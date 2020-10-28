<?php

namespace PropertyBuilder\Elementor\Widgets\HelloPropertyFeatures;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use ElementorPro\Base\Base_Widget;

include_once ( 'skins/skin-base.php');
include_once ( 'skins/skin1.php');
include_once ( 'skins/skin2.php');

class HelloPropertyFeatures extends Base_Widget {

	public function __construct( $data = [], $args = null ) {

		parent::__construct( $data, $args );
//		wp_enqueue_style( 'ut-datepicker-css', get_template_directory_uri() . '/includes/elementor/widgets/assets/css/datepicker.css', array(), date("Ymd"), false );
//		wp_enqueue_script( 'ut-datepicker-js', get_template_directory_uri() . '/includes/elementor/widgets/assets/js/datepicker.js', array(), date("Ymd"), false );

        wp_register_script('hello-features-script', get_stylesheet_directory_uri() . '/includes/elementor/widgets/HelloPropertyFeatures/assets/js/base-script.js', '', '1', true);
        wp_register_style('hello-features-style', get_stylesheet_directory_uri() . '/includes/elementor/widgets/HelloPropertyFeatures/assets/css/base-main.css', '', 1);
	}

    public function get_script_depends() {
        return ['hello-features-script' ];
    }

    public function get_style_depends() {
        return ['hello-features-style'];
    }

	public function get_name() {
		return 'hello_property_features';
	}

	public function get_title() {
		return __( 'Hello Property Features', 'elementor' );
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
			'section_property_features',
			[
				'label' => __( 'Property Features', 'elementor' ),
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
