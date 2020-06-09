<?php
namespace WPSight_Berlin\Elementor\Widgets\Property\Skinss;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class Hello_Skin_Classic extends Skin_Base {

	protected function _register_controls_actions() {
		parent::_register_controls_actions();
		add_action( 'elementor/element/property/classic_section_design_layout/after_section_end', [ $this, 'register_additional_design_controls' ] );

        wp_enqueue_script('hello-carousel-script', get_stylesheet_directory_uri() . '/includes/elementor/widgets/PropertyList/assets/js/classic-script.js', '', '1', true);
        wp_enqueue_style( 'hello-carousel-style', get_stylesheet_directory_uri() . '/includes/elementor/widgets/PropertyList/assets/css/classic-main.css', '', 1 );

    }

	public function get_id() {
		return 'classic';
	}

	public function get_title() {
		return __( 'Classic', 'elementor-pro' );
	}

	public function register_additional_design_controls() {
		$this->start_controls_section(
			'section_design_box',
			[
				'label' => __( 'Box', 'elementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_control(
			'box_border_radius',
			[
				'label' => __( 'Border Radius', 'elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-post' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'box_padding',
			[
				'label' => __( 'Padding', 'elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-post' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'content_padding',
			[
				'label' => __( 'Content Padding', 'elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-post__text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
				'separator' => 'after',
			]
		);

		$this->start_controls_tabs( 'bg_effects_tabs' );

		$this->start_controls_tab( 'classic_style_normal',
			[
				'label' => __( 'Normal', 'elementor-pro' ),
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow',
				'selector' => '{{WRAPPER}} .elementor-post',
			]
		);

		$this->add_control(
			'box_bg_color',
			[
				'label' => __( 'Background Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-post' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'box_border_color',
			[
				'label' => __( 'Border Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-post' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'classic_style_hover',
			[
				'label' => __( 'Hover', 'elementor-pro' ),
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_shadow_hover',
				'selector' => '{{WRAPPER}} .elementor-post:hover',
			]
		);

		$this->add_control(
			'box_bg_color_hover',
			[
				'label' => __( 'Background Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-post:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'box_border_color_hover',
			[
				'label' => __( 'Border Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-post:hover' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}


    protected function render_loop_header() {

    }

    protected function render_loop_footer() {

    }

    public function render() {

        $this->parent->query_posts();

        /** @var \WP_Query $query */
        $query = $this->parent->get_query();
        if ( ! $query->found_posts ) {
            return;
        }

//        $this->render_loop_header();
        echo "<div class='hl-listings'>";
            while ( $query->have_posts() ) {
                $query->the_post();

                $data = [
                    'gallery' => get_field('property_gallery', get_the_ID() )
                ];

                $this->current_permalink = get_permalink();
                echo $this->get_partial('includes/elementor/widgets/PropertyList/skins/skin-classic-template.php', $data );
            }
        echo "</div>";

        wp_reset_postdata();

//        $this->render_loop_footer();

    }

    protected function render_post() {

	}



    public function get_partial($template_name, $data = []) {
        $template = locate_template($template_name, false);

        if (!$template) {
            return;
        }

        if ($data) {
            extract($data);
        }

        include($template);
    }
}
