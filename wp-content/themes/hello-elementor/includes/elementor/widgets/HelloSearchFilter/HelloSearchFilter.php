<?php

namespace PropertyBuilder\Elementor\Widgets\HelloSearchFilter;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Text_Shadow; 
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use ElementorPro\Base\Base_Widget;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// include_once ( 'property-base.php');
include_once ( 'skins/skin-base.php');
include_once ( 'skins/skin1.php');
include_once ( 'skins/skin2.php');

class HelloSearchFilter extends Base_Widget {

	public function __construct( $data = [], $args = null ) {

		parent::__construct( $data, $args );
//		wp_enqueue_style( 'ut-datepicker-css', get_template_directory_uri() . '/includes/elementor/widgets/assets/css/datepicker.css', array(), date("Ymd"), false );
//		wp_enqueue_script( 'ut-datepicker-js', get_template_directory_uri() . '/includes/elementor/widgets/assets/js/datepicker.js', array(), date("Ymd"), false );

        wp_register_script('hello-search-script', get_stylesheet_directory_uri() . '/includes/elementor/widgets/HelloSearchFilter/assets/js/base-script.js', '', '1', true);
        wp_register_style('hello-search-style', get_stylesheet_directory_uri() . '/includes/elementor/widgets/HelloSearchFilter/assets/css/base-main.css', '', 1);

        wp_register_script('hello-search-select2', get_stylesheet_directory_uri() . '/includes/elementor/widgets/HelloSearchFilter/assets/js/select2.min.js', '', '1', true);
        wp_register_style('hello-search-select2-style', get_stylesheet_directory_uri() . '/includes/elementor/widgets/HelloSearchFilter/assets/css/select2.min.css', '', 1);

        wp_enqueue_script( 'hello-search-multiple',  get_stylesheet_directory_uri() . '/includes/elementor/widgets/HelloSearchFilter/assets/js/multiple-select.min.js', '', '1', true );
        wp_enqueue_style( 'hello-search-multiple-style', get_stylesheet_directory_uri() . '/includes/elementor/widgets/HelloSearchFilter/assets/css/multiple-select.min.css');

	}

    public function get_script_depends() {
        return ['hello-search-select2', 'hello-search-script', 'hello-search-multiple' ];
    }

    public function get_style_depends() {
        return ['hello-search-style', 'hello-search-select2-style', 'hello-search-multiple-style'];
    }

	public function get_name() {
		return 'search_filter';
	}

	public function get_title() {
		return __( 'Hello Search Filter', 'elementor' );
	}

	public function get_icon() {
		return 'eicon-search-results';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	protected function _register_skins() {
		$this->add_skin( new Skins\Skin1( $this ) );
		$this->add_skin( new Skins\Skin2( $this ) );
	}

	protected function _register_controls() {
        parent::_register_controls();

		$this->start_controls_section(
			'section_search_filter',
			[
				'label' => __( 'Search Filter', 'elementor' ),
			]
		);

		$this->end_controls_section();
	}
}
