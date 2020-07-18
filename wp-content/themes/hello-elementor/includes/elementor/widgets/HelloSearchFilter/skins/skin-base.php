<?php
namespace PropertyBuilder\Elementor\Widgets\HelloSearchFilter\Skins;

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

    public function get_id() {
        return 'skin-base';
    }

    protected function _register_controls_actions() {
        add_action( 'elementor/element/search_filter/section_search_filter/before_section_end', [ $this, 'register_controls' ] );
    }


    public function register_controls( Widget_Base $widget ) {
        $this->parent = $widget;

        $this->register_filter_controls();
    }

	protected function register_filter_controls(  ) {



	}

    protected function render_search_form() {
        $settings = $this->parent->get_settings_for_display();

        $unit = $settings['_padding']['unit'];
        $padding_top = $settings['_padding']['top'] . $unit;
        $padding_right = $settings['_padding']['right'] . $unit;
        $padding_bottom = $settings['_padding']['bottom'] . $unit;
        $padding_left = $settings['_padding']['left'] . $unit;

        $paddings_string = 'padding-top:' . $padding_top .  ';' . ' padding-right:' . $padding_right .  ';' . ' padding-bottom:' . $padding_bottom .  ';' . ' padding-left:' . $padding_left .  ';';

        $items =  $this->get_instance_value( 'hello_search_items' );
        $search_result_page =  $this->get_instance_value( 'hello_search_result_page' );

        $value_data = [
            'property_bedrooms' => ['' => 'Bedrooms', '1' => 1, '2' => 2, '3' => 3],
            'property_rooms' => ['' => 'Rooms','1' => 1, '2' => 2, '3' => 3, '4' => 4, '10' => 10],
            'property_bath' => ['' => 'Bath','1' => 1, '2' => 2, '3' => 3],
            'property_garages' => ['' => 'Garages','1' => 1, '2' => 2, '3' => 3],
            'featured' => [],
//            'property_garages' => ['' => 'Garages','1' => 1, '2' => 2, '3' => 3],
        ];

        ?>
            <div id="home-search" class="site-section home-section">
                <div class="container">
                    <form id="search_filter_form" method="get" action="<?php echo get_page_link( $search_result_page ); ?>" class="wpsight-listings-search">

                        <div class="listings-search-default" style="<?php echo $paddings_string ?>">
                            <input type="hidden" id="page_id" name="page_id" value="<?php echo $search_result_page ?>">
                            <?php
                                foreach ( $items as $field ) :

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

                                    if ( 'select' == $field['type_view'] ) { ?>
                                        <div class="wrap-field" style="width:<?php echo $field['width_field']; ?>%;">
                                            <label class="wrap-input wrap-select">
                                                      <?php if ($field['label']) { ?>
                                                        <span class="listings-search-field-label">
                                                        <?php echo $field['label']; ?>
                                                      </span>
                                                    <?php } ?>
                                                    <select class="select-2 form-control" name="<?php echo $field['type_field']; ?>">
                                                        <?php foreach ( $value_data[$field['type_field']] as $index => $option ) { ?>
                                                          <option value="<?php echo $index; ?>"><?php echo $option; ?></option>
                                                        <?php  }  ?>
                                                    </select>
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
                                                  <select class="select-multiselect form-control" data-placeholder="test placeholder" multiple="multiple" name="<?php echo $field['type_field']; ?>[]">
                                                    <?php echo $options; ?>
                                                  </select>
                                                </span>
                                            </label>
                                        </div>
                                    <?php } ?>

                                    <?php  if ( 'input' == $field['type_view'] ) { ?>
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
