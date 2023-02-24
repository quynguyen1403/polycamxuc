<?php
namespace RTAddons\Widgets;

defined('ABSPATH') || exit; // Abort, If called directly.

use Elementor\{Widget_Base, Controls_Manager, Group_Control_Background};

/**
 * Delimiter widget for Header CPT
 *
 *
 * @category Class
 * @package gostudy-core\includes\elementor
 * @author RaisTheme <help.raistheme@gmail.com>
 * @since 1.0.0
 */
class RT_Header_Delimiter extends Widget_Base
{
    public function get_name()
    {
        return 'rt-header-delimiter';
    }

    public function get_title()
    {
        return esc_html__('RT Delimiter', 'gostudy-core');
    }

    public function get_icon()
    {
        return 'rt-header-delimiter';
    }

    public function get_categories()
    {
        return ['rt-header-modules'];
    }

    public function get_script_depends()
    {
        return [
            'rt-elementor-extensions-widgets',
        ];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_content_general',
            ['label' => esc_html__('General', 'gostudy-core')]
        );

        $this->add_control(
            'delimiter_height',
            [
                'label' => esc_html__('Delimiter Height', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'separator' => 'before',
                'min' => 0,
                'default' => 100,
                'selectors' => [
                    '{{WRAPPER}} .delimiter' => 'height: {{VALUE}}px;',
                ],
            ]
        );

        $this->add_control(
            'delimiter_width',
            [
                'label' => esc_html__('Delimiter Width', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'min' => 0,
                'default' => 1,
                'description' => esc_html__('Values in pixels', 'gostudy-core'),
                'selectors' => [
                    '{{WRAPPER}} .delimiter' => 'width: {{VALUE}}px;',
                ],
            ]
        );

        $this->add_control(
            'delimiter_align',
            [
                'label' => esc_html__('Alignment', 'gostudy-core'),
                'type' => Controls_Manager::CHOOSE,
                'separator' => 'after',
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'gostudy-core'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'gostudy-core'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'gostudy-core'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .delimiter-wrapper' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'delimiter_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .delimiter',
            ]
        );

        $this->add_control(
            'delimiter_margin',
            [
                'label' => esc_html__('Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'separator' => 'before',
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .delimiter' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    public function render()
    { ?>
        <div class="delimiter-wrapper">
            <div class="delimiter"></div>
        </div><?php
    }
}
