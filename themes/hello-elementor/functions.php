<?php
/**
 * Theme functions and definitions
 *
 * @package HelloElementor
 */
use Elementor\Core\Files\Base;
use Elementor\Core\Files\CSS\Global_CSS;
use Elementor\Core\Files\CSS\Post as Post_CSS;
use Elementor\Core\Responsive\Files\Frontend;

//function admin_notice_missing_main_plugin() {
//
//    if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
//
//    $message = sprintf(
//    /* translators: 1: Plugin Name 2: Elementor */
//        esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'text-domain' ),
//        '<strong>' . esc_html__( 'Plugin Name', 'text-domain' ) . '</strong>',
//        '<strong>' . esc_html__( 'Elementor', 'text-domain' ) . '</strong>'
//    );
//
//    printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
//
//}

if ( ! did_action( 'elementor/loaded' ) ) {
//    add_action( 'admin_notices', 'admin_notice_missing_main_plugin' );
    return;
}

use ElementorPro\Modules\ThemeBuilder\Documents\Theme_Document;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

define( 'HELLO_ELEMENTOR_VERSION', '2.2.0' );

if ( ! isset( $content_width ) ) {
    $content_width = 800; // Pixels.
}
add_filter( 'big_image_size_threshold', '__return_false' );
if ( ! function_exists( 'hello_elementor_setup' ) ) {
    /**
     * Set up theme support.
     *
     * @return void
     */
    function hello_elementor_setup() {
        $hook_result = apply_filters_deprecated( 'elementor_hello_theme_load_textdomain', [ true ], '2.0', 'hello_elementor_load_textdomain' );
        if ( apply_filters( 'hello_elementor_load_textdomain', $hook_result ) ) {
            load_theme_textdomain( 'hello-elementor', get_template_directory() . '/languages' );
        }

        $hook_result = apply_filters_deprecated( 'elementor_hello_theme_register_menus', [ true ], '2.0', 'hello_elementor_register_menus' );
        if ( apply_filters( 'hello_elementor_register_menus', $hook_result ) ) {
            register_nav_menus( array( 'menu-1' => __( 'Primary', 'hello-elementor' ) ) );
        }

        $hook_result = apply_filters_deprecated( 'elementor_hello_theme_add_theme_support', [ true ], '2.0', 'hello_elementor_add_theme_support' );
        if ( apply_filters( 'hello_elementor_add_theme_support', $hook_result ) ) {
            add_theme_support( 'post-thumbnails' );
            add_theme_support( 'automatic-feed-links' );
            add_theme_support( 'title-tag' );
            add_theme_support(
                'html5',
                array(
                    'search-form',
                    'comment-form',
                    'comment-list',
                    'gallery',
                    'caption',
                )
            );
            add_theme_support(
                'custom-logo',
                array(
                    'height'      => 100,
                    'width'       => 350,
                    'flex-height' => true,
                    'flex-width'  => true,
                )
            );

            /*
             * Editor Style.
             */
            add_editor_style( 'editor-style.css' );
        }
    }
}
add_action( 'after_setup_theme', 'hello_elementor_setup' );

if ( ! function_exists( 'hello_elementor_scripts_styles' ) ) {
    /**
     * Theme Scripts & Styles.
     *
     * @return void
     */
    function hello_elementor_scripts_styles() {
        $enqueue_basic_style = apply_filters_deprecated( 'elementor_hello_theme_enqueue_style', [ true ], '2.0', 'hello_elementor_enqueue_style' );
        $min_suffix          = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

        if ( apply_filters( 'hello_elementor_enqueue_style', $enqueue_basic_style ) ) {
            wp_enqueue_style(
                'hello-elementor',
                get_template_directory_uri() . '/style' . $min_suffix . '.css',
                [],
                HELLO_ELEMENTOR_VERSION
            );
        }
        wp_enqueue_script('jquery');
    }
}
add_action( 'wp_enqueue_scripts', 'hello_elementor_scripts_styles' );

if ( ! function_exists( 'hello_elementor_register_elementor_locations' ) ) {
    /**
     * Register Elementor Locations.
     *
     * @param ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager $elementor_theme_manager theme manager.
     *
     * @return void
     */
    function hello_elementor_register_elementor_locations( $elementor_theme_manager ) {
        $hook_result = apply_filters_deprecated( 'elementor_hello_theme_register_elementor_locations', [ true ], '2.0', 'hello_elementor_register_elementor_locations' );
        if ( apply_filters( 'hello_elementor_register_elementor_locations', $hook_result ) ) {
            $elementor_theme_manager->register_all_core_location();
        }
    }
}
add_action( 'elementor/theme/register_locations', 'hello_elementor_register_elementor_locations' );

