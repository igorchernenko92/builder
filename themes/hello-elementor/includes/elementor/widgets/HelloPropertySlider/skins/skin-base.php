<?php
namespace PropertyBuilder\Elementor\Widgets\HelloPropertySlider\Skins;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Skin_Base as Elementor_Skin_Base;
use Elementor\Widget_Base;
use ElementorPro\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

abstract class Skin_Base extends Elementor_Skin_Base {

    protected function _register_controls_actions() {
        add_action( 'elementor/element/hello_property_slider/section_property_slider/before_section_end', [ $this, 'register_main_controls' ] );
        add_action( 'elementor/element/hello_property_slider/property_style_icon/before_section_end', [ $this, 'register_style_controls' ] );
    }

    public function get_id() {
        return 'skin-base';
    }


    public function register_main_controls( Widget_Base $widget ) {
        $this->parent = $widget;


        $this->add_responsive_control(
            'posts_per_page',
            [
                'label' => __( 'Posts Per Page', 'elementor-pro' ),
                'description' => __( '-1 for all', 'elementor-pro' ),
                'type' => Controls_Manager::NUMBER,
                'default' => -1,
            ]
        );



    }

    public function register_style_controls( Widget_Base $widget ) {
//        $this->start_controls_tabs( 'icon_colors' );
    }

