<?php
namespace PropertyBuilder\Elementor\Widgets\Agents;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use ElementorPro\Modules\QueryControl\Module as Module_Query;
use ElementorPro\Modules\QueryControl\Controls\Group_Control_Related;
//use PropertyBuilder\Elementor\Widgets\Property\Skins;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

include_once ( 'skins/HelloAgentSkinBase.php');
include_once ( 'skins/HelloAgentSkin1.php');
include_once ( 'skins/HelloAgentSkin2.php');
include_once ( 'skins/HelloAgentSkin3.php');

/**
 * Class Posts
 */
class HelloAgents extends Widget_Base {

    private $meta;
    private $id;

    public function __construct($data = [], $args = null) {
        $this->meta = [
            'agent_specialties' => __( 'Specialties', 'builder' ),
            'agent_email' => __( 'Email', 'builder' ),
            'agent_service_areas' => __( 'Service Areas', 'builder' ),
            'agent_tax_number' => __( 'Tax Number', 'builder' ),
            'agent_license' => __( 'Agent license', 'builder' ),
            'agent_position' => __( 'Position', 'builder' ),
            'agent_company_name' => __( 'Company Name', 'builder' ),
            'agent_mobile' => __( 'Mobile Number', 'builder' ),
            'agent_office_number' => __( 'Office Number', 'builder' ),
            'agent_language' => __( 'Language', 'builder' ),
            'agent_website' => __( 'Website', 'builder' ),
        ];

        $this->id = get_the_ID();

        parent::__construct($data, $args);
        wp_register_script('hello-carousel-agents-script', get_stylesheet_directory_uri() . '/includes/elementor/widgets/HelloAgentList/assets/js/base-script.js', '', '1', true);
        wp_register_style('hello-carousel-agents-style', get_stylesheet_directory_uri() . '/includes/elementor/widgets/HelloAgentList/assets/css/base-main.css', '', 1);
    }

    public function get_meta() {
        return $this->meta;
    }

    public function get_the_id() {
        return $this->id;
    }

    public function set_the_id($id) {
        return $this->id = $id;
    }

    public function get_script_depends() {
        return ['hello-carousel-agents-script', 'swiper'];
    }

    public function get_style_depends() {
        return ['hello-carousel-agents-style'];
    }

	public function get_name() {
		return 'hello-agents';
	}

	public function get_title() {
		return __( 'Hello Agents', 'elementor-pro' );
	}

	public function get_keywords() {
		return [ 'posts', 'cpt', 'item', 'loop', 'query', 'cards', 'custom post type' ];
	}

	public function on_import( $element ) {
		if ( ! get_post_type_object( $element['settings']['posts_post_type'] ) ) {
			$element['settings']['property_post_type'] = 'property';
		}

		return $element;
	}

	protected function _register_skins() {
		$this->add_skin( new Skins\HelloAgentSkin1( $this ) );
		$this->add_skin( new Skins\HelloAgentSkin2( $this ) );
		$this->add_skin( new Skins\HelloAgentSkin3( $this ) );
	}

	protected function _register_controls() {
		parent::_register_controls();

		$this->register_query_section_controls();
	}

	public function query_posts() {

	}

	protected function register_query_section_controls() {

        $this->start_controls_section(
            'section_layout',
            [
                'label' => __( 'Layout', 'elementor-pro' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->end_controls_section();

	}

}
