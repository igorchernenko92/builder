<?php
namespace PropertyBuilder\Elementor\Widgets\HelloBreadcrumbs;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Core\Schemes;
use Elementor\Controls_Manager;


class HelloBreadcrumbs extends Widget_Base {

    public function __construct($data = [], $args = null) {

        parent::__construct($data, $args);
//        wp_register_script('hello-breadcrumbs-script', get_stylesheet_directory_uri() . '/includes/elementor/widgets/HelloBreadcrumbs/assets/js/base-script.js', '', '1', true);
        wp_register_style('hello-breadcrumbs-style', get_stylesheet_directory_uri() . '/includes/elementor/widgets/HelloBreadcrumbs/assets/css/base-main.css', '', 1);
    }

//    public function get_script_depends() {
//        return ['hello-breadcrumbs-script'];
//    }

    public function get_style_depends() {
        return ['hello-breadcrumbs-style'];
    }

	public function get_name() {
		return 'hello_breadcrumbs_list';
	}


	public function get_title() {
		return __( 'Hello BreadCrumbs', 'elementor' );
	}


	public function get_icon() {
		return 'eicon-icon-box';
	}

	public function get_keywords() {
		return [ 'breadcrumbs', 'icon' ];
	}


	protected function _register_controls() {
		$this->start_controls_section(
			'section_icon',
			[
				'label' => __( 'Breadcrumbs', 'elementor' ),
			]
		);

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => __( 'Typography', 'elementor-pro' ),
                'name' => 'title_typography',
                'scheme' => Schemes\Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .hello_breadcrumbs_block',
            ]
        );

        $this->add_control(
            'hello_breadcrumbs_color',
            [
                'label' => __( 'Color', 'elementor' ),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_1,
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .hello_breadcrumbs_block a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .hello_breadcrumbs_block span' => 'color: {{VALUE}};',
                ],
            ]
        );





		$this->end_controls_section();
	}

	protected function hello_breadCrumbs() {
        $pageNum = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

        $separator = '<span> > </span>'; //  »

        global $post;

        if( is_front_page() ){

//            if( $pageNum > 1 ) {
//                echo '<a href="' . site_url() . '">Главная</a>' . $separator . $pageNum . '-я страница';
//            } else {
//                echo 'Home';
//            }

        } else {

            echo '<a href="' . site_url() . '">Home</a>' . $separator;

            if( is_single() ) {
                the_category(', '); echo $separator; the_title();
            } 
            elseif ( is_tax() ){

                single_term_title();

            } elseif ( is_page() ) {

                global $post;

                if ( $post->post_parent ) {
                    $parent_id  = $post->post_parent;
                    $breadcrumbs = array();

                    while ( $parent_id ) {
                        $page = get_page( $parent_id );
                        $breadcrumbs[] = '<a href="' . get_permalink( $page->ID ) . '">' . get_the_title( $page->ID ) . '</a>';
                        $parent_id = $page->post_parent;
                    }

                    echo join( $separator, array_reverse( $breadcrumbs ) ) . $separator;
                }

               echo '<span>' . get_the_title() . '</span>';

            } elseif ( is_category() ) {

                single_cat_title();

            } elseif( is_tag() ) {

                single_tag_title();

            } elseif ( is_day() ) {

                echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a>' . $separator;
                echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a>' . $separator;
                echo get_the_time('d');

            } elseif ( is_month() ) {

                echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a>' . $separator;
                echo get_the_time('F');

            } elseif ( is_year() ) { // архивы (по годам)

                echo get_the_time('Y');

            } elseif ( is_author() ) { // архивы по авторам

                global $author;
                $userdata = get_userdata($author);
                echo 'Author: ' . $userdata->display_name;

            } elseif ( is_404() ) { // если страницы не существует

                echo '404';

            }
        }

    }

	protected function render() {
        $settings = $this->get_active_settings();
        echo '<div class="hello_breadcrumbs_block">';
            echo $this->hello_breadCrumbs();
        echo '</div>';

	}
}
