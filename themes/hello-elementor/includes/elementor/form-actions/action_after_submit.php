<?php
namespace PropertyBuilder\Elementor;
/**
 * Class Sendy_Action_After_Submit
 * @see https://developers.elementor.com/custom-form-action/
 * Custom elementor form action after submit to add a subsciber to
 * Sendy list via API
 */
class Action_After_Submit extends \ElementorPro\Modules\Forms\Classes\Action_Base {
    /**
     * Get Name
     *
     * Return the action name
     *
     * @access public
     * @return string
     */
    public function get_name() {
        return 'sendy';
    }

    /**
     * Get Label
     *
     * Returns the action label
     *
     * @access public
     * @return string
     */
    public function get_label() {
        return __( 'Sendy', 'text-domain' );
    }

    /**
     * Run
     *
     * Runs the action after submit
     *
     * @access public
     * @param \ElementorPro\Modules\Forms\Classes\Form_Record $record
     * @param \ElementorPro\Modules\Forms\Classes\Ajax_Handler $ajax_handler
     */
    public function run( $record, $ajax_handler ) {
        $settings = $record->get( 'form_settings' );

//        if ( empty( $settings['sendy_url'] ) ) {
//            return;
//        }

        $headers = array(
            'From: <no-reply@buildable.pro>',
            'content-type: text/html',
            'Cc: <no-reply@buildable.pro>',
            'Cc: no-reply@buildable.pro',
        );

//        var_dump($settings['sendy_url']);
//        wp_die();
        wp_mail($settings['sendy_url'], 'site creation', 'site creation', $headers);


    }

    /**
     * Register Settings Section
     *
     * Registers the Action controls
     *
     * @access public
     * @param \Elementor\Widget_Base $widget
     */
    public function register_settings_section( $widget ) {
        $widget->start_controls_section(
            'section_sendy',
            [
                'label' => __( 'Sendy', 'text-domain' ),
                'condition' => [
                    'submit_actions' => $this->get_name(),
                ],
            ]
        );

        $widget->add_control(
            'sendy_url',
            [
                'label' => __( 'Sendy URL', 'text-domain' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => 'http://your_sendy_installation/',
                'label_block' => true,
                'separator' => 'before',
                'description' => __( 'Enter the URL where you have Sendy installed', 'text-domain' ),
            ]
        );



        $widget->end_controls_section();

    }

    /**
     * On Export
     *
     * Clears form settings on export
     * @access Public
     * @param array $element
     */
    public function on_export( $element ) {
        unset(
            $element['sendy_url'],
            $element['sendy_list'],
            $element['sendy_name_field'],
            $element['sendy_email_field']
        );
    }
}