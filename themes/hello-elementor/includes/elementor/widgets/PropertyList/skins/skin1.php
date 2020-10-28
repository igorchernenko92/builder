<?php
namespace PropertyBuilder\Elementor\Widgets\Property\Skins;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Widget_Base;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class Skin1 extends Skin_Base {

    public function __construct(Widget_Base $parent) {
        parent::__construct( $parent );
    }

	protected function _register_controls_actions() {
		parent::_register_controls_actions();
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
