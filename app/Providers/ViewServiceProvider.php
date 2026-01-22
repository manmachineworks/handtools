<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\ProductVariant;
use App\Models\Review;
use App\Models\ProductImage;
use App\Models\Blog;
use App\Models\Meta;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('partials.mini_cart', function ($view) {
            $cartController = new CartController();
            $cartData = $cartController->headerCart();
            $view->with($cartData);
        });

        View::composer('partials.disc_cart', function ($view) {
            $cartController = new CartController();
            $cartData = $cartController->headerCart();
            $view->with($cartData);
        });

        View::composer('partials.wishlist_count', function ($view) {
            $wishlistController = new WishlistController();
            $wishlistData = $wishlistController->headerWishlist();
            $view->with($wishlistData);
        });

        View::composer('*', function ($view) {
            $productController = new ProductController();
            $categories = $productController->fetchCategoriesWithSubcategories();
            $view->with('categories', $categories);
        });

        // Detect the route and set meta data accordingly
        View::composer('*', function ($view) {
            $meta_title = 'Gurunanak Hand Tools | Industrial-Grade Tools for Workshops & Industries';
            $meta_keywords = "Gurunanak Hand Tools, industrial tools India, spanners, pliers, wrenches, sockets, cutters, hammers, tool trolleys, non-sparking tools, insulated tools, stainless steel tools, welding machines, workshops India";
            $meta_description = "Gurunanak Hand Tools delivers industrial-grade tools for workshops and industries across India. 25+ years of experience, strength and reliability, precision performance, and a full range from spanners to welding machines.";
            $averageRating = "4";
            $saleprice = "default";
            $name = "default";
            $imageUrl = asset('assets/img/banner/Advanced-Polishing-img.avif');
            $segment1 = Request::segment(1);
        
            // If it's the homepage (no URL segment), fetch meta details from home_meta table where id = 1
            if (!$segment1) {
                $homeMeta = Meta::find(1);
                if ($homeMeta) {
                    $meta_title = $homeMeta->title;
                    $meta_keywords = $homeMeta->keyword;
                    $meta_description = $homeMeta->description;
                }
            } 
            // For product pages
            elseif (Request::is('product/*')) {
                $url = Request::segment(2); // Fetch product URL from the route
                $product = Product::where('url', $url)->first();
                if ($product) {
                    $meta_title = $product->title;
                    $meta_keywords = $product->meta_key;
                    $meta_description = $product->meta_desc;
                    $reviews = Review::where('product_id', $product->id)->get();
                    $averageRating = $reviews->avg('rating') ?? 4;
                    $saleprice = $product->sale_price;
                    $name = $product->product_name;
                    $image = ProductImage::where('product_id', $product->id)->first();

                    if ($image && $image->image_url) {
                        $imageUrl = asset($image->image_url);
                    }
                }
            } 
            // For category pages
            elseif (Request::is('category/*')) {
                $categorySlug = Request::segment(2);
                $category = Category::where('slug', $categorySlug)->first();
                if ($category) {
                    $meta_title = $category->meta_title;
                    $meta_keywords = $category->meta_keyword;
                    $meta_description = $category->meta_description;
                }
            } 
            // For blog pages
            elseif (Request::is('blog/*')) {
                $blogSlug = Request::segment(2);
                $blog = Blog::where('url', $blogSlug)->first();
                if ($blog) {
                    $meta_title = $blog->meta_title;
                    $meta_keywords = $blog->meta_keyword;
                    $meta_description = $blog->meta_description;
                }
            } 
            // For subcategory pages
            elseif (Request::is('subcategory/*')) {
                $subcategorySlug = Request::segment(2);
                $subcategory = Subcategory::where('slug', $subcategorySlug)->first();
                if ($subcategory) {
                    $meta_title = $subcategory->meta_title;
                    $meta_keywords = $subcategory->meta_keyword;
                    $meta_description = $subcategory->meta_description;
                }
            }
            // For the meta manager / other slugs, try to load a page meta entry
            elseif (Request::segment(1)) {
                $slugMeta = Meta::where('page_slug', Request::segment(1))->first();
                if ($slugMeta) {
                    $meta_title = $slugMeta->title ?? $meta_title;
                    $meta_keywords = $slugMeta->keyword ?? $meta_keywords;
                    $meta_description = $slugMeta->description ?? $meta_description;
                }
            }

            $baseMeta = [
                'title' => $meta_title,
                'keyword' => $meta_keywords,
                'description' => $meta_description,
                'canonical' => Request::fullUrl(),
                'image' => $imageUrl,
                'type' => 'website',
                'site_name' => 'Gurunanak Hand Tools',
            ];

            $existingMeta = $view->getData()['meta'] ?? [];
            if ($existingMeta && !is_array($existingMeta)) {
                $existingMeta = (array) $existingMeta;
            }

            $metaForView = (object) array_merge($baseMeta, (array) $existingMeta);

            // Share meta data (including normalized object) with all views
            $view->with(compact('meta_title', 'meta_keywords', 'meta_description', 'averageRating', 'name', 'saleprice', 'imageUrl'));
            $view->with('meta', $metaForView);
        });
        
    
    }
}
