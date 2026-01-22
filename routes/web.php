<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\PaymentController3;
use App\Http\Controllers\TwilioController;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\PageMetaController;
use App\Http\Controllers\CommtController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::post('/blog/{blog}/comment', [CommtController::class, 'store'])->name('commts.store')->middleware('throttle:comments');


Route::get('cat', function (){
    return view('products.product_listing');
});


/*
Route::redirect('/car-wash-chemical', 'https://www.manmachineworks.com/blog/car-wash-chemical', 301);
*/

// Route::get('/', function () {
//     return view('home');
// })->name('home');

// Route::get('/test', function () {
//     return view('include.head'); // Ensure you can see the data here
// });
Route::get('/bbecome-dealer', [HomeController::class, 'become_dealer']);
Route::get('/become-dealer', [HomeController::class, 'become_dealer']);
//Route::post('/submit-apply-dealer', [FormController::class, 'storeApplyDealer'])->name('submit.apply.dealer');
// Route::post('/become-dealer', [FormController::class, 'submit_dealer'])->name('dealer.submit_dealer');


Route::get('/search-products', [ProductController::class, 'search'])->name('search.products');

Route::get('/get-products-by-category/{categoryId}', [ProductController::class, 'getByCategory']);
Route::get('/get-products', [ProductController::class, 'getProducts']);


Route::post('/submit-demo-form', [FormController::class, 'storeDemoForm'])->name('submit.demo.form');
// Route::post('/submit-apply-form', [FormController::class, 'storeApplyForm'])->name('submit.apply.form');

Route::post('/apply/submit', [FormController::class, 'storeApplyForm'])->name('submit.apply.form');
Route::post('/dealer/submit', [FormController::class, 'submit_dealer'])->name('dealer.submit_dealer');

Route::post('/contact/submit', [FormController::class, 'submit'])->name('contact.submit');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/blog', [HomeController::class, 'blogs'])->name('blog_list');

Route::get('/blog/{url}', [HomeController::class, 'blog_show'])->name('blog_show');
Route::get('/brand/{slug}', [BrandController::class, 'show'])->name('brand.show');

Route::get('/Career', function () {
    return redirect('/career');
});


Route::get('/industrial-polishing', [HomeController::class, 'indpolishing']);
Route::get('/professional-car-care', [HomeController::class, 'pro_car_care']);

Route::get('/career', [HomeController::class, 'carrer'])->name('carrer');
Route::post('/apply-job', [HomeController::class, 'apply'])->name('apply.job');


Route::post('subscribe',[SubscriberController::class, 'store_subs'])->name('store_subs');

Route::post('/product/{id}/review', [ProductController::class, 'storeReview'])->name('product.review.store');

Route::get('/clear-route-cache', function () {
    Artisan::call('route:clear');
    return "Route cache cleared!";
});

Route::post('/send-otp', [TwilioController::class, 'sendOTP'])->name('send-otp');
Route::post('/verify-otp', [TwilioController::class, 'verifyOTP'])->name('verify-otp');

Route::get('Md_Message', [PageController::class, 'Md_Message']);
Route::get('Team', [PageController::class, 'Team']);
Route::get('CSR', [PageController::class, 'CSR']);

Route::get('/News', [PageController::class, 'News']);
Route::get('/Video', [PageController::class, 'Video']);

Route::get('faq', [PageController::class, 'faq']);

Route::get('privacy', [PageController::class, 'privacy']);
Route::get('terms', [PageController::class, 'terms']);
Route::get('ppf-terms', [PageController::class, 'ppf']);
Route::get('contact', [PageController::class, 'contact']);
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('polishing-program', [PageController::class, 'polishingprogram']);
Route::get('comingsoon', [PageController::class, 'comingSoon']);
// Route::get('product_details', [PageController::class, 'productDetails']);
Route::get('categories', [PageController::class, 'categories'])->name('categories.index');


Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::get('/wishlist/add/{id}', [WishlistController::class, 'add'])->name('wishlist.add');
Route::delete('/wishlist/delete/{id}', [WishlistController::class, 'delete'])->name('wishlist.delete');

Route::middleware(['transfer.cart'])->group(function () {
    Route::get('cart', [CartController::class, 'index'])->name('cart.index');
    Route::get('cart/delete/{id}', [CartController::class, 'delete'])->name('cart.delete');
    Route::post('cart/update', [CartController::class, 'updateQuantity'])->name('cart.update');
});

Route::middleware(['auth'])->group(
    function () {
        Route::get('dashboard', [UserController::class, 'dashboard'])->name('dashboard');
        Route::get('address_add', [UserController::class, 'add_address_view'])->name('add_address.form');
        Route::post('address_add', [UserController::class, 'add_address'])->name('add_address');

        Route::get('address_edit/{id}', [UserController::class, 'address_edit_view'])->name('address.edit.form');
        Route::post('address_edit/update/{id}', [UserController::class, 'edit_address'])->name('address.edit');

        Route::post('orders/{order}/cancel', [UserController::class, 'cancelOrder'])->name('orders.cancel');
    }
);
Route::post('address_add_c', [UserController::class, 'add_address_c'])->name('add_address_c');


