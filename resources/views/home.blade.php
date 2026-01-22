<!doctype html>
<html class="no-js" lang="en-IN">
@include('layout/head')

<body>
@include('layout/header')

<!-- ====================================== Section One (Hero) ===================================== -->
<section class="section-one">
    <div class="background-img-slider-SecOne">
        <div class="slider-section">
            <div class="slider-main">
                <img class="service-main-bg" src="/assets/assets/banner/tools_web3.png" alt="slider-imgsec1-img">
                <img class="service-main-bg" src="/assets/assets/banner/tools_web3.png" alt="slider-imgsec1-img2">
                <span class="video-bg-slide">
                    <video autoplay muted loop>
                        <source src="/assets/new_assets/video/video1.mp4" type="video/mp4">
                    </video>
                </span>
            </div>
        </div>

        <div class="container">
            <div class="row sec-one-row">
                <div class="col-xxl-6 col-xl-6 col-lg-9 sec-one-col1 fade_down">
                    <div class="quality-main">
                        <p class="quality">Genuine Tools • Trusted Brands • Fast Support</p>
                    </div>

                    <h1 class="Handyman-main-text">Gurunanak Hand Tools</h1>

                    <h2 class="eget">
                        Hand Tools, Power Tools, Measuring Instruments, Welding Machines & Workshop Essentials —
                        built for strength, engineered for precision, and trusted by professionals across India.
                    </h2>

                    <div class="sec-one-buttons">
                        <a href="{{ url('/contact') }}" class="btn-main btn1">Get A Quote
                            <span class="arrow-section">
                                <img class="arrow" src="/assets/new_assets/images/svg/right-arrow-svg.svg" alt="right-arrow-svg">
                            </span>
                            <div class="btn-box-left"></div>
                            <div class="btn-box-right"></div>
                        </a>

                            <div class="position-relative">
                                <button class="diamond-btn youtube">
                                    <img src="/assets/new_assets/images/svg/play-btn.svg" alt="play-btn">
                                </button>
                                <div class="right-arrow-svg">
                                    <img src="/assets/new_assets/images/svg/dot-arrow-png.svg" alt="dot-arrow-png">
                                    <p class="play-now">Play Now</p>
                                </div>
                            </div>
                    </div>
                </div>

                <div class="col-xxl-6 col-xl-6 col-lg-12 sec-one-col1 fade_down">
                    <img class="sec-oneimg1" src="/assets/assets/banner/11.png" alt="Tools showcase">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ====================================== Section Two (About) ===================================== -->
<section class="section-two">
    <div class="container">
        <div class="quality-main about-qulity-main fade_down">
            <p class="quality">about gurunanak hand tools</p>
        </div>

        <div class="row">
            <div class="col-xxl-6 col-xl-6 col-lg-6">
                

                <div class="about-sec-img-main">
                    <img class="about-sec-img1 img-animation-style1 reveal"
                         src="/assets/new_assets/images/about-page/about1300x420.png" alt="about-sec-img1">
                    <img class="about-sec-img2 img-animation-style2 reveal"
                         src="/assets/new_assets/images/about-page/about22.png" alt="about-sec-img2">
                    <img class="about-sec-img3 img-animation-style6 reveal"
                         src="/assets/new_assets/images/about-page/about_3_300x330.png" alt="about-sec-img3">
                </div>
            </div>

            <div class="col-xxl-6 col-xl-6 col-lg-6">
                <!-- <h3 class="handyman-text fade_down">
                    A trusted partner for industrial tools, workshop supplies & professional-grade equipment
                </h3> -->
                <p class="fusce fade_down">
                    Gurunanak Hand Tools is built around one goal: supplying reliable tools that help professionals
                    work faster, safer, and more accurately. From daily workshop essentials to heavy-duty industrial
                    requirements, we provide a wide range of products backed by trusted brands and dependable support.
                </p>

                <div class="row highQulity-box-row overflow-hidden">
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6">
                        <div class="highQulity-box fade_right">
                            <!--<img src="/assets/new_assets/images/svg/about-sec-svg1.svg" alt="quality">-->
                            <p class="highQulity">Genuine Quality Products</p>
                            <p class="semper">Durable, workshop-tested tools sourced from trusted brands.</p>
                        </div>

                        <div class="highQulity-box highQulity-box2 fade_right">
                            <!--<img src="/assets/new_assets/images/svg/about-sec-svg3.svg" alt="range">-->
                            <p class="highQulity">Wide Category Range</p>
                            <p class="semper">Hand tools, power tools, measuring instruments, welding & more.</p>
                        </div>
                    </div>

                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6">
                        <div class="highQulity-box fade_left">
                            <!--<img src="/assets/new_assets/images/svg/about-sec-svg2.svg" alt="support">-->
                            <p class="highQulity">Professional Support</p>
                            <p class="semper">Help choosing the right tool, brands, and workshop solutions.</p>
                        </div>

                        <div class="highQulity-box highQulity-box2 fade_left">
                            <!--<img src="/assets/new_assets/images/svg/about-sec-svg4.svg" alt="pricing">-->
                            <p class="highQulity">Competitive Pricing</p>
                            <p class="semper">Best value for industrial buyers, workshops, and contractors.</p>
                        </div>
                    </div>

                    <p class="semper blandit">
                        Whether you are a contractor, fabricator, mechanic, technician, or industrial buyer —
                        our catalog is designed to cover every essential requirement with reliable supply and support.
                    </p>

                    <div class="about-sec-contact-main">
                        <a href="{{ url('/about') }}" class="btn-main btn2">Read More
                            <span class="arrow-section">
                                <img class="arrow" src="/assets/new_assets/images/svg/right-arrow-svg.svg" alt="right-arrow-svg">
                            </span>
                            <div class="btn-box-left btn2"></div>
                            <div class="btn-box-right btn2"></div>
                        </a>

                        <div class="contact-box">
                            <div class="headphone-icon">
                                <img src="/assets/new_assets/images/svg/headphone.svg" alt="headphone">
                            </div>
                            <div class="call-info-book">
                                <p>Call For Support</p>
                                <a href="tel:+91XXXXXXXXXX">+91 XXXXXXXXXX</a>
                            </div>
                        </div>
                    </div>

                </div><!-- /row -->
            </div>
        </div>
    </div>
</section>

{{-- ====================================== Section Three (Categories) ===================================== --}}
@if(isset($categories) && $categories->count())
<section class="section-three">
    <div class="container">
        <div class="row justify-content-between align-items-end">
            <div class="col">
                <div class="quality-main about-qulity-main fade_down">
                    <p class="quality">Categories</p>
                </div>

                <div class="handyman-services-textMain">
                    <h2 class="handyman-text handyman-services fade_down">Browse Our Categories</h2>
                    <p class="fusce malesuada fade_down mt-0">
                        Find the right tool for every job — explore our most popular categories and shop with confidence.
                    </p>
                </div>
            </div>

            <div class="col-sm-auto">
                <div class="icon-box">
                    <button data-slick-prev=".services_slider" class="slick-arrow default" aria-label="Previous category">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <button data-slick-next=".services_slider" class="slick-arrow default" aria-label="Next category">
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="services_slider">
            @foreach($categories as $category)
                <a href="{{ route('category.show', $category->slug) }}">
                    <div class="services-slider-box">
                        <img class="services-icon"
                             src="{{ asset($category->cat_image) }}"
                             alt="{{ $category->name }}"
                             loading="lazy"
                             decoding="async">

                        <div class="services-icon-box">
                            <!--<img class="plumbing"-->
                            <!--     src="/assets/new_assets/images/svg/welding.svg"-->
                            <!--     alt="{{ $category->name }} icon">-->

                            <h2 class="services-solution-main-text">{{ $category->name }}</h2>

                            <p class="aliquam-text">
                                {{ \Illuminate\Support\Str::limit(strip_tags($category->cat_text ?? 'Explore products in this category.'), 90) }}
                            </p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<div class="View-btn-sec">
    <div class="container">
        <div class="View-btn-sec-btn-main">
            <a href="{{ url('/categories') }}" class="btn-main btn2">
                View All Categories
                <span class="arrow-section">
                    <img class="arrow" src="/assets/new_assets/images/svg/right-arrow-svg.svg" alt="right-arrow-svg">
                </span>
                <div class="btn-box-left btn2"></div>
                <div class="btn-box-right btn2"></div>
            </a>
        </div>
    </div>
