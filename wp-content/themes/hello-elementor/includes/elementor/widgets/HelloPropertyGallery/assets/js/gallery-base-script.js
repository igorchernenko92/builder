(function($) {
    const HelloGallerySkinScript = function ($scope, $) {
      function getPreViews($carousel) {
        const slidesPerView = {};
        const carouselWidth = {
          "laptop": $carousel.width() > 991,
          "tablet": ($carousel.width() > 600) && ($carousel.width() <= 991),
          "mobileXm": ($carousel.width() > 480) && ($carousel.width() <= 600),
          "mobileSm": $carousel.width() <= 480
        };
    
        if (carouselWidth.laptop) {
          slidesPerView.laptop = "auto";
        } else if (carouselWidth.mobileXm || carouselWidth.tablet) {
          slidesPerView.laptop = 1;
        } else if (carouselWidth.mobileSm) {
          slidesPerView.laptop = 1;
        }
        
        if (carouselWidth.tablet || carouselWidth.mobileXm || carouselWidth.mobileSm) {
          $carousel.find("> .hl-gallery__slider").addClass("hl-gallery__slider_full")
        }
    
        return slidesPerView;
      }
  
      
      // Gallery 1
      const $galleries_1 = $(".hl-gallery-1");
  
      const defaultOptionsGallery1 = function (params) {
        return {
          spaceBetween: 15,
          speed: 600,
          allowTouchMove: false,
          ...params,
        }
      };
  
      const initListingGallery1 = function ($gallery) {
        if (!$gallery) return;
  
        const perViews = getPreViews($gallery.parent());
    
        const customOptions = {
          navigation: {
            nextEl: $gallery.find(".hl-gallery__slider-nav_next"),
            prevEl: $gallery.find(".hl-gallery__slider-nav_prev")
          },
          pagination: {
            el: $gallery.find(".hl-gallery__slider-pagination"),
            clickable: true,
            type: "bullets",
          },
          slidesPerView: perViews.laptop,
          breakpoints: {
            991: {
              allowTouchMove: true,
            },
            0: {
              allowTouchMove: true,
              slidesPerView: 1,
            }
          },
        };
    
        if (!$gallery.find("> .swiper-container").hasClass("swiper-container-initialized")) {
          new Swiper($gallery.find("> .swiper-container"), defaultOptionsGallery1({
            ...customOptions,
          }))
        }
      };
      
      if ($galleries_1.length) {
        $galleries_1.each(function () {
          const $gallery = $(this).find(".hl-gallery__slider");
          if (!$gallery) return;
          initListingGallery1($gallery);
        })
      }
  
  
      // Gallery 2
      const $galleries_2 = $(".hl-gallery-2");
      if ($galleries_2.length) {
        $galleries_2.each(function () {
          if ($(this).width() > 991) {
            $(this).addClass("hl-gallery-2_large")
          }
        })
      }
      
      
      // Gallery 3
      const $galleries_3 = $(".hl-gallery-3");
  
      const initListingGallery3 = function ($gallery_top, $gallery_thumbs) {
        let sliderThumbsState = null;
        let sliderTopState = null;
  
        if (!$gallery_thumbs.hasClass("swiper-container-initialized")) {
          sliderThumbsState = new Swiper($gallery_thumbs, {
            spaceBetween: 10,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesVisibility: true,
            watchSlidesProgress: true,
            speed: 600,
          });
        }
        
        if (!$gallery_top.hasClass("swiper-container-initialized")) {
          sliderTopState = new Swiper($gallery_top, {
            spaceBetween: 10,
            navigation: {
              nextEl: $gallery_top.find(".hl-gallery__slider-nav_next"),
              prevEl: $gallery_top.find(".hl-gallery__slider-nav_prev")
            },
            speed: 600,
            thumbs: {
              swiper: sliderThumbsState
            }
          });
        }
      };
  
      if ($galleries_3.length) {
        $galleries_3.each(function () {
          const $gallery_top = $(this).find(".hl-gallery__slider-top");
          const $gallery_thumbs = $(this).find(".hl-gallery__slider-thumbs");
          if (!$gallery_top && !$gallery_thumbs) return;
          initListingGallery3($gallery_top, $gallery_thumbs);
        })
      }
    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/hello_property_gallery.hello_gallery_skin1', HelloGallerySkinScript);
        elementorFrontend.hooks.addAction('frontend/element_ready/hello_property_gallery.hello_gallery_skin2', HelloGallerySkinScript);
        elementorFrontend.hooks.addAction('frontend/element_ready/hello_property_gallery.hello_gallery_skin3', HelloGallerySkinScript);
    });

})(jQuery);



