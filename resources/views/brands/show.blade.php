<!DOCTYPE html>
<html lang="en">
@include('layout/head')

<body>
@include('layout/header')

@section('title', $meta->title ?? $brand->name)
@section('meta_keywords', $meta->keyword ?? '')
@section('meta_description', $meta->description ?? '')

<!--==============================
Breadcrumb
==============================-->

<!-- ======================================
Breadcrumb / Page Header (Brand)
====================================== -->
<section class="section-one">
    <div class="page-img-header" id="about-bg">
        <div class="container">

            {{-- Page Title --}}
            <h1 class="img-header-text fade_down">
                {{ $brand->name }}
            </h1>

            {{-- Breadcrumb --}}
            <div class="breadcrumb-group fade_up">
                <ul class="breadcumb-menu">
                        @foreach($breadcrumb as $item)
                            @if($item['url'])
                                <li><a href="{{ $item['url'] }}">{{ $item['name'] }}</a></li>
                            @else
                                <li class="active">{{ $item['name'] }}</li>
                            @endif
                        @endforeach
                    </ul>
            </div>

            {{-- Brand Image (optional) --}}
            @if($brand->image)
                <div class="mt-3">
                    <img src="/{{ $brand->image }}"
                         alt="{{ $brand->name }}"
                         style="max-height:120px;"
                         loading="lazy"
                         decoding="async">
                </div>
            @endif

        </div>
    </div>
</section>

@include('products.partials.styles')

<section class="shop-section space-top space-extra-bottom">
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
                    <div class="text-muted-sm">{{ $brand->name }}</div>
                </div>

                <div class="loading-overlay" id="productLoading" aria-hidden="true">
                    <div class="spinner-border text-danger" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                <div class="widget-card mb-4">
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        @if($brand->image)
                            <div class="flex-shrink-0">
                                <img src="/{{ $brand->image }}" alt="{{ $brand->name }}" style="width:70px;height:70px;object-fit:contain;">
                            </div>
                        @endif
                        <div class="flex-grow-1">
                            <h3 class="mb-1">{{ $brand->name }}</h3>
                            <p class="mb-0 text-muted">Browse products from {{ $brand->name }}. Use filters or search to find the right item.</p>
                        </div>
                        <form class="d-none d-md-flex" method="GET">
                            <div class="input-group">
                                <input type="text" class="form-control" name="q" placeholder="Search {{ $brand->name }}" value="{{ request('q') }}">
                                <button class="btn btn-dark" type="submit"><i class="fas fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <form class="d-md-none mt-3" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="q" placeholder="Search {{ $brand->name }}" value="{{ request('q') }}">
                            <button class="btn btn-dark" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </form>
                </div>

                <div id="productGrid">
                    @include('products.partials.product-grid', [
                        'products' => $products,
                        'category' => null,
                        'emptyMessage' => 'No products found for this brand.'
                    ])
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
