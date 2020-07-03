<?php
namespace PropertyBuilder\Elementor\Widgets\HelloPropertyGallery\Skins;

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
      $open_lightbox = $this->get_instance_value( 'open_lightbox' );
      $gallery = get_field('property_gallery', get_the_ID() );
      $unique_id_gallery = uniqid();
      ?>
          <div class="hl-gallery__list">
              <?php foreach ($gallery as $index => $attachment) {
                  $link_key = 'link_' . $index;
                  $link = $this->get_link_url( $attachment );
                  $this->parent->add_lightbox_data_attributes( $link_key, $attachment['id'], $open_lightbox, $this->get_id() . $unique_id_gallery );
                  $this->parent->add_render_attribute( $link_key, [
                      'class' => 'hl-gallery__list-item',
                  ] );

                  if ( $open_lightbox == 'yes' ) {
                      $this->parent->add_link_attributes( $link_key, $link );
                  }

                  $link_tag = '<a ' . $this->parent->get_render_attribute_string( $link_key ) . '>';
                  ?>
                  <?php echo $link_tag; ?>
                    <div class="hl-gallery__list-item-inner">
                      <span class="hl-gallery__list-item-text">See all</span>

                      <img
                        class="hl-gallery__image"
                        src="<?php echo $attachment['sizes']['medium_large']; ?>"
                        title="<?php echo $attachment['title']; ?>"
                        alt="<?php echo $attachment['alt']; ?>"
                      >
                    </div>
                  </a>
              <?php } ?>
          </div>
      <?php
  }


}
