<?php 
/**
 * Plugin Name: Builder
 * Description: Описание плагина желательно не очень длинное
 * Plugin URI:  Ссылка на инфо о плагине
 * Author URI:  Ссылка на автора
 * Author:      Имя автора
 * Version:     1.0
 *
 * Text Domain: Идентификатор перевода, указывается в load_plugin_textdomain()
 * Domain Path: Путь до файла перевода. Нужен если файл перевода находится не в той же папке, в которой находится текущий файл.
 *              Например, .mo файл находится в папке myplugin/languages, а файл плагина в myplugin/myplugin.php, тогда тут указываем "/languages"
 *
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * Network:     Укажите "true" для возможности активировать плагин по все сети сайтов (для Мультисайтовой сборки).
 */

// Include ABS path
include_once(ABSPATH . 'wp-admin/includes/plugin.php');
	
if ( ! class_exists( 'Property_Builder' ) ) {
	
	/**
	 * Localisation
	 */
	// load_plugin_textdomain( 'wp_builder', false, dirname( plugin_basename( __FILE__ ) ) . '/' );

	class Property_Builder {

	    public function __construct()   {
            // Define constants
            if ( ! defined( 'BUILDER_NAME' ) )
                define( 'BUILDER_NAME', 'Builder' );

            if ( ! defined( 'BUILDER_DOMAIN' ) )
                define( 'BUILDER_DOMAIN', 'builder' );

            define( 'BUILDER_VERSION', '1.0' );
            define( 'BUILDER_PLUGIN_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
            define( 'BUILDER_PLUGIN_URL', untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) ) );





	        add_action('init', array( $this, 'register_logo_options_page') );
	        add_action('init', array( $this, 'register_acf_fields') );


            // Include classes
            include( BUILDER_PLUGIN_DIR . '/includes/class-builder-general.php' );

            // Include functions
            include( BUILDER_PLUGIN_DIR . '/functions/builder-properties.php' );


            // called after all plugins have loaded
            add_action( 'plugins_loaded', array( &$this, 'plugins_loaded' ) );
	    }

	    public function register_logo_options_page() {

	        if ( function_exists('acf_add_options_page') ) {

	            $option_page = acf_add_options_page( array(
	                'page_title'    => 'Hello builder',
	                'menu_title'    => 'Hello builder',
	                'menu_slug'     => 'hello_builder',
	                'capability'    => 'edit_posts',
	                'redirect'  	=> false
                ) );

	        }

	    }

	    public function register_acf_fields ()  {

	        if ( function_exists('acf_add_local_field_group') ) {

	        	acf_add_local_field_group( array(
					'key' 	 => 'filter_fields_g',
					'title'  => 'Fields',
					'fields' => array(
						
						array(
			                'key' 				=> 'build_list_prop_fields',
			                'label' 			=> 'Property list fields',
			                'name' 				=> 'property_list',
			                'type' 				=> 'checkbox',
			                'instructions' 		=> '',
			                'required' 			=> 0,
			                'conditional_logic' => 0,
			                'wrapper' 			=> array(
			                    'width' 	=> '',
			                    'class' 	=> '',
			                    'id' 		=> '',
			                ),
			                'choices' 			=> array(
			                    'property_year_built' 		=> 'Year Built',
			                    'property_bedrooms' 		=> 'Bedrooms',
			                    'property_bath' 			=> 'Bath',
			                    'property_garages' 			=> 'Garages',
			                    'property_rooms' 			=> 'Rooms',
			                    'property_living_area' 		=> 'Living Area',
			                    'property_terrace' 			=> 'Terrace',
			                ),
			                'allow_null' 		=> 0,
			                'other_choice' 		=> 0,
			                'default_value' 	=> '',
			                'layout' 			=> 'vertical',
			                'return_format' 	=> 'value',
			                'save_other_choice' => 0,
			            ),

					),
					'location' => array (
	                    array (
	                        array (
	                            'param' 	=> 'options_page',
	                            'operator' 	=> '==',
	                            'value' 	=> 'hello_builder',
	                        ),
	                    ),
	                ),
					'menu_order' 			=> 0,
					// 'position' 				=> 'side',
					'style' 				=> 'default',
					'label_placement' 		=> 'top',
					'instruction_placement' => 'label',
					'hide_on_screen' 		=> '',
				) );

	        }

	    }

	    /**
		 * Take care of anything that needs all plugins to be loaded
		 */
		public function plugins_loaded() {

			if ( is_plugin_inactive('advanced-custom-fields-pro/acf.php' ) ) {

				add_action('all_admin_notices', 'wp_manager_required_notice');

				function wp_manager_required_notice() {

			        $plugin_data = get_plugin_data(__FILE__);
			        echo '
			        <div class="error">
			          <p>'.sprintf( __('<strong>%s</strong> You must install <strong><a href="https://github.com/wp-premium/advanced-custom-fields-pro" target="_blank">Advanced Custom Fields Pro</a></strong> plugin to use Builder.', 'wp_manager_txtd'), $plugin_data['Name'] ).'</p>
			        </div>';
				}

			} else {

				if ( function_exists('acf_add_local_field_group') ) :

					// 
					

				endif;
			}
		}
	}

	$builder = new Property_Builder();
}