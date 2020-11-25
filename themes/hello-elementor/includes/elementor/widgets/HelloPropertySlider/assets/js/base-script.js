(function($) {
  const HelloPropertySkinScript = function ($scope, $) {

  };
  
  $(window).on('elementor/frontend/init', function () {
    elementorFrontend.hooks.addAction('frontend/element_ready/hello_property_slider.skin1', HelloPropertySkinScript);
    elementorFrontend.hooks.addAction('frontend/element_ready/hello_property_slider.skin2', HelloPropertySkinScript);
  });
  
  
})(jQuery);



