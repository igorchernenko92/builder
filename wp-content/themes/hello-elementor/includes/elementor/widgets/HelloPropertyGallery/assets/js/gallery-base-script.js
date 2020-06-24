(function($) {
    const HelloGallerySkinScript = function ($scope, $) {
      function getPreViewsForCarousel($carousel) {
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
      
      const $galleries = $(".hl-gallery-1");
  
      const defaultOptionsGallery = function (params) {
        return {
          spaceBetween: 15,
          speed: 600,
          allowTouchMove: false,
          ...params,
        }
      };
  
      const initListingGallery = function ($gallery) {
        if (!$gallery) return;
  
        const perViews = getPreViewsForCarousel($gallery.parent());
    
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
          new Swiper($gallery.find("> .swiper-container"), defaultOptionsGallery({
            ...customOptions,
          }))
        }
      };
  
  
      if ($galleries.length) {
        $galleries.each(function () {
          const $gallery = $(this).find(".hl-gallery__slider");
          if (!$gallery) return;
          initListingGallery($gallery);
        })
      }
    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/hello_property_gallery.hello_gallery_skin1', HelloGallerySkinScript);
    });


})(jQuery);



