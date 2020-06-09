(function($) {
    $(document).ready(function() {
      const defaultOptions = function (params) {
        return {
          spaceBetween: 0,
          loop: true,
          slidesPerView: 1,
          speed: 800,
          preloadImages: false,
          lazy: true,
          allowTouchMove: false,
          navigation: {
            nextEl: params.navs.next,
            prevEl: params.navs.prev
          },
          breakpoints: {
            991: {
              allowTouchMove: true,
            },
          }
        }
      };

      const listingsSliders = $(".hl-listing-card__carousel");

      if (listingsSliders.length) {
        listingsSliders.each(function () {
          const params = {
            navs: {
              next: $(this).find(".hl-listing-card__carousel-nav_next"),
              prev: $(this).find(".hl-listing-card__carousel-nav_prev"),
            }
          };
          const $slider = $(this).find(".swiper-container");

          new Swiper($slider, defaultOptions({
            ...params,
          }))
        })
      }

    });
})(jQuery);
