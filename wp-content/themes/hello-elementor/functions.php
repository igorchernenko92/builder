<?php
/**
 * Theme functions and definitions
 *
 * @package HelloElementor
 */

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

			/*
			 * WooCommerce.
			 */
			$hook_result = apply_filters_deprecated( 'elementor_hello_theme_add_woocommerce_support', [ true ], '2.0', 'hello_elementor_add_woocommerce_support' );
			if ( apply_filters( 'hello_elementor_add_woocommerce_support', $hook_result ) ) {
				// WooCommerce in general.
				add_theme_support( 'woocommerce' );
				// Enabling WooCommerce product gallery features (are off by default since WC 3.0.0).
				// zoom.
				add_theme_support( 'wc-product-gallery-zoom' );
				// lightbox.
				add_theme_support( 'wc-product-gallery-lightbox' );
				// swipe.
				add_theme_support( 'wc-product-gallery-slider' );
			}
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

		if ( apply_filters( 'hello_elementor_enqueue_theme_style', true ) ) {
			wp_enqueue_style(
				'hello-elementor-theme-style',
				get_template_directory_uri() . '/theme' . $min_suffix . '.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}
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




function register_widgets() {

//    $condition_general = ['include/general'];
//    update_metadata( 'post', 83, '_elementor_conditions', $condition_general );

    $all_conditions = [];
    $query = new \WP_Query( [
        'posts_per_page' => -1,
        'post_type' => 'elementor_library',
//        'fields' => 'ids',
        'meta_key' => '_elementor_conditions',
    ] );

    foreach ( $query->posts as $post ) {
        $post_id = $post->ID;

        $document = \Elementor\Plugin::instance()->documents->get($post_id);

            if ( $document ) {
            $conditions = $document->get_meta( '_elementor_conditions' );

            $location = $document->get_location();
            if ( $location ) {
                if ( ! isset( $conditions[ $location ] ) ) {
                    $all_conditions[ $location ] = [];
                }
                $all_conditions[ $location ][ $document->get_main_id() ] = $conditions;
            }
        }
    }

    update_option( 'elementor_pro_theme_builder_conditions', $all_conditions );

}

add_action( 'init', 'register_widgets', 10 );


function import_data() {
    $xml = simplexml_load_file(file_get_contents('http://test.redcarlos.pro/pagess.xml'));

//    var_dump($xml);


}
//echo get_current_blog_id();
//add_action( 'init', 'import_data', 10 );


function my_acf_init() {
    acf_update_setting('google_api_key', 'AIzaSyCyzLPGLgRv_SOdc3anLhP8olpjrBocu6I');
}

add_action('acf/init', 'my_acf_init');


add_action( 'init', 'register_post_types' );
function register_post_types(){
    register_post_type( 'property', [
        'label'  => null,
        'labels' => [
            'name'               => 'Properties', // основное название для типа записи
            'singular_name'      => 'property', // название для одной записи этого типа
            'add_new'            => 'Добавить property', // для добавления новой записи
            'add_new_item'       => 'Добавление properties', // заголовка у вновь создаваемой записи в админ-панели.
            'edit_item'          => 'Редактирование property', // для редактирования типа записи
            'new_item'           => 'Новое property', // текст новой записи
            'view_item'          => 'Смотреть property', // для просмотра записи этого типа.
            'search_items'       => 'Искать property', // для поиска по этим типам записи
            'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
            'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
            'parent_item_colon'  => '', // для родителей (у древовидных типов)
            'menu_name'          => 'Properties', // название меню
        ],
        'description'         => '',
        'public'              => true,
        // 'publicly_queryable'  => null, // зависит от public
        // 'exclude_from_search' => null, // зависит от public
        // 'show_ui'             => null, // зависит от public
        // 'show_in_nav_menus'   => null, // зависит от public
        'show_in_menu'        => null, // показывать ли в меню адмнки
        // 'show_in_admin_bar'   => null, // зависит от show_in_menu
        'show_in_rest'        => null, // добавить в REST API. C WP 4.7
        'rest_base'           => null, // $post_type. C WP 4.7
        'menu_position'       => null,
        'menu_icon'           => null,
        //'capability_type'   => 'post',
        //'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
        //'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
        'hierarchical'        => false,
        'supports'            => [ 'title', 'editor', 'thumbnail' ], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
        'taxonomies'          => [],
        'has_archive'         => false,
        'rewrite'             => true,
        'query_var'           => true,
    ] );
}

add_action( 'init', 'create_prop_tax' );

function create_prop_tax() {
    register_taxonomy(
        'features',
        'property',
        array(
            'label' => __( 'Features' ),
            'rewrite' => array( 'slug' => 'features' ),
            'hierarchical' => true,
        )
    );
}

/**
 * Implement widgets creating
 */
require get_template_directory() . '/includes/elementor/widgets-manager.php';
require get_template_directory() . '/includes/acfFields.php';


//$creds = array();
//$creds['user_login'] = 'email+1217@example.com';
//$creds['user_password'] = 'fake-password';
////$creds['remember'] = true;
//wp_signon($creds);

//add_filter( 'http_request_host_is_external', '__return_true' );

//add_filter( 'wp_image_editors', 'change_graphic_lib' );

//function change_graphic_lib($array) {
//    return array( 'WP_Image_Editor_GD', 'WP_Image_Editor_Imagick' );
//}




add_action( 'init', 'czc_disable_extra_image_sizes' );
add_filter( 'image_resize_dimensions', 'czc_disable_crop', 10, 6 );
function czc_disable_crop( $enable, $orig_w, $orig_h, $dest_w, $dest_h, $crop )
{
    // Instantly disable this filter after the first run
    // remove_filter( current_filter(), __FUNCTION__ );
    // return image_resize_dimensions( $orig_w, $orig_h, $dest_w, $dest_h, false );
    return false;
}
function czc_disable_extra_image_sizes()
{
    foreach (get_intermediate_image_sizes() as $size) {
        remove_image_size($size);
    }
}










