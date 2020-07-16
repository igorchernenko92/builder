<?php
namespace PropertyBuilder\Elementor\Widgets\PropertyDetails\Skins;

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
        add_action( 'elementor/element/property_details/section_property_details/before_section_end', [ $this, 'register_controls' ] );
    }


    public function register_controls( Widget_Base $widget ) {
        $this->parent = $widget;

        $this->register_filter_controls();
    }

	protected function register_filter_controls(  ) {

		$repeater = new Repeater();

		$repeater->add_control(
			'type_field',
			[
				'label'   => _x( 'Type field', 'Type Field', 'elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'property_id',
				'options' => $this->details_array(),
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



		$this->add_control(
			'hello_property_details',
			[
				'label' 	 	=> __( 'Fields', 'elementor' ),
				'type' 		 	=> Controls_Manager::REPEATER,
				'show_label' 	=> true,
				'fields' 		=> $repeater->get_controls(),
				'default' 		=> [
					[
						'type_field' => 'property_id',
					],
					[
						'type_field' => 'price',
					],
				],
				'title_field' => '{{{ type_field }}}',
			]
		);

	}

    protected function render_details() {
        $settings = $this->parent->get_settings_for_display();
        $items =  $this->get_instance_value( 'hello_property_details' );
        $details_array = $this->details_array();
        $label = '';

        foreach ( $items as $field ) {
            $label = $details_array[ $field["type_field"] ];
            if ($field['label']) {
                $label = $field['label'];
            } ?>
            <div class="some_class"><?php echo $label ?> : <?php echo get_field($field["type_field"], get_the_ID())  ?></div>

       <?php }

    }

	public function render() {
        $this->render_details();
    }

    protected function details_array() {
        $details = [
                'property_id' 			=> __( 'Property ID', 'elementor' ),
                'property_year_built' 	=> __( 'Year Built', 'elementor' ),
                'property_bedrooms' 	=> __( 'Bedrooms', 'elementor' ),
                'property_bath' 		=> __( 'Bath', 'elementor' ),
                'property_garages' 		=> __( 'Garages', 'elementor' ),
                'property_rooms' 		=> __( 'Rooms', 'elementor' ),
                'property_living_area' 	=> __( 'Living Area', 'elementor' ),
                'property_terrace' 		=> __( 'Terrace', 'elementor' ),
                'property_price' 		=> __( 'Price', 'elementor' ),
//					'features' 		        => __( 'Features', 'elementor' ),
//					'location' 		        => __( 'Location', 'elementor' ),
        ];
        return $details;
    }

}