</div>
@endif
<!--==============================
    Portfolio Area (products slider)
==============================-->
@php $hasProducts = isset($productsn) && count($productsn) > 0; @endphp
<section class="portfolio-area-1 space overflow-hidden">
    <div class="container">
        <div class="row justify-content-between align-items-end">
            <div class="col-xl-5 col-lg-6">
                <div class="title-area">
                    <span class="sub-title">Our products</span>
                    <h2 class="sec-title">
                        Our Wide Range Of Products
                        <img class="title-bg-shape" src="/assets/assets/img/bg/title-bg-shape.avif" loading="lazy" decoding="async" alt="Products">
                    </h2>
                </div>
            </div>
            @if($hasProducts)
                <div class="col-sm-auto">
                    <div class="title-area">
                        <div class="icon-box">
                            <button data-slick-prev=".portfolio-slider1" class="slick-arrow default" aria-label="Previous products">
                                <i class="fas fa-arrow-left"></i>
                            </button>
                            <button data-slick-next=".portfolio-slider1" class="slick-arrow default" aria-label="Next products">
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if($hasProducts)
        <div class="container-fluid p-0">
            <div class="row global-carousel gx-30 portfolio-slider1"
                 data-slide-show="3"
                 data-lg-slide-show="2"
                 data-md-slide-show="2"
                 data-sm-slide-show="1"
                 data-xs-slide-show="1"
                 data-center-mode="true"
                 data-xl-center-mode="true"
                 data-ml-center-mode="true"
                 data-lg-center-mode="true"
                 data-center-padding="150px"
                 data-xl-center-padding="100px"
                 data-ml-center-padding="80px"
                 data-lg-center-padding="60px"
                 data-md-center-padding="40px"
                 data-sm-center-padding="30px">

                @foreach($productsn as $product)
                    <div class="col-lg-6 ">
                        <div class="portfolio-card style2">
                            <div class="portfolio-card-thumb">
                                @php
                                    $categorySlug = data_get($product, 'subcategory.category.slug', 'general');
                                    $subcategorySlug = data_get($product, 'subcategory.slug', 'general');
                                    $productLink = route('content.show', [
                                        'category' => $categorySlug,
                                        'subcategory' => $subcategorySlug,
                                        'url' => data_get($product, 'url', 'product')
                                    ]);
                                    $imagePath = asset(optional($product->images->first())->image_url ?? 'assets/assets/img/logo-colored.png');
                                @endphp

                                <a href="{{ $productLink }}">
                                    <img src="{{ $imagePath }}"
                                         loading="lazy"
                                         decoding="async"
                                         alt="{{ $product->product_name ?? 'Product image' }}"
                                         width="400"
                                         height="400">
                                </a>
                            </div>

                            <div class="portfolio-card-details">
                                <div class="media-left">
                                    @php
                                        $subcategoryName = data_get($product, 'subcategory.name', 'General');
                                        $brandName = data_get($product, 'brand.name');
                                    @endphp
                                    <h3 class="portfolio-card-details_title clamp-titlee2">{{ $product->product_name ?? 'Product' }}</h3>
                                    <span class="portfolio-card-details_subtitle">
                                        {{ $brandName ? $brandName . ' • ' : '' }}{{ $subcategoryName }}
                                    </span>
                                </div>

                                <a href="{{ $productLink }}" class="icon-btn" aria-label="View {{ $product->product_name }}">
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    @else
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="portfolio-card style2">
                        <div class="portfolio-card-details">
                            <div class="media-left">
                                <h3 class="portfolio-card-details_title">Products coming soon</h3>
                                <span class="portfolio-card-details_subtitle">We are updating our catalog. Reach out for a tailored quote.</span>
                            </div>
                            <a href="{{ url('/contact') }}" class="icon-btn" aria-label="Contact us for products">
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</section>

