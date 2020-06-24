<?php
namespace WPSight_Berlin\Elementor\Widgets\HelloPropertyGallery\Skins;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Skin_Base as Elementor_Skin_Base;
use Elementor\Widget_Base;
use ElementorPro\Plugin;

abstract class Hello_Gallery_Skin_Base extends Elementor_Skin_Base {

	protected $current_permalink;

	protected function _register_controls_actions() {
//		add_action( 'elementor/element/hello_property_gallery/section_layout/before_section_end', [ $this, 'register_controls' ] );
    }


    public function get_id() {
        return 'hello_property_skin_base';
    }

    public function render() {
        echo 'sdcsd';
    }


}
