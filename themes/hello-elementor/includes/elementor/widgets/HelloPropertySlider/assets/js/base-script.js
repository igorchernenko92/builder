(function($) {
  const HelloPropertySkinScript = function ($scope, $) {
    const $sliders = $(".hl-property-slider");

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
  
  $(window).on('elementor/frontend/init', function () {
    elementorFrontend.hooks.addAction('frontend/element_ready/hello_property_slider.skin1', HelloPropertySkinScript);
    elementorFrontend.hooks.addAction('frontend/element_ready/hello_property_slider.skin2', HelloPropertySkinScript);
  });
  
  
})(jQuery);



