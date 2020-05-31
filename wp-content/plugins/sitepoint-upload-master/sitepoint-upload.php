<?php
/*
Plugin Name: Simple Uploader
Plugin URI: http://sitepoint.com
Description: Simple plugin to demonstrate AJAX upload with WordPress
Version: 0.1.0
Author: Firdaus Zahari
Author URI: http://www.sitepoint.com/author/fzahari/
*/

/** WordPress Import Administration API */
require_once ABSPATH . 'wp-admin/includes/import.php';

if ( ! class_exists( 'WP_Importer' ) ) {
    $class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
    if ( file_exists( $class_wp_importer ) )
        require $class_wp_importer;
}

require_once dirname( __FILE__ ) . '/class-wp-import.php';

/** WXR_Parser class */
require_once dirname( __FILE__ ) . '/parsers/class-wxr-parser.php';

/** WXR_Parser_SimpleXML class */
require_once dirname( __FILE__ ) . '/parsers/class-wxr-parser-simplexml.php';

/** WXR_Parser_XML class */
require_once dirname( __FILE__ ) . '/parsers/class-wxr-parser-xml.php';

/** WXR_Parser_Regex class */
require_once dirname( __FILE__ ) . '/parsers/class-wxr-parser-regex.php';

/** WP_Import class */
require_once dirname( __FILE__ ) . '/class-wp-import.php';



//function su_allow_subscriber_to_uploads() {
//    $subscriber = get_role('subscriber');
//
//    if ( ! $subscriber->has_cap('upload_files') ) {
//        $subscriber->add_cap('upload_files');
//    }
//}
//add_action('admin_init', 'su_allow_subscriber_to_uploads');

function su_image_form_html(){
    ob_start();
    ?>
        <?php if ( is_user_logged_in() ): ?>
            <p class="form-notice"></p>
            <form id="form_data" method="post" action="myajax-submit" enctype="multipart/form-data">
<!--                --><?php //wp_nonce_field('xml-submission'); ?>
<!--                <p><input type="text" name="user_name" placeholder="Your Name" required></p>-->
<!--                <p><input type="email" name="user_email" placeholder="Your Email Address" required></p>-->
<!--                <p class="image-notice"></p>-->
<!--                <p><input id="xml_file" type="file" name="import"  required></p>-->
<!--                <input type="hidden" name="image_id">-->
<!--                <input type="hidden" name="action" value="image_submission">-->
<!--                <div class="image-preview"></div>-->
<!--                <hr>-->
                <p><input type="submit" value="Submit"></p>
            </form>
        <?php else: ?>
            <p>Please <a href="<?php echo esc_url( wp_login_url( get_permalink() ) ); ?>">login</a> first to submit your image.</p>
        <?php endif; ?>
    <?php
    $output = ob_get_clean();
    return $output;
}
add_shortcode('import_data', 'su_image_form_html');

function su_load_scripts() {
    wp_enqueue_script('image-form-js', plugin_dir_url( __FILE__ ) . 'js/script.js', array('jquery'), '0.1.0', true);

    $data = array(
//                'upload_url' => admin_url('async-upload.php'),
                'ajax_url'   => admin_url('admin-ajax.php'),
                'nonce'      => wp_create_nonce('myajax-nonce')
            );

    wp_localize_script( 'image-form-js', 'myajax', $data );
}
add_action('wp_enqueue_scripts', 'su_load_scripts');


add_action( 'wp_ajax_login_or_register', 'login_or_register' );
add_action( 'wp_ajax_nopriv_login_or_register', 'login_or_register' );
function login_or_register() {

//    require_once get_template_directory() . '/vendor/autoload.php';
//
//    $client = new Google_Client(['client_id' => '390155665774-rblk9ocv18mt5npcj79fpufqt5ni5g95.apps.googleusercontent.com']);  // Specify the CLIENT_ID of the app that accesses the backend
//    $payload = $client->verifyIdToken($_POST['token']);
//    if ($payload) {
//        $userid = $payload['sub'];
//
//    } else {
//
//    }

    $main_site = 'test.redcarlos.pro';

//    $username = $_POST['name'];
    $useremail = $_POST['email'];
    $password = wp_generate_password( 12 );



    $rand_number = rand( 1, 2000 );
    $username = 'user-' . $rand_number;
    $password = 'fake-password';
    // $password = wp_generate_password( 12, false );
    $email = "email+$rand_number@example.com";
    $user_id = wpmu_create_user( $username, $password, $email );

    $bytes = random_bytes(3);

    $siteName = bin2hex($bytes);
    $newdomain = "{$siteName}.$main_site";
    $path = '/';

    $blog_id = wpmu_create_blog( $newdomain, $path, $siteName, $user_id , array( 'public' => 1 ) );
    $blog = get_blog_details( array( 'blog_id' => $blog_id ) );

//    echo $blog->siteurl;
//    switch_to_blog( $blog_id );
    $location = $siteName . '.' . $main_site;
//    echo $email . ' ';
//    echo $blog_id . ' ';
    echo 'http://' . $location;

    $creds = array();
    $creds['user_login'] = 'email+1217@example.com';
    $creds['user_password'] = 'fake-password';

    wp_signon($creds);
    switch_to_blog( $blog_id );
    $import = new WP_Import_Custom();

    $templates = trailingslashit( WP_CONTENT_DIR ) . 'uploads/templates.xml';
    $pages = trailingslashit( WP_CONTENT_DIR ) . 'uploads/pages.xml';
    $property = trailingslashit( WP_CONTENT_DIR ) . 'uploads/property.xml';
    $menu = trailingslashit( WP_CONTENT_DIR ) . 'uploads/menu.xml';

    $import->import($templates);
    $import->import($pages);
    $import->import($property);
    $import->import($menu);

    $homepage = get_page_by_title( 'first main page' );
    if ( $homepage ) {
        update_option( 'page_on_front', $homepage->ID );
        update_option( 'show_on_front', 'page' );
    }

    $all_conditions = [];
    $query = new \WP_Query( [
        'posts_per_page' => -1,
        'post_type' => 'elementor_library',
//        'fields' => 'ids',
        'meta_key' => '_elementor_conditions',
    ] );

    wp_die();

}




function su_image_submission_cb() {
    check_ajax_referer('myajax-nonce', 'nonce_code');

    $import = new WP_Import_Custom();

//    ob_start();
//    var_dump($_FILES['file']);
//    $result = ob_get_clean();
//
//    echo $result;
//    $name = trailingslashit( WP_CONTENT_DIR ) . 'uploads/finalpages.xml';
//    $menu = trailingslashit( WP_CONTENT_DIR ) . 'uploads/menu.xml';
    $ae = trailingslashit( WP_CONTENT_DIR ) . 'uploads/ae.xml';
    $property = trailingslashit( WP_CONTENT_DIR ) . 'uploads/property.xml';
//
//    $import->import($name);
//    $import->import($menu);

    $import->import($ae);
    $import->import($property);

    $homepage = get_page_by_title( 'first main page' );
    if ( $homepage ) {
        update_option( 'page_on_front', $homepage->ID );
        update_option( 'show_on_front', 'page' );
    }

    wp_die();

}
add_action( 'wp_ajax_myajax-submit', 'su_image_submission_cb' );
//add_action( 'wp_ajax_nopriv_myajax-submit', 'su_image_submission_cb' );