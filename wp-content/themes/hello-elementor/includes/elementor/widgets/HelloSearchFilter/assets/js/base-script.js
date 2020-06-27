(function($) {
  const HelloPropertySkinScript = function ($scope, $) {


  };
  
  $(window).on('elementor/frontend/init', function () {
    elementorFrontend.hooks.addAction('frontend/element_ready/search_filter.skin1', HelloPropertySkinScript);
    elementorFrontend.hooks.addAction('frontend/element_ready/search_filter.skin2', HelloPropertySkinScript);
  });
  
  
})(jQuery);



