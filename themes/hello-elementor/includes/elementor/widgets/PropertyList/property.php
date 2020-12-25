<?php
namespace PropertyBuilder\Elementor\Widgets\Property;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use ElementorPro\Modules\QueryControl\Module as Module_Query;
use ElementorPro\Modules\QueryControl\Controls\Group_Control_Related;
//use PropertyBuilder\Elementor\Widgets\Property\Skins;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

include_once ( 'property-base.php');
include_once ( 'skins/skin-base.php');
include_once ( 'skins/skin1.php');
include_once ( 'skins/skin2.php');
include_once ( 'skins/skin3.php');
include_once ( 'skins/skin4.php');


class Property extends Property_Base {
    private $type_list;
    private $type_list_meta;

    public function __construct($data = [], $args = null) {
        $this->type_list = builder_get_options_array();
        $this->type_list_meta = builder_get_options_array(false, [], ['property_year_built', 'property_price', 'keyword' ]);

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

    public function get_type_list() {
        return $this->type_list;
    }

    public function get_type_list_meta() {
        return $this->type_list_meta;
    }

	public function get_name() {
		return 'property';
	}

	public function get_title() {
		return __( 'Hello Properties', 'elementor-pro' );
	}

	public function get_keywords() {
		return [ 'posts', 'item', 'cards', 'custom post type', 'listing', 'listings', 'property', 'properties' ];
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
		$this->add_skin( new Skins\Skin4( $this ) );
	}

	protected function _register_controls() {
		parent::_register_controls();

		$this->register_query_section_controls();
		$this->register_pagination_section_controls();

//		Deregister specific controls for specific skins
        $this->remove_responsive_control( 'skin3_hello_is_carousel' );
	}

	public function query_posts() {
        $args = [
            'posts_per_page' => $this->get_current_skin()->get_instance_value( 'posts_per_page' ),
			'paged' => $this->get_current_page(),
        ];

        if ( is_singular('propperty') ) {
            $args['post__not_in'] = array( get_the_ID() );
        }

        $this->set_settings('property_post_type', 'property'); // query only property post type

        $check_get = array_keys( $this->get_type_list() );
        $getParam = (array)$_GET;
        $property_tax = array_keys( get_object_taxonomies( 'property', 'objects' ) );

        foreach ( $getParam as $meta_key => $meta_value ) {
            if ( in_array( $meta_key, $check_get ) && !empty( $meta_value ) ) {
                $type = '';
                $compare = '';

                if ( in_array($meta_key, $property_tax) ) { // if any of tax in the list add tax to query
                    $args['tax_query'][] = [
                        [
                            'taxonomy' => $meta_key,
                            'field'    => 'slug',
                            'terms'    => $meta_value
                        ]
                    ];
                    continue;
                }

                if ( 'property_year_built' == $meta_key ) {
                    $type = 'DATE';
                    $compare = '==';
                    $meta_value = preg_replace( '/\s+/', '', $meta_value ); // date('Ymd'),
                }

                if ( 'property_price' == $meta_key ) {
                    $type = 'numeric';
                    $compare = 'BETWEEN';

                    if ( empty( $meta_value['min'] )  ) {
                        $meta_value['min'] = 0;
                    }

                    if ( empty( $meta_value['max'] ) ) {
                        $meta_value['max'] = 999999999;
                    }

                    $meta_value = array( $meta_value['min'], $meta_value['max'] );
                }

                    $args['meta_query'][] = array(
                        array(
                            'key'   => $meta_key,
                            'value' => $meta_value,
                            'type'    => $type,
                            'compare' => $compare
                        )
                    );
            }
        }

        if ( is_tax() ) {
            $args['tax_query'][] = [
                [
                    'taxonomy' => get_query_var( 'taxonomy' ),
                    'field'    => 'slug',
                    'terms'    => get_query_var( 'term' )
                ]
            ];
        }

        if ( is_singular('agent') ) {
            $agent_posts = get_field('agent_properties', get_the_ID());

            if ( $agent_posts ) {
                $args['post__in'] = $agent_posts;
            } else {
                $args['post__in'] = array('99999999'); // if no property related to agent show nothing
            }
        }

		$elementor_query = Module_Query::instance();
		$this->query = $elementor_query->get_query( $this, $this->get_name(), $args, [] );

	}

	protected function register_query_section_controls() {

	}

}
