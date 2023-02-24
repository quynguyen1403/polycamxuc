<?php

namespace MasterAddons\Modules;

use \Elementor\Element_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Background;

use \MasterAddons\Inc\Classes\JLTMA_Extension_Prototype;

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
};

/**
 * Reveals - Opening effect
 */

class JLTMA_Extension_Reveal extends JLTMA_Extension_Prototype
{

    private static $instance = null;
    public $name = 'Reveal';
    public $has_controls = true;

    public $common_sections_actions = array(
        array(
            'element' => 'common',
            'action' => '_section_style',
        ),

        array(
            'element' => 'column',
            'action' => 'section_advanced',
        ),
    );

    public function jltma_add_reveal_scripts()
    {
        wp_enqueue_script('ma-el-anime-lib');
        wp_enqueue_script('ma-el-reveal-lib', JLTMA_URL . '/assets/vendor/reveal/revealFx.js', array('ma-el-anime-lib', 'jquery'), JLTMA_VER, true);
    }

    protected function add_actions()
    {

        // Activate controls for widgets
        add_action('elementor/element/common/jltma_section_reveal_advanced/before_section_end', function ($element, $args) {
            $this->add_controls($element, $args);
        }, 10, 2);

        add_filter('elementor/widget/print_template', array($this, 'reveal_print_template'), 9, 2);

        add_action('elementor/widget/render_content', array($this, 'reveal_render_template'), 9, 2);

        // add_action( 'elementor/editor/before_enqueue_scripts', [ $this, 'before_render'],10);
        add_action('elementor/frontend/element/before_render', [$this, 'before_render'], 10, 1);
        // add_action( 'elementor/frontend/column/before_render', [ $this, 'before_render'],10,1);
        // add_action( 'elementor/frontend/section/before_render', [ $this, 'before_render'],10,1);
        add_action('elementor/frontend/widget/before_render', [$this, 'before_render'], 10, 1);

        add_action('elementor/preview/enqueue_scripts', [$this, 'jltma_add_reveal_scripts']);

        // Activate controls for columns
        add_action('elementor/element/column/jltma_section_reveal_advanced/before_section_end', function ($element, $args) {
            $this->add_controls($element, $args);
        }, 10, 2);
    }

    private function add_controls($element, $args)
    {

        $element_type = $element->get_type();

        $element->add_control(
            'enabled_reveal',
            [
                'label' => __('Enabled Reveal', 'master-addons' ),
                'type' => Controls_Manager::SWITCHER,
                'default' => '',
                'label_on' => __('Yes', 'master-addons' ),
                'label_off' => __('No', 'master-addons' ),
                'return_value' => 'yes',
                'frontend_available' => true
            ]
        );
        $element->add_control(
            'reveal_direction',
            [
                'label' => __('Direction', 'master-addons' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'c',
                'options' => [
                    'c' => __('Center', 'master-addons' ),
                    'lr' => __('Left to Right', 'master-addons' ),
                    'rl' => __('Right to Left', 'master-addons' ),
                    'tb' => __('Top to Bottom', 'master-addons' ),
                    'bt' => __('Bottom to top', 'master-addons' ),
                ],
                'frontend_available' => true,
                'condition' => [
                    'enabled_reveal' => 'yes'
                ]
            ]
        );
        $element->add_control(
            'reveal_speed',
            [
                'label' => __('Speed', 'master-addons' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 0.1
                    ],
                ],
                'default' => [
                    'size' => 5,

                ],
                'frontend_available' => true,
                'condition' => [
                    'enabled_reveal' => 'yes'
                ]
            ]
        );
        $element->add_control(
            'reveal_delay',
            [
                'label' => __('Delay', 'master-addons' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 20,
                        'step' => 0.1
                    ],
                ],
                'default' => [
                    'size' => 0,

                ],
                'frontend_available' => true,
                'condition' => [
                    'enabled_reveal' => 'yes'
                ]
            ]
        );
        // $element->add_control(
        //     'reveal_bgcolor', [
        //         'label' => __('Color', 'master-addons' ),
        //         'type' => Controls_Manager::COLOR,
        //         'frontend_available' => true,
        //         'condition' => [
        //             'enabled_reveal' => 'yes'
        //         ]
        //     ]
        // );


        $element->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'                  => 'reveal_bgcolor',
                'label'                 => __('Background', 'master-addons' ),
                'types'                 => ['classic', 'gradient'],
                'exclude'               => ['image'],
                'frontend_available'    => true,
                'condition'             => [
                    'enabled_reveal' => 'yes'
                ]
                // 'selector'              => '{{WRAPPER}} .ma-el-gravity-form .gform_wrapper .gf_progressbar_percentage'
            ]
        );
    }

    public function before_render(\Elementor\Element_Base $element)
    {
        $settings = $element->get_settings();

        if (isset($settings['enabled_reveal']) && $settings['enabled_reveal'] == 'yes') {
            $this->jltma_add_reveal_scripts();
        }
    }


    public function reveal_print_template($content, $widget)
    {
        if (!$content)
            return '';

        $id_item = $widget->get_id();

        $content = "<# if ( '' !== settings.enabled_reveal ) { #><div id=\"reveal-{{id}}\" class=\"reveal\">" . $content . "</div><# } else { #>" . $content . "<# } #>";
        return $content;
    }

    public function reveal_render_template($content, $widget)
    {
        $settings = $widget->get_settings_for_display();

        if ($settings['enabled_reveal']) {

            $this->_enqueue_alles();

            if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
            }

            $id_item = $widget->get_id();
            $content = '<div id="reveal-' . esc_attr($id_item) . '" class="revealFx">' . $content . '</div>';
        }
        return $content;
    }


    public static function get_instance()
    {
        if (!self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }
}

JLTMA_Extension_Reveal::get_instance();
