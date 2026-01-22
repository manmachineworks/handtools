<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\Subcategory;
use Illuminate\Support\Str;
use App\Models\ProductVariant;
use App\Models\Review;

class ProductController extends Controller
{

    public function show(Request $request, $categorySlug, $subcategorySlug, $url)
    {
        
         $product = Product::where('url', $url)
        ->with(['images', 'subcategory.category'])
        ->firstOrFail();
        // Check if URL matches a category
        $category = Category::where('slug', $url)->first();
        if ($category) {
            $products = Product::where('category_id', $category->id)
                ->with('images', 'subcategory')
                ->paginate(12);

        $categoriesTree = Category::select('id', 'name', 'slug')
            ->with(['subcategories:id,name,slug,category_id'])
            ->orderBy('name')
            ->get();

        $activeCategorySlug = $category->slug;
        $activeSubcategorySlug = null;

        $breadcrumb = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => $category->name, 'url' => '']
        ];
            
             $meta = (object) [
            'title' => $category->meta_title,
            'keyword' => $category->meta_keyword,
            'description' => $category->meta_description,
        ];

            if ($request->ajax()) {
                $html = view('products.partials.product-grid', [
                    'products' => $products,
                    'category' => $category,
                ])->render();

                $pagination = $products->hasPages() ? $products->links()->toHtml() : '';

                return response()->json([
                    'html' => $html,
                    'pagination' => $pagination,
                    'hasProducts' => $products->count() > 0,
                ]);
            }

            return view('products.index', compact('products', 'category', 'breadcrumb', 'meta', 'categoriesTree', 'activeCategorySlug', 'activeSubcategorySlug'));
        }

        // Check if URL matches a subcategory
        $subcategory = Subcategory::where('slug', $url)->first();
        if ($subcategory) {
            $products = Product::where('subcategory_id', $subcategory->id)
                ->select('id', 'product_name', 'subcategory_id', 'category_id', 'url')
                ->with([
                    'images:id,product_id,image_url',
                    'subcategory:id,name,slug,category_id',
                ])
                ->paginate(12);

           $breadcrumb = [
    ['name' => 'Home', 'url' => route('home')],
    ['name' => $subcategory->category->name, 'url' => route('category.show', $subcategory->category->slug)], // use a separate route for category
    ['name' => $subcategory->name, 'url' => '']
];

            $categoriesTree = Category::select('id', 'name', 'slug')
                ->with(['subcategories:id,name,slug,category_id'])
                ->orderBy('name')
                ->get();

            $activeCategorySlug = $subcategory->category->slug;
            $activeSubcategorySlug = $subcategory->slug;

            $meta = (object) [
            'title' => $subcategory->meta_title,
            'keyword' => $subcategory->meta_keyword,
            'description' => $subcategory->meta_description,
        ];

            if ($request->ajax()) {
                $html = view('products.partials.product-grid', [
                    'products' => $products,
                    'category' => $subcategory->category,
                ])->render();

                $pagination = $products->hasPages() ? $products->links()->toHtml() : '';

                return response()->json([
                    'html' => $html,
                    'pagination' => $pagination,
                    'hasProducts' => $products->count() > 0,
                ]);
            }

            return view('products.subcat', compact('products', 'subcategory', 'breadcrumb', 'meta', 'categoriesTree', 'activeCategorySlug', 'activeSubcategorySlug'))
                ->with('category', $subcategory->category);
        }

        // Assume the URL is for a product
        $product = Product::where('url', $url)->firstOrFail();
        $productImages = ProductImage::where('product_id', $product->id)->get();
        $productVariants = ProductVariant::where('product_id', $product->id)->get();
        $reviews = Review::where('product_id', $product->id)->get();
        $averageRating = $reviews->avg('rating');

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(5)
            ->get();

       $breadcrumb = [
    ['name' => 'Home', 'url' => route('home')],
    ['name' => $product->category->name, 'url' => route('category.show', $product->category->slug)],
    ['name' => $product->subcategory->name ?? '', 'url' => $product->subcategory ? route('subcategory.show', [$product->category->slug, $product->subcategory->slug]) : ''],
    ['name' => $product->product_name, 'url' => '']
];

        
        $meta = (object) [
            'title' => $product->title,
            'keyword' => $product->meta_key,
            'description' => $product->meta_desc,
        ];


        return view('product_details', compact('product', 'productImages', 'productVariants', 'relatedProducts', 'reviews', 'averageRating', 'breadcrumb', 'meta'));

    }
    
    
