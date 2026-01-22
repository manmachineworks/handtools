@php use Illuminate\Support\Str; @endphp

<aside class="sidebar-area sidebar-shop sidebar-sticky">

    <!-- Search -->
    <div class="widget_search widget-card mb-4">
        <div class="widget-head">
            <h3 class="widget_title mb-0">Product Search</h3>
        </div>

        <form class="search-form modern-search" method="GET" action="{{ route('search.products') }}">
            <div class="search-input-wrap">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search product name…"
                    aria-label="Search product">
                <button type="submit" aria-label="Search">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>

        @if(request('q'))
            <a class="clear-search" href="{{ url()->current() }}">Clear search</a>
        @endif
    </div>

    <!-- Categories -->
    <div class="widget_categories widget-card">
        <div class="widget-head">
            <h3 class="widget_title mb-0">Categories</h3>
        </div>

        @if(isset($categoriesTree) && $categoriesTree->count())
            <div class="category-accordion modern-accordion" id="categoryAccordion">
                @foreach($categoriesTree as $cat)
                    @php
                        $isActiveCategory = isset($activeCategorySlug) && $activeCategorySlug === $cat->slug;
                        $isActiveSubcategory = isset($activeSubcategorySlug) && $cat->subcategories->contains(function ($sub) use ($activeSubcategorySlug) {
                            return $sub->slug === $activeSubcategorySlug;
                        });
                        $shouldExpand = $isActiveCategory || $isActiveSubcategory;
                    @endphp

                    <div class="category-group {{ $shouldExpand ? 'is-open' : '' }}">
                        <button class="category-toggle" type="button" aria-expanded="{{ $shouldExpand ? 'true' : 'false' }}"
                            aria-controls="cat-{{ $cat->id }}">
                            <span class="cat-name" title="{{ $cat->name }}">{{ Str::limit($cat->name, 18) }}</span>
                            <span class="chev" aria-hidden="true"><i class="fas fa-chevron-down"></i></span>
                        </button>

                        <ul id="cat-{{ $cat->id }}" class="subcategory-list {{ $shouldExpand ? 'show' : '' }}">
                            <li class="{{ $isActiveCategory && !$isActiveSubcategory ? 'active' : '' }}">
                                <a class="ajax-category-link" data-ajax="true" href="{{ route('category.show', $cat->slug) }}">
                                    <span title="{{ $cat->name }}">All {{ Str::limit($cat->name, 16) }}</span>
                                    <span class="pill">View</span>
                                </a>
                            </li>

                            @foreach($cat->subcategories as $sub)
                                <li
                                    class="{{ isset($activeSubcategorySlug) && $activeSubcategorySlug === $sub->slug ? 'active' : '' }}">
                                    <a class="subcategory-link"
                                        data-ajax="{{ $cat->slug === ($activeCategorySlug ?? '') ? 'true' : 'false' }}"
                                        href="{{ route('subcategory.show', [$cat->slug, $sub->slug]) }}">
                                        <span title="{{ $sub->name }}">{{ Str::limit($sub->name, 18) }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        @else
            <p class="mb-0">No categories available.</p>
        @endif
    </div>


    {{-- KEEP these sections as-is (no change) --}}
    <div class="ad-box">
        <img src="/assets/new_assets/images/svg/logo.png" alt="footer-logo">
        <h3 class="frist-services">Reach Out & Connect with Gurunanak</h3>
        <div class="testimonials-btn mt-0" id="ad-btn">
            <a href="contact" class="btn-main btn1">Contact Us
                <span class="arrow-section">
                    <img class="arrow" src="/assets/new_assets/images/svg/right-arrow-svg.svg" alt="right-arrow-svg">
                </span>
                <div class="btn-box-left btn1"></div>
                <div class="btn-box-right btn1"></div>
            </a>
        </div>
        <img class="plumbing-services-img5" src="/assets/new_assets/images/services-page/plumbing-services-img5.png"
            alt="plumbing-services-img5">
    </div>

    <!-- <div class="documents-box">
        <a href="#" class="brochure-main">
            <div class="brochure">
                <img src="/assets/new_assets/images/svg/brochure.svg" alt="brochure">
            </div>
            <h3>Download Brochure</h3>
        </a>
        <a href="#" class="brochure-main mb-0">
            <div class="brochure">
                <img src="/assets/new_assets/images/svg/brochure2.svg" alt="brochure2">
            </div>
            <h3>Download Company Profile</h3>
        </a>
    </div> -->

</aside>