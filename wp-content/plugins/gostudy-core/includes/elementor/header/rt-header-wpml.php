<?php
namespace RTAddons\Widgets;

defined('ABSPATH') || exit; // Abort, If called directly.

use Elementor\{Widget_Base, Controls_Manager};

/**
 * WPML widget for Header CPT
 *
 *
 * @category Class
 * @package gostudy-core\includes\elementor
 * @author RaisTheme <help.raistheme@gmail.com>
 * @since 1.0.0
 */
class RT_Header_Wpml extends Widget_Base
{
    public function get_name() {
        return 'rt-header-wpml';
    }

    public function get_title() {
        return esc_html__('WPML Selector', 'gostudy-core' );
    }

    public function get_icon() {
        return 'rt-header-wpml';
    }

    public function get_categories() {
        return [ 'rt-header-modules' ];
    }

    public function get_script_depends() {
        return [
            'perfect-scrollbar',
            'rt-elementor-extensions-widgets',
        ];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_navigation_settings',
            [
                'label' => esc_html__( 'WPML Settings', 'gostudy-core' ),
            ]
        );

        $this->add_control(
            'wpml_height',
            array(
                'label' => esc_html__( 'WPML Height', 'gostudy-core' ),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'step' => 1,
                'default' => 100,
                'description' => esc_html__( 'Enter value in pixels', 'gostudy-core' ),
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .sitepress_container' => 'height: {{VALUE}}px;',
                ],
            )
        );

        $this->add_control(
            'wpml_align',
            array(
                'label' => esc_html__( 'Alignment', 'gostudy-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'gostudy-core' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'gostudy-core' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'gostudy-core' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'label_block' => false,
                'default' => 'left',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .sitepress_container' => 'text-align: {{VALUE}};',
                ],
            )
        );

        $this->end_controls_section();
    }

    public function render(){
        if (class_exists('\SitePress')) {
            echo "<div class='sitepress_container'>";
                do_action('wpml_add_language_selector');
            echo "</div>";
        }
    }
}