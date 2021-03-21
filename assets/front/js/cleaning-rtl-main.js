(function ($) {
    'use strict';

    //scroll-to-top
    $(window).scroll(function () {
        if ($(this).scrollTop() >= 650) {
            $('.scroll-to-top').fadeIn(200);
        } else {
            $('.scroll-to-top').fadeOut(200);
        }
    });

    $('a.see-more').on('click', function(e) {
        e.preventDefault();
        $(this).prev('span').addClass('d-inline');
        $(this).hide();
    })

    $('.scroll-to-top').on('click', function () {
        $('html').animate({
            scrollTop: 0
        }, 1000);
    });
    //mobile-menu
    $('.primary_menu nav').meanmenu({
        meanMenuContainer: '.mobile_menu',
        meanScreenWidth: "991"
    });




    //===== Sticky

    $(window).on('scroll', function (event) {
        var scroll = $(window).scrollTop();
        if (scroll < 110) {
            $(".bottom-header-area").removeClass("sticky");
        } else {
            $(".bottom-header-area").addClass("sticky");
        }
    });



    //====search
    $(".header-search span").on('click', function () {
        $(".offcanvas-search-area").addClass("search-bar-active");
    });

    $(".close-bar i").on('click', function () {
        $(".offcanvas-search-area").removeClass("search-bar-active");
    });


    //===== hero  slick slider
    function mainSlider() {
        var BasicSlider = $('.hero-carousel-active');
        BasicSlider.on('init', function (e, slick) {
          var $firstAnimatingElements = $('.single-carousel-active:first-child').find('[data-animation]');
          doAnimations($firstAnimatingElements);
        });
        BasicSlider.on('beforeChange', function (e, slick, currentSlide, nextSlide) {
          var $animatingElements = $('.single-carousel-active[data-slick-index="' + nextSlide + '"]').find('[data-animation]');
          doAnimations($animatingElements);
        });
        BasicSlider.slick({
            autoplay: true,
            autoplaySpeed: 10000,
            dots: false,
            fade: true,
            cssEase: 'linear',
            arrows: true,
            prevArrow: '<span class="prev"><i class="fas fa-arrow-left"></i></span>',
            nextArrow: '<span class="next"><i class="fas fa-arrow-right"></i></span>',
            slidesToShow: 1,
            slidesToScroll: 1,
            rtl: true
        });
        function doAnimations(elements) {
          var animationEndEvents = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
          elements.each(function () {
            var $this = $(this);
            var $animationDelay = $this.data('delay');
            var $animationType = 'animated ' + $this.data('animation');
            $this.css({
              'animation-delay': $animationDelay,
              '-webkit-animation-delay': $animationDelay
            });
            $this.addClass($animationType).one(animationEndEvents, function () {
              $this.removeClass($animationType);
            });
          });
        }
    }
    mainSlider();

    //===== service, team,price team slick slider
    $('.service-slick, .team-slick, .pricing-slick, .blog-slick ').slick({
        dots: false,
        infinite: true,
        autoplay: false,
        autoplaySpeed: 3000,
        arrows: true,
        rtl: true,
        prevArrow: '<span class="prev"><i class="fas fa-arrow-left"></i></span>',
        nextArrow: '<span class="next"><i class="fas fa-arrow-right"></i></span>',
        speed: 1500,
        slidesToShow: 3,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1201,
                settings: {
                    slidesToShow: 3,
                }
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 1,
                }
            }
        ]
    });

    /*---------------------- 
        Hero Area Backgound Video js
    ------------------------*/
    if ($("#bgndVideo").length > 0) {
        $("#bgndVideo").YTPlayer();
    }
    /*---------------------- 
        Hero Area Backgound Video js
    ------------------------*/

    /*---------------------- 
        Hero Area Water Effect js
    ------------------------*/
    if ($("#heroHome4").length > 0) {
        $('#heroHome4').ripples({
            resolution: 500,
            dropRadius: 20,
            perturbance: 0.04
        });
    }
    /*---------------------- 
        Hero Area Water Effect js
    ------------------------*/


    /*---------------------- 
        Hero Area Particles Effect js
    ------------------------*/
    if ($("#particles-js").length > 0) {
        particlesJS.load('particles-js', 'assets/front/js/particles.json');
    }
    /*---------------------- 
        Hero Area Particles Effect js
    ------------------------*/



    //===== projects slick slider
    $('.project-slick').slick({
        dots: false,
        infinite: true,
        autoplay: false,
        autoplaySpeed: 3000,
        arrows: true,
        rtl: true,
        prevArrow: '<span class="prev"><i class="fas fa-arrow-left"></i></span>',
        nextArrow: '<span class="next"><i class="fas fa-arrow-right"></i></span>',
        speed: 1500,
        slidesToShow: 4,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1700,
                settings: {
                    slidesToShow: 4,
                }
            },
            {
                breakpoint: 1401,
                settings: {
                    slidesToShow: 3,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                }
            }
        ]
    });



    //===== testimonial slick slider
    $('.testimonial-active').slick({
        dots: true,
        infinite: true,
        autoplay: false,
        autoplaySpeed: 3000,
        arrows: false,
        rtl: true,
        prevArrow: '<span class="prev"><i class="fas fa-arrow-left"></i></span>',
        nextArrow: '<span class="next"><i class="fas fa-arrow-right"></i></span>',
        speed: 1500,
        slidesToShow: 2,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1201,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 1,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 1,
                }
            }
        ]
    });


    //===== brand-carousel-active slick slider
    $('.brand-carousel-active').slick({
        dots: true,
        infinite: true,
        autoplay: false,
        autoplaySpeed: 3000,
        arrows: false,
        rtl: true,
        prevArrow: '<span class="prev"><i class="fas fa-arrow-left"></i></span>',
        nextArrow: '<span class="next"><i class="fas fa-arrow-right"></i></span>',
        speed: 1500,
        slidesToShow: 5,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 1201,
                settings: {
                    slidesToShow: 5,
                }
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 4,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 1,
                }
            }
        ]
    });

    //===== counter up
    $('.count').counterUp({
        delay: 10,
        time: 2000
    });

    // wow js
    new WOW().init();


    //====== Magnific Popup

    $('.video-popup').magnificPopup({
        type: 'iframe',
        // other options
    });

    // announcement banner magnific popup
    if (mainbs.is_announcement == 1) {
        $('.announcement-banner').magnificPopup({
            type: 'image',
            mainClass: 'mfp-fade',
            callbacks: {
                open: function () {
                    $.magnificPopup.instance.close = function () {
                        // Do whatever else you need to do here
                        sessionStorage.setItem("announcement", "closed");
                        // console.log(sessionStorage.getItem('announcement'));

                        // Call the original close method to close the announcement
                        $.magnificPopup.proto.close.call(this);
                    };
                }
            }
        });
    }


    /*---------------------- 
        Projects Carousel js
    ------------------------*/
    var projectCarousel = $('.project-ss-carousel');
    projectCarousel.owlCarousel({
        loop: true,
        dots: true,
        nav: true,
        navText: ["<i class='flaticon-left-arrow'></i>", "<i class='flaticon-right-arrow'></i>"],
        autoplay: false,
        autoplayTimeout: 5000,
        smartSpeed: 1500,
        rtl: rtl == 1 ? true : false,
        items: 1
    });
    /*---------------------- 
        Projects Carousel js
    ------------------------*/

    // project carousel Image popup
    $('.single-magnific-ss').magnificPopup({
        type: 'image',
        gallery: {
            enabled: true
        }
    });
    $('.single-ss').on('click', function (e) {
        e.preventDefault();
        let id = $(this).data('id');
        $("#singleMagnificSs" + id).trigger('click');
    });


    $(window).on('load', function () {
        // preloader fadeout onload
        $(".loader-container").addClass('loader-fadeout');

        // preloader fadeout onload
        $(".loader-container").addClass('loader-fadeout');


        // isotope initialize
        $('.grid').isotope({
            // set itemSelector so .grid-sizer is not used in layout
            itemSelector: '.single-pic',
            percentPosition: true,
            masonry: {
                // set to the element
                columnWidth: '.grid-sizer'
            }
        });

        if (mainbs.is_announcement == 1) {
            // trigger announcement banner base on sessionStorage
            let announcement = sessionStorage.getItem('announcement') != null ? false : true;
            // console.log(sessionStorage.getItem('announcement'));
            if (announcement) {
                setTimeout(function () {
                    $('.announcement-banner').trigger('click');
                }, mainbs.announcement_delay * 1000);
            }
        }

    });
})(window.jQuery);
