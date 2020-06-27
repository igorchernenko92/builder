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
      $gallery = get_field('property_gallery', get_the_ID() );
      ?>
          <div class="hl-gallery__list">
              <?php foreach ($gallery as $image) { ?>
                  <a class='hl-gallery__list-item' data-elementor-lightbox-slideshow="gallery_2" href="<?php echo $image['sizes']['large']; ?>">
                    <div class="hl-gallery__list-item-inner">
                      <span class="hl-gallery__list-item-text">See all</span>

                      <img
                        src="<?php echo $image['sizes']['medium_large']; ?>"
                        class="hl-gallery__image"
                        title="<?php echo $image['title']; ?>"
                        alt="<?php echo $image['alt']; ?>"
                      >
                    </div>
                  </a>
              <?php } ?>
          </div>
      <?php
  }


}
