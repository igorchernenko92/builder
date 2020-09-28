<?php
namespace PropertyBuilder\Elementor\Widgets\Agents\Skins;

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

abstract class HelloAgentSkinBase extends Elementor_Skin_Base {

    public function get_id() {
        return 'skin-base';
    }

	protected $current_permalink;

	protected function _register_controls_actions() {
		add_action( 'elementor/element/hello-agents/section_layout/before_section_end', [ $this, 'register_layout_sections' ] );
    }

	public function register_query_sections( Widget_Base $widget ) {
		$this->parent = $widget;

//		$this->register_design_controls();
	}

    public function register_layout_sections( Widget_Base $widget ) {
        $this->parent = $widget;

        $this->register_layout_controls();
    }


    public function register_layout_controls () {
        global $post;

        $is_prop = '';
        if ( 'property' == $post->post_type ) {
            $is_prop = 'yes';
        }

        $is_agent = '';
        if( 'agent' == $post->post_type ){
            $is_agent = 'yes';
        }

        $this->add_control(
            'is_agent_page',
            [
                'label' => __('Is Agent Page', 'builder'),
                'type' => Controls_Manager::SWITCHER,
                'default' => $is_agent,
                'frontend_available' => true,
                'condition' => [
                    $this->get_control_id( 'is_property_page' ) => '',
                ]
            ]
        );

        $this->add_control(
            'is_property_page',
            [
                'label' => __('Is Property Page', 'builder'),
                'type' => Controls_Manager::SWITCHER,
                'default' => $is_prop,
                'frontend_available' => true,
                'condition' => [
                    $this->get_control_id( 'is_agent_page' ) => '',
                ]
            ]
        );


        $this->add_responsive_control(
            'posts_per_page',
            [
                'label' => __( 'Posts Per Page', 'elementor-pro' ),
                'description' => __( '-1 for all agents', 'elementor-pro' ),
                'type' => Controls_Manager::NUMBER,
                'default' => -1,
                'condition' => [
                    $this->get_control_id( 'is_agent_page' ) => '',
                    $this->get_control_id( 'is_property_page' ) => '',
                ]
            ]
        );

        $this->add_responsive_control(
            'agent_items_width',
            [
                'label' => __( 'Item width', 'elementor-pro' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                    ],
                ],
                'default' => [
                    'size' => 300,
                ],
                'selectors' => [
                    '{{WRAPPER}} .hl-agents-main' => 'grid-template-columns: repeat(auto-fill, minmax({{SIZE}}{{UNIT}}, 1fr)) ',
                ],
            ]
        );

