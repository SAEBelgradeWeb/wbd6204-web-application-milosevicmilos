

$(document).ready( function() {
    'use strict';
    /*-----------------------------------
    Navbar
    -----------------------------------*/
    $('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
      var $el = $(this);
      var $parent = $(this).offsetParent(".dropdown-menu");
      if (!$(this).next().hasClass('show')) {
        $(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
      }
      var $subMenu = $(this).next(".dropdown-menu");
      $subMenu.toggleClass('show');
      
      $(this).parent("li").toggleClass('show');

      $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function (e) {
        $('.dropdown-menu .show').removeClass("show");
      });
      
      if (!$parent.parent().hasClass('navbar-nav')) {
        $el.next().css({"top": $el[0].offsetTop, "left": $parent.outerWidth() - 4});
      }

      return false;
    });

    if($(window).width() < 992) {
      $(document).on('click', function(event) {
        var clickover = $(event.target);
        var _opened = $('#navbarSupportedContent').hasClass('show');
        if(_opened === true && !(clickover.is('.navbar-nav li, .navbar-nav .dropdown *'))) {
          $('button.navbar-toggler').trigger('click');
        }
      });
    }

    /*-------------------------------------
      Share Icon
    -------------------------------------*/

    $('.post-line-style .share').on('click', function(e) {
      e.preventDefault();
      $(this).siblings('.share-icons').fadeToggle();
    })

    /*-------------------------------------
      tooltip
    -------------------------------------*/

    $('.user-number i').tooltip();

    /*-------------------------------------
      PRICING CONTROL 
    -------------------------------------*/

    $('.switch-wrap').on('click', function() {
      $(this).children('.switch').toggleClass('year-active');
      $('.duration-month').toggleClass('active');
      $('.duration-year').toggleClass('active');
      $('.monthly-rate').toggleClass('hidden');
      $('.yearly-rate').toggleClass('hidden');
    });

    /*-----------------------------------
    Back to Top
    -----------------------------------*/
    $('.backtotop').on('click', function() {
      $("html, body").animate({
        scrollTop: 0
      }, 600);
      return false;
    })

    $('.back-to-top').on('click', function() {
      $("html, body").animate({
        scrollTop: 0
      }, 600);
      return false;
    })

    /*-----------------------------------
    CountTo 
    -----------------------------------*/
    function animateCountTo(ct) {
      if ($.fn.visible && $(ct).visible() && !$(ct).hasClass('animated')) {
        $(ct).countTo({
          speed: 1000,
          refreshInterval: 1
        });
        $(ct).addClass('animated');
      }
    }

    function initCountTo() {
      var counter = $('.count');
      counter.each(function () {
        animateCountTo(this);
      });
    }

    initCountTo();

    /*-------------------------------------
      MAGNIFIC POPUP
    -------------------------------------*/

    if ($(".main-promo").length > 0) {
      $('.main-promo').magnificPopup({
        type: 'iframe',
        gallery: {
          enabled: true,
        },
      });

      $.extend(true, $.magnificPopup.defaults, {
        iframe: {
          patterns: {
            youtube: {
              index: 'youtube.com/',
              id: 'v=',
              src: 'https://www.youtube.com/embed/%id%?autoplay=1'
            }
          }
        }
      });
    }

    if ($(".intro-wrapper .intro-button").length > 0) {
      $('.intro-wrapper .intro-button').magnificPopup({
        type: 'iframe',
        gallery: {
          enabled: true,
        },
      });

      $.extend(true, $.magnificPopup.defaults, {
        iframe: {
          patterns: {
            youtube: {
              index: 'youtube.com/',
              id: 'v=',
              src: 'https://www.youtube.com/embed/%id%?autoplay=1'
            }
          }
        }
      });
    }

    /*-------------------------------------
      Plyr Js  
    -------------------------------------*/
    const player = new Plyr('#player');

    /*-------------------------------------
    owlCarousel
    -------------------------------------*/
    $('.banner-slider').owlCarousel({
      loop:true,
      autoplay: true,
      autoplayHoverPause: true,
      autoplaySpeed: 1000,
      margin:0,
      dots: false,
      nav:true,
      navText: ['<span class="ti-angle-left"></span>','<span class="ti-angle-right"></span>'],
      responsive:{
        0:{
          items:1
        }
      }
    })

    $('.post-slider').owlCarousel({
      loop:true,
      autoplay: false,
      margin:0,
      animateOut: 'fadeOut',
      animateIn: 'fadeIn',
      dots: false,
      nav:true,
      navText: ['<span class="ti-angle-left"></span>','<span class="ti-angle-right"></span>'],
      responsive:{
        0:{
          items:1
        }
      }
    })

    $('.portfolio-details-slider').owlCarousel({
      loop:true,
      autoplay: true,
      margin:0,
      dots: true,
      nav:false,
      responsive:{
        0:{
          items:1
        }
      }
    })

    $('.portfolio-slider-fullwidth').owlCarousel({
      loop:true,
      autoplay: true,
      margin: 15,
      autoplayHoverPause: true,
      dots: true,
      nav: false,
      responsive:{
        0:{
            items:1
        },
        576:{
            items:2
        },
        768:{
            items:3
        },
        1200:{
            items:4
        }
      }
    })

    $('.post-details-slider').owlCarousel({
      loop:true,
      autoplay: false,
      margin:0,
      animateOut: 'fadeOut',
      animateIn: 'fadeIn',
      dots: false,
      nav:true,
      navText: ['<span class="ti-angle-left"></span>','<span class="ti-angle-right"></span>'],
      responsive:{
        0:{
          items:1
        }
      }
    })
    
    /*-------------------------------------
      ROUNDED PROGRESSBAR
    -------------------------------------*/
    function animateRoundedProgress(rpb) {
      if ($.fn.visible && $(rpb).visible() && !$(rpb).hasClass('animated') && $(rpb).hasClass('circle-sm')) {
        $(rpb).css('stroke-dashoffset', 351.858377 - (351.858377 / 100) * $(rpb).attr('aria-valuenow'));
      }
    } 

    function initRoundedProgress() {
      var roundedProgress = $('.progress-circle');
      roundedProgress.each(function () {
        animateRoundedProgress(this);
      });
    }

    initRoundedProgress();

    /*-------------------------------------
      FILTER BUTTON
    -------------------------------------*/

    if ($(window).width() > 575) {
      $('.filter').on('click', function() {
        $(this).fadeOut();
        $('.iso-nav').fadeIn();
      })

      $('.portfolio-filter .iso-nav .all').on('click', function() {
        $('.iso-nav').fadeOut();
        $('.portfolio-filter .filter').fadeIn();
      })
    }

    /*-------------------------------------
    Isotope
    -------------------------------------*/
    // init Isotope
    var $grid = $('.iso-gallery').isotope({
      // options...
      itemSelector: '.iso-gallery>div',
      masonry: {
        columnWidth: 0
      }
    });
    // layout Isotope after each image loads
    $grid.imagesLoaded().progress(function () {
      $grid.isotope('layout');
    });

    $('#iso-nav .btn').on('click', function () {
      $('#iso-nav .btn-filter').removeClass('active');
      $(this).addClass('active');

      var selector = $(this).attr('data-filter');
      $('.iso-gallery').isotope({
          filter: selector
      });
      return false;
    });

    /*-------------------------------------
      MASONARY
    -------------------------------------*/

    // init Isotope
    var $grid = $('.masonary').isotope({
        // options...
        itemSelector: '.col-lg-4',
        masonry: {
            columnWidth: 0
        }
    });
    // layout Isotope after each image loads
    $grid.imagesLoaded().progress(function () {
        $grid.isotope('layout');
    });

    $('#iso-nav .btn').on('click', function () {
        $('#iso-nav .btn-filter').removeClass('active');
        $(this).addClass('active');

        var selector = $(this).attr('data-filter');
        $('.masonary').isotope({
            filter: selector
        });
        return false;
    });


    /*-----------------------------------
    Subscription
    -----------------------------------*/
    $(".subscribtion-form").ajaxChimp({
      callback: mailchimpResponse,
      url: "http://codepassenger.us10.list-manage.com/subscribe/post?u=6b2e008d85f125cf2eb2b40e9&id=6083876991" // Replace your mailchimp post url inside double quote "".  
    });

    function mailchimpResponse(resp) {
      if (resp.result === 'success') {
        $('.newsletter-success').html(resp.msg).fadeIn().delay(3000).fadeOut();
      } else if (resp.result === 'error') {
        $('.newsletter-error').html(resp.msg).fadeIn().delay(3000).fadeOut();
      }
    }

    /*-----------------------------------
    Contact Form
    -----------------------------------*/
    // Function for email address validation
    function isValidEmail(emailAddress) {
        var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);

        return pattern.test(emailAddress);

    }
    $("#contactForm").on('submit', function (e) {
        e.preventDefault();
        var data = {
            name: $("#name").val(),
            email: $("#email").val(),
            phone: $("#phone").val(),
            message: $("#message").val()
        };

        if (isValidEmail(data['email']) && (data['message'].length > 1) && (data['name'].length > 1) && (data['phone'].length > 1)) {
          $.ajax({
            type: "POST",
            url: "sendmail.php",
            data: data,
            success: function () {
              $('#contactForm .input-success').delay(500).fadeIn(1000);
              $('#contactForm .input-error').fadeOut(500);
            }
          });
        } else {
          $('#contactForm .input-error').delay(500).fadeIn(1000);
          $('#contactForm .input-success').fadeOut(500);
        }
        return false;
    });

    /*-------------------------------------
    Window Scroll
    -------------------------------------*/
    $(window).on('scroll', function () {
      initCountTo();
      initRoundedProgress();
    });
})


$(window).on('scroll', function () {
  $('.testimonial').owlCarousel({
    loop:true,
    autoplay: false,
    margin:0,
    dots: false,
    nav:true,
    navText: ['<span class="ti-arrow-left"></span>','<span class="ti-arrow-right"></span>'],
    responsive:{
      0:{
        items:1
      }
    }
  })

  $('.case-study-slider').owlCarousel({
    loop:true,
    autoplay: false,
    margin: 10,
    dots: true,
    nav:true,
    navText: ['<span class="ti-arrow-left"></span>','<span class="ti-arrow-right"></span>'],
    responsive:{
      0:{
          items:1
      },
      575:{
          items:2
      },
      768:{
          items:3
      },
      1200:{
          items:4
      }
    }
  })

  $('.client-logos').owlCarousel({
    loop:true,
    autoplay: true,
    margin: 10,
    dots: false,
    nav:false,
    responsive:{
      0:{
          items:2
      },
      575:{
          items:3
      },
      768:{
          items:5
      },
      1200:{
          items:6
      }
    }
  })

});
