<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;

class Blog extends Model
{
    use HasFactory;

    // The table associated with the model.
    protected $table = 'blog';

    // The attributes that are mass assignable.
    protected $fillable = [
        'blog_title',
        'url',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'blog_meta_canonical',
        'blog_meta_alternate',
        'blog_image',
        'blog_image_2',
        'blog_detail',
        'date',
    ];
    
public function commt() {
    return $this->hasMany(Commt::class);
}

}
