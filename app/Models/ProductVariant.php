<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'variant', 'mrp', 'sale_price', 'sku_code',
        'varaint_name',
        'stock', 'length', 'breadth', 'height', 'weight'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variantImages()
    {
        return $this->hasMany(VariantImage::class);
    }
}
