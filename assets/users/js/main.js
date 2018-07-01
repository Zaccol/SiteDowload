 (function ($) {
	"use strict";
      jQuery(document).on('ready', function() {


         
           /*---------------------------------*/
                    /*---------- Scroll to top ----------*/
                    /*---------------------------------*/
                    var scroll_top = $('.scroll-top');
                    scroll_top.on('click', function() {      // When arrow is clicked
                          $('body,html').animate({
                              scrollTop : 0                       // Scroll to top of body
                          }, 2000);
                      });


              /*================================
              ============ Top Bar =============
              =================================*/
            
            /*--show and hide scroll to top Active --*/
            var scroll_top_active =  $('.scroll-top.active');
            var scroll_top = $('.scroll-top')
              $(window).on('scroll', function() {
                  if ($(this).scrollTop() >= 50) {        // If page is scrolled more than 50px
                     scroll_top_active.removeClass('active');
                      scroll_top.addClass('active');    // Fade in the arrow
                  } else {
                      scroll_top.removeClass('active');   // Else fade out the arrow
                  }
              });

              /*================================
              ============ Test Circle =============
              =================================*/
              var test_color4 =$("#test-circle4");
              var test_color3 =$("#test-circle3");
              var test_color2 =$("#test-circle2");
              var test_color1 =$("#test-circle1");
              active(85,test_color4);
              active(75,test_color3);
              active(65,test_color2);
              active(45,test_color1);
              function active(per,id){
                id.circliful({
                          animation: 1,
                          animationStep: 1,
                          target: 20,
                          start: 2,
                          percent: per,
                          showPercent: 1,
                          backgroundColor: '#681b3f',
                          foregroundColor: '#77b047',
                          fontColor: '#681b3f',
                          iconColor: '#681b3f',
                          iconSize: '40',
                          iconPosition: 'middle'
                });
              };


               /*================================
              ============= Raindrops Effect =============
               =================================*/

                        var mobile = (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent));
                        
                        hljs.initHighlightingOnLoad();
                        hljs.configure({useBR: true});
                        jQuery('#raindrops').raindrops({color:'#fff',canvasHeight:5});
                        jQuery('#raindrops-red').raindrops({color:'#681b3f',canvasHeight:5});
                        jQuery('#raindrops-green').raindrops({color:'#3498db',canvasHeight:5});

              /*================================
              ============ Lightcase =============
              =================================*/
                var lightcase =$('a[data-rel^=lightcase]');
                jQuery(document).ready(function($) {
                lightcase.lightcase();
              });

              /*================================
              ============ Counterup =============
              =================================*/
              var counter = $('.counter');
              counter.counterUp({
                  delay: 10,
                  time: 10000
              });

              /*================================
              ============ Client Container =============
              =================================*/
              var swiper = new Swiper('.client-container', {

                nextButton: '.swiper-button-next',
                prevButton: '.swiper-button-prev',
                paginationClickable: true,
                slidesPerView: 6,
                spaceBetween: 30,
                autoplay: 500,

                loop:true,
                     breakpoints: {
                  // when window width is <= 320px
                  320: {
                    slidesPerView: 1
                  },
                  // when window width is <= 480px
                  480: {
                    slidesPerView: 2
                  },
                  // when window width is <= 767px
                  767: {
                    slidesPerView: 3

                  },
                  // when window width is <= 990px
                  990: {
                    slidesPerView: 4
                  }
                }
            });

               /*================================
              ============ Slider =============
              =================================*/
                  var slider_for = $('.slider-for');
                    slider_for.slick({
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        arrows: false,
                        draggable: false,
                        fade: true,
                        asNavFor: '.slider-nav'
                    });
                /*------------------------------------
                  Testimonial Slick Carousel as Nav
                --------------------------------------*/
                  var slider_nav = $('.slider-nav');
                    slider_nav.slick({
                        slidesToShow: 5,
                        slidesToScroll: 1,
                        asNavFor: '.slider-for',
                        dots: false,
                        arrows: true,
                        centerMode: true,
                        focusOnSelect: true,
                        centerPadding: '10px',
                        responsive: [
                            {
                              breakpoint: 450,
                              settings: {
                                dots: false,
                                slidesToShow: 5,  
                                centerPadding: '0px',
                                }
                            },
                            {
                              breakpoint: 420,
                              settings: {
                                autoplay: true,
                                dots: false,
                                slidesToShow: 1,
                                centerMode: false,
                                }
                            }
                        ]
                    });

                  /*================================
                  ============= Slick Mobile Menu =============
                  =================================*/
                  var slickNavActivation = $('#header-menu');
                   slickNavActivation.slicknav();


                   // change is-checked class on buttons
                    $(document).load(function() {
                        $('.header-navigation').each(function (i, liList) {
                            var $liList = $(liList);
                            $liList.on('click', 'li ', function () {
                                $liList.find('.menu-active').removeClass('menu-active');
                                $(this).addClass('menu-active');
                            });

                        });
                    });

                        //jQuery for page scrolling feature - requires jQuery Easing plugin
                    $('.header-navigation').each(function (i, liList) {
                        var $liList = $(liList);
                        $liList.on('click', 'li a', function (event) {
                            var $anchor = $(this);
                            $('html, body').stop().animate({
                                scrollTop: $($anchor.attr('href')).offset().top
                            }, 1500, 'easeInOutExpo');
                            event.preventDefault();
                        });
                    });


  });

  $(window).on('scroll', function() {
                /*================================
                ============= Main menu Fixed  =============
                =================================*/
                var fixed_top = $(".main-menu");
                var slicknav = $(".slicknav_menu");

                if( $(this).scrollTop() > 100 ) { 
                    fixed_top.addClass("menu-fixed animated fadeInDown");
                    slicknav.addClass("slick-position");
                }
                else{
                    fixed_top.removeClass("menu-fixed animated fadeInDown");
                     slicknav.removeClass("slick-position");
                }
                var back_top = $('#back-to-top');

                     if ($(this).scrollTop() > 100) {
                         back_top.fadeIn();
                     } else {
                         back_top.fadeOut();
                     }

                /*================================
                ============= Scroll Fixed  =============
                =================================*/
                var back_top = $('#back-to-top');

                   if ($(this).scrollTop() > 100) {
                       back_top.fadeIn();
                   } else {
                       back_top.fadeOut();
                   }
        
          
  });

  $(window).on('load',function(){
          /* ===========================
          ========== Pre-Loader ========
          ============================*/
             var preLoader = $("#preloader");
             preLoader.fadeOut(600);
  });


})(jQuery);
