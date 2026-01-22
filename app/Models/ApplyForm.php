<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplyForm extends Model
{
    use HasFactory;

    protected $table = 'apply_form'; // ✅ singular table name

    protected $fillable = [
        'name',
        'email',
        'mobile',
        'product_type',
        'city',
        'state',
        'ip',
        'user_agent',
    ];
}
