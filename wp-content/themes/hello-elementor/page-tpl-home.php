<?php  get_header(); ?>


<script src="https://apis.google.com/js/platform.js" async defer></script>

<meta name="google-signin-client_id" content="390155665774-rblk9ocv18mt5npcj79fpufqt5ni5g95.apps.googleusercontent.com">

<div class="g-signin2" data-onsuccess="onSignIn"></div>



<script>

    $( "body" ).on( "click", ".g-signin2", function() {
        localStorage.setItem('check', '1');
    });

    //var data = {
    //    token: 31414,
    //    name:  '234234',
    //    action: 'login_or_register',
    //    email:  '2342423',
    //};
    //
    //jQuery.ajax({
    //    url: "<?php //echo admin_url('admin-ajax.php')  ?>// ",
    //    type: 'POST',
    //    data: data,
    //    success: function (data) {
    //        console.log(data);
    //        // location.href = data;
    //    },
    //});



    function signOut() {
        var auth2 = gapi.auth2.getAuthInstance();
        auth2.signOut().then(function () {
            console.log('User signed out.');
        });
    }

    function onSignIn(googleUser) {
        if ( localStorage.getItem('check') === '0' ) {
            return;
        }
        var id_token = googleUser.getAuthResponse().id_token;
        var profile = googleUser.getBasicProfile();

        var data = {
            token: id_token,
            name:  profile.getName(),
            action: 'login_or_register',
            email:  profile.getEmail(),
        };

        //
        jQuery.ajax({
            url: "<?php echo admin_url('admin-ajax.php')  ?> ",
            type: 'POST',
            data: data,
            success: function (data) {
                console.log(data);
                // location.href = data;
            },
        });


        // console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
        // console.log('Name: ' + profile.getName());
        // console.log('Image URL: ' + profile.getImageUrl());
        // console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
        localStorage.setItem('check', '0');
        signOut();
    }

</script>
<!--<a href="#" onclick="signOut();">Sign out</a>-->
<?php
/**
 * Template Name: Login
 *
 * This is the home page template.
 *
 * @package WPCasa Berlin
 */

$is_elementor_theme_exist = function_exists( 'elementor_theme_do_location' );

if ( is_singular() ) {
    if ( ! $is_elementor_theme_exist || ! elementor_theme_do_location( 'single' ) ) {
        get_template_part( 'template-parts/single' );
    }
} elseif ( is_archive() || is_home() ) {
    if ( ! $is_elementor_theme_exist || ! elementor_theme_do_location( 'archive' ) ) {
        get_template_part( 'template-parts/archive' );
    }
} elseif ( is_search() ) {
    if ( ! $is_elementor_theme_exist || ! elementor_theme_do_location( 'archive' ) ) {
        get_template_part( 'template-parts/search' );
    }
} else {
    if ( ! $is_elementor_theme_exist || ! elementor_theme_do_location( 'single' ) ) {
        get_template_part( 'template-parts/404' );
    }
}

get_footer();