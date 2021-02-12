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

	class Property_Builder {

	    public function __construct() {
            // Define constants
            if ( ! defined( 'BUILDER_NAME' ) )
                define( 'BUILDER_NAME', 'Builder' );

            if ( ! defined( 'BUILDER_DOMAIN' ) )
                define( 'BUILDER_DOMAIN', 'builder' );

            define( 'BUILDER_VERSION', '1.0.0' );
            define( 'BUILDER_PLUGIN_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
            define( 'BUILDER_PLUGIN_URL', untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) ) );


            //admin
            include( BUILDER_PLUGIN_DIR . '/includes/admin/class-builder-admin.php' );

            // Include classes
            include( BUILDER_PLUGIN_DIR . '/includes/class-builder-general.php' );

            // Include functions
            include( BUILDER_PLUGIN_DIR . '/functions/builder-properties.php' );

            // Include wordpress pluggable
            include( BUILDER_PLUGIN_DIR . '/functions/builder-notifications.php' );


            if ( is_admin() )
                $this->admin = new Builder_Admin();

            // called after all plugins have loaded
//            add_action( 'plugins_loaded', array( &$this, 'plugins_loaded' ) );
	    }
	}

	$builder = new Property_Builder();
}