(function ($) {
    "use strict";

    /*********************************
    /* Sticky Navbar
    *********************************/
    $(window).scroll(function () {
        var scrolling = $(this).scrollTop();
        var stikey = $(".header");

        if (scrolling >= 10) {
            $(stikey).addClass("nav-bg");
        } else {
            $(stikey).removeClass("nav-bg");
        }
    });

    /*********************************
    /*  Mobile Menu Expand (Main Dropdown)
    *********************************/
    $(".offcanvas-nav-menu > .has-dropdown > .nav-link").on("click", function (event) {
        event.preventDefault();
        // Close other top-level submenus
        $(".offcanvas-nav-menu > .has-dropdown > .nav-link").not(this).next(".sub-menu").slideUp(400);
        // Toggle current submenu
        $(this).next(".sub-menu").stop(true, true).slideToggle(400);
    });

    /*********************************
    /*  Mobile Menu Expand (Sub Dropdown)
    *********************************/
    $(".offcanvas-nav-menu .sub-menu .has-dropdown > .nav-link").on("click", function (event) {
        event.preventDefault();
        // Close sibling sub-sub-menus within same sub-menu
        $(this).parent().siblings(".has-dropdown").find(".sub-sub-menu").slideUp(400);
        // Toggle current sub-sub-menu
        $(this).next(".sub-sub-menu").stop(true, true).slideToggle(400);
    });

    /*********************************
    /*  Testimonial Slider
    *********************************/
    if ($(".testimonial__slider").length > 0) {
        var testimonialSlider = new Swiper(".testimonial__slider", {
            loop: true,
            spaceBetween: 20,
            grabCursor: true,
            // centeredSlides: true,
            speed: 800, // transition duration in ms
            autoplay: {
                enabled: false,
                delay: 3000,
            },
            navigation: {
                nextEl: ".testimonial-swipe-next",
                prevEl: ".testimonial-swipe-prev",
            },
            pagination: {
                //pagination(dots)
                el: ".testimonial-pagination",
            },
            breakpoints: {
                300: {
                    slidesPerView: 1,
                },
                400: {
                    slidesPerView: 1,
                },
                479: {
                    slidesPerView: 1,
                },
                575: {
                    slidesPerView: 1,
                },
                767: {
                    slidesPerView: 1.5,
                },
                991: {
                    slidesPerView: 2,
                },
                1199: {
                    slidesPerView: 2,
                },
            },
        });
    }

    /**********************************
    /*  AOS animation
    **********************************/
    AOS.init();

    /**********************************
     *  Back to Top JS
     **********************************/
    $("body").append('<div id="toTop" class="back__icon"><i class="ri-arrow-up-double-line"></i></div>');
    $(window).on("scroll", function () {
        if ($(this).scrollTop() > 300) {
            $("#toTop").addClass("active");
        } else {
            $("#toTop").removeClass("active");
        }
    });
    $("#toTop").on("click", function () {
        $("html, body").animate({ scrollTop: 0 }, 0);
        return false;
    });
})(jQuery);
