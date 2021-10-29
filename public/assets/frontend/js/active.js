// Index of jQuery Active Code

// :: 1.0 PRELOADER ACTIVE CODE
// :: 2.0 NAVIGATION MENU ACTIVE CODE
// :: 3.0 STICKY HEADER ACTIVE CODE
// :: 4.0 SCROLL TO TOP ACTIVE CODE
// :: 5.0 SCROLL LINK ACTIVE CODE
// :: 6.0 SMOOTH SCROLLING ACTIVE CODE
// :: 7.0 AOS ACTIVE CODE
// :: 8.0 WOW ACTIVE CODE
// :: 9.0 PREVENT DEFAULT ACTIVE CODE
// :: 10.0 COUNTERUP ACTIVE CODE
// :: 11.0 FANCYBOX VIDEO POPUP ACTIVE CODE
// :: 12.0 CIRCLE ANIMATION ACTIVE CODE
// :: 13.0 REVIEWS ACTIVE CODE
// :: 14.0 PORTFOLIO ACTIVE CODE
// :: 15.0 CONTACT FORM ACTIVE CODE

(function ($) {
    "use strict";

    var $window = $(window);
    var zero = 0;

    // :: 1.0 PRELOADER ACTIVE CODE
    $(window).on("load", function () {
        $("#digimax-preloader").addClass("loaded");

        if ($("#digimax-preloader").hasClass("loaded")) {
            $("#preloader")
                .delay(900)
                .queue(function () {
                    $(this).remove();
                });
        }
    });

    // :: 2.0 NAVIGATION MENU ACTIVE CODE
    jQuery(function ($) {
        "use strict";

        // RESPONSIVE NAVIGATION
        function navResponsive() {
            let navbar = $(".navbar .items");
            let menu = $("#menu .items");

            menu.html("");
            navbar.clone().appendTo(menu);

            $(".menu .fa-angle-right")
                .removeClass("fa-angle-right")
                .addClass("fa-angle-down");
        }

        navResponsive();

        $(window).on("resize", function () {
            navResponsive();
        });

        // PREVENT DROPDOWN
        $(".menu .dropdown-menu").each(function () {
            var children = $(this).children(".dropdown").length;
            $(this).addClass("children-" + children);
        });

        $(".menu .nav-item.dropdown").each(function () {
            var children = $(this).children(".nav-link");
            children.addClass("prevent");
        });

        $(document).on("click", "#menu .nav-item .nav-link", function (e) {
            if ($(this).hasClass("prevent")) {
                e.preventDefault();
            }

            var nav_link = $(this);

            nav_link.next().toggleClass("show");

            if (nav_link.hasClass("smooth-anchor")) {
                $("#menu").modal("hide");
            }
        });
    });

    // :: 3.0 STICKY HEADER ACTIVE CODE
    $window.on("scroll", function () {
        if ($(window).scrollTop() > 40) {
            $(".navbar").addClass("navbar-sticky");
            $(".navbar .navbar-nav.action .btn").addClass("btn-bordered");
            $(".navbar .navbar-nav.action .btn").removeClass(
                "btn-bordered-white"
            );
        } else {
            $(".navbar").removeClass("navbar-sticky");
            $(".navbar .navbar-nav.action .btn").removeClass("btn-bordered");
            $(".navbar .navbar-nav.action .btn").addClass("btn-bordered-white");
        }
    });

    $window.on("scroll", function () {
        $(".navbar-sticky").toggleClass("hide", $(window).scrollTop() > zero);
        zero = $(window).scrollTop();
    });

    // :: 4.0 SCROLL TO TOP ACTIVE CODE
    var offset = 300;
    var duration = 500;

    $window.on("scroll", function () {
        if ($(this).scrollTop() > offset) {
            $("#scrollUp").fadeIn(duration);
        } else {
            $("#scrollUp").fadeOut(duration);
        }
    });

    $("#scrollUp").on("click", function () {
        $("html, body").animate(
            {
                scrollTop: 0,
            },
            duration
        );
    });
    $("#button_mitra").on("click", function () {
        var name = $("#name input").val().length;
        var nomor_hp = $("#nomor_hp input").val().length;
        var nomor_hp_dua = $("#nomor_hp input").height();
        var warehouse_address = $("#warehouse_address input").val().length;
        var warehouse_area = $("#warehouse_area input").val().length;
        var checked = false;
        var checkeddua = false;
        var warehouse_facility = document.getElementsByName(
            "warehouse_facility[]"
        );
        var warehouse_vehicle = document.getElementsByName(
            "warehouse_vehicle[]"
        );
        var warehouse_type = $("#warehouse_type select").val();
        var is_flood_free = $("#is_flood_free select").val();
        var is_parking_free = $("#is_parking_free select").val();
        var warehouse_ownership = $("#warehouse_ownership select").val();
        for (var i = 0; i < warehouse_facility.length; i++) {
            if (warehouse_facility[i].checked) {
                checked = true;
            }
        }
        for (var i = 0; i < warehouse_vehicle.length; i++) {
            if (warehouse_vehicle[i].checked) {
                checkeddua = true;
            }
        }
        if (
            name == 0 ||
            nomor_hp == 0 ||
            warehouse_address == 0 ||
            warehouse_area == 0 ||
            !checked ||
            !checkeddua ||
            warehouse_type == null ||
            is_flood_free == null ||
            is_parking_free == null ||
            warehouse_ownership == null
        ) {
            if (name == 0) {
                $("#name .invalid-feedback").css("display", "block");
            } else {
                $("#name .invalid-feedback").css("display", "none");
            }
            if (nomor_hp == 0) {
                $("#nomor_hp .invalid-feedback").css("display", "block");
            } else {
                $("#nomor_hp .invalid-feedback").css("display", "none");
            }
            if (warehouse_address == 0) {
                $("#warehouse_address .invalid-feedback").css(
                    "display",
                    "block"
                );
            } else {
                $("#warehouse_address .invalid-feedback").css(
                    "display",
                    "none"
                );
            }
            if (warehouse_area == 0) {
                $("#warehouse_area .invalid-feedback").css("display", "block");
            } else {
                $("#warehouse_area .invalid-feedback").css("display", "none");
            }

            for (var i = 0; i < warehouse_facility.length; i++) {
                if (warehouse_facility[i].checked) {
                    checked = true;
                }
            }
            if (!checked) {
                $("#warehouse_facility .invalid-feedback").css(
                    "display",
                    "block"
                );
            } else {
                $("#warehouse_facility .invalid-feedback").css(
                    "display",
                    "none"
                );
            }

            for (var i = 0; i < warehouse_vehicle.length; i++) {
                if (warehouse_vehicle[i].checked) {
                    checked = true;
                }
            }
            if (!checked) {
                $("#warehouse_vehicle .invalid-feedback").css(
                    "display",
                    "block"
                );
            } else {
                $("#warehouse_vehicle .invalid-feedback").css(
                    "display",
                    "none"
                );
            }

            if (warehouse_type == null) {
                $("#warehouse_type .invalid-feedback").css("display", "block");
            } else {
                $("#warehouse_type .invalid-feedback").css("display", "none");
            }
            if (is_flood_free == null) {
                $("#is_flood_free .invalid-feedback").css("display", "block");
            } else {
                $("#is_flood_free .invalid-feedback").css("display", "none");
            }
            if (is_parking_free == null) {
                $("#is_parking_free .invalid-feedback").css("display", "block");
            } else {
                $("#is_parking_free .invalid-feedback").css("display", "none");
            }
            if (warehouse_ownership == null) {
                $("#warehouse_ownership .invalid-feedback").css(
                    "display",
                    "block"
                );
            } else {
                $("#warehouse_ownership .invalid-feedback").css(
                    "display",
                    "none"
                );
            }
            $("html, body").animate(
                {
                    scrollTop: 0,
                },
                duration
            );
        } else {
            $("#button_mitra").remove("type", "button");
            $("#button_mitra").attr("type", "submit");
        }
    });

    // :: 5.0 SCROLL LINK ACTIVE CODE
    var scrollLink = $(".scroll");

    // :: 6.0 SMOOTH SCROLLING ACTIVE CODE
    scrollLink.on("click", function (e) {
        e.preventDefault();
        $("body,html").animate(
            {
                scrollTop: $(this.hash).offset().top,
            },
            1000
        );
    });

    // :: 7.0 AOS ACTIVE CODE
    AOS.init();

    // :: 8.0 WOW ACTIVE CODE
    new WOW().init();

    // :: 9.0 PREVENT DEFAULT ACTIVE CODE
    $("a[href='#']").on("click", function ($) {
        $.preventDefault();
    });

    // :: 10.0 COUNTERUP ACTIVE CODE
    $(".counter").counterUp({
        delay: 10,
        time: 1000,
    });

    // :: 11.0 FANCYBOX VIDEO POPUP ACTIVE CODE
    $(".play-btn").fancybox({
        animationEffect: "zoom-in-out",
        transitionEffect: "circular",
        maxWidth: 800,
        maxHeight: 600,
        youtube: {
            controls: 0,
        },
    });

    // :: 12.0 CIRCLE ANIMATION ACTIVE CODE
    $(window).on("load", function () {
        $(".profile-circle-wrapper").addClass("circle-animation");
        $(".profile-icon").fadeIn();
    });

    // :: 13.0 REVIEWS ACTIVE CODE
    $(".client-reviews.owl-carousel").owlCarousel({
        loop: true,
        center: true,
        margin: 40,
        nav: false,
        dots: false,
        smartSpeed: 1000,
        autoplay: true,
        autoplayTimeout: 4000,
        animateOut: "slideOutDown",
        animateIn: "flipInX",
        responsive: {
            0: {
                items: 1,
            },
            576: {
                items: 2,
            },
            768: {
                items: 2,
            },
            992: {
                items: 3,
            },
        },
    });

    // :: 14.0 PORTFOLIO ACTIVE CODE
    $(".portfolio-area").each(function (index) {
        var count = index + 1;

        $(this)
            .find(".portfolio-items")
            .removeClass("portfolio-items")
            .addClass("portfolio-items-" + count);
        $(this)
            .find(".portfolio-item")
            .removeClass("portfolio-item")
            .addClass("portfolio-item-" + count);
        $(this)
            .find(".portfolio-btn")
            .removeClass("portfolio-btn")
            .addClass("portfolio-btn-" + count);

        var Shuffle = window.Shuffle;
        var Filter = new Shuffle(
            document.querySelector(".portfolio-items-" + count),
            {
                itemSelector: ".portfolio-item-" + count,
                buffer: 1,
            }
        );

        $(".portfolio-btn-" + count).on("change", function (e) {
            var input = e.currentTarget;

            if (input.checked) {
                Filter.filter(input.value);
            }
        });
    });

    // :: 15.0 CONTACT FORM ACTIVE CODE
    // Get the form.
    var form = $("#contact-form");
    // Get the messages div.
    var formMessages = $(".form-message");
    // Set up an event listener for the contact form.
    $(form).submit(function (e) {
        // Stop the browser from submitting the form.
        e.preventDefault();
        // Serialize the form data.
        var formData = $(form).serialize();
        // Submit the form using AJAX.
        $.ajax({
            type: "POST",
            url: $(form).attr("action"),
            data: formData,
        })
            .done(function (response) {
                // Make sure that the formMessages div has the 'success' class.
                $(formMessages).removeClass("error");
                $(formMessages).addClass("success");

                // Set the message text.
                $(formMessages).text(response);

                // Clear the form.
                $("#contact-form input,#contact-form textarea").val("");
            })
            .fail(function (data) {
                // Make sure that the formMessages div has the 'error' class.
                $(formMessages).removeClass("success");
                $(formMessages).addClass("error");

                // Set the message text.
                if (data.responseText !== "") {
                    $(formMessages).text(data.responseText);
                } else {
                    $(formMessages).text(
                        "Oops! An error occured and your message could not be sent."
                    );
                }
            });
    });
})(jQuery);
