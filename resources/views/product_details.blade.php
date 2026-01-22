<!DOCTYPE html>
<html lang="en">

@include('layout/head')

<body>
    @include('layout/header')
    
       <!--==============================
    Breadcumb
    ============================== -->
   
     <section class="section-one">
        <div class="page-img-header" id="about-bg">
            <div class="container">
                <h1 class="img-header-text fade_down">Product Details</h1>
                @if(!empty($breadcrumb))
                            <nav aria-label="breadcrumb">
                                <ul class="breadcumb-menu">
                                    @foreach($breadcrumb as $item)
                                        @if($loop->last)
                                            <li class="breadcrumb-item active" aria-current="page">{{ $item['name'] }}</li>
                                        @else
                                            <li class="breadcrumb-item">
                                                <a href="{{ $item['url'] }}">{{ $item['name'] }}</a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </nav>
                        @endif
            </div>
        </div>
    </section>

<style>
    :root {
        --brand-primary: #ff5805;
        --brand-primary-dark: #e64d04;
        --brand-secondary: #28353d;
        --brand-accent: #f37413;
        --brand-tint: #ffe3d2;
        --brand-surface: #ffffff;
        --text-main: #1f2933;
        --text-muted: #6b7280;
        --border: #e5e7eb;
    }

    .left-column {
        overflow: hidden;
    }

    .page-content {
        padding: 50px 0;
        background: radial-gradient(circle at 10% 20%, rgba(255, 200, 170, 0.15), transparent 35%), #fdf7f2;
    }

    .grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 30px;
    }

    @media (min-width: 768px) {
        .grid {
            grid-template-columns: 1.5fr 1fr;
        }
    }

    .product-title {
        font-family: 'Poppins', sans-serif;
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 12px;
        color: var(--brand-secondary);
        letter-spacing: -0.02em;
    }

    .product-location {
        display: flex;
        align-items: center;
        color: var(--text-muted);
        margin-bottom: 20px;
        font-size: 16px;
        gap: 6px;
    }

    .product-location i {
        color: var(--brand-primary);
    }

    .gallery-container {
        position: relative;
        margin-bottom: 30px;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 15px 45px rgba(40, 53, 61, 0.15);
        background: var(--brand-surface);
        border: 1px solid var(--border);
    }

    .main-slideshow {
        position: relative;
        height: 420px;
        background: linear-gradient(135deg, #fff, #fff6ef);
        border-radius: 12px;
        overflow: hidden;
    }

    .slide {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        transition: opacity 0.5s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .slide.active {
        opacity: 1;
    }

    .slide img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        background-color: var(--brand-surface);
    }

    .slide-controls {
        position: absolute;
        top: 50%;
        width: 100%;
        display: flex;
        justify-content: space-between;
        padding: 0 15px;
        transform: translateY(-50%);
        pointer-events: none;
    }

    .slide-controls button {
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid var(--border);
        width: 44px;
        height: 44px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        pointer-events: auto;
        color: var(--brand-secondary);
    }

    .slide-controls button:hover {
        background: var(--brand-primary);
        color: #fff;
        border-color: transparent;
        transform: translateY(-1px);
    }

    .thumbnails {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 10px;
        margin: 18px 18px 22px;
    }

    .thumbnail {
        height: 80px;
        border: 2px solid transparent;
        border-radius: 10px;
        overflow: hidden;
        cursor: pointer;
        transition: all 0.3s ease;
        background: #fff;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.04);
    }

    .thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .thumbnail.active,
    .thumbnail:hover {
        border-color: var(--brand-primary);
        box-shadow: 0 12px 30px rgba(255, 88, 5, 0.25);
    }

    .section-title {
        margin-bottom: 20px;
        position: relative;
        padding-bottom: 10px;
    }

    .section-title h2 {
        font-family: 'Poppins', sans-serif;
        font-size: 24px;
        font-weight: 700;
        color: var(--brand-secondary);
    }

    .product-description {
        background: var(--brand-surface);
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 15px 40px rgba(40, 53, 61, 0.12);
        margin-bottom: 30px;
        border: 1px solid var(--border);
        color: var(--text-main);
    }

    .product-description p {
        margin-bottom: 15px;
        color: var(--text-muted);
        line-height: 1.7;
    }

    .order-box {
        background: var(--brand-surface);
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 15px 40px rgba(40, 53, 61, 0.12);
        position: sticky;
        top: 100px;
        border: 1px solid var(--border);
    }

    .order-box ul {
        list-style: none;
        margin-bottom: 25px;
    }

    .order-box ul li {
        padding: 12px 0;
        border-bottom: 1px solid var(--border);
        display: flex;
        justify-content: space-between;
    }

    .order-box ul li:last-child {
        border-bottom: none;
    }

    .order-box ul li span:first-child {
        font-weight: 600;
        color: var(--brand-secondary);
    }

    .order-box ul li span:last-child {
        color: var(--text-muted);
    }

    .price {
        font-size: 28px;
        font-weight: 800;
        color: var(--brand-primary);
        margin: 12px 0 4px;
        text-align: center;
    }

    .btn-get-quote {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        padding: 15px;
        background: var(--brand-primary);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 18px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 20px;
        box-shadow: 0 15px 35px rgba(255, 88, 5, 0.35);
    }

    .btn-get-quote:hover {
        background: var(--brand-primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 18px 40px rgba(230, 77, 4, 0.4);
    }

    .btn-get-quote img {
        margin-left: 10px;
        height: 20px;
        filter: invert(1);
    }

    .features {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-top: 30px;
    }

    .feature {
        background: var(--brand-surface);
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 12px 32px rgba(40, 53, 61, 0.12);
        display: flex;
        align-items: center;
        border: 1px solid var(--border);
    }

    .feature i {
        font-size: 24px;
        color: var(--brand-primary);
        margin-right: 15px;
    }

    .feature-content h3 {
        font-size: 18px;
        margin-bottom: 5px;
        color: var(--brand-secondary);
    }

    .feature-content p {
        color: var(--text-muted);
        font-size: 14px;
        margin: 0;
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(40, 53, 61, 0.75);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }

    .modal.active {
        display: flex;
    }

    .modal-content {
        background: var(--brand-surface);
        width: 90%;
        max-width: 520px;
        border-radius: 12px;
        padding: 30px;
        position: relative;
        animation: modalFade 0.3s ease;
        border: 1px solid var(--border);
    }

    @keyframes modalFade {
        from {
            opacity: 0;
            transform: translateY(-50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .close-modal {
        position: absolute;
        top: 15px;
        right: 15px;
        font-size: 24px;
        color: var(--text-muted);
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .close-modal:hover {
        color: var(--brand-primary);
    }

    .modal-title {
        font-size: 24px;
        margin-bottom: 20px;
        color: var(--brand-secondary);
        text-align: center;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: var(--brand-secondary);
    }

    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid var(--border);
        border-radius: 10px;
        font-size: 16px;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
        background: #fff;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--brand-primary);
        box-shadow: 0 0 0 3px rgba(255, 88, 5, 0.15);
    }

    .btn-submit {
        background: var(--brand-primary);
        color: white;
        border: none;
        padding: 14px;
        width: 100%;
        border-radius: 10px;
        font-size: 18px;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.3s ease, transform 0.2s ease;
        box-shadow: 0 12px 30px rgba(255, 88, 5, 0.35);
    }

    .btn-submit:hover {
        background: var(--brand-primary-dark);
        transform: translateY(-1px);
    }

    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        background: var(--brand-primary);
        color: white;
        padding: 15px 25px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        transform: translateX(200%);
        transition: transform 0.3s ease;
        z-index: 1100;
    }

    .notification.active {
        transform: translateX(0);
    }

    .notification.error {
        background: #e74c3c;
    }

    .stock-status {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
    }

    .in-stock {
        background: rgba(255, 88, 5, 0.12);
        color: var(--brand-primary);
    }

    .out-of-stock {
        background: rgba(231, 76, 60, 0.15);
        color: #c0392b;
    }

    @media (max-width: 768px) {
        .features {
            grid-template-columns: 1fr;
        }

        .thumbnails {
            grid-template-columns: repeat(4, 1fr);
            margin: 16px 10px 0;
        }

        .product-title {
            font-size: 26px;
        }

        .main-slideshow {
            height: 360px;
        }
    }

    @media (max-width: 480px) {
        .thumbnails {
            grid-template-columns: repeat(3, 1fr);
        }

        .main-slideshow {
            height: 300px;
        }
    }

    .img-zoom-container {
        position: relative;
        display: inline-block;
        overflow: hidden;
    }

    .zoom-image {
        width: 100%;
        max-width: 100%;
        display: block;
    }

    .img-zoom-lens {
        position: absolute;
        border: 1px solid #d4d4d4;
        width: 100px;
        height: 100px;
        visibility: hidden;
        cursor: none;
        background-repeat: no-repeat;
        background-size: 200% 200%;
        z-index: 10;
    }
</style>

<style>
.fullscreen-modal {
    display: none;
    position: fixed;
    z-index: 9999;
    padding-top: 60px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.95);
}

.fullscreen-slide {
    display: none;
    text-align: center;
}

.fullscreen-slide img {
    max-width: 90%;
    max-height: 80vh;
    margin: auto;
}

.fullscreen-modal .close-btn {
    position: absolute;
    top: 15px;
    right: 35px;
    font-size: 40px;
    color: white;
    cursor: pointer;
}

.fullscreen-modal .prev,
.fullscreen-modal .next {
    cursor: pointer;
    position: absolute;
    top: 50%;
    font-size: 40px;
    color: white;
    padding: 16px;
    margin-top: -22px;
    user-select: none;
}

.fullscreen-modal .prev { left: 0; }
.fullscreen-modal .next { right: 0; }
</style>

    <div class="page-content">
        <div class="container">
            <div class="grid">
                <div class="left-column">
                    <div class="gallery-container">
                        @php
                            $galleryImages = collect($productImages ?? [])->filter(function ($img) {
                                return !empty($img->image_url);
                            });
                            if ($galleryImages->isEmpty()) {
                                $galleryImages = collect([(object) ['image_url' => 'assets/assets/img/logo-colored.png']]);
                            }
                        @endphp
                        <div class="main-slideshow">
                             @foreach($galleryImages as $index => $image)
                            <div class="slide {{ $index === 0 ? 'active' : '' }}">
                                 <img src="{{ asset($image->image_url) }}" loading="lazy" decoding="async" alt="{{ $product->product_name }}">
                            </div>
                            @endforeach
                            
                            <div class="slide-controls">
                                <button class="prev-slide"><i class="fas fa-chevron-left"></i></button>
                                <button class="next-slide"><i class="fas fa-chevron-right"></i></button>
                            </div>
                        </div>
                        
                        <div class="thumbnails">
                            @foreach($galleryImages as $key => $image)
                            <div class="thumbnail {{ $key === 0 ? 'active' : '' }}">
                                <img src="{{ asset($image->image_url) }}" loading="lazy" decoding="async" alt="{{ $product->product_name }}">
                            </div>
                            @endforeach
                            
                        </div>
                    </div>
                    
                    
                    
                    <!-- Fullscreen Modal -->
                    <div id="fullscreenModal" class="fullscreen-modal">
                        <span class="close-btn">&times;</span>
                        <div class="fullscreen-slideshow">
                            @foreach($galleryImages as $index => $image)
                            <div class="fullscreen-slide" style="display: {{ $index === 0 ? 'block' : 'none' }};">
                                <img src="{{ asset($image->image_url) }}" loading="lazy" decoding="async" alt="{{ $product->product_name }}">
                            </div>
                            @endforeach
                    
                            <a class="prev">&#10094;</a>
                            <a class="next">&#10095;</a>
                        </div>
                    </div>

                    
                    <h1 class="product-title">{{ $product->product_name }}</h1>
                    
    <style>
    
     :root {
      --main-bg: #ffffff;
      --section-bg: #ffe3d2;
      --highlight: #ff5805;
      --highlight-alt: #f37413;
      --dim: #28353d;
      --text-main: #1f2933;
      --text-muted: #6b7280;
    }
    
    .page-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background: #fdf7f2;
        padding: 20px;
    }

    .downloads-container {
        width: 100%;
        max-width: 950px;
        background: rgba(255, 255, 255, 0.98);
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25);
        overflow: hidden;
        padding: 40px;
    }

    .downloads-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .downloads-header h1 {
        font-size: 2.8rem;
       
        margin-bottom: 15px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .downloads-header p {
        font-size: 1.2rem;
        color: var(--text-muted);
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
    }

    .downloads-header::after {
        content: '';
        display: block;
        width: 80px;
        height: 4px;
        background: linear-gradient(to right, var(--brand-primary), var(--brand-accent));
        margin: 20px auto 0;
        border-radius: 2px;
    }

    .download-item {
        background: #fff;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        border: 1px solid #eee;
        transition: 0.3s ease;
    }

    .download-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(255, 88, 5, 0.15);
        border-color: #ffd7be;
    }

    .file-icon {
        width: 70px;
        height: 70px;
        border-radius: 12px;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-right: 25px;
        font-size: 2rem;
        background: rgba(255, 88, 5, 0.12);
        color: var(--brand-primary);
    }

    .file-info {
        flex: 1;
    }

    .file-info h3 {
        font-size: 1.4rem;
        color: var(--brand-secondary);
        margin-bottom: 8px;
        font-weight: 700;
    }

    .file-info p {
        color: var(--text-muted);
        font-size: 0.95rem;
        display: flex;
        align-items: center;
    }

    .file-info p i {
        margin-right: 8px;
        font-size: 0.9rem;
    }

    .file-badge {
        background: rgba(255, 88, 5, 0.12);
        color: var(--brand-primary);
        padding: 4px 10px;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 700;
        margin-left: 12px;
        display: inline-flex;
        align-items: center;
    }

    .file-badge i {
        margin-right: 5px;
        font-size: 0.7rem;
    }

    .download-btn {
        background: linear-gradient(120deg, var(--brand-primary), var(--brand-accent));
        color: #fff;
        border: none;
        padding: 12px 25px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: 0.3s ease;
        display: flex;
        align-items: center;
        box-shadow: 0 10px 25px rgba(255, 88, 5, 0.35);
    }
    .download-btn a {
        color: #fff;
    }

    .download-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(255, 88, 5, 0.4);
        background: linear-gradient(120deg, var(--brand-primary-dark), var(--brand-primary));
    }
    

    .download-btn i {
        margin-right: 8px;
        font-size: 1.1rem;
    }


    @media (max-width: 768px) {
        .download-item {
            flex-direction: column;
            text-align: center;
            padding: 30px 20px;
        }

        .file-icon {
            margin-right: 0;
            margin-bottom: 20px;
        }

        .file-info {
            margin-bottom: 20px;
        }

        .downloads-header h1 {
            font-size: 2.2rem;
        }
    }
    
    .center-wrapper {
  display: flex;
  justify-content: center;  /* center horizontally */
  align-items: center;           /* full height of viewport, adjust as needed */
}

