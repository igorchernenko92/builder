<?php
namespace PropertyBuilder\Elementor;

use ElementorPro\Base\Module_Base;
use PropertyBuilder\Elementor\Documents\PropertyArchive;
use PropertyBuilder\Elementor\Conditions\Property;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Widget_Manager
 *
 * @since 1.0.0
 */
class Widget_Manager {

    private $modules = [];

    /**
     * Instance
     *
     * @since 1.0.0
     * @access private
     * @static
     *
     * @var Widget_Manager single instance of the class.
     */
    private static $_instance = null;

    /**
     * Instance
     *
     * Ensures only one instance of the class is loaded or can be loaded.
     *
     * @since 1.0.0
     * @access public
     *
     * @return Widget_Manager an instance of the class.
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * Include Widgets files
     *
     * Load widgets files
     *
     * @since 1.0.0
     * @access private
     */
    private function include_widgets_files() {
        // TODO: move widget folder to variable
        include_once( 'widgets/PropertyList/property.php' );
        include_once( 'widgets/HelloPropertyGallery/HelloPropertyGallery.php' );
        include_once( 'widgets/HelloAgentList/HelloAgents.php' );
        include_once( 'widgets/HelloMap/HelloGoogleMap.php' );
        include_once( 'widgets/HelloSearchFilter/HelloSearchFilter.php' );
        include_once( 'widgets/HelloPropertyDetails/HelloPropertyDetails.php' );
//        include_once( 'widgets/HelloPropertyFeatures/HelloPropertyFeatures.php' );
        include_once( 'widgets/HelloPropertyFeatures.php' );
        include_once( 'widgets/HelloPropertySlider/HelloPropertySlider.php' );
        include_once( 'widgets/HelloPropertyPrice.php' );
        include_once( 'widgets/HelloPropertyStatus.php' );
//
        include_once( 'widgets/ListingDetails.php' );

        include_once( 'widgets/hello-max-width.php' );

    }

    /**
     * Register Widgets
     *
     * Register new Elementor widgets.
     *
     * @since 1.0.0
     * @access public
     */
    public function register_widgets() {
        $this->include_widgets_files();

        // Register Widgets

       \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\HelloMap\HelloGoogleMap() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\ListingDetails() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Property\Property() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\HelloPropertyGallery\HelloPropertyGallery() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Agents\HelloAgents() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\HelloSearchFilter\HelloSearchFilter() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\HelloPropertyDetails\HelloPropertyDetails() );

//        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\HelloPropertyFeatures\HelloPropertyFeatures() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\HelloPropertyFeatures() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\HelloPropertySlider\HelloPropertySlider() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\HelloPropertyPrice() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\HelloPropertyStatus() );
    }

    /**
     * Add Widget category
     *
     * Adds new widget category to group theme-specific widgets.
     *
     * @since 1.0.0
     * @access public
     */
    public function add_widget_categories( $elements_manager ) {

        $elements_manager->add_category(
            'theme',
            [
                'title' => __( 'Theme', 'wpcasa-berlin' ),
                'icon' => 'fa fa-plug',
            ]
        );

    }

    /**
     *  Widget_Manager class constructor
     *
     * Register action hooks and filters
     *
     * @since 1.0.0
     * @access public
     */
    public function __construct() {
        include_once( 'documents/PropertyArchive.php' );
        include_once( 'conditions/Property.php' );
        add_action(
            'elementor/documents/register',
            function( $manager ) {

                $manager->register_document_type( 'property-archive', PropertyArchive::get_class_full_name() );

            }
        );

        add_action(
            'elementor/theme/register_conditions',
            function( $manager ) {

                $listings = new Property();

                $manager->get_condition( 'general' )->register_sub_condition( $listings );
            }
        );

        // Register widgets
        add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );

        // Add widget categories
        add_action( 'elementor/elements/categories_registered', [ $this, 'add_widget_categories'] );
    }
}

Widget_Manager::instance();



