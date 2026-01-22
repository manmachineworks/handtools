<!DOCTYPE html>
<html lang="zxx">



<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
@include('layout/head')

<body class="page-equipment-detail">
    <div class="page-wrapper">
    @include('layout/header')
        <main class="page-main">
            <div class="page-head">
                <div class="page-head__bg" style="background-image: url(assets/assets/img/bg/bg_categories.jpg)">
                    <div class="page-head__content" data-uk-parallax="y: 0, 100">
                        <div class="uk-container">
                            <div class="header-icons"><span></span><span></span><span></span></div>
                            <div class="page-head__title"> Caterpillar 345 GC Excavator</div>
                            <div class="page-head__breadcrumb">
                                <ul class="uk-breadcrumb">
                                    <li><a href="https://pro-theme.com/">Home</a></li>
                                    <li> <a href="#!">Equipments</a></li>
                                    <li> <a href="#!">Excavators</a></li>
                                    <li><span>Caterpillar 345 GC Excavator</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-content">
    <div class="uk-section-large uk-container">
        <div class="uk-grid" data-uk-grid>
            <div class="uk-width-2-3@m">
                <div class="equipment-detail">
                    <!-- Product Image Gallery -->
                    <div class="equipment-detail__gallery">
                        <div data-uk-slideshow="min-height: 300; max-height: 430">
                            <div class="uk-position-relative">
                                <ul class="uk-slideshow-items uk-child-width-1-1" data-uk-lightbox="animation: scale">
                                    @foreach($productImages as $image)
                                    <li>
                                        <a href="{{ asset($image->image_url) }}">
                                            <img class="uk-width-1-1" src="{{ asset( $image->image_url) }}" alt="{{ $product->product_name }}" data-uk-cover>
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                                <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" data-uk-slidenav-previous data-uk-slideshow-item="previous"></a>
                                <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" data-uk-slidenav-next data-uk-slideshow-item="next"></a>
                            </div>

                            <!-- Thumbnails -->
                            <div class="uk-margin-top" data-uk-slider>
                                <ul class="uk-thumbnav uk-slider-items uk-grid uk-grid-small uk-child-width-1-2 uk-child-width-1-3@s uk-child-width-1-4@m uk-child-width-1-5@l">
                                    @foreach($productImages as $key => $image)
                                        <a href="#"><img src="{{ asset($image->image_url) }}" alt="{{ $product->product_name }}"></a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Product Title and Location -->
                    <div class="equipment-detail__title">{{ $product->product_name }}</div>
                    <div class="equipment-detail__location">
                        <span data-uk-icon="location"></span>{{ $product->location ?? 'Location not available' }}
                    </div>

                    <!-- Product Buttons -->
                    <div class="equipment-detail__btns">
                        <a href="#!"><i class="fas fa-file-pdf"></i>View or Download Brochure</a>
                        <a href="#!"><i class="fas fa-star"></i>Favourite This Equipment</a>
                    </div>

                    <!-- Product Description -->
                    <div class="equipment-detail__desc">
                        <div class="section-title">
                            <div class="uk-h2">Description</div>
                        </div>
                        <p>{!! \Illuminate\Support\Str::words($product->description, 50, '...') !!}</p>
                    </div>

                    <!-- Product Specifications -->
                    <!--<div class="equipment-detail__specification">-->
                    <!--    <div class="section-title">-->
                    <!--        <div class="uk-h2">Specification</div>-->
                    <!--    </div>-->
                    <!--    <table class="uk-table uk-table-striped">-->
                    <!--        <tr>-->
                    <!--            <td>Weight:</td>-->
                    <!--            <td>{{ $product->weight ?? 'N/A' }}kg</td>-->
                    <!--        </tr>-->
                    <!--        <tr>-->
                    <!--            <td>Length:</td>-->
                    <!--            <td>{{ $product->length ?? 'N/A' }} meters</td>-->
                    <!--        </tr>-->
                    <!--        <tr>-->
                    <!--            <td>Breadth:</td>-->
                    <!--            <td>{{ $product->breadth ?? 'N/A' }} meters</td>-->
                    <!--        </tr>-->
                    <!--        <tr>-->
                    <!--            <td>Height:</td>-->
                    <!--            <td>{{ $product->height ?? 'N/A' }} meters</td>-->
                    <!--        </tr>-->
                            <!-- Add more fields if necessary -->
                    <!--    </table>-->
                    <!--</div>-->
                </div>
            </div>

            <!-- Booking Section -->
            <div class="uk-width-1-3@m">
                <div class="equipment-order">
                    <div class="equipment-order__price"><span>${{ $product->sale_price }}<small>Per day</small></span></div>
                    <div class="equipment-order__form">
                        <div class="uk-margin">
                            <div class="datapicker-inline"></div>
                        </div>
                        <div class="uk-margin">
                            <input type="text" placeholder="Where: Atlanta, New York">
                        </div>
                        <div class="uk-margin">
                            <div class="equipment-order__value">
                                <span data-uk-icon="check"></span>Dates are available
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Total Section -->
                <div class="equipment-order-total">
                    <ul>
                        <li><span>Price</span><span>${{ $product->sale_price }}</span></li>
             
                    </ul>
                    <button class="uk-button uk-button-large uk-width-1-1" type="submit">
                        <span>Book now</span><img src="{{ asset('assets/assets/img/icons/arrow.svg') }}" alt="arrow" data-uk-svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

       
        </main>
        @include('layout/footer')
    </div>
    <script src="assets/assets/js/libs.js"></script>
    <script src="assets/assets/js/main.js"></script>
</body>

</html>
