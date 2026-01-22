<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Meta;
use App\Models\Category;

class PageController extends Controller
{

   public function about()
    {
     
        
        $meta = Meta::where('page_slug', 'about')->first();

    return view('about', compact('meta'));

    }
    
    
    
      public function faq()
    {
     
        
        $meta = Meta::where('page_slug', 'faq')->first();

        return view('faq', compact('meta'));

    }

    
     public function polishingprogram()
    {
      
        $meta = Meta::where('page_slug', 'polishing-program')->first();

    return view('polishing-program', compact('meta'));
        /* return view('pages.VisionMission'); */
    }
/*
    public function Md_Message()
    {
        return view('pages.Md_Message');
    }
    public function Team()
    {
        return view('pages.Team');
    }

    public function CSR()
    {
        return view('pages.CSR');
    }




    public function News()
    {
        return view('pages.News');
    }
    public function Video()
    {
        return view('pages.Video');
    }




    public function terms()
    {
        return view('terms');
    }
    public function ppf()
    {
        return view('ppf');
    }
*/

    public function contact()
    {
     
         $meta = Meta::where('page_slug', 'contact')->first();

    return view('contact', compact('meta'));
    }

    public function categories()
    {
        $categories = Category::select('id', 'name', 'slug', 'cat_image', 'cat_text')
            ->orderBy('name')
            ->get();

        $meta = Meta::where('page_slug', 'categories')->first();

        return view('categories.index', compact('categories', 'meta'));
    }
    
    /*
    public function productDetails()
    {
        return view('product_details');
    }
    
     public function products()
    {
        return view('products');
    }

*/

    public function privacy()
    {
         $meta = Meta::where('page_slug', 'privacy')->first();

        return view('privacy', compact('meta'));
    }
    
     public function terms()
    {
        $meta = Meta::where('page_slug', 'terms')->first();

        return view('terms', compact('meta'));
    }
        
}