{{-- ===================== TOOL WHEEL (layout unchanged; content updated placeholder) ===================== --}}
<style>
.tool-wheel{ position: relative; width: 560px; height: 560px; margin: 0 auto 60px;  }
.tool-wheel .circle-item{ position: absolute; inset: 0; animation: wheel-spin 38s linear infinite; }
.tool-wheel .circle-item > li{ position: absolute; left: 50%; top: 50%; transform-origin: 0 0; }
.tool-wheel .circle-item > li:nth-child(1){ transform: rotate(0deg) translate(16em); }
.tool-wheel .circle-item > li:nth-child(2){ transform: rotate(45deg) translate(16em); }
.tool-wheel .circle-item > li:nth-child(3){ transform: rotate(90deg) translate(16em); }
.tool-wheel .circle-item > li:nth-child(4){ transform: rotate(135deg) translate(16em); }
.tool-wheel .circle-item > li:nth-child(5){ transform: rotate(180deg) translate(16em); }
.tool-wheel .circle-item > li:nth-child(6){ transform: rotate(225deg) translate(16em); }
.tool-wheel .circle-item > li:nth-child(7){ transform: rotate(270deg) translate(16em); }
.tool-wheel .circle-item > li:nth-child(8){ transform: rotate(315deg) translate(16em); }
.tool-wheel .circle-item > li.last{ left: 50%; top: 50%; transform: translate(-50%, -50%) !important; animation: none !important; z-index: -5; }
@keyframes wheel-spin{ from{ transform: rotate(0deg);} to{ transform: rotate(360deg);} }
@media (max-width: 991px){ .tool-wheel{ width: 420px; height: 420px;} }
@media (max-width: 575px){ .tool-wheel{ width: 320px; height: 320px;} }
</style>


