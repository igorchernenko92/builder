<?php
namespace WPSight_Berlin\Elementor\Widgets\Property\Skins;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class Hello_Skin_Classic extends Skin_Base {

	protected function _register_controls_actions() {
		parent::_register_controls_actions();
		add_action( 'elementor/element/property/section_layout/before_section_end', [ $this, 'add_meta_data_controls' ] );

        wp_enqueue_script('hello-carousel-script', get_stylesheet_directory_uri() . '/includes/elementor/widgets/PropertyList/assets/js/list-script.js', '', '1', true);
        wp_enqueue_style( 'hello-carousel-style', get_stylesheet_directory_uri() . '/includes/elementor/widgets/PropertyList/assets/css/list-main.css', '', 1 );

    }

	public function get_id() {
		return 'list';
	}

	public function get_title() {
		return __( 'List', 'elementor-pro' );
	}

//	public function add_meta_data_controls() {
//        $repeater = new Repeater();
//
//        $repeater->add_control(
//            'meta_data',
//            [
//                'label' => __( 'Meta Data', 'elementor-pro' ),
//                'label_block' => true,
//                'type' => Controls_Manager::SELECT2,
////                'default' => [ 'date', 'comments' ],
//                'multiple' => false,
//                'options' => [
//                    'property_bedrooms' => __( 'Beds', 'elementor-pro' ),
//                    'property_bath' => __( 'Bath', 'elementor-pro' ),
//                    'property_garages' => __( 'Garages', 'elementor-pro' ),
//                    'property_rooms' => __( 'Rooms', 'elementor-pro' ),
//                    'property_living_area' => __( 'Living Area', 'elementor-pro' ),
//                    'property_terrace' => __( 'Terrace', 'elementor-pro' ),
//                ],
//            ]
//        );
//
//        $repeater->add_control(
//            'text',
//            [
//                'label' => __( 'Label', 'elementor' ),
//                'type' => Controls_Manager::TEXT,
//                'label_block' => true,
//                'placeholder' => __( '', 'elementor' ),
//                'default' => __( 'List Item', 'elementor' ),
//                'description' => __( 'Leave it empty if default', 'elementor' ),
//                'dynamic' => [
//                    'active' => true,
//                ],
//            ]
//        );
//
//        $repeater->add_group_control(
//            \Elementor\Group_Control_Typography::get_type(),
//            [
//                'name' => 'content_typography',
//                'label' => __( 'Text Typography', 'plugin-domain' ),
//                'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
//                'selector' => '{{WRAPPER}} .text',
//            ]
//        );
//
//        $repeater->add_control(
//            'hr',
//            [
//                'type' => \Elementor\Controls_Manager::DIVIDER,
//            ]
//        );
//
//
//        $repeater->add_control(
//            'icon_color',
//            [
//                'label' => __( 'Icon color', 'elementor-pro' ),
//                'type' => Controls_Manager::COLOR,
//                'scheme' => [
//                    'type' => \Elementor\Scheme_Color::get_type(),
//                    'value' => \Elementor\Scheme_Color::COLOR_1,
//                ],
//                'selectors' => [
//                    '{{WRAPPER}} .elementor-post__title, {{WRAPPER}} .elementor-post__title a' => 'color: {{VALUE}};',
//                ],
//            ]
//        );
//
//        $repeater->add_control(
//            'selected_icon',
//            [
//                'label' => __( 'Icon', 'elementor' ),
//                'type' => Controls_Manager::ICONS,
//                'default' => [
//                    'value' => 'fas fa-check',
//                    'library' => 'fa-solid',
//                ],
//                'fa4compatibility' => 'icon',
//            ]
//        );
//
//        $this->add_control(
//            'property_meta_list',
//            [
//                'label' => '',
//                'type' => Controls_Manager::REPEATER,
//                'fields' => $repeater->get_controls(),
//                'default' => [
//                    [
//                        'text' => __( 'List Item #1', 'elementor' ),
//                        'selected_icon' => [
//                            'value' => 'fas fa-check',
//                            'library' => 'fa-solid',
//                        ],
//                    ],
//                    [
//                        'text' => __( 'List Item #2', 'elementor' ),
//                        'selected_icon' => [
//                            'value' => 'fas fa-times',
//                            'library' => 'fa-solid',
//                        ],
//                    ],
//                    [
//                        'text' => __( 'List Item #3', 'elementor' ),
//                        'selected_icon' => [
//                            'value' => 'fas fa-dot-circle',
//                            'library' => 'fa-solid',
//                        ],
//                    ],
//                ],
//                'title_field' => '{{{ elementor.helpers.renderIcon( this, selected_icon, {}, "i", "panel" ) || \'<i class="{{ icon }}" aria-hidden="true"></i>\' }}} {{{ text }}}',
//            ]
//        );
//	}


    protected function render_loop_header() {

    }

    protected function render_loop_footer() {

    }

}