if ( ! function_exists( 'hello_elementor_content_width' ) ) {
    /**
     * Set default content width.
     *
     * @return void
     */
    function hello_elementor_content_width() {
        $GLOBALS['content_width'] = apply_filters( 'hello_elementor_content_width', 800 );
    }
}
add_action( 'after_setup_theme', 'hello_elementor_content_width', 0 );

if ( is_admin() ) {
    require get_template_directory() . '/includes/admin-functions.php';
}

if ( ! function_exists( 'hello_elementor_check_hide_title' ) ) {
    /**
     * Check hide title.
     *
     * @param bool $val default value.
     *
     * @return bool
     */
    function hello_elementor_check_hide_title( $val ) {
        if ( defined( 'ELEMENTOR_VERSION' ) ) {
            $current_doc = \Elementor\Plugin::instance()->documents->get( get_the_ID() );
            if ( $current_doc && 'yes' === $current_doc->get_settings( 'hide_title' ) ) {
                $val = false;
            }
        }
        return $val;
    }
}
add_filter( 'hello_elementor_page_title', 'hello_elementor_check_hide_title' );

/**
 * Wrapper function to deal with backwards compatibility.
 */
if ( ! function_exists( 'hello_elementor_body_open' ) ) {
    function hello_elementor_body_open() {
        if ( function_exists( 'wp_body_open' ) ) {
            wp_body_open();
        } else {
            do_action( 'wp_body_open' );
        }
    }
}




function update_elementor_locations() {
    $all_conditions = [];
    $query = new \WP_Query( [
        'posts_per_page' => -1,
        'post_type' => 'elementor_library',
        'meta_key' => '_elementor_conditions',
    ] );

    foreach ( $query->posts as $post ) {
        $post_id = $post->ID;
        $document = \Elementor\Plugin::instance()->documents->get($post_id);
//         check for error if class is not not_supported
        if ($document instanceof Elementor\Modules\Library\Documents\Not_Supported) {
            continue;
        }
        if ( $document ) {
            $conditions = $document->get_meta( '_elementor_conditions' );
            $location = $document->get_location();

            if ( $location ) {
                $all_conditions[ $location ][ $document->get_main_id() ] = $conditions;
            }
        }
    }

    update_option( 'elementor_pro_theme_builder_conditions', $all_conditions );
}

//add_action( 'init', 'update_elementor_locations', 10 );





function my_acf_init() {
    acf_update_setting('google_api_key', 'AIzaSyCyzLPGLgRv_SOdc3anLhP8olpjrBocu6I');
}

add_action('acf/init', 'my_acf_init');


add_action( 'init', 'register_post_types' );
function register_post_types(){
    register_post_type( 'property', [
        'label'  => null,
        'labels' => [
            'name'               => __( 'Properties', 'builder' ),
            'singular_name'      => __( 'Property', 'builder' ),
            'add_new'            => __( 'Add property', 'builder' ),
            'add_new_item'       => __( 'New property', 'builder' ),
            'edit_item'          => __( 'Edit property', 'builder' ),
            'new_item'           => __( 'New property', 'builder' ),
            'view_item'          => __( 'View property', 'builder' ),
            'search_items'       => __( 'Search property', 'builder' ),
            'not_found'          => __( 'Property not found', 'builder' ),
            'not_found_in_trash' => __( 'Property not found', 'builder' ),
            'parent_item_colon'  => '',
            'menu_name'          => __( 'Properties', 'builder' ),
        ],
        'description'         => '',
        'public'              => true,
        'show_in_menu'        => null,
        'show_in_rest'        => null,
        'rest_base'           => null,
        'menu_position'       => null,
        'menu_icon'           => null,
        'hierarchical'        => false,
        'supports'            => [ 'title', 'editor', 'thumbnail', 'excerpt' ], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
        'taxonomies'          => [],
        'has_archive'         => false,
        'rewrite'             => true,
        'query_var'           => true,
    ] );

    register_post_type( 'agent', [
        'label'  => null,
        'labels' => [
            'name'               => __( 'Agents', 'builder' ),
            'singular_name'      => __( 'Agent', 'builder' ),
            'add_new'            => __( 'Add agent', 'builder' ),
            'add_new_item'       => __( 'Add agent', 'builder' ),
            'edit_item'          => __( 'Edit agent', 'builder' ),
            'new_item'           => __( 'New agent', 'builder' ),
            'view_item'          => __( 'Look agent', 'builder' ),
            'search_items'       => __( 'Search agent', 'builder' ),
            'not_found'          => __( 'Agent not found', 'builder' ),
            'not_found_in_trash' => __( 'Agent no found', 'builder' ),
            'parent_item_colon'  => '',
            'menu_name'          => 'Agents',
        ],
        'description'         => '',
        'public'              => true,
        'show_in_menu'        => null,
        'show_in_rest'        => null,
        'rest_base'           => null,
        'menu_position'       => null,
        'menu_icon'           => null,
        'hierarchical'        => false,
        'supports'            => [ 'title', 'editor', 'thumbnail', 'excerpt' ], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
        'taxonomies'          => [],
        'has_archive'         => false,
        'rewrite'             => true,
        'query_var'           => true,
    ] );
}

