// import external dependencies
import 'jquery';
import Swiper from 'swiper';

var bodyheight = window.innerHeight;
var mySwiper; // swiper object

function start_progress_bar(container, time) {
  $('.swiper-progressBar .swiper-bar', container).css('-webkit-transition', 'width ' + time + 's linear');
  $('.swiper-progressBar .swiper-bar', container).css('transition', 'width ' + time + 's linear');
  $('.swiper-progressBar .swiper-bar', container).css('width', '100%');
  return true;
}

function reset_progress_bar(container) {
  $('.swiper-progressBar .swiper-bar', container).css('-webkit-transition', 'width 0s');
  $('.swiper-progressBar .swiper-bar', container).css('transition', 'width 0s');
  $('.swiper-progressBar .swiper-bar', container).css('width', '0%');
  // console.log('reset fnc');
  return true;
}
let $progressBar = ''
let $prevthumb = ''
let $nextthumb = ''
let $bar = ''
export const sqrt = Math.sqrt;
export function swapper(options) {
  options = $.extend(true, {
    container: "", // actual swiper
    full_screen: false, // actual screen
    awesome_nav: false,
    parallax: true,
    autoplay: 500,
    swiper: {
      parallax: true,
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
        type: 'bullets',
      },
      on: {
        init: function () {
          if ($(options.container).find("nav.nav-slit").length) {
            // console.log('nav-slit founded');
            if ($('.swiper-slide', options.container).length > 1) {
              $('nav #thumb-next').attr("src", $($('.swiper-slide:nth-child(2)', options.container)).attr('data-thumb-url'));
              $('nav #thumb-prev').attr("src", $($('.swiper-slide:last', options.container)).attr('data-thumb-url'));
              $('nav #title-next').html($($('.swiper-slide:nth-child(2)', options.container)).attr('data-title'));
              $('nav #title-prev').html($($('.swiper-slide:last', options.container)).attr('data-title'));
            } else {
              $('nav #thumb-next').attr("src", $($('.swiper-slide:nth-child(1)', options.container)).attr('data-thumb-url'));
              $('nav #thumb-prev').attr("src", $($('.swiper-slide:last', options.container)).attr('data-thumb-url'));
              $('nav #title-next').html($($('.swiper-slide:nth-child(1)', options.container)).attr('data-title'));
              $('nav #title-prev').html($($('.swiper-slide:last', options.container)).attr('data-title'));
            }
          }
          if (options.autoplay) {
            $progressBar = $("<div>", {
              class: "swiper-progressBar",
            });
            $bar = $("<div>", {
              class: "swiper-bar",
            });
            $progressBar.append($bar).prependTo($(options.container));
            $('.swiper-bar').css('-webkit-transition', 'width ' + options.autoplay + 's linear');
            $('.swiper-bar').css('transition', 'width ' + options.autoplay + 's linear');
            //options.swiper['autoplay'] =options.autoplay*1000;	 
          }

          $('.swiper-slide:not(.swiper-slide-active) header .animated', options.container).each(function () {
            var animation = $(this).data('animate');
            $(this).css('opacity', '0');
            $(this).removeClass(animation);
          });
        },
      },
      // renderBullet: function (index, className) {
      // 	return '<span class="' + className + '">' + (index + 1) + '</span>';
      // },	
      calculateHeight: true,
      loop: false,
      keyboardControl: true,
      grabCursor: true,
      autoplay: false,
    },
  }, options);
  // full_screen
  if (options.full_screen) {
    if ($('body').hasClass('admin-bar')) {
      bodyheight = bodyheight - 32;
      // $('body').css("overflow", 'hidden');
    }
    $(options.container).height(bodyheight);
  }
  // awesome_nav
  if (options.awesome_nav) {
    // let first_init =  
    // options.swiper['onInit'] = first_init();
  }
  //tableContainer = swiper.parents(".swiper-container");
  // initialize a swiper
  mySwiper = new Swiper(options.container, options.swiper);
  start_progress_bar(options.container, options.autoplay);
  //			just for first init
  $('.swiper-progressBar .swiper-bar', options.container).one('transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd',
    function () {
      // code to execute after animation ends
      if ($('.swiper-bar', options.container).width() === $(options.container).width()) {
        reset_progress_bar(options.container);
        //console.log('complete transition');
        if (((mySwiper.activeIndex + 1) > ($('.swiper-slide', options.container).length - 1))) {
          mySwiper.slideTo(0);
        } else {
          mySwiper.slideNext();
        }
      }
    });
  // awesome_nav
  if (options.awesome_nav) {
    if ($(options.container).find("nav.nav-slit").length) {
      mySwiper.on('slideChange', function () {
        // console.log('slide changed');
        if ((mySwiper.activeIndex + 1) > ($('.swiper-slide', options.container).length - 1)) {
          $nextthumb = mySwiper.slides[0];
        } else {
          $nextthumb = mySwiper.slides[mySwiper.activeIndex + 1];
        }
        // console.log($($nextthumb).attr('data-thumb-url'));
        $('nav #thumb-next', options.container).attr("src", $($nextthumb).attr('data-thumb-url'));
        $('nav #title-next', options.container).html($($nextthumb).attr('data-title'));
        if (mySwiper.activeIndex <= 0) {
          $prevthumb = mySwiper.slides[$('.swiper-slide', options.container).length - 1];
        } else {
          $prevthumb = mySwiper.slides[mySwiper.activeIndex - 1];
        }
        // console.log($($prevthumb).attr('data-thumb-url'));
        $('nav #thumb-prev').attr("src", $($prevthumb).attr('data-thumb-url'));
        $('nav #title-prev').html($($prevthumb).attr('data-title'));
        //  animated content
        // console.log($('.swiper-slide header .container .animated',options.container).length);
        reset_progress_bar(options.container);
        // if ($('.swiper-slide header .animated', options.container).length) {
        // 	console.log('animation');
        // $('.swiper-slide header .animated', options.container).each(function(index) {
        //   var animation = $(this).data('animate');
        // 	$(this).css('opacity', '0');
        //   $(this).removeClass(animation);
        // });
        // }
      });
      // slider onTouchStart progress bar  
      mySwiper.on('touchStart', function () {
        reset_progress_bar(options.container);
        // console.log('ontouch');
      });
      // slider onTouchEnd progress bar 
      mySwiper.on('touchEnd', function () {
        //mySwiper.stopAutoplay();
        start_progress_bar(options.container, options.autoplay);
        $('.swiper-progressBar .swiper-bar', options.container).one('transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd',
          function () {
            // code to execute after animation ends
            if ($('.swiper-progressBar .swiper-bar', options.container).width() === $(options.container).width()) {
              reset_progress_bar(options.container);
              //console.log('complete transition');
              if (((mySwiper.activeIndex + 1) > ($('.swiper-slide', options.container).length - 1))) {
                mySwiper.slideTo(0);
              } else {
                mySwiper.slideNext();
              }
            }
          });
      });

      mySwiper.on('transitionEnd', function () {
        $('.swiper-slide header .animated', options.container).each(function () {
          var animation = $(this).data('animate');
          $(this).css('opacity', '0');
          $(this).removeClass(animation);
        });
        $('.swiper-slide.swiper-slide-active header .animated', options.container).each(function () {
          var animation = $(this).data('animate');
          $(this).css('opacity', '');
          $(this).addClass(animation);
        });
      });
      mySwiper.on('slideChange', function () {
        start_progress_bar(options.container, options.autoplay);
        $('.swiper-progressBar .swiper-bar', options.container).one('transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd',
          function () {
            // code to execute after animation ends
            if ($('.swiper-progressBar .swiper-bar', options.container).width() === $(options.container).width()) {
              reset_progress_bar(options.container);
              // console.log('complete transition');
              if (((mySwiper.activeIndex + 1) > ($('.swiper-slide', options.container).length - 1))) {
                mySwiper.slideTo(0);
              } else {
                mySwiper.slideNext();
              }
            }
          });
      });
    }
  }
  if (options.parallax) {
    var isMobile = {
      Android: function () {
        return navigator.userAgent.match(/Android/i);
      },
      BlackBerry: function () {
        return navigator.userAgent.match(/BlackBerry/i);
      },
      iOS: function () {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
      },
      Opera: function () {
        return navigator.userAgent.match(/Opera Mini/i);
      },
      Windows: function () {
        return navigator.userAgent.match(/IEMobile/i);
      },
      any: function () {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
      },
    };
    if (!isMobile.any()) {
      var targetHeight = $(options.container).outerHeight();
      var position = $(options.container).position();
      jQuery(window).scroll(function () {
        var scrollPercent = (targetHeight - (window.scrollY - position.top));
        // console.log('scrollpercent: '+ scrollPercent);
        if ((scrollPercent >= 0) && (window.scrollY > (position.top - (targetHeight * 2)))) {
          $('.swiper-slide header .container', options.container).css({
            'top': 1 - (((scrollPercent - targetHeight) / 2) - 40) + "px",
            'opacity': (scrollPercent) / targetHeight,
          });
          $('.swiper-slide header .header-image').css({
            'background-position': "50% " + ((window.scrollY - position.top) * 0.4) + "px",
          });
        }
      });
    }
  }

  // navigation button
  $('nav a.prev', options.container).on('click', function (e) {
    e.preventDefault();
    if ((mySwiper.activeIndex <= 0)) {
      mySwiper.slideTo($('.swiper-slide', options.container).length - 1);
    } else {
      mySwiper.slidePrev();
    }
  });
  $('nav a.next', options.container).on('click', function (e) {
    e.preventDefault();
    if (((mySwiper.activeIndex + 1) > ($('.swiper-slide', options.container).length - 1))) {
      mySwiper.slideTo(0);
    } else {
      mySwiper.slideNext();
    }
  });

  $(options.container).on('mouseout', function () {
    start_progress_bar(options.container, options.autoplay);
    $('.swiper-progressBar .swiper-bar', options.container).one('transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd',
      function () {
        // code to execute after animation ends
        if ($('.swiper-progressBar .swiper-bar', options.container).width() === $(options.container).width()) {
          reset_progress_bar(options.container);
          if (((mySwiper.activeIndex + 1) > ($('.swiper-slide', options.container).length - 1))) {
            mySwiper.slideTo(0);
          } else {
            mySwiper.slideNext();
          }
        }
      });
  });
}