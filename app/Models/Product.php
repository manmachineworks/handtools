<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Brand;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'code',
        'mrp',
        'sale_price',
        'sku_code',
        'category_id',
        'subcategory_id',
        'brand_id',
        'description',
        'meta_key',
        'meta_desc',
        'title',
        'url',
        'stock',
        'today_hot_deals',
        'best_seller',
        'featured_products',
        'length',
        'breadth',
        'height',
        'weight',
    ];

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    // This method might not be necessary unless you need to filter images by variant
    public function variantImages($variant)
    {
        return $this->images()->where('variant', $variant);
    }
}
