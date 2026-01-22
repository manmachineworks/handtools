<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\Blog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\ProductVariant;
use App\Models\VariantImage;
use App\Models\Brand;
use App\Models\Review;
use App\Models\Order;
use App\Mail\ProductNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Subscriber;
use App\Models\User;
use App\Models\Coupon;
use App\Models\HomePage;
use App\Models\DemoForm;
use App\Models\ApplyForm;
use App\Models\Contact;
use App\Models\Meta;
use App\Models\Page;

class AdminController extends Controller
{


    public function meta_update_form(){
        $meta = Meta::where('id', 1)->first();
        return view('admin.meta.edit', compact('meta'));
    }

    public function meta_update(Request $request){
        $data = $request->validate([
            'title' => 'required|string',
            'keyword' => 'required|string',
            'description' => 'required|string'
        ]);

        // dd($data);
        $meta = Meta::where('id', 1)->update($data);

        if($meta){
            return redirect()->back()->with('success', 'Meta Data Updated Succesfully');
        }else{
            return redirect()->back()->with('error', 'Meta Data Not Updated');
        }

    }

    public function index_home()
    {
        $homepage = HomePage::where('id', 1)->first();

        return view('admin.home.index', compact('homepage'));
    }


    public function home_content(){

    $page = Page::where('id' , 1)->first();
    return view('admin.page.index', compact('page'));
}

    public function home_content_post(Request $request) {
        $request->validate([
            'title_1' => 'required|string',
            'content_1' => 'required|string',
        ]);

        $page = Page::findOrFail(1);

        // Update the fields
        $page->update([
            'title' => $request->input('title_1'),
            'content' => $request->input('content_1'),
        ]);

        // Redirect or return response
        return redirect()->back()->with('success', 'Content updated successfully');

    }