add_action( 'init', 'create_taxonomies' );

function create_taxonomies() {
    register_taxonomy(
        'features',
        'property',
        array(
            'label' => __( 'Features' ),
            'rewrite' => array( 'slug' => 'features' ),
            'hierarchical' => true,
        )
    );

    register_taxonomy(
        'status',
        'property',
        array(
            'label' => __( 'Status' ),
            'rewrite' => array( 'slug' => 'status' ),
            'hierarchical' => true,
        )
    );

    register_taxonomy(
        'featured',
        'property',
        array(
            'label' => __( 'Featured' ),
            'rewrite' => array( 'slug' => 'featured' ),
            'hierarchical' => true,
        )
    );

    register_taxonomy(
        'location',
        'property',
        array(
            'label' => __( 'Location' ),
            'rewrite' => array( 'slug' => 'location' ),
            'hierarchical' => true,
        )
    );

//    register_taxonomy(
//        'location',
//        'agent',
//        array(
//            'label' => __( 'Location' ),
//            'rewrite' => array( 'slug' => 'location' ),
//            'hierarchical' => true,
//        )
//    );
}

/**
 * Implement widgets creating
 */
//require get_template_directory() . '/includes/import/functions.php';
require get_template_directory() . '/includes/elementor/widgets-manager.php';

// acf sync files
require get_template_directory() . '/acfe-php/group_5ecbc332768f3.php';
require get_template_directory() . '/acfe-php/group_5efc7f9a053c7.php';
require get_template_directory() . '/acfe-php/group_5efdb7d7d47d7.php';
require get_template_directory() . '/acfe-php/group_5f11cc6d60bd4.php';
//require get_template_directory() . '/includes/acfFields.php';



//Have the option to remove delay on drop-down menu
//https://github.com/elementor/elementor/issues/9400
add_action( 'wp_footer', function () { ?>
    <script>
        jQuery(document).ready(function($) {
            $('.elementor-nav-menu--main > ul').attr('data-sm-options', '{ showTimeout: 0, hideTimeout: 0 }');
        });
    </script>
<?php } );



//global $wpdb;
//
//$el_data = $wpdb->get_results( "SELECT * FROM wp_postmeta WHERE post_id = 2889" );
//$fields_to_update = ['_elementor_controls_usage', '_elementor_css', '_elementor_data'];
//
//for ( $i = 0; $i < count($el_data); $i++ ) {
//    if ( in_array($el_data[$i]->meta_key, $fields_to_update)) {
//        $wpdb->update( 'wp_200_postmeta',
//            array( "meta_value" => $el_data[$i]->meta_value, ),
//            array( 'post_id' => 2889, 'meta_key' => $el_data[$i]->meta_key ),
//            array( '%s' ),
//            array( '%d', '%s' ) );
//    }
//}
//Plugin::$instance->files_manager->clear_cache();

//copy( wp_upload_dir()['basedir'] . '/elementor/css/post-2889.css',  wp_upload_dir()['basedir'] . '/sites/200/elementor/css/post-2889.css');

function status_term_default_value() {
    $term_rent = get_term_by('slug', 'for-rent', 'status');
    $term_sale = get_term_by('slug', 'for-sale', 'status');

    update_field( 'status_color', '#06B236', $term_rent );
    update_field( 'status_color', '#1348c2', $term_sale );
}

