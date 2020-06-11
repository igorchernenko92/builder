<?php
namespace WPSight_Berlin\Elementor\Widgets\Property\Skins;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class Skin1 extends Skin_Base {

	protected function _register_controls_actions() {
		parent::_register_controls_actions();

        wp_enqueue_script('hello-carousel-script', get_stylesheet_directory_uri() . '/includes/elementor/widgets/PropertyList/assets/js/skin1.js', '', '1', true);
        wp_enqueue_style( 'hello-carousel-style', get_stylesheet_directory_uri() . '/includes/elementor/widgets/PropertyList/assets/css/skin1.css', '', 1 );

    }

	public function get_id() {
		return 'skin1';
	}

	public function get_title() {
		return __( 'Skin 1', 'elementor-pro' );
	}

    protected function render_loop_header() {

    }

    protected function render_loop_footer() {

    }

}
