<?php

namespace PropertyBuilder\Elementor\Widgets\HelloMap;

use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

use Elementor\Widget_Base;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

include_once ( 'DCE_Helper.php');


/**
 * Elementor ACF-GoogleMaps
 *
 * Elementor widget for Dynamic Content for Elementor
 *
 */
class HelloGoogleMap extends Widget_Base {
    private $type_list;

    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
        $this->type_list = get_option('hello_search_array');

        wp_register_script( 'hello-google-script', 'https://maps.googleapis.com/maps/api/js?v=3&key=AIzaSyCyzLPGLgRv_SOdc3anLhP8olpjrBocu6I', [], '1.0.0', true );
        wp_register_script( 'hello-markerclusterer-js', 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js', array(), date("Ymd"), false );
        wp_register_script( 'hello-map-script', get_stylesheet_directory_uri() . '/includes/elementor/widgets/HelloMap/assets/js/google-maps.js', [ 'elementor-frontend' ], '1.0.0', true );
    }

    public function get_script_depends() {
        return ['hello-google-script', 'hello-markerclusterer-js', 'hello-map-script'];
    }

    public function get_name() {
        return 'hello-google-map';
    }

    static public function is_enabled() {
        return true;
    }

    public function get_title() {
        return __('Hello Google Map', 'builder');
    }

    public function get_type_list() {
        return $this->type_list;
    }

    public function get_description() {
        return __('Build a map using data from a Google Maps ACF', 'builder');
    }

    public function get_icon() {
        return 'icon-dyn-map';
    }


    public function get_style_depends() {
        return ['dce-acfGooglemap'];
    }
    static public function get_position() {
        return 4;
    }

    public function get_plugin_depends() {
        return array('acf');
    }

