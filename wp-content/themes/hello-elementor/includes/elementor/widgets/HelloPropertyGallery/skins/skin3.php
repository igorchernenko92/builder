<?php
namespace WPSight_Berlin\Elementor\Widgets\HelloPropertyGallery\Skins;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use WPSight_Berlin\Elementor\Widgets\HelloPropertyGallery\Skins\Hello_Gallery_Skin_Base;


class Hello_Gallery_Skin3 extends Hello_Gallery_Skin_Base {

	protected function _register_controls_actions() {
		parent::_register_controls_actions();
    }

	public function get_id() {
		return 'hello_gallery_skin3';
	}

	public function get_title() {
		return __( 'Skin 3', 'elementor-pro' );
	}

  protected function render_gellery_header() {
      echo "<div class='hl-gallery hl-gallery-3'>";
  }

  protected function render_gellery_images() {
      $gallery = get_field('property_gallery', get_the_ID() );
      ?>
          <div class="hl-gallery__slider">
            <div class="swiper-container hl-gallery__slider-top">
              <div class="swiper-wrapper">
                  <?php foreach ($gallery as $image) { ?>
                      <div class='swiper-slide'>
                          <a class="hl-gallery__wrap-image" data-elementor-lightbox-slideshow="gallery_3" href="<?php echo $image['sizes']['large']; ?>">
                              <img
                                  src="<?php echo $image['sizes']['large']; ?>"
                                  class="hl-gallery__image"
                                  title="<?php echo $image['title']; ?>"
                                  alt="<?php echo $image['alt']; ?>"
                              >
                          </a>
                      </div>
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

            <div class="swiper-container hl-gallery__slider-thumbs">
                <div class="swiper-wrapper">
                    <?php foreach ($gallery as $image) { ?>
                        <div class='swiper-slide'>
                            <div class="hl-gallery__wrap-image">
                                <img
                                    src="<?php echo $image['sizes']['medium_large']; ?>"
                                    class="hl-gallery__image"
                                    title="<?php echo $image['title']; ?>"
                                    alt="<?php echo $image['alt']; ?>"
                                >
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
          </div>
      <?php
  }

}