function recurse_copy($src,$dst) {
    $dir = opendir($src);
    @mkdir($dst);
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            if ( is_dir($src . '/' . $file) ) {
                recurse_copy($src . '/' . $file,$dst . '/' . $file);
            }
            else {
                copy($src . '/' . $file,$dst . '/' . $file);
            }
        }
    }
    closedir($dir);
}


//add_action( 'init', 'copy_media' );
function copy_media($blog_id, $blog_url, $user_id) {
    switch_to_blog(1);


//  get kit data from original site
    $main_kit_id      = get_option( 'elementor_active_kit' );
    $main_kit_data = get_post_meta( $main_kit_id, '_elementor_page_settings' );


    $args = array('post_type' => 'attachment','numberposts' => -1,'post_status' => null);
    $attachments = get_posts($args);
//    restore_current_blog();
    switch_to_blog($blog_id);


    if($attachments) {
        foreach($attachments as $attachment) {

            switch_to_blog(1);

            $post = get_post($attachment->ID, ARRAY_A);
            $metadata = wp_get_attachment_metadata($attachment->ID);
            $attached_file = get_post_meta($attachment->ID, '_wp_attached_file', true);

            switch_to_blog($blog_id);
            if ( ($post['post_parent'] != 0) && ($metadata != '') ) {
                unset($post['ID']);
                $post['guid'] = str_replace("buildable.pro", $blog_url, $post['guid']);
                $post['post_author'] = $user_id;

                $post_id = wp_insert_post($post);
                update_post_meta( $post_id, '_wp_attachment_metadata', $metadata );
                update_post_meta( $post_id, '_wp_attached_file', $attached_file );

//                var_dump($post);
//            var_dump($metadata);
//            echo '<br><br>';
            }
        }
    }
//echo $i;
}

//add_action( 'init', 'update_media_gallery_for_properties' );
function update_media_gallery_for_properties() {
    $query = new \WP_Query( [
        'posts_per_page' => -1,
        'post_type' => 'property',
    ] );
    $array_with_media_id = [];

//    fill array with proper id's
    for ( $i = 45; $i < 111; $i++ ) {
        array_push($array_with_media_id, $i);
    }
//  set array of images id to property
    foreach ( $query->posts as $post ) {
        update_field( 'property_gallery', array_slice($array_with_media_id,0, 5), $post->ID );
        array_splice($array_with_media_id,0, 5);
    }
}


function import_data($blog_id) {
    switch_to_blog( $blog_id );

    $import = new WP_Import_Custom();
//    $import->fetch_attachments = true;

    $templates = trailingslashit( WP_CONTENT_DIR ) . 'uploads/templates.xml';
    $pages = trailingslashit( WP_CONTENT_DIR ) . 'uploads/pages.xml';
    $property = trailingslashit( WP_CONTENT_DIR ) . 'uploads/properties.xml';
    $agent = trailingslashit( WP_CONTENT_DIR ) . 'uploads/agents.xml';
    $menu = trailingslashit( WP_CONTENT_DIR ) . 'uploads/menu.xml';
    $media = trailingslashit( WP_CONTENT_DIR ) . 'uploads/media.xml';

//  prevent outputting
    ob_start();
    $import->import($templates);
    $import->import($pages);
    $import->import($property);
    $import->import($agent);
    $import->import($menu);
    $import->import($media);

    //prevent outputting
    ob_end_clean();
}

