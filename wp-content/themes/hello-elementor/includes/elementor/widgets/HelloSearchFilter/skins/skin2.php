<?php
namespace WPSight_Berlin\Elementor\Widgets\HelloSearchFilter\Skins;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class Skin2 extends Skin_Base {

	public function get_id() {
		return 'skin2';
	}

	public function get_title() {
		return __( 'Skin 2', 'elementor-pro' );
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

                        <h1>SKIN 2</h1>

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

            <!-- <script>
                jQuery(document).ready( function($) {
                    $('#search_filter_form').submit( function(e) {
                        e.preventDefault();
                        var template_url = '<?php echo $this->get_permalink_by_template( 'template-advanced-search.php' ); ?>';
                        var data = $(this).serialize();
                        var redirect_url = template_url + '?' + data;
                        window.location  = redirect_url;
                    });
                });
            </script> -->

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
