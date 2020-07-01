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
		add_action( 'elementor/element/hello_property_gallery/section_layout/before_section_end', [ $this, 'register_controls' ] );
//        'elementor/element/' . $this->get_name() . '/' . $section_id . '/after_section_start'
    }

    public function get_id() {
        return 'hello_property_skin_base';
    }

    public function register_controls(Widget_Base $widget) {
        $this->parent = $widget;

        $this->register_gallery_controls();
    }

    protected function register_gallery_controls( ) {
        $this->add_control(
            'open_lightbox',
            [
                'label' => __( 'Lightbox', 'elementor' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'yes',
                'options' => [
                    'yes' => __( 'Yes', 'elementor' ),
                    'no' => __( 'No', 'elementor' ),
                ]
            ]
        );
    }

    protected function render_gellery_header() {
        echo "<div class='hl-gallery hl-gallery-1'>";
    }

    protected function render_gellery_footer() {
        echo "</div>";
    }

    protected function render_gellery_images() {
        $open_lightbox = $this->get_instance_value( 'open_lightbox' );
        $gallery = get_field('property_gallery', get_the_ID() );
        $unique_id_gallery = "unique_id";
        ?>
          <div class="hl-gallery__slider">
              <div class='swiper-container'>
                  <div class='swiper-wrapper'>
                      <?php foreach ($gallery as $index => $attachment) {
                          $link_key = 'link_' . $index;
//                          $image_url = Group_Control_Image_Size::get_attachment_image_src( $attachment['id'], 'thumbnail', $settings );

                          $link = $this->get_link_url( $attachment );


                          $this->parent->add_lightbox_data_attributes( $link_key, $attachment['id'], $open_lightbox, $this->get_id() . $unique_id_gallery );
                          $this->parent->add_render_attribute( $link_key, [
                              'class' => 'hl-gallery__wrap-image',
                          ] );

                          if ( $open_lightbox == 'yes' ) {
                              $this->parent->add_link_attributes( $link_key, $link );
                           }

                          $link_tag = '<a ' . $this->parent->get_render_attribute_string( $link_key ) . '>';
                      ?>
                          <div class='swiper-slide'>
                              <?php echo $link_tag; ?>
                                    <img
                                        src="<?php echo $attachment['sizes']['medium_large']; ?>"
                                        class="hl-listing-card__picture-img hl-img-responsive"
                                        title="<?php echo $attachment['title']; ?>"
                                        alt="<?php echo $attachment['alt']; ?>"
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

    public function render() {
        $this->render_gellery_header();
            $this->render_gellery_images();
        $this->render_gellery_footer();
    }


    protected function get_link_url( $attachment ) {
        return [
            'url' => wp_get_attachment_url( $attachment['id'] ),
        ];
    }


}
