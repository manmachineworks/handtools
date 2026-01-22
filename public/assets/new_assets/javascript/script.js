/*------------------------------------- Page Loader -------------------------------------*/
$(function () {
    setTimeout(() => {
        $('.page-loader').fadeOut('slow');
    }, 1000);
});
/*------------------------------------- Side Menu -------------------------------------*/
const menu = document.querySelector('.menu');
const menuToggle = document.querySelector('.menu-toggle');
const closeMenu = document.querySelector('.close-menu');
const overlay = document.querySelector('.menuOverlay');

// Open the menu and show the overlay
menuToggle.addEventListener('click', () => {
    menu.classList.add('active');
    overlay.classList.add('active');
});

// Close the menu and hide the overlay
closeMenu.addEventListener('click', () => {
    menu.classList.remove('active');
    overlay.classList.remove('active');
});

// Close the menu and hide the overlay when clicking on the overlay
overlay.addEventListener('click', () => {
    menu.classList.remove('active');
    overlay.classList.remove('active');
});

/*------------------------------------- Header Menu DropDown -------------------------------------*/
$(document).ready(function () {
    $(document).on('click', '.menu-dropdown', function (e) {
        e.stopPropagation();

        $('.menu-ul-list').not($(this).siblings('.menu-ul-list')).slideUp(280);
        $('.arrow-icon-menu').not($(this).find('.arrow-icon-menu')).removeClass('up');

        $(this).siblings('.menu-ul-list').slideToggle(280);
        $(this).find('.arrow-icon-menu').toggleClass('up');
    });

    // Close all dropdowns when clicking outside
    $(document).on('click', function () {
        $('.menu-ul-list').slideUp(280);
        $('.arrow-icon-menu').removeClass('up');
    });
});

/*------------------------------------- Active Menu Sub Menu -------------------------------------*/
const windowPathname = window.location.pathname;
const setActiveClass = (selector) => {
    const navLinks = document.querySelectorAll(selector);

    navLinks.forEach((navLink) => {
        const navLinkPathname = new URL(navLink.href, window.location.origin).pathname;
        const menuItem = navLink.closest('.wrapper');
        if (
            windowPathname === navLinkPathname ||
            (windowPathname === '/' && navLinkPathname === '/index.html')
        ) {
            navLink.classList.add('active');
            if (menuItem) {
                menuItem.classList.add('active');

                const submenu = navLink.closest('.menu-ul-list');
                if (submenu) {
                    submenu.parentElement.classList.add('active');
                }
            }
        }
    });
};

// Apply the active class logic
setActiveClass('.menu-text');
setActiveClass('.submenu-link');

/*-------------------------------------main background slider-------------------------------------*/
$('.slider-main').slick({
    dots: false,
    infinite: true,
    speed: 1000,
    fade: true,
    cssEase: 'linear',
    autoplay: true,
    arrows: false,
})

/*-------------------------------------Specific reveal Function-------------------------------------*/
function reveal() {
    const reveals = document.querySelectorAll(".reveal");
    const windowHeight = window.innerHeight;
    const elementVisible = 150;

    reveals.forEach((reveal) => {
        const elementTop = reveal.getBoundingClientRect().top;
        if (elementTop < windowHeight - elementVisible) {
            reveal.classList.add("active");
        } else {
            reveal.classList.remove("active");
        }
    });
}
window.addEventListener("scroll", reveal, { passive: true });

/*------------------------------------- Whole Page Scrolling Animation -------------------------------------*/
const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
            entry.target.classList.add('show');
        } else {
            entry.target.classList.remove('show');
        }
    });
});
const hiddenElements = document.querySelectorAll('.fade_up, .fade_down, .zoom_in, .zoom_out, .fade_right, .fade_left, .flip_left, .flip_right, .flip_up, .flip_down');
hiddenElements.forEach((el) => observer.observe(el));

