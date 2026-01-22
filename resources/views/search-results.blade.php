<!DOCTYPE html>
<html lang="en">
@include('layout/head')

<body>

@include('layout/header')

<!--==============================
Breadcrumb
==============================-->
<div class="breadcumb-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="breadcumb-content">
                    <h1 class="breadcumb-title">Search</h1>
                    <ul class="breadcumb-menu">
                        <li><a href="/">Home</a></li>
                        <li class="active">Products</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 d-lg-block d-none">
                <div class="breadcumb-thumb">
                    <img src="/assets/assets/img/bg/banner-2.jpg" loading="lazy" decoding="async" alt="Product search banner">
                </div>            
            </div>
        </div>
    </div>
</div>

@include('products.partials.styles')

<section class="shop-section space-top space-extra-bottom">
    <div class="container">
        <div class="row flex-row-reverse">
            <!-- Product Listing -->
            <div class="col-xl-9 col-lg-8 position-relative">

                <!-- Mobile Filter Bar -->
                <div class="mobile-filter-bar d-lg-none">
                    <button class="btn-filter" type="button" id="openFilter">
                        <i class="fas fa-sliders-h"></i> Filters
                    </button>
                    @if(isset($query))
                        <div class="text-muted-sm">Results for "{{ $query }}"</div>
                    @endif
                </div>

                <div class="loading-overlay" id="productLoading" aria-hidden="true">
                    <div class="spinner-border text-danger" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                @if(isset($query))
                    <p class="mb-4">Showing results for: <strong>{{ $query }}</strong></p>
                @endif

                <div id="productGrid">
                    @include('products.partials.product-grid', ['products' => $products, 'category' => null])
                </div>

                <div class="pagination-wrapper" id="productPagination">
                    {{ $products->appends(request()->query())->links() }}
                </div>

                @if(!$products->count())
                    <div class="alert alert-warning mt-4">
                        No products found for "<strong>{{ $query }}</strong>".
                    </div>
                @endif

            </div>

            <!-- Sidebar -->
            <div class="col-xl-3 col-lg-4 sidebar-widget-area">
                @include('products.partials.sidebar')
            </div>
        </div>
    </div>
</section>

<!-- Mobile offcanvas -->
<div class="offcanvas-backdrop" id="filterBackdrop" aria-hidden="true"></div>
<div class="sidebar-offcanvas d-lg-none" id="filterPanel" role="dialog" aria-modal="true" aria-label="Filters">
    <div class="offcanvas-head">
        <h3 class="offcanvas-title">Filters</h3>
        <button class="offcanvas-close" type="button" id="closeFilter" aria-label="Close filters">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @include('products.partials.sidebar')
</div>

@include('products.partials.scripts')

@include('layout/footer')
  
</body>

</html>