    protected function _register_controls() {
        $taxonomies = DCE_Helper::get_taxonomies();

        $this->start_controls_section(
            'section_map', [
                'label' => __('ACF Google Maps', 'builder'),
            ]
        );


        $this->add_control(
            'acf_mapfield', [
                'label' => __('ACF Map', 'builder'),
                'type' => Controls_Manager::SELECT,
                'options' => DCE_Helper::get_acf_fields('google_map'),
                'default' => 'property_location',
                'frontend_available' => true,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'auto_zoom', [
                'label' => __('Force automatic Zoom', 'builder'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'frontend_available' => true,
                'condition' => [
                    'acf_mapfield!' => '0',
                ]
            ]
        );

        $this->add_control(
            'zoom', [
                'label' => __('Zoom Level', 'builder'),
                'type' => Controls_Manager::SLIDER,
                'separator' => 'before',
                'default' => [
                    'size' => 10,
                ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 20,
                    ],
                ],
                /*'condition' => [
                    'auto_zoom' => '',
                ],*/

                //'frontend_available' => true,
            ]
        );

        $this->add_responsive_control(
            'height', [
                'label' => __('Height', 'builder'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                    'size' => 500,
                ],
                'range' => [
                    'px' => [
                        'min' => 200,
                        'max' => 1440,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} #el-wgt-map-{{ID}}' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'prevent_scroll', [
                'label' => __('Scroll', 'builder'),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'separator' => 'before',
                'label_on' => __('Yes', 'builder'),
                'label_off' => __('No', 'builder'),
                'render_type' => 'template',
                'frontend_available' => true,
            ]
        );
        $this->add_control(
            'enable_infoWindow', [
                'label' => __('Enable Info Window', 'builder'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'separator' => 'before',
                'render_type' => 'template',
                'frontend_available' => true,
            ]
        );


        $this->add_control(
            'view', [
                'label' => __('View', 'builder'),
                'type' => Controls_Manager::HIDDEN,
                'default' => 'traditional',
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_mapInfoWIndow', [
                'label' => __('Info Window', 'builder'),
                'condition' => [
                    'enable_infoWindow' => 'yes'
                ]
            ]
        );

        // --------- IMAGE
        $this->add_control(
            'infoWindow_heading_style_image',
            [
                'label' => __('Image', 'builder'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'infowindow_query_show_image', [
                'label' => __('Show Image', 'builder'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'frontend_available' => true,
            ]
        );


//        $this->add_responsive_control(
//            'infowindow_query_image_size', [
//                'label' => __('Info window image size', 'builder'),
//                'type' => Controls_Manager::SLIDER,
//                'default' => [
//                    'size' => 300,
//                ],
//                'range' => [
//                    'px' => [
//                        'min' => 40,
//                        'max' => 1440,
//                    ],
//                ],
//                'selectors' => [
//                    '{{WRAPPER}} .gm-style .gm-style-iw-c .dce-iw-image' => 'width: {{SIZE}}px;',
//                ],
//
//                'condition' => [
//                    'infowindow_query_show_image' => 'yes',
//                ],
//
//                //'frontend_available' => true,
//            ]
//        );
        // --------- TITLE
        $this->add_control(
            'infoWindow_heading_style_title',
            [
                'label' => __('Title', 'builder'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'infowindow_query_show_title', [
                'label' => __('Show Title', 'builder'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'frontend_available' => true,
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name' => 'infowindow_query_typography_title',
                'label' => __('Title Typography', 'builder'),
                'selector' => '{{WRAPPER}} .gm-style .gm-style-iw-c .dce-iw-title',
                'separator' => 'before',
                'fields_options' => [
                    'typography' => ['default' => 'yes'],
                    'font_size' => ['default' => ['size' => 16]],
//                    'font_weight' => ['default' => 600],
                ],
                'condition' => [
                    'infowindow_query_show_title!' => '',
                ],
            ]
        );
        $this->add_control(
            'infowindow_query_color_title', [
                'label' => __('Title Color', 'builder'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .gm-style .gm-style-iw-c .dce-iw-title' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'infowindow_query_show_title!' => '',
                ],
            ]
        );


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
                'options' => $this->get_type_list(),
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

        $this->end_controls_tab();

        $this->end_controls_tabs();


        // --------- PANEL
        $this->add_control(
            'infoWindow_heading_style_panel',
            [
                'label' => __('Panel', 'builder'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                ],
            ]
        );
//        $this->add_group_control(
//            Group_Control_Border::get_type(), [
//                'name' => 'infoWindow_border',
//                'label' => __('Border', 'builder'),
//                'selector' => '{{WRAPPER}} .gm-style .gm-style-iw-c, {{WRAPPER}} .gm-style .gm-style-iw-t::after',
//            ]
//        );
//        $this->add_control(
//            'infoWindow_padding', [
//                'label' => __('Padding panel', 'builder'),
//                'type' => Controls_Manager::DIMENSIONS,
//                'size_units' => ['px', 'em'],
//                'default' => [
//                    'unit' => 'px',
//                ],
//                'selectors' => [
//                    '{{WRAPPER}} .gm-style .gm-style-iw-c' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
//                ],
//            ]
//        );

//        $this->add_control(
//            'infoWindow_border_radius', [
//                'label' => __('Border Radius', 'builder'),
//                'type' => Controls_Manager::DIMENSIONS,
//                'size_units' => ['px', '%'],
//                'selectors' => [
//                    '{{WRAPPER}} .gm-style .gm-style-iw-c' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
//                ],
//
//            ]
//        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(), [
                'name' => 'infoWindow_box_shadow',
                'selector' => '{{WRAPPER}} .gm-style .gm-style-iw-c',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_mapMarker', [
                'label' => __('Marker', 'builder'),
            ]
        );
        $this->add_control(
            'acf_markerfield', [
                'label' => __('Map (ACF)', 'builder'),
                'type' => Controls_Manager::SELECT,
                'label_block' => true,
                'options' => DCE_Helper::get_acf_fields('image'),
                'default' => '0',
                'condition' => [
                ],
            ]
        );
        $this->add_control(
            'imageMarker', [
                'label' => __('Marker Image', 'builder'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => '', //'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png',
                ],
                'frontend_available' => true,
                'condition' => [
                    'acf_markerfield' => '0',
                ],
            ]
        );
        $this->add_control(
            'marker_width', [
                'label' => __('Force Width', 'builder'),
                'type' => Controls_Manager::NUMBER,
                'frontend_available' => 'true',
            ]
        );
        $this->add_control(
            'marker_height', [
                'label' => __('Force Height', 'builder'),
                'type' => Controls_Manager::NUMBER,
                'frontend_available' => 'true',
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'section_mapStyles', [
                'label' => __('Styles', 'builder'),
            ]
        );
        $this->add_control(
            'map_type', [
                'label' => __('Map Type', 'builder'),
                'type' => Controls_Manager::SELECT,
                'default' => 'roadmap',
                'options' => [
                    'roadmap' => __('Roadmap', 'builder'),
                    'satellite' => __('Satellite', 'builder'),
                    'hybrid' => __('Hybrid', 'builder'),
                    'terrain' => __('Terrain', 'builder'),
                ],
                'frontend_available' => true,
            ]
        );
        // --------------------------------- [ ACF Type of style ]
        $this->add_control(
            'style_select', [
                'label' => __('Style', 'builder'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => __('None', 'builder'),
                    'custom' => __('Custom', 'builder'),
                    'prestyle' => __('Snazzy Style', 'builder'),
                ],
                'frontend_available' => true,
                'condition' => [
                    'map_type' => 'roadmap',
                ],
            ]
        );
        $this->add_control(
            'snazzy_select', [
                'label' => __('Snazzy Style', 'builder'),
                'type' => Controls_Manager::SELECT,
                'options' => $this->snazzymaps(),
                'frontend_available' => true,
                'condition' => [
                    'map_type' => 'roadmap',
                    'style_select' => 'prestyle',
                ],
            ]
        );
        $this->add_control(
            'style_map', [
                'label' => __('Copy Snazzy Json Style Map', 'builder'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => __('', 'builder'),
                'description' => 'To better manage the graphic styles of the map go to: <a href="https://snazzymaps.com/" target="_blank">snazzymaps.com</a>',
                'frontend_available' => true,
                'condition' => [
                    'map_type' => 'roadmap',
                    'style_select' => 'custom',
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'section_mapControls', [
                'label' => __('Controls', 'builder'),
            ]
        );
        $this->add_control(
            'maptypecontrol', [
                'label' => __('Map Type Control', 'builder'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'streetviewcontrol', [
                'label' => __('Street View Control', 'builder'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'frontend_available' => true,
            ]
        );
        $this->add_control(
            'zoomcontrol', [
                'label' => __('Zoom Control', 'builder'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'frontend_available' => true,
            ]
        );
        $this->add_control(
            'fullscreenControl', [
                'label' => __('Full Screen Control', 'builder'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'frontend_available' => true,
            ]
        );
        $this->add_control(
            'markerclustererControl', [
                'label' => __('Marker Clusterer', 'builder'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'frontend_available' => true,
            ]
        );
        $this->end_controls_section();

//        $this->start_controls_section(
//            'section_cpt', [
//                'label' => __('Multilocations Query', 'builder'),
//                'condition' => [
//                    'acf_mapfield!' => '0',
//                ]
//            ]
//        );


        // --------------------------------- [ Custom Post Type ]

//        $this->add_control(
//            'taxonomy', [
//                'label' => __('Taxonomy', 'builder'),
//                'type' => Controls_Manager::SELECT,
//                'options' => ['' => __('None', 'builder')] + get_taxonomies(array('public' => true)),
//
//            ]
//        );
//        $this->add_control(
//            'category', [
//                'label' => __('Terms ID', 'builder'),
//                'description' => __('Comma separated list of category ids', 'builder'),
//                'type' => Controls_Manager::HIDDEN,
//
//            ]
//        );
//
//        foreach ($taxonomies as $tkey => $atax) {
//            if ($tkey) {
//                $this->add_control(
//                    'terms_' . $tkey, [
//                        'label' => __('Terms', 'builder'),
//                        'type' => Controls_Manager::SELECT2,
//                        'options' => ['' => __('All', 'builder')] + DCE_Helper::get_taxonomy_terms($tkey),
//                        'description' => __('Filter results by selected taxonomy term', 'builder'),
//                        'multiple' => true,
//                        'label_block' => true,
//                        'condition' => [
//                            'taxonomy' => $tkey,
//                        ],
//                        'render_type' => 'template',
//                    ]
//                );
//            }
//        }

        $this->end_controls_section();

//        $this->start_controls_section(
//            'section_dce_settings', [
//                'label' => __('Dynamic content', 'builder'),
//                'tab' => Controls_Manager::TAB_SETTINGS,
//            ]
//        );
//        $this->add_control(
//            'data_source',
//            [
//                'label' => __('Source', 'builder'),
//                'description' => __('Select the data source', 'builder'),
//                'type' => Controls_Manager::SWITCHER,
//                'default' => 'yes',
//                'label_on' => __('Same', 'builder'),
//                'label_off' => __('Other', 'builder'),
//                'return_value' => 'yes',
//            ]
//        );
//
//        $this->add_control(
//            'other_post_source',
//            [
//                'label' => __('Select from other source post', 'builder'),
//                'type' => 'ooo_query',
//                'placeholder' => __('Post Title', 'builder'),
//                'label_block' => true,
//                'query_type' => 'posts',
//                'condition' => [
//                    'data_source' => '',
//                ],
//            ]
//        );
//        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display(null, true);
        if (empty($settings))
            return;

        // ------------------------------------------
        $id_page = DCE_Helper::get_the_id();

        $zoom = $settings['zoom']['size'];
        if (!$zoom) {
            $zoom = 10;
        }

        //$imageMarker = get_field($settings['acf_markerfield'], $id_page);
        $imageMarker = '';

        $is_repeater = false;
        $imageMarkerType = DCE_Helper::get_acf_field_post($settings['acf_markerfield']);

        if(isset($imageMarkerType->post_parent)){
            $field_settings = DCE_Helper::get_acf_field_settings($imageMarkerType->post_parent);

            if(isset($field_settings['type']) && $field_settings['type'] == 'repeater'){
                $is_repeater = true;
            }
        }



            $imageMarker = DCE_Helper::get_acf_field_value($settings['acf_markerfield'], $id_page);

            if (is_string($imageMarker)) {
                if (is_numeric($marker_img)) {
                    $imageSrc = wp_get_attachment_image_src($imageMarker, 'full');
                    $imageMarker = $imageSrc[0];
                    //echo 'uuu: '.$imageSrc;
                } else {
                    $imageSrc = $imageMarker;
                }
                //echo 'url: '.$imageMarker;
            } else if (is_numeric($imageMarker)) {
                //echo 'id: '.$imageMarker;
                $imageSrc = wp_get_attachment_image_src($imageMarker, 'full');
                $imageMarker = $imageSrc[0];
            } else if (is_array($imageMarker)) {
                //echo 'array: '.$imageMarker;
                $imageSrc = wp_get_attachment_image_src($imageMarker['ID'], 'full');
                $imageMarker = $imageSrc[0];
            }

        if ($imageMarker == '') {
            $imageMarker = $settings['imageMarker']['url'];
        }



            $args = array(
                'post_type' => 'property',
                'posts_per_page' => -1,
                'post_status' => 'publish',
            );

            $check_get = array_keys( get_option('hello_search_array') );
            $getParam = (array)$_GET;
            $property_tax = array_keys( get_object_taxonomies( 'property', 'objects' ) );

            foreach ( $getParam as $meta_key => $meta_value ) {
                if ( in_array( $meta_key, $check_get ) && !empty( $meta_value ) ) {
                    $type = '';
                    $compare = '';

                    if ( in_array($meta_key, $property_tax) ) { // if any of tax in the list add tax to query
                        $args['tax_query'][] = [
                            [
                                'taxonomy' => $meta_key,
                                'field'    => 'slug',
                                'terms'    => $meta_value
                            ]
                        ];
                        continue;
                    }

                    if ( 'property_year_built' == $meta_key ) {
                        $type = 'DATE';
                        $compare = '==';
                        $meta_value = preg_replace( '/\s+/', '', $meta_value ); // date('Ymd'),
                    }

                    if ( 'property_price' == $meta_key ) {
                        $type = 'numeric';
                        $compare = 'BETWEEN';

                        if ( empty( $meta_value['min'] )  ) {
                            $meta_value['min'] = 0;
                        }

                        if ( empty( $meta_value['max'] ) ) {
                            $meta_value['max'] = 999999999;
                        }

                        $meta_value = array( $meta_value['min'], $meta_value['max'] );
                    }

                    $args['meta_query'][] = array(
                        array(
                            'key'   => $meta_key,
                            'value' => $meta_value,
                            'type'    => $type,
                            'compare' => $compare
                        )
                    );
                }
            }

            if ( is_tax() ) {
                $args['tax_query'][] = [
                    [
                        'taxonomy' => get_query_var( 'taxonomy' ),
                        'field'    => 'slug',
                        'terms'    => get_query_var( 'term' )
                    ]
                ];
            }

                if(isset($args) && count($args) ) {
                    $p_query = new \WP_Query($args);
                    //echo $p_query->found_posts;
                    $counter = 0;
                    //var_dump($args);
                    if ($p_query->have_posts()) {
                        global $wp_query;
                        $original_queried_object = get_queried_object();
                        $original_queried_object_id = get_queried_object_id();
                        ?>
                        <script>
                            var address_list_<?php echo $this->get_id(); ?> = [<?php
                                while ($p_query->have_posts()) {
                                    $p_query->the_post();
                                    $wp_query->queried_object_id = $id_page = get_the_ID();
                                    $wp_query->queried_object = get_post();

                                    //$map_field = get_field($settings['acf_mapfield'], get_the_ID());
                                    $map_field = DCE_Helper::get_acf_field_value($settings['acf_mapfield'], get_the_ID());

                                    if (!empty($map_field)) {
                                        //var_dump($map_field);
                                        $indirizzo = $map_field['address'];
                                        $lat = $map_field['lat'];
                                        $lng = $map_field['lng'];

                                        // link to post ---------
                                        $postlink = get_the_permalink($id_page);

                                        // infowindow ---------
                                            $postTitle = '';

                                            $postImage = '';

                                            $map_card_content = '<div class="map-card__content">';

                                              if ($settings['infowindow_query_show_title']) {
                                                $map_card_content .= '<a href="' . $postlink . '" class="map-card__title">' . get_the_title($id_page) . '</a>';
                                              }

                                              $map_card_content .= '<div class="map-card__row">';
                                                $map_card_content .= '<div class="map-card__price">';

                                                $map_card_content .= builder_get_property_price();
                                                $map_card_content .= '</div>';

                                                $map_card_content .= builder_get_property_status();
                                              $map_card_content .= '</div>';

                                                $property_mata = $settings[ 'property_meta_data' ];
                                                $map_card_content .= '<div class="map-card__bottom">';
                                                    $map_card_content .= '<ul class="map-card__details">';
                                                        foreach ( $property_mata as $item ) {
                                                            $value = get_field($item['property_meta_key'], get_the_ID());
                                                            if ( !$value ) continue;

                                                            $map_card_content .= '<li class="map-card__details-item">';
                                                                 $map_card_content .= '<i class="fa fa-' . $item['selected_icon']['value'] .' map-card__details-item-icon"></i>';
                                                                 $map_card_content .= '<span class="map-card__details-item-value">' . $value . '</span>';
                                                            $map_card_content .= '</li>';
                                                        }

                                                    $map_card_content .= '</ul>';
                                                $map_card_content .= '</div>';
                                            $map_card_content .= '</div>';


                                            if ($settings['infowindow_query_show_image']) {
                                                if (!empty(get_the_post_thumbnail($id_page))) {
                                                    $postImage = '<a href="' . $postlink . '"><div class="map-card__wrap-img">' . get_the_post_thumbnail($id_page) . '</div></a>';
                                                }
                                            }
//                                            if ($settings['infowindow_query_show_readmore']) {
//                                                $postReadMore = '<div class="dce-iw-readmore-wrapper"><a href="' . $postlink . '" class="dce-iw-readmore-btn">' . __($settings['infowindow_query_readmore_text'], 'builder' . '_texts') . '</a></div>';
//                                            }


                                            $postInfowindow = $postImage . '<div class="dce-iw-textzone">' . $map_card_content . '</div>';

                                        // marker ---------
                                        $marker_img = DCE_Helper::get_acf_field_value($settings['acf_markerfield'], $id_page);
                                        if (is_string($marker_img)) {
                                            if (is_numeric($marker_img)) {
                                                $imageSrc = wp_get_attachment_image_src($marker_img, 'full');
                                                $marker_img = $imageSrc[0];
                                                //echo 'uuu: '.$imageSrc;
                                            } else {
                                                //echo 'url: '.$marker_img;
                                                $imageSrc = $marker_img;
                                            }
                                        } else if (is_numeric($marker_img)) {
                                            //echo 'id: '.$marker_img;
                                            $imageSrc = wp_get_attachment_image_src($marker_img, 'full');
                                            $marker_img = $imageSrc[0];
                                        } else if (is_array($marker_img)) {
                                            //echo 'array: '.$marker_img;
                                            $imageSrc = wp_get_attachment_image_src($marker_img['ID'], 'full');
                                            $marker_img = $imageSrc[0];
                                        }
                                        if ($marker_img == '') {
                                            $marker_img = $imageMarker;
                                        }

                                        if ($marker_img == '') {
                                            $marker_data = '';
                                        } else {
                                            $marker_data = '"marker":"' . $marker_img . '",';
                                        }


                                        if ($counter > 0) {
                                            echo ', ';
                                        }
                                        echo '{"address":"' . $indirizzo . '",';
                                        echo '"lat":"' . $lat . '",';
                                        echo '"lng":"' . $lng . '",';
                                        echo $marker_data;
                                        echo '"postLink":"' . $postlink . '",';
                                        echo '"infoWindow": "' . strval(addslashes($postInfowindow)) . '"}';
                                        //var_dump($map_field);
                                        $counter++;
                                    }
                                }
                                ?>];
                        </script>
                        <?php
                        // Reset the post data to prevent conflicts with WP globals
                        $wp_query->queried_object = $original_queried_object;
                        $wp_query->queried_object_id = $original_queried_object_id;
                        wp_reset_postdata();
                    } else { //have_posts()
//                        echo 'Sorry, but no listing matches your search criteria.';
                        return;
                    }
                }else { ?>
                    <script>
                        var address_list_<?php echo $this->get_id(); ?> = [];
                    </script>
                    <?php
                }


            /* ----------------------------------------------------------------- END Query */

        //var_dump($counter);
        ?>

        <style>
            #el-wgt-map-<?php echo $this->get_id(); ?>{
                width: 100%;
                background-color: #ccc;
            }

            .gm-style .gm-style-iw-d,
            .gm-style .gm-style-iw.gm-style-iw-c {
              overflow: initial !important;
              max-height: none !important;
            }

            .gm-style .gm-style-iw.gm-style-iw-c {
              max-width: 320px !important;
              width: 320px;
              padding: 0 !important;
              overflow: hidden !important;
            }

            .map-card__content {
              padding-top: 16px;
            }

            .map-card__content > * {
              padding: 0 20px;
              margin-bottom: 10px;
            }

            .map-card__content > *:last-child {
              margin-bottom: 0;
            }

            .map-card__wrap-img {
              font-size: 0;
              overflow: hidden;
              position: relative;
            }

            .map-card__wrap-img:before {
              content: "";
              padding-top: 65%;
              display: block;
              pointer-events: none;
            }

            .map-card__wrap-img img {
              position: absolute;
              top: 0;
              left: 0;
              width: 100%;
              height: 100% !important;
              object-fit: cover;
              object-position: center;
            }

            .map-card__title {
              display: block;
              font-size: 18px;
              color: #333;
              text-decoration: none;
              font-weight: 500;
            }

            .map-card__row {
              display: flex;
              align-items: center;
              justify-content: space-between;
              margin-bottom: 18px;
            }

            .map-card__details {
              display: flex;
              align-items: center;
              flex-wrap: wrap;
            }

            .map-card__details > * {
              margin-bottom: 6px;
            }

            .map-card__details-item {
              display: flex;
              align-items: center;
              padding: 0 8px;
              font-size: 12px;
              width: 100%;
              max-width: calc(100% / 6);
            }

            .map-card__details-item-icon {
              margin-right: 5px;
              font-size: 14px;
              width: 20px;
              height: 20px;
              display: flex;
              align-items: center;
              color: #5c727d;
            }

            .map-card__price {
              color: #5c727d;
              font-size: 16px;
              font-weight: 500;
            }

            .map-card__label {
              font-size: 14px;
              background-color: #274abb;
              color: #fff;
              text-align: center;
              line-height: 14px;
              padding: 6px 12px;
              border-radius: 4px;
            }

            .map-card__bottom {
              padding: 0 12px 12px;
            }
        </style>
        <span id="debug" style="display: none;"></span>
        <?php //echo $settings['acf_mapfield']; ?>
        <div id='el-wgt-map-<?php echo $this->get_id(); ?>'
             data-address='<?php echo $indirizzo; ?>'
             data-lat='<?php echo $lat; ?>'
             data-lng='<?php echo $lng; ?>'
             data-zoom='<?php echo $zoom; ?>'
             data-imgmarker='<?php echo $imageMarker; ?>'
        </div>
        <?php
    }

    protected function _content_template() {

    }

    protected function snazzymaps() {
        $path = get_template_directory() . '/includes/elementor/widgets/HelloMap/';
        $path_url = get_template_directory_uri() . '/includes/elementor/widgets/HelloMap/';
        $snazzy_list = [];
        $snazzy_styles = glob($path . 'maps_style/*.json');
        if (!empty($snazzy_styles)) {
            foreach ($snazzy_styles as $key => $value) {
                $snazzy_name = basename($value);
                $snazzy_name = str_replace('.json', '', $snazzy_name);
                $snazzy_name = str_replace('_', ' ', $snazzy_name);
                $snazzy_name = ucfirst($snazzy_name);
                $snazzy_url = str_replace('.json', '', $value);
                $snazzy_url = str_replace($path, $path_url, $snazzy_url);
                $snazzy_list[$snazzy_url] = $snazzy_name;
            }
        }

        return $snazzy_list;
    }

}
