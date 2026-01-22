<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.include.head')
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        @include('admin.include.sidebar')

        <!-- Content Start -->
        <div class="content">
            @include('admin.include.navbar')

            <!-- Wishlist Start -->
            <div class="container mt-4">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="mb-4">Wishlist</h1>
                    </div>
                </div>
                <div class="accordion" id="wishlistAccordion">
                    @foreach($wishlists as $wishlist)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading{{ $wishlist->id }}">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $wishlist->id }}" aria-expanded="false" aria-controls="collapse{{ $wishlist->id }}">
                                {{ $wishlist->product->product_name ?? 'Product Name Not Available' }}
                            </button>
                        </h2>
                        <div id="collapse{{ $wishlist->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $wishlist->id }}" data-bs-parent="#wishlistAccordion">
                            <div class="accordion-body">
                                <p><strong>User:</strong> {{ $wishlist->user->name ?? 'User Not Available' }}</p>
                                <p><strong>Number:</strong> {{ $wishlist->user->phone  }}</p>
                                <p><strong>Product:</strong> {{ $wishlist->product->product_name ?? 'Product Not Available' }}</p>
                                @if($wishlist->variant)
                                <p><strong>Variant:</strong> {{ $wishlist->variant->variant }}</p>
                                @endif
                                <p><strong>Added On:</strong> {{ $wishlist->created_at->format('d l F Y') }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <!-- Wishlist End -->

            @include('admin.include.footer')
        </div>
        <!-- Content End -->
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>