    public function update_home(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'title_1' => 'required|string|max:255',
            'content_1' => 'required|string',
            'title_2' => 'required|string|max:255',
            'content_2' => 'required|string',
            
        ]);

        // Find the franchise record with id 1
        $HomePage = HomePage::findOrFail(1);

        // Update the fields
        $HomePage->update([
            'title_1' => $request->input('title_1'),
            'content_1' => $request->input('content_1'),
            'title_2' => $request->input('title_2'),
            'content_2' => $request->input('content_2'),
        ]);

        // Redirect or return response
        return redirect()->back()->with('success', 'HomePage updated successfully');
    }

    // Show the login form
    public function showLoginForm()
    {
        return view('admin.login');
    }

    // Handle the login request
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $username = $request->input('username');
        $password = $request->input('password');

        // Find the admin by username
        $admin = Admin::where('username', $username)->first();

        // Debugging step: check if admin exists
        if (!$admin) {
            return back()->withErrors([
                'username' => 'No admin found with this username.',
            ]);
        }

        // Check the password
        if ($admin->password !== $password) {
            return back()->withErrors([
                'password' => 'Incorrect password.',
            ]);
        }
        // Log in the admin
        Auth::guard('admin')->login($admin);
        return redirect()->intended('admin/dashboard');
    }


    // Logout the admin
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    public function showDashboard()
    {
        
        $applyForms = ApplyForm::whereDate('created_at', Carbon::today())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $counter = ($applyForms->currentPage() - 1) * $applyForms->perPage() + 1;

        return view('admin.dashboard', compact('applyForms', 'counter'));
        
    }
    // Outlets Admin Panle Ends Here]


    // Show the form to add a new product
    public function addProductForm()
    {
        $categories = Category::with('subcategories')->get();
        $brands = Brand::active()->orderBy('name')->get();
        return view('admin.products.add_product', compact('categories', 'brands'));
    }

    public function getSubcategories($category)
    {
        // Assuming you have a relationship set up in Category model to Subcategory
        $subcategories = Subcategory::where('category_id', $category)->get(['id', 'name']);

        return response()->json($subcategories);
    }

    public function storeProduct(Request $request)
    {
        // Loop through each variant
        // foreach ($request->variants as $index => $variant) {
        //     // Check if images exist for the variant
        //     if (isset($variant['images'])) {
        //         $imageCount = count($variant['images']);
        //         echo "Variant {$index} has {$imageCount} images.<br>";
        //     } else {
        //         echo "Variant {$index} has no images.<br>";
        //     }
        // }
        // exit(); // To stop execution after displaying the image counts
          $check_data = $request->validate([
            'product_name' => 'required',
            'code' => 'required',
            'meta_key' => 'required',
            'meta_desc' => 'required',
            'title' => 'required',
            'url' => 'required',
            'mrp' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'stock' => 'required|numeric',
            'sku_code' => 'required',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'description' => 'nullable|string',
            'today_hot_deals' => 'boolean',
            'best_seller' => 'boolean',
            'featured_products' => 'boolean',
            'length' => 'required|numeric',
            'breadth' => 'required|numeric',
            'height' => 'required|numeric',
            'weight' => 'required|numeric',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'
        ], [
            'category_id.exists' => 'The selected category is invalid.',
            'subcategory_id.exists' => 'The selected subcategory is invalid.'
        ]);

        // Create the product
        $product = Product::create([
            'product_name' => $request->product_name,
            'code' => $request->code,
            'mrp' => $request->mrp,
            'sale_price' => $request->sale_price,
            'sku_code' => $request->sku_code,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'brand_id' => $request->brand_id,
            'description' => $request->description,
            'meta_key' => $request->meta_key,
            'meta_desc' => $request->meta_desc,
            'url' => $request->url,
            'title' => $request->title,
            'stock' => $request->stock,
            'today_hot_deals' => $request->input('today_hot_deals', 0),
            'best_seller' => $request->input('best_seller', 0),
            'featured_products' => $request->input('featured_products', 0),
            'length' => $request->length,
            'breadth' => $request->breadth,
            'height' => $request->height,
            'weight' => $request->weight,
        ]);

        // Save product images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('assets/img/product'), $imageName);
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => 'assets/img/product/' . $imageName
                ]);
            }
        }

        // Save product variants
        if ($request->has('variants')) {
            foreach ($request->variants as $variant) {
                $productVariant = ProductVariant::create([
                    'product_id' => $product->id,
                    'variant' => $variant['name'],
                    'mrp' => $variant['mrp'],
                    'sale_price' => $variant['sale_price'],
                    'sku_code' => $variant['sku_code'],
                    'varaint_name' => $variant['v_name'],
                    'stock' => $variant['stock'],
                ]);
                // Save variant images
                if (isset($variant['images'])) {
                    foreach ($variant['images'] as $image) {
                        $imageName = time() . '_' . $image->getClientOriginalName();
                        $image->move(public_path('assets/img/variant'), $imageName);
                        VariantImage::create([
                            'product_variant_id' => $productVariant->id,
                            'image_url' => 'assets/img/variant/' . $imageName
                        ]);
                    }
                }
            }
        }

        $productUrl = route('product.show', ['url' => $product->url]);

        // Fetch all subscribers
        $subscribers = Subscriber::all();

        // foreach ($subscribers as $subscriber) {
        //     Mail::to($subscriber->email)->send(new ProductNotification($product->product_name, $productUrl));
        // }

        return redirect()->route('products.index')->with('success', 'Product added successfully.');
    }


    public function index()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    // Show the form for editing the specified product

    public function edit(Product $product)
    {
        $categories = Category::all();
        $subcategories = Subcategory::where('category_id', $product->category_id)->get();
        $brands = Brand::orderBy('name')->get();
        $variants = $product->variants()->with('variantImages')->get();
        return view('admin.products.edit', compact('product', 'categories', 'subcategories', 'variants', 'brands'));
    }

    public function editVariants(Product $product)
    {
        $categories = Category::all();
        $subcategories = Subcategory::where('category_id', $product->category_id)->get();
        $variants = $product->variants()->with('variantImages')->get();
        return view('admin.products.edit_variant', compact('product', 'categories', 'subcategories', 'variants'));
    }

    public function add_Variants(Product $product)
    {
        $categories = Category::all();
        $subcategories = Subcategory::where('category_id', $product->category_id)->get();
        $variants = $product->variants()->with('variantImages')->get();
        return view('admin.products.add_variant', compact('product', 'categories', 'subcategories', 'variants'));
    }

    public function addVariants(Request $request, $productId)
    {
        $product = Product::findOrFail($productId); // Retrieve the product by ID

        if ($request->has('variants')) {
            foreach ($request->variants as $variant) {
                // Create ProductVariant record
                $productVariant = ProductVariant::create([
                    'product_id' => $product->id,
                    'variant' => $variant['name'],
                    'mrp' => $variant['mrp'],
                    'sale_price' => $variant['sale_price'],
                    'sku_code' => $variant['sku_code'],
                    'varaint_name' => $variant['v_name'],
                    'stock' => $variant['stock'],
                ]);

                // Save variant images
                if (isset($variant['images'])) {
                    foreach ($variant['images'] as $image) {
                        if ($image) { // Check if image is not null
                            $imageName = time() . '_' . $image->getClientOriginalName();
                            $image->move(public_path('assets/img/variant'), $imageName);
                            VariantImage::create([
                                'product_variant_id' => $productVariant->id,
                                'image_url' => 'assets/img/variant/' . $imageName
                            ]);
                        }
                    }
                }
            }
        }

        return redirect()->route('products.editVariants', $productId)
            ->with('success', 'Variants added successfully.');
    }

    public function updateVariantImages(Request $request, $variantId)
    {
        $variant = ProductVariant::find($variantId);

        if ($variant) {
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $image->move(public_path('assets/img/variant'), $imageName);

                    VariantImage::create([
                        'product_variant_id' => $variant->id,
                        'image_url' => 'assets/img/variant/' . $imageName
                    ]);
                }
            }
        }

        return back()->with('success', 'Images updated successfully.');
    }


    public function updateVariants(Request $request, Product $product)
    {
        $data = $request->input('variants');

        foreach ($data as $variantId => $variantData) {
            // Update variant details
            $variant = ProductVariant::find($variantId);
            if ($variant) {
                $variant->update([
                    'name' => $variantData['name'],
                    'mrp' => $variantData['mrp'],
                    'sale_price' => $variantData['sale_price'],
                    'sku_code' => $variantData['sku_code'],
                    'varaint_name' => $variantData['v_name'],
                    'stock' => $variantData['stock'],
                ]);

                // Handle images
                if (isset($variantData['images'])) {
                    foreach ($variantData['images'] as $image) {
                        $imagePath = $image->store('variant_images', 'public');
                        VariantImage::create([
                            'product_variant_id' => $variant->id,
                            'image_url' => $imagePath
                        ]);
                    }
                }
            }
        }
        return redirect()->route('products.editVariants', $product->id)
            ->with('success', 'Variants updated successfully');
    }



    public function deleteVariantImage($imageId)
    {
        $image = VariantImage::find($imageId);
        if ($image) {
            // Delete image file
            $filePath = public_path('assets/img/variant/' . $image->image_url); // Adjust the path if needed
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Delete record from database
            $data = $image->delete();

            // dd($data);
        }

        return back()->with('success', 'Image removed successfully');
    }

    public function deleteVariant($variantId)
    {
        $variant = ProductVariant::find($variantId);
        if ($variant) {
            // Delete related images
            $variant->variantImages()->each(function ($image) {
                $filePath = public_path('assets/img/variant/' . $image->image_url); // Adjust the path if needed
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
                $image->delete();
            });
            // Delete variant record
            $variant->delete();
        }

        return back()->with('success', 'Variant removed successfully');
    }


    public function img_destroy(ProductImage $image)
    {
        // Delete the image file from the server
        if (file_exists(public_path('assets/img/product/' . $image->image_url))) {
            unlink(public_path('assets/img/product/' . $image->image_url));
        }
        // Delete the image record from the database
        $image->delete();
        return response()->json(['success' => true]);
    }

    // Update the specified product in storage
    public function update(Request $request, Product $product)
    {
        // Validate the request
        $request->validate([
            'product_name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'variant' => 'nullable|string|max:255',
            'mrp' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'sku_code' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'description' => 'nullable|string',
            'new_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:20048',
            'update_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:20048',
            'stock' => 'required|numeric',
            'today_hot_deals' => 'boolean',
            'best_seller' => 'boolean',
            'featured_products' => 'boolean',
            'length' => 'required|numeric',
            'breadth' => 'required|numeric',
            'height' => 'required|numeric',
            'weight' => 'required|numeric',
        ]);

        // Update product details
        $product->update($request->only([
            'product_name',
            'code',
            'variant',
            'mrp',
            'sale_price',
            'sku_code',
            'category_id',
            'subcategory_id',
            'brand_id',
            'description',
            'meta_key',
            'meta_desc',
            'url',
            'title',
            'stock',
            'today_hot_deals',
            'best_seller',
            'featured_products',
            'length',
            'breadth',
            'height',
            'weight',
        ]));



        // Handle updating existing images
        if ($request->hasFile('update_images')) {
            foreach ($request->file('update_images') as $imageId => $imageFile) {
                $image = ProductImage::find($imageId);
                if ($image) {
                    // Delete the old image file
                    if (file_exists(public_path('assets/img/product/' . $image->image_url))) {
                        unlink(public_path('assets/img/product/' . $image->image_url));
                    }

                    // Store the new image file
                    $imageName = time() . '_' . $imageFile->getClientOriginalName();
                    $imageFile->move(public_path('assets/img/product'), $imageName);

                    // Update the image record
                    $image->update([
                        'image_url' => 'assets/img/product/' . $imageName,
                    ]);
                }
            }
        }

        // Handle adding new images
        if ($request->hasFile('new_images')) {
            foreach ($request->file('new_images') as $imageFile) {
                $imageName = time() . '_' . $imageFile->getClientOriginalName();
                $imageFile->move(public_path('assets/img/product'), $imageName);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => 'assets/img/product/' . $imageName,
                ]);
            }
        }

        return redirect()->route(
            'products.edit',
            $product
        )->with('success', 'Product updated successfully.');
    }

    // Remove the specified product from storage
    public function destroy(Product $product)
    {
        // Fetch the variants associated with the product
        $variants = ProductVariant::where('product_id', $product->id)->get();

        // Iterate over each variant
        foreach ($variants as $variant) {
            if ($variant) {
                // Delete related images
                $variant->variantImages()->each(function ($image) {
                    $filePath = public_path('assets/img/variant/' . $image->image_url); // Adjust the path if needed
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                    $image->delete();
                });

                // Delete variant record
                $variant->delete();
            }
        }

        // Delete the product
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }



    // Blog Admin Panle Starts Here]

    public function blog_index()
    {
        $blogs = Blog::orderBy('date', 'desc')->get();
        return view('admin.blogs.index', compact('blogs'));
    }

    // Show the form for creating a new resource
    public function blog_create()
    {
        return view('admin.blogs.create');
    }

    // Store a newly created resource in storage
    public function blog_store(Request $request)
    {
        $request->validate([
            'blog_title' => 'required|string|max:250',
            'url' => 'required|string|max:500',
            'meta_title' => 'required|string|max:500',
            'meta_keyword' => 'required',
            'meta_description' => 'required',
            'meta_canonical' => 'nullable|string|max:500',
            'meta_alternate' => 'nullable|string|max:500',
            'blog_image' => 'nullable|image|max:2048',
            'blog_image_2' => 'nullable|image|max:2048',
            'blog_detail' => 'required',
        ]);

        $data = $request->input('meta_canonical');
        // dd($data);
        // Initialize a new Blog entry
        $blog = new Blog();

        // Assign data from request to the blog entry
        $blog->blog_title = $request->input('blog_title');
        $blog->url = $request->input('url');
        $blog->meta_title = $request->input('meta_title');
        $blog->meta_keyword = $request->input('meta_keyword');
        $blog->meta_description = $request->input('meta_description');
        $blog->meta_canonical = $request->input('meta_canonical');
        $blog->meta_alternate = $request->input('meta_alternate');
        $blog->blog_detail = $request->input('blog_detail');

        // Handle the first blog image
        if ($request->hasFile('blog_image')) {
            $imageName = time() . '_' . $request->file('blog_image')->getClientOriginalName();
            $request->file('blog_image')->move(public_path('assets/img/blog'), $imageName);
            $blog->blog_image = 'assets/img/blog/' . $imageName;
        }

        // Handle the second blog image
        if ($request->hasFile('blog_image_2')) {
            $imageName2 = time() . '_' . $request->file('blog_image_2')->getClientOriginalName();
            $request->file('blog_image_2')->move(public_path('assets/img/blog'), $imageName2);
            $blog->blog_image_2 = 'assets/img/blog/' . $imageName2;
        }

        // Save the blog entry to the database
        $blog->save();

        return redirect()->route('blogs.index')->with('success', 'Blog created successfully.');
    }



    // Show the form for editing the specified resource
    public function blog_edit(Blog $blog)
    {
        return view('admin.blogs.edit', compact('blog'));
    }

    // Update the specified resource in storage
    public function blog_update(Request $request, Blog $blog)
    {
        $request->validate([
            'blog_title' => 'required|string|max:250',
            'url' => 'required|string|max:500',
            'meta_title' => 'required|string|max:500',
            'meta_keyword' => 'required',
            'meta_description' => 'required',
            'meta_canonical' => 'nullable|string|max:500',
            'meta_alternate' => 'nullable|string|max:500',
            'blog_image' => 'nullable|image|max:2048', // Image validation
            'blog_image_2' => 'nullable|image|max:2048', // Image validation
            'blog_detail' => 'required',
        ]);

        // Assign data from request to the blog entry
        $blog->blog_title = $request->input('blog_title');
        $blog->url = $request->input('url');
        $blog->meta_title = $request->input('meta_title');
        $blog->meta_keyword = $request->input('meta_keyword');
        $blog->meta_description = $request->input('meta_description');
        $blog->meta_canonical = $request->input('meta_canonical');
        $blog->meta_alternate = $request->input('meta_alternate');
        $blog->blog_detail = $request->input('blog_detail');

        // Handle the first blog image
        if ($request->hasFile('blog_image')) {
            $imageName = time() . '_' . $request->file('blog_image')->getClientOriginalName();
            $request->file('blog_image')->move(public_path('assets/img/blog'), $imageName);
            $blog->blog_image = 'assets/img/blog/' . $imageName;
        }

        // Handle the second blog image
        if ($request->hasFile('blog_image_2')) {
            $imageName2 = time() . '_' . $request->file('blog_image_2')->getClientOriginalName();
            $request->file('blog_image_2')->move(public_path('assets/img/blog'), $imageName2);
            $blog->blog_image_2 = 'assets/img/blog/' . $imageName2;
        }

        // Save the updated blog entry to the database
        $blog->save();

        return redirect()->route('blogs.index')->with('success', 'Blog updated successfully.');
    }



    // Remove the specified resource from storage
    public function blog_destroy(Blog $blog)
    {
        $blog->delete();

        return redirect()->route('blogs.index')->with('success', 'Blog deleted successfully.');
    }

    // Blog Admin Panle Ends Here]


    // Category Section Starts Here 

    public function indexCategory()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function createCategory()
    {
        return view('admin.categories.create');
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories', // Ensure unique slugs
            'meta_title' => 'required|string|max:500',
            'meta_keyword' => 'required|string', // Add validation rule for meta_keyword if needed
            'meta_description' => 'required|string',
            'cat_image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'cat_text' => 'required|string',
        ]);



        $category = new Category();

        $category->name = $request->input('name');
        $category->slug = $request->input('slug');
        $category->meta_title = $request->input('meta_title');
        $category->meta_keyword = $request->input('meta_keyword');
        $category->meta_description = $request->input('meta_description');
        $category->cat_text = $request->input('cat_text');

        // Handle the image upload
        if ($request->hasFile('cat_image')) {
            // Create a unique image name with time for avoiding conflicts
            $imageName = time() . '_' . $request->file('cat_image')->getClientOriginalName();

            // Move the image to the public/assets/img/cat_image directory
            $request->file('cat_image')->move(public_path('assets/img/cat_image'), $imageName);

            // Save the image path in the database
            $category->cat_image = 'assets/img/cat_image/' . $imageName;
        }


        $category->save(); // Don't forget to save the category

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function editCategory(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function updateCategory(Request $request, Category $category)
    {


        $category->name = $request->input('name');
        $category->slug = $request->input('slug');
        $category->meta_title = $request->input('meta_title');
        $category->meta_keyword = $request->input('meta_keyword');
        $category->meta_description = $request->input('meta_description');
        $category->cat_text = $request->input('cat_text');

        // Handle the image upload
        if ($request->hasFile('cat_image')) {
            // Create a unique image name with time for avoiding conflicts
            $imageName = time() . '_' . $request->file('cat_image')->getClientOriginalName();

            // Move the image to the public/assets/img/cat_image directory
            $request->file('cat_image')->move(public_path('assets/img/cat_image'), $imageName);

            // Save the image path in the database
            $category->cat_image = 'assets/img/cat_image/' . $imageName;
        }

        // Save the changes to the existing category
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroyCategory(Category $category)
    {
        // Check if there are any products associated with this category
        if ($category->products()->count() > 0) {
            return redirect()->route('categories.index')->with('error', 'Cannot delete category because it has associated products. Please delete the products first.');
        }

        // If no products are associated, delete the category
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }


    // Subcategories

    public function indexSubcategory()
    {
        
        $subcategories = Subcategory::with('category')->get();
        return view('admin.subcategories.index', compact('subcategories'));
    }

    public function createSubcategory()
    {
        $categories = Category::all();
        return view('admin.subcategories.create', compact('categories'));
    }

    public function storeSubcategory(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'meta_title' => 'required|string|max:500',
            'meta_keyword' => 'required|string', // Add validation rule for meta_keyword if needed
            'meta_description' => 'required|string',
            'subcat_image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'subcat_text' => 'required|string',
        ]);

        $Subcategory = new Subcategory();

        $Subcategory->name = $request->input('name');
        $Subcategory->category_id  = $request->input('category_id');
        $Subcategory->slug = $request->input('slug');
        $Subcategory->meta_title = $request->input('meta_title');
        $Subcategory->meta_keyword = $request->input('meta_keyword');
        $Subcategory->meta_description = $request->input('meta_description');
        $Subcategory->subcat_text = $request->input('subcat_text');


        if ($request->hasFile('cat_image')) {
            // Create a unique image name with time for avoiding conflicts
            $imageName = time() . '_' . $request->file('cat_image')->getClientOriginalName();

            // Move the image to the public/assets/img/cat_image directory
            $request->file('cat_image')->move(public_path('assets/img/cat_image'), $imageName);

            // Save the image path in the database
            $category->cat_image = 'assets/img/cat_image/' . $imageName;
        }
        if ($request->hasFile('subcat_image')) {
            // Create a unique image name with time for avoiding conflicts
            $imageName = time() . '_' . $request->file('subcat_image')->getClientOriginalName();

            // Move the image to the public/assets/img/cat_image directory
            $request->file('subcat_image')->move(public_path('assets/img/subcat_image'), $imageName);

            // Save the image path in the database
            $Subcategory->subcat_image = 'assets/img/subcat_image/' . $imageName;
        }

        $Subcategory->save(); // Don't forget to save the category


        return redirect()->route('subcategories.index')->with('success', 'Subcategory created successfully.');
    }

    public function editSubcategory(Subcategory $subcategory)
    {
        $categories = Category::all();
        return view('admin.subcategories.edit', compact('subcategory', 'categories'));
    }

    public function updateSubcategory(Request $request, Subcategory $subcategory)
    {
        // Validate the input fields
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'meta_title' => 'required|string|max:500',
            'meta_keyword' => 'required|string',
            'meta_description' => 'required|string',
            'subcat_text' => 'required|string',
        ]);

        // Assign updated values to the existing subcategory
        $subcategory->name = $request->input('name');
        $subcategory->slug = $request->input('slug');
        $subcategory->meta_title = $request->input('meta_title');
        $subcategory->meta_keyword = $request->input('meta_keyword');
        $subcategory->meta_description = $request->input('meta_description');
        $subcategory->subcat_text = $request->input('subcat_text');
        $subcategory->category_id = $request->input('category_id');

        // Handle image upload if there's a file
        if ($request->hasFile('subcat_image')) {
            // Create a unique image name
            $imageName = time() . '_' . $request->file('subcat_image')->getClientOriginalName();

            // Move the image to the public/assets/img/subcat_image directory
            $request->file('subcat_image')->move(public_path('assets/img/subcat_image'), $imageName);

            // Debugging: ensure the correct path is being saved
            $img = 'assets/img/subcat_image/' . $imageName;
            // dd($img);  // Check this value before proceeding to save in the DB

            // Save the image path in the database
            $subcategory->subcat_image = $img;
        }

        // Save the updated subcategory to the database
        $subcategory->save();

        return redirect()->route('subcategories.index')->with('success', 'Subcategory updated successfully.');
    }



    public function destroySubcategory(Subcategory $subcategory)
    {
        // Check if there are any products associated with this subcategory
        if ($subcategory->products()->count() > 0) {
            return redirect()->route('subcategories.index')->with('error', 'Cannot delete subcategory because it has associated products. Please delete the products first.');
        }

        // If no products are associated, delete the subcategory
        $subcategory->delete();

        return redirect()->route('subcategories.index')->with('success', 'Subcategory deleted successfully.');
    }



    // Category Serction Ends Here


    //  Review Section Starts Here

    public function indexReview()
    {
        $reviews = Review::paginate(10); // Adjust the number as needed for pagination
        return view('admin.reviews.index', compact('reviews'));
    }

    public function destroyReview($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->route('admin.reviews.index')->with('success', 'Review deleted successfully!');
    }

    // Review Section Ends Here 

    public function order()
    {
        $orders = Order::with(['user', 'address', 'product'])
            ->where('order_status', 'active')
             ->where('status', 'success') // Second condition
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('transaction_id');

        // Manually paginate the grouped orders
        $currentPage = Paginator::resolveCurrentPage();
        $perPage = 10;
        $currentPageItems = $orders->slice(($currentPage - 1) * $perPage, $perPage)->all();

        $paginatedOrders = new LengthAwarePaginator(
            $currentPageItems,
            $orders->count(),
            $perPage,
            $currentPage,
            ['path' => Paginator::resolveCurrentPath()]
        );

        return view('admin.orders.index', compact('paginatedOrders'));
    }
    
     public function order_pending()
    {
        $orders = Order::with(['user', 'address', 'product'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('transaction_id');

        // Manually paginate the grouped orders
        $currentPage = Paginator::resolveCurrentPage();
        $perPage = 10;
        $currentPageItems = $orders->slice(($currentPage - 1) * $perPage, $perPage)->all();

        $paginatedOrders = new LengthAwarePaginator(
            $currentPageItems,
            $orders->count(),
            $perPage,
            $currentPage,
            ['path' => Paginator::resolveCurrentPath()]
        );

        return view('admin.orders.pending', compact('paginatedOrders'));
    }

    public function canceledOrders()
    {
        $orders = Order::with(['user', 'address', 'product'])
            ->where('order_status', 'canceled')
             ->where('status', 'success') // Second condition
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('transaction_id');

        // Manually paginate the grouped orders
        $currentPage = Paginator::resolveCurrentPage();
        $perPage = 10;
        $currentPageItems = $orders->slice(($currentPage - 1) * $perPage, $perPage)->all();

        $paginatedOrders = new LengthAwarePaginator(
            $currentPageItems,
            $orders->count(),
            $perPage,
            $currentPage,
            ['path' => Paginator::resolveCurrentPath()]
        );

        return view('admin.orders.canceled', compact('paginatedOrders'));
    }

    public function cancelOrder(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->order_status = 'canceled';
        $order->save();

        return redirect()->route('admin.orders.index')->with('success', 'Order has been canceled successfully.');
    }

    public function updateDeliveryTime(Request $request, $id)
    {
        $request->validate([
            'delivery_time' => 'required|string|max:255',
        ]);

        $order = Order::findOrFail($id);
        $order->delivery_time = $request->delivery_time;
        $order->save();

        return redirect()->route('admin.orders.index')->with('success', 'Delivery time updated successfully.');
    }

    public function user()
    {
        // Eager load the 'addresses' relationship
        $users = User::with('addresses')->paginate(10); // Adjust the number as needed for pagination

        return view('admin.users.index', compact('users'));
    }



    public function indexCoupon()
    {
        $coupons = Coupon::all();
        return view('admin.coupons.index', compact('coupons'));
    }

    // Show the form for creating a new coupon
    public function createCoupon()
    {
        return view('admin.coupons.create');
    }

    // Store a newly created coupon in the database
    public function storeCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string|max:50|unique:coupons',
            'discount_percentage' => 'required|integer|min:1|max:100',
        ]);

        Coupon::create($request->all());

        return redirect()->route('coupons.index')->with('success', 'Coupon created successfully.');
    }

    // Delete a coupon from the database
    public function destroyCoupon(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('coupons.index')->with('success', 'Coupon deleted successfully.');
    }



    public function showApplyFormData()
    {
        // Fetch all apply form data with pagination, ordered by date in descending order
        $applyForms = ApplyForm::orderBy('created_at', 'desc')->paginate(10); // 10 items per page

        // Initialize counter based on current page
        $counter = ($applyForms->currentPage() - 1) * $applyForms->perPage() + 1;

        // Pass data and counter to the view
        return view('admin.forms.apply_form', compact('applyForms', 'counter'));
    }

    public function showApplyFormDetail($id)
    {
        // Fetch the specific apply form record by ID
        $applyForm = ApplyForm::findOrFail($id);

        // Pass the data to the view
        return view('admin.forms.apply_form_detail', compact('applyForm'));
    }


    public function showDemoFormFormData()
    {
        // Fetch all apply form data with pagination, ordered by date in descending order
        $applyForms = DemoForm::orderBy('created_at', 'desc')->paginate(10); // 10 items per page

        // Initialize counter based on current page
        $counter = ($applyForms->currentPage() - 1) * $applyForms->perPage() + 1;

        // Pass data and counter to the view
        return view('admin.forms.demo_form', compact('applyForms', 'counter'));
    }

    public function showDemoFormDetail($id)
    {
        // Fetch the specific apply form record by ID
        $applyForm = DemoForm::findOrFail($id);

        // Pass the data to the view
        return view('admin.forms.demo_form_detail', compact('applyForm'));
    }


        
    public function showContactFormData()
    {
        // Fetch all apply form data with pagination, ordered by date in descending order
        $applyForms = Contact::orderBy('created_at', 'desc')->paginate(10); // 10 items per page

        // Initialize counter based on current page
        $counter = ($applyForms->currentPage() - 1) * $applyForms->perPage() + 1;

        // Pass data and counter to the view
        return view('admin.forms.contact_form', compact('applyForms', 'counter'));
    }

    public function showContactFormDetail($id)
    {
        // Fetch the specific apply form record by ID
        $applyForm = Contact::findOrFail($id);

        // Pass the data to the view
        return view('admin.forms.contact_form_detail', compact('applyForm'));
    }

}
