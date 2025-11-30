(function ($) {
    "use strict";

    // data color
    $("[data-color]").each(function () {
        $(this).css("color", $(this).attr("data-color"))
    })

    // data bg img
    $("[data-bg-img]").each(function () {
        $(this).css("background-image", "url(" + $(this).attr("data-bg-img") + ")")
    })

    // data border color
    $("[data-border-color]").each(function () {
        $(this).css("border-color", $(this).attr("data-border-color"))
    })

    // data bg color
    $("[data-bg-color]").each(function () {
        $(this).css("background-color", $(this).attr("data-bg-color"))
    })

    // header-menu
    $(".tp-header-menu-icon").on('click', function () {
        $(".tp-sidebar-overlay").addClass("tp-sidebar-overlay-open");

    });
    $(".tp-sidebar-overlay").on('click', function () {
        $(".tp-sidebar-overlay").removeClass("tp-sidebar-overlay-open");
        $(".tp-sidebar-area").removeClass("tp-sidebar-area-open"); // sidebar hide
    });

    // Toggle dropdown on click
    $(".tp-header-lang").on("click", function (e) {
        e.stopPropagation();
        $(this).toggleClass("tp-header-lang-open");
    });
    $(document).on("click", function () {
        $(".tp-header-lang").removeClass("tp-header-lang-open");
    });

    // Author dropdown toggle
    $(".tp-header-author").on("click", function (e) {
        e.stopPropagation();
        $(this).toggleClass("tp-header-author-open");
    });

    $(document).on("click", function () {
        $(".tp-header-lang, .tp-header-author").removeClass("tp-header-lang-open tp-header-author-open");
    });



    $(".tp-header-menu-icon").on("click", function () {
        $(".tp-sidebar-area").toggleClass("tp-sidebar-area-open");
    });
    $(".tp-deashboard-form-icon").on("click", function () {
        $(".tp-deashboard-form").toggleClass("tp-deashboard-form-open");
    });

    $(document).ready(function () {
        const sections = ["dashboard", "driver", "rider", "notification","complaint","sos","report-types"];

        sections.forEach(section => {
            $("." + section).on("click", function () {
                sections.forEach(other => {
                    if (other !== section) {
                        $(".tp-dropdown__menu-single-" + other).removeClass("tp-dropdown-menu-open-single");
                        $(".d-" + other).removeClass("show");
                    }
                });

                // Toggle the clicked one
                $(".tp-dropdown__menu-single-" + section).toggleClass("tp-dropdown-menu-open-single");
                $(".d-" + section).toggleClass("show");
            });
        });
    });



    $(document).on("click", ".tp-header-menu-icon", function () {
        $(".tp-dropdown__menu").removeClass("tp-dropdown-menu-open");
    });

    $(document).on("click", ".tp-header-menu-icon", function () {
        $(".tp-dropdown-toggle").removeClass("active");
        $(".tp-dropdown__menu-item").removeClass("open");
    });

    $(document).on("click", ".tp-header-menu-icon", function () {
        $(".tp-dropdown__menu li").removeClass("active");
    });
    $(document).on("click", ".tp-header-menu-icon", function () {
        $(".tp-deashboard-form").removeClass("tp-deashboard-form-open");
    });

    $(document).on("click", ".tp-dropdown__menu li", function (e) {
        e.preventDefault();
        $(".tp-dropdown__menu li").removeClass("active");
        $(this).addClass("active");
    });

    $(document).on("click", ".tp-sidebar-area.collapsed .tp-dropdown-toggle", function () {
        $(".tp-sidebar-area.collapsed .tp-dropdown-toggle").not(this).removeClass("active");
        $(this).toggleClass("active");
    });

    $(document).ready(function () {
        $(".tp-menu-link-open").on("click", function () {
            console.log("Navigating to:", $(this).attr("href"));
        });
    });

    $(".tp-deashboard-close-icon").on("click", function () {
        $(".tp-sidebar-area").toggleClass("tp-sidebar-area-open");
        $(".tp-sidebar-overlay").removeClass("tp-sidebar-overlay-open");
    });

    $("#sidebar__active").on("click", function () {
        if (window.innerWidth > 0 && window.innerWidth <= 991) {
            $(".tp-sidebar-area").toggleClass("open");

        } else {
            $(".tp-sidebar-area").toggleClass("collapsed");
             $(".tp-menu-link").toggleClass("tp-menu-link-open");
              $(".tp-sidebar-overlay").removeClass("tp-sidebar-overlay-open");
        }
    });


    var windowOn = $(window);
    windowOn.on('scroll', function () {
        var scroll = windowOn.scrollTop();

        if (scroll < 20) {
            $("#tp-header-sticky").removeClass("header-sticky");
        } else {
            $("#tp-header-sticky").addClass("header-sticky");
        }
    });


    $(document).ready(function () {
        $(".tp-dropdown-toggle").on("click", function (e) {
            var isDropdown = $(this).data("toggle") === "dropdown";

            if (isDropdown) {
                e.preventDefault();

                var parentLi = $(this).parent();
                var dropdownMenu = parentLi.find('.tp-dropdown__menu');
                var sidebar = $(".tp-sidebar-area");

                if (dropdownMenu.length === 0) return;

                if (sidebar.hasClass("collapsed")) {
                    if (dropdownMenu.hasClass("tp-dropdown-menu-open")) {
                        dropdownMenu.css({ 'max-height': '0', 'opacity': '0' });
                        dropdownMenu.removeClass("tp-dropdown-menu-open");
                    } else {
                        $(".tp-dropdown__menu").removeClass("tp-dropdown-menu-open")
                            .css({ 'max-height': '0', 'opacity': '0' });

                        var scrollHeight = dropdownMenu.get(0).scrollHeight;
                        dropdownMenu.addClass("tp-dropdown-menu-open")
                            .css({ 'max-height': scrollHeight + 'px', 'opacity': '1' });
                    }
                } else {
                    if (parentLi.hasClass('open')) {
                        dropdownMenu.css({ 'max-height': '0', 'opacity': '0' });
                        dropdownMenu.on('transitionend', function () {
                            parentLi.removeClass("open");
                            dropdownMenu.off('transitionend');
                        });
                    } else {
                        parentLi.addClass("open");
                        var scrollHeight = dropdownMenu.get(0).scrollHeight;
                        dropdownMenu.css({ 'max-height': scrollHeight + 'px', 'opacity': '1' });
                    }
                }
            }
        });

        $(".tp-dropdown__menu a").on("click", function (e) {
            e.stopPropagation(); // Allow default behavior, but stop bubbling
        });
    });


    //counter
    new PureCounter();
    new PureCounter({
        filesizing: true,
        selector: ".filesizecount",
        pulse: 2,
    });


    // Back to top
    var amountScrolled = 200;

    $(window).scroll(function () {
        if ($(window).scrollTop() > amountScrolled) {
            $('button.back-to-top').addClass('show');
        } else {
            $('button.back-to-top').removeClass('show');
        }
    });

    $(window).on("load", function () {
        $("#loading").fadeOut(500, function () {
            $(this).remove();
        });
    });










})(jQuery);
