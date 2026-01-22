<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BecomeDealer extends Model
{
    use HasFactory;

    protected $table = 'become_dealers';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'state',
        'address',
        'message',
        'ip',
        'user_agent',
    ];
}
