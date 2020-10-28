<?php

namespace PropertyBuilder\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Core\Schemes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * All information about custom widgets can be found here
 * https://developers.elementor.com/creating-a-new-widget/
 */
class ListingDetails extends Widget_Base {

	public function get_name() {
		return 'PropertyBuilder_listing_details';
	}

	public function get_title() {
		return __( 'Hello details', 'wpcasa-berlin' );
	}

    public function get_icon() {
		return 'eicon-price-list';
	}

	public function get_categories() {
		return [ 'theme-elements-single', 'theme' ];
	}

	protected function _register_controls() {
        $this->start_controls_section(
            'section_layout',
            [
                'label' => __( 'Layout', 'wpcasa-berlin' ),
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __( 'Title', 'elementor' ),
                'type' => Controls_Manager::TEXTAREA,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => __( 'Enter your title', 'elementor' ),
                'default' => __( 'Add Your Heading Text Here', 'elementor' ),
            ]
        );

        $this->add_control(
            'header_size',
            [
                'label' => __( 'HTML Tag', 'elementor' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'div',
                    'span' => 'span',
                    'p' => 'p',
                ],
                'default' => 'h2',
            ]
        );

        $this->add_control(
            'value',
            [
                'label' => __( 'Value', 'elementor' ),
                'type' => Controls_Manager::TEXTAREA,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => __( 'Enter your value', 'elementor' ),
                'default' => __( 'Add Your Value Text Here', 'elementor' ),
            ]
        );

        $this->add_control(
            'value_header_size',
            [
                'label' => __( 'HTML Tag', 'elementor' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'div',
                    'span' => 'span',
                    'p' => 'p',
                ],
                'default' => 'h2',
            ]
        );

        $this->add_responsive_control(
            'custom_title_bottom_space',
            [
                'label' => __( 'Spacing', 'elementor' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-heading-title' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_title_style',
            [
                'label' => __( 'Title', 'elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'main_title_color',
            [
                'label' => __( 'Text Color', 'elementor' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-heading-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'scheme' => Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .elementor-heading-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'text_shadow',
                'selector' => '{{WRAPPER}} .elementor-heading-title',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'value_section_title_style',
            [
                'label' => __( 'Value', 'elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'value_main_title_color',
            [
                'label' => __( 'Text Color', 'elementor' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-heading-value' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'value_typography',
                'scheme' => Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .elementor-heading-value',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'value_text_shadow',
                'selector' => '{{WRAPPER}} .elementor-heading-value',
            ]
        );
    }

	protected function render() {
        $settings = $this->get_settings_for_display();

        if ( '' === $settings['title'] ) {
            return;
        }

        $this->add_render_attribute( 'title', 'class', 'elementor-heading-title' );
        $this->add_render_attribute( 'value', 'class', 'elementor-heading-value' );

        $this->add_inline_editing_attributes( 'title' );
        $this->add_inline_editing_attributes( 'value' );

        $title = $settings['title'];
        $value = $settings['value'];

        $title_html = sprintf( '<%1$s %2$s>%3$s</%1$s>', $settings['header_size'], $this->get_render_attribute_string( 'title' ), $title );
        $value_html = sprintf( '<%1$s %2$s>%3$s</%1$s>', $settings['value_header_size'], $this->get_render_attribute_string( 'value' ), $value );

        echo $title_html . $value_html;
    }

}
