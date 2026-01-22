<!DOCTYPE html>
<html lang="en">
@include('layout/head')

<body>

@include('layout/header')

<div class="container py-5">
    <h1>Products in {{ $subcategory->name }}</h1>

    <div class="row">
        @foreach($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    @if($product->images->count())
                        <img src="{{ asset($product->images->first()->image_url) }}" class="card-img-top" alt="{{ $product->product_name }}">
                    @endif
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $product->product_name }}</h5>
                        <a href="{{ route('product.show', $product->url) }}" class="btn btn-primary btn-sm">View Product</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>
</body>
</html>