.cut-gloss-section {
  text-align: center; /* center text and content inside */
}


.step.half-active .step-circle {
  background: linear-gradient(90deg, var(--highlight) 50%, var(--dim) 50%);
}

</style>
                    
  


                    
                    <div class="product-description">
                        <div class="section-title">
                            <h2>Description</h2>
                        </div>
                        
            <p>{!! $product->description !!}</p>               
    
                    </div>
                    
                   
                </div>
                
                <div class="right-column">
                    <div class="order-box">
                        <ul>
                             <li><h3 class="product-title">{{ $product->product_name }}</h3></li>
                            <li>
                              
                                <span><small>{!! Str::limit($product->description, 120) !!}</small></span>
                            </li>
                            <li>
                                <span>Category</span>
                                <span>{{ $product->category->name ?? 'N/A' }}</span>
                            </li>
                            <li>
                                <span>Availability</span>
                                <span class="stock-status in-stock">In Stock</span>
                            </li>
                           
                            
                        
                        <div class="actions">
                           
                            <button class="btn-get-quote" id="popupTrigger">
                                Get A Quote
                            </button>
                            
                        </div> 

                        </ul>
                        

                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    
 
    <!--==============================
Team Area  
==============================-->
<div class="team-area-1 space-top space-bottom">
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-lg-7 col-md-8">
                <div class="title-area">
                    <span class="sub-title style2">MenzernaIndia Brochure</span>
                    <h2 class="sec-title">Downloads</h2>
                </div>
            </div>
        </div>

        <div class="row gy-30">
            @php $hasBrochure = false; @endphp
            @foreach($productVariants as $variant)
                @if($variant->sku_code === 'Brochure')
                    @php $hasBrochure = true; @endphp
                    <div class="col-lg-12">
                        <div class="download-list">
                            <div class="download-item d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="file-icon pdf me-3">
                                        <i class="fas fa-file-pdf fa-2x text-danger"></i>
                                    </div>
                                    <div class="file-info">
                                        <h3 class="mb-1">{{ $variant->variant }}</h3>
                                        <span class="file-badge"><i class="fas fa-file-alt"></i> PDF</span>
                                    </div>
                                </div>
                                <a class="download-btn btn btn-primary" href="{{ asset('assets/download/' . $variant->varaint_name) }}" download>
                                    <i class="fas fa-download"></i> Download
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
            @unless($hasBrochure)
                <div class="col-12 text-center text-muted">
                    <p class="mb-0">No brochures available for this product yet.</p>
                </div>
            @endunless
        </div>
    </div>
</div>

    
        
    <style>
.pagination-wrapper {
    text-align: center;
    margin-top: 30px;
}

.pagination {
    display: inline-flex;
    padding-left: 0;
    list-style: none;
    border-radius: 0.25rem;
}

.pagination li {
    margin: 0 5px;
}

.pagination li a,
.pagination li span {
    display: block;
    padding: 8px 12px;
    color: #333;
    background-color: #f1f1f1;
    border: 1px solid #ccc;
    text-decoration: none;
    border-radius: 4px;
}

.pagination li.active span,
.pagination li a:hover {
    background-color: #007bff;
    color: white;
    border-color: #007bff;
}

.pagination li.disabled span {
    color: #999;
    background-color: #e9ecef;
}
    .productt {
      background-color: #ffffff;
      color: #333;
      padding: 20px 40px;
      font-size: 2.5rem;
      text-align: center;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2) ;
      border-radius: 10px;
      transition: all 0.3s ease-in-out;
    }

    @media (max-width: 768px) {
      .productt {
        font-size: 2rem;
        padding: 15px 30px;
      }
    }

    @media (max-width: 480px) {
      .productt {
        font-size: 1.5rem;
        padding: 10px 20px;
      }
    }
  
  .clamp-titlee {
  padding: 16px 20px;
  border-radius: 10px;
  font-size: 18px;
  line-height: 1.4;
  background-color: #f9f9f9;
  margin-bottom: 10px;

  display: -webkit-box;
  -webkit-line-clamp: 2; /* Show only 2 lines */
  -webkit-box-orient: vertical;
  overflow: hidden;
  height: calc(2.2em * 2); /* 2 lines of text */
}


  .clamp-titlee a {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    color: inherit;
    text-decoration: none;
    font-weight: 700;
  }

  .clamp-titlee a:hover {
    text-decoration: underline;
  }

  @media (max-width: 576px) {
    .clamp-titlee {
      font-size: 14px;
      padding: 12px 16px;
    }
  }
  
  
  
  
  .clamp-titlee2 {
    font-size: 18px;
    line-height: 1.4;
  }

  .clamp-titlee2 a {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    color: inherit;
    text-decoration: none;
    font-weight: 700;
  }

  .clamp-titlee2 a:hover {
    text-decoration: underline;
    
        color: #ff5906;
    text-decoration: none;
    outline: 0;
    -webkit-transition: all ease 0.4s;
    transition: all ease 0.4s;
  }

  @media (max-width: 576px) {
    .clamp-titlee2 {
      font-size: 14px;
      padding: 12px 16px;
    }
  }
  #popupForm {
      display: none;
  }
</style>

    <!--==============================
    Portfolio Area  
    ==============================-->
    <div class="portfolio-area-1  space-bottom overflow-hidden">
        <div class="container">
            <div class="row justify-content-between align-items-end">
                <div class="col-xl-5 col-lg-6">
                    <div class="title-area">
                        <span class="sub-title mt-3">Our products</span>
                        <h2 class="sec-title">Related products<img class="title-bg-shape" src="/assets/assets/img/bg/title-bg-shape.png" loading="lazy" decoding="async" alt="img"></h2>
                    </div>
                </div>
                @if(($relatedProducts ?? collect())->count() > 0)
                    <div class="col-sm-auto">
                        <div class="title-area">
                            <div class="icon-box">
                                <button data-slick-prev=".portfolio-slider1" class="slick-arrow default" aria-label="Previous related"><i class="fas fa-arrow-left"></i></button>
                                <button data-slick-next=".portfolio-slider1" class="slick-arrow default" aria-label="Next related"><i class="fas fa-arrow-right"></i></button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        @if(($relatedProducts ?? collect())->count() > 0)
            <div class="container-fluid p-0">
                <div class="row global-carousel gx-30 portfolio-slider1"
                     data-slide-show="3"
                     data-center-mode="true"
                     data-xl-center-mode="true"
                     data-ml-center-mode="true"
                     data-lg-center-mode="true"
                     data-center-padding="150px"
                     data-xl-center-padding="100px"
                     data-ml-center-padding="80px"
                     data-lg-center-padding="60px">

                    @foreach($relatedProducts as $related)
                        @php
                            $relatedCategorySlug = data_get($related, 'subcategory.category.slug', 'general');
                            $relatedSubcategorySlug = data_get($related, 'subcategory.slug', 'general');
                            $relatedImage = asset(optional(optional($related->images)->first())->image_url ?? 'assets/assets/img/logo-colored.png');
                            $relatedCategoryName = data_get($related, 'category.name', 'Category');
                        @endphp
                        <div class="col-lg-6">
                            <div class="portfolio-card style2">
                                <div class="portfolio-card-thumb">
                                    <img src="{{ $relatedImage }}" loading="lazy" decoding="async" alt="{{ $related->product_name }}">
                                </div>
                                <div class="portfolio-card-details">
                                    <div class="media-left">
                                        <h4 class="portfolio-card-details_title clamp-titlee2">
                                            <a href="{{ route('content.show', [
                                                'category' => $relatedCategorySlug,
                                                'subcategory' => $relatedSubcategorySlug,
                                                'url' => $related->url
                                            ]) }}">{{ $related->product_name }}</a>
                                        </h4>
                                        <span class="portfolio-card-details_subtitle">{{ $relatedCategoryName }}</span>
                                    </div>
                                    <a href="{{ route('content.show', [
                                        'category' => $relatedCategorySlug,
                                        'subcategory' => $relatedSubcategorySlug,
                                        'url' => $related->url
                                    ]) }}" class="icon-btn" aria-label="View {{ $related->product_name }}">
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
                    <div class="col-12 text-center text-muted py-4">
                        <p class="mb-0">No related products available.</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
    
    
    
     <div class="popup-form" id="popupForm">
    <div class="popup-form-content">
        <div class="popup-form-blur-bg"></div>
        <div class="popup-form-header">
            <h2 class="form-title">Enquiry Now</h2>
            <button id="closePopup" class="close-btn" aria-label="Close">&times;</button>
        </div>
         <div id="success-message" class="alert-success-msg" style="display: none;">
            Your message has been sent successfully!
        </div>
            <form action="{{ route('submit.apply.form') }}" method="POST" id="quoteForm">
                @csrf
                <div class="form-group">
                    <label for="name">Full Name <span class="reqfil">*</span></label>
                    <input type="text" id="name" name="name" placeholder="Enter your name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email Address <span class="reqfil">*</span></label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="mobile">Phone Number <span class="reqfil">*</span></label>
                    <input type="tel" id="mobile" name="mobile" placeholder="Enter your phone number" required>
                </div>
               
                
                 <div class="form-group">
                    <label for="product">Product <span class="reqfil">*</span></label>
                    <select name="product_type" id="productDropdown" style="line-height: inherit;" required>
                        <option value="{{ $product->product_name }}">{{ $product->product_name }}</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="city">City <span class="reqfil">*</span></label>
                    <input type="text" id="city" name="city" placeholder="Enter your City" required>
                </div>
                <div class="form-group">
                    <label for="state">State <span class="reqfil">*</span></label>
                    <input type="text" id="state" name="state" placeholder="Enter your State" required>
                </div>
                <button type="submit" class="btn-submit">Submit</button>
            </form>
        
         </div>
        </div>
    

    
    <script>
        // Slideshow functionality with guards
        let currentSlide = 0;
        const slides = document.querySelectorAll('.slide');
        const thumbnails = document.querySelectorAll('.thumbnail');
        
        function showSlide(index) {
            if (!slides.length) return;
            slides.forEach(slide => slide.classList.remove('active'));
            thumbnails.forEach(thumb => thumb.classList.remove('active'));
            
            slides[index].classList.add('active');
            thumbnails[index].classList.add('active');
            currentSlide = index;
        }
        
        document.querySelector('.next-slide')?.addEventListener('click', () => {
            let nextSlide = currentSlide + 1;
            if (nextSlide >= slides.length) nextSlide = 0;
            showSlide(nextSlide);
        });
        
        document.querySelector('.prev-slide')?.addEventListener('click', () => {
            let prevSlide = currentSlide - 1;
            if (prevSlide < 0) prevSlide = slides.length - 1;
            showSlide(prevSlide);
        });
        
        thumbnails.forEach((thumb, index) => {
            thumb.addEventListener('click', () => showSlide(index));
        });
        
        if (slides.length > 1) {
            setInterval(() => {
                let nextSlide = currentSlide + 1;
                if (nextSlide >= slides.length) nextSlide = 0;
                showSlide(nextSlide);
            }, 5000);
        }
    </script>
    
    <script>
    const popupTrigger = document.getElementById('popupTrigger');
    const popupForm = document.getElementById('popupForm');
    const closePopup = document.getElementById('closePopup');

    if (popupTrigger && popupForm && closePopup) {
        popupTrigger.addEventListener('click', () => popupForm.classList.add('active'));
        closePopup.addEventListener('click', () => popupForm.classList.remove('active'));
        window.addEventListener('click', function (event) {
            if (event.target === popupForm) {
                popupForm.classList.remove('active');
            }
        });
    }
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('quoteForm');
        const successMessage = document.getElementById('success-message');

        form?.addEventListener('submit', function (e) {
            e.preventDefault();

            let formData = new FormData(form);

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name=\"_token\"]').value
                },
                body: formData
            })
            .then(response => {
                if (response.ok) return response.json();
                return response.json().then(err => Promise.reject(err));
            })
            .then(data => {
                form.reset();
                if (successMessage) {
                    successMessage.style.display = 'block';
                    successMessage.innerText = 'Your message has been sent successfully!';
                }

                setTimeout(() => {
                    if (successMessage) successMessage.style.display = 'none';
                    popupForm?.classList.remove('active');
                }, 3000);
            })
            .catch(error => {
                console.error('Submission error:', error);
            });
        });
    });
    </script>


    <script>
    document.addEventListener("DOMContentLoaded", function () {
        fetch("/get-products")
            .then(response => response.json())
            .then(data => {
                const dropdown = document.getElementById("productDropdown");
                if (!dropdown) return;
                data.forEach(product => {
                    const option = document.createElement("option");
                    option.value = product.product_name;
                    option.textContent = product.product_name;
                    dropdown.appendChild(option);
                });
            })
            .catch(error => {
                console.error("Error fetching products:", error);
            });
    });
    </script>


        @include('layout/footer')
    
</body>


</html>
