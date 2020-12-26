(function($) {
  const HelloPropertySkin1Script = function ($scope, $) {
    const $sliders = $(".hl-property-slider-1");

    const defaultOptions = function (params) {
      return {
        spaceBetween: 15,
        effect: 'fade',
        speed: 600,
        ...params,
      }
    };

    const initListingGallery1 = function ($slider) {
      if (!$slider) return;

      const customOptions = {
        navigation: {
          nextEl: $slider.find(".hl-property-slider__nav_next"),
          prevEl: $slider.find(".hl-property-slider__nav_prev")
        },
        slidesPerView: 1,
      };

      if (!$slider.find("> .swiper-container").hasClass("swiper-container-initialized")) {
        new Swiper($slider.find("> .swiper-container"), defaultOptions({
          ...customOptions,
        }))
      }
    };

    if ($sliders.length) {
      $sliders.each(function () {
        initListingGallery1($(this));
      })
    }
  };

  const HelloPropertySkin2Script = function ($scope, $) {
    const $sliders = $(".hl-property-slider-2");

    const defaultOptions = function (params) {
      return {
        speed: 800,
        ...params,
      }
    };

    const initListingGallery1 = function ($slider) {
      if (!$slider) return;

      const customOptions = {
        navigation: {
          nextEl: $slider.find(".hl-property-slider__nav_next"),
          prevEl: $slider.find(".hl-property-slider__nav_prev")
        },
        pagination: {
          el: $slider.find(".hl-property-slider__pagination"),
          clickable: true,
          type: "bullets",
        },
        slidesPerView: 1,
      };

      if (!$slider.find("> .swiper-container").hasClass("swiper-container-initialized")) {
        new Swiper($slider.find("> .swiper-container"), defaultOptions({
          ...customOptions,
        }))
      }
    };

    if ($sliders.length) {
      $sliders.each(function () {
        initListingGallery1($(this));
      })
    }
  };

  $(window).on('elementor/frontend/init', function () {
    elementorFrontend.hooks.addAction('frontend/element_ready/hello_property_slider.skin1', HelloPropertySkin1Script);
    elementorFrontend.hooks.addAction('frontend/element_ready/hello_property_slider.skin2', HelloPropertySkin2Script);
  });


})(jQuery);



