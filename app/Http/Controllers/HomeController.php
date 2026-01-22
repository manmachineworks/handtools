<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Blog;
use Illuminate\Http\Request;
use App\Models\HomePage;
use App\Models\Meta;
use App\Models\Commt;
use App\Models\Page;
use App\Models\Brand;
use App\Models\Category;

use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function index()
    {
        
        $todayhotDeals = Product::where('today_hot_deals', 1)
            ->with(['images' => function ($query) {
                $query->select('product_id', 'image_url');
            }])
            ->get();
            
        $productsn = Product::all();


        $bestSellers = Product::where('best_seller', 1)
            ->with(['images' => function ($query) {
                $query->select('product_id', 'image_url');
            }])
            ->get();

        $featuredProducts = Product::where('featured_products', 1)
            ->with(['images' => function ($query) {
                $query->select('product_id', 'image_url');
            }])
            ->get();

        $newArrivals = Product::with(['images' => function ($query) {
            $query->select('product_id', 'image_url');
        }])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->distinct('id') // Ensure distinct products are fetched
            ->get();
        // dd($newArrivals);

        $randomProducts = Product::inRandomOrder()
        ->with(['images' => function ($query) {
            $query->select('product_id', 'image_url');
        }])
        ->take(5)
        ->get();

        $homepage = HomePage::where('id', 1)->first();

        // dd($franchise);
        // Pass the data to the view
        $latestBlogs = Blog::orderBy('created_at', 'desc')
        ->take(10)
        ->get();

        $brands = Brand::active()
            ->whereNotNull('image')
            ->orderBy('name')
            ->get();

        $categories = Category::select('name', 'slug', 'cat_image', 'cat_text')
            ->whereNotNull('cat_image')
            ->orderBy('name')
            ->get();
        
        $meta = Meta::where('page_slug', 'home')->first();
           $page = Page::where('id', 1)->first();

        return view('home', compact('meta', 'todayhotDeals', 'productsn', 'bestSellers', 'featuredProducts','newArrivals', 'randomProducts', 'latestBlogs', 'homepage', 'page', 'brands', 'categories'));
    }
    
    public function become_dealer()
    {
        

        return view('become_dealer');
    }

    public function blogs()
    {
        $blogs = Blog::orderBy('created_at', 'desc')
        ->paginate(12);
        $recents = Blog::orderBy('created_at', 'desc')->take(4)->get();
        
         $recentsone = Blog::orderBy('created_at', 'desc')->take(1)->get();
         
            $meta = Meta::where('page_slug', 'blog')->first();

        return view('blog.index', compact('meta', 'blogs', 'recents', 'recentsone'));
    }

    public function blog_show($url)
    {
         $blog = Blog::where('url', $url)->firstOrFail();
       
        $recents = Blog::orderBy('created_at', 'desc')->take(4)->get();
        //  $comments = Commt::where('blog_id', $blog->id)->orderBy('created_at', 'desc')->get();
          $comments = $blog->commt()->approved()->latest()->paginate(10);
        $meta = (object) [
        'title' => $blog->meta_title,
        'keyword' => $blog->meta_keyword,
        'description' => $blog->meta_description,
        'canonical' => $blog->meta_canonical,
        'alternate' => $blog->meta_alternate,
    ];

        
        return view('blog.show', compact('blog', 'recents', 'meta',  'comments'));
        
    }

    public function carrer(){
        return view('carrer');
    }

    public function indpolishing(){
        return view('industrial-polishing');
    }

    public function pro_car_care(){
        return view('professional-car-care');
    }

    public function apply(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'location' => 'required|string',
            'experience' => 'required|integer|min:0',
        ]);

        // Send the email
        Mail::send('emails.job-application', $validated, function ($message) {
            $message->to('hr.manager@manmachine.in')
            ->subject('New Job Application');
        });

        return redirect()->back()->with('success', 'Your application has been submitted successfully!');
    }

}