<!-- ====================================== Section Four (Request Quote) ===================================== -->
<section class="section-four space">
    <div class="container">
        <div class="row">
            <div class="col-xxl-6 col-xl-6 col-lg-6" style="z-index: 1;">
                <div class="quality-main about-qulity-main fade_down">
                    <p class="quality">get free estimate</p>
                </div>
                <h2 class="handyman-text fade_down">Request a quote</h2>
                <p class="fusce fade_down mt-0">
                    Tell us what tools you need — we’ll help you with pricing, availability, and delivery timelines.
                </p>

                <form class="req-form-main" method="post" action="{{ url('/enquiry') }}">
                    @csrf
                    <div class="input-main">
                        <input type="text" placeholder="Your Name*" name="name" required>
                        <input type="email" placeholder="Email ID*" name="email" required>
                    </div>
                    <div class="input-main">
                        <input type="text" placeholder="Phone Number*" name="phone" required>

                        <div class="wrapper">
                            <div class="formDropDown">Choose Category*
                                <img class="arrow-icon-form" src="/assets/new_assets/images/svg/down-arrow.svg" alt="arrow-icon-form">
                            </div>

                            <div class="position-relative">
                                <ul class="formDropDown-ul-list">
                                    <li><a href="javascript:void(0)">Hand Tools & Tool Kits</a></li>
                                    <li><a href="javascript:void(0)">Power Tools & Machinery</a></li>
                                    <li><a href="javascript:void(0)">Measuring Instruments</a></li>
                                    <li><a href="javascript:void(0)">Welding Machines & Accessories</a></li>
                                    <li><a href="javascript:void(0)">Cutting & Abrasive Tools</a></li>
                                    <li><a href="javascript:void(0)">Industrial Tools & Workshop Equipment</a></li>
                                    <li><a href="javascript:void(0)">Tool Storage</a></li>
                                    <li><a href="javascript:void(0)">Construction Equipment</a></li>
                                    <li><a href="javascript:void(0)">Garden & Outdoor Tools</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="input-main">
                        <input type="text" placeholder="Your Message*" name="message" required>
                    </div>

                    <div class="Submit">
                        <button type="submit" class="btn-main btn2">
                            Submit
                            <span class="arrow-section">
                                <img class="arrow" src="/assets/new_assets/images/svg/right-arrow-svg.svg" alt="right-arrow-svg">
                            </span>
                            <div class="btn-box-left btn2"></div>
                            <div class="btn-box-right btn2"></div>
                        </button>
                    </div>
                </form>
            </div>

          <!-- Tool Wheel -->
        <div class="tool-wheel-wrapper col-xxl-6 col-xl-6 col-lg-6 position-relative request-qoute-img-main">
            <div class="tool-wheel">
                <ul class="circle-item">

                    <!-- Tool 1 -->
                    <li title="Hook Wrench">
                        <a href="#">
                            <img src="https://deneerstools.com/wp-content/uploads/2020/06/Hook-wrench-300x300.png"
                                 alt="Hook Wrench"
                                 width="151"
                                 height="151"
                                 loading="lazy">
                        </a>
                    </li>

                    <!-- Tool 2 -->
                    <li title="Bucket Grease Pump with Trolley">
                        <a href="#">
                            <img src="https://deneerstools.com/wp-content/uploads/2020/06/Bucket-grass-pump-with-trolly-300x300.png"
                                 alt="Bucket Grease Pump with Trolley"
                                 width="154"
                                 height="154"
                                 loading="lazy">
                        </a>
                    </li>

                    <!-- Tool 3 -->
                    <li title="Water Pump Plier Box Joint">
                        <a href="#">
                            <img src="https://deneerstools.com/wp-content/uploads/2020/06/Water-pump-plier-box-joint-300x300.png"
                                 alt="Water Pump Plier"
                                 width="153"
                                 height="153"
                                 loading="lazy">
                        </a>
                    </li>

                    <!-- Tool 4 -->
                    <li title="Torque Wrench">
                        <a href="#">
                            <img src="https://deneerstools.com/wp-content/uploads/2020/06/Torque-wrench-300x300.png"
                                 alt="Torque Wrench"
                                 width="150"
                                 height="150"
                                 loading="lazy">
                        </a>
                    </li>

                    <!-- Tool 5 -->
                    <li title="Flat File (Bastard)">
                        <a href="#">
                            <img src="https://deneerstools.com/wp-content/uploads/2020/06/mini-flat-file.png"
                                 alt="Flat File"
                                 width="142"
                                 height="142"
                                 loading="lazy">
                        </a>
                    </li>

                    <!-- Tool 6 -->
                    <li title="Bolt Cutter">
                        <a href="#">
                            <img src="https://deneerstools.com/wp-content/uploads/2020/06/Bolt-Cutter-300x300.png"
                                 alt="Bolt Cutter"
                                 width="157"
                                 height="157"
                                 loading="lazy">
                        </a>
                    </li>

                    <!-- Tool 7 -->
                    <li title="Pipe Bender">
                        <a href="#">
                            <img src="https://deneerstools.com/wp-content/uploads/2020/06/Pipe-bender-300x300.png"
                                 alt="Pipe Bender"
                                 width="157"
                                 height="157"
                                 loading="lazy">
                        </a>
                    </li>

                    <!-- Tool 8 -->
                    <li title="Four Way Wheel Spanner">
                        <a href="#">
                            <img src="https://deneerstools.com/wp-content/uploads/2020/06/6.png"
                                 alt="Four Way Wheel Spanner"
                                 width="155"
                                 height="155"
                                 loading="lazy">
                        </a>
                    </li>

                    <!-- Center Logo -->
                    <li class="last" title="Trusted Tool Solutions">
                        <div class="center-logo">
                            <img src="/assets/new_assets/images/svg/parts-img1x1.png"
                                 alt="Brand Logo"
                                 loading="lazy">
                        </div>

                        <!-- Decorative Ring -->
                        <div class="circleEffect rotate">
                            <svg viewBox="0 0 862 846">
                                <defs>
                                    <linearGradient id="SVGID_1_" gradientUnits="userSpaceOnUse"
                                        x1="355.55" y1="217.5" x2="844.86" y2="217.5">
                                        <stop offset="0" stop-color="#ff5805"/>
                                        <stop offset="1" stop-color="#ff5805"/>
                                    </linearGradient>
                                </defs>
                                <path d="M834.3 419c-5.7 0-10.4-4.5-10.6-10.3
                                         C816.2 192.8 638.8 20 421 20
                                         c-22.3 0-44.2 1.8-65.5 5.3
                                         27.9-6.1 56.8-9.3 86.5-9.3
                                         218.9 0 397.1 174.6 402.9 392.1
                                         .1 6-4.6 10.9-10.6 10.9z"
                                      fill="url(#SVGID_1_)"/>
                                <circle cx="421" cy="423" r="403" fill="none"/>
                            </svg>
                        </div>

                        <div class="animation-circle-inverse color_1">
                            <i></i><i></i><i></i>
                        </div>
                    </li>

                </ul>
            </div>
        </div>
        </div>
    </div>
