<?php

namespace PropertyBuilder\Elementor\Widgets\HelloSearchFilter;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Text_Shadow; 
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use ElementorPro\Base\Base_Widget;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class HelloSearchFilter extends Base_Widget {
	public function __construct( $data = [], $args = null ) {
	    parent::__construct( $data, $args );

//		wp_enqueue_style( 'ut-datepicker-css', get_template_directory_uri() . '/includes/elementor/widgets/assets/css/datepicker.css', array(), date("Ymd"), false );
//		wp_enqueue_script( 'ut-datepicker-js', get_template_directory_uri() . '/includes/elementor/widgets/assets/js/datepicker.js', array(), date("Ymd"), false );


        wp_enqueue_script('hello-search-script', get_stylesheet_directory_uri() . '/includes/elementor/widgets/HelloSearchFilter/assets/js/base-script.js', '', '1', true);
        wp_enqueue_style('hello-search-style', get_stylesheet_directory_uri() . '/includes/elementor/widgets/HelloSearchFilter/assets/css/base-main.css', '', 1);

        wp_enqueue_script('hello-search-select2', get_stylesheet_directory_uri() . '/includes/elementor/widgets/HelloSearchFilter/assets/js/select2.min.js', '', '1', true);
        wp_enqueue_style('hello-search-select2-style', get_stylesheet_directory_uri() . '/includes/elementor/widgets/HelloSearchFilter/assets/css/select2.min.css', '', 1);

        wp_enqueue_script( 'hello-search-multiple',  get_stylesheet_directory_uri() . '/includes/elementor/widgets/HelloSearchFilter/assets/js/multiple-select.min.js', '', '1', true );
        wp_enqueue_style( 'hello-search-multiple-style', get_stylesheet_directory_uri() . '/includes/elementor/widgets/HelloSearchFilter/assets/css/multiple-select.min.css');


	}

    public function get_script_depends() {
        return ['hello-search-select2', 'hello-search-script', 'hello-search-multiple' ];
    }

    public function get_style_depends() {
        return ['hello-search-style', 'hello-search-select2-style', 'hello-search-multiple-style'];
    }

    public function get_keywords() {
        return [ 'filter', 'search' ];
    }

	public function get_name() {
		return 'search_filter';
	}

	public function get_title() {
		return __( 'Hello Search Filter', 'elementor' );
	}

	public function get_icon() {
		return 'eicon-search-results';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	protected function _register_skins() {
//		$this->add_skin( new Skins\Skin1( $this ) );
//		$this->add_skin( new Skins\Skin2( $this ) );
	}

	protected function _register_controls() {
        parent::_register_controls();

		$this->start_controls_section(
			'section_search_filter',
			[
				'label' => __( 'Search Filter', 'elementor' ),
			]
		);

        $result_pages = [ '' => _x( 'Select Page', 'elementor' ) ];
        $pages = get_pages();
        foreach( $pages as $page ) {
            $result_pages[ $page->ID ] = $page->post_title;
        }

        $this->add_control(
            'hello_search_result_page',
            [
                'label'   => _x( 'Select Result Page', 'Select Result Page', 'elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => '',
                'options' => $result_pages,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'search_button',
            [
                'label' => __('Search button', 'builder'),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
            ]
        );


        $repeater->add_control(
            'button_text_color',
            [
                'label' => __( 'Text Color', 'elementor' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .hello_search_button' => 'fill: {{VALUE}}; color: {{VALUE}};',
                ],
                'condition' => [
                    'search_button' => 'yes',
                ],
            ]
        );

        $repeater->add_control(
            'background_color',
            [
                'label' => __( 'Background Color', 'elementor' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_4,
                ],
                'selectors' => [
                    '{{WRAPPER}} .hello_search_button' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'search_button' => 'yes',
                ],
            ]
        );

        $repeater->add_control(
            'hover_color',
            [
                'label' => __( 'Hover Text Color', 'elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .hello_search_button:hover, {{WRAPPER}} .hello_search_button:focus' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'search_button' => 'yes',
                ],
            ]
        );

        $repeater->add_control(
            'button_background_hover_color',
            [
                'label' => __( 'Hover Background Color', 'elementor' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .hello_search_button:hover, {{WRAPPER}} .hello_search_button:focus' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'search_button' => 'yes',
                ],
            ]
        );

        $repeater->add_control(
            'hover_animation',
            [
                'label' => __( 'Hover Animation', 'elementor' ),
                'type' => Controls_Manager::HOVER_ANIMATION,
                'condition' => [
                    'search_button' => 'yes',
                ],
            ]
        );



        $repeater->add_control(
            'type_field',
            [
                'label'   => _x( 'Type field', 'Type Field', 'elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'search',
                'options' => builder_get_options_array(),
                'condition' => [
                    'search_button' => '',
                ],
            ]
        );

        $repeater->add_control(
            'type_view',
            [
                'label'   => _x( 'Type View', 'Type View', 'elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'input',
                'options' => [
                    'input' 	        => _x( 'Input', 'Type View', 'elementor' ),
                    'select' 	        => _x( 'Select', 'Type View', 'elementor' ),
                    'multiple-select' 	=> _x( 'Multiple Select', 'Type View', 'elementor' ),
                    'checkbox' 	        => _x( 'Checkbox', 'Type View', 'elementor' ),
                ],
                'condition' => [
                    'search_button' => '',
                    'type_field!' => 'property_price'
                ],
            ]
        );

        $repeater->add_control(
            'label',
            [
                'label' 		=> __( 'Label', 'elementor' ),
                'type' 			=> Controls_Manager::TEXT,
                'placeholder' 	=> __( 'Enter your label', 'elementor' ),
            ]
        );

        $repeater->add_control(
            'placeholder',
            [
                'label' 		=> __( 'Placeholder', 'elementor' ),
                'type' 			=> Controls_Manager::TEXT,
                'placeholder' 	=> __( 'Enter your placeholder', 'elementor' ),
                'condition' => [
                    'search_button' => '',
                ],
            ]
        );

        $repeater->add_control(
            'price_label',
            [
                'label' 		=> __( 'Label 2', 'elementor' ),
                'type' 			=> Controls_Manager::TEXT,
                'placeholder' 	=> __( 'Enter your label', 'elementor' ),
                'condition' => [
                    'type_field' => 'property_price'
                ],
            ]
        );

        $repeater->add_control(
            'price_placeholder',
            [
                'label' 		=> __( 'Placeholder 2', 'elementor' ),
                'type' 			=> Controls_Manager::TEXT,
                'placeholder' 	=> __( 'Enter your placeholder', 'elementor' ),
                'condition' => [
                    'type_field' => 'property_price'
                ],
            ]
        );

        $repeater->add_control(
            'width_field',
            [
                'label'   => _x( 'Column Width', 'elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => '20',
                'options' => [
                    '10' 	=> _x( '10%', 'Type Field', 'elementor' ),
                    '11' 	=> _x( '11%', 'Type Field', 'elementor' ),
                    '12' 	=> _x( '12%', 'Type Field', 'elementor' ),
                    '14' 	=> _x( '14%', 'Type Field', 'elementor' ),
                    '15' 	=> _x( '15%', 'Type Field', 'elementor' ),
                    '16' 	=> _x( '16%', 'Type Field', 'elementor' ),
                    '20' 	=> _x( '20%', 'Type Field', 'elementor' ),
                    '25' 	=> _x( '25%', 'Type Field', 'elementor' ),
                    '30' 	=> _x( '30%', 'Type Field', 'elementor' ),
                    '33' 	=> _x( '33%', 'Type Field', 'elementor' ),
                    '35' 	=> _x( '35%', 'Type Field', 'elementor' ),
                    '40' 	=> _x( '40%', 'Type Field', 'elementor' ),
                    '45' 	=> _x( '45%', 'Type Field', 'elementor' ),
                    '50' 	=> _x( '50%', 'Type Field', 'elementor' ),
                    '55' 	=> _x( '55%', 'Type Field', 'elementor' ),
                    '60' 	=> _x( '60%', 'Type Field', 'elementor' ),
                    '65' 	=> _x( '65%', 'Type Field', 'elementor' ),
                    '66' 	=> _x( '66%', 'Type Field', 'elementor' ),
                    '70' 	=> _x( '70%', 'Type Field', 'elementor' ),
                    '75' 	=> _x( '75%', 'Type Field', 'elementor' ),
                    '80' 	=> _x( '80%', 'Type Field', 'elementor' ),
                    '83' 	=> _x( '83%', 'Type Field', 'elementor' ),
                    '90' 	=> _x( '90%', 'Type Field', 'elementor' ),
                    '100' 	=> _x( '100%', 'Type Field', 'elementor' ),
                ],
            ]
        );

        $this->add_control(
            'hello_search_items',
            [
                'label' 	 	=> __( 'Fields', 'elementor' ),
                'type' 		 	=> Controls_Manager::REPEATER,
                'show_label' 	=> true,
                'fields' 		=> $repeater->get_controls(),
                'default' 		=> [
                    [
                        'type_field' => 'keyword',
                        'type_view' => 'input',
                        'width_field' => '30',
                        'placeholder' => 'Search',
                    ],
                    [
                        'type_field' => 'property_rooms',
                        'type_view' => 'select',
                        'placeholder' => 'Rooms',
                    ],
                    [
                        'type_field' => 'property_price',
                        'type_view' => 'select',
                        'width_field' => '30',
                        'placeholder' => 'min',
                        'price_placeholder' => 'max',
                    ],
                    [
                        'search_button' => 'yes',
                        'background_color' => '#4054B2',
                        'button_text_color' => '#fff',
                        'hover_animation' => 'grow',
                    ],
                ],
                'title_field' => '{{{ type_field }}}',
            ]
        );

		$this->end_controls_section();
	}

    protected function render_search_form() {
        $settings = $this->get_settings_for_display();

        $unit = $settings['_padding']['unit'];
        $padding_top = $settings['_padding']['top'] . $unit;
        $padding_right = $settings['_padding']['right'] . $unit;
        $padding_bottom = $settings['_padding']['bottom'] . $unit;
        $padding_left = $settings['_padding']['left'] . $unit;

        $paddings_string = 'padding-top:' . $padding_top .  ';' . ' padding-right:' . $padding_right .  ';' . ' padding-bottom:' . $padding_bottom .  ';' . ' padding-left:' . $padding_left .  ';';

        $items =  $settings[ 'hello_search_items' ];
        $search_result_page =  $settings[ 'hello_search_result_page' ];

        $mapping_array = builder_get_options_array();

        $value_data = [
            'property_bedrooms' => ['' => 'Bedrooms', '1' => 1, '2' => 2, '3' => 3],
            'property_rooms' => ['' => 'Rooms','1' => 1, '2' => 2, '3' => 3, '4' => 4, '10' => 10],
            'property_bath' => ['' => 'Bath','1' => 1, '2' => 2, '3' => 3],
            'property_garages' => ['' => 'Garages','1' => 1, '2' => 2, '3' => 3],
        ];

        ?>
        <div id="home-search" class="site-section home-section">
            <div class="container">
                <form id="search_filter_form" method="get" action="<?php echo get_page_link( $search_result_page ); ?>" class="wpsight-listings-search">

                    <div class="listings-search-default" style="<?php echo $paddings_string ?>">
                        <input type="hidden" id="page_id" name="page_id" value="<?php echo $search_result_page ?>">
                        <?php
                        foreach ( $items as $field ) :
                            if ( !$field['placeholder'] && isset($mapping_array[$field['type_field']]) ) {
                                $field['placeholder'] = $mapping_array[$field['type_field']];
                            }

                            if ( $field['type_field'] == 'property_price' ) {
                                $field['type_view'] = 'price';
                            }

                            // search button
                            $search_button =  $field['search_button'];
                            if ( $search_button ) {
                                $field['type_view'] = ''; // need to prevent other fields to show when button
                                $label = __( 'Search', 'builder' );

                                if ($field['label']) {
                                    $label = $field['label'];
                                }
                                ?>
                                <div class="wrap-field listings-search-field-submit" style="width:<?php echo $field['width_field']; ?>%;">
                                    <div class="wrap-input">
                                        <input type="submit" value="<?php echo $label; ?>" class="btn btn-primary btn-block hello_search_button elementor-animation-<?php echo $field['hover_animation'] ?>">
                                    </div>
                                </div>
                            <?php } // end search button

                            if ( 'select' == $field['type_view'] ) {


                             if ( !isset($value_data[$field['type_field']]) ) {
                                   continue;
                             }

                                ?>
                                <div class="wrap-field" style="width:<?php echo $field['width_field']; ?>%;">
                                    <label class="wrap-input">
                                        <?php if ($field['label']) { ?>
                                          <span class="listings-search-field-label">
                                              <?php echo $field['label']; ?>
                                          </span>
                                        <?php } ?>

                                      <div class="wrap-select">
                                          <select class="select-2 form-control" data-placeholder="<?php echo $field['placeholder']; ?>" name="<?php echo $field['type_field']; ?>">
                                            <?php

                                            foreach ( $value_data[$field['type_field']] as $index => $option ) { ?>
                                                <option value="<?php echo $index; ?>"><?php echo $option; ?></option>
                                            <?php  }  ?>
                                          </select>
                                        </div>
                                    </label>
                                </div>
                            <?php } ?>

                            <?php if ( 'multiple-select' == $field['type_view'] ) {
                            $options = '';
                            if ( in_array( $field['type_field'], get_object_taxonomies('property') ) ) {
                                $terms = get_terms(
                                    array(
                                        'taxonomy' => $field['type_field'],
                                        'hide_empty' => false,
                                    )
                                );
                                $options = $this->get_terms_hierarchical($terms);
                            } else {
                                foreach ( $value_data[$field['type_field']] as $index => $option ) {
                                    $options .= '<option value="' . $index . '">' . $option . '</option>';
                                }
                            }

                            ?>

                            <div class="wrap-field" style="width:<?php echo $field['width_field']; ?>%;">
                                <label class="wrap-input">
                                    <?php if ($field['label']) { ?>
                                        <span class="listings-search-field-label">
                                            <?php echo $field['label']; ?>
                                        </span>
                                    <?php } ?>
                                    <span class="wrap-select">
                                      <select class="select-multiselect form-control" data-placeholder="<?php echo $field['placeholder']; ?>" multiple="multiple" name="<?php echo $field['type_field']; ?>[]">
                                        <?php echo $options; ?>
                                      </select>
                                    </span>
                                </label>
                            </div>
                        <?php } ?>

                            <?php  if ( 'input' == $field['type_view'] ) {?>
                            <div class="wrap-field" style="width:<?php echo $field['width_field']; ?>%;">
                                <label class="wrap-input">
                                    <?php if ($field['label']) { ?>
                                        <span class="listings-search-field-label">
                                              <?php echo $field['label']; ?>
                                          </span>
                                    <?php } ?>
                                    <input class="text form-control" name="<?php echo $field['type_field']; ?>" type="text" value="" placeholder="<?php echo $field['placeholder']; ?>">
                                </label>
                            </div>
                        <?php } ?>

                            <?php  if ( 'price' == $field['type_view'] ) { ?>
                            <div class="wrap-field" style="width:<?php echo $field['width_field']; ?>%;">
                                <div class="wrap-field-price">
                                    <label class="wrap-input">
                                        <?php if ($field['label']) { ?>
                                            <span class="listings-search-field-label">
                                                    <?php echo $field['label']; ?>
                                                </span>
                                        <?php } ?>
                                        <input class="text form-control" name="property_price[min]" type="number" value="" placeholder="<?php echo $field['placeholder']; ?>">
                                    </label>
                                </div>
                                <div class="wrap-field-price">
                                    <label class="wrap-input">
                                        <?php if ($field['price_label']) { ?>
                                            <span class="listings-search-field-label">
                                              <?php echo $field['price_label']; ?>
                                          </span>
                                        <?php } ?>
                                        <input class="text form-control" name="property_price[max]" type="number" value="" placeholder="<?php echo $field['price_placeholder']; ?>">
                                    </label>
                                </div>
                            </div>
                        <?php } ?>

                        <?php endforeach; ?>

                    </div>
                </form>
            </div>
        </div>
        <?php
    }

    public function render() {
        $this->render_search_form();
    }

    /**
     *	get terms for multiselect
     *
     *	@uses	get_terms_hierarchical()
     *	@return	array of terms
     *
     *	@since 1.0.0
     */
    protected function get_terms_hierarchical($terms, $output = '', $parent_id = 0, $level = 0) {
        $outputTemplate = '<option class="%CLASS%" value="%SLUG%">%NAME%</option>';

        foreach ($terms as $term) {
            if ($parent_id == $term->parent) {
                $itemOutput = str_replace('%SLUG%', $term->slug, $outputTemplate);
                $itemOutput = str_replace('%CLASS%', 'listing-search-padding-' . $level, $itemOutput);
                $itemOutput = str_replace('%NAME%', $term->name, $itemOutput);

                $output .= $itemOutput;
                $output = $this->get_terms_hierarchical($terms, $output, $term->term_id, $level + 1);
            }
        }
        return $output;
    }
}
