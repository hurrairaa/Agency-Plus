(function($) {
    "use strict";
    jQuery(document).ready(function($) {

        // hero carousel
        var hero2Responsive = {
            0: {
                items: 1
            }
        };
        owlCarsouelActivate('.hero2-carousel', false, hero2Responsive, 8000, 1000, true, 'fadeOut', 1000, false);

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



        // Pricing carousel
        if ($('.pricing-tables .single-pricing-table').length > 3) {
          var pricingNav = true;
        } else {
          var pricingNav = false;
        }
        var pricingCarousel = $('.pricing-carousel');
        pricingCarousel.owlCarousel({
            loop: true,
            dots: false,
            nav: pricingNav,
            navText: ["<i class='flaticon-left-arrow'></i>", "<i class='flaticon-right-arrow'></i>"],
            autoplay: false,
            autoplayTimeout: 5000,
            smartSpeed: 1500,
            rtl: rtl == 1 ? true : false,
            items: 3,
            responsive : {
                // breakpoint from 0 up
                0 : {
                    items : 1,
                    nav: true
                },
                // breakpoint from 480 up
                768 : {
                    items : 2,
                    nav: true
                },
                // breakpoint from 768 up
                992 : {
                    items : 3
                }
            }
        });



        // Project ss carousel
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

        // testimonial carousel
        var testimonialResponsive = {
            0: {
                items: 1
            },
            992: {
                items: 2
            },
        };
        owlCarsouelActivate('.testimonial-carousel', false, testimonialResponsive, 5000, 1500, true, false, 1500, true, 30);

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
        owlCarsouelActivate('.partner-carousel', true, partnerResponsive, 3000, 500, false, false, 1500, true, 30);

        //owl carousel activate function
        function owlCarsouelActivate(selector, nav, responsive, autoplayTimeout, autoplaySpeed, dots, animateOut, smartSpeed, autoplayHoverPause, margin = 0, loop = false, autoplay = false) {
            var $selector = $(selector);
            if ($selector.length > 0) {
                $selector.owlCarousel({
                    loop: loop,
                    autoplay: false,
                    autoplayTimeout: autoplayTimeout,
                    autoplaySpeed: autoplaySpeed,
                    dots: dots,
                    nav: nav,
                    navText: ["<i class='flaticon-left-arrow'></i>", "<i class='flaticon-right-arrow'></i>"],
                    smartSpeed: smartSpeed,
                    autoplayHoverPause: autoplayHoverPause,
                    animateOut: animateOut,
                    margin: margin,
                    responsive: responsive,
                    rtl: rtl == 1 ? true : false
                });
            }
        }

        // team carousel initialization
        var teamCarousel = $('.team-carousel');
        teamCarousel.owlCarousel({
            loop: false,
            dots: false,
            margin: 30,
            autoplay: false,
            smartSpeed: 1500,
            startPosition: 2,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            rtl: rtl == 1 ? true : false,
            nav: true,
            navText: ["<i class='flaticon-left-arrow'></i>", "<i class='flaticon-right-arrow'></i>"],
            responsive: {
                0: {
                    items: 1
                },
                576: {
                    items: 2
                },
                992: {
                    items: 3
                },
                1200: {
                    items: 4
                }
            }
        });

        // blog carousel initialization
        var blogCarousel = $('.blog-carousel');
        blogCarousel.owlCarousel({
            loop: true,
            dots: false,
            margin: 22,
            autoplay: false,
            smartSpeed: 1500,
            startPosition: 2,
            autoplayTimeout: 5000,
            autoplayHoverPause: true,
            nav: true,
            rtl: rtl == 1 ? true : false,
            navText: ["<i class='flaticon-left-arrow'></i>", "<i class='flaticon-right-arrow'></i>"],
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 2
                },
                992: {
                    items: 2
                },
                1200: {
                    items: 3
                }
            }
        });

        // language dropdown toggle on clicking button
        $('.language-btn').on('click', function(event) {
            event.preventDefault();
             event.stopPropagation();
            $(this).next('.language-dropdown').toggleClass('open');
        });
        $(document).on('click', function(event) {
          if($('.language-dropdown').hasClass('open')) {
            $('.language-dropdown').removeClass('open');
          }
        });

        

        $('a.see-more').on('click', function(e) {
            e.preventDefault();
            $(this).prev('span').show();
            $(this).hide();
        })

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

        // enable bootstrap tooltip
        $('[data-toggle="tooltip"]').tooltip()

        // change is-checked class on buttons
        $('.case-types li button').on('click', function() {
            $('.case-types').find('.is-checked').removeClass('is-checked');
            $(this).addClass('is-checked');
        });

        // particles effect initialization for home 3
        if ($("#particles-js").length > 0) {
            particlesJS.load('particles-js', 'assets/front/js/particles.json');
        }

        // ripple effect initialization for home 4
        if ($("#heroHome4").length > 0) {
            $('#heroHome4').ripples({
                resolution: 500,
                dropRadius: 20,
                perturbance: 0.04
            });
        }

        // // background video initialization for home 5
        if ($("#bgndVideo").length > 0) {
            $("#bgndVideo").YTPlayer();
        }


        // project carousel
        $('.single-magnific-ss').magnificPopup({
          type: 'image',
          gallery:{
            enabled:true
          }
        });

        // video popup in magnific popup
        $('.video-play-button').magnificPopup({
            type: 'iframe',
            mainClass: 'mfp-fade',
            preloader: true,
        });

        // statistics jquery circle progressbar initialization
        var $section = $('#statisticsSection');
        if ($section.length >0) {
            $(document).bind('scroll', function (ev) {
                var scrollOffset = $(document).scrollTop();
                var containerOffset = $section.offset().top - window.innerHeight;
                if (scrollOffset > containerOffset) {
                  $('.round').each(function() {
                    $(this).circleProgress({
                      animation: {
                        duration: 1500,
                        easing: "circleProgressEasing"
                      }
                    }).on('circle-animation-progress', function(event, progress) {
                      $(this).find('strong').text(parseInt(progress*$(this).data('number')) + "+");
                    });
                  });
                  // unbind event not to load scroll again
                  $(document).unbind('scroll');
                }
            });
        }


        $('.single-ss').on('click', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            $("#singleMagnificSs"+id).trigger('click');
        });


        // announcement banner magnific popup
        if (mainbs.is_announcement == 1) {
          $('.announcement-banner').magnificPopup({
            type: 'image',
            mainClass: 'mfp-fade',
            callbacks: {
              open: function() {
                $.magnificPopup.instance.close = function() {
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
            setTimeout(function(){
              $('.announcement-banner').trigger('click');
            }, mainbs.announcement_delay*1000);
          }
        }               
      
    });

    

}(jQuery));
