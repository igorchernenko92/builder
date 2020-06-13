<?php
namespace WPSight_Berlin\Elementor\Widgets\Property\Skins;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class Skin3 extends Skin_Base {

	protected function _register_controls_actions() {
		parent::_register_controls_actions();

        wp_enqueue_script('hello-carousel-script', get_stylesheet_directory_uri() . '/includes/elementor/widgets/PropertyList/assets/js/skin2.js', '', '1', true);
        wp_enqueue_style( 'hello-carousel-style', get_stylesheet_directory_uri() . '/includes/elementor/widgets/PropertyList/assets/css/skin2.css', '', 1 );

    }

	public function get_id() {
		return 'skin3';
	}

	public function get_title() {
		return __( 'Skin 3', 'elementor-pro' );
	}

    protected function render_loop_header() {

    }

    protected function render_loop_footer() {

    }

    protected function render_post_header() {
        ?>
    <div <?php post_class( [ 'hl-listing-card hl-listing-card_skin-3 hl-listing-card_hover' ] ); ?>>
        <?php
    }

    protected function render_agent() {
        ?>
        <div class="hl-listing-card__bottom mt-auto">
            <div class="hl-listing-card__bottom-inner">
                <a href="#" class="hl-listing-card__agent">
                    <img
                        src="https://tokyowpresidence.b-cdn.net/wp-content/uploads/2014/05/agent3-1-19-120x120.jpg"
                        class="hl-listing-card__agent-img hl-img-responsive"
                        alt=""
                    >
                </a>
            </div>
        </div>
        <?php
    }

    protected function render_post() {
        $this->render_post_header();
          $this->start_picture_wrapper();
            $this->render_tags();
            $this->render_agent();
            $this->render_thumb_carousel();
          $this->end_picture_wrapper();

          $this->start_content_wrapper();
            $this->render_title();
            $this->render_price();
            $this->render_excerpt();
            $this->render_meta_data();
          $this->end_content_wrapper();
        $this->render_post_footer();
    }

    public function render() {
        $this->parent->query_posts();

        /** @var \WP_Query $query */
        $query = $this->parent->get_query();
        if ( ! $query->found_posts ) {
            return;
        }

        echo "<div class='hl-listings hl-listings_large'>";
          while ( $query->have_posts() ) {
            $query->the_post();
            $this->current_permalink = get_permalink();
            $this->render_post();
          }
        echo "</div>";

        wp_reset_postdata();
    }

}
