<?php
namespace WPSight_Berlin\Elementor\Widgets\HelloSearchFilter\Skins;

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

    protected function _register_controls_actions() {
        add_action( 'elementor/element/search_filter/section_search_filter/before_section_end', [ $this, 'register_controls' ] );
    }

    public function get_id() {
        return 'skin-base';
    }


    public function register_controls( Widget_Base $widget ) {
        $this->parent = $widget;

        $this->register_some_controls();
    }

	protected function register_some_controls(  ) {

        $result_pages = [ '' => _x( 'Select Page', 'elementor' ) ];
        $pages = get_pages();
        foreach( $pages as $page ) {
            $result_pages[ $page->ID ] = $page->post_title;
        }

        $this->add_control(
            'result_page',
            [
                'label'   => _x( 'Select Result Page', 'Select Result Page', 'elementor' ),
                'type'    => Controls_Manager::SELECT,
                'default' => '',
                'options' => $result_pages,
            ]
        );

		$repeater = new Repeater();

		$repeater->add_control(
			'type_field',
			[
				'label'   => _x( 'Type field', 'Type Field', 'elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'search',
				'options' => [
					'search' 				=> _x( 'Search', 'Type Field', 'elementor' ),
					'property_year_built' 	=> _x( 'Year Built', 'Type Field', 'elementor' ),
					'property_bedrooms' 	=> _x( 'Bedrooms', 'Type Field', 'elementor' ),
					'property_bath' 		=> _x( 'Bath', 'Type Field', 'elementor' ),
					'property_garages' 		=> _x( 'Garages', 'Type Field', 'elementor' ),
					'property_rooms' 		=> _x( 'Rooms', 'Type Field', 'elementor' ),
					'property_living_area' 	=> _x( 'Living Area', 'Type Field', 'elementor' ),
					'property_terrace' 		=> _x( 'Terrace', 'Type Field', 'elementor' ),
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
					'input' 	=> _x( 'Input', 'Type View', 'elementor' ),
					'select' 	=> _x( 'Select', 'Type View', 'elementor' ),
					'checkbox' 	=> _x( 'Checkbox', 'Type View', 'elementor' ),
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
			'items',
			[
				'label' 	 	=> __( 'Fields', 'elementor' ),
				'type' 		 	=> Controls_Manager::REPEATER,
				'show_label' 	=> true,
				'fields' 		=> $repeater->get_controls(),
				'default' 		=> [
					[
						'type_field' => 'search',
					],
					[
						'type_field' => 'price',
					],
				],
				'title_field' => '{{{ type_field }}}',
			]
		);

	}

	protected function render_header() {
        ?>
            <h1>Header</h1>
        <?php
    }

    protected function render_search_form() {

        $settings = $this->parent->get_settings();
        ?>

            <div id="home-search" class="site-section home-section">
                <div class="container">
                    <form id="search_filter_form" method="get" action="<?php echo get_page_link( $settings['result_page'] ); ?>" class="wpsight-listings-search horizontal">

                        <h1>SKIN BASE</h1>

                        <div class="listings-search-default">

                            <?php
                            foreach ( $settings['items'] as $field ) :

                                if ( 'search' == $field['type_field'] ) :
                                ?>

                                    <div class="listings-search-field listings-search-field-text listings-search-field-keyword wrap-field wrap-field_search" style="width:<?php echo $field['width_field']; ?>%;">
                                        <label class="wrap-input">
                                          <?php echo $field['label']; ?>
                                          <input class="listing-search-keyword text form-control" name="keyword" type="text" value="" placeholder="<?php echo $field['placeholder']; ?>">
                                        </label>

                                        <div class="listings-search-field listings-search-field-submit listings-search-field-submit">
                                          <input type="submit" value="Search" class="btn btn-primary btn-block">
                                        </div>
                                    </div>

                                <?php
                                elseif (
                                    'property_bedrooms'     == $field['type_field'] ||
                                    'property_bath'         == $field['type_field'] ||
                                    'property_garages'      == $field['type_field'] ||
                                    'property_rooms'        == $field['type_field'] ||
                                    'property_living_area'  == $field['type_field'] ||
                                    'property_terrace'      == $field['type_field']
                                ) :

                                    if ( 'input' == $field['type_view'] ) : ?>

                                        <div class="wrap-field" style="width:<?php echo $field['width_field']; ?>%;">
                                            <label class="wrap-input">
                                                <?php echo $field['label']; ?>
                                                <input class="text form-control" name="<?php echo $field['type_field']; ?>" type="number" value="" placeholder="<?php echo $field['placeholder']; ?>">
                                            </label>
                                        </div>

                                    <?php elseif ( 'select' == $field['type_view'] ) : ?>

                                        <div class="wrap-field" style="width:<?php echo $field['width_field']; ?>%;">
                                            <label class="wrap-input">
                                                <?php echo $field['label']; ?>
                                                <select name="<?php echo $field['type_field']; ?>">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select>
                                            </label>
                                        </div>

                                    <?php elseif ( 'checkbox' == $field['type_view'] ) : ?>

                                        <div class="wrap-field" style="width:<?php echo $field['width_field']; ?>%;">
                                            <label class="wrap-input"><?php echo $field['label']; ?></label>
                                            <label>
                                                1
                                                <input type="checkbox" name="<?php echo $field['type_field']; ?>" value="1" >
                                            </label>
                                            <label>
                                                2
                                                <input type="checkbox" name="<?php echo $field['type_field']; ?>" value="2" >
                                            </label>
                                            <label>
                                                3
                                                <input type="checkbox" name="<?php echo $field['type_field']; ?>" value="3" >
                                            </label>
                                            <label>
                                                4
                                                <input type="checkbox" name="<?php echo $field['type_field']; ?>" value="4" >
                                            </label>
                                            <label>
                                                5
                                                <input type="checkbox" name="<?php echo $field['type_field']; ?>" value="5" >
                                            </label>
                                        </div>

                                    <?php
                                    endif;

                                elseif ( 'property_year_built' == $field['type_field'] ) :
                                ?>

                                  <div class="wrap-field" style="width:<?php echo $field['width_field']; ?>%;">
                                    <label class="wrap-input">
                                      <?php echo $field['label']; ?>
                                      <input class="text form-control datepicker-here" name="<?php echo $field['type_field']; ?>" type="text" value="" placeholder="<?php echo $field['placeholder']; ?>" data-date-format="yyyy mm dd">
                                      <!-- data-date-format="M d, yyyy" -->
                                    </label>
                                  </div>

                                <?php
                                endif;

                            endforeach;
                            ?>

                        </div>
                    </form>
                </div>
            </div>
        <?php
    }

    protected function render_footer() {
        ?>
            <h1>Footer</h1>
        <?php
    }

	public function render() {

        $this->render_header();
        $this->render_search_form();
        $this->render_footer();
    }
}
