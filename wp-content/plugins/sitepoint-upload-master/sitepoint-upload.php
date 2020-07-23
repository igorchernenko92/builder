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




add_action( 'wp_ajax_myajax-submit', 'su_image_submission_cb' );
add_action( 'wp_ajax_nopriv_myajax-submit', 'su_image_submission_cb' );
function su_image_submission_cb() {
    check_ajax_referer('myajax-nonce', 'nonce_code');

    $import = new WP_Import_Custom();
    $import->fetch_attachments = true;

    $templates = trailingslashit( WP_CONTENT_DIR ) . 'uploads/templates.xml';
    $pages = trailingslashit( WP_CONTENT_DIR ) . 'uploads/pages.xml';
    $property = trailingslashit( WP_CONTENT_DIR ) . 'uploads/property.xml';
    $menu = trailingslashit( WP_CONTENT_DIR ) . 'uploads/menu.xml';
    $media = trailingslashit( WP_CONTENT_DIR ) . 'uploads/media.xml';
    $all = trailingslashit( WP_CONTENT_DIR ) . 'uploads/all.xml';

//    prevent outputting
//    ob_start();
    $import->import($templates);
    $import->import($pages);
    $import->import($property);
    $import->import($menu);
    $import->import($media);

    //    prevent outputting
//    ob_end_clean();

    $homepage = get_page_by_title( 'first main page' );
    if ( $homepage ) {
        update_option( 'page_on_front', $homepage->ID );
        update_option( 'show_on_front', 'page' );
    }

    wp_die();

}
