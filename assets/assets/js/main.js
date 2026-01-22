(function ($) {
    "use strict";

    // Abort safely if jQuery is missing
    if (typeof $ === "undefined") {
        console.warn("main.js: jQuery not found – skipping file.");
        return;
    }

    /*===========================
      01. PRELOADER / ON LOAD
    ===========================*/
    $(function () {
        var $pre = $(".preloader");
        if ($pre.length) {
            // fade quickly once DOM is ready (better LCP)
            $pre.addClass("preloader-hide");
            setTimeout(function () {
                $pre.fadeOut(300);
            }, 50);
        }
    });

    // Refresh slick on resize (only if slick exists)
    $(window).on("resize", function () {
        if ($.fn.slick) {
            $(".slick-slider").slick("refresh");
        }
    });

    /*===========================
      03. MOBILE MENU
    ===========================*/
    $.fn.mobilemenu = function (options) {
        var opt = $.extend(
            {
                menuToggleBtn: ".menu-toggle",
                bodyToggleClass: "body-visible",
                subMenuClass: "submenu-class",
                subMenuParent: "submenu-item-has-children",
                subMenuParentToggle: "active-class",
                meanExpandClass: "mean-expand-class",
                appendElement: '<span class="mean-expand-class"></span>',
                subMenuToggleClass: "menu-open",
                toggleSpeed: 400,
            },
            options
        );

        return this.each(function () {
            var menu = $(this);

            function menuToggle() {
                menu.toggleClass(opt.bodyToggleClass);

                var subMenu = "." + opt.subMenuClass;
                $(subMenu).each(function () {
                    if ($(this).hasClass(opt.subMenuToggleClass)) {
                        $(this)
                            .removeClass(opt.subMenuToggleClass)
                            .hide()
                            .parent()
                            .removeClass(opt.subMenuParentToggle);
                    }
                });
            }

            // Setup submenu structure
            menu.find("li").each(function () {
                var submenu = $(this).find("ul");
                if (!submenu.length) return;
                submenu
                    .addClass(opt.subMenuClass)
                    .hide()
                    .parent()
                    .addClass(opt.subMenuParent);
                submenu.prev("a").append(opt.appendElement);
                submenu.next("a").append(opt.appendElement);
            });

            function toggleDropDown($element) {
                if ($($element).next("ul").length) {
                    $($element)
                        .parent()
                        .toggleClass(opt.subMenuParentToggle);
                    $($element)
                        .next("ul")
                        .slideToggle(opt.toggleSpeed)
                        .toggleClass(opt.subMenuToggleClass);
                } else if ($($element).prev("ul").length) {
                    $($element)
                        .parent()
                        .toggleClass(opt.subMenuParentToggle);
                    $($element)
                        .prev("ul")
                        .slideToggle(opt.toggleSpeed)
                        .toggleClass(opt.subMenuToggleClass);
                }
            }

            // Expand buttons
            var expandToggler = "." + opt.meanExpandClass;
            $(expandToggler).each(function () {
                $(this).on("click", function (e) {
                    e.preventDefault();
                    toggleDropDown($(this).parent());
                });
            });

            // Toggle open / close
            $(opt.menuToggleBtn).each(function () {
                $(this).on("click", function () {
                    menuToggle();
                });
            });

            // Close on outside click
            menu.on("click", function (e) {
                e.stopPropagation();
                menuToggle();
            });

            // Do not close when clicking inside menu content
            menu.find("div").on("click", function (e) {
                e.stopPropagation();
            });
        });
    };

    $(".mobile-menu-wrapper").mobilemenu();

    /*===========================
      04. STICKY HEADER
    ===========================*/
    $(window).on("scroll", function () {
        var topPos = $(this).scrollTop();
        if (topPos > 500) {
            $(".sticky-wrapper").addClass("sticky");
        } else {
            $(".sticky-wrapper").removeClass("sticky");
        }
    });

    /*===========================
      05. SCROLL TO TOP
    ===========================*/
    (function () {
        var $scrollTop = $(".scroll-top");
        if (!$scrollTop.length) return;

        var scrollTopbtn = $scrollTop.get(0);
        var progressPath = $scrollTop.find("path").get(0);
        if (!progressPath) return;

        var pathLength = progressPath.getTotalLength();
        progressPath.style.transition = progressPath.style.WebkitTransition = "none";
        progressPath.style.strokeDasharray = pathLength + " " + pathLength;
        progressPath.style.strokeDashoffset = pathLength;
        progressPath.getBoundingClientRect();
        progressPath.style.transition = progressPath.style.WebkitTransition =
            "stroke-dashoffset 10ms linear";

        var updateProgress = function () {
            var scroll = $(window).scrollTop();
            var height = $(document).height() - $(window).height();
            var progress = pathLength - (scroll * pathLength) / height;
            progressPath.style.strokeDashoffset = progress;
        };

        updateProgress();
        $(window).on("scroll", updateProgress);

        var offset = 50;

        $(window).on("scroll", function () {
            if ($(this).scrollTop() > offset) {
                $(scrollTopbtn).classList.add("show");
            } else {
                $(scrollTopbtn).classList.remove("show");
            }
        });

        $(scrollTopbtn).addEventListener("click", function (event) {
            event.preventDefault();
            $("html, body").animate({ scrollTop: 0 }, 200);
            return false;
        });
    })();

    /*===========================
      07. GLOBAL CAROUSEL (slick)
    ===========================*/
    if ($.fn.slick) {
        $(".global-carousel").each(function () {
            var carouselSlide = $(this);

            function d(data) {
                return carouselSlide.data(data);
            }

            var prevButton =
                    '<button type="button" class="slick-prev"><i class="' +
                    d("prev-arrow") +
                    '"></i></button>',
                nextButton =
                    '<button type="button" class="slick-next"><i class="' +
                    d("next-arrow") +
                    '"></i></button>';

            // External arrows
            $("[data-slick-next]").each(function () {
                $(this).on("click", function (e) {
                    e.preventDefault();
                    $($(this).data("slick-next")).slick("slickNext");
                });
            });
            $("[data-slick-prev]").each(function () {
                $(this).on("click", function (e) {
                    e.preventDefault();
                    $($(this).data("slick-prev")).slick("slickPrev");
                });
            });

            if (d("arrows") === true && !carouselSlide.closest(".arrow-wrap").length) {
                carouselSlide.closest(".container").parent().addClass("arrow-wrap");
            }

            carouselSlide.slick({
                dots: !!d("dots"),
                fade: !!d("fade"),
                arrows: !!d("arrows"),
                speed: d("speed") || 1000,
                sliderNavfor: d("slidernavfor") || false,
                autoplay: d("autoplay") === false ? false : true,
                infinite: d("infinite") === false ? false : true,
                slidesToShow: d("slide-show") || 1,
                adaptiveHeight: !!d("adaptive-height"),
                centerMode: !!d("center-mode"),
                autoplaySpeed: d("autoplay-speed") || 8000,
                centerPadding: d("center-padding") || "0",
                focusOnSelect: d("focuson-select") === false ? false : true,
                pauseOnFocus: !!d("pauseon-focus"),
                pauseOnHover: !!d("pauseon-hover"),
                variableWidth: !!d("variable-width"),
                vertical: !!d("vertical"),
                verticalSwiping: !!d("vertical"),
                prevArrow: d("prev-arrow")
                    ? prevButton
                    : '<button type="button" class="slick-prev"><i class="fas fa-arrow-left"></i></button>',
                nextArrow: d("next-arrow")
                    ? nextButton
                    : '<button type="button" class="slick-next"><i class="fas fa-arrow-right"></i></button>',
                rtl: $("html").attr("dir") === "rtl",
                responsive: [
                    {
                        breakpoint: 1600,
                        settings: {
                            arrows: !!d("xl-arrows"),
                            dots: !!d("xl-dots"),
                            slidesToShow: d("xl-slide-show") || d("slide-show"),
                            centerMode: !!d("xl-center-mode"),
                            centerPadding: d("xl-center-padding") || "0",
                        },
                    },
                    {
                        breakpoint: 1400,
                        settings: {
                            arrows: !!d("ml-arrows"),
                            dots: !!d("ml-dots"),
                            slidesToShow: d("ml-slide-show") || d("slide-show"),
                            centerMode: !!d("ml-center-mode"),
                            centerPadding: d("ml-center-padding") || "0",
                        },
                    },
                    {
                        breakpoint: 1200,
                        settings: {
                            arrows: !!d("lg-arrows"),
                            dots: !!d("lg-dots"),
                            slidesToShow: d("lg-slide-show") || d("slide-show"),
                            centerMode: !!d("lg-center-mode"),
                            centerPadding: d("lg-center-padding") || "0",
                        },
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            arrows: !!d("md-arrows"),
                            dots: !!d("md-dots"),
                            slidesToShow: d("md-slide-show") || 1,
                            centerMode: !!d("md-center-mode"),
                            centerPadding: 0,
                        },
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            arrows: !!d("sm-arrows"),
                            dots: !!d("sm-dots"),
                            slidesToShow: d("sm-slide-show") || 1,
                            centerMode: !!d("sm-center-mode"),
                            centerPadding: 0,
                        },
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            arrows: !!d("xs-arrows"),
                            dots: !!d("xs-dots"),
                            slidesToShow: d("xs-slide-show") || 1,
                            centerMode: !!d("xs-center-mode"),
                            centerPadding: 0,
                        },
                    },
                ],
            });
        });
    }

    /*===========================
      08. CUSTOM ANIMATIONS
    ===========================*/
    $("[data-ani-duration]").each(function () {
        $(this).css("animation-duration", $(this).data("ani-duration"));
    });
    $("[data-ani-delay]").each(function () {
        $(this).css("animation-delay", $(this).data("ani-delay"));
    });
    $("[data-ani]").each(function () {
        var animaionName = $(this).data("ani");
        $(this).addClass(animaionName);
        $(".slick-current [data-ani]").addClass("slider-animated");
    });
    $(".global-carousel").on("afterChange", function (event, slick, currentSlide) {
        $(slick.$slides).find("[data-ani]").removeClass("slider-animated");
        $(slick.$slides[currentSlide]).find("[data-ani]").addClass("slider-animated");
    });

    /*===========================
      21. PRICE SLIDER (jQuery UI)
    ===========================*/
    if ($.fn.slider && $(".price_slider").length) {
        $(".price_slider").slider({
            range: true,
            min: 10,
            max: 100,
            values: [10, 75],
            slide: function (event, ui) {
                $(".from").text("$" + ui.values[0]);
                $(".to").text("$" + ui.values[1]);
            },
        });
        $(".from").text("$" + $(".price_slider").slider("values", 0));
        $(".to").text("$" + $(".price_slider").slider("values", 1));
    }

    /*===========================
      19. CIRCLE PROGRESS
    ===========================*/
    function animateElements() {
        if (!$.fn.circleProgress) return;
        $(".counter-circle .progressbar").each(function () {
            var $this = $(this);
            var elementPos = $this.offset().top;
            var topOfWindow = $(window).scrollTop();
            var percent = $this.find(".circle").attr("data-percent");
            var animate = $this.data("animate");

            if (elementPos < topOfWindow + $(window).height() - 30 && !animate) {
                $this.data("animate", true);
                $this
                    .find(".circle")
                    .circleProgress({
                        startAngle: -Math.PI / 2,
                        value: percent / 100,
                        size: 135,
                        thickness: 7,
                        emptyFill: "#2C2C2C",
                        fill: { color: "#F41E1E" },
                    })
                    .on("circle-animation-progress", function (event, progress, stepValue) {
                        $(this)
                            .find(".circle-num")
                            .text((stepValue * 100).toFixed(0) + "%");
                    })
                    .stop();
            }
        });
    }
    $(window).on("scroll load", animateElements);

    /*===========================
      11. SEARCH BOX POPUP
    ===========================*/
    function popupSarchBox($searchBox, $searchOpen, $searchCls, $toggleCls) {
        $($searchOpen).on("click", function (e) {
            e.preventDefault();
            $($searchBox).addClass($toggleCls);
        });
        $($searchBox).on("click", function () {
            $($searchBox).removeClass($toggleCls);
        });
        $($searchBox)
            .find("form")
            .on("click", function (e) {
                e.stopPropagation();
            });
        $($searchCls).on("click", function (e) {
            e.preventDefault();
            e.stopPropagation();
            $($searchBox).removeClass($toggleCls);
        });
    }
    popupSarchBox(".popup-search-box", ".searchBoxToggler", ".searchClose", "show");

    /*===========================
      12. POPUP SIDEMENU
    ===========================*/
    function popupSideMenu($sideMenu, $sideMunuOpen, $sideMenuCls, $toggleCls) {
        $($sideMunuOpen).on("click", function (e) {
            e.preventDefault();
            $($sideMenu).addClass($toggleCls);
        });
        $($sideMenu).on("click", function () {
            $($sideMenu).removeClass($toggleCls);
        });
        var sideMenuChild = $sideMenu + " > div";
        $(sideMenuChild).on("click", function (e) {
            e.stopPropagation();
        });
        $($sideMenuCls).on("click", function (e) {
            e.preventDefault();
            e.stopPropagation();
            $($sideMenu).removeClass($toggleCls);
        });
    }
    popupSideMenu(".sidemenu-wrapper", ".sideMenuToggler", ".sideMenuCls", "show");

    /*===========================
      13. MAGNIFIC POPUP
    ===========================*/
    if ($.fn.magnificPopup) {
        $(".popup-image").magnificPopup({
            type: "image",
            mainClass: "mfp-zoom-in",
            removalDelay: 260,
            gallery: { enabled: true },
        });

        $(".popup-video").magnificPopup({
            type: "iframe",
            mainClass: "mfp-zoom-in",
            removalDelay: 260,
        });

        $(".popup-content").magnificPopup({
            type: "inline",
            midClick: true,
        });

        $(".popup-content").on("click", function () {
            if ($.fn.slick) {
                $(".slick-slider").slick("refresh");
            }
        });
    }

    /*===========================
      15. FILTER / ISOTOPE
    ===========================*/
    if ($.fn.imagesLoaded && $.fn.isotope) {
        $(".filter-active").imagesLoaded(function () {
            var $filter = ".filter-active",
                $filterItem = ".filter-item",
                $filterMenu = ".filter-menu-active";

            if ($($filter).length) {
                var $grid = $($filter).isotope({
                    itemSelector: $filterItem,
                    filter: "*",
                });

                $($filterMenu).on("click", "button", function () {
                    var filterValue = $(this).attr("data-filter");
                    $grid.isotope({ filter: filterValue });
                });

                $($filterMenu).on("click", "button", function (event) {
                    event.preventDefault();
                    $(this)
                        .addClass("active")
                        .siblings(".active")
                        .removeClass("active");
                });
            }
        });

        $(".masonary-active").imagesLoaded(function () {
            var $filter = ".masonary-active",
                $filterItem = ".filter-item",
                $filterMenu = ".filter-menu-active";

            if ($($filter).length) {
                var $grid = $($filter).isotope({
                    itemSelector: $filterItem,
                    filter: "*",
                    masonry: { columnWidth: 1 },
                });

                $($filterMenu).on("click", "button", function () {
                    var filterValue = $(this).attr("data-filter");
                    $grid.isotope({ filter: filterValue });
                });

                $($filterMenu).on("click", "button", function (event) {
                    event.preventDefault();
                    $(this)
                        .addClass("active")
                        .siblings(".active")
                        .removeClass("active");
                });
            }
        });

        $(".filter-active-cat1").imagesLoaded(function () {
            var $filter = ".filter-active-cat1",
                $filterItem = ".filter-item",
                $filterMenu = ".filter-menu-active";

            if ($($filter).length) {
                var $grid = $($filter).isotope({
                    itemSelector: $filterItem,
                    filter: ".cat1",
                    masonry: { columnWidth: 1 },
                });

                $($filterMenu).on("click", "button", function () {
                    var filterValue = $(this).attr("data-filter");
                    $grid.isotope({ filter: filterValue });
                });

                $($filterMenu).on("click", "button", function (event) {
                    event.preventDefault();
                    $(this)
                        .addClass("active")
                        .siblings(".active")
                        .removeClass("active");
                });
            }
        });
    }

    /*===========================
      16. COUNTER UP
    ===========================*/
    if ($.fn.counterUp && $(".counter-number").length) {
        $(".counter-number").counterUp({
            delay: 10,
            time: 1000,
        });
    }

    /*===========================
      18. SHAPE MOCKUP
    ===========================*/
    $.fn.shapeMockup = function () {
        var $shape = $(this);
        $shape.each(function () {
            var $currentShape = $(this),
                shapeTop = $currentShape.data("top"),
                shapeRight = $currentShape.data("right"),
                shapeBottom = $currentShape.data("bottom"),
                shapeLeft = $currentShape.data("left");
            $currentShape
                .css({
                    top: shapeTop,
                    right: shapeRight,
                    bottom: shapeBottom,
                    left: shapeLeft,
                })
                .removeAttr("data-top data-right data-bottom data-left")
                .parent()
                .addClass("shape-mockup-wrap");
        });
    };
    if ($(".shape-mockup").length) {
        $(".shape-mockup").shapeMockup();
    }

    /*===========================
      20. PROGRESS BAR (waypoints)
    ===========================*/
    if ($.fn.waypoint) {
        $(".progress-bar").waypoint(
            function () {
                $(".progress-bar").css({
                    animation: "animate-positive 1.8s",
                    opacity: "1",
                });
            },
            { offset: "75%" }
        );
    }

    /*===========================
      23. INDICATOR
    ===========================*/
    $.fn.indicator = function () {
        var $menu = $(this),
            $linkBtn = $menu.find("a"),
            $btn = $menu.find("button");

        $menu.append('<span class="indicator"></span>');
        var $line = $menu.find(".indicator");
        var $currentBtn = $linkBtn.length ? $linkBtn : $btn;

        $currentBtn.on("click", function (e) {
            e.preventDefault();
            $(this).addClass("active").siblings(".active").removeClass("active");
            linePos();
        });

        function linePos() {
            var $btnActive = $menu.find(".active"),
                $height = $btnActive.css("height"),
                $width = $btnActive.css("width"),
                $top = $btnActive.position().top + "px",
                $left = $btnActive.position().left + "px";

            $(window).on("resize", function () {
                $top = $btnActive.position().top + "px";
                $left = $btnActive.position().left + "px";
            });

            $line.get(0).style.setProperty("--height-set", $height);
            $line.get(0).style.setProperty("--width-set", $width);
            $line.get(0).style.setProperty("--pos-y", $top);
            $line.get(0).style.setProperty("--pos-x", $left);
        }

        linePos();
    };
    if ($(".indicator-active").length) {
        $(".indicator-active").indicator();
    }

    /*===========================
      QUANTITY +/-
    ===========================*/
    $(".quantity-plus").on("click", function (e) {
        e.preventDefault();
        var $qty = $(this).siblings(".qty-input");
        var currentVal = parseInt($qty.val(), 10);
        if (!isNaN(currentVal)) {
            $qty.val(currentVal + 1);
        }
    });

    $(".quantity-minus").on("click", function (e) {
        e.preventDefault();
        var $qty = $(this).siblings(".qty-input");
        var currentVal = parseInt($qty.val(), 10);
        if (!isNaN(currentVal) && currentVal > 1) {
            $qty.val(currentVal - 1);
        }
    });

    /*===========================
      HOME SEVEN: SWIPER & SLIDERS
      (deferred for performance)
    ===========================*/
    function initHeroSwiper() {
        if (typeof Swiper === "undefined") return;
        new Swiper(".mySwiper", {
            slidesPerView: 1,
            centeredSlides: false,
            slidesPerGroupSkip: 1,
            grabCursor: true,
            effect: "fade",
            autoplay: true,
            speed: 1500,
            keyboard: { enabled: true },
            breakpoints: {
                769: { slidesPerView: 1, slidesPerGroup: 1 },
            },
            scrollbar: { el: ".swiper-scrollbar" },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
        });
    }

    function initFeaturesSlider() {
        if (!$.fn.slick || !$(".features-slider").length) return;
        $(".features-slider").slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            autoplay: false,
            autoplaySpeed: 2000,
            speed: 900,
            dots: false,
            pauseOnHover: true,
            arrows: true,
            draggable: true,
            rtl: $("html").attr("dir") === "rtl",
            infinite: true,
            nextArrow: "#features-next",
            prevArrow: "#features-prev",
            responsive: [
                { breakpoint: 1199, settings: { slidesToShow: 2, arrows: false } },
                { breakpoint: 767, settings: { slidesToShow: 1, arrows: false } },
                { breakpoint: 575, settings: { slidesToShow: 1, arrows: false } },
            ],
        });
    }

    function initBrandSlider() {
        if (!$.fn.slick || !$(".brand-slider").length) return;
        $(".brand-slider").slick({
            slidesToShow: 8,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            speed: 900,
            dots: false,
            pauseOnHover: true,
            arrows: false,
            draggable: true,
            rtl: $("html").attr("dir") === "rtl",
            infinite: true,
            nextArrow: "#brand-next",
            prevArrow: "#brand-prev",
            responsive: [
                { breakpoint: 1399, settings: { slidesToShow: 6, arrows: false } },
                { breakpoint: 992, settings: { slidesToShow: 5, arrows: false } },
                { breakpoint: 767, settings: { slidesToShow: 4, arrows: false } },
                { breakpoint: 424, settings: { slidesToShow: 2, arrows: false } },
                { breakpoint: 359, settings: { slidesToShow: 2, arrows: false } },
            ],
        });
    }

    function initTestimonialsSlider() {
        if (!$.fn.slick || !$(".testimonials-slider").length) return;
        $(".testimonials-slider").slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            autoplay: false,
            autoplaySpeed: 2000,
            speed: 900,
            dots: false,
            pauseOnHover: true,
            arrows: true,
            draggable: true,
            rtl: $("html").attr("dir") === "rtl",
            infinite: true,
            nextArrow: "#testi-next",
            prevArrow: "#testi-prev",
            responsive: [
                { breakpoint: 1199, settings: { slidesToShow: 2, arrows: false } },
                { breakpoint: 767, settings: { slidesToShow: 1, arrows: false } },
                { breakpoint: 575, settings: { slidesToShow: 1, arrows: false } },
            ],
        });
    }

    function initMarquees() {
        if (!$.fn.marquee) return;

        if ($(".marquee_mode").length) {
            $(".marquee_mode").marquee({
                speed: 100,
                gap: 0,
                delayBeforeStart: 0,
                direction: "left",
                duplicated: true,
                pauseOnHover: true,
                startVisible: true,
            });
        }

        if ($(".marquee_mode2").length) {
            $(".marquee_mode2").marquee({
                speed: 100,
                gap: 0,
                delayBeforeStart: 0,
                direction: "right",
                duplicated: true,
                pauseOnHover: true,
                startVisible: true,
            });
        }
    }

    function initNonCritical() {
        initHeroSwiper();
        initFeaturesSlider();
        initBrandSlider();
        initTestimonialsSlider();
        initMarquees();
    }

    if (typeof window.requestIdleCallback === "function") {
        window.requestIdleCallback(initNonCritical);
    } else {
        setTimeout(initNonCritical, 1200);
    }

    /*===========================
      PROGRESS BARS (IO)
    ===========================*/
    (function () {
        var progressContainers = document.querySelectorAll(".progress-container");
        if (!progressContainers.length) return;

        function setPercentage(progressContainer) {
            var percentage = progressContainer.getAttribute("data-percentage") + "%";
            var progressEl = progressContainer.querySelector(".progress");
            var percentageEl = progressContainer.querySelector(".percentage");
            if (!progressEl || !percentageEl) return;
            progressEl.style.width = percentage;
            percentageEl.innerText = percentage;
            percentageEl.style.insetInlineStart = percentage;
        }

        var observer = new IntersectionObserver(
            function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        var pc = entry.target;
                        setPercentage(pc);
                        var prog = pc.querySelector(".progress");
                        var perc = pc.querySelector(".percentage");
                        if (prog) prog.classList.remove("active");
                        if (perc) perc.classList.remove("active");
                        observer.unobserve(pc);
                    }
                });
            },
            { threshold: 0.5 }
        );

        progressContainers.forEach(function (pc) {
            observer.observe(pc);
        });
    })();
})(window.jQuery || window.$);