</section>



<!-- ====================================== Section Five (Process) ===================================== -->
<section class="section-five">
    <div class="container">
        <div class="quality-main ourProcess fade_down">
            <p class="quality">our process</p>
        </div>

        <h2 class="handyman-text quick fade_down">Easy quick ordering steps</h2>

        <p class="fusce malesuada elementum fade_down">
            From enquiry to delivery — we keep the process simple and fast for workshops and industrial buyers.
        </p>

        <div class="row step-box-row">
            <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6">
                <div class="steps-box-main flip_left">
                    <div class="number-circel">1</div>
                    <div class="steps-box">
                        <div class="register-img-main">
                            <img class="register" src="/assets/new_assets/images/svg/register.svg" alt="register">
                        </div>
                        <h2 class="Register-text">Share Your Requirement</h2>
                        <p class="proin">Send product list, brand preference, quantities, and delivery location.</p>
                    </div>
                </div>
            </div>

            <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6">
                <div class="steps-box-main flip_left">
                    <div class="number-circel">2</div>
                    <div class="steps-box">
                        <div class="register-img-main">
                            <img class="register" src="/assets/new_assets/images/svg/inspect.svg" alt="inspect">
                        </div>
                        <h2 class="Register-text">We Suggest & Confirm</h2>
                        <p class="proin">We confirm availability, alternatives, best-fit models, and pricing.</p>
                    </div>
                </div>
            </div>

            <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6">
                <div class="steps-box-main flip_left">
                    <div class="number-circel">3</div>
                    <div class="steps-box">
                        <div class="register-img-main">
                            <img class="register" src="/assets/new_assets/images/svg/workProcess.svg" alt="workProcess">
                        </div>
                        <h2 class="Register-text">Packing & Dispatch</h2>
                        <p class="proin">Orders are processed quickly with safe packaging and dispatch support.</p>
                    </div>
                </div>
            </div>

            <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6">
                <div class="steps-box-main flip_left">
                    <div class="number-circel">4</div>
                    <div class="steps-box">
                        <div class="register-img-main">
                            <img class="register" src="/assets/new_assets/images/svg/handover.svg" alt="handover">
                        </div>
                        <h2 class="Register-text">Delivery & Support</h2>
                        <p class="proin">We assist with delivery tracking and support for repeat requirements.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ====================================== Section Six ===================================== -->
