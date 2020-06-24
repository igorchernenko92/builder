(function($) {
  const HelloPropertySkinScript = function ($scope, $) {
    function getPreViewsForCarousel($carousel) {
      const slidesPerView = {};
      const carouselWidth = {
        "laptop": $carousel.width() > 991,
        "tablet": ($carousel.width() > 600) && ($carousel.width() <= 991),
        "mobileXm": ($carousel.width() > 480) && ($carousel.width() <= 600),
        "mobileSm": $carousel.width() <= 480
      };
      
      if (carouselWidth.laptop) {
        slidesPerView.laptop = 3;
        slidesPerView.tablet = 2;
        slidesPerView.mobileXm = 1;
        slidesPerView.mobileSm = 1;
      } else if (carouselWidth.mobileXm || carouselWidth.tablet) {
        slidesPerView.laptop = 2;
        slidesPerView.tablet = 2;
        slidesPerView.mobileXm = 2;
        slidesPerView.mobileSm = 1;
      } else if (carouselWidth.mobileSm) {
        slidesPerView.laptop = 1;
        slidesPerView.tablet = 1;
        slidesPerView.mobileXm = 1;
        slidesPerView.mobileSm = 1;
      }
      
      return slidesPerView;
    }
    
    const $carousels = $(".hl-listings-carousel");
    const $listings = $(".hl-listing-card:not('.swiper-slide > .hl-listing-card')");
    
    const defaultOptionsByListingSlider = function (params) {
      return {
        spaceBetween: 0,
        slidesPerView: 1,
        speed: 500,
        preloadImages: false,
        lazy: true,
        ...params,
      }
    };
    
    const initListingSlider = function ($slider) {
      if (!$slider) return;
      
      const customOptions = {
        navigation: {
          nextEl: $slider.find(".hl-listing-card__carousel-nav_next"),
          prevEl: $slider.find(".hl-listing-card__carousel-nav_prev")
        },
      };
      
      if (!$slider.find("> .swiper-container").hasClass("swiper-container-initialized")) {
        new Swiper($slider.find("> .swiper-container"), defaultOptionsByListingSlider({
          ...customOptions,
        }))
      }
    };
    
    const defaultOptionsByCarousel = function (params) {
      return {
        spaceBetween: 30,
        speed: 500,
        preloadImages: false,
        on: {
          init: function () {
            const $listings = $(this.$el).find(".hl-listing-card");
            
            if ($listings.length) {
              $listings.each(function () {
                const $slider = $(this).find(".hl-listing-card__carousel");
                if (!$slider) return;
                initListingSlider($slider);
              })
            }
          }
        },
        ...params,
      }
    };
    
    const initCarousels = function () {
      function initCarousel($swiper) {
        if (!$swiper) return;
        
        const perViews = getPreViewsForCarousel($swiper.parent());
        
        const customOptions = {
          navigation: {
            nextEl: $swiper.closest(".hl-listings-carousel").find(".hl-listings-carousel__nav_next"),
            prevEl: $swiper.closest(".hl-listings-carousel").find(".hl-listings-carousel__nav_prev"),
          },
          pagination: {
            el: $swiper.closest(".hl-listings-carousel").find(".hl-listings-carousel__pagination"),
            clickable: true,
            type: "bullets",
          },
          slidesPerView: perViews.laptop,
          autoHeight: perViews.laptop === 1,
          breakpoints: {
            480: {
              slidesPerView: perViews.mobileSm,
              autoHeight: perViews.mobileSm === 1,
            },
            600: {
              slidesPerView: perViews.tablet,
              autoHeight: perViews.tablet === 1,
            },
            991: {
              slidesPerView: perViews.laptop,
              autoHeight: perViews.laptop === 1,
            },
          },
        };
        
        if (!$swiper.hasClass("swiper-container-initialized")) {
          new Swiper($swiper, defaultOptionsByCarousel({
            ...customOptions,
          }))
        }
      }
      
      $carousels.each(function () {
        const $carousel = $(this).find("> .swiper-container");
        if (!$carousel) return;
        initCarousel($carousel);
      })
    };
    
    
    if ($carousels.length) {
      initCarousels();
    }
    
    if ($listings.length) {
      $listings.each(function () {
        const $slider = $(this).find(".hl-listing-card__carousel");
        if (!$slider) return;
        initListingSlider($slider);
      })
    }
  };
  
  $(window).on('elementor/frontend/init', function () {
    elementorFrontend.hooks.addAction('frontend/element_ready/property.skin1', HelloPropertySkinScript);
    elementorFrontend.hooks.addAction('frontend/element_ready/property.skin2', HelloPropertySkinScript);
    elementorFrontend.hooks.addAction('frontend/element_ready/property.skin3', HelloPropertySkinScript);
  });
  
  
})(jQuery);



