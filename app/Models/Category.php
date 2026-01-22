<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'cat_image',
        'cat_text',
    ];
    // Add slug to the fillable fields

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    // Automatically generate a slug when saving the category
    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if (!$model->slug) {
                $model->slug = Str::slug($model->name);  // Generate slug from name
            }
        });
    }
}
