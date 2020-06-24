<?php
namespace WPSight_Berlin\Elementor\Widgets\HelloPropertyGallery;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use ElementorPro\Modules\QueryControl\Module as Module_Query;
use ElementorPro\Modules\QueryControl\Controls\Group_Control_Related;
//use WPSight_Berlin\Elementor\Widgets\Property\Skins;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

include_once ( 'skins/skin-base.php');
include_once ( 'skins/skin1.php');
include_once ( 'skins/skin2.php');
include_once ( 'skins/skin3.php');


class HelloPropertyGallery extends Widget_Base {

    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
        wp_register_script('hello-property-gallery-script', get_stylesheet_directory_uri() . '/includes/elementor/widgets/HelloPropertyGallery/assets/js/gallery-base-script.js', '', '1', true);
        wp_register_style('hello-property-gallery-style', get_stylesheet_directory_uri() . '/includes/elementor/widgets/HelloPropertyGallery/assets/css/gallery-base-main.css', '', 1);
    }

    public function get_script_depends() {
        return ['hello-property-gallery-script', 'swiper'];
    }

    public function get_style_depends() {
        return ['hello-property-gallery-style'];
    }

	public function get_name() {
		return 'hello_property_gallery';
	}

	public function get_title() {
		return __( 'Hello Property Gallery', 'elementor-pro' );
	}

	public function get_keywords() {
		return [ 'posts', 'cpt', 'item', 'loop', 'query', 'cards', 'custom post type' ];
	}

	protected function _register_skins() {
		$this->add_skin( new Skins\Hello_Gallery_Skin1( $this ) );
		$this->add_skin( new Skins\Hello_Gallery_Skin2( $this ) );
		$this->add_skin( new Skins\Hello_Gallery_Skin3( $this ) );
	}

	protected function _register_controls() {

        $this->start_controls_section(
            'section_layout',
            [
                'label' => __( 'Layout', 'elementor-pro' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );


        $this->end_controls_section();

	}


}
