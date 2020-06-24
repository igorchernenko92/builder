(function($) {
    const HelloGallerySkinScript = function ($scope, $) {
    //        write here
    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/hello_property_gallery.hello_gallery_skin1', HelloGallerySkinScript);
    });


})(jQuery);



