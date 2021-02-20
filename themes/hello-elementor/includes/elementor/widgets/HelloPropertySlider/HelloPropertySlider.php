<?php

namespace PropertyBuilder\Elementor\Widgets\HelloPropertySlider;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use ElementorPro\Base\Base_Widget;

include_once ( 'skins/skin-base.php');
include_once ( 'skins/skin1.php');
include_once ( 'skins/skin2.php');

class HelloPropertySlider extends Base_Widget {
    protected $_has_template_content = false;
	public function __construct( $data = [], $args = null ) {

		parent::__construct( $data, $args );
//        wp_register_script('swiper', $this->wpacuGetSwiperJsUrl(), '', '1');
//        wp_enqueue_script('jquery');
//        wp_enqueue_script('swiper');
        wp_register_script('hello-property-slider-script', get_stylesheet_directory_uri() . '/includes/elementor/widgets/HelloPropertySlider/assets/js/base-script.js', '', '1', true);


        wp_register_style('hello-property-slider-style', get_stylesheet_directory_uri() . '/includes/elementor/widgets/HelloPropertySlider/assets/css/base-main.css', '', 1);

//        var_dump($this->wpacuGetSwiperJsUrl());
	}

    public function get_script_depends() {
        return ['hello-property-slider-script' ];
    }

    public function get_style_depends() {
        return ['hello-property-slider-style'];
    }

	public function get_name() {
		return 'hello_property_slider';
	}

	public function get_title() {
		return __( 'Hello Property Slider', 'elementor' );
	}

	public function get_icon() {
		return 'eicon-search-results';
	}

	public function get_categories() {
		return [ 'general' ];
	}

    public function get_keywords() {
        return [ 'slider', 'properties', 'banner', 'list' ];
    }

	protected function _register_skins() {
		$this->add_skin( new Skins\Skin1( $this ) );
		$this->add_skin( new Skins\Skin2( $this ) );
	}


//    public function wpacuGetSwiperJsUrl()
//    {
//        $swiperJsFileUrl = ELEMENTOR_ASSETS_URL.'lib/swiper/swiper';
//
//        $swiperJsFileDir = ELEMENTOR_PATH.'assets/lib/swiper/';
//
//        $swiperAssetExists = (is_file($swiperJsFileDir.'swiper.js') || is_file($swiperJsFileDir.'swiper.min.js'));
//
//        if ( ! $swiperAssetExists ) {
//            return false;
//        }
//
//        $isTestMode = (defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG) || (defined( 'ELEMENTOR_TESTS' ) && ELEMENTOR_TESTS);
//
//        if (! $isTestMode) {
//            $swiperJsFileUrl .= '.min.js'; // load the minified version if there's no test mode
//        } else {
//            $swiperJsFileUrl .= '.js'; // test mode is enabled, thus load it non-minified
//        }
//
//        // Determine Swiper Version / The URL has to be exactly the same one loaded from /wp-content/plugins/elementor/assets/js/frontend.(min).js
//        $frontEndMinJsFilePath = ELEMENTOR_ASSETS_PATH.'js/frontend.min.js';
//
//        if (! is_file($frontEndMinJsFilePath)) {
//            return false;
//        }
//
//        $frontEndMinJsContents = file_get_contents(ELEMENTOR_ASSETS_URL.'js/frontend.min.js');
//
//        preg_match_all('#assets,"lib/swiper/swiper"\)(.*?)\".js\?ver=(.*?)\"\)#si', $frontEndMinJsContents, $verMatches);
//
//        if (isset($verMatches[2][0]) && is_numeric(str_replace('.', '', $verMatches[2][0]))) {
//            $swiperJsFileUrl .= '?ver='.trim($verMatches[2][0]);
//        }
//
//        return $swiperJsFileUrl;
//    }




	protected function _register_controls() {
        parent::_register_controls();

		$this->start_controls_section(
			'section_property_slider',
			[
				'label' => __( 'Property Slider', 'elementor' ),
			]
		);

		$this->end_controls_section();


//        $this->start_controls_section(
//            'property_style_icon',
//            [
//                'label' => __( 'Icon', 'elementor' ),
//            ]
//        );
//
//
//        $this->end_controls_section();

	}




}
