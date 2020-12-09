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
      $image_size = 'large'; // need to load first image bigger
      ?>
        <div class="swiper-container">
          <div class="hl-gallery__list swiper-wrapper">
              <?php foreach ($gallery as $index => $attachment) {

                  if ($index !== array_key_first($gallery)) {
                      $image_size = 'medium_large';
                  }
                  $link_key = 'link_' . $index;
                  $link = $this->get_link_url( $attachment );
                  $this->parent->add_lightbox_data_attributes( $link_key, $attachment['id'], $open_lightbox, $this->get_id() . $unique_id_gallery );
                  $this->parent->add_render_attribute( $link_key, [
                      'class' => 'hl-gallery__list-item swiper-slide',
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
                        src="<?php echo $attachment['sizes'][$image_size]; ?>"
                        title="<?php echo $attachment['title']; ?>"
                        alt="<?php echo $attachment['alt']; ?>"
                      >
                    </div>
                  </a>
              <?php } ?>
          </div>

          <button class='hl-gallery__slider-nav_prev hl-gallery__slider-nav hl-listing-card__carousel-nav'>
            <svg xmlns="http://www.w3.org/2000/svg" fill='currentColor' width="24" height="24" viewBox="0 0 24 24">
              <path fill="#222" fill-rule="nonzero" d="M9 17.523L10.39 19 17 12l-6.61-7L9 6.477 14.215 12z"/>
            </svg>
          </button>

          <button class='hl-gallery__slider-nav_next hl-gallery__slider-nav hl-listing-card__carousel-nav'>
            <svg xmlns="http://www.w3.org/2000/svg" fill='currentColor' width="24" height="24" viewBox="0 0 24 24">
              <path fill="#222" fill-rule="nonzero" d="M9 17.523L10.39 19 17 12l-6.61-7L9 6.477 14.215 12z"/>
            </svg>
          </button>
        </div>
      <?php
  }


}
