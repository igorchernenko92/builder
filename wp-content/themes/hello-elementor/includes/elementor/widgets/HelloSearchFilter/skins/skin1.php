<?php
namespace WPSight_Berlin\Elementor\Widgets\HelloSearchFilter\Skins;

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

    protected function render_header() {
        ?>
            <h1>Header</h1>
        <?php
    }

    protected function render_footer() {
        ?>
            <h1>Footer</h1>
        <?php
    }

	public function render() {

        $this->render_header();
        $this->render_search_form();
        $this->render_footer();
    }

}
