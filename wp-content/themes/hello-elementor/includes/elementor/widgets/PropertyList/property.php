<?php
namespace WPSight_Berlin\Elementor\Widgets\Property;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use ElementorPro\Modules\QueryControl\Module as Module_Query;
use ElementorPro\Modules\QueryControl\Controls\Group_Control_Related;
//use WPSight_Berlin\Elementor\Widgets\Property\Skins;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

include_once ( 'property-base.php');
include_once ( 'skins/skin-base.php');
include_once ( 'skins/skin1.php');
include_once ( 'skins/skin2.php');
include_once ( 'skins/skin3.php');

/**
 * Class Posts
 */
class Property extends Property_Base {

    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
        wp_register_script('hello-carousel-script', get_stylesheet_directory_uri() . '/includes/elementor/widgets/PropertyList/assets/js/base-script.js', '', '1', true);
        wp_register_style('hello-carousel-style', get_stylesheet_directory_uri() . '/includes/elementor/widgets/PropertyList/assets/css/base-main.css', '', 1);
    }

    public function get_script_depends() {
        return ['hello-carousel-script', 'swiper'];
    }

    public function get_style_depends() {
        return ['hello-carousel-style'];
    }

	public function get_name() {
		return 'property';
	}

	public function get_title() {
		return __( 'Hello Properties', 'elementor-pro' );
	}

	public function get_keywords() {
		return [ 'posts', 'cpt', 'item', 'loop', 'query', 'cards', 'custom post type' ];
	}

	public function on_import( $element ) {
		if ( ! get_post_type_object( $element['settings']['posts_post_type'] ) ) {
			$element['settings']['property_post_type'] = 'property';
		}

		return $element;
	}

	protected function _register_skins() {
		$this->add_skin( new Skins\Skin1( $this ) );
		$this->add_skin( new Skins\Skin2( $this ) );
		$this->add_skin( new Skins\Skin3( $this ) );
	}

	protected function _register_controls() {
		parent::_register_controls();

		$this->register_query_section_controls();
		$this->register_pagination_section_controls();

//		Deregistering specific controls for specific skins
        $this->remove_responsive_control( 'skin3_hello_is_carousel' );
	}

	public function query_posts() {
		$query_args = [
			'posts_per_page' => $this->get_current_skin()->get_instance_value( 'posts_per_page' ),
			'paged' => $this->get_current_page(),
            ];

        $this->set_settings('property_post_type', 'property');

        $check_get = get_option('hello_search_array');
        foreach ( (array)$_GET as $meta_key => $meta_value ) {
            if ( in_array( $meta_key, $check_get ) && ! empty( $meta_value ) ) {
                if ( 'keyword' == $meta_key ) {
                    $args['s'] = $meta_value;
                } elseif ( 'property_year_built' == $meta_key ) {
                    $args['meta_query'][] = array(
                        array(
                            'key' 		=> $meta_key,
                            'value' 	=> preg_replace( '/\s+/', '', $meta_value ), // date('Ymd'),
                            'type' 		=> 'DATE',
                            'compare' 	=> '=='
                        )
                    );
                } else {
                    $args['meta_query'][] = array(
                        array(
                            'key'   => $meta_key,
                            'value' => $meta_value
                        )
                    );
                }
            }
        }


		/** @var Module_Query $elementor_query */
		$elementor_query = Module_Query::instance();
		$this->query = $elementor_query->get_query( $this, $this->get_name(), $args, [] );

	}

	protected function register_query_section_controls() {
		$this->start_controls_section(
			'section_query',
			[
				'label' => __( 'Query', 'elementor-pro' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);


		$this->add_group_control(
			Group_Control_Related::get_type(),
			[
				'name' => $this->get_name(),
				'presets' => [ 'full' ],
				'exclude' => [
					'posts_per_page', //use the one from Layout section
				],
			]
		);

		$this->end_controls_section();
	}

}
