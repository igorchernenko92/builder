(function($) {
    $(document).ready(function() {
        $('#form_data').on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData();
            formData.append('action', 'myajax-submit');
            // formData.append('file', $('input#xml_file')[0].files[0]);
            formData.append('_wpnonce', myajax.nonce);


            $.ajax({
                url: myajax.ajax_url,
                // action: 'myajax-submit',
                // nonce_code: myajax.nonce,
                type: 'POST',
                data: formData,
                success: function (data) {
                    console.log(data)
                },
                cache: false,
                contentType: false,
                processData: false
            });

        });

    });
})(jQuery);
