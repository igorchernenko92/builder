<?php

namespace WPSight_Berlin\Elementor\Widgets\HelloSearchFilter;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Text_Shadow; 
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use ElementorPro\Base\Base_Widget;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// include_once ( 'property-base.php');
include_once ( 'skins/skin-base.php');
include_once ( 'skins/skin1.php');
include_once ( 'skins/skin2.php');

class HelloSearchFilter extends Base_Widget {

	public function __construct( $data = [], $args = null ) {

		parent::__construct( $data, $args );
		wp_enqueue_style( 'ut-datepicker-css', get_template_directory_uri() . '/includes/elementor/widgets/assets/css/datepicker.css', array(), date("Ymd"), false );
		wp_enqueue_script( 'ut-datepicker-js', get_template_directory_uri() . '/includes/elementor/widgets/assets/js/datepicker.js', array(), date("Ymd"), false );
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
		$this->add_skin( new Skins\Skin1( $this ) );
		$this->add_skin( new Skins\Skin2( $this ) );
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
			'result_page',
			[
				'label'   => _x( 'Select Result Page', 'Select Result Page', 'elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => $result_pages,
			]
		);

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings();
 
		?>
		
			<div id="home-search" class="site-section home-section">
				<div class="container">
					<form id="search_filter_form" method="get" action="<?php echo get_page_link( $settings['result_page'] ); ?>" class="wpsight-listings-search horizontal">
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
				                    'property_bedrooms' 	== $field['type_field'] ||
				                    'property_bath' 		== $field['type_field'] ||
				                    'property_garages' 		== $field['type_field'] ||
				                    'property_rooms' 		== $field['type_field'] ||
				                    'property_living_area' 	== $field['type_field'] ||
				                    'property_terrace' 		== $field['type_field']
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

}
