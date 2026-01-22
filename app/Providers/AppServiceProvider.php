<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Brand;
use App\Models\Category;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
     public function register()
     {
         
     }
     
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('layout.header', function ($view) {
            $navBrands = Brand::active()
                ->select('name', 'slug')
                ->orderBy('name')
                ->get();

            $navCategories = Category::select('name', 'slug')
                ->orderBy('name')
                ->get();

            $view->with([
                'brands' => $navBrands,
                'categories' => $navCategories,
                'navBrands' => $navBrands,
                'navCategories' => $navCategories,
            ]);
        });
    }
}
