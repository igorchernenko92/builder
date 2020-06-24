<?php
namespace WPSight_Berlin\Elementor\Widgets\HelloPropertyGallery\Skins;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class Hello_Gallery_Skin2 extends Hello_Gallery_Skin_Base {

	protected function _register_controls_actions() {
		parent::_register_controls_actions();
    }

	public function get_id() {
		return 'hello_gallery_skin2';
	}

	public function get_title() {
		return __( 'Skin 2', 'elementor-pro' );
	}

    protected function render_gellery_header() {
        echo "<div class='hl-gallery hl-gallery-2'>";
    }

    protected function render_gellery_images() {
        $count = array_fill(0, 5, 'some');

        ?>
            <div class="hl-gallery__list">
                <?php  foreach ($count as $i) { ?>
                    <picture class='hl-gallery__wrap-image'>
                        <img class='hl-gallery__image' src='https://via.placeholder.com/1200x900' alt=''>
                    </picture>
                <?php } ?>

                <picture class='hl-gallery__wrap-image hl-gallery__wrap-image-button'>
                    <span class="hl-gallery__wrap-image-text">See all</span>
                    <img class='hl-gallery__image' src='https://via.placeholder.com/1200x900' alt=''>
                </picture>
            </div>
        <?php
    }


}
