<?php

namespace App\Http\Requests;

use App\Rules\DisposableDomain;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class DealerSubmissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    // Normalize inputs before rules run
    protected function prepareForValidation(): void
    {
        $phone = preg_replace('/[^\d+]/', '', (string) $this->input('phone', ''));
        $this->merge([
            'name'       => trim((string) $this->input('name')),
            'email'      => trim(Str::lower((string) $this->input('email'))),
            'address'    => trim((string) $this->input('address')),
            'message'    => trim((string) $this->input('message')),
            'phone'      => $phone,
            'form_start' => $this->input('form_start'), // used for time trap
        ]);
    }

    public function rules(): array
    {
        $rules = [
            // Honeypot: field must exist and be empty
            'website'    => ['present', 'prohibited'],

            // Time trap: existence + integer; elapsed verified in withValidator()
            'form_start' => ['required', 'integer'],

            'name'    => ['required','string','min:2','max:100','regex:/^[\pL\s\'.-]+$/u'],
            'email'   => ['required','email:rfc,dns','max:255', new DisposableDomain],
            'phone'   => ['required','string','min:7','max:20','regex:/^\+?\d{7,20}$/'],
            'address' => ['required','string','min:5','max:255'],
            'state'   => ['required','string', Rule::in(config('states.india', []))],
            'message' => ['required','string','min:2','max:2000'],
            'consent' => ['accepted'],
        ];

        if (config('services.recaptcha_v3.enabled')) {
            $rules['captcha_token'] = ['required','string','min:10'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'website.prohibited' => 'Spam detected.',
            'form_start.required' => 'Invalid submission.',
            'form_start.integer'  => 'Invalid submission.',
            'state.in'            => 'Please select a valid state.',
            'consent.accepted'    => 'You must agree to the Privacy Policy.',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($v) {
            // Time trap: ensure user spent >= 4s and <= 2h on the form
            $start = (int) $this->input('form_start');
            $now   = time();
            if ($start <= 0 || ($now - $start) < 4 || ($now - $start) > 7200) {
                $v->errors()->add('form_start', 'Invalid or suspicious submission timing.');
            }

            // Lightweight message spam checks
            $msg = (string) $this->input('message', '');
            if (preg_match('/https?:\/\/|www\./i', $msg)) {
                $v->errors()->add('message', 'Please remove links from the message.');
            }
            if (preg_match('/(.)\1{6,}/u', $msg)) { // 7+ repeated same char
                $v->errors()->add('message', 'Message appears automated. Please rephrase.');
            }

            // Optional: per-IP soft rate limit (10 per hour)
            $ip  = (string) $this->ip();
            $key = 'dealer_ip_count:' . $ip;
            $count = (int) Cache::get($key, 0);
            if ($count >= 10) {
                $v->errors()->add('form', 'Too many submissions from your IP. Try later.');
            } else {
                // only increment if no errors so far (avoid burning attempts on invalid posts)
                // We'll increment in passedValidation() to ensure only valid entries count.
            }

            // reCAPTCHA v3 verification (if enabled)
            if (config('services.recaptcha_v3.enabled')) {
                $token = (string) $this->input('captcha_token');
                $verify = $this->verifyRecaptchaV3($token, $ip);
                if (!$verify['ok']) {
                    $v->errors()->add('captcha_token', $verify['message'] ?? 'Captcha verification failed.');
                }
            }
        });
    }

    protected function passedValidation(): void
    {
        // Now increment the per-IP counter (valid submissions only)
        $ip  = (string) $this->ip();
        $key = 'dealer_ip_count:' . $ip;
        Cache::add($key, 0, now()->addHour());
        Cache::increment($key);
    }

    /**
     * Verify reCAPTCHA v3 using native PHP (no composer dependency).
     */
    private function verifyRecaptchaV3(string $token, ?string $ip = null): array
    {
        $secret   = config('services.recaptcha_v3.secret');
        $minScore = (float) config('services.recaptcha_v3.min_score', 0.3);

        if (!$secret || !$token) {
            return ['ok' => false, 'message' => 'Captcha token missing.'];
        }

        $postFields = http_build_query([
            'secret'   => $secret,
            'response' => $token,
            'remoteip' => $ip,
        ]);

        $endpoint = 'https://www.google.com/recaptcha/api/siteverify';
        $response = null;

        if (function_exists('curl_init')) {
            $ch = curl_init($endpoint);
            curl_setopt_array($ch, [
                CURLOPT_POST           => true,
                CURLOPT_POSTFIELDS     => $postFields,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT        => 8,
                CURLOPT_SSL_VERIFYPEER => true,
                CURLOPT_HTTPHEADER     => ['Content-Type: application/x-www-form-urlencoded'],
            ]);
            $response = curl_exec($ch);
            $errno = curl_errno($ch);
            curl_close($ch);

            if ($errno) {
                return ['ok' => false, 'message' => 'Captcha server unreachable (cURL).'];
            }
        } else {
            $context = stream_context_create([
                'http' => [
                    'method'  => 'POST',
                    'header'  => "Content-Type: application/x-www-form-urlencoded\r\n".
                                 "Content-Length: ".strlen($postFields)."\r\n",
                    'content' => $postFields,
                    'timeout' => 8,
                ],
                'ssl' => [
                    'verify_peer'      => true,
                    'verify_peer_name' => true,
                ],
            ]);
            $response = @file_get_contents($endpoint, false, $context);
            if ($response === false) {
                return ['ok' => false, 'message' => 'Captcha server unreachable (HTTP).'];
            }
        }

        $json = json_decode($response, true) ?: [];

        $success = ($json['success'] ?? false) === true;
        $action  = $json['action']  ?? null;
        $score   = (float) ($json['score'] ?? 0.0);

        $ok = $success && $action === 'dealer_submit' && $score >= $minScore;

        if (!$ok) {
            $codes = isset($json['error-codes']) ? implode(',', (array) $json['error-codes']) : 'none';
            \Log::warning('reCAPTCHA v3 failed', compact('action','score','codes'));
        }

        return [
            'ok'      => $ok,
            'message' => $ok ? null : 'Captcha verification failed.',
            'raw'     => $json,
        ];
    }

    public function attributes(): array
    {
        return [
            'form_start' => 'submission time',
        ];
    }
}
