<!DOCTYPE html>
<html lang="en">
@include('layout/head')

<body>
@include('layout/header')

@section('title', $meta->title ?? 'All Categories')
@section('meta_keywords', $meta->keyword ?? '')
@section('meta_description', $meta->description ?? '')
<!-- ====================================== Section One ===================================== -->
<section class="section-one">
    <div class="page-img-header" id="services-bg">
        <div class="container">
            <h1 class="img-header-text fade_down">Our Categories</h1>
            <div class="breadcrumb-group fade_up">
                <a href="{{ url('/') }}">HOME / </a>
                <a href="javascript:void(0)"> ALL CATEGORIES</a>
            </div>
        </div>
    </div>
</section>

<!-- ====================================== Section Eight ===================================== -->
<section class="section-eight" id="services-page-section">
    <div class="container">
        <div class="quality-main about-qulity-main fade_down">
            <p class="quality">our categories</p>
        </div>

        <div class="handyman-services-textMain">
            <h2 class="handyman-text handyman-services services-page-text fade_down">
                Browse all product categories
            </h2>
            <p class="fusce malesuada tellus fade_down mt-0">
                Explore our complete range of tools and accessories. Choose a category to view available products.
            </p>
        </div>

        <div class="row services-page-row">

            @forelse($categories as $category)
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 services-page-col">
                    <a href="{{ route('category.show', $category->slug) }}">
                        <div class="services-slider-box">
                            <img class="services-icon"
                                 src="{{ asset($category->cat_image ?: 'assets/assets/img/logo-colored.png') }}"
                                 alt="{{ $category->name }}"
                                 loading="lazy"
                                 decoding="async">

                            <div class="services-icon-box">
                                <!-- keep same icon (no change in layout) -->
                                <img class="plumbing" src="/assets/new_assets/images/svg/plumbing.svg" alt="{{ $category->name }}">

                                <h2 class="services-solution-main-text">{{ $category->name }}</h2>

                                <p class="aliquam-text">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($category->cat_text ?? 'Explore products in this category.'), 90) }}
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="mb-0">No categories available right now.</p>
                </div>
            @endforelse

        </div>
    </div>
</section>


@include('layout/footer')
</body>
</html>
