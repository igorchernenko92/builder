<?php
namespace PropertyBuilder\Elementor\Widgets\Agents\Skins;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Skin_Base as Elementor_Skin_Base;
use Elementor\Widget_Base;
use ElementorPro\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

abstract class HelloAgentSkinBase extends Elementor_Skin_Base {

	/**
	 * @var string Save current permalink to avoid conflict with plugins the filters the permalink during the post render.
	 */
	protected $current_permalink;

	protected function _register_controls_actions() {
		add_action( 'elementor/element/property/section_layout/before_section_end', [ $this, 'register_controls' ] );
        add_action( 'elementor/element/property/section_query/after_section_end', [ $this, 'register_style_sections' ] );
    }

	public function register_style_sections( Widget_Base $widget ) {
		$this->parent = $widget;

		$this->register_design_controls();
	}

    public function get_id() {
        return 'skin-agents-base';
    }


    public function register_controls( Widget_Base $widget ) {
		$this->parent = $widget;

		$this->register_columns_controls();
		$this->register_post_count_control();
		$this->register_thumbnail_controls();
		$this->register_title_controls();
		$this->register_excerpt_controls();
		$this->register_link_controls();
        $this->register_read_more_controls();
		$this->add_meta_data_controls();
	}

	public function register_design_controls() {
//		$this->register_design_layout_controls();
		$this->register_design_image_controls();
		$this->register_design_content_controls();

	}

