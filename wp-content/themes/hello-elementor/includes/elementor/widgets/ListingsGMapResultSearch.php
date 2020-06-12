<?php 
namespace WPSight_Berlin\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class ListingsGMapResultSearch extends Widget_Base {

	public function __construct( $data = [], $args = null ) {

		parent::__construct( $data, $args );
		wp_enqueue_script( 'ut-markerclusterer-js', 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js', array(), date("Ymd"), false );
		wp_enqueue_script( 'ut-googleapis-js', 'https://maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false', array(), date("Ymd"), false );
		wp_enqueue_script( 'ut-markerclusterer-background-size-js', 'https://gist.githubusercontent.com/verticalgrain/28bf79bcfd7fbe8e3bfeac3b56fcc82a/raw/e6a95d2e2d789051b2513861c8ee564e4691b181/markerclustererBackgroundSize.js', array(), date("Ymd"), false );
	}

	public function get_script_depends() {
		return ;
	}

	/**
	 * Get widget name.
	 *
	 * Retrieve google maps widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'google_map_serch_result';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve google maps widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Google Map Search Result', 'elementor' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve google maps widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-google-maps';
	}

	/**
	 * Register google maps widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {

		$this->start_controls_section(
			'section_map',
			[
				'label' => __( 'Map', 'elementor' ),
			]
		);

		$this->add_control(
			'zoom',
			[
				'label' => __( 'Zoom Level', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 10,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 20,
					],
				],
			]
		);

		$this->add_control(
			'height',
			[
				'label' => __( 'Height', 'elementor' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 300,
				],
				'range' => [
					'px' => [
						'min' => 40,
						'max' => 1440,
					],
				],
				'selectors' => [
					'{{WRAPPER}} iframe' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'prevent_scroll',
			[
				'label' => __( 'Prevent Scroll', 'elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'selectors' => [
					'{{WRAPPER}} iframe' => 'pointer-events: none;',
				],
			]
		);

		$this->add_control(
			'view',
			[
				'label' => __( 'View', 'elementor' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
			]
		);

		$this->end_controls_section();
	}

	/*protected function reformat_date( $date, $from_format = 'F j, Y', $to_format = 'Ymd' ) {

	    $date_aux = date_create_from_format( $from_format, $date );

	    return date_format( $date_aux, $to_format );
	}*/

	protected function generate_query() {

		$get_data = $_GET;
		$args = array( 
		    'post_type'      => 'property', 
		    'posts_per_page' => -1,
		    'post_status'    => 'publish'
		    // 'meta_query'     => array('relation'  => 'AND'),
	  	); 

		foreach ( (array)$_GET as $meta_key => $meta_value ) {
		    
		    if ( ! empty(  $meta_value ) ) {

		    	if ( 'keyword' == $meta_key ) {

		    		$args['s'] = $meta_value;

		    	} elseif ( 'property_year_built' == $meta_key ) {

		    		$args['meta_query'][] = array(
			            array(
			                'key' 		=> $meta_key,
							'value' 	=> preg_replace( '/\s+/', '', $meta_value ), // date('Ymd'),
							'type' 		=> 'DATE',
							'compare' 	=> '=='
			            )
			        ); 

		    	} else {

		    		$args['meta_query'][] = array(
			            array(
		                 	'key'   => $meta_key,
		                 	'value' => $meta_value
			            )
			        );

		    	}
		    	
		    } 
		}

		$query = new \WP_Query( $args );

        return $query;
	}

	protected function get_list_locations( $query ) {

		$result = [];

		if ( $query->have_posts() ) :
            while ( $query->have_posts() ) : $query->the_post();

            	$location = get_field( "property_location", get_the_ID() ); 

                $result[] = [ 'lat' => $location['lat'], 'lng' => $location['lng'] ];

        endwhile;
        wp_reset_postdata();
        endif;

        return $result;
	}

	/**
	 * Render google maps widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$query = $this->generate_query(); 
		$list_locations = json_encode( $this->get_list_locations( $query ) ); 
		$settings = $this->get_settings();

		if ( 0 === absint( $settings['zoom']['size'] ) ) {
			$settings['zoom']['size'] = 10;
		}

		$map_height = 'height:' . $settings['height']['size'] . 'px';

		?>

			<div class="elementor-custom-embed">
		 		<div id="map" style="<?php echo $map_height; ?>"></div>
	 		</div>

			<script>
				function initMap() {

				  	var map = new google.maps.Map(document.getElementById("map"), {
				    	zoom: <?php echo absint( $settings['zoom']['size'] ); ?>,
				    	center: { lat: -28.024, lng: 140.887 }
				  	});

				  	// Create an array of alphabetical characters used to label the markers.
				  	var labels = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
				  	var markers = locations.map(function(location, i) {
					    return new google.maps.Marker({
					      	position: location,
					      	label: labels[i % labels.length]
					    });
				  	});
				  
					var clusterStyles = [
					  	{
						    textColor: 'white',
						    url: 'https://cdn3.iconfinder.com/data/icons/eightyshades/512/78_Circle-Full-48.png',
						    height: 48,
						    width: 48
					  	},
					 	{
						    textColor: 'white',
						    url: 'https://cdn3.iconfinder.com/data/icons/eightyshades/512/78_Circle-Full-48.png',
						    height: 48,
						    width: 48
					  	},
					 	{
						    textColor: 'white',
						    url: 'https://cdn3.iconfinder.com/data/icons/eightyshades/512/78_Circle-Full-48.png',
						    height: 48,
						    width: 48
					  	}
					];

				  	// Add a marker clusterer to manage the markers.
				  	var markerCluster = new MarkerClusterer(map, markers, {
					    //imagePath: "https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m",
					    gridSize: 48,
					    cssClass: 'cluster',
					    styles: clusterStyles,
					    minimumClusterSize: 2,
					    calculator: function(markers, numStyles) {
					       if (markers.length >= 50) return { text: markers.length, index: 3} // red
					       if (markers.length >= 5) return { text: markers.length, index: 2}  // yellow
					       return { text: markers.length, index: 0}    }                      // blue
				  	});
				  

				  
				}
				google.maps.event.addDomListener( window, 'load', initMap );

				var locations = <?php echo $list_locations; ?> ;

			</script>
		<?php 
	}

	/**
	 * Render google maps widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _content_template() {}
}