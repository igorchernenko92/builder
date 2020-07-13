<?php
namespace PropertyBuilder\Elementor\Widgets\Property\Skins;

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

abstract class Skin_Base extends Elementor_Skin_Base {

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
        return 'skin-base';
    }

    public function register_controls( Widget_Base $widget ) {
		$this->parent = $widget;

		$this->register_columns_controls();
		$this->register_post_count_control();
		$this->register_thumbnail_controls();
		$this->register_title_controls();
		$this->register_excerpt_controls();
        $this->register_price_controls();
        $this->register_agent_controls();
        $this->register_read_more_controls();
		$this->register_meta_data_controls();
        $this->register_link_controls();
	}

	public function register_design_controls() {
//		$this->register_design_layout_controls();
		$this->register_design_image_controls();
		$this->register_design_content_controls();

	}

	protected function register_thumbnail_controls() {
        $this->add_responsive_control(
            'hello_is_carousel',
            [
                'label' => __( 'Carousel', 'elementor-pro' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'On', 'elementor-pro' ),
                'label_off' => __( 'Off', 'elementor-pro' ),
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'carousel_show_dots',
            [
                'label' => __( 'Carousel Dots', 'elementor-pro' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'elementor-pro' ),
                'label_off' => __( 'Hide', 'elementor-pro' ),
                'default' => 'no',
                'condition' => [
                    $this->get_control_id( 'hello_is_carousel' ) => 'yes',
                ],
            ]
        );

        $this->add_control(
            'carousel_show_arrows',
            [
                'label' => __( 'Arrows', 'elementor-pro' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'elementor-pro' ),
                'label_off' => __( 'Hide', 'elementor-pro' ),
                'default' => 'no',
                'condition' => [
                    $this->get_control_id( 'hello_is_carousel' ) => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'hello_is_thumb_carousel',
            [
                'label' => __( 'Thumb Carousel', 'elementor-pro' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'On', 'elementor-pro' ),
                'label_off' => __( 'Off', 'elementor-pro' ),
                'separator' => 'before',
            ]
        );


//	    $this->add_responsive_control(
//			'item_ratio',
//			[
//				'label' => __( 'Image Ratio', 'elementor-pro' ),
//				'type' => Controls_Manager::SLIDER,
//				'default' => [
//					'size' => 0.66,
//				],
//				'tablet_default' => [
//					'size' => '',
//				],
//				'mobile_default' => [
//					'size' => 0.5,
//				],
//				'range' => [
//					'px' => [
//						'min' => 0.1,
//						'max' => 2,
//						'step' => 0.01,
//					],
//				],
//				'selectors' => [
//					'{{WRAPPER}} .elementor-posts-container .elementor-post__thumbnail' => 'padding-bottom: calc( {{SIZE}} * 100% );',
//				],
//			]
//		);
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

    protected function register_price_controls() {
        $this->add_control(
            'hello_show_price',
            [
                'label' => __( 'Price', 'elementor-pro' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'elementor-pro' ),
                'label_off' => __( 'Hide', 'elementor-pro' ),
                'default' => 'yes',
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

    protected function register_agent_controls() {
        $this->add_control(
            'show_agent',
            [
                'label' => __( 'Show Agent', 'elementor-pro' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'elementor-pro' ),
                'label_off' => __( 'Hide', 'elementor-pro' ),
                'default' => 'yes',
                'separator' => 'before',
            ]
        );
    }

    public function register_meta_data_controls() {
        $this->add_control(
            'show_meta_data',
            [
                'label' => __( 'Meta Data', 'elementor-pro' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __( 'Show', 'elementor-pro' ),
                'label_off' => __( 'Hide', 'elementor-pro' ),
                'default' => 'yes',
                'separator' => 'before',
            ]
        );

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

	protected function render_title() {
		if ( ! $this->get_instance_value( 'show_title' ) ) {
			return;
		}

		$optional_attributes_html = $this->get_optional_link_attributes_html();

		$tag = $this->get_instance_value( 'title_tag' );
		?>
		<<?php echo $tag; ?> class="hl-listing-card__title">
			<a href="<?php echo $this->current_permalink; ?>" <?php echo $optional_attributes_html; ?>>
				<?php the_title(); ?>
			</a>
		</<?php echo $tag; ?>>
		<?php
	}

	protected function render_excerpt() {
        if ( ! $this->get_instance_value( 'show_excerpt' ) ) {
            return;
        }
        $length = $this->get_instance_value( 'excerpt_length' );
        $read_more_text = $this->get_instance_value( 'read_more_text' );
	    ?>
		<p class="hl-listing-card__description">
            <?php echo wp_trim_words( get_the_excerpt(), $length, '' );; ?>
		</p>
		<?php


	}

	protected function render_read_more() {
		if ( ! $this->get_instance_value( 'show_read_more' ) ) {
			return;
		}

		$optional_attributes_html = $this->get_optional_link_attributes_html();

		?>
			<a class="elementor-post__read-more" href="<?php echo $this->current_permalink; ?>" <?php echo $optional_attributes_html; ?>>
				<?php echo $this->get_instance_value( 'read_more_text' ); ?>
			</a>
		<?php
	}

	protected function render_post_header() {
		?>
		<div <?php post_class( [ 'hl-listing-card hl-listing-card_skin-1 hl-listing-card_hover' ] ); ?>>
		<?php
	}

	protected function render_post_footer() {
		?>
		</div>
		<?php
	}

	protected function render_text_header() {
		?>
		<div class="elementor-post__text">
		<?php
	}

	  protected function render_price() {
        $terms = get_the_terms( get_the_ID(), 'status' );
	  ?>
      <div class="hl-listing-wrap-price">
      <?php
        if ( $this->get_instance_value( 'hello_show_price' ) ) { ?>
          <div class="hl-listing-price">
            <?php echo builder_get_property_price(); ?>
          </div>
       <?php }
            echo builder_get_property_status();
        ?>
      </div>
		<?php
	}

	protected function render_text_footer() {
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

    protected function start_picture_wrapper() {
        ?>
            <div class="hl-listing-card__picture">
        <?php
    }

    protected function end_picture_wrapper() {
        ?>
            </div>
        <?php
    }

    protected function render_tags() {
        $featured = get_the_terms( get_the_ID(), 'featured' );
        ?>
        <ul class="hl-listing-card__tags">
            <?php if ( $featured ) { ?>
                <li class="hl-listing-card__tag-wrap">
                    <a href="<?php echo get_term_link( $featured[0] ) ?>" class="hl-listing-card__tag hl-listing-card__tag_red"><?php echo $featured[0]->name ?></a>
                </li>
            <?php } ?>
        </ul>
      <?php
    }

    protected function render_location() {
        $terms = get_the_terms( get_the_ID(), 'location' );
        if ( !$terms ) return;

        $delimiter = ',';
        ?>

        <div class="hl-listing-card__location">
            <i class="fa fa-map-marker hl-listing-card__location-icon"></i>
            <?php foreach ( $terms as $key => $term ) {
                $array_keys = array_keys($terms);
                if (end($array_keys) == $key) {
                    $delimiter = '';
                }
                ?>
                <a class="hl-listing-card__location-text" href="<?php echo get_term_link( $term ) ?>"><?php echo $term->name . $delimiter ?></a>
           <?php } ?>
        </div>
      <?php
    }

    protected function render_post_image() {
        if ( $this->get_instance_value( 'hello_is_thumb_carousel' ) ) return;
//        TODO: figure out with get_optional_link_attributes_html()
        $attr = array(
            'class' => "hl-listing-card__picture-img img-responsive",
        );
        $thumbnail = get_the_post_thumbnail( get_the_ID(), 'large', $attr );

        ?>

        <a href="<?php echo $this->current_permalink; ?>" <?php echo $this->get_optional_link_attributes_html(); ?>>
            <div class="hl-listing-card__picture-wrap-img">
                <?php echo $thumbnail; ?>
            </div>
        </a>
   <?php }

    protected function render_img_placeholder() {
	    ?>
        <div class="hl-listing-card__picture-wrap-img">
          <img src="https://via.placeholder.com/358x232" class="hl-listing-card__picture-img img-responsive" alt="">
        </div>
      <?php
    }

    protected function render_thumb_carousel() {
         if ( !$this->get_instance_value( 'hello_is_thumb_carousel' ) ) return; ?>
        <div class="hl-listing-card__carousel hl-listing-card__carousel">
            <div class="swiper-container">
                <div class="swiper-wrapper">

                    <?php
                    $gallery = get_field('property_gallery', get_the_ID() );
                    if ($gallery) {
                        foreach ($gallery as $image) { ?>
                            <div class="swiper-slide hl-listing-card__carousel-item">
                                <a class="hl-listing-card__carousel-item-inner hl-listing-card__picture-wrap-img" href="<?php echo $this->current_permalink; ?>">
                                    <img
                                            src="<?php echo  $image['sizes']['medium_large']; ?>"
                                            class="hl-listing-card__picture-img hl-img-responsive"
                                            title="<?php echo $image['title']; ?>"
                                            alt="<?php echo $image['alt']; ?>"
                                    >
                                </a>
                            </div>
                        <?php }
                    }
                    ?>
                </div>

                <button class="hl-listing-card__carousel-nav_prev hl-listing-card__carousel-nav hl-listing-card__carousel-nav">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M15.41 16.59L10.83 12l4.58-4.59L14 6l-6 6 6 6 1.41-1.41z"></path>
                        <path fill="none" d="M0 0h24v24H0V0z"></path>
                    </svg>
                </button>

                <button class="hl-listing-card__carousel-nav_next hl-listing-card__carousel-nav hl-listing-card__carousel-nav">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"></path>
                        <path fill="none" d="M0 0h24v24H0V0z"></path>
                    </svg>
                </button>
            </div>
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
                <span class="hl-listing-card__info-value"><?php echo $value; ?></span>
            </li>

       <?php }
        echo '</ul>';
	}

	protected function render_author() {
		?>
		<span class="elementor-post-author">
			<?php the_author(); ?>
		</span>
		<?php
	}

    protected function render_agent() {
        if ( ! $this->get_instance_value( 'show_agent' ) ) return;
        if ( ! $agent = get_field('property_agent') ) return;

        $name = $agent[0]->post_title;
        $link = get_the_permalink($agent[0]->ID);
        $thumbnail = get_the_post_thumbnail( $agent[0]->ID, 'large', ['class' => "hl-listing-card__agent-img hl-img-responsive"] );

        ?>
        <div class="hl-listing-card__bottom mt-auto">
            <div class="hl-listing-card__bottom-inner">
                <a href="<?php echo $link ?>" class="hl-listing-card__agent">
                   <?php echo $thumbnail; ?>
                    <span class="hl-listing-card__agent-name"><?php echo $name ?></span>
                </a>
            </div>
        </div>
        <?php
    }

	protected function render_date() {
		?>
		<span class="elementor-post-date">
			<?php
			/** This filter is documented in wp-includes/general-template.php */
			echo apply_filters( 'the_date', get_the_date(), get_option( 'date_format' ), '', '' );
			?>
		</span>
		<?php
	}

    protected function start_content_wrapper() {
        echo '<div class="hl-listing-card__body">';
    }

    protected function end_content_wrapper() {
        echo '</div>';
    }

	protected function render_time() {
		?>
		<span class="elementor-post-time">
			<?php the_time(); ?>
		</span>
		<?php
	}

	protected function render_comments() {
		?>
		<span class="elementor-post-avatar">
			<?php comments_number(); ?>
		</span>
		<?php
	}

    public function render() {
        $this->parent->query_posts();
        $query = $this->parent->get_query();
        if ( ! $query->found_posts ) {
            echo 'Sorry, but no listing matches your search criteria.';
            return;
        }

        $isCarousel = $this->get_instance_value( 'hello_is_carousel' );

        if ( $isCarousel ) {
            $this->render_carousel($query);
        } else {
            $this->render_list($query);
        }



        wp_reset_postdata();

//        $this->render_loop_footer();
    }

    protected function render_carousel($query) {
	    ?>
        <div class='hl-listings-carousel'>
            <div class='swiper-container'>
                <div class='swiper-wrapper'>
                  <?php
                    while ( $query->have_posts() ) {
                        $query->the_post();
                        $this->current_permalink = get_permalink();
                            echo "<div class='swiper-slide'>";
                                $this->render_post();
                            echo "</div>";
                    } ?>

                </div>
            </div>


            <?php if ( $this->get_instance_value( 'carousel_show_dots' ) ) {  ?>
                <div class="hl-listings-carousel__pagination slider-pagination"></div>
            <?php } ?>



        <?php if ( $this->get_instance_value( 'carousel_show_arrows' ) ) {  ?>
              <button class='hl-listings-carousel__nav_prev hl-listings-carousel__nav'>
                <svg xmlns="http://www.w3.org/2000/svg" fill='currentColor' width="24" height="24" viewBox="0 0 24 24">
                  <path fill="#222" fill-rule="nonzero" d="M9 17.523L10.39 19 17 12l-6.61-7L9 6.477 14.215 12z"/>
                </svg>
              </button>

              <button class='hl-listings-carousel__nav_next hl-listings-carousel__nav'>
                <svg xmlns="http://www.w3.org/2000/svg" fill='currentColor' width="24" height="24" viewBox="0 0 24 24">
                  <path fill="#222" fill-rule="nonzero" d="M9 17.523L10.39 19 17 12l-6.61-7L9 6.477 14.215 12z"/>
                </svg>
              </button>
        <?php } ?>

        </div>
<?php
    }

    protected function render_list($query) {
        echo "<div class='hl-listings'>";
            while ( $query->have_posts() ) {
                $query->the_post();
                $this->current_permalink = get_permalink();
                $this->render_post();
            }
        echo "</div>";
    }

	protected function render_post() {
      $this->render_post_header();
          $this->start_picture_wrapper();
              $this->render_tags();
              $this->render_location();
              $this->render_post_image();
              $this->render_thumb_carousel();
          $this->end_picture_wrapper();

          $this->start_content_wrapper();
              $this->render_title();
              $this->render_price();
              $this->render_excerpt();
              $this->render_meta_data();
          $this->end_content_wrapper();

          $this->render_agent();
      $this->render_post_footer();
	}
}