    public function render_item($post) {
        $post = sanitize_post( $post, 'display' );
        $post_id = $post->ID;
        $post_title = $post->post_title;
        $location = get_field('property_location', $post_id, true)['address'] ?? '';
        $rooms = get_field('property_rooms', $post_id, true);
        $bedrooms = get_field('property_bedrooms', $post_id, true);
        $bathrooms = get_field('property_bath', $post_id, true);
        $area = get_field('property_living_area', $post_id, true);


        ?>
            <div class="hl-property-slider__item">

                <?php
                $attr = array(
                    'class' => "hl-property-slider__item-bg",
                );
                $thumbnail = get_the_post_thumbnail( $post_id, 'large', $attr );
                    echo $thumbnail;
                ?>
                <div class="hl-property-slider__item-inner">
                    <div class="hl-property-slider__item-block">
                        <a href="<?php echo get_post_permalink($post_id) ?>" class="hl-property-slider__item-title">
                            <?php echo $post_title; ?>
                        </a>
                        <?php if ($location) : ?>
                            <div class="hl-property-slider__item-location">
                                <i class="fa fa-map-marker-alt hl-property-slider__item-location-icon"></i>
                                <span class="hl-property-slider__item-location-text">
                                     <?php echo $location; ?>
                                </span>
                            </div>
                        <?php endif; ?>

                        <ul class="hl-property-slider__item-list">
                            <li class="hl-property-slider__item-list-item">
                                <i class="fa fa-fas fa-door-open hl-property-slider__item-list-item-icon"></i>
                                <div class="hl-property-slider__item-list-item-text" >
                                    <span><?php echo intval($rooms) ?> </span> <span>Rooms</span>
                                </div>
                            </li>

                            <li class="hl-property-slider__item-list-item">
                                <i class="fa fa-fas fa-bed hl-property-slider__item-list-item-icon"></i>
                                <div class="hl-property-slider__item-list-item-text" >
                                    <span><?php echo intval($bedrooms) ?> </span> <span>Bedrooms</span>
                                </div>
                            </li>

                            <li class="hl-property-slider__item-list-item">
                                <i class="fa fa-fas fa-bath hl-property-slider__item-list-item-icon"></i>
                                <div class="hl-property-slider__item-list-item-text" >
                                    <span><?php echo intval($bathrooms) ?> </span> <span>Bathrooms</span>
                                </div>
                            </li>

                            <li class="hl-property-slider__item-list-item">
                                <i class="fa fa-fas fa-square-root-alt hl-property-slider__item-list-item-icon"></i>
                                <div class="hl-property-slider__item-list-item-text" >
                                    <span><?php echo intval($area) ?> </span> <span>sq ft</span>
                                </div>
                            </li>
                        </ul>

                        <div class="hl-property-slider__item-bottom">
<!--                            <ul class="hl-property-slider__item-rating">-->
<!--                                <li><i class="fas fa-star"></i></li>-->
<!--                                <li><i class="fas fa-star"></i></li>-->
<!--                                <li><i class="fas fa-star"></i></li>-->
<!--                                <li><i class="fas fa-star-half-alt"></i></li>-->
<!--                                <li><i class="fas fa-star-half-alt"></i></li>-->
<!--                            </ul>-->

                            <div class="hl-property-slider__item-price">
                                <?php  echo builder_get_property_price($post_id); ?>
<!--                                <span class="hl-property-slider__item-text">-->
<!--                                    starts from-->
<!--                                </span>-->
<!--                                <div class="hl-property-slider__item-price-sum">-->
<!--                                    $21000-->
<!--                                </div>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

        $images = [
                'http://demo.lion-coders.com/html/sarchholm-real-estate-template/images/featured/featured_5.jpg',
                'http://demo.lion-coders.com/html/sarchholm-real-estate-template/images/featured/featured_5.jpg',
                'http://demo.lion-coders.com/html/sarchholm-real-estate-template/images/featured/featured_5.jpg',
                'http://demo.lion-coders.com/html/sarchholm-real-estate-template/images/featured/featured_5.jpg',
                'http://demo.lion-coders.com/html/sarchholm-real-estate-template/images/featured/featured_5.jpg',
        ]
        ?>
            <div class="hl-property-slider">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                    <?php


                    foreach ( $query->posts as $post ) {
                        echo '<div class="swiper-slide">';
                            $this->render_item($post);
                        echo '</div>';
                    }

//                        $gallery = [0, 1, 2, 3, 4];
//                        if ($gallery) {
//                            foreach ($gallery as $count) { ?>
<!--                                <div class="swiper-slide">-->
<!--                                    --><?php //$this->render_item($images[$count]); ?>
<!--                                </div>-->
<!--                            --><?php
//                            }
//                        }
                    ?>
                    </div>

                    <button class='hl-property-slider__nav_prev hl-property-slider__nav'>
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512.008 512.008" style="enable-background:new 0 0 512.008 512.008;" xml:space="preserve">
                            <path style="fill:#000;" d="M501.342,245.185H36.424L210.227,71.404c4.093-4.237,3.975-10.99-0.262-15.083 c-4.134-3.992-10.687-3.992-14.82,0l-192,192c-4.171,4.16-4.179,10.914-0.019,15.085c0.006,0.006,0.013,0.013,0.019,0.019l192,192 c4.093,4.237,10.845,4.354,15.083,0.262c4.237-4.093,4.354-10.845,0.262-15.083c-0.086-0.089-0.173-0.176-0.262-0.262 L36.424,266.519h464.917c5.891,0,10.667-4.776,10.667-10.667S507.233,245.185,501.342,245.185z"/>
                            <path d="M202.675,458.519c-2.831,0.005-5.548-1.115-7.552-3.115l-192-192c-4.164-4.165-4.164-10.917,0-15.083l192-192 c4.237-4.093,10.99-3.975,15.083,0.262c3.992,4.134,3.992,10.687,0,14.82L25.758,255.852L210.206,440.3 c4.171,4.16,4.179,10.914,0.019,15.085C208.224,457.39,205.508,458.518,202.675,458.519z"/>
                            <path d="M501.342,266.519H10.675c-5.891,0-10.667-4.776-10.667-10.667s4.776-10.667,10.667-10.667h490.667 c5.891,0,10.667,4.776,10.667,10.667S507.233,266.519,501.342,266.519z"/>
                        </svg>
                    </button>

                    <button class='hl-property-slider__nav_next hl-property-slider__nav'>
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
	                        <path style="fill:#000;" d="M511.189,259.954c1.649-3.989,0.731-8.579-2.325-11.627l-192-192 c-4.237-4.093-10.99-3.975-15.083,0.262c-3.992,4.134-3.992,10.687,0,14.82l173.803,173.803H10.667 C4.776,245.213,0,249.989,0,255.88c0,5.891,4.776,10.667,10.667,10.667h464.917L301.803,440.328 c-4.237,4.093-4.355,10.845-0.262,15.083c4.093,4.237,10.845,4.354,15.083,0.262c0.089-0.086,0.176-0.173,0.262-0.262l192-192 C509.872,262.42,510.655,261.246,511.189,259.954z"/>
                            <path d="M309.333,458.546c-5.891,0.011-10.675-4.757-10.686-10.648c-0.005-2.84,1.123-5.565,3.134-7.571L486.251,255.88 L301.781,71.432c-4.093-4.237-3.975-10.99,0.262-15.083c4.134-3.992,10.687-3.992,14.82,0l192,192 c4.164,4.165,4.164,10.917,0,15.083l-192,192C314.865,457.426,312.157,458.546,309.333,458.546z"/>
                            <path d="M501.333,266.546H10.667C4.776,266.546,0,261.771,0,255.88c0-5.891,4.776-10.667,10.667-10.667h490.667 c5.891,0,10.667,4.776,10.667,10.667C512,261.771,507.224,266.546,501.333,266.546z"/>
                        </svg>
                    </button>
                </div>
            </div>
        <?php
    }
}
