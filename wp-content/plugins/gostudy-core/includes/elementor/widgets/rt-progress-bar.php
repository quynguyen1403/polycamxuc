<?php
/*
 * This template can be overridden by copying it to yourtheme/gostudy-core/elementor/widgets/rt-progress-bar.php.
*/
namespace RTAddons\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\{Widget_Base, Controls_Manager};
use Elementor\{Group_Control_Border, Group_Control_Typography, Group_Control_Box_Shadow};
use RTAddons\Gostudy_Global_Variables as Gostudy_Globals;

class RT_Progress_Bar extends Widget_Base
{
    public function get_name()
    {
        return 'rt-progress-bar';
    }

    public function get_title()
    {
        return esc_html__('RT Progress Bar', 'gostudy-core');
    }

    public function get_icon()
    {
        return 'rt-progress-bar';
    }

    public function get_categories()
    {
        return ['rt-extensions'];
    }

    public function get_script_depends()
    {
        return ['jquery-appear'];
    }

    protected function register_controls()
    {
        /*-----------------------------------------------------------------------------------*/
        /*  CONTENT -> GENERAL
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_content_general',
            ['label' => esc_html__('General', 'gostudy-core')]
        );

        $this->add_control(
            'progress_title',
            [
                'label' => esc_html__('Title', 'gostudy-core'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_attr__('ex: My Skill', 'gostudy-core'),
                'default' => esc_html__('My Skill', 'gostudy-core'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'value',
            [
                'label' => esc_html__('Value', 'gostudy-core'),
                'type' => Controls_Manager::SLIDER,
                'default' => ['size' => 50, 'unit' => '%'],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'units',
            [
                'label' => esc_html__('Units', 'gostudy-core'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => esc_attr__('ex: %, px, points, etc.', 'gostudy-core'),
                'default' => esc_html__('%', 'gostudy-core'),
            ]
        );

        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> TITLE
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_title',
            [
                'label' => esc_html__('Title', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'progress_title_typo',
                'selector' => '{{WRAPPER}} .progress_label_wrap',
            ]
        );

        $this->add_control(
            'title_tag',
            [
                'label' => esc_html__('HTML Tag', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => '‹h1›',
                    'h2' => '‹h2›',
                    'h3' => '‹h3›',
                    'h4' => '‹h4›',
                    'h5' => '‹h5›',
                    'h6' => '‹h6›',
                    'div' => '‹div›',
                ],
                'default' => 'div',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_h_font_color(),
                'selectors' => [
                    '{{WRAPPER}} .progress_label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .progress_label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> VALUE
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_value',
            [
                'label' => esc_html__('Value', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'progress_value_typo',
                'selector' => '{{WRAPPER}} .progress_value_wrap',
            ]
        );

        $this->add_control(
            'value_color',
            [
                'label' => esc_html__('Text Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_h_font_color(),
                'selectors' => [
                    '{{WRAPPER}} .progress_value_wrap' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'value_bg',
            [
                'label' => esc_html__('Background Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .progress_value_wrap' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'value_margin',
            [
                'label' => esc_html__('Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .progress_value_wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'value_border_radius',
            [
                'label' => esc_html__('Border Radius', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .progress_value_wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'value_position',
            [
                'label' => esc_html__('Value Position', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'fixed' => esc_html__('Fixed', 'gostudy-core'),
                    'dynamic' => esc_html__('Dynamic', 'gostudy-core'),
                ],
                'default' => 'fixed',
            ]
        );

        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> PROGRESS BAR
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_bar',
            [
                'label' => esc_html__('Bar', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'bar_height_filled',
            [
                'label' => esc_html__('Filled Bar Height', 'gostudy-core'),
                'type' => Controls_Manager::SLIDER,
                'label_block' => true,
                'range' => [
                    'px' => ['min' => 1, 'max' => 50],
                ],
                'default' => ['size' => 6],
                'selectors' => [
                    '{{WRAPPER}} .progress_bar_wrap .progress_bar' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'bar_height_empty',
            [
                'label' => esc_html__('Empty Bar Height', 'gostudy-core'),
                'type' => Controls_Manager::SLIDER,
                'label_block' => true,
                'range' => [
                    'px' => ['min' => 1, 'max' => 50],
                ],
                'default' => ['size' => 6],
                'selectors' => [
                    '{{WRAPPER}} .progress_bar_wrap' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'bar_bg_empty',
            [
                'label' => esc_html__('Empty Bar Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => '#e3eff3',
                'selectors' => [
                    '{{WRAPPER}} .progress_bar_wrap' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'bar_color_filled',
            [
                'label' => esc_html__('Filled Bar Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .progress_bar' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'bar_padding',
            [
                'label' => esc_html__('Padding', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .progress_bar_wrap-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'bar_margin',
            [
                'label' => esc_html__('Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => 13,
                    'right' => 0,
                    'bottom' => 6,
                    'left' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .progress_bar_wrap-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'bar_border_radius',
            [
                'label' => esc_html__('Border Radius', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => 3,
                    'right' => 3,
                    'bottom' => 3,
                    'left' => 3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .progress_bar_wrap,
                    {{WRAPPER}} .progress_bar,
                    {{WRAPPER}} .progress_bar_wrap-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'bar_box_shadow',
                'selector' => '{{WRAPPER}} .progress_bar_wrap',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .progress_bar_wrap-wrap',
            ]
        );

        $this->end_controls_section();
    }

    public function render()
    {
        $_s = $this->get_settings_for_display();

        $this->add_render_attribute('progress_bar', 'class', [
            'rt-progress_bar',
            $_s['value_position'] == 'dynamic' ? 'dynamic-value' : '',
        ]);

        $this->add_render_attribute('bar', [
            'class' => 'progress_bar',
            'data-width' => esc_attr((int)$_s['value']['size']),
        ]);

        $this->add_render_attribute('label', 'class', 'progress_label');

        // Render
        echo '<div ', $this->get_render_attribute_string('progress_bar'), '>';
        echo '<div class="progress_wrap">';

        echo '<div class="progress_label_wrap">';
        if (!empty($_s['progress_title'])) {
            echo '<', esc_attr($_s['title_tag']), ' ',
                $this->get_render_attribute_string('label'),
                '>',
                esc_html($_s['progress_title']),
                '</',
                esc_attr($_s['title_tag']),
                '>';
        }
        echo '<div class="progress_value_wrap">';
        echo '<span class="progress_value">0</span>';
        if (!empty($_s['units'])) {
            echo '<span class="progress_units">',
                esc_html($_s['units']),
                '</span>';
        }
        echo '</div>';
        echo '</div>';

        echo '<div class="progress_bar_wrap-wrap">',
            '<div class="progress_bar_wrap">',
            '<div ',
            $this->get_render_attribute_string('bar'),
            '></div>',
            '</div>',
            '</div>';

        echo '</div>';
        echo '</div>';
    }
}
