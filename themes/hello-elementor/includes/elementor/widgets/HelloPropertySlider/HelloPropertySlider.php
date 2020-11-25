<?php

namespace PropertyBuilder\Elementor\Widgets\HelloPropertySlider;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use ElementorPro\Base\Base_Widget;

include_once ( 'skins/skin-base.php');
include_once ( 'skins/skin1.php');
include_once ( 'skins/skin2.php');

class HelloPropertySlider extends Base_Widget {

	public function __construct( $data = [], $args = null ) {

		parent::__construct( $data, $args );
        wp_register_script('hello-property-slider-script', get_stylesheet_directory_uri() . '/includes/elementor/widgets/HelloPropertySlider/assets/js/base-script.js', '', '1', true);
        wp_register_style('hello-property-slide-style', get_stylesheet_directory_uri() . '/includes/elementor/widgets/HelloPropertySlider/assets/css/base-main.css', '', 1);
	}

    public function get_script_depends() {
        return ['hello-property-slider-script' ];
    }

    public function get_style_depends() {
        return ['hello-property-slider-style'];
    }

	public function get_name() {
		return 'hello_property_slider';
	}

	public function get_title() {
		return __( 'Hello Property Slider', 'elementor' );
	}

	public function get_icon() {
		return 'eicon-search-results';
	}

	public function get_categories() {
		return [ 'general' ];
	}

    public function get_keywords() {
        return [ 'slider', 'properties', 'banner', 'list' ];
    }

	protected function _register_skins() {
		$this->add_skin( new Skins\Skin1( $this ) );
		$this->add_skin( new Skins\Skin2( $this ) );
	}

	protected function _register_controls() {
        parent::_register_controls();

		$this->start_controls_section(
			'section_property_slider',
			[
				'label' => __( 'Property Slider', 'elementor' ),
			]
		);

		$this->end_controls_section();


        $this->start_controls_section(
            'property_style_icon',
            [
                'label' => __( 'Icon', 'elementor' ),
            ]
        );


        $this->end_controls_section();

	}




}
