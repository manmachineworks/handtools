<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $table = 'products';

    protected $fillable = [
        'page_id',
        'product_name',
        'product_title',
        'product_meta_title',
        'product_keyword',
        'product_meta_description',
        'product_canonical',
        'product_alternate',
        'product_image',
        'product_pdf',
        'video_url',
        'buy_now_url',
        'about_product',
        'product_description',
        'category_id',
        'subcategory_id',
    ];
}