<!DOCTYPE html>
<html lang="en">

@include('layout/head')

<body >
@include('layout/header')
 <!-- ====================================== Section One ===================================== -->
    <section class="section-one">
        <div class="page-img-header" id="error404-bg">
            <div class="container">
                <h1 class="img-header-text fade_down">404 Page</h1>
                <div class="breadcrumb-group fade_up">
                    <a href="/">HOME / </a>
                    <a href="#">404 PAGE</a>
                </div>
            </div>
        </div>
    </section>
    <!-- ====================================== Section REPAIR & INSTALLATION ===================================== -->
    <section class="installation-section">
        <div class="container">
            <div class="quality-main ourProcess fade_down">
                <p class="quality">404 ERROR</p>
            </div>
            <h2 class="handyman-text legal fade_down">Oops ! The Page Not Found.</h2>
            <p class="fusce iaculis fade_down">We apologize for the inconvenience. You can use our search bar to find
                what you're looking for, or contact us for further assistance.
            </p>
            <div class="robot-img-text">
                <div class="oops">OOPS...</div>
                <img src="/assets/new_assets/images/error-page/robot.png" alt="robot">
                <div class="error-text">
                    <h2 class="Error404-text" data-text="404">404</h2>
                    <p class="Error404-text error" data-text="ERROR">ERROR</p>
                </div>
            </div>
            <div class="testimonials-btn mt-0 fade_down">
                <a href="/" class="btn-main btn2">Back To Home
                    <span class="arrow-section">
                        <img class="arrow" src="/assets/new_assets/images/svg/right-arrow-svg.svg" alt="right-arrow-svg">
                    </span>
                    <div class="btn-box-left btn2"></div>
                    <div class="btn-box-right btn2"></div>
                </a>
            </div>
        </div>
    </section>


        @include('layout/footer')
  
</body>


</html>