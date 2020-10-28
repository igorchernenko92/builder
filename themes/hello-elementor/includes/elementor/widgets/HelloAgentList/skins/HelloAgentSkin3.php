<?php
namespace PropertyBuilder\Elementor\Widgets\Agents\Skins;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Widget_Base;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class HelloAgentSkin3 extends HelloAgentSkinBase {

    public function __construct(Widget_Base $parent) {
        parent::__construct( $parent );
    }

	protected function _register_controls_actions() {
		parent::_register_controls_actions();
    }

	public function get_id() {
		return 'agent_skin3';
	}

	public function get_title() {
		return __( 'Skin 3', 'elementor-pro' );
	}

    protected function render_post_header() {
      ?>
          <div <?php post_class( [ 'hl-agent' ] ); ?>>
      <?php
  }

    public function render_agents_top() {
        ?>
            <div class='hl-agents-3 hl-agents-main'>
        <?php
    }

    protected function render_content() {
        $id = $this->parent->get_the_id();
        $options = $this->parent->get_meta();
        $agents_meta = $this->get_instance_value( 'agent_meta_data' );
        ?>

        <div class="hl-agent__content">
          <div class="hl-agent__content-top">
          <?php  $this->render_title();  ?>
          </div>

            <ul class="hl-agent__table">
                <?php  foreach ( $agents_meta as $item ) {
                    $label = $item['label'];
                    if (!$label)  $label = $options[$item['agent_meta_key']];

                    $value = get_field($item['agent_meta_key'], $this->parent->get_the_id());
                    if ( !$value ) continue;
                ?>
                  <li class="hl-agent__table-row">
                      <span class="hl-agent__table-label">
                            <?php echo esc_html($label); ?>:
                      </span>

                      <span class="hl-agent__table-value">
                          <?php echo esc_html($value); ?>
                      </span>
                  </li>
            <?php  }  ?>
            </ul>
        </div>

        <?php
    }


    protected function render_post() {
        $this->render_post_header();
        $this->render_avatar();
        $this->render_content();
        $this->render_post_footer();
    }

}
