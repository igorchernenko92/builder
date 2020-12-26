<?php
namespace PropertyBuilder\Elementor\Widgets\Property\Skins;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class Skin4 extends Skin_Base {

	protected function _register_controls_actions() {
		parent::_register_controls_actions();
    }

	public function get_id() {
		return 'skin4';
	}

	public function get_title() {
		return __( 'Skin 4', 'elementor-pro' );
	}

    protected function render_loop_header() {

    }

    protected function render_loop_footer() {

    }

    protected function render_post_header() {
        ?>
    <div <?php post_class( [ 'hl-listing-card hl-listing-card_skin-4 hl-listing-card_hover' ] ); ?>>
        <?php
    }

    protected function render_picture_preview() {
      ?>
        <div class="hl-listing-card__picture-preview">
          <a href="#" class="hl-listing-card__picture-preview-title">View Property</a>
          <span class="hl-listing-card__picture-preview-subtitle">Real Estate</span>
        </div>
      <?php
    }

	protected function render_meta_data() {
		if ( ! $this->get_instance_value( 'show_meta_data' ) ) {
            return;
        }

		$settings = $this->get_instance_value( 'property_meta_data' );
		if ( empty( $settings ) ) {
			return;
		}
		$options = $this->parent->get_type_list_meta();
		echo '<ul class="hl-listing-card__info">';
            foreach ( $settings as $item ) {
                $value = get_field($item['property_meta_key'], get_the_ID());
                if ( !$value ) continue;

                $label = $item['label'];
                if (!$label) $label = $options[$item['property_meta_key']];
                ?>
            <li class="hl-listing-card__info-item">
                <i class="fa fa-<?php echo $item['selected_icon']['value']; ?> hl-listing-card__icon hl-listing-card__info-icon"></i>
                <span class="hl-listing-card__info-value"><?php echo $value; ?> <?php echo $label; ?></span>
            </li>

       <?php }
        echo '</ul>';
	}

	protected function render_time() {
	  ?>
      <div class="hl-listing-card__bottom-item hl-listing-card__bottom-item_time">
          <i class="fa fa-calendar hl-listing-card__icon hl-listing-card__bottom-item-icon"></i>
          <time class="hl-listing-card__bottom-item-text"><?php echo  human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ).' '.__( 'ago' ); ?></time>
      </div>
	  <?php
	}

    protected function render_agent() { ?>
        <div class="hl-listing-card__bottom mt-auto">
            <div class="hl-listing-card__bottom-inner">
                <?php if ( $this->get_instance_value( 'show_agent' ) && $agent = get_field('property_agent') ) {
                    $name = $agent[0]->post_title;
                    $link = get_the_permalink($agent[0]->ID);
                    $thumbnail = get_the_post_thumbnail( $agent[0]->ID, 'large', ['class' => "hl-listing-card__agent-img hl-img-responsive"] )
                ?>
                    <a href="<?php echo $link ?>" class="hl-listing-card__agent hl-listing-card__bottom-item">
                        <?php echo $thumbnail; ?>
                        <span class="hl-listing-card__agent-name"><?php echo $name ?></span>
                    </a>
                <?php } ?>
                <?php $this->render_time(); ?>
            </div>
        </div>
        <?php
    }

    protected function render_tags() {
        $featured = get_the_terms( get_the_ID(), 'featured' );
        $status = get_the_terms( get_the_ID(), 'status' );

        if ( $featured ) { ?>
              <div class="hl-listing-card__wrap-tag hl-listing-card__wrap-tag_left">
                  <a href="<?php echo get_term_link( $featured[0] ) ?>" class="hl-listing-card__tag hl-listing-card__tag_green"><?php echo $featured[0]->name ?></a>
              </div>
          <?php
        }

        if ( $status ) { ?>
            <div class="hl-listing-card__wrap-tag hl-listing-card__wrap-tag_right">
                <a href="<?php echo get_term_link( $status[0] ) ?>" class="hl-listing-card__tag hl-listing-card__tag_blue"><?php echo $status[0]->name ?></a>
            </div>
          <?php
        }
    }

    protected function render_price_status() {
	    ?>
        <div class="hl-listing-wrap-price">
          <?php
            $this->render_price();
          ?>
        </div>
      <?php
	  }

    protected function render_wrap_title() {
      ?>
          <div class="hl-listing-card__wrap-title">
              <?php
                  $this->render_price_status();
                  $this->render_title();
              ?>
          </div>
      <?php
    }

    protected function render_post() {
        $this->render_post_header();
            $this->start_picture_wrapper();
                $this->render_tags();
                $this->render_wrap_title();
                $this->render_picture_preview();
                $this->render_post_image();
                $this->render_thumb_carousel();
            $this->end_picture_wrapper();

            $this->start_content_wrapper();
                $this->render_location();
                $this->render_meta_data();
            $this->end_content_wrapper();

            $this->render_agent();
        $this->render_post_footer();
    }

}
