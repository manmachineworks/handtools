<!-- ====================================== Preloader ===================================== -->
    <div class="page-loader">
        <img src="/assets/new_assets/images/svg/logo.png" alt="loader">
        <div class="loading">
            <span>H</span>
            <span>A</span>
            <span>N</span>
            <span>D</span>
            <span>T</span>
            <span>O</span>
            <span>O</span>
            <span>L</span>
        </div>
    </div>
    
    <!-- ====================================== Header ===================================== -->
    <header class="header">
        <div class="small-header">
            <div class="container small-header-sub-main">
                <div class="small-header-sub">
                    <a href="mailto:contact@home.rakshak.com">
                        <p><img src="/assets/new_assets/images/svg/email.svg" alt="email"> contact@home.rakshak.com</p>
                    </a>
                    <p><img src="/assets/new_assets/images/svg/location.svg" alt="location"> 2972 Westheimer 96 Rd. Mexico</p>
                </div>
                <div class="small-header-media-main">
                    <a href="https://www.facebook.com">
                        <img src="/assets/new_assets/images/svg/facebook.svg" alt="facebook">
                    </a>
                    <a href="https://x.com">
                        <img src="/assets/new_assets/images/svg/twiiter.svg" alt="twiiter">
                    </a>
                    <a href="https://www.instagram.com">
                        <img src="/assets/new_assets/images/svg/insta.svg" alt="insta">
                    </a>
                    <a href="https://www.linkedin.com">
                        <img src="/assets/new_assets/images/svg/linkdien.svg" alt="linkdien">
                    </a>
                </div>
            </div>
        </div>
        <div class="container header-sub">
            <div class="logo">
                <a href="/"><img src="/assets/new_assets/images/svg/logo.png" alt="logo"></a>
            </div>
            <div class="menuOverlay"></div>
            <nav class="menu">
                <div class="side-menu-logo">
                    <a href="/"><img src="/assets/new_assets/images/svg/logo.png" alt="logo"></a>
                    <button class="close-menu d-none"><img src="/assets/new_assets/images/svg/x.svg" alt="x"></button>
                </div>
                <ul class="menu-list">
                    <li class="active-home">
                        <a class="conta-home" href="/">Home</a>
                    </li>
                    <li class="wrapper wrapper-men">
                        <a class="menu-dropdown menu-text" href="javascript:void(0)">Categories
                            <img class="arrow-icon-menu" src="/assets/new_assets/images/svg/down-arrow.svg" alt="down-arrow">
                        </a>
                        <div class="menu-ul-list">
                            <div class="menu-ul-list-d">
                                @php
                                    $navCategories = collect($categories ?? [])->take(8);
                                @endphp
                                @if($navCategories->count())
                                    <ul>
                                        @foreach($navCategories as $category)
                                            @php
                                                $categoryName = data_get($category, 'name', 'Category');
                                                $categorySlug = data_get($category, 'slug', \Illuminate\Support\Str::slug($categoryName));
                                                $categoryLink = url('/' . $categorySlug);
                                            @endphp
                                            <li><a class="submenu-link" href="{{ $categoryLink }}">{{ $categoryName }}</a></li>
                                        @endforeach
                                    </ul>
                                @else
                                    <ul>
                                        <li><a class="submenu-link" href="{{ url('/hand-tools') }}">Hand Tools &amp; Tool Kits</a></li>
                                        <li><a class="submenu-link" href="{{ url('/power-tools') }}">Power Tools &amp; Machinery</a></li>
                                        <li><a class="submenu-link" href="{{ url('/measuring-instruments') }}">Measuring Instruments</a></li>
                                        <li><a class="submenu-link" href="{{ url('/welding-fabrication') }}">Welding &amp; Fabrication</a></li>
                                        <li><a class="submenu-link" href="{{ url('/cutting-abrasives') }}">Cutting &amp; Abrasives</a></li>
                                        <li><a class="submenu-link" href="{{ url('/safety-gear') }}">Safety &amp; PPE</a></li>
                                        <li><a class="submenu-link" href="{{ url('/pneumatic-tools') }}">Pneumatic Tools</a></li>
                                        <li><a class="submenu-link" href="{{ url('/workshop-supplies') }}">Workshop Supplies</a></li>
                                    </ul>
                                @endif
                                <img src="/assets/new_assets/images/svg/3.png" alt="Categories highlight">
                            </div>
                        </div>
                    </li>
                    <li class="wrapper wrapper-men">
                        <a class="menu-dropdown menu-text" href="javascript:void(0)">Brands
                            <img class="arrow-icon-menu" src="/assets/new_assets/images/svg/down-arrow.svg" alt="down-arrow">
                        </a>
                        <div class="menu-ul-list">
                            <div class="menu-ul-list-d">
                                @php
                                    $navBrands = collect($brands ?? [])->take(8);
                                @endphp
                                @if($navBrands->count())
                                    <ul>
                                        @foreach($navBrands as $brand)
                                            @php
                                                $brandName = data_get($brand, 'name', (string) $brand);
                                                $brandSlug = data_get($brand, 'slug', \Illuminate\Support\Str::slug($brandName));
                                                $brandLink = route('brand.show', $brandSlug);
                                            @endphp
                                            <li><a class="submenu-link" href="{{ $brandLink }}">{{ $brandName }}</a></li>
                                        @endforeach
                                    </ul>
                                @else
                                    <ul>
                                        <li><a class="submenu-link" href="{{ route('brand.show', 'bosch') }}">Bosch</a></li>
                                        <li><a class="submenu-link" href="{{ route('brand.show', 'makita') }}">Makita</a></li>
                                        <li><a class="submenu-link" href="{{ route('brand.show', 'dewalt') }}">DeWalt</a></li>
                                        <li><a class="submenu-link" href="{{ route('brand.show', 'stanley') }}">Stanley</a></li>
                                        <li><a class="submenu-link" href="{{ route('brand.show', 'taparia') }}">Taparia</a></li>
                                        <li><a class="submenu-link" href="{{ route('brand.show', 'ingco') }}">Ingco</a></li>
                                        <li><a class="submenu-link" href="{{ route('brand.show', 'hikoki') }}">Hitachi (Hikoki)</a></li>
                                        <li><a class="submenu-link" href="{{ route('brand.show', 'eastman') }}">Eastman</a></li>
                                    </ul>
                                @endif
                                <img src="/assets/new_assets/images/svg/brand-tools.png" alt="Brands highlight">
                            </div>
                        </div>
                    </li>
                    <li class="wrapper wrapper-men">
                        <a class="menu-dropdown menu-text" href="javascript:void(0)">More
                            <img class="arrow-icon-menu" src="/assets/new_assets/images/svg/down-arrow.svg" alt="down-arrow">
                        </a>
                        <div class="menu-ul-list">
                            <div class="menu-ul-list-d">
                                <ul>
                                    <li><a class="submenu-link" href="{{ url('/about') }}">About Us</a></li>
                                    <li><a class="submenu-link" href="{{ url('/blog') }}">Blog</a></li>
                                    <li><a class="submenu-link" href="{{ url('/contact') }}">Contact Us</a></li>
                                </ul>
                                <img src="/assets/new_assets/images/svg/2.png" alt="More pages">
                            </div>
                        </div>
                    </li>
                    <li class="conta-home"><a href="{{ url('/contact') }}">Contact Us</a></li>
                </ul>
                <div class="side-menu-footer">
                    <a href="https://www.facebook.com">
                        <img src="/assets/new_assets/images/svg/facebook.svg" alt="home-fb-icon">
                    </a>
                    <a href="https://x.com">
                        <img src="/assets/new_assets/images/svg/twiiter.svg" alt="home-tw-icon">
                    </a>
                    <a href="https://www.instagram.com">
                        <img src="/assets/new_assets/images/svg/insta.svg" alt="home-insta-icon">
                    </a>
                    <a href="https://www.linkedin.com">
                        <img src="/assets/new_assets/images/svg/linkdien.svg" alt="home-be-icon">
                    </a>
                </div>
            </nav>
            <div class="contact">
                <div class="icon">
                    <img src="/assets/new_assets/images/svg/headphone.svg" alt="headphone">
                </div>
                <div class="call-info">
                    <p>Call Us</p>
                    <a href="tel:+12483578866">+1 (248) 357 8866</a>
                </div>
            </div>
            <button class="menu-toggle"><img src="/assets/new_assets/images/svg/menu.svg" alt="menu"></button>
        </div>
    </header>
