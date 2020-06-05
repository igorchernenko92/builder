<?php
namespace WPSight_Berlin\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use ElementorPro\Base\Base_Widget;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class ListingsSearchFilter extends Base_Widget {

	public function get_name() {
		return 'search_filter';
	}

	public function get_title() {
		return __( 'Search Filter', 'elementor-pro' );
	}

	public function get_icon() {
		return 'eicon-search-results';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_search_filter',
			[
				'label' => __( 'Search Filter', 'elementor-pro' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'type_field',
			[
				'label'   => _x( 'Type field', 'Type Field', 'elementor-pro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'search',
				'options' => [
					'search' 	=> _x( 'Search', 'Type Field', 'elementor-pro' ),
					'order' 	=> _x( 'Order', 'Type Field', 'elementor-pro' ),
					'price' 	=> _x( 'Price', 'Type Field', 'elementor-pro' ),
				],
			]
		);

		$this->add_control(
			'items',
			[
				'label' 	 	=> __( 'Fields', 'elementor-pro' ),
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

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings();
 
		?>
		
			<div id="home-search" class="site-section home-section">
				<div class="container">
					<form method="get" action="#" class="wpsight-listings-search horizontal">
						<div class="listings-search-default">
							<div class="row gutter-30">
								
								<?php foreach ( $settings['items'] as $field ) : ?>
									
									<?php if ( 'search' == $field['type_field'] ) : ?>

										<div class="listings-search-field listings-search-field-text listings-search-field-keyword col-xs-10 col-sm-9"> 
											<input class="listing-search-keyword text form-control" title="Keyword or Listing ID…" name="keyword" type="text" value="" placeholder="Keyword or Listing ID…">
										</div>
										<div class="listings-search-field listings-search-field-submit listings-search-field-submit col-xs-2 col-sm-3"> 
											<input type="submit" value="Search" class="btn btn-primary btn-block">
										</div><br>
									
									<?php elseif ( 'order' == $field['type_field'] ) : ?>

										<div class="listings-search-field listings-search-field-select listings-search-field-offer col-xs-12 col-sm-2">
											<div class="btn-group bootstrap-select listing-search-offer select form-control">
												<select id="listing-search-offer-5eda43b0e0f5f" class="listing-search-offer select selectpicker form-control" name="offer" tabindex="-98">
													<option value="">Order</option>
													<option value="asc" data-default="false">ASC</option>
													<option value="desc" data-default="false">DESC</option> 
												</select>
											</div>
										</div><br>

									<?php elseif ( 'price' == $field['type_field'] ) : ?>

										<div class="listings-search-field listings-search-field-text listings-search-field-keyword col-xs-12 col-sm-9"> 
											<input class="listing-search-keyword text form-control" name="price" type="number" value="" placeholder="Price">
										</div><br>

									<?php endif; ?>

								<?php endforeach; ?>

							</div>
						</div>  
					</form>
				</div>
			</div>

		<?php
	}

	/**
	 * Render search_filter widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 2.9.0
	 * @access protected
	 */
	protected function content_template() {

	}
}
