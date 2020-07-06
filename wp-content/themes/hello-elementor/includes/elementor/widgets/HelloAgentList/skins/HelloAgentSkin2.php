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


class HelloAgentSkin2 extends HelloAgentSkinBase {

    public function __construct(Widget_Base $parent) {
        parent::__construct( $parent );
    }

	protected function _register_controls_actions() {
		parent::_register_controls_actions();
    }

	public function get_id() {
		return 'agent_skin2';
	}

	public function get_title() {
		return __( 'Skin 2', 'elementor-pro' );
	}

    protected function render_post_header() {
        ?>
            <div <?php post_class( [ 'hl-agent-2' ] ); ?>>
        <?php
    }

    protected function render_table() {
        ?>
            <ul class="hl-agent__table">
                <li class="hl-agent__table-row">
                    <span class="hl-agent__table-label">
                        Office
                    </span>

                    <span class="hl-agent__table-value">
                        +375 29 000 00 00
                    </span>
                </li>

                <li class="hl-agent__table-row">
                    <span class="hl-agent__table-label">
                        Office
                    </span>

                    <span class="hl-agent__table-value">
                        +375 29 000 00 00
                    </span>
                </li>

                <li class="hl-agent__table-row">
                    <span class="hl-agent__table-label">
                        Office
                    </span>

                    <span class="hl-agent__table-value">
                        +375 29 000 00 00
                    </span>
                </li>

                <li class="hl-agent__table-row">
                    <span class="hl-agent__table-label">
                        Office
                    </span>

                    <span class="hl-agent__table-value">
                        <a href="mailto:some@mail.ru">some@mail.ru</a>
                    </span>
                </li>

                <li class="hl-agent__table-row">
                    <span class="hl-agent__table-label">
                        Office
                    </span>

                    <span class="hl-agent__table-value">
                        <a href="mailto:some@mail.ru">some@mail.ru</a>
                    </span>
                </li>
            </ul>
        <?php
    }

    public function render_agents_top() {
        ?>
          <div class='hl-agents-2'>
        <?php
    }

    protected function render_post() {
        $spec = get_field('agent_specialties', get_the_ID());
        $areas = get_field('agent_service_areas', get_the_ID());
        $email = get_field('agent_email', get_the_ID());
        $position = get_field('agent_position', get_the_ID());
        $com_name = get_field('agent_company_name', get_the_ID());
        $license = get_field('agent_license', get_the_ID());
        $tax = get_field('agent_tax_number', get_the_ID());
        $tel = get_field('agent_mobile', get_the_ID());
        $office_number = get_field('agent_office_number', get_the_ID());
        $language = get_field('agent_language', get_the_ID());
        $website = get_field('agent_website', get_the_ID());

        $this->render_post_header();
        $this->render_avatar();
        $this->render_table();
        $this->render_post_footer();
    }

}
