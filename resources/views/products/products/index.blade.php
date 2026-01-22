<!doctype html>
<html class="no-js" lang="en">


@include("layout/head")


<body>
    @include("layout/header")
    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="/">Home</a></li>
                            <li>{{ $categoryName }}

                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->

    <!--shop  area start-->
    <div class="shop_area shop_fullwidth">
        <div class="container mb-80">
            <div class="row">
                <div class="col-12">
                    <!--shop banner area start-->
                    <div class="shop_banner_area mb-30">
                        <div class="row">
                            <div class="col-12">
                                <div class="shop_banner_thumb">
                                    <img src="{{ asset($category->cat_image) }}" alt="{{ $category->name }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--shop banner area end-->

                    <div class="row">
                        <div>{!! $category->cat_text !!}</div>
                        @foreach($products as $product)
                        <div class="col-lg-3 col-md-4 col-12 mt-4 mb-4 text-center">
                            <article class="single_product text-center">
                                <figure>
                                    <div class="product_thumb">
                                        <a class="primary_img" href="{{ route('content.show', [
    'category' => $product->subcategory->category->slug,
    'subcategory' => $product->subcategory->slug,
    'url' => $product->url
]) }}">
                                            <img src="{{ asset($product->images->first()->image_url) }}" alt="{{ $product->product_name }}">
                                        </a>
                                        @if($product->images->count() > 1)
                                        <a class="secondary_img" href="{{ route('content.show', [
    'category' => $product->subcategory->category->slug,
    'subcategory' => $product->subcategory->slug,
    'url' => $product->url
]) }}">
                                            <img src="{{ asset($product->images[1]->image_url) }}" alt="{{ $product->product_name }}">
                                        </a>
                                        @endif
                                         <div class="label_product">
                                            <span class="label_new">new</span>
                                        </div> -->
                                    </div>
                                    <div class="product_content grid_content">
                                        <div class="product_content_inner">
                                             <p class="manufacture_product"><a href="#">{{ $product->subcategory->name }}</a></p> 
                                            <h4 class="product_name">
                                                <a href="{{ route('content.show', [
    'category' => $product->subcategory->category->slug,
    'subcategory' => $product->subcategory->slug,
    'url' => $product->url
]) }}">{{ $product->product_name }}</a>
                                            </h4>
                                            <div class="product_rating">
                                                <ul>
                                                    <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                    <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                    <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                    <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                    <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                </ul>
                                            </div>
                                            <div class="price_box">
                                                <span class="old_price">Rs {{ $product->mrp }}</span>
                                                <span class="current_price">Rs {{ $product->sale_price }}</span>
                                            </div>
                                        </div>
                                        <div class="action_links">
                                            <ul>
                                                <li class="add_to_cart">
                                                    <a href="{{ route('cart.add', ['id' => $product->id, 'variant_id' => null]) }}" title="Add to cart">Add to cart</a>
                                                </li>
                                                <li class="wishlist"><a href="{{ route('wishlist.add', $product->id) }}" title="Add to Wishlist"><i class="icon-heart"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product_content list_content">
                                        <div class="left_caption">
                                             <p class="manufacture_product"><a href="#">{{ $product->subcategory->name }}</a></p> 
                                            <h4 class="product_name">
                                                <a href="{{ route('content.show', [
    'category' => $product->subcategory->category->slug,
    'subcategory' => $product->subcategory->slug,
    'url' => $product->url
]) }}">{{ $product->product_name }}</a>
                                            </h4>
                                            <div class="product_rating">
                                                <ul>
                                                    <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                    <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                    <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                    <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                    <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                                </ul>
                                            </div>
                                            <div class="price_box">
                                                <span class="old_price">Rs {{ $product->mrp }}</span>
                                                <span class="current_price">Rs {{ $product->sale_price }}</span>
                                            </div>
                                            <div class="product_desc">
                                                <p>{{ Str::limit($product->description, 250) }}</p>
                                            </div>
                                        </div>
                                        <div class="right_caption">
                                            <p class="text_available">Availability: <span>{{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}</span></p>
                                            <div class="action_links">
                                                <ul>
                                                    <li class="add_to_cart"><a href="{{ route('cart.add', $product->id) }}" title="Add to cart">Add to cart</a></li>
                                                    <li class="wishlist"><a href="{{ route('wishlist.add', $product->id) }}" title="Add to Wishlist"><i class="icon-heart"></i> Add to Wishlist</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </figure>
                            </article>
                        </div>
                        @endforeach
                    </div>



                </div>
            </div>
        </div>
        <!--shop  area end-->




        @include("layout/footer")

</body>

</html>