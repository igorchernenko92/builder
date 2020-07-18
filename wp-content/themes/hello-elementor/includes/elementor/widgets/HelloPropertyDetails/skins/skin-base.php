<?php
namespace PropertyBuilder\Elementor\Widgets\HelloPropertyDetails\Skins;

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
				'options' => $this->parent->get_type_list()
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

	protected function render_details_top() {
      ?>
        <div class="hl-details-1">
      <?php
  }

  protected function render_details_bottom() {
      ?>
        </div>
      <?php
  }

    protected function render_details() {
        $items =  $this->get_instance_value( 'hello_property_details' );
        $details_array = $this->parent->get_type_list();
        $label = '';
        $this->render_details_top();

        foreach ( $items as $field ) {
            $value = get_field($field["type_field"], get_the_ID());
            if ( !$value ) {
                continue;
            }
            $label = $details_array[ $field["type_field"] ];
            if ($field['label']) {
                $label = $field['label'];
            } ?>
            <div class="listing-details-detail">
              <div class="listing-details-label">
                  <?php echo $label ?>
              </div>
              <div class="listing-details-value">
                  <?php echo $value;  ?>
              </div>
            </div>
       <?php }
        $this->render_details_bottom();
    }

	public function render() {
        $this->render_details();
    }
}
