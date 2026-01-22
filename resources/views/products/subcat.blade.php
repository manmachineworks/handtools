<!DOCTYPE html>
<html lang="en">
@include('layout/head')

<body>

@include('layout/header')

<!--==============================
Breadcrumb
==============================-->

<section class="section-one">
        <div class="page-img-header" id="about-bg">
            <div class="container">
                <h1 class="img-header-text fade_down">{{ $subcategory->name }}</h1>
                <div class="breadcrumb-group fade_up">
                    <ul class="breadcumb-menu">
                        @foreach ($breadcrumb as $item)
                            @if ($item['url'])
                                <li><a href="{{ $item['url'] }}">{{ $item['name'] }}</a></li>
                            @else
                                <li class="active">{{ $item['name'] }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>

@include('products.partials.styles')

<section class="shop-section space-top space-bottom">
    <div class="container">
        <div class="row">

            <!-- Desktop Sidebar -->
            <div class="col-xl-3 col-lg-4 sidebar-widget-area d-none d-lg-block">
                @include('products.partials.sidebar')
            </div>

            <!-- Product Listing -->
            <div class="col-xl-9 col-lg-8 position-relative">

                <!-- Mobile Filter Bar -->
                <div class="mobile-filter-bar d-lg-none">
                    <button class="btn-filter" type="button" id="openFilter">
                        <i class="fas fa-sliders-h"></i> Filters
                    </button>
                    <div class="text-muted-sm">{{ $subcategory->name }}</div>
                </div>

                <div class="loading-overlay" id="productLoading" aria-hidden="true">
                    <div class="spinner-border text-danger" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                <div id="productGrid">
                    @include('products.partials.product-grid', ['products' => $products, 'category' => $subcategory->category])
                </div>

                <div class="pagination-wrapper" id="productPagination">
                    {{ $products->appends(request()->query())->links() }}
                </div>

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
