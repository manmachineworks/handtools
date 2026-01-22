<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    // Define the table name if different from 'pages'
    protected $table = 'page';

    // Define the fillable fields
    protected $fillable = [
        'title',
        'content',
        'created_at',
        'update_at'
    ];

    // Disable timestamps if your table doesn't use them
    public $timestamps = false;
}
