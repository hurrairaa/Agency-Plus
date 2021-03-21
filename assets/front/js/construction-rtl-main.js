(function ($) {
  'use strict';

  /*---------------------------------  
      sticky header JS
  -----------------------------------*/
  $(window).on('scroll', function () {
    var scroll = $(window).scrollTop();
    if (scroll < 100) {
      $(".finlance_header").removeClass("sticky");
    } else {
      $(".finlance_header").addClass("sticky");
    }
  });
  /*---------------------------------  
      sticky header JS
  -----------------------------------*/

  $('a.see-more').on('click', function (e) {
    e.preventDefault();
    $(this).prev('span').show();
    $(this).hide();
  })

  /*---------------------------------  
     Search JS
 -----------------------------------*/
  $(".search_icon,.close_link").on('click', function (e) {
    e.preventDefault();
    $(".search_wrapper").toggleClass("active");
  });
  /*---------------------------------  
      Meanmenu JS
  -----------------------------------*/
  $('.primary_menu nav').meanmenu({
    meanMenuContainer: '.mobile_menu',
    meanScreenWidth: "991"
  });
  /*---------------------------------  
      Meanmenu JS
  -----------------------------------*/
  /*---------------------- 
     Slick Slider js
  ------------------------*/
  // mainSlider
  function mainSlider() {
    var BasicSlider = $('.hero_slide_v1');
    BasicSlider.on('init', function (e, slick) {
      var $firstAnimatingElements = $('.single_slider:first-child').find('[data-animation]');
      doAnimations($firstAnimatingElements);
    });
    BasicSlider.on('beforeChange', function (e, slick, currentSlide, nextSlide) {
      var $animatingElements = $('.single_slider[data-slick-index="' + nextSlide + '"]').find('[data-animation]');
      doAnimations($animatingElements);
    });
    BasicSlider.slick({
      autoplay: true,
      autoplaySpeed: 10000,
      dots: false,
      fade: true,
      arrows: true,
      rtl: true,
      slidesToShow: 1,
      slidesToScroll: 1
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




  $('.service-slick,.pricing-slick,.blog-slick').slick({
    dots: false,
    arrows: true,
    infinite: true,
    speed: 300,
    rtl: true,
    autoplay: true,
    slidesToShow: 3,
    slidesToScroll: 1,
    responsive: [
      {
        breakpoint: 992,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2,
        }
      },
      {
        breakpoint: 780,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
  });


  $('.team-slick').slick({
    dots: false,
    arrows: true,
    infinite: true,
    speed: 300,
    autoplay: false,
    slidesToShow: 4,
    slidesToScroll: 1,
    rtl: true,
    responsive: [
      {
        breakpoint: 992,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3,
        }
      },
      {
        breakpoint: 780,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
  });


  $('.testimonial_slide').slick({
    dots: false,
    arrows: false,
    infinite: true,
    speed: 300,
    rtl: true,
    autoplay: true,
    slidesToShow: 2,
    slidesToScroll: 1,
    responsive: [
      {
        breakpoint: 992,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2,
        }
      },
      {
        breakpoint: 780,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
  });
  $('.project-slick').slick({
    dots: false,
    arrows: true,
    infinite: true,
    speed: 300,
    rtl: true,
    autoplay: true,
    slidesToShow: 4,
    slidesToScroll: 1,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 2,
        }
      },
      {
        breakpoint: 780,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
  });
  $('.partner_slide').slick({
    dots: false,
    arrows: false,
    infinite: true,
    speed: 600,
    rtl: true,
    autoplay: true,
    slidesToShow: 5,
    slidesToScroll: 1,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3,
        }
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
  });
  /*---------------------- 
      Slick Slider js
  ------------------------*/

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
      Hero Area Particles Effect js
  ------------------------*/
  if ($("#particles-js").length > 0) {
    particlesJS.load('particles-js', 'assets/front/js/particles.json');
  }
  /*---------------------- 
      Hero Area Particles Effect js
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

  /*---------------------- 
      magnific-popup js
  ----------------------*/
  $('.play_btn').magnificPopup({
    type: 'iframe',
    removalDelay: 300,
    mainClass: 'mfp-fade'
  });
  /*---------------------- 
      magnific-popup js
  ----------------------*/

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
      Counter js
  ------------------------*/
  $('.counter').counterUp({
    delay: 100,
    time: 1000
  });
  // wow js
  new WOW().init();
  /*---------------------- 
      Scroll top js
  ------------------------*/
  $(window).on('scroll', function () {
    if ($(this).scrollTop() > 100) {
      $('#scroll_up').fadeIn();
    } else {
      $('#scroll_up').fadeOut();
    }
  });
  $('#scroll_up').on('click', function () {
    $("html, body").animate({
      scrollTop: 0
    }, 600);
    return false;
  });
  /*---------------------- 
      Scroll top js
  ------------------------*/


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