<?php
namespace PropertyBuilder\Elementor\Widgets\Agents\Skins;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Widget_Base;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class HelloAgentSkin2 extends HelloAgentSkinBase {

    public function __construct(Widget_Base $parent) {
        parent::__construct( $parent );
    }

	protected function _register_controls_actions() {
		parent::_register_controls_actions();
    }

	public function get_id() {
		return 'agent_skin2';
	}

	public function get_title() {
		return __( 'Skin 2', 'elementor-pro' );
	}




}
