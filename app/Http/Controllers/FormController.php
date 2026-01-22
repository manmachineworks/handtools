<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DemoForm;
use App\Models\ApplyForm;
use App\Models\Contact;
use App\Models\Product;
use App\Models\BecomeDealer;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use App\Http\Requests\DealerSubmissionRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ApplyFormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;   // ✅ correct import

use Illuminate\Support\Facades\Mail;
use App\Mail\DealerFormMail;
use App\Mail\QuoteFormMail;
use App\Mail\ContactFormMail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;


class FormController extends Controller
{
    private int $maxAttempts = 5;
    private int $decaySeconds = 60;

    private function throttleOrFail(string $key, Request $request)
    {
        $keyed = $key . '|' . $request->ip();
        if (RateLimiter::tooManyAttempts($keyed, $this->maxAttempts)) {
            $seconds = RateLimiter::availableIn($keyed);
            return $this->reject($request, 'Too many attempts. Try again in ' . $seconds . ' seconds.');
        }
        RateLimiter::hit($keyed, $this->decaySeconds);
        return null;
    }

    // Store data for Demo Form
    public function storeDemoForm(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'mobile' => 'required|string|max:15',
            'product_type' => 'required|string|max:50',
            'city' => 'required|string|max:50',
            'state' => 'required|string|max:50',
            'g-recaptcha-response' => 'required',
        ]);
           
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        if (!$response->json('success')) {
            return back()->withErrors([
                'captcha' => 'reCAPTCHA verification failed. Please try again.'
            ])->withInput();
        }

        DemoForm::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'product_type' => $request->product_type,
            'city' => $request->city,
            'state' => $request->state,
        ]);

        return redirect()->back()->with('success', 'Form submitted successfully');
    }
    
     public function apply_form()
{
    $productsn = Product::all();
    return view('partials.apply-form', compact('productsn'));
}


public function storeApplyForm(Request $request)
    {
        if ($response = $this->throttleOrFail('apply_form', $request)) {
            return $response;
        }
        // simple anti-bot checks
        if ($request->filled('website')) {
            return $this->reject($request, 'Bot detected.');
        }
        if ((int) $request->input('form_start') > 0) {
            $elapsed = time() - (int) $request->input('form_start');
            if ($elapsed < 2) {
                return $this->reject($request, 'Form submitted too quickly.');
            }
        }

        // Normalize
        $request->merge([
            'name'   => trim((string) $request->input('name')),
            'email'  => trim(Str::lower((string) $request->input('email'))),
            'mobile' => preg_replace('/\D+/', '', (string) $request->input('mobile', '')),
            'city'   => trim((string) $request->input('city')),
            'state'  => trim((string) $request->input('state')),
        ]);

        // Validate
        $validated = $request->validate(
            [
                'name'         => ['required','string','max:100'],
                'email'        => ['required','email:rfc,dns','max:100'],
                'mobile'       => ['required','digits:10'],
                'product_type' => ['required','string','max:100'],
                'city'         => ['required','string','max:50'],
                'state'        => ['required','string','max:50'],
                'captcha_token'=> ['nullable','string'],
            ],
            [
                'email.email'   => 'Please enter a valid email address.',
                'mobile.digits' => 'Phone number must be exactly 10 digits.',
            ]
        );

        // Persist
        $record = ApplyForm::create([
            'name'         => $validated['name'],
            'email'        => $validated['email'],
            'mobile'       => $validated['mobile'],
            'product_type' => $validated['product_type'],
            'city'         => $validated['city'],
            'state'        => $validated['state'],
            'ip'           => $request->ip(),
            'user_agent'   => substr((string) $request->userAgent(), 0, 255),
        ]);

        // Build the payload the email view expects
        $formData = [
            'name'         => $record->name,
            'email'        => $record->email,
            'mobile'       => $record->mobile,
            'product_type' => $record->product_type,
            'city'         => $record->city,
            'state'        => $record->state,
            'ip'           => $record->ip,
            'user_agent'   => $record->user_agent,
            'submitted_at' => now()->format('Y-m-d H:i:s'),
        ];

        try {
            Mail::to('info@menzernaindia.com')->send(new QuoteFormMail($formData));
            Mail::to('sales@menzernaindia.com')->send(new QuoteFormMail($formData));
        } catch (\Throwable $e) {
            Log::error('Apply mail queue failed', ['error' => $e->getMessage()]);
        }

        Log::info('Apply form submitted', ['id' => $record->id, 'ip' => $record->ip]);

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Quote form submitted successfully'], 200);
        }

        return back()->with('success', 'Quote form submitted successfully');
    }

    protected function reject(Request $request, string $reason)
    {
        Log::warning('Apply form rejected', ['reason' => $reason, 'ip' => $request->ip()]);
        if ($request->expectsJson()) {
            return response()->json(['message' => $reason], 429);
        }
        return back()->withErrors(['form' => $reason])->withInput();
    }

