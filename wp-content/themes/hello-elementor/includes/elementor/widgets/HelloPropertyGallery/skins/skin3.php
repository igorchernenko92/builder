<?php
namespace WPSight_Berlin\Elementor\Widgets\HelloPropertyGallery\Skins;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;use WPSight_Berlin\Elementor\Widgets\HelloPropertyGallery\Skins\Hello_Gallery_Skin_Base;


class Hello_Gallery_Skin3 extends Hello_Gallery_Skin_Base {

	protected function _register_controls_actions() {
		parent::_register_controls_actions();
    }

	public function get_id() {
		return 'skin3';
	}

	public function get_title() {
		return __( 'Skin 3', 'elementor-pro' );
	}


}
