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
            <div class='hl-agents-3'>
        <?php
    }

    protected function render_content() {
        $id = $this->parent->get_the_id();

        $license = get_field('agent_license', $id);
        $tax = get_field('agent_tax_number', $id);
        $areas = get_field('agent_service_areas', $id);
        $spec = get_field('agent_specialties', $id);
        ?>

        <div class="hl-agent__content">
          <div class="hl-agent__content-top">
            <a class="hl-agent__title" href="#">
              Samuel Palmer
            </a>

            <span class="hl-agent__content-company">
              Company Agent at <a href="#">Modern House Real Estate</a>
            </span>
          </div>

          <ul class="hl-agent__table">
            <?php if ($license) { ?>
            <li class="hl-agent__table-row">
              <span class="hl-agent__table-label">
                Agent license:
              </span>

              <span class="hl-agent__table-value">
                <?php echo $license; ?>
              </span>
            </li>
            <?php } ?>

            <?php if ($tax) { ?>
            <li class="hl-agent__table-row">
              <span class="hl-agent__table-label">
                Tax Number:
              </span>

              <span class="hl-agent__table-value">
                <?php echo $tax; ?>
              </span>
            </li>
            <?php } ?>

            <?php if ($areas) { ?>
            <li class="hl-agent__table-row">
              <span class="hl-agent__table-label">
                Service Areas:
              </span>

              <span class="hl-agent__table-value">
                <?php echo $areas; ?>
              </span>
            </li>
            <?php } ?>

            <?php if ($spec) { ?>
            <li class="hl-agent__table-row">
              <span class="hl-agent__table-label">
                Specialties:
              </span>

              <span class="hl-agent__table-value">
                <?php echo $spec; ?>
              </span>
            </li>
            <?php } ?>
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