/*------------------------------------- Testimonial Slider-------------------------------------*/
$(document).ready(function () {
    $('.services_slider').slick({
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        arrows: false,
        dots: false,
        speed: 1500,
        responsive: [
            {
                breakpoint: 1199,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    autoplay: true,
                    arrows: false,
                }
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                }
            }
        ]
    });
});

/*------------------------------------- Form Drop Down Menu -------------------------------------*/
$(document).ready(function () {
    $('.formDropDown').on('click', function (e) {
        e.stopPropagation();
        $('.formDropDown-ul-list').slideToggle(280);
        $('.arrow-icon-form').toggleClass('up');
    });

    $('.formDropDown-ul-list li').on('click', function (e) {
        e.stopPropagation();
        let selectedItem = $(this).text();
        $('.formDropDown').contents().filter(function () {
            return this.nodeType === 3;
        }).get(0).nodeValue = selectedItem;
        $('.formDropDown-ul-list').slideUp(280);
        $('.arrow-icon-form').removeClass('up');
    });

    $(document).on('click', function () {
        $('.formDropDown-ul-list').slideUp(280);
        $('.arrow-icon-form').removeClass('up');
    });
});

/*------------------------------------- Bottom To Top Button -------------------------------------*/
window.addEventListener('scroll', function () {
    var button = document.querySelector('.bottom-top-button');
    if (window.pageYOffset > 100) {
        button.style.display = 'block';
    } else {
        button.style.display = 'none';
    }
});

document.querySelector('.bottom-top-button').addEventListener('click', function () {
    window.scrollTo({ top: 0, behavior: 'smooth' });
});
/*------------------------------------- Progress Bar -------------------------------------*/
jQuery(document).ready(function () {
    jQuery(document).on('scroll', function () {
        if (jQuery('html,body').scrollTop() > jQuery('#first-sec').height()) {
            jQuery(".progress-bar").each(function () {
                jQuery(this).find(".progress-content").animate({
                    width: jQuery(this).attr("data-percentage")
                }, 2000);

                jQuery(this).find(".progress-number-mark").animate({
                    left: jQuery(this).attr("data-percentage")
                }, {
                    duration: 2000,
                    step: function (now, fx) {
                        var data = Math.round(now);
                        jQuery(this).find(".percent").html(data + "%");
                    }
                });
            });
        }
    });
});
/*------------------------------------- Pricing Toggle Button  -------------------------------------*/
document.addEventListener("DOMContentLoaded", function () {
    const toggleInput = document.getElementById("toggle-input");
    const monthlyText = document.getElementById("monthly-text");
    const yearlyText = document.getElementById("yearly-text");
    const monthlyPlan = document.getElementById("monthly-plan");
    const yearlyPlan = document.getElementById("yearly-plan");

    // Check if the toggle input and plans exist before adding event listeners
    if (toggleInput && monthlyText && yearlyText && monthlyPlan && yearlyPlan) {
        toggleInput.addEventListener("change", function () {
            if (toggleInput.checked) {
                // Switch to Yearly
                yearlyText.classList.add("active");
                monthlyText.classList.remove("active");
                yearlyPlan.classList.add("active");
                monthlyPlan.classList.remove("active");
            } else {
                // Switch to Monthly
                monthlyText.classList.add("active");
                yearlyText.classList.remove("active");
                monthlyPlan.classList.add("active");
                yearlyPlan.classList.remove("active");
            }
        });
    }
});

/*------------------------------------- Share Button  -------------------------------------*/
const shareButton = document.querySelector('.share-button');
const shareContainer = document.querySelector('.share-container');

if (shareButton && shareContainer) {
    const shareIcon = document.querySelector('.share-button img');

    shareButton.addEventListener('click', () => {
        shareContainer.classList.toggle('open');
        if (shareContainer.classList.contains('open')) {
            shareIcon.src = 'assets/images/svg/x.svg';
        } else {
            shareIcon.src = 'assets/images/svg/share.svg';
        }
    });
}