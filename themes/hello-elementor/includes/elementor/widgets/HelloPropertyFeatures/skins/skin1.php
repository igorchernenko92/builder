<?php
namespace PropertyBuilder\Elementor\Widgets\HelloPropertyFeatures\Skins;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Widget_Base;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class Skin1 extends Skin_Base {

	public function get_id() {
		return 'skin1';
	}

	public function get_title() {
		return __( 'Skin 1', 'elementor-pro' ); 
	}


}
