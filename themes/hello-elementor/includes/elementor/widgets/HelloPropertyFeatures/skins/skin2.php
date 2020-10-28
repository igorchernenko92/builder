<?php
namespace PropertyBuilder\Elementor\Widgets\HelloPropertyFeatures\Skins;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class Skin2 extends Skin_Base {

	public function get_id() {
		return 'skin2';
	}

	public function get_title() {
		return __( 'Skin 2', 'elementor-pro' );
	}
}
