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
		return __( 'Search Filter', 'elementor' );
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
				'label' => __( 'Search Filter', 'elementor' ),
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
					'search' 	=> _x( 'Search', 'Type Field', 'elementor' ),
					'order' 	=> _x( 'Order', 'Type Field', 'elementor' ),
					'price' 	=> _x( 'Price', 'Type Field', 'elementor' ),
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

										<div class="listings-search-field listings-search-field-text listings-search-field-keyword col-xs-10 col-sm-9" style="width:<?php echo $field['width_field']; ?>%;"> 
											<label>
												<?php echo $field['label']; ?>
												<input class="listing-search-keyword text form-control" name="keyword" type="text" value="" placeholder="<?php echo $field['placeholder']; ?>">
											</label>
										</div>
										<div class="listings-search-field listings-search-field-submit listings-search-field-submit col-xs-2 col-sm-3"> 
											<input type="submit" value="Search" class="btn btn-primary btn-block">
										</div>
									
									<?php elseif ( 'order' == $field['type_field'] ) : ?>

										<div class="listings-search-field listings-search-field-select listings-search-field-offer col-xs-12 col-sm-2" style="width:<?php echo $field['width_field']; ?>%;">
											<div class="btn-group bootstrap-select listing-search-offer select form-control">
												<label>
													<?php echo $field['label']; ?>
													<select class="listing-search-offer select selectpicker form-control" name="offer" tabindex="-98">
														<option value="">Order</option>
														<option value="asc" data-default="false">ASC</option>
														<option value="desc" data-default="false">DESC</option> 
													</select>
												</label>
											</div>
										</div>

									<?php elseif ( 'price' == $field['type_field'] ) : ?>

										<div class="listings-search-field listings-search-field-text listings-search-field-keyword col-xs-12 col-sm-9" style="width:<?php echo $field['width_field']; ?>%;"> 
											<label>
												<?php echo $field['label']; ?>
												<input class="listing-search-keyword text form-control" name="price" type="number" value="" placeholder="<?php echo $field['placeholder']; ?>">
											</label>
										</div>

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