//var_dump(get_current_blog_id());
function siteAndUserCreation($user_id, $provider) {
    delete_user_option( $user_id, 'capabilities' );
    delete_user_option( $user_id, 'user_level' );


    do_action( 'wpmu_new_user', $user_id );

    $main_site = 'buildable.pro';
    $bytes = random_bytes(3); // need for creating unique site name
    $randName = bin2hex($bytes);     // need for creating unique site name
    $newdomain = "{$randName}.$main_site"; // create unique domain

    $blog_id = wpmu_create_blog( $newdomain, '/', $randName, $user_id);
    $location = get_site_url( $blog_id, '', '' );  // send link to front
    switch_to_blog( $blog_id );

    if ( ! class_exists( 'WP_Importer' ) ) {
        $class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
        if ( file_exists( $class_wp_importer ) )
            require_once $class_wp_importer;
    }

    require_once dirname( __FILE__ ) . '/parsers/class-wxr-parser.php';
    require_once dirname( __FILE__ ) . '/parsers/class-wxr-parser-simplexml.php';
    require_once dirname( __FILE__ ) . '/parsers/class-wxr-parser-xml.php';
    require_once dirname( __FILE__ ) . '/parsers/class-wxr-parser-regex.php';
    require_once dirname( __FILE__ ) . '/class-wp-import.php';

    copy_media($blog_id, $newdomain, $user_id);
    import_data($blog_id);


    $homepage = get_page_by_title( 'Home page 1' );
    if ( $homepage ) {
        update_option( 'page_on_front', $homepage->ID );
        update_option( 'show_on_front', 'page' );
    }
    status_term_default_value();
    $cpt_support = [ 'page', 'post', 'agent', 'property' ];
    update_option( 'elementor_cpt_support', $cpt_support );
    update_media_gallery_for_properties();

    //migrate default kit setting from main site
//    global $wpdb;
//    $main_active_kit = $wpdb->get_results( "SELECT * FROM wp_options WHERE option_name = 'elementor_active_kit'" );
//    $site_active_kit = $wpdb->get_results( "SELECT * FROM wp_".$blog_id."_options WHERE option_name = 'elementor_active_kit'" );
//    $main_active_kit_id = $main_active_kit[0]->option_value;
//    $site_active_kit_id = $site_active_kit[0]->option_value;
//
//
//    $main_kit = $wpdb->get_results( "SELECT * FROM wp_postmeta WHERE post_id = " . $main_active_kit_id . " AND meta_key = '_elementor_page_settings'" );
//    $site_kit = $wpdb->get_results( "SELECT * FROM wp_" . $blog_id . "_postmeta WHERE post_id = " . $site_active_kit_id . " AND meta_key = '_elementor_page_settings'" );
//    $main_kit_data = $main_kit[0]->meta_value;
//
//
//    if ( !$site_kit ) {
//        $wpdb->insert( 'wp_'.$blog_id.'_postmeta', array( "meta_value" => $main_kit_data, 'post_id' => $site_active_kit_id, 'meta_key' => '_elementor_page_settings'), array( '%s', '%d', '%s' ) );
//        Elementor\Plugin::$instance->files_manager->clear_cache();
//    }





    add_filter($provider->getId() . '_register_redirect_url', function () use ($location) {
        return $location;
    });

}
add_action('nsl_register_new_user', 'siteAndUserCreation', 10, 2);



add_filter('body_class','my_class_names');
function my_class_names($classes) {
    if (is_user_logged_in() && !is_super_admin()) {
        $classes[] = 'is-not-super-admin';
    }
    return $classes;
}

add_action( 'elementor/element/column/layout/before_section_end', 'add_responsive_column_order', 10, 2 );
function add_responsive_column_order( $element, $args ) {
    $element->add_responsive_control(
        'responsive_column_order',
        [
            'label' => __( 'Responsive Column Order', 'bleye-elementor-extras' ),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'separator' => 'before',
            'selectors' => [
                '{{WRAPPER}}' => '-webkit-order: {{VALUE}}; -ms-flex-order: {{VALUE}}; order: {{VALUE}};',
            ],
        ]
    );
}




add_filter('manage_property_posts_columns', 'property_table_head');
function property_table_head( $defaults ) {
    unset($defaults['title']);
    unset($defaults['tags']);
    unset($defaults['date']);
    $defaults['tax']  = 'Status';
    $defaults['id']  = 'ID';
    $defaults['image']  = 'Image';
    $defaults['title'] = 'Title';
    $defaults['price']  = 'Price';
    $defaults['agent']  = 'Agent';
    $defaults['date'] = 'Posted';

    $output_css = '<style type="text/css">
        .manage-column.column-image { width: 8% }
        .manage-column.column-tax { width: 11% }
        .manage-column.column-title { width: 25% }
        .manage-column.column-id { width: 10% }
    </style>';
    echo $output_css;

    return $defaults;
}

add_action( 'manage_property_posts_custom_column', 'bs_property_table_content', 10, 2 );

