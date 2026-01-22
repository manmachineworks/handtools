<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Subcategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'slug', 
        'category_id',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'subcat_image',
        'subcat_text',



];  // Add slug to the fillable fields

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Automatically generate a slug when saving the subcategory
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
