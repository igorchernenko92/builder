(function($) {
  var WidgetElements_ACFSliderHandler1 = function ($scope, $) {
    function getPreViews($carousel) {
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
  
    $(".hl-agents-3").each(function () {
      const laptopCount = getPreViews($(this)).laptop
      if (laptopCount === 1) {
        $(this).addClass("hl-agents-3_small")
      }
    })
  };

  $(window).on('elementor/frontend/init', function () {
    elementorFrontend.hooks.addAction('frontend/element_ready/hello-agents.agent_skin3', WidgetElements_ACFSliderHandler1);

  });


})(jQuery);



