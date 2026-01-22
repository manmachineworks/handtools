<?php
// VerificationCode.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerificationCode extends Model
{
    protected $table = 'verification_codes'; // Should be a string, not an array
    protected $fillable = [
        'phone',
        'verification_code',
        'verification_code_expires_at',
    ];
}