<section class="section-six">
    <div class="container">
        <div class="row">
            <div class="col-xxl-4 col-xl-4 col-lg-4">
                <div class="quality-main about-qulity-main fade_down">
                    <p class="quality">featured collections</p>
                </div>

                <h2 class="handyman-text fade_down">Explore our best-selling tool ranges</h2>

                <p class="fusce fade_down">
                    Discover hand-picked products trusted by workshops, contractors, and industrial professionals.
                    From precision tools to heavy-duty machines — built to perform every day.
                </p>

                <div class="Submit seemore-btn-main">
                    <a href="/shop" class="btn-main btn2">See More
                        <span class="arrow-section">
                            <img class="arrow" src="/assets/new_assets/images/svg/right-arrow-svg.svg" alt="right-arrow-svg">
                        </span>
                        <div class="btn-box-left btn2"></div>
                        <div class="btn-box-right btn2"></div>
                    </a>
                </div>
            </div>

            <div class="col-xxl-8 col-xl-8 col-lg-8">
                <div class="img-group-estimate-main">

                    <!-- Card 1 -->
                    <div class="img-wrapper">
                        <img class="estimate-img img-animation-style1 reveal"
                             src="/assets/new_assets/images/home-page/estimate-img12.jpg" alt="Best Selling Hand Tools">
                        <div class="overlay"></div>
                        <div class="overlay-text">
                            <p>Hand Tools & Tool Kits</p>
                            <a class="view-details-btn" href="/hand-tools">View Details
                                <img src="/assets/new_assets/images/svg/arrow-cross.svg" alt="arrow-cross">
                            </a>
                        </div>
                    </div>

                    <div class="img-group-estimate2">

                        <!-- Card 2 -->
                        <div class="img-wrapper">
                            <img class="img-animation-style4 reveal"
                                 src="/assets/new_assets/images/home-page/estimate-img22.jpg" alt="Power Tools & Machinery">
                            <div class="overlay"></div>
                            <div class="overlay-text">
                                <p>Power Tools & Machinery</p>
                                <a class="view-details-btn" href="/power-tools">View Details
                                    <img src="/assets/new_assets/images/svg/arrow-cross.svg" alt="arrow-cross">
                                </a>
                            </div>
                        </div>

                        <!-- Card 3 -->
                        <div class="img-wrapper">
                            <img class="img-animation-style2 reveal"
                                 src="/assets/new_assets/images/home-page/estimate-img33.jpg" alt="Welding & Workshop Solutions">
                            <div class="overlay"></div>
                            <div class="overlay-text">
                                <p>Welding & Workshop Essentials</p>
                                <a class="view-details-btn" href="/welding-machines">View Details
                                    <img src="/assets/new_assets/images/svg/arrow-cross.svg" alt="arrow-cross">
                                </a>
                            </div>
                        </div>

                    </div><!-- /img-group-estimate2 -->
                </div><!-- /img-group-estimate-main -->
            </div>
        </div>
    </div>
</section>

<!-- ====================================== Section Seven (CTA) ===================================== -->
<section class="section-seven">
    <div class="container">
        <div class="free-contact-sec-main">
            <div>
                <div class="quality-main about-qulity-main fade_down">
                    <p class="quality">feel free to contact</p>
                </div>
                <h2 class="handyman-text premium-handyman fade_down">
                    Need tools for your workshop or project?
                </h2>
            </div>

            <a href="{{ url('/contact') }}" class="btn-main btn1">Get A Quote
                <span class="arrow-section">
                    <img class="arrow" src="/assets/new_assets/images/svg/right-arrow-svg.svg" alt="right-arrow-svg">
                </span>
                <div class="btn-box-left btn1"></div>
                <div class="btn-box-right btn1"></div>
            </a>
        </div>
    </div>
</section>