	protected function register_thumbnail_controls() {

		$this->add_responsive_control(
			'item_ratio',
			[
				'label' => __( 'Image Ratio', 'elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0.66,
				],
				'tablet_default' => [
					'size' => '',
				],
				'mobile_default' => [
					'size' => 0.5,
				],
				'range' => [
					'px' => [
						'min' => 0.1,
						'max' => 2,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-posts-container .elementor-post__thumbnail' => 'padding-bottom: calc( {{SIZE}} * 100% );',
//					'{{WRAPPER}}:after' => 'content: "{{SIZE}}";',
				],
			]
		);
	}

	protected function register_columns_controls() {
		$this->add_responsive_control(
			'columns',
			[
				'label' => __( 'Columns', 'elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options' => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				],
				'prefix_class' => 'elementor-grid%s-',
				'frontend_available' => true,
			]
		);
	}

	protected function register_post_count_control() {
		$this->add_control(
			'posts_per_page',
			[
				'label' => __( 'Posts Per Page', 'elementor-pro' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 6,
			]
		);
	}

	protected function register_title_controls() {
		$this->add_control(
			'show_title',
			[
				'label' => __( 'Title', 'elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'elementor-pro' ),
				'label_off' => __( 'Hide', 'elementor-pro' ),
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label' => __( 'Title HTML Tag', 'elementor-pro' ),
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
				'default' => 'h3',
				'condition' => [
					$this->get_control_id( 'show_title' ) => 'yes',
				],
			]
		);

	}

	protected function register_excerpt_controls() {
		$this->add_control(
			'show_excerpt',
			[
				'label' => __( 'Excerpt', 'elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'elementor-pro' ),
				'label_off' => __( 'Hide', 'elementor-pro' ),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'excerpt_length',
			[
				'label' => __( 'Excerpt Length', 'elementor-pro' ),
				'type' => Controls_Manager::NUMBER,
				/** This filter is documented in wp-includes/formatting.php */
				'default' => apply_filters( 'excerpt_length', 25 ),
				'condition' => [
					$this->get_control_id( 'show_excerpt' ) => 'yes',
				],
			]
		);
	}

	protected function register_link_controls() {
		$this->add_control(
			'open_new_tab',
			[
				'label' => __( 'Open in new window', 'elementor-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'elementor-pro' ),
				'label_off' => __( 'No', 'elementor-pro' ),
				'default' => 'no',
				'render_type' => 'none',
			]
		);
	}

    protected function register_read_more_controls() {
        $this->add_control(
            'show_read_more',
            [
                'label' => __( 'Read More', 'elementor-pro' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'elementor-pro' ),
                'label_off' => __( 'Hide', 'elementor-pro' ),
                'default' => 'no',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'read_more_text',
            [
                'label' => __( 'Read More Text', 'elementor-pro' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( '...', 'elementor-pro' ),
                'condition' => [
                    $this->get_control_id( 'show_read_more' ) => 'yes',
                ],
            ]
        );
    }

    public function add_meta_data_controls() {
        $repeater = new Repeater();

        $repeater->add_control(
            'property_meta_key',
            [
                'label' => __( 'Meta Data', 'elementor-pro' ),
                'label_block' => true,
                'type' => Controls_Manager::SELECT2,
//                'default' => [ 'date', 'comments' ],
                'multiple' => false,
                'options' => [
                    'property_rooms' => __( 'Rooms', 'elementor-pro' ),
                    'property_bedrooms' => __( 'Beds', 'elementor-pro' ),
                    'property_bath' => __( 'Bath', 'elementor-pro' ),
                    'property_garages' => __( 'Garages', 'elementor-pro' ),
                    'property_living_area' => __( 'Living Area', 'elementor-pro' ),
                    'property_terrace' => __( 'Terrace', 'elementor-pro' ),
                ],
            ]
        );

        $repeater->add_control(
            'label',
            [
                'label' => __( 'Label', 'elementor' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => __( '', 'elementor' ),
                'default' => __( '', 'elementor' ),
                'description' => __( 'Leave it empty if default', 'elementor' ),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

//        $repeater->add_group_control(
//            \Elementor\Group_Control_Typography::get_type(),
//            [
//                'name' => 'content_typography',
//                'label' => __( 'Text Typography', 'plugin-domain' ),
//                'scheme' => \Elementor\Scheme_Typography::TYPOGRAPHY_1,
//                'selector' => '{{WRAPPER}} .hl-listing-card__meta_info-label',
//            ]
//        );

        $repeater->add_control(
            'hr',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
            ]
        );


        $repeater->add_control(
            'icon_color',
            [
                'label' => __( 'Icon color', 'elementor-pro' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => \Elementor\Scheme_Color::get_type(),
                    'value' => \Elementor\Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-post__title, {{WRAPPER}} .elementor-post__title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $repeater->add_control(
            'selected_icon',
            [
                'label' => __( 'Icon', 'elementor' ),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-check',
                    'library' => 'fa-solid',
                ],
                'fa4compatibility' => 'icon',
            ]
        );

        $this->add_control(
            'property_meta_data',
            [
                'label' => '',
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'label' => __( '', 'elementor' ),
                        'property_meta_key' => 'property_rooms',
                        'selected_icon' => [
                            'value' => 'fas fa-door-open',
                            'library' => 'fa-solid',
                        ],
                    ],
                    [
                        'label' => __( '', 'elementor' ),
                        'property_meta_key' => 'property_bedrooms',
                        'selected_icon' => [
                            'value' => 'fas fa-bed',
                            'library' => 'fa-solid',
                        ],
                    ],
                    [
                        'label' => __( '', 'elementor' ),
                        'property_meta_key' => 'property_bath',
                        'selected_icon' => [
                            'value' => 'fas fa-bath',
                            'library' => 'fa-solid',
                        ],
                    ],

                    [
                        'label' => __( '', 'elementor' ),
                        'property_meta_key' => 'property_garages',
                        'selected_icon' => [
                            'value' => 'fas fa-car-alt',
                            'library' => 'fa-solid',
                        ],
                    ],
                    [
                        'label' => __( '', 'elementor' ),
                        'property_meta_key' => 'property_living_area',
                        'selected_icon' => [
                            'value' => 'fas fa-square-root-alt',
                            'library' => 'fa-solid',
                        ],
                    ],
                    [
                        'label' => __( '', 'elementor' ),
                        'property_meta_key' => 'property_terrace',
                        'selected_icon' => [
                            'value' => 'fas fa-house-damage',
                            'library' => 'fa-solid',
                        ],
                    ],
                ],
                'title_field' => '{{{ elementor.helpers.renderIcon( this, selected_icon, {}, "i", "panel" ) || \'<i class="{{ icon }}" aria-hidden="true"></i>\' }}} {{{ property_meta_key }}}',
            ]
        );
    }

	protected function get_optional_link_attributes_html() {
		$settings = $this->parent->get_settings();
		$new_tab_setting_key = $this->get_control_id( 'open_new_tab' );
		$optional_attributes_html = 'yes' === $settings[ $new_tab_setting_key ] ? 'target="_blank"' : '';

		return $optional_attributes_html;
	}
	/**
	 * Style Tab
	 */
//	protected function register_design_layout_controls() {
//		$this->start_controls_section(
//			'section_design_layout',
//			[
//				'label' => __( 'Layout', 'elementor-pro' ),
//				'tab' => Controls_Manager::TAB_STYLE,
//			]
//		);
//
//		$this->add_control(
//			'column_gap',
//			[
//				'label' => __( 'Columns Gap', 'elementor-pro' ),
//				'type' => Controls_Manager::SLIDER,
//				'default' => [
//					'size' => 30,
//				],
//				'range' => [
//					'px' => [
//						'min' => 0,
//						'max' => 100,
//					],
//				],
//				'selectors' => [
//					'{{WRAPPER}} .elementor-posts-container' => 'grid-column-gap: {{SIZE}}{{UNIT}}',
//					'.elementor-msie {{WRAPPER}} .elementor-post' => 'padding-right: calc( {{SIZE}}{{UNIT}}/2 ); padding-left: calc( {{SIZE}}{{UNIT}}/2 );',
//					'.elementor-msie {{WRAPPER}} .elementor-posts-container' => 'margin-left: calc( -{{SIZE}}{{UNIT}}/2 ); margin-right: calc( -{{SIZE}}{{UNIT}}/2 );',
//				],
//			]
//		);
//
//		$this->add_control(
//			'row_gap',
//			[
//				'label' => __( 'Rows Gap', 'elementor-pro' ),
//				'type' => Controls_Manager::SLIDER,
//				'default' => [
//					'size' => 35,
//				],
//				'range' => [
//					'px' => [
//						'min' => 0,
//						'max' => 100,
//					],
//				],
//				'frontend_available' => true,
//				'selectors' => [
//					'{{WRAPPER}} .elementor-posts-container' => 'grid-row-gap: {{SIZE}}{{UNIT}}',
//					'.elementor-msie {{WRAPPER}} .elementor-post' => 'padding-bottom: {{SIZE}}{{UNIT}};',
//				],
//			]
//		);
//
//		$this->add_control(
//			'alignment',
//			[
//				'label' => __( 'Alignment', 'elementor-pro' ),
//				'type' => Controls_Manager::CHOOSE,
//				'options' => [
//					'left' => [
//						'title' => __( 'Left', 'elementor-pro' ),
//						'icon' => 'eicon-text-align-left',
//					],
//					'center' => [
//						'title' => __( 'Center', 'elementor-pro' ),
//						'icon' => 'eicon-text-align-center',
//					],
//					'right' => [
//						'title' => __( 'Right', 'elementor-pro' ),
//						'icon' => 'eicon-text-align-right',
//					],
//				],
//				'prefix_class' => 'elementor-posts--align-',
//			]
//		);
//
//		$this->end_controls_section();
//	}

	protected function register_design_image_controls() {
		$this->start_controls_section(
			'section_design_image',
                [
				'label' => __( 'Image', 'elementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					$this->get_control_id( 'thumbnail!' ) => 'none',
				],
			]
		);

		$this->add_control(
			'img_border_radius',
			[
				'label' => __( 'Border Radius', 'elementor-pro' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-post__thumbnail' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					$this->get_control_id( 'thumbnail!' ) => 'none',
				],
			]
		);

		$this->add_control(
			'image_spacing',
			[
				'label' => __( 'Spacing', 'elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}}.elementor-posts--thumbnail-left .elementor-post__thumbnail__link' => 'margin-right: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}}.elementor-posts--thumbnail-right .elementor-post__thumbnail__link' => 'margin-left: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}}.elementor-posts--thumbnail-top .elementor-post__thumbnail__link' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
				'default' => [
					'size' => 20,
				],
				'condition' => [
					$this->get_control_id( 'thumbnail!' ) => 'none',
				],
			]
		);

		$this->start_controls_tabs( 'thumbnail_effects_tabs' );

		$this->start_controls_tab( 'normal',
			[
				'label' => __( 'Normal', 'elementor-pro' ),
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'thumbnail_filters',
				'selector' => '{{WRAPPER}} .elementor-post__thumbnail img',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'hover',
			[
				'label' => __( 'Hover', 'elementor-pro' ),
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'thumbnail_hover_filters',
				'selector' => '{{WRAPPER}} .elementor-post:hover .elementor-post__thumbnail img',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function register_design_content_controls() {
		$this->start_controls_section(
			'section_design_content',
			[
				'label' => __( 'Content', 'elementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'heading_title_style',
			[
				'label' => __( 'Title', 'elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'condition' => [
					$this->get_control_id( 'show_title' ) => 'yes',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Schemes\Color::get_type(),
					'value' => Schemes\Color::COLOR_2,
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-post__title, {{WRAPPER}} .elementor-post__title a' => 'color: {{VALUE}};',
				],
				'condition' => [
					$this->get_control_id( 'show_title' ) => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'scheme' => Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .elementor-post__title, {{WRAPPER}} .elementor-post__title a',
				'condition' => [
					$this->get_control_id( 'show_title' ) => 'yes',
				],
			]
		);

		$this->add_control(
			'title_spacing',
			[
				'label' => __( 'Spacing', 'elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-post__title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					$this->get_control_id( 'show_title' ) => 'yes',
				],
			]
		);

		$this->add_control(
			'heading_meta_style',
			[
				'label' => __( 'Meta', 'elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					$this->get_control_id( 'meta_data!' ) => [],
				],
			]
		);

		$this->add_control(
			'meta_color',
			[
				'label' => __( 'Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-post__meta-data' => 'color: {{VALUE}};',
				],
				'condition' => [
					$this->get_control_id( 'meta_data!' ) => [],
				],
			]
		);

		$this->add_control(
			'meta_separator_color',
			[
				'label' => __( 'Separator Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-post__meta-data span:before' => 'color: {{VALUE}};',
				],
				'condition' => [
					$this->get_control_id( 'meta_data!' ) => [],
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'meta_typography',
				'scheme' => Schemes\Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .elementor-post__meta-data',
				'condition' => [
					$this->get_control_id( 'meta_data!' ) => [],
				],
			]
		);

		$this->add_control(
			'meta_spacing',
			[
				'label' => __( 'Spacing', 'elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-post__meta-data' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					$this->get_control_id( 'meta_data!' ) => [],
				],
			]
		);

		$this->add_control(
			'heading_excerpt_style',
			[
				'label' => __( 'Excerpt', 'elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					$this->get_control_id( 'show_excerpt' ) => 'yes',
				],
			]
		);

		$this->add_control(
			'excerpt_color',
			[
				'label' => __( 'Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-post__excerpt p' => 'color: {{VALUE}};',
				],
				'condition' => [
					$this->get_control_id( 'show_excerpt' ) => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'excerpt_typography',
				'scheme' => Schemes\Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .elementor-post__excerpt p',
				'condition' => [
					$this->get_control_id( 'show_excerpt' ) => 'yes',
				],
			]
		);

		$this->add_control(
			'excerpt_spacing',
			[
				'label' => __( 'Spacing', 'elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-post__excerpt' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					$this->get_control_id( 'show_excerpt' ) => 'yes',
				],
			]
		);

		$this->add_control(
			'heading_readmore_style',
			[
				'label' => __( 'Read More', 'elementor-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					$this->get_control_id( 'show_read_more' ) => 'yes',
				],
			]
		);

		$this->add_control(
			'read_more_color',
			[
				'label' => __( 'Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Schemes\Color::get_type(),
					'value' => Schemes\Color::COLOR_4,
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-post__read-more' => 'color: {{VALUE}};',
				],
				'condition' => [
					$this->get_control_id( 'show_read_more' ) => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'read_more_typography',
				'selector' => '{{WRAPPER}} .elementor-post__read-more',
				'scheme' => Schemes\Typography::TYPOGRAPHY_4,
				'condition' => [
					$this->get_control_id( 'show_read_more' ) => 'yes',
				],
			]
		);

		$this->add_control(
			'read_more_spacing',
			[
				'label' => __( 'Spacing', 'elementor-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-post__text' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					$this->get_control_id( 'show_read_more' ) => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

//	public function filter_excerpt_length() {
//		return $this->get_instance_value( 'excerpt_length' );
//	}

	public function filter_excerpt_more( $more ) {
		return '';
	}

	public function get_container_class() {
		return 'elementor-hello-property--skin-' . $this->get_id();
	}

	protected function render_post_header() {
		?>
		<div <?php post_class( [ 'hl-agent' ] ); ?>>
		<?php
	}

	protected function render_post_footer() {
		?>
		</div>
		<?php
	}


	protected function render_loop_header() {
		$classes = [
			'elementor-posts-container',
			'elementor-posts',
			$this->get_container_class(),
		];

		$wp_query = $this->parent->get_query();

		// Use grid only if found posts.
		if ( $wp_query->found_posts ) {
			$classes[] = 'elementor-grid';
		}

		$this->parent->add_render_attribute( 'container', [
			'class' => $classes,
		] );

		?>
		<div <?php echo $this->parent->get_render_attribute_string( 'container' ); ?>>
		<?php
	}

	protected function render_loop_footer() {
		?>
		</div>
		<?php

		$parent_settings = $this->parent->get_settings();
		if ( '' === $parent_settings['pagination_type'] ) {
			return;
		}

		$page_limit = $this->parent->get_query()->max_num_pages;
		if ( '' !== $parent_settings['pagination_page_limit'] ) {
			$page_limit = min( $parent_settings['pagination_page_limit'], $page_limit );
		}

		if ( 2 > $page_limit ) {
			return;
		}

		$this->parent->add_render_attribute( 'pagination', 'class', 'elementor-pagination' );

		$has_numbers = in_array( $parent_settings['pagination_type'], [ 'numbers', 'numbers_and_prev_next' ] );
		$has_prev_next = in_array( $parent_settings['pagination_type'], [ 'prev_next', 'numbers_and_prev_next' ] );

		$links = [];

		if ( $has_numbers ) {
			$paginate_args = [
				'type' => 'array',
				'current' => $this->parent->get_current_page(),
				'total' => $page_limit,
				'prev_next' => false,
				'show_all' => 'yes' !== $parent_settings['pagination_numbers_shorten'],
				'before_page_number' => '<span class="elementor-screen-only">' . __( 'Page', 'elementor-pro' ) . '</span>',
			];

			if ( is_singular() && ! is_front_page() ) {
				global $wp_rewrite;
				if ( $wp_rewrite->using_permalinks() ) {
					$paginate_args['base'] = trailingslashit( get_permalink() ) . '%_%';
					$paginate_args['format'] = user_trailingslashit( '%#%', 'single_paged' );
				} else {
					$paginate_args['format'] = '?page=%#%';
				}
			}

			$links = paginate_links( $paginate_args );
		}

		if ( $has_prev_next ) {
			$prev_next = $this->parent->get_posts_nav_link( $page_limit );
			array_unshift( $links, $prev_next['prev'] );
			$links[] = $prev_next['next'];
		}

		?>
		<nav class="elementor-pagination" role="navigation" aria-label="<?php esc_attr_e( 'Pagination', 'elementor-pro' ); ?>">
			<?php echo implode( PHP_EOL, $links ); ?>
		</nav>
		<?php
	}

    protected function render_avatar() {
        $attr = array(
            'class' => "hl-agent__picture",
        );
        $thumbnail = get_the_post_thumbnail( get_the_ID(), 'large', $attr );

        ?>
        <a class="hl-agent__wrap-img" href="<?php echo $this->current_permalink; ?>">
            <?php echo $thumbnail; ?>
        </a>
      <?php
    }

    protected function render_title() {
        $name = get_the_title();
        ?>
          <a href="<?php echo  $this->current_permalink ?>" target="_blank" class="hl-agent__title"><?php echo $name ?></a>
        <?php
    }

    protected function render_position() {
        $spec = get_field('agent_specialties', get_the_ID());
        ?>
          <p class="hl-agent__position"><?php echo $spec ?></p>
        <?php
    }

    protected function render_description() {
	    $content = get_the_content();
        ?>
          <p class="hl-agent__description">
                <?php echo $content ?>
          </p>
        <?php
    }

    protected function render_bottom() {
        ?>
          <div class="hl-agent__bottom">
            <a href="<?php echo  $this->current_permalink ?>" target="_blank" class="hl-agent__bottom-link"><?php echo __('View profile', 'builder') ?></a>
          </div>
        <?php
    }

    public function render() {
        $this->parent->query_posts();

        $query = $this->parent->get_query();
        if ( ! $query->found_posts ) {
            return;
        }

        echo "<div class='hl-agents'>";
            while ( $query->have_posts() ) {
                $query->the_post();

                $this->current_permalink = get_permalink();
                $this->render_post();
            }
        echo "</div>";

        wp_reset_postdata();

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
          $this->render_title();
          $this->render_position();
          $this->render_description();
          $this->render_bottom();
      $this->render_post_footer();
	}

	public function render_amp() {

	}
}
