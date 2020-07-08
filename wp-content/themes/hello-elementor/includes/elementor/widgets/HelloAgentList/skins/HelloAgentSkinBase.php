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
        return 'skin-agents-base';
    }

	protected $current_permalink;

	protected function _register_controls_actions() {
		add_action( 'elementor/element/hello-agents/section_layout/before_section_end', [ $this, 'register_layout_sections' ] );
//        add_action( 'elementor/element/property/section_query/after_section_end', [ $this, 'register_query_sections' ] );
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
        $default = '';
	    if ( is_singular('agent') ) {
            $default = 'yes';
        }

        $this->add_control(
            'is_agent_page',
            [
                'label' => __('Agent Page', 'builder'),
                'type' => Controls_Manager::SWITCHER,
                'default' => $default,
                'frontend_available' => true,
            ]
        );


        $this->add_control(
            'posts_per_page',
            [
                'label' => __( 'Posts Per Page', 'elementor-pro' ),
                'description' => __( '-1 for all agents', 'elementor-pro' ),
                'type' => Controls_Manager::NUMBER,
                'default' => 6,
                'condition' => [
                    $this->get_control_id( 'is_agent_page' ) => '',
                ]
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
        $thumbnail = get_the_post_thumbnail( get_the_ID(), 'large', $attr );

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
        $name = get_the_title();
        if ($name) { ?>
          <a href="<?php echo  $this->current_permalink ?>" target="_blank" class="hl-agent__title"><?php echo $name ?></a>
        <?php }
    }

    protected function render_position() {
        $spec = get_field('agent_specialties', get_the_ID());
        if ($spec) { ?>
          <p class="hl-agent__position"><?php echo $spec ?></p>
        <?php }
    }

    protected function render_description() {
	    $content = get_field('agent_description', get_the_ID());
	    if (trim($content)) { ?>
          <div class="hl-agent__description">
                <?php echo trim($content); ?>
          </div>
        <?php }
    }

    protected function render_bottom() {
        ?>
          <div class="hl-agent__bottom">
            <a href="<?php echo  $this->current_permalink ?>" target="_blank" class="hl-agent__bottom-link"><?php echo __('View profile', 'builder') ?></a>
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
	    if ( $settings [ $this->get_control_id( 'is_agent_page' ) ] ) {
            $this->render_post();
	        return;
        }

        $this->parent->query_posts();

        $query = $this->parent->get_query();
        if ( ! $query->found_posts ) {
            return;
        }

        $this->render_agents_top();
            while ( $query->have_posts() ) {
                $query->the_post();

                $website = get_field('agent_website', get_the_ID());

                $this->current_permalink = get_permalink();
                $this->render_post();
            }
        $this->render_agents_bottom();

        wp_reset_postdata();

    }

	protected function render_post() {
      $spec = get_field('agent_specialties', get_the_ID());
      $areas = get_field('agent_service_areas', get_the_ID());
      $email = get_field('agent_email', get_the_ID());
      $position = get_field('agent_position', get_the_ID());
      $com_name = get_field('agent_company_name', get_the_ID());
      $license = get_field('agent_license', get_the_ID());
      $tax = get_field('agent_tax_number', get_the_ID());
      $tel = get_field('agent_mobile', get_the_ID());
      $office_number = get_field('agent_office_number', get_the_ID());
      $language = get_field('agent_language', get_the_ID());
      $website = get_field('agent_website', get_the_ID());

      $this->render_post_header();
          $this->render_avatar();
          $this->render_title();
          $this->render_position();
          $this->render_description();
          $this->render_bottom();
      $this->render_post_footer();
	}
}
