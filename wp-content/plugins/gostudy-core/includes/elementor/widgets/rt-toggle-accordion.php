<?php
/*
 * This template can be overridden by copying it to yourtheme/gostudy-core/elementor/widgets/rt-toggle-accordion.php.
*/
namespace RTAddons\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use RTAddons\Includes\RT_Icons;
use RTAddons\Includes\RT_Elementor_Helper;
use Elementor\Frontend;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;


class RT_Toggle_Accordion extends Widget_Base
{
    public function get_name()
    {
        return 'rt-toggle-accordion';
    }

    public function get_title()
    {
        return esc_html__('RT Toggle/Accordion', 'gostudy-core');
    }

    public function get_icon()
    {
        return 'rt-toggle-accordion';
    }

    public function get_categories()
    {
        return ['rt-extensions'];
    }


    protected function register_controls()
    {

        $primary_color = esc_attr(\Gostudy_Theme_Helper::get_option('theme-primary-color'));
        $secondary_color = esc_attr(\Gostudy_Theme_Helper::get_option('theme-secondary-color'));
        $h_font_color = esc_attr(\Gostudy_Theme_Helper::get_option('header-font')['color']);
        $main_font_color = esc_attr(\Gostudy_Theme_Helper::get_option('main-font')['color']);


        /*-----------------------------------------------------------------------------------*/
        /*  CONTENT -> GENERAL
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_content_general',
            ['label' => esc_html__('General', 'gostudy-core')]
        );

        $this->add_control(
            'acc_type',
            [
                'label' => esc_html__('Type', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'accordion' => esc_html__('Accordion', 'gostudy-core'),
                    'toggle' => esc_html__('Toggle', 'gostudy-core'),
                ],
                'default' => 'accordion',
            ]
        );

        $this->add_control(
            'heading_desktop',
            [
                'label' => esc_html__('Icon Settings', 'gostudy-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'enable_acc_icon',
            [
                'label' => esc_html__('Icon', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'none' => esc_html__('None', 'gostudy-core'),
                    'plus' => esc_html__('Plus/Minus', 'gostudy-core'),
                    'custom' => esc_html__('Custom', 'gostudy-core'),
                ],
                'default' => 'plus',
            ]
        );

        $this->add_control(
            'icon_style',
            [
                'label' => esc_html__('Style', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => ['enable_acc_icon!' => 'none'],
                'options' => [
                    'default' => esc_html__('Default', 'gostudy-core'),
                    'stacked' => esc_html__('Stacked', 'gostudy-core'),
                    'framed' => esc_html__('Framed', 'gostudy-core'),
                ],
                'default' => 'default',
                'prefix_class' => 'elementor-view-'
            ]
        );

        $this->add_control(
            'acc_icon',
            [
                'label' => esc_html__('Choose Icon', 'gostudy-core'),
                'type' => Controls_Manager::ICON,
                'condition' => ['enable_acc_icon' => 'custom'],
                'label_block' => true,
                'include' => [
                    'flaticon flaticon-play',
                    'fa fa-chevron-right',
                    'fa fa-plus',
                    'fa fa-long-arrow-right',
                    'fa fa-chevron-circle-right',
                    'fa fa-arrow-right',
                    'fa fa-arrow-circle-right',
                    'fa fa-angle-right',
                    'fa fa-angle-double-right',
                ],
                'default' => 'flaticon flaticon-play',
            ]
        );

        $this->add_control(
            'icon_alignment',
            [
                'label' => esc_html__('Icon Position', 'gostudy-core'),
                'type' => Controls_Manager::CHOOSE,
                'condition' => ['enable_acc_icon!' => 'none'],
                'options' => [
                    'order: 1' => [
                        'title' => esc_html__('Left', 'gostudy-core'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'order: 0; flex-grow: 1' => [
                        'title' => esc_html__('Right', 'gostudy-core'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => 'order: 0; flex-grow: 1',
                'selectors' => [
                    '{{WRAPPER}} .rt-accordion_title' => '{{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  CONTENT -> CONTENT
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_content_content',
            ['label' => esc_html__('Content', 'gostudy-core')]
        );

        $this->add_responsive_control(
            'tab_panel_margin',
            [
                'label' => esc_html__('Tab Panel Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 10,
                    'left' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .rt-accordion_panel' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'label' => 'Tab Panel Shadow',
                'name' => 'acc_tab_panel_shadow',
                'selector' => '{{WRAPPER}} .rt-accordion_panel',
            ]
        );

        $repeater = new Repeater();
        $repeater->add_control(
			'acc_tab_title',
			[
                'label' => esc_html__('Tab Title', 'gostudy-core'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__('Tab Title', 'gostudy-core'),
                'dynamic' => ['active' => true],
			]
        );
        $repeater->add_control(
			'acc_tab_title_pref',
			[
                'label' => esc_html__('Title Prefix', 'gostudy-core'),
                'type' => Controls_Manager::TEXT,
			]
        );
        $repeater->add_control(
			'acc_tab_def_active',
			[
                'label' => esc_html__('Active as Default', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
			]
        );
        $repeater->add_control(
			'acc_content_type',
			[
                'label' => esc_html__('Content Type', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'content' => esc_html__('Content', 'gostudy-core'),
                    'template' => esc_html__('Saved Templates', 'gostudy-core'),
                ],
                'default' => 'content',
			]
        );
        $repeater->add_control(
			'acc_content_templates',
			[
                'label' => esc_html__('Choose Template', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'options' => RT_Elementor_Helper::get_instance()->get_elementor_templates(),
                'condition' => [
                    'acc_content_type' => 'template',
                ],
			]
        );
        $repeater->add_control(
			'acc_content',
			[
                'label' => esc_html__('Tab Content', 'gostudy-core'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio, neque qui velit. Magni dolorum quidem ipsam eligendi, totam, facilis laudantium cum accusamus ullam voluptatibus commodi numquam, error, est. Ea, consequatur.', 'gostudy-core'),
                'dynamic' => ['active' => true],
                'condition' => [
                    'acc_content_type' => 'content',
                ],
			]
        );

        $this->add_control(
            'acc_tab',
            [
                'type' => Controls_Manager::REPEATER,
                'seperator' => 'before',
                'default' => [
                    [
                        'acc_tab_title' => esc_html__('Tab Title 1', 'gostudy-core'),
                        'acc_tab_def_active' => 'yes'
                    ],
                    ['acc_tab_title' => esc_html__('Tab Title 2', 'gostudy-core')],
                    ['acc_tab_title' => esc_html__('Tab Title 3', 'gostudy-core')],
                ],
                'fields' => $repeater->get_controls(),
                'title_field' => '{{acc_tab_title}}',
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
                'name' => 'acc_title_typo',
                'selector' => '{{WRAPPER}} .rt-accordion_title',
            ]
        );

        $this->add_control(
            'acc_title_tag',
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
                'default' => 'h4',
            ]
        );

        $this->add_responsive_control(
            'title_padding',
            [
                'label' => esc_html__('Padding', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '13',
                    'right' => '20',
                    'bottom' => '13',
                    'left' => '30',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .rt-accordion_header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'acc_title_margin',
            [
                'label' => esc_html__('Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .rt-accordion_header' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('acc_header_tabs');

        $this->start_controls_tab(
            'acc_header_idle',
            ['label' => esc_html__('Idle', 'gostudy-core')]
        );

        $this->add_control(
            'acc_title_color',
            [
                'label' => esc_html__('Title Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $h_font_color,
                'selectors' => [
                    '{{WRAPPER}} .rt-accordion_header' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'acc_title_bg_color_idle',
            [
                'label' => esc_html__('Background Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#f5f3f4',
                'selectors' => [
                    '{{WRAPPER}} .rt-accordion_header' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'acc_title_border_radius',
            [
                'label' => esc_html__('Border Radius', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => '5',
                    'right' => '5',
                    'bottom' => '5',
                    'left' => '5',
                    'unit'  => 'px',
                    'isLinked' => true
                ],
                'selectors' => [
                    '{{WRAPPER}} .rt-accordion_header' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'acc_title_shadow_radius',
                'selector' => '{{WRAPPER}} .rt-accordion_header',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_shadow',
                'selector' => '{{WRAPPER}} .rt-accordion_header',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'acc_header_hover',
            ['label' => esc_html__('Hover', 'gostudy-core')]
        );

        $this->add_control(
            'title_color_hover',
            [
                'label' => esc_html__('Title Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .rt-accordion_header:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_bg_color_hover',
            [
                'label' => esc_html__('Background Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $primary_color,
                'selectors' => [
                    '{{WRAPPER}} .rt-accordion_header:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'acc_title_border_radius_hover',
            [
                'label' => esc_html__('Border Radius', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .rt-accordion_header:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'acc_title_border_hover',
                'selector' => '{{WRAPPER}} .rt-accordion_header:hover',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'acc_title_shadow_hover',
                'selector' => '{{WRAPPER}} .rt-accordion_header:hover',
                'fields_options' => [
                    'box_shadow_type' => [
                        'default' => 'yes'
                    ],
                    // 'box_shadow' => [
                    //     'default' => [
                    //         'horizontal' => 5,
                    //         'vertical' => 4,
                    //         'blur' => 13,
                    //         'spread' => 0,
                    //         'color' => 'rgba('.\Gostudy_Theme_Helper::HexToRGB($primary_color).', 0.45)',
                    //     ]
                    // ]
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'acc_header_active',
            ['label' => esc_html__('Active', 'gostudy-core')]
        );

        $this->add_control(
            'acc_title_color_active',
            [
                'label' => esc_html__('Title Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .rt-accordion_header.active' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'acc_title_bg_color_active',
            [
                'label' => esc_html__('Background Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $primary_color,
                'selectors' => [
                    '{{WRAPPER}} .rt-accordion_header.active' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'acc_title_border_radius_active',
            [
                'label' => esc_html__('Border Radius', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .rt-accordion_header.active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'acc_title_border_active',
                'selector' => '{{WRAPPER}} .rt-accordion_header.active',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'acc_title_shadow_active',
                'selector' => '{{WRAPPER}} .rt-accordion_header.active',
                'fields_options' => [
                    'box_shadow_type' => [
                        'default' => 'yes'
                    ],
                    // 'box_shadow' => [
                    //     'default' => [
                    //         'horizontal' => 5,
                    //         'vertical' => 4,
                    //         'blur' => 13,
                    //         'spread' => 0,
                    //         'color' => 'rgba('.\Gostudy_Theme_Helper::HexToRGB($primary_color).', 0.45)',
                    //     ]
                    // ]
                ]
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> TITLE PREFIX
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_title_pref',
            [
                'label' => esc_html__('Title Prefix', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'acc_title_pref_typo',
                'selector' => '{{WRAPPER}} .rt-accordion_title .rt-accordion_title-prefix',
            ]
        );


        $this->start_controls_tabs('acc_header_pref_tabs');

        $this->start_controls_tab(
            'acc_header_pref_idle',
            ['label' => esc_html__('Idle', 'gostudy-core')]
        );

        $this->add_control(
            'acc_title_pref_color_idle',
            [
                'label' => esc_html__('Text Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .rt-accordion_header .rt-accordion_title-prefix' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'acc_header_pref_hover',
            ['label' => esc_html__('Hover', 'gostudy-core')]
        );

        $this->add_control(
            'title_pref_color_hover',
            [
                'label' => esc_html__('Text Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .rt-accordion_header:hover .rt-accordion_title-prefix' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();


        $this->start_controls_tab(
            'acc_header_pref_active',
            ['label' => esc_html__('Active', 'gostudy-core')]
        );

        $this->add_control(
            'acc_title_pref_color_active',
            [
                'label' => esc_html__('Text Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .rt-accordion_header.active .rt-accordion_title-prefix' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> ICON
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => esc_html__('Icon', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'acc_icon_size',
            [
                'label' => esc_html__('Icon Size', 'gostudy-core'),
                'type' => Controls_Manager::SLIDER,
                'condition' => ['enable_acc_icon' => 'custom'],
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => ['min' => 1, 'max' => 100],
                ],
                'default' => ['size' => 9, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}} .rt-accordion_icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'acc_icon_margin',
            [
                'label' => esc_html__('Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .rt-accordion_icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'acc_icon_padding',
            [
                'label' => esc_html__('Padding', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .rt-accordion_icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_border_width',
            [
                'label' => esc_html__('Border Width', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .rt-accordion_icon' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_border_radius',
            [
                'label' => esc_html__('Border Radius', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .rt-accordion_icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('acc_icon_tabs');

        $this->start_controls_tab(
            'acc_icon_idle',
            ['label' => esc_html__('Idle', 'gostudy-core')]
        );

        $this->add_control(
            'icon_color_idle',
            [
                'label' => esc_html__('Icon Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $primary_color,
                'selectors' => [
                    '{{WRAPPER}} .rt-accordion_icon:before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .icon-plus .rt-accordion_icon:before,{{WRAPPER}} .icon-plus .rt-accordion_icon:after' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_bg_color_idle',
            [
                'label' => esc_html__('Background Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-accordion_icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_border_color_idle',
            [
                'label' => esc_html__('Border Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-accordion_icon' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'icon_idle',
                'selector' => '{{WRAPPER}} .rt-accordion_icon',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'acc_icon_hover',
            ['label' => esc_html__('Hover', 'gostudy-core')]
        );

        $this->add_control(
            'acc_icon_color_hover',
            [
                'label' => esc_html__('Icon Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .rt-accordion_header:hover .rt-accordion_icon:before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .icon-plus .rt-accordion_header:hover .rt-accordion_icon:before, {{WRAPPER}} .icon-plus .rt-accordion_header:hover .rt-accordion_icon:after' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_bg_color_hover',
            [
                'label' => esc_html__('Background Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-accordion_header:hover .rt-accordion_icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_border_color_hover',
            [
                'label' => esc_html__('Border Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-accordion_header:hover .rt-accordion_icon' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'icon_hover',
                'selector' => '{{WRAPPER}} .rt-accordion_header:hover .rt-accordion_icon',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'acc_icon_active',
            ['label' => esc_html__('Active', 'gostudy-core')]
        );

        $this->add_control(
            'icon_color_active',
            [
                'label' => esc_html__('Icon Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .rt-accordion_header.active .rt-accordion_icon:before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .icon-plus .rt-accordion_header.active .rt-accordion_icon:before, {{WRAPPER}} .icon-plus .rt-accordion_header.active .rt-accordion_icon:after' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_bg_color_active',
            [
                'label' => esc_html__('Background Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-accordion_header.active .rt-accordion_icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_border_color_active',
            [
                'label' => esc_html__('Border Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-accordion_header.active .rt-accordion_icon' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'icon_active',
                'selector' => '{{WRAPPER}} .rt-accordion_header.active .rt-accordion_icon',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> CONTENT
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_content',
            [
                'label' => esc_html__('Content', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'acc_content_typo',
                'selector' => '{{WRAPPER}} .rt-accordion_content',
            ]
        );

        $this->add_responsive_control(
            'acc_content_padding',
            [
                'label' => esc_html__('Padding', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '21',
                    'right' => '25',
                    'bottom' => '10',
                    'left' => '20',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .rt-accordion_content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'acc_content_margin',
            [
                'label' => esc_html__('Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .rt-accordion_content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'acc_content_color',
            [
                'label' => esc_html__('Text Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $main_font_color,
                'selectors' => [
                    '{{WRAPPER}} .rt-accordion_content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'acc_content_bg_color',
            [
                'label' => esc_html__('Background Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .rt-accordion_content' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'acc_content_border_radius',
            [
                'label' => esc_html__('Border Radius', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .rt-accordion_content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'acc_content_border',
                'selector' => '{{WRAPPER}} .rt-accordion_content',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $_s = $this->get_settings_for_display();
        $id_int = substr($this->get_id_int(), 0, 3);

        $this->add_render_attribute(
            'accordion',
            [
                'class' => [
                    'rt-accordion',
                    'icon-' . $_s['enable_acc_icon'],
                ],
                'id' => 'rt-accordion-' . esc_attr($this->get_id()),
                'data-type' => $_s['acc_type'],
            ]
        );

        echo '<div ', $this->get_render_attribute_string('accordion'), '>';

        foreach ($_s['acc_tab'] as $index => $item) :

            $tab_count = $index + 1;

            $tab_title_key = $this->get_repeater_setting_key('acc_tab_title', 'acc_tab', $index);

            $this->add_render_attribute(
                $tab_title_key,
                [
                    'id' => 'rt-accordion_header-' . $id_int . $tab_count,
                    'class' => ['rt-accordion_header'],
                    'data-default' => $item['acc_tab_def_active'],
                ]
            );

            echo '<div class="rt-accordion_panel">';
            echo '<', $_s['acc_title_tag'], ' ', $this->get_render_attribute_string($tab_title_key), '>';

            echo '<span class="rt-accordion_title">';
            if (!empty($item['acc_tab_title_pref'])) {
                echo '<span class="rt-accordion_title-prefix">',
                    $item['acc_tab_title_pref'],
                    '</span>';
            }
            echo $item['acc_tab_title'];
            echo '</span>'; // _title

            if ($_s['enable_acc_icon'] != 'none') {
                echo '<i class="rt-accordion_icon elementor-icon ', $_s['acc_icon'], '"></i>';
            }

            echo '</', $_s['acc_title_tag'], '>';

            echo '<div class="rt-accordion_content">';

            if ($item['acc_content_type'] == 'content') {
                echo do_shortcode($item['acc_content']);
            } elseif ($item['acc_content_type'] == 'template') {
                $id = $item['acc_content_templates'];
                $rt_frontend = new Frontend;
                echo $rt_frontend->get_builder_content_for_display($id, true);
            }

            echo '</div>'; // _content

            echo '</div>'; // _panel

        endforeach;

        echo '</div>';
    }
}
