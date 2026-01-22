<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'    => ['required','string','min:2','max:120'],
            'message' => ['required','string','min:5','max:2000'],
            // honeypot fields (optional): 'website' => ['prohibited']
            // recaptcha token (optional): 'g-recaptcha-response' => ['required','captcha']
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Please tell us your name.',
            'message.required' => 'Write something before submitting.',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
} // 👈 this was missing
