<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemoForm extends Model
{
    use HasFactory;

    protected $table = 'demo_form';

    protected $fillable = [
        'name',
        'email',
        'mobile',
        'product_type',
        'city',
        'state',
    ];
}
