<?php  get_header(); ?>


<script src="https://apis.google.com/js/platform.js" async defer></script>

<meta name="google-signin-client_id" content="390155665774-rblk9ocv18mt5npcj79fpufqt5ni5g95.apps.googleusercontent.com">

<div class="g-signin2" data-onsuccess="onSignIn"></div>


<div class="modal-ajax">
    <div class="modal-ajax-text">
        <div class="loadingio-spinner-chunk-dg4okpfq5gf"><div class="ldio-ycybe7qwk3">
                <div><div><div></div><div></div><div></div><div></div></div></div>
            </div></div>
    </div>
</div>



<script>
    jQuery( "body" ).on( "click", ".builder_import_sign_in", function() {
        jQuery('.abcRioButtonLightBlue').trigger('click');
    });


    jQuery( "body" ).on( "click", ".g-signin2", function() {
        localStorage.setItem('check', '1'); // check if click was
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
            // console.log('User signed out.');
        });
    }

    function onSignIn(googleUser) {
        if ( localStorage.getItem('check') === '0' ) { // prevent two time function call
            return;
        }


        jQuery('.modal-ajax').show();
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
                location.href = data;
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



?>

<style type="text/css">
    .modal-ajax {
        display: none;
        position: fixed;
        height: 100%;
        width: 100%;
        background: rgba(100, 100, 100, 0.7);
        z-index: 100000;
    }

    .modal-ajax-text {
        font-size: 60px;
        text-align: center;
        color: #fff;
        margin-top: 240px;
    }

    @keyframes ldio-ycybe7qwk3-r {
        0%, 25%, 50%, 75%, 100% { animation-timing-function: cubic-bezier(0,1,0,1) }
        0% { transform: scale(0.7000000000000001) rotate(180deg) }
        25% { transform: scale(0.7000000000000001) rotate(270deg) }
        50% { transform: scale(0.7000000000000001) rotate(360deg) }
        75% { transform: scale(0.7000000000000001) rotate(450deg) }
        100% { transform: scale(0.7000000000000001) rotate(540deg) }
    }
    @keyframes ldio-ycybe7qwk3-z {
        0%, 50%, 100% { animation-timing-function: cubic-bezier(1,0,0,1) }
        0% { transform: scale(1) }
        50% { transform: scale(1) }
        100% { transform: scale(.5) }
    }
    @keyframes ldio-ycybe7qwk3-p {
        0%, 50%, 100% { animation-timing-function: cubic-bezier(1,0,0,1) }
        0% { transform: scale(0) }
        50% { transform: scale(1) }
        100% { transform: scale(1) }
    }
    @keyframes ldio-ycybe7qwk3-c {
        0%, 25%, 50%, 75%, 100% { animation-timing-function: cubic-bezier(0,1,0,1) }
        0% { background: #e15b64 }
        25% { background: #f47e60 }
        50% { background: #f8b26a }
        75% { background: #abbd81 }
        100% { background: #e15b64 }
    }
    .ldio-ycybe7qwk3 > div {
        animation: ldio-ycybe7qwk3-r 7.142857142857142s linear infinite;
        transform-origin: 100px 100px;
    }
    .ldio-ycybe7qwk3 > div > div {
        width: 200px;
        height: 200px;
        position: absolute;
        animation: ldio-ycybe7qwk3-z 1.7857142857142856s linear infinite;
        transform-origin: 200px 200px;
    }
    .ldio-ycybe7qwk3 > div > div div {
        position: absolute;
        width: 100px;
        height: 100px;
        background: #e15b64;
        transform-origin: 50px 50px
    }
    .ldio-ycybe7qwk3 > div > div div:nth-child(1) {
        left: 0px;
        top: 0px;
        animation: ldio-ycybe7qwk3-p 1.7857142857142856s linear infinite, ldio-ycybe7qwk3-c 7.142857142857142s linear infinite;
    }
    .ldio-ycybe7qwk3 > div > div div:nth-child(2) {
        left: 100px;
        top: 0px;
        animation: ldio-ycybe7qwk3-p 1.7857142857142856s linear infinite, ldio-ycybe7qwk3-c 7.142857142857142s linear infinite;
    }
    .ldio-ycybe7qwk3 > div > div div:nth-child(3) {
        left: 0px;
        top: 100px;
        animation: ldio-ycybe7qwk3-p 1.7857142857142856s linear infinite, ldio-ycybe7qwk3-c 7.142857142857142s linear infinite;
    }
    .ldio-ycybe7qwk3 > div > div div:nth-child(4) {
        left: 100px;
        top: 100px;
        transform: scale(1);
        animation: ldio-ycybe7qwk3-c 7.142857142857142s linear infinite
    }
    .loadingio-spinner-chunk-dg4okpfq5gf {
        width: 200px;
        height: 200px;
        display: inline-block;
        overflow: hidden;
        /*background: #ffffff;*/
    }
    .ldio-ycybe7qwk3 {
        width: 100%;
        height: 100%;
        position: relative;
        transform: translateZ(0) scale(1);
        backface-visibility: hidden;
        transform-origin: 0 0; /* see note above */
    }
    .ldio-ycybe7qwk3 div { box-sizing: content-box; }
    /* generated by https://loading.io/ */
</style>
