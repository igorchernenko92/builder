<?php
namespace PropertyBuilder\Elementor\Widgets\HelloPropertySlider\Skins;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class Skin2 extends Skin_Base {

	public function get_id() {
		return 'skin2';
	}

	public function get_title() {
		return __( 'Skin 2', 'elementor-pro' );
	}

	public function render_location($location) {
	    ?>
            <div class="hl-property-slider__item-location">
                <i class="fa fa-map-marker-alt hl-property-slider__item-location-icon"></i>
                <span class="hl-property-slider__item-location-text">
                     <?php echo $location; ?>
                </span>
            </div>
        <?php
    }

    public function render_title($post_id, $post_title) {
        ?>
            <a href="<?php echo get_post_permalink($post_id) ?>" class="hl-property-slider__item-title">
                <?php echo $post_title; ?>
            </a>
        <?php
    }

    public function render_price($price) {
        ?>
            <div class="hl-property-slider__item-price">
                <?php echo $price; ?>
            </div>
        <?php
    }

    public function render_item($post) {
        $post = sanitize_post( $post, 'display' );
        $post_id = $post->ID;
        $post_title = $post->post_title;
        $location = get_field('property_location', $post_id, true)['address'] ?? '';
        $price = builder_get_property_price($post_id);

        $attr = array(
            'class' => "hl-property-slider__item-bg",
        );
        $thumbnail_url = get_the_post_thumbnail_url( $post_id, 'large', $attr );

        ?>
            <div class="hl-property-slider__item" style="background-image: url('<?php echo $thumbnail_url; ?>')">
                <div class="hl-property-slider__item-block">
                    <?php if ($location) :
                        $this->render_location($location);
                    endif;

                    if ($post_title) :
                        $this->render_title($post_id, $post_title);
                    endif;

                    if ($price) :
                        $this->render_price($price);
                    endif; ?>
                </div>
            </div>
        <?php
    }

    public function render_dots() {
	    ?>
            <div class="hl-property-slider__pagination slider-pagination"></div>
        <?php
    }

    public function render() {

        $args = array(
            'post_type' => 'property',
            'post_status' => 'publish',
            'posts_per_page' => $this->get_instance_value( 'posts_per_page' ),
        );

        $query = new \WP_Query($args);
        if ( ! $query->have_posts() ) {
            return;
        }

        ?>
        <div class="hl-property-slider-2">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php
                        foreach ( $query->posts as $post ) {
                            echo '<div class="swiper-slide">';
                                $this->render_item($post);
                            echo '</div>';
                        }
                    ?>
                </div>

                <?php $this->render_navs(); ?>
                <?php $this->render_dots(); ?>
            </div>
        </div>
        <?php
    }
}