{{-- ============================ BLOG (content updated, layout unchanged) ============================ --}}
@if(isset($latestBlogs) && $latestBlogs->count())
<section class="blog-area space">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="title-area text-center">
                    <span class="sub-title">Blog</span>
                    <h2 class="sec-title">Latest Tool Guides & Workshop Tips</h2>
                </div>
            </div>
        </div>

        <div class="row global-carousel blog-slider slider-shadow"
             data-slide-show="3"
             data-lg-slide-show="2"
             data-md-slide-show="1"
             data-sm-slide-show="1"
             data-xs-slide-show="1"
             data-dots="false">

            @foreach($latestBlogs as $blog)
                <div class="col-md-6 col-lg-4">
                    <div class="blog-card style2">
                        <div class="blog-img">
                            <a href="{{ url('/blog/' . $blog->url) }}">
                                <img src="{{ asset($blog->blog_image) }}"
                                     loading="lazy"
                                     decoding="async"
                                     alt="{{ $blog->blog_title }}"
                                     width="410"
                                     height="300">
                            </a>
                        </div>

                        <div class="blog-content">
                            <div class="blog-meta">
                                <a href="{{ url('/blog/' . $blog->url) }}"><i class="fas fa-user"></i> By admin</a>
                                <a href="{{ url('/blog/' . $blog->url) }}">
                                    <i class="fas fa-calendar"></i>
                                    <span>{{ \Carbon\Carbon::parse($blog->date)->format('d') }}</span>
                                    {{ \Carbon\Carbon::parse($blog->date)->format('F') }}
                                </a>
                            </div>
                              <h3 class="blog-title clamp-titlee2" style="font-size:20px;">
                                <a class="blog-box" href="{{ url('/blog/' . $blog->url) }}">{{ $blog->blog_title }}</a>
                            </h3>


                            <a class="link-btn style3" href="{{ url('/blog/' . $blog->url) }}">
                                Read More <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>

                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>
@endif

<!-- ====================================== FAQ SECTION (content updated, layout unchanged) ===================================== -->
<section class="installation-section">
    <div class="container">
        <div class="row faq-sec-Row">
            <div class="col-xxl-6 col-xl-6 col-lg-6 installation-img-group">
                <img class="installation-img1 img-animation-style4 reveal"
                     src="/assets/new_assets/images/home-page/parts-img.png" alt="installation-img1">
                <img class="installation-img2 img-animation-style2 reveal"
                     src="/assets/new_assets/images/svg/installation-img2.jpg" alt="installation-img2">
                <div class="yerOfExperi">
                    <h2>25+</h2>
                    <p>Years of Experience</p>
                </div>
            </div>

            <div class="col-xxl-6 col-xl-6 col-lg-6">
                <div class="quality-main about-qulity-main fade_down">
                    <p class="quality">SUPPORT & HELP</p>
                </div>

                <h2 class="handyman-text fade_down">Frequently asked questions</h2>

                <p class="fusce fade_down">
                    Quick answers about products, brands, ordering, and delivery.
                </p>

                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Do you sell genuine branded tools?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                             data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Yes. We focus on reliable brands and genuine supply for professional and industrial use.
                                If you need a specific model, share the code and we’ll confirm availability.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Can I get bulk pricing for workshops and industrial orders?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                             data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Yes. We support bulk enquiries and repeat procurement. Send your requirement list and
                                quantities — we’ll share the best quote and alternatives if needed.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                What categories do you offer?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                             data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Hand Tools, Power Tools, Measuring Instruments, Welding Machines & Accessories,
                                Cutting & Abrasives, Tool Storage, Construction Equipment, and Workshop Essentials.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                How fast is delivery?
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                             data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Delivery depends on product availability and location. After order confirmation, we
                                share dispatch timeline and tracking details.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFive">
                            <button class="accordion-button collapsed mb-0" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                Do you help in selecting the right product?
                            </button>
                        </h2>
                        <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                             data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Yes. Share your application (work type, material, usage frequency), and we’ll recommend
                                suitable models, brands, and accessories.
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

</main>

@include('layout/footer')
</body>
</html>
