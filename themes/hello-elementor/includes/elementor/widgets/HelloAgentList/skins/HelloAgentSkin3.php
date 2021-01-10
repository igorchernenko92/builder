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
            <div class='hl-agents-3 hl-agents-4'>
        <?php
    }

    protected function render_bottom() {
        ?>
          <div class="hl-agent__bottom">
            <ul class="hl-agent__socials">
              <li class="hl-agent__socials-item">
                <a href="#" class="hl-agent__socials-link">
                  <i class="fas fa-envelope"></i>
                </a>
              </li>
              <li class="hl-agent__socials-item">
                <a href="#" class="hl-agent__socials-link">
                  <i class="fas fa-envelope"></i>
                </a>
              </li>
              <li class="hl-agent__socials-item">
                <a href="#" class="hl-agent__socials-link">
                  <i class="fas fa-envelope"></i>
                </a>
              </li>
              <li class="hl-agent__socials-item">
                <a href="#" class="hl-agent__socials-link">
                  <i class="fas fa-envelope"></i>
                </a>
              </li>
            </ul>

            <ul class="hl-agent__socials">
              <li class="hl-agent__socials-item">
                <a href="#" class="hl-agent__socials-link">
                  <i class="fas fa-phone-alt"></i>
                </a>
              </li>
              <li class="hl-agent__socials-item">
                <a href="#" class="hl-agent__socials-link">
                  <i class="fas fa-envelope"></i>
                </a>
              </li>
            </ul>
          </div>
        <?php
    }

    protected function render_content() {
      echo "<div class='hl-agent__content'>";
        $this->render_title();
        $this->render_position();
        $this->render_description();
        $this->render_bottom();
      echo "</div>";
    }

    protected function render_wrap_main_start() {
      echo "<div class='hl-agents-main'>";
    }

    protected function render_wrap_main_end() {
      echo "</div>";
    }

    protected function render_post() {
        $this->render_post_header();
          $this->render_wrap_main_start();
            $this->render_avatar();
            $this->render_content();
          $this->render_wrap_main_end();
          $this->render_bottom();
        $this->render_post_footer();
    }

}