public function showProduct($categorySlug, $subcategorySlug, $productSlug)
{
    // Verify category exists
    $category = Category::where('slug', $categorySlug)->firstOrFail();

    // Verify subcategory belongs to that category
    $subcategory = Subcategory::where('slug', $subcategorySlug)
        ->where('category_id', $category->id)
        ->firstOrFail();

    // Find product in that subcategory
    $product = Product::where('url', $productSlug)
        ->where('subcategory_id', $subcategory->id)
        ->with(['images', 'variants'])
        ->firstOrFail();

    $productImages = ProductImage::where('product_id', $product->id)->get();
    $productVariants = ProductVariant::where('product_id', $product->id)->get();
    $reviews = Review::where('product_id', $product->id)->get();
    $averageRating = $reviews->avg('rating');

    $relatedProducts = Product::where('subcategory_id', $subcategory->id)
        ->where('id', '!=', $product->id)
        ->take(5)
        ->get();

    $breadcrumb = [
        ['name' => 'Home', 'url' => route('home')],
        ['name' => $category->name, 'url' => route('category.show', $category->slug)],
        ['name' => $subcategory->name, 'url' => route('subcategory.show', [$category->slug, $subcategory->slug])],
        ['name' => $product->product_name, 'url' => '']
    ];

    $meta = (object) [
        'title' => $product->title,
        'keyword' => $product->meta_key,
        'description' => $product->meta_desc,
    ];

    return view('product_details', compact(
        'product',
        'productImages',
        'productVariants',
        'relatedProducts',
        'reviews',
        'averageRating',
        'breadcrumb',
        'meta'
    ));
}

    
    public function showSubcategory(Request $request, $categorySlug, $subcategorySlug)
{
    $category = Category::select('id', 'name', 'slug')
        ->where('slug', $categorySlug)
        ->with(['subcategories:id,name,slug,category_id'])
        ->firstOrFail();

    $subcategory = Subcategory::select('id', 'name', 'slug', 'category_id', 'subcat_image', 'subcat_text', 'meta_title', 'meta_keyword', 'meta_description')
        ->where('slug', $subcategorySlug)
        ->where('category_id', $category->id)
        ->firstOrFail();

    $products = Product::where('subcategory_id', $subcategory->id)
        ->select('id', 'product_name', 'subcategory_id', 'category_id', 'url')
        ->with([
            'images:id,product_id,image_url',
            'subcategory:id,name,slug,category_id',
        ])
        ->paginate(12);

    $categoriesTree = Category::select('id', 'name', 'slug')
        ->with(['subcategories:id,name,slug,category_id'])
        ->orderBy('name')
        ->get();

    $activeCategorySlug = $category->slug;
    $activeSubcategorySlug = $subcategory->slug;

    $breadcrumb = [
        ['name' => 'Home', 'url' => route('home')],
        ['name' => $category->name, 'url' => route('category.show', $category->slug)],
        ['name' => $subcategory->name, 'url' => '']
    ];

    $meta = (object) [
        'title' => $subcategory->meta_title,
        'keyword' => $subcategory->meta_keyword,
        'description' => $subcategory->meta_description,
    ];

    if ($request->ajax()) {
        $html = view('products.partials.product-grid', [
            'products' => $products,
            'category' => $category,
        ])->render();

        $pagination = $products->hasPages() ? $products->links()->toHtml() : '';

        return response()->json([
            'html' => $html,
            'pagination' => $pagination,
            'hasProducts' => $products->count() > 0,
        ]);
    }

    return view('products.subcat', compact(
        'products',
        'subcategory',
        'breadcrumb',
        'meta',
        'categoriesTree',
        'activeCategorySlug',
        'activeSubcategorySlug',
        'category'
    ));
}


public function showCategorySubcategories()
{
  
        return view('car_care');

}

public function showCategory(Request $request, $categorySlug)
{
    $category = Category::where('slug', $categorySlug)->firstOrFail();

    $products = Product::where('category_id', $category->id)
        ->with('images', 'subcategory')
        ->paginate(12);

    $categoriesTree = Category::select('id', 'name', 'slug')
        ->with(['subcategories:id,name,slug,category_id'])
        ->orderBy('name')
        ->get();

    $activeCategorySlug = $category->slug;
    $activeSubcategorySlug = null;

    $breadcrumb = [
        ['name' => 'Home', 'url' => route('home')],
        ['name' => $category->name, 'url' => '']
    ];

    $meta = (object) [
        'title' => $category->meta_title,
        'keyword' => $category->meta_keyword,
        'description' => $category->meta_description,
    ];

    if ($request->ajax()) {
        $html = view('products.partials.product-grid', [
            'products' => $products,
            'category' => $category,
        ])->render();

        $pagination = $products->hasPages() ? $products->links()->toHtml() : '';

        return response()->json([
            'html' => $html,
            'pagination' => $pagination,
            'hasProducts' => $products->count() > 0,
        ]);
    }

    return view('products.index', compact('products', 'category', 'breadcrumb', 'meta', 'categoriesTree', 'activeCategorySlug', 'activeSubcategorySlug'));
}

    
    public function getProducts()
    {
        $products = Product::all();
        return response()->json($products);
    }

    
    