function bs_property_table_content( $column_name, $post_id ) {
    if ($column_name == 'tax') {
        $terms = get_the_terms( $post_id, 'status' );
        foreach($terms as $term) {
            echo '<span style="background-color: ' . get_field('status_color', $term) . '; padding: 6px 17px; color: #fff;border-radius: 3px;font-size: 12px;">' . $term->name . '</span>';
        }
    }

    if ($column_name == 'image') {
        echo '<a href="' . get_edit_post_link( $post_id ) . '">' . get_the_post_thumbnail( $post_id, [75, 75] ) . '</a>';
    }

    if ($column_name == 'price') {
        echo builder_get_property_price($post_id);
    }

    if ($column_name == 'id') {
        echo get_field('property_id', $post_id );
    }

    if ($column_name == 'agent') {
        $agent = get_field('property_agent', $post_id )[0];

        echo '<a href="' . get_edit_post_link( $agent->ID ) . '">'  . $agent->post_title . '</a>';
    }

}


//add_action( 'init', 'update_elementor_style_kit', 10 );
function update_elementor_style_kit() {
    $option_name = get_current_blog_id() . '_check_style_kit';
    $current_blog_id = get_current_blog_id();

    if (( $current_blog_id != 1 ) && ( !get_option($option_name) )) {
        global $wpdb;
        $main_active_kit = $wpdb->get_results( "SELECT * FROM wp_options WHERE option_name = 'elementor_active_kit'" );
        $site_active_kit = $wpdb->get_results( "SELECT * FROM wp_".$current_blog_id."_options WHERE option_name = 'elementor_active_kit'" );



        if ( $site_active_kit ) {
            $main_active_kit_id = $main_active_kit[0]->option_value;
            $site_active_kit_id = $site_active_kit[0]->option_value;

            $main_kit = $wpdb->get_results( "SELECT * FROM wp_postmeta WHERE post_id = " . $main_active_kit_id . " AND meta_key = '_elementor_page_settings'" );
            $site_kit = $wpdb->get_results( "SELECT * FROM wp_" . $current_blog_id . "_postmeta WHERE post_id = " . $site_active_kit_id . " AND meta_key = '_elementor_page_settings'" );
            $main_kit_data = $main_kit[0]->meta_value;



            if ( !$site_kit ) {
                $wpdb->insert( 'wp_'.$current_blog_id.'_postmeta', array( "meta_value" => $main_kit_data, 'post_id' => $site_active_kit_id, 'meta_key' => '_elementor_page_settings'), array( '%s', '%d', '%s' ) );
                Elementor\Plugin::$instance->files_manager->clear_cache();

                update_option($option_name, 'true');
            }
        }

        //add temporary style. Need it for first page load.
        // clear_cache() - applied AFTER the page is loaded, and user see not proper colors. Need to update it for first load

        echo '<style>
                .hello_search_button {
                  background-color: #1348C2 !important;
                }
                .e-form__buttons button {
                 background-color: #1348C2 !important;
                }
        </style>';
    }
}


//delete_option(get_current_blog_id(). '_check_media_files') ;
//check if media files are copied. I don't know why but it's not working from site migration function
add_action( 'init', 'check_media_files' );
function check_media_files() {
    $option_name = get_current_blog_id() . '_check_media_files';
    if ( !get_option($option_name) ) {
//        TODO: get the path via vars
        recurse_copy('/home/508171.cloudwaysapps.com/fncvxcdrwb/public_html/wp-content/uploads/2020/', '/home/508171.cloudwaysapps.com/fncvxcdrwb/public_html/wp-content/uploads/sites/' . get_current_blog_id() . '/2020');
        update_option($option_name, 'true');
        update_elementor_locations(); // update it once after import
        update_option( 'elementor_active_kit', 5321 );

        // TODO: remove this default kits from import files
        wp_delete_post(146, true);
        wp_delete_post(5333, true);

    }
//    update_elementor_style_kit();
}



add_filter( 'elementor_pro/custom_fonts/font_display', function( $current_value, $font_family, $data ) {
    return 'swap';
}, 10, 3 );




/**
 * Cleanup orphaned tables during site deletion
 *
 * @param $blog_id
 */
add_action( 'wp_uninitialize_site', 'action_function_name_3048' );
function action_function_name_3048( $old_site ){
    global $wpdb;
    $blog_id = $old_site->blog_id;

    $prep_query = $wpdb->prepare("SELECT table_name FROM information_schema.TABLES WHERE table_name LIKE %s;", $wpdb->esc_like("{$wpdb->base_prefix}{$blog_id}_") . '%');
    $table_list = $wpdb->get_results($prep_query, ARRAY_A);

    foreach ($table_list as $index => $data) {
        $table_name = $data['table_name'];

        $sql = "DROP TABLE IF EXISTS $table_name";
        $wpdb->query($sql);
    }
}