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

    protected function render_gellery_header() {
        echo "<div class='hl-gallery hl-gallery-1'>";
    }

    protected function render_gellery_footer() {
        echo "</div>";
    }

    protected function render_gellery_images() {
//        if ( !$this->get_instance_value( 'hello_is_thumb_carousel' ) ) return;

        $gallery = get_field('property_gallery', get_the_ID() );
//        var_dump($gallery);

//        if ($gallery) {
//            foreach ($gallery as $image) {
//
//            }
//        }


        ?>
          <div class="hl-gallery__slider">
              <div class='swiper-container'>
                  <div class='swiper-wrapper'>
                      <?php foreach ($gallery as $image) {
//                          var_dump( $image['sizes'] );
                          ?>
                          <div class='swiper-slide'>
                              <a class='hl-gallery__wrap-image' href="<?php echo $image['sizes']['large']; ?>">
                                    <img
                                            src="<?php echo $image['sizes']['medium_large']; ?>"
                                            class="hl-listing-card__picture-img hl-img-responsive"
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

<!--              <div class="hl-gallery__slider-pagination slider-pagination"></div>-->
          </div>
        <?php
    }

    public function render()
    {
        $this->render_gellery_header();
            $this->render_gellery_images();
        $this->render_gellery_footer();
    }


}