public function search(Request $request)
{
    $query = $request->input('q');

    $products = Product::with('images')
        ->where('product_name', 'like', '%' . $query . '%')
        ->orWhere('description', 'like', '%' . $query . '%')
        ->paginate(15)
        ->appends(['q' => $query]); // Keep the query in pagination links

    $categoriesTree = Category::select('id', 'name', 'slug')
        ->with(['subcategories:id,name,slug,category_id'])
        ->orderBy('name')
        ->get();

   return view('search-results', [
       'products' => $products,
       'query' => $query,
       'categoriesTree' => $categoriesTree,
       'activeCategorySlug' => null,
       'activeSubcategorySlug' => null,
   ]);

}



public function getByCategory($categoryId)
{
    if ($categoryId === 'all') {
        $products = Product::all(['id', 'product_name']);
    } else {
        $products = Product::where('category_id', $categoryId)->get(['id', 'product_name']);
    }

    return response()->json($products);
}


    public function storeReview(Request $request, $id)
    {
        $request->validate([
            'user_name' => 'required|string|max:255',
            'user_email' => 'required|email|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        Review::create([
            'product_id' => $id,
            'user_name' => $request->input('user_name'),
            'user_email' => $request->input('user_email'),
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
        ]);

        return redirect()->route('product.show', ['url' => Product::find($id)->url])
            ->with('success', 'Review submitted successfully!');
    }

    public function showByCategory($slug)
    {

        // Find the category by slug
        $category = Category::where('slug', $slug)->firstOrFail();
        $categoryName = $category->name;
        // Fetch the products belonging to the category with images and subcategory data
        $products = Product::where('category_id', $category->id)
            ->with(['images' => function ($query) {
                $query->select('product_id', 'image_url');
            }, 'subcategory' => function ($query) {
                $query->select('id', 'name');
            }])
            ->paginate(12);  // Use paginate instead of get
            
        $meta = (object) [
            'title' => $category->meta_title,
            'keyword' => $category->meta_keyword,
            'description' => $category->meta_description,
        ];
        // Return the view with the necessary data
        return view('products.index', compact('products', 'category', 'categoryName', 'meta'));
    }


    public function showBySubcategory($slug)
    {
        // Find the subcategory by slug
        $subcategory = Subcategory::where('slug', $slug)->firstOrFail();
        $subcategoryName  = $subcategory->name;
        // Fetch the products belonging to the subcategory with images and subcategory data
        $products = Product::where('subcategory_id', $subcategory->id)
            ->with(['images' => function ($query) {
                $query->select('product_id', 'image_url');
            }, 'subcategory' => function ($query) {
                $query->select('id', 'name');
            }])
            ->paginate(12); 
            
        $meta = (object) [
            'title' => $subcategory->meta_title,
            'keyword' => $subcategory->meta_keyword,
            'description' => $subcategory->meta_description,
        ];


        // Return the view with the necessary data
        return view('products.subcat', compact('products', 'subcategory', 'subcategoryName', 'meta'));
    }


    public function getVariantData($id)
    {
        $variant = ProductVariant::with('variantImages')->findOrFail($id);

        return response()->json([
            'mrp' => $variant->mrp,
            'sale_price' => $variant->sale_price,
            'sku_code' => $variant->sku_code,
            'stock' => $variant->stock,
            'varaint_name' => $variant->varaint_name,
            'images' => $variant->variantImages->map(function ($image) {
                return ['image_url' => asset($image->image_url)];
            }),
            'variant' => $variant->variant
        ]);
    }


    public function searchQuery(Request $request)
    {
        $searchq = $request->input('searchq');
        $category = $request->input('category');

        // Initialize the base query
        $query = Product::query();

        // Filter by category if selected
        if ($category && $category !== 'all') {
            $categoryId = Category::where('name', $category)->value('id');
            if ($categoryId) {
                $query->where('category_id', $categoryId);
            }
        }

        // Filter by search query if provided
        if ($searchq) {
            $query->where(function ($q) use ($searchq) {
                $q->where('product_name', 'LIKE', '%' . $searchq . '%')
                    ->orWhere('description', 'LIKE', '%' . $searchq . '%')
                    ->orWhere('meta_key', 'LIKE', '%' . $searchq . '%')
                    ->orWhere('meta_desc', 'LIKE', '%' . $searchq . '%')
                    ->orWhere('title', 'LIKE', '%' . $searchq . '%');
            });
        }

        $products = $query->get();
        return view('search', compact('products'));
    }

    public function fetchCategoriesWithSubcategories()
    {
        // Fetch categories with subcategories and products
        $categories = Category::with('subcategories')->get();

        return $categories;
    }
}
