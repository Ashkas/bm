// Fancybox for lightboxes
import '@fancyapps/fancybox/dist/jquery.fancybox.min.js';

// Slick carousel
//import 'bootstrap/dist/js/bootstrap';
//import 'slick-carousel/slick/slick.min';

// Swiper
//import Swiper from 'swiper';

// Owl Carousel
import 'owl.carousel/dist/owl.carousel';

// Read more
import 'readmore-js/readmore.js';

export default {
  init() {
    //var test = new Foundation.Accordion($('.tabs'));

		//$.fancybox.defaults.hash = false;

		// FancyBox
		$(document).ready(function () {

			var RotateImage = function (instance) {
        this.instance = instance;

        this.init();
      };

      $.extend(RotateImage.prototype, {
        $button_left: null,
        $button_right: null,
        transitionanimation: true,

        init: function () {
          var self = this;

  /*
          self.$button_left = $('<button data-rotate-left class="fancybox-button fancybox-button--rotate" title="Rotate to left"><i class="fas fa-undo" aria-hidden="true"></i></button>')
          .prependTo(this.instance.$refs.toolbar)
          .on('click', function () {
            self.rotate('left');
          });
  */

          self.$button_right = $('<button data-rotate-right class="fancybox-button fancybox-button--rotate" title="Rotate to right"><svg version="1.1" id="CW" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 20 20" enable-background="new 0 0 20 20" xml:space="preserve"><path fill="#FFFFFF" d="M19.315,10h-2.372V9.795c-0.108-4.434-3.724-7.996-8.169-7.996C4.259,1.799,0.6,5.471,0.6,10 s3.659,8.199,8.174,8.199c1.898,0,3.645-0.65,5.033-1.738l-1.406-1.504c-1.016,0.748-2.27,1.193-3.627,1.193 c-3.386,0-6.131-2.754-6.131-6.15s2.745-6.15,6.131-6.15c3.317,0,6.018,2.643,6.125,5.945V10h-2.672l3.494,3.894L19.315,10z"/></svg></button>')
          .prependTo(this.instance.$refs.toolbar)
          .on('click', function () {
            self.rotate('right');
          });
        },

        rotate: function (direction) {
          var self = this;
          var image = self.instance.current.$image[0];
          var angle = parseInt(self.instance.current.$image.attr('data-angle')) || 0;

          if (direction == 'right') {
            angle += 90;
          } else {
            angle -= 90;
          }

          if (!self.transitionanimation) {
            angle = angle % 360;
          } else {
            $(image).css('transition', 'transform .3s ease-in-out');
          }

          self.instance.current.$image.attr('data-angle', angle);

          $(image).css('webkitTransform', 'rotate(' + angle + 'deg)');
          $(image).css('mozTransform', 'rotate(' + angle + 'deg)');
        },
      });

      $(document).on('onInit.fb', function (e, instance) {
        if (!instance.opts.rotate) {
          instance.Rotate = new RotateImage(instance);
        }
      });

			$('[data-fancybox="work-gallery"]').fancybox({
				protect: true,
				preventCaptionOverlap: true,
				buttons : [
					'zoom',
					//'rotate',
					'fullScreen',
					'thumbs',
					'close',
				],
				transitionEffect : 'fade',
      });

			// Owl Carousel DOM Elements
      var sync1 = $('#work-slider'),
      sync2 = $('#work-slider-nav'),
      slidesPerPage_mob = 4,
      slidesPerPage_tab = 3,
      slidesPerPage_desk = 5,
      syncedSecondary = true;

      sync1.owlCarousel({
        items : 1,
        nav: true,
        autoplay: false,
        autoHeight:true,
        dots: false,
        loop: false,
        animateOut: 'fadeOut',
        lazyLoad : true,
        responsiveRefreshRate : 200,
        navText: ['<span class="slider-nav-icon icon-chevron-thin-left"></span>','<span class="slider-nav-icon icon-chevron-thin-right"></span>'],
      }).on('changed.owl.carousel', syncPosition);

      sync2
        .on('initialized.owl.carousel', function () {
          sync2.find('.owl-item').eq(0).addClass('current');
        })
        .owlCarousel({
        items : slidesPerPage_mob,
        dots: false,
        nav: true,
        smartSpeed: 200,
        slideSpeed : 500,
        navText: ['<span class="slider-nav-icon icon-chevron-thin-left"></span>','<span class="slider-nav-icon icon-chevron-thin-right"></span>'],
        slideBy: slidesPerPage_mob, //alternatively you can slide by 1, this way the active slide will stick to the first item in the second carousel
        responsive : {
          // breakpoint from 0 up
          0 : {
            items : slidesPerPage_mob,
            slideBy: slidesPerPage_mob,
          },
          // breakpoint from 768 up
          728 : {
            items : slidesPerPage_tab,
            slideBy: slidesPerPage_tab,
          },
          // breakpoint from 992 up
          992 : {
            items : slidesPerPage_desk,
            slideBy: slidesPerPage_desk,
          },
        },
        responsiveRefreshRate : 100,
        })
        .on('changed.owl.carousel', syncPosition2)
        .on('resized.owl.carousel', function(){
          //$('.ui.sticky').sticky('destroy');
          if ($(window).width() >= 767.98) {
            $('.ui.sticky').sticky({
              context: '#work-image',
              offset: 60,
            });
          }
        });

      function syncPosition(el) {
        //if you set loop to false, you have to restore this next line
        var current = el.item.index;

        // $('.ui.sticky').sticky('destroy');
        // if ($(window).width() >= 767.98) {
        //   $('.ui.sticky').sticky({
        //     context: '#work-image',
        //     offset: 60,
        //   });
        // }

        //if you disable loop you have to comment this block
        // var count = el.item.count-1;
        // var current = Math.round(el.item.index - (el.item.count/2) - .5);

        // if(current < 0) {
        //   current = count;
        // }
        // if(current > count){
        //   current = 0;
        // }

        //end block

        sync2
          .find('.owl-item')
          .removeClass('current')
          .eq(current)
          .addClass('current');
        var onscreen = sync2.find('.owl-item.active').length - 1;
        var start = sync2.find('.owl-item.active').first().index();
        var end = sync2.find('.owl-item.active').last().index();

        if (current > end) {
          sync2.data('owl.carousel').to(current, 100, true);
        }
        if (current < start) {
          sync2.data('owl.carousel').to(current - onscreen, 100, true);
        }
      }

      function syncPosition2(el) {
        if(syncedSecondary) {
          var number = el.item.index;
          sync1.data('owl.carousel').to(number, 100, true);
        }
        //$('.ui.sticky').sticky('destroy');
        // if ($(window).width() >= 767.98) {
        //   // $('.ui.sticky').sticky('destroy');
        //   $('.ui.sticky').sticky({
        //     context: '#work-image',
        //     offset: 60,
        //   });
        // }
      }

      sync2.on('click', '.owl-item', function(e){
        e.preventDefault();
        var number = $(this).index();
        sync1.data('owl.carousel').to(number, 300, true);
      });

		});

    // Readmore
    $('.work-comment, .work-special-notes').readmore({
        speed: 200,
        collapsedHeight: 156,
        moreLink: '<p class="read-more"><a href="#"><i class="icon-add-circle"></i> Read more</a></p>',
        lessLink: '<p class="read-more"><a href="#"><i class="icon-remove-circle"></i> Read less</a></p>',
        afterToggle: function() {
          //$('.ui.sticky').sticky('refresh');
        },
    });

		// Modal
		$('#open_modal').click(function(){
			$('.fullscreen.modal').modal('show');
		});
		$('.fullscreen.modal').modal({
			closable: true,
		});

    // Sticky
    // NOTE: DAVID May 2020
    // Turning off sticky because it doesn't work friendly with auto height, which is needed with the variable height images
    // $(document).ready(function(){
    //   if($(window).width() >= 767.98){
    //     $('.ui.sticky').sticky({
    //       context: '#work-image',
    //       offset: 60,
    //     });
    //   }
    // });

    // $(window).resize(function(){
    //   if($(window).width() >= 767.98 ){
    //     $('.ui.sticky').sticky({
    //       context: '#work-image',
    //       offset: 60,
    //     });
    //   } else {
    //     $('.ui.sticky').sticky('destroy');
    //   }
    // });

    // Accordian
    //$('.ui.accordion').accordion();

    // Tabs
    //$('.menu .item').tab();

    $('.archive-description-read').readmore({
      speed: 200,
      collapsedHeight: 364,
      moreLink: '<p class="read-more"><a href="#"><i class="icon-add-circle"></i> Read more</a></p>',
      lessLink: '<p class="read-more"><a href="#"><i class="icon-remove-circle"></i> Read less</a></p>',
  });
  },
  finalize() {
  },
};
