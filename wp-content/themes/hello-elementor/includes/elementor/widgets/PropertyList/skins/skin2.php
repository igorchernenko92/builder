<?php
namespace WPSight_Berlin\Elementor\Widgets\Property\Skins;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class Skin2 extends Skin_Base {

	protected function _register_controls_actions() {
		parent::_register_controls_actions();
    }

	public function get_id() {
		return 'skin2';
	}

	public function get_title() {
		return __( 'Skin 2', 'elementor-pro' );
	}

    protected function render_loop_header() {

    }

    protected function render_loop_footer() {

    }

    protected function render_post_header() {
        ?>
    <div <?php post_class( [ 'hl-listing-card hl-listing-card_skin-2 hl-listing-card_hover' ] ); ?>>
        <?php
    }

    protected function render_category() {
      ?>
        <ul class="hl-listing-card__tags hl-listing-card__tags_bottom">
          <li class="hl-listing-card__tag-wrap">
            <a href="#" class="hl-listing-card__tag hl-listing-card__tag_purple">Family Home</a>
          </li>
        </ul>
      <?php
    }

    protected function render_picture_preview() {
      ?>
        <div class="hl-listing-card__picture-preview">
          <a href="#" class="hl-listing-card__picture-preview-title">View Property</a>
          <span class="hl-listing-card__picture-preview-subtitle">Real Estatey</span>
        </div>
      <?php
    }

	protected function render_meta_data() {
		$settings = $this->get_instance_value( 'property_meta_data' );
		if ( empty( $settings ) ) {
			return;
		}
		$options = [
            'property_bedrooms' => __( 'Beds', 'elementor-pro' ),
            'property_bath' => __( 'Bath', 'elementor-pro' ),
            'property_garages' => __( 'Garages', 'elementor-pro' ),
            'property_rooms' => __( 'Rooms', 'elementor-pro' ),
            'property_living_area' => __( 'Living Area', 'elementor-pro' ),
            'property_terrace' => __( 'Terrace', 'elementor-pro' ),
        ];
		echo '<ul class="hl-listing-card__info">';
            foreach (  $settings as $item ) {
                $label = $item['label'];
                if (!$label) $label = $options[$item['property_meta_key']];

                $value = get_field($item['property_meta_key'], get_the_ID());
                ?>
            <li class="hl-listing-card__info-item">
                <i class="fa fa-<?php echo $item['selected_icon']['value']; ?> hl-listing-card__icon hl-listing-card__info-icon"></i>
                <span class="hl-listing-card__info-value"><?php echo $value; ?> <?php echo $label; ?></span>
            </li>

       <?php }
        echo '</ul>';
	}

    protected function render_agent() {
        ?>
        <div class="hl-listing-card__bottom mt-auto">
            <div class="hl-listing-card__bottom-inner">
                <a href="#" class="hl-listing-card__bottom-item">
                    <i class="fa fa-user hl-listing-card__icon hl-listing-card__bottom-item-icon"></i>
                    <span class="hl-listing-card__bottom-item-text">Janet Richmond</span>
                </a>

                <div class="hl-listing-card__bottom-item">
                    <i class="fa fa-calendar hl-listing-card__icon hl-listing-card__bottom-item-icon"></i>
                    <time class="hl-listing-card__bottom-item-text">2 months ago</time>
                </div>
            </div>
        </div>
        <?php
    }

    protected function render_post() {
        $this->render_post_header();
            $this->start_picture_wrapper();
                $this->render_tags();
                $this->render_category();
                $this->render_picture_preview();
                $this->render_thumb_carousel();
            $this->end_picture_wrapper();

            $this->start_content_wrapper();
                $this->render_title();
                $this->render_location();
                $this->render_meta_data();
                $this->render_price();
            $this->end_content_wrapper();

            $this->render_agent();
        $this->render_post_footer();
    }

}
