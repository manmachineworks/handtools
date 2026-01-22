<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomePage extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'home_pages';

    // Specify the fields that are mass assignable
    protected $fillable = [
        'title_1',
        'content_1',
        'title_2',
        'content_2'
    ];
}
