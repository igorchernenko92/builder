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

    public function render_navs() {
        ?>
            <button class='hl-property-slider__nav_prev hl-property-slider__nav'>
                <svg width="14" height="25" viewBox="0 0 14 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12.7357 23.7205L13.5004 22.9611C13.7392 22.7221 13.8707 22.4042 13.8707 22.0644C13.8707 21.7247 13.7392 21.4064 13.5004 21.1674L4.83783 12.5053L13.51 3.83313C13.7488 3.59452 13.8801 3.27619 13.8801 2.93657C13.8801 2.59694 13.7488 2.27843 13.51 2.03963L12.7501 1.28009C12.2559 0.785543 11.4509 0.785543 10.9567 1.28009L0.594392 11.6053C0.355787 11.8439 0.187669 12.1619 0.187669 12.5045L0.187669 12.5085C0.187669 12.8483 0.355976 13.1662 0.594393 13.4048L10.9287 23.7205C11.1673 23.9594 11.4948 24.0906 11.8345 24.091C12.1743 24.091 12.4973 23.9594 12.7357 23.7205Z" fill="#F6F7FB"/>
                </svg>
            </button>

            <button class='hl-property-slider__nav_next hl-property-slider__nav'>
                <svg width="14" height="25" viewBox="0 0 14 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.26403 1.27954L0.499398 2.03889C0.260605 2.27787 0.129052 2.59582 0.129052 2.93564C0.129052 3.27526 0.260605 3.59359 0.499398 3.83257L9.16193 12.4947L0.489787 21.1669C0.250994 21.4055 0.119629 21.7238 0.119629 22.0634C0.119629 22.4031 0.250994 22.7216 0.489787 22.9604L1.2497 23.7199C1.74388 24.2145 2.54884 24.2145 3.04301 23.7199L13.4054 13.3947C13.644 13.1561 13.8121 12.8381 13.8121 12.4955L13.8121 12.4915C13.8121 12.1517 13.6438 11.8338 13.4054 11.5952L3.07109 1.27954C2.83249 1.04056 2.50492 0.909378 2.1653 0.909002C1.82548 0.909002 1.50244 1.04056 1.26403 1.27954Z" fill="#F6F7FB"/>
                </svg>
            </button>
        <?php
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