        $this->add_responsive_control(
            'agent_items_gap',
            [
                'label' => __( 'Gaps', 'elementor-pro' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 150,
                    ],
                ],
                'default' => [
                    'size' => 40,
                ],
                'selectors' => [
                    '{{WRAPPER}} .hl-agents-main' => 'grid-gap: {{SIZE}}{{UNIT}}',
                ],
            ]
        );


        $repeater = new Repeater();

        $repeater->add_control(
            'agent_meta_key',
            [
                'label' => __( 'Meta Data', 'elementor-pro' ),
                'label_block' => true,
                'type' => Controls_Manager::SELECT2,
                'multiple' => false,
                'options' => $this->parent->get_meta()
            ]
        );

        $repeater->add_control(
            'label',
            [
                'label' => __( 'Label', 'elementor' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => __( '', 'elementor' ),
                'default' => __( '', 'elementor' ),
                'description' => __( 'Leave it empty if default', 'elementor' ),
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );


        $this->add_control(
            'agent_meta_data',
            [
                'label' => '',
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'label' => __( '', 'elementor' ),
                        'agent_meta_key' => 'agent_company_name',
                    ],
                    [
                        'label' => __( '', 'elementor' ),
                        'agent_meta_key' => 'agent_mobile',
                    ],
                    [
                        'label' => __( '', 'elementor' ),
                        'agent_meta_key' => 'agent_email',
                    ],
                    [
                        'label' => __( '', 'elementor' ),
                        'agent_meta_key' => 'agent_service_areas',
                    ],

                ],
                'title_field' => '{{{ agent_meta_key }}}',
            ]
        );

    }


    public function register_controls( Widget_Base $widget ) {
		$this->parent = $widget;

	}

	public function get_container_class() {
		return 'elementor-hello-property--skin-' . $this->get_id();
	}

	protected function render_post_header() {
		?>
		<div <?php post_class( [ 'hl-agent' ] ); ?>>
		<?php
	}

	protected function render_post_footer() {
		?>
		</div>
		<?php
	}

    protected function render_img_placeholder() {
      ?>
        <img src="https://via.placeholder.com/358x232" class="img-responsive" alt="">
      <?php
    }

    protected function render_avatar() {
        $attr = array(
            'class' => "hl-agent__picture",
        );
        $thumbnail = get_the_post_thumbnail( $this->parent->get_the_id(), 'large', $attr );

        if ($thumbnail) { ?>
          <a class="hl-agent__wrap-img" href="<?php echo $this->current_permalink; ?>">
              <?php echo $thumbnail; ?>
          </a>
        <?php } else { ?>
            <div class="hl-agent__wrap-img">
                <?php echo $this->render_img_placeholder(); ?>
            </div>
        <?php }
    }

    protected function render_title() {
        $name = esc_html( get_the_title($this->parent->get_the_id()) );
        if ($name) { ?>
          <a href="<?php echo esc_url( $this->current_permalink ) ?>" target="_blank" class="hl-agent__title"><?php echo esc_html( $name ) ?></a>
        <?php }
    }

    protected function render_position() {
        $spec = get_field('agent_specialties', $this->parent->get_the_id());
        if ($spec) { ?>
          <p class="hl-agent__position"><?php echo esc_html( $spec ) ?></p>
        <?php }
    }

    protected function render_description() {
	    $content = get_field('agent_description', $this->parent->get_the_id());
	    if ($content = trim($content)) {
	        ?>
          <div class="hl-agent__description">
                <?php echo  wp_trim_words( wp_kses_post( $content ), 20 ); ?>
          </div>
        <?php }
    }

    protected function render_bottom() {
        ?>
          <div class="hl-agent__bottom">
            <a href="<?php echo esc_url($this->current_permalink) ?>" target="_blank" class="hl-agent__bottom-link"><?php echo esc_html__('View profile', 'builder') ?></a>
          </div>
        <?php
    }

    public function render_agents_top() {
        ?>
            <div class='hl-agents'>
        <?php
    }

    public function render_agents_bottom() {
      ?>
        </div>
      <?php
    }

    public function render() {
        $settings = $this->parent->get_active_settings();

//      if single agent page show only one
	    if ( $settings [ $this->get_control_id( 'is_agent_page' ) ] && is_singular('agent') ) {
	        $this->parent->set_the_id($this->parent->get_the_id());
            $this->render_agents_top();
            $this->render_post();
            $this->render_agents_bottom();

	        return;
        }

        if ( $settings [ $this->get_control_id( 'is_property_page' ) ] && is_singular('property') ) {
            $property_agent = get_field('property_agent', $this->parent->get_the_id());

            $this->parent->set_the_id($property_agent[0]->ID); // set prop agent id
            $this->current_permalink = get_permalink($property_agent[0]->ID);

            $this->render_agents_top();
            $this->render_post();
            $this->render_agents_bottom();

            return;
        }

        $args = array(
            'post_type' => 'agent',
            'post_status' => 'publish',
            'posts_per_page' => $this->get_instance_value( 'posts_per_page' ),
        );

        $query = new \WP_Query($args);
        if ( ! $query->have_posts() ) {
            return;
        }

        $this->render_agents_top();
            while ( $query->have_posts() ) {
                $query->the_post();

                $this->parent->set_the_id(get_the_ID());

                $this->current_permalink = get_permalink(get_the_ID());
                $this->render_post();
            }
        $this->render_agents_bottom();

        wp_reset_postdata();
    }

	protected function render_post() {
        $options = $this->parent->get_meta();
        $agents_meta = $this->get_instance_value( 'agent_meta_data' );

        foreach ( $agents_meta as $item ) {
            $label = $item['label'];
            if (!$label)  $label = $options[$item['agent_meta_key']];

            $value = get_field($item['agent_meta_key'], $this->parent->get_the_id());
        }

      $this->render_post_header();
          $this->render_avatar();
          $this->render_title();
          $this->render_position();
          $this->render_description();
          $this->render_bottom();
      $this->render_post_footer();
	}
}
