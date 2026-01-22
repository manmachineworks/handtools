<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Meta extends Model
{
    use HasFactory;

    protected $table = "home_meta";
    protected $fillable = [
        'page_slug',
        'title',
        'keyword',
        'description',
       
    ];
   
}
