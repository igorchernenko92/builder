(function($) {
  const HelloPropertySkinScript = function ($scope, $) {
    // Select 2
    const initSelect2 = function () {
      const $selectFields = $("select");
      const svgIcon = '<svg class="select-icon" width="1em" height="1em" viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" fill="currentColor" class="css-tdckgx-style-ExpandMore"><path d="M16.59 8.59L12 13.17 7.41 8.59 6 10l6 6 6-6z"></path><path d="M0 0h24v24H0z" fill="none"></path></svg>';
    
      // -- Functions BEGIN
      const initSelect = function () {
        $selectFields.each(function() {
          if ($(this).hasClass("select2-hidden-accessible")) return;
        
          $(this).wrap("<div class='wrap-select'></div>");
          const $wrapperCurSelect = $(this).parent();
          $wrapperCurSelect.append(svgIcon);
        
          $(this).select2({
            dropdownParent: $wrapperCurSelect,
            dropdownAutoWidth: true,
            width: 'auto',
            minimumResultsForSearch: -1,
          });
        });
      };
    
      if ($selectFields.length) initSelect();
    };
    initSelect2()
  };
  
  $(window).on('elementor/frontend/init', function () {
    elementorFrontend.hooks.addAction('frontend/element_ready/search_filter.skin1', HelloPropertySkinScript);
    elementorFrontend.hooks.addAction('frontend/element_ready/search_filter.skin2', HelloPropertySkinScript);
  });
  
  
})(jQuery);



