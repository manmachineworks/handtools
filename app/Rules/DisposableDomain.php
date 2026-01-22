<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class DisposableDomain implements Rule
{
    protected array $fragments = [
        'tempmail','mailinator','guerrillamail','10minutemail','yopmail'
    ];

    public function passes($attribute, $value): bool
    {
        $domain = Str::lower(Str::after($value, '@'));
        foreach ($this->fragments as $frag) {
            if (Str::contains($domain, $frag)) {
                return false;
            }
        }
        return true;
    }

    public function message(): string
    {
        return 'Please use a valid email provider.';
    }
}