Route::get('checkout', [CartController::class, 'checkout'])->name('checkout.index');
Route::post('/checkout', [UserController::class, 'checkout'])->name('checkout');

Route::post('/apply-coupon', [CartController::class, 'applyCoupon'])->name('apply.coupon');


Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('cart/add/{id}', [CartController::class, 'add'])->name('cart.add');

Route::post('/payment', [PaymentController::class, 'createOrder'])->name('payment.create');
Route::get('/payment-status/{merchantTransactionId}', [PaymentController::class, 'checkPaymentStatus'])->name('payment.status');

// routes/web.php
Route::get('/orders/{order}', [UserController::class, 'viewOrder'])->name('orders.view');
// routes/web.php

Route::get('/payment-success/{merchantTransactionId}', [ShippingController::class, 'handleShipping'])->name('payment.success');


Route::get('/payment-pending', function () {
    return view('payment.pending');
})->name('payment.pending');

Route::get('/payment-failure', function () {
    return view('payment.failure');
})->name('payment.failure');

// password




// Password Reset Routes
Route::get('forgot-password', [UserController::class, 'showResetRequestForm'])->name('password.request');
Route::post('forgot-password', [UserController::class, 'sendResetLink'])->name('password.email');
Route::get('reset-password/{token}/{email}', [UserController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [UserController::class, 'resetPassword'])->name('password.update');



Route::get('search', [ProductController::class, 'searchQuery'])->name('searchQuery');


//   Route::get('/{url}', [ProductController::class, 'show'])->name('content.show');






Route::get('/product/variant/{id}', [ProductController::class, 'getVariantData']);



Route::get('login', [UserController::class, 'login'])->name('login');
Route::post('login', [UserController::class, 'loginSubmit'])->name('login.submit');
Route::post('logout', [UserController::class, 'logout'])->name('logout');

Route::get('register', [UserController::class, 'register'])->name('register');
Route::post('register', [UserController::class, 'registerSubmit'])->name('register.submit');



  
// Meta Routes - Admin Panel
Route::prefix('admin')->name('admin.metas.')->group(function () {
    
    // Show all meta entries
    Route::get('/metas', [PageMetaController::class, 'index'])->name('index');
    
    // Show create form
    Route::get('/metas/create', [PageMetaController::class, 'create'])->name('create');
    
    // Store new meta entry
    Route::post('/metas', [PageMetaController::class, 'store'])->name('store');
    
    // Show edit form
    Route::get('/metas/{metas}/edit', [PageMetaController::class, 'edit'])->name('edit');
    
    // Update existing meta
    Route::put('/metas/{metas}', [PageMetaController::class, 'update'])->name('update');
    
    // Delete a meta entry
    Route::delete('/metas/{metas}', [PageMetaController::class, 'destroy'])->name('destroy');
});

Route::prefix('admin')->group(function () {
    

    Route::get('login', [AdminController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminController::class, 'login']);
    Route::post('logout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('dashboard', [AdminController::class, 'showDashboard'])->name('admin.dashboard');
        Route::get('add_product', [AdminController::class, 'addProductForm'])->name('admin.add_product');
        Route::post('add_product', [AdminController::class, 'storeProduct'])->name('admin.store_product');
        Route::get('get-subcategories/{category}', [AdminController::class, 'getSubcategories'])->name('get-subcategories');

        Route::get('meta_update',[AdminController::class,'meta_update_form']);
        Route::put('meta_update',[AdminController::class,'meta_update'])->name('meta.update');

        // Brands
        Route::get('brands', [BrandController::class, 'index'])->name('brands.index');
        Route::get('brands/create', [BrandController::class, 'create'])->name('brands.create');
        Route::post('brands', [BrandController::class, 'store'])->name('brands.store');
        Route::get('brands/{brand}/edit', [BrandController::class, 'edit'])->name('brands.edit');
        Route::put('brands/{brand}', [BrandController::class, 'update'])->name('brands.update');
        Route::delete('brands/{brand}', [BrandController::class, 'destroy'])->name('brands.destroy');


        Route::get('apply', [AdminController::class, 'showApplyFormData'])->name('admin.apply');
        Route::get('apply/{id}', [AdminController::class, 'showApplyFormDetail'])->name('admin.apply.detail');

        Route::get('demo', [AdminController::class, 'showDemoFormFormData'])->name('admin.demo');
        Route::get('demo/{id}', [AdminController::class, 'showDemoFormDetail'])->name('admin.demo.detail');

        Route::get('contact', [AdminController::class, 'showContactFormData'])->name('admin.contact');
        Route::get('contact/{id}', [AdminController::class, 'showContactFormDetail'])->name('admin.contact.detail');


        Route::get('/product/{url}', [ProductController::class, 'show'])->name('product.show');

        Route::get('/home', [AdminController::class, 'index_home'])->name('index_home.form');
        Route::post('/home/update', [AdminController::class, 'update_home'])->name('home.update');
        // New Routes for Product Image Management
        Route::delete('images/{image}', [AdminController::class, 'img_destroy'])->name('images.destroy');

        Route::get('/products', [AdminController::class, 'index'])->name('products.index');
        Route::get('/products/{product}/edit', [AdminController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [AdminController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [AdminController::class, 'destroy'])->name('products.destroy');

        // In routes/web.php
        Route::get('/products/{product}/edit-variants', [AdminController::class, 'editVariants'])->name('products.editVariants');
        Route::put('/products/{product}/update-variants', [AdminController::class, 'updateVariants'])->name('products.updateVariants');

        Route::get('/products/{product}/add-variants', [AdminController::class, 'add_Variants'])->name('products.add_Variants');
        Route::put('/products/{product}/add-variants', [AdminController::class, 'addVariants'])->name('products.addMoreVariants');

        Route::delete('/products/variant-image/{imageId}', [AdminController::class, 'deleteVariantImage'])->name('products.deleteVariantImage');
        Route::delete('/products/variant/{variantId}', [AdminController::class, 'deleteVariant'])->name('products.deleteVariant');


        Route::put('/products/{variant}/update-variant-images', [AdminController::class, 'updateVariantImages'])->name('products.updateVariantImages');


        Route::get('/blogs_show', [AdminController::class, 'blog_index'])->name('blogs.index');
        Route::get('/blogs/create', [AdminController::class, 'blog_create'])->name('blogs.create');
        Route::post('/blogs', [AdminController::class, 'blog_store'])->name('blogs.store');
        Route::get('/blogs/{blog}/edit', [AdminController::class, 'blog_edit'])->name('blogs.edit');
        Route::put('/blogs/{blog}', [AdminController::class, 'blog_update'])->name('blogs.update');
        Route::delete('/blogs/{blog}', [AdminController::class, 'blog_destroy'])->name('blogs.destroy');

        // Categories routes
        Route::get('categories', [AdminController::class, 'indexCategory'])->name('categories.index');
        Route::get('categories/create', [AdminController::class, 'createCategory'])->name('categories.create');
        Route::post('categories', [AdminController::class, 'storeCategory'])->name('categories.store');
        Route::get('categories/{category}/edit', [AdminController::class, 'editCategory'])->name('categories.edit');
        Route::put('categories/{category}', [AdminController::class, 'updateCategory'])->name('categories.update');
        Route::delete('categories/{category}', [AdminController::class, 'destroyCategory'])->name('categories.destroy');

        // Subcategories routes
        Route::get('subcategories', [AdminController::class, 'indexSubcategory'])->name('subcategories.index');
        Route::get('subcategories/create', [AdminController::class, 'createSubcategory'])->name('subcategories.create');
        Route::post('subcategories', [AdminController::class, 'storeSubcategory'])->name('subcategories.store');
        Route::get('subcategories/{subcategory}/edit', [AdminController::class, 'editSubcategory'])->name('subcategories.edit');
        Route::put('subcategories/{subcategory}', [AdminController::class, 'updateSubcategory'])->name('subcategories.update');
        Route::delete('subcategories/{subcategory}', [AdminController::class, 'destroySubcategory'])->name('subcategories.destroy');

        Route::get('reviews', [AdminController::class, 'indexReview'])->name('admin.reviews.index');
        Route::delete('reviews/{id}', [AdminController::class, 'destroyReview'])->name('admin.reviews.destroy');

        Route::get('orders', [AdminController::class, 'order'])->name('admin.orders.index');
        
         Route::get('order_pending', [AdminController::class, 'order_pending'])->name('admin.orders.order_pending');

        Route::patch('orders/{order}/update-delivery-time', [AdminController::class, 'updateDeliveryTime'])->name('admin.orders.updateDeliveryTime');
        Route::get('orders/canceled', [AdminController::class, 'canceledOrders'])->name('admin.orders.canceled');
        Route::post('orders/{order}/cancel', [AdminController::class, 'cancelOrder'])->name('admin.orders.cancel');
        
        
         Route::get('home/content', [AdminController::class, 'home_content'])->name('home_content.create');
        Route::post('home_content', [AdminController::class, 'home_content_post'])->name('home_content.store');
        

        Route::get('users', [AdminController::class, 'user'])->name('admin.users.index');

        Route::get('coupons', [AdminController::class, 'indexCoupon'])->name('coupons.index');
        Route::get('coupons/create', [AdminController::class, 'createCoupon'])->name('coupons.create');
        Route::post('coupons', [AdminController::class, 'storeCoupon'])->name('coupons.store');
        Route::delete('coupons/{coupon}', [AdminController::class, 'destroyCoupon'])->name('coupons.destroy');
    });
});

// Subcategory products page


// Product detail page
Route::get('/{categorySlug}/{subcategorySlug}/{productSlug}', [ProductController::class, 'showProduct'])
    ->name('product.show');



Route::get('{category}', [ProductController::class, 'showCategory'])->name('category.show');
Route::get('{category}/{subcategory}', [ProductController::class, 'showSubcategory'])->name('subcategory.show');
Route::get('{category}/{subcategory}/{url}', [ProductController::class, 'show'])->name('content.show');
