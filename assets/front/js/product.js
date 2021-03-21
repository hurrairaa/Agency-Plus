(function($) {
    "use strict";


    
    jQuery(document).ready(function($) {



        // hero carousel
        var hero2Responsive = {
            0: {
                items: 1
            }
        };
        owlCarsouelActivate('.hero2-carousel', false, hero2Responsive, 10000, 1000, true, 'fadeOut', 1000, false);

        // case carousel
        var caseResponsive = {
            0: {
                items: 1
            },
            576: {
                items: 2
            },
            992: {
                items: 3
            },
            1367: {
                items: 4
            },
            1750: {
                items: 5
            }
        };
        owlCarsouelActivate('.case-carousel', true, caseResponsive, 5000, 1500, false, false, 1500, true);

        // testimonial carousel
        var testimonialResponsive = {
            0: {
                items: 1
            },
            992: {
                items: 2
            },
        };
        owlCarsouelActivate('.testimonial-carousel', false, testimonialResponsive, 5000, 1500, false, false, 1500, true, 30);


        // testimonial carousel
        var ShopResponsive = {
            0: {
                items: 4,
                margin: 0
            },
            310: {
                items: 1,
                margin: 0
            },
            576: {
                items: 2,
                margin: 0
            },
            768: {
                items: 3,
                margin: 0
            },
            992: {
                items: 4,
                margin: 0
            },
        };
        owlCarsouelActivate('.shop-item-slide-2', false, ShopResponsive, 5000, 1500, false, false, 1500, true, 30);

        // Partner carousel
        var partnerResponsive = {
            0: {
                items: 2
            },
            576: {
                items: 3
            },
            992: {
                items: 5
            },
        };
        owlCarsouelActivate('.partner-carousel', false, partnerResponsive, 3000, 500, false, false, 1500, true, 30);

        //owl carousel activate function 
        function owlCarsouelActivate(selector, nav, responsive, autoplayTimeout, autoplaySpeed, dots, animateOut, smartSpeed, autoplayHoverPause, margin = 0, loop = false, autoplay = true) {
            var $selector = $(selector);
            if ($selector.length > 0) {
                $selector.owlCarousel({
                    loop: loop,
                    autoplay: true,
                    autoplayTimeout: autoplayTimeout,
                    autoplaySpeed: autoplaySpeed,
                    dots: dots,
                    nav: nav,
                    navText: ["<i class='flaticon-left-arrow'></i>", "<i class='flaticon-right-arrow'></i>"],
                    smartSpeed: smartSpeed,
                    autoplayHoverPause: autoplayHoverPause,
                    animateOut: animateOut,
                    margin: margin,
                    responsive: responsive
                });
            }
        }

        //===== shop slide slick slider
        $('.product-item-slide').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            loop: true,
            arrows: true,
            prevArrow: '<span class="prev"><i class="fas fa-arrow-left"></i></span>',
            nextArrow: '<span class="next"><i class="fas fa-arrow-right"></i></span>',
            fade: true,
            asNavFor: '.product-details-slide-item ul',
            rtl: rtl == 1 ? true : false
        });
          
        $('.product-details-slide-item ul').slick({
            slidesToShow: 5,
            slidesToScroll: 1,
            asNavFor: '.product-item-slide',
            dots: false,
            loop: true,
            centerMode: true,
            arrows: true,
            prevArrow: '<span class="prev"><i class="fas fa-arrow-left"></i></span>',
            nextArrow: '<span class="next"><i class="fas fa-arrow-right"></i></span>',
            centerPadding: "0",
            focusOnSelect: true,
            rtl: rtl == 1 ? true : false
        });

        if ($('.product-details-slide-item ul li').length <= 5) {
            $(".product-details-slide-item .slick-list").addClass("w-100");
            $(".product-details-slide-item .slick-track").addClass("w-100");
        } else {
            $(".product-details-slide-item .slick-list").removeClass("w-100");
            $(".product-details-slide-item .slick-track").removeClass("w-100");
        }


        // language dropdown toggle on clicking button
        $('.language-btn').on('click', function(event) {
            event.preventDefault();
            $(this).next('.language-dropdown').toggleClass('open');
        });
        // language dropdown toggle on clicking button
        $('.shop-dropdown button').on('click', function(event) {
            event.preventDefault();
            $(this).next('.language-dropdown').toggleClass('open');
        });

        // slicknav initialization
        $('#mainMenu').slicknav({
            prependTo: '#mobileMenu'
        });

        // Back to top
        $('.back-to-top').on('click', function() {
            $("html, body").animate({
                scrollTop: 0
            }, 1000);
        });

        // isotope for cases
        var $grid = $('.case-lists .cases').isotope({
            layoutMode: 'fitRows',
            itemSelector: '.single-case',
            fitRows: {
                gutter: '.case-lists .gutter-sizer'
            }
        })

        // bind filter on button click
        $('.case-types').on('click', 'button', function() {
            var filterValue = $(this).attr('data-filter');
            $grid.isotope({
                filter: filterValue
            });
        });

        // change is-checked class on buttons
        $('.case-types li button').on('click', function() {
            $('.case-types').find('.is-checked').removeClass('is-checked');
            $(this).addClass('is-checked');
        });

        // particles effect initialization for home 3
        if ($("#particles-js").length > 0) {
            particlesJS.load('particles-js', 'assets/js/particles.json');
        }

        // ripple effect initialization for home 4
        if ($("#heroHome4").length > 0) {
            $('#heroHome4').ripples({
                resolution: 500,
                dropRadius: 20,
                perturbance: 0.04
            });            
        }

        // background video initialization for home 5
        if ($("#bgndVideo").length > 0) {
            $("#bgndVideo").YTPlayer();            
        }

    });


    $(window).on('scroll', function() {
        // sticky menu activation
        if ($(window).scrollTop() > 180) {
            $('.header-area').addClass('sticky-navbar');
        } else {
            $('.header-area').removeClass('sticky-navbar');
        }

        // back to top button fade in / fade out
        if ($(window).scrollTop() > 1000) {
            $('.back-to-top').addClass('show');
        } else {
            $('.back-to-top').removeClass('show');
        }
    });


    jQuery(window).on('load', function() {
        // preloader fadeout onload
        $(".loader-container").addClass('loader-fadeout');
    });


    





    
    
    //===== product quantity
    $('.add').click(function () {
        if ($(this).prev().val()) {
            $(this).prev().val(+$(this).prev().val() + 1);
        }
    });
    $('.sub').click(function () {
        if ($(this).next().val() > 1) {
            if ($(this).next().val() > 1) $(this).next().val(+$(this).next().val() - 1);
        }
    });


    //===== Magnific Popup
    



}(jQuery));