public function submit_dealer(Request $request)
{
    if ($response = $this->throttleOrFail('dealer_form', $request)) {
        return $response;
    }
    // Bot traps
    if ($request->filled('website')) {
        return $this->reject($request, 'Bot detected.');
    }
    if ((int) $request->input('form_start') > 0) {
        $elapsed = time() - (int) $request->input('form_start');
        if ($elapsed < 2) {
            return $this->reject($request, 'Form submitted too quickly.');
        }
    }

    // Normalize
    $request->merge([
        'name'    => trim((string) $request->input('name')),
        'email'   => trim(Str::lower((string) $request->input('email'))),
        'phone'   => preg_replace('/\D+/', '', (string) $request->input('phone', '')),
        'address' => trim((string) $request->input('address')),
        'state'   => trim((string) $request->input('state')),
        'message' => trim((string) $request->input('message')),
    ]);

    // Validate
    $validated = $request->validate([
        'name'          => ['required','string','max:100'],
        'email'         => ['required','email:rfc,dns','max:100'],
        'phone'         => ['required','digits:10'],
        'address'       => ['required','string','max:255'],
        'state'         => ['required','string','max:50'],
        'message'       => ['required','string','max:2000'],
        'consent'       => ['accepted'],
        'captcha_token' => ['nullable','string'],
    ],[
        'email.email'        => 'Please enter a valid email address.',
        'phone.digits'       => 'Phone number must be exactly 10 digits.',
        'consent.accepted'   => 'You must agree to the Privacy Policy.',
    ]);

    // Persist
    $dealer = BecomeDealer::create([
        'name'       => $validated['name'],
        'email'      => $validated['email'],
        'phone'      => $validated['phone'],
        'state'      => $validated['state'],
        'address'    => $validated['address'],
        'message'    => $validated['message'],
        'ip'         => $request->ip(),
        'user_agent' => substr((string) $request->userAgent(), 0, 255),
    ]);

    // Send mail
    try {
        Mail::to(['info@menzernaindia.com','sales@menzernaindia.com'])
            ->send(new DealerFormMail($dealer));

        Log::info('Dealer mail sent', ['dealer_id' => $dealer->id, 'emails' => ['info@menzernaindia.com','sales@menzernaindia.com']]);
    } catch (TransportExceptionInterface $e) {
        Log::error('Dealer mail transport failure', [
            'dealer_id' => $dealer->id,
            'error'     => $e->getMessage(),
        ]);
        // Optional: surface a friendlier message
        return back()->with('success', 'Thanks! We received your request. (Email delivery pending)');
    } catch (\Throwable $e) {
        Log::error('Dealer mail send failed', [
            'dealer_id' => $dealer->id,
            'error'     => $e->getMessage(),
        ]);
        return back()->with('success', 'Thanks! We received your request. (Email delivery pending)');
    }

    Log::info('Dealer form submitted', ['id' => $dealer->id, 'ip' => $dealer->ip]);
    if ($request->expectsJson()) {
        return response()->json(['message' => 'Your message has been sent successfully!']);
    }
    return back()->with('success', 'Your message has been sent successfully!');
}



    public function submit(Request $request)
    {
        if ($response = $this->throttleOrFail('contact_form', $request)) {
            return $response;
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
            'g-recaptcha-response' => 'required',
        ]);
        
          $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        if (!$response->json('success')) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'reCAPTCHA verification failed. Please try again.'], 422);
            }
            return back()->withErrors([
                'captcha' => 'reCAPTCHA verification failed. Please try again.'
            ])->withInput();
        }

        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);
        
        // Send the email
    Mail::to('info@menzernaindia.com')->send(new ContactFormMail($validated));
     Mail::to('sales@menzernaindia.com')->send(new ContactFormMail($validated));
         if ($request->expectsJson()) {
             return response()->json(['success' => true, 'message' => 'Message sent successfully!']);
         }
         return back()->with('success', 'Message sent successfully!');



    }
}
