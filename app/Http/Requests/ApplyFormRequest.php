<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ApplyFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'email'  => strtolower(trim((string) $this->email)),
            'mobile' => preg_replace('/[^\d+]/', '', (string) $this->mobile),
            'name'   => trim((string) $this->name),
            'city'   => trim((string) $this->city),
        ]);
    }

    public function rules(): array
    {
        $states   = array_keys(config('states.india', []));
        $products = array_keys(config('products.types', []));

        return [
            'name'         => ['required', 'string', 'min:2', 'max:100'],
            'email'        => ['required', 'email', 'max:150'],
            'mobile'       => ['required', 'regex:/^\+?\d{10,15}$/'],
            'city'         => ['required', 'string', 'max:100'],
            'state'        => ['required', Rule::in($states)],
            'product_type' => ['required', Rule::in($products)],
            'website'      => ['nullable', 'size:0'], // honeypot
            'form_start'   => ['nullable', 'integer'], // for timing validation if needed
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'         => 'Please enter your name.',
            'email.required'        => 'Please enter a valid email address.',
            'mobile.required'       => 'Please provide your mobile number.',
            'mobile.regex'          => 'Mobile number format is invalid.',
            'city.required'         => 'City is required.',
            'state.in'              => 'Please select a valid state.',
            'product_type.in'       => 'Please select a valid product.',
        ];
    }
}
