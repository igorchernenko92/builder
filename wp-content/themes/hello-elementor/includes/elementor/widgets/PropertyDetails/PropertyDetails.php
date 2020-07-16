<?php

namespace PropertyBuilder\Elementor\Widgets\PropertyDetails;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Text_Shadow; 
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use ElementorPro\Base\Base_Widget;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

include_once ( 'skins/skin-base.php');
include_once ( 'skins/skin1.php');
include_once ( 'skins/skin2.php');

class PropertyDetails extends Base_Widget {

	public function __construct( $data = [], $args = null ) {

		parent::__construct( $data, $args );
	}

    public function get_script_depends() {
        return ['' ];
    }

    public function get_style_depends() {
        return [''];
    }

	public function get_name() {
		return 'property_details';
	}

	public function get_title() {
		return __( 'Property Details', 'elementor' );
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
			'section_property_details',
			[
				'label' => __( 'Property Details', 'elementor' ),
			]
		);

		$this->end_controls_section();
	}
}
