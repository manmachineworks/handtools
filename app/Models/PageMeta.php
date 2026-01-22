<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageMeta extends Model
{
    protected $fillable = ['page_slug', 'meta_title', 'meta_keywords', 'meta_description'];
}
