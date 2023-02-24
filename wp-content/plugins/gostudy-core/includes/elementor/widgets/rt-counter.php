<?php
/*
 * This template can be overridden by copying it to yourtheme/gostudy-core/elementor/widgets/rt-counter.php.
*/
namespace RTAddons\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\{Widget_Base, Controls_Manager};
use Elementor\{Group_Control_Border, Group_Control_Typography, Group_Control_Box_Shadow, Group_Control_Background};
use RTAddons\Gostudy_Global_Variables as Gostudy_Globals;
use RTAddons\Includes\RT_Icons;

class RT_Counter extends Widget_Base
{
    public function get_name()
    {
        return 'rt-counter';
    }

    public function get_title()
    {
        return esc_html__('RT Counter', 'gostudy-core');
    }

    public function get_icon()
    {
        return 'rt-counter';
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
            'rt_counter_content',
            ['label' => esc_html__('General', 'gostudy-core')]
        );

        RT_Icons::init(
            $this,
            [
                'label' => esc_html__('Counter ', 'gostudy-core'),
                'output' => '',
                'section' => false,
            ]
        );

        $this->add_control(
            'layout',
            [
                'label' => esc_html__('Layout', 'gostudy-core'),
                'type' => 'rt-radio-image',
                'condition' => ['icon_type!' => ''],
                'options' => [
                    'top' => [
                        'title' => esc_html__('Top', 'gostudy-core'),
                        'image' => RT_ELEMENTOR_ADDONS_URL . 'assets/img/rt_elementor_addon/icons/style_def.png',
                    ],
                    'left' => [
                        'title' => esc_html__('Left', 'gostudy-core'),
                        'image' => RT_ELEMENTOR_ADDONS_URL . 'assets/img/rt_elementor_addon/icons/style_left.png',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'gostudy-core'),
                        'image' => RT_ELEMENTOR_ADDONS_URL . 'assets/img/rt_elementor_addon/icons/style_right.png',
                    ],
                ],
                'default' => 'top',
            ]
        );

        $this->add_control(
            'counter_title',
            [
                'label' => esc_html__('Title Text', 'gostudy-core'),
                'type' => Controls_Manager::TEXT,
                'separator' => 'before',
                'label_block' => true,
                'dynamic' => ['active' => true],
                'default' => esc_html__('This is the heading​', 'gostudy-core'),
            ]
        );

        $this->add_control(
            'title_block',
            [
                'label' => esc_html__('Title Full Width', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'start_value',
            [
                'label' => esc_html__('Start Value', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'separator' => 'before',
                'min' => 0,
                'step' => 10,
                'default' => 0,
            ]
        );

        $this->add_control(
            'end_value',
            [
                'label' => esc_html__('End Value', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'min' => 1,
                'step' => 10,
                'default' => 120,
            ]
        );

        $this->add_control(
            'prefix',
            [
                'label' => esc_html__('Counter Prefix', 'gostudy-core'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
            ]
        );

        $this->add_control(
            'suffix',
            [
                'label' => esc_html__('Counter Suffix', 'gostudy-core'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
                'placeholder' => esc_attr__('ex: +', 'gostudy-core'),
            ]
        );

        $this->add_control(
            'speed',
            [
                'label' => esc_html__('Animation Speed', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'min' => 100,
                'step' => 100,
                'default' => 2000,
            ]
        );

        $this->add_responsive_control(
            'alignment',
            [
                'label' => esc_html__('Alignment', 'gostudy-core'),
                'type' => Controls_Manager::CHOOSE,
                'separator' => 'before',
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
                'default' => 'left',
                'prefix_class' => 'a',
            ]
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> GENERAL
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'counter_style_section',
            [
                'label' => esc_html__('General', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'counter_offset',
            [
                'label' => esc_html__('Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .rt-counter' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'counter_padding',
            [
                'label' => esc_html__('Padding', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .rt-counter' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'counter_border_radius',
            [
                'label' => esc_html__('Border Radius', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .rt-counter' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('counter_color_tab');

        $this->start_controls_tab(
            'custom_counter_color_idle',
            ['label' => esc_html__('Idle', 'gostudy-core')]
        );

        $this->add_control(
            'bg_counter_color',
            [
                'label' => esc_html__('Background Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .rt-counter' => 'background-color: {{VALUE}};'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'counter_border',
                'label' => esc_html__('Border Type', 'gostudy-core'),
                'selector' => '{{WRAPPER}} .rt-counter',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'counter_shadow',
                'selector' => '{{WRAPPER}} .rt-counter',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_counter_color_hover',
            ['label' => esc_html__('Hover', 'gostudy-core')]
        );

        $this->add_control(
            'bg_counter_color_hover',
            [
                'label' => esc_html__('Background Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}}:hover .rt-counter' => 'background-color: {{VALUE}};'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'counter_border_hover',
                'label' => esc_html__('Border Type', 'gostudy-core'),
                'selector' => '{{WRAPPER}}:hover .rt-counter',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'counter_shadow_hover',
                'selector' => '{{WRAPPER}}:hover .rt-counter',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> MEDIA
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => esc_html__('Media', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['icon_type!' => ''],
            ]
        );

        $this->add_control(
            'primary_color',
            [
                'label' => esc_html__('Icon Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'condition' => ['icon_type' => 'font'],
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Icon Size', 'gostudy-core'),
                'type' => Controls_Manager::SLIDER,
                'condition' => ['icon_type' => 'font'],
                'range' => [
                    'px' => ['min' => 13, 'max' => 100],
                ],
                'default' => ['size' => 52],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_margin',
            [
                'label' => esc_html__('Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 16,
                    'left' => 0,
                    'unit'  => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .media-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_padding',
            [
                'label' => esc_html__('Padding', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .media-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'counter_icon_border_radius',
            [
                'label' => esc_html__('Border Radius', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .media-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'media_background',
                'label' => esc_html__('Background', 'gostudy-core'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .media-wrapper',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'counter_icon_border',
                'selector' => '{{WRAPPER}} .media-wrapper'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'counter_icon_shadow',
                'selector' => '{{WRAPPER}} .media-wrapper',
            ]
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> VALUE
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'value_style_section',
            [
                'label' => esc_html__('Value', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'value_offset',
            [
                'label' => esc_html__('Value Offset', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .rt-counter_value-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_value',
                'selector' => '{{WRAPPER}} .rt-counter_value-wrap',
            ]
        );

        $this->add_control(
            'value_color',
            [
                'label' => esc_html__('Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .rt-counter_value-wrap' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> TITLE
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'title_style_section',
            [
                'label' => esc_html__('Title', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
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
                    'span' => '‹span›',
                ],
                'default' => 'h3',
            ]
        );

        $this->add_responsive_control(
            'title_offset',
            [
                'label' => esc_html__('Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .rt-counter_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_title',
                'selector' => '{{WRAPPER}} .rt-counter_title',
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
                    '{{WRAPPER}} .rt-counter_title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    public function render()
    {
        $_s = $this->get_settings_for_display();

        $this->add_render_attribute(
            [
                'counter' => [
                    'class' => [
                        'rt-counter',
                        $_s['title_block'] ? 'title-block' : 'title-inline',
                    ],
                ],
                'counter-wrap' => [
                    'class' => [
                        'rt-counter_wrap',
                        $_s['layout'] ? 'rt-layout-' . $_s['layout'] : '',
                    ],
                ],
                'counter_value' => [
                    'class' => 'rt-counter__value',
                    'data-start-value' => $_s['start_value'],
                    'data-end-value' => $_s['end_value'],
                    'data-speed' => $_s['speed'],
                ],
            ]
        );

        // Icon/Image
        ob_start();
        if (!empty($_s['icon_type'])) {
            $icons = new RT_Icons;
            echo $icons->build($this, $_s, []);
        }
        $counter_media = ob_get_clean();

        $_s['prefix'] = !empty($_s['prefix']) ? $_s['prefix'] : '';

        // Render
        echo '<div ', $this->get_render_attribute_string('counter'), '>';
        echo '<div ', $this->get_render_attribute_string('counter-wrap'), '>';
        if ($_s['icon_type'] != '' && $counter_media) {
            echo '<div class="media-wrap">',
                $counter_media,
                '</div>';
        }

        echo '<div class="content-wrap">';
        echo '<div class="rt-counter_value-wrap">';

        if ($_s['prefix']) {
            echo '<span class="rt-counter__prefix">', $_s['prefix'], '</span>';
        }
        if (!empty($_s['end_value'])) {
            echo '<div class="rt-counter__placeholder-wrap">';
            echo '<span class="rt-counter__placeholder">',
                $_s['end_value'],
                '</span>';

            echo '<span ', $this->get_render_attribute_string('counter_value'), '>',
                $_s['start_value'],
                '</span>';
            echo '</div>';
        }
        if (!empty($_s['suffix'])) {
            echo '<span class="rt-counter__suffix">',
                $_s['suffix'],
                '</span>';
        }
        echo '</div>'; // rt-counter_value-wrap

        if (!empty($_s['counter_title'])) {
            echo '<', $_s['title_tag'], ' class="rt-counter_title">',
                $_s['counter_title'],
                '</',
                $_s['title_tag'],
                '>';
        }
        echo '</div>'; // content-wrap
        echo '</div>';
        echo '</div>';
    }
}
