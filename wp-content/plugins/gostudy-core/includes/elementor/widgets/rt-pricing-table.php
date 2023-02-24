<?php
/*
 * This template can be overridden by copying it to yourtheme/gostudy-core/elementor/widgets/rt-pricing-table.php.
*/
namespace RTAddons\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\{Widget_Base, Controls_Manager};
use Elementor\{Core\Schemes\Typography as Typography};
use Elementor\{Group_Control_Border, Group_Control_Typography, Group_Control_Background, Group_Control_Box_Shadow};
use RTAddons\Gostudy_Global_Variables as Gostudy_Globals;
use RTAddons\templates\RT_Button;

class RT_Pricing_Table extends Widget_Base
{
    public function get_name() {
        return 'rt-pricing-table';
    }

    public function get_title() {
        return esc_html__('RT Pricing Table', 'gostudy-core');
    }

    public function get_icon() {
        return 'rt-pricing-table';
    }

    public function get_categories() {
        return [ 'rt-extensions' ];
    }


    protected function register_controls()
    {

        $primary_color = esc_attr(\Gostudy_Theme_Helper::get_option('theme-primary-color'));
        $secondary_color = esc_attr(\Gostudy_Theme_Helper::get_option('theme-secondary-color'));

        /*-----------------------------------------------------------------------------------*/
        /*  CONTENT -> GENERAL
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_content_general',
            [ 'label' => esc_html__('General', 'gostudy-core') ]
        );

        $this->add_responsive_control(
            'p_alignment',
            [
                'label' => esc_html__('Alignment', 'gostudy-core'),
                'type' => Controls_Manager::CHOOSE,
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

        $this->add_control(
            'p_title',
            [
                'label' => esc_html__('Title', 'gostudy-core'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_attr__('Title...', 'gostudy-core'),
                'default' => esc_html__('Basic', 'gostudy-core'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'p_currency',
            [
                'label' => esc_html__('Currency', 'gostudy-core'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_attr__('Currency...', 'gostudy-core'),
                'default' => esc_html__('$', 'gostudy-core'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'p_price',
            [
                'label' => esc_html__('Price', 'gostudy-core'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_attr__('Price...', 'gostudy-core'),
                'default' => esc_html__('99', 'gostudy-core'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'p_period',
            [
                'label' => esc_html__('Period', 'gostudy-core'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_attr__('Period...', 'gostudy-core'),
                'default' => esc_html__('/ PER HOUR', 'gostudy-core'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'p_content',
            [
                'label' => esc_html__('Content', 'gostudy-core'),
                'type' => Controls_Manager::WYSIWYG,
                'label_block' => true,
                'dynamic' => ['active' => true],
                'default' => esc_html__('Your content...', 'gostudy-core'),
            ]
        );

        $this->add_control(
            'p_description',
            [
                'label' => esc_html__('Description', 'gostudy-core'),
                'type' => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'placeholder' => esc_attr__('Description...', 'gostudy-core'),
            ]
        );

        $this->add_control(
            'hover_animation',
            [
                'label' => esc_html__('Enable hover animation', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'description' => esc_html__('Lift up the item on hover.', 'gostudy-core'),
            ]
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  CONTENT -> BUTTON
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_content_button',
            [ 'label' => esc_html__('Button', 'gostudy-core') ]
        );

        $this->add_control(
            'b_switch',
            [
                'label' => esc_html__('Use button?','gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'b_title',
            [
                'label' => esc_html__('Button Text', 'gostudy-core'),
                'type' => Controls_Manager::TEXT,
                'condition' => [ 'b_switch' => 'yes' ],
                'label_block' => true,
                'default' => esc_html__('CHOOSE', 'gostudy-core'),
            ]
        );

        $this->add_control(
            'b_link',
            [
                'label' => esc_html__('Button Link', 'gostudy-core'),
                'type' => Controls_Manager::URL,
                'condition' => [ 'b_switch' => 'yes' ],
                'label_block' => true,
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
                'name' => 'title_typo',
                'selector' => '{{WRAPPER}} .pricing_title',

            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Text Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .pricing_title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_bg',
            [
                'label' => esc_html__('Background Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_secondary_color(),
                'selectors' => [
                    '{{WRAPPER}} .pricing_title' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .pricing_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_padding',
            [
                'label' => esc_html__('Padding', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .pricing_title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => 8,
                    'right' => 14,
                    'bottom'=> 8,
                    'left'  => 14,
                ],
            ]
        );

        $this->add_control(
            'title_border_radius',
            [
                'label' => esc_html__('Border Radius', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'top' => 15,
                    'right' => 15,
                    'bottom'=> 15,
                    'left'  => 15,
                ],
                'selectors' => [
                    '{{WRAPPER}} .pricing_title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'title_border',
                'selector' => '{{WRAPPER}} .pricing_title',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'title_box_shadow',
                'selector' => '{{WRAPPER}} .pricing_title',
                'fields_options' => [
                    'box_shadow_type' => [
                        'default' => 'yes'
                    ],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 5,
                            'vertical' => 4,
                            'blur' => 13,
                            'spread' => 0,
                            'color' => 'rgba('.\Gostudy_Theme_Helper::HexToRGB($secondary_color).', 0.45)',
                        ]
                    ]
                ]
            ]
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> PRICE
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_price',
            [
                'label' => esc_html__('Price', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'pricing_price_typo',
                'selector' => '{{WRAPPER}} .pricing_price_wrap',
            ]
        );

        $this->add_control(
            'custom_price_color',
            [
                'label' => esc_html__('Text Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .pricing_price_wrap' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'price_padding',
            [
                'label' => esc_html__('Padding', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'top' => 30,
                    'right' => 0,
                    'bottom'=> 26,
                    'left'  => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .pricing_price_wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> PERIOD
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_period',
            [
                'label' => esc_html__('Period', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'pricing_period_typo',
                'selector' => '{{WRAPPER}} .pricing_period',
                'fields_options' => [
                    'font_size' => [
                        'default' => [ 'size' => 0.3, 'unit' => 'em' ]
                    ]
                ],
            ]
        );

        $this->add_control(
            'period_color',
            [
                'label' => esc_html__('Text Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_h_font_color(),
                'selectors' => [
                    '{{WRAPPER}} .pricing_period' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'period_padding',
            [
                'label' => esc_html__('Padding', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .pricing_period' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

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
                'name' => 'pricing_content_typo',
                'selector' => '{{WRAPPER}} .pricing_content',
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label' => esc_html__('Text Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_h_font_color(),
                'selectors' => [
                    '{{WRAPPER}} .pricing_content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content-padding',
            [
                'label' => esc_html__('Padding', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .pricing_content' => 'padding-top: {{TOP}}{{UNIT}}; padding-bottom: {{BOTTOM}}{{UNIT}}; padding-left: {{LEFT}}{{UNIT}} !important; padding-right: {{RIGHT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'content_border',
                'selector' => '{{WRAPPER}} .pricing_content',
                'fields_options' => [
                    'border' => [ 'default' => 'solid' ],
                    'width' => [ 'default' => [
                        'top' => 1,
                        'right' => 0,
                        'bottom' => 0,
                        'left' => 0,
                    ] ],
                    'color' => [
                        'default' => '#e5e5e5'
                    ],
                ],
            ]
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> DESCRIPTION
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_description',
            [
                'label' => esc_html__('Description', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [ 'p_description!' => '' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'pricing_desc_typo',
                'selector' => '{{WRAPPER}} .pricing_desc',
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => esc_html__('Text Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_main_font_color(),
                'selectors' => [
                    '{{WRAPPER}} .pricing_desc' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'description_padding',
            [
                'label' => esc_html__('Padding', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .pricing_desc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> BUTTON
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_button',
            [
                'label' => esc_html__('Button', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [ 'b_switch!' => '' ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'selector' => '{{WRAPPER}} .rt-button',
            ]
        );

        $this->start_controls_tabs( 'tabs_button_style' );

        $this->start_controls_tab(
            'tab_button_idle',
            [ 'label' => esc_html__('Idle', 'gostudy-core') ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label' => esc_html__('Text Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .rt-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'b_bg_idle',
            [
                'label' => esc_html__('Background Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => $primary_color,
                'selectors' => [
                    '{{WRAPPER}} .rt-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_box_shadow',
                'selector' => '{{WRAPPER}} .rt-button',
                'fields_options' => [
                    'box_shadow_type' => [
                        'default' => 'yes'
                    ],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 5,
                            'vertical' => 4,
                            'blur' => 13,
                            'spread' => 0,
                            'color' => 'rgba('.\Gostudy_Theme_Helper::HexToRGB($primary_color).', 0.45)',
                        ]
                    ]
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [ 'label' => esc_html__('Hover', 'gostudy-core') ]
        );

        $this->add_control(
            'b_color_hover',
            [
                'label' => esc_html__('Text Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .rt-button:hover, {{WRAPPER}} .rt-button:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'b_bg_hover',
            [
                'label' => esc_html__('Background Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => $secondary_color,
                'selectors' => [
                    '{{WRAPPER}} .rt-button:hover, {{WRAPPER}} .rt-button:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_hover_box_shadow',
                'selector' => '{{WRAPPER}} .rt-button:hover',
                'fields_options' => [
                    'box_shadow_type' => [
                        'default' => 'yes'
                    ],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 5,
                            'vertical' => 4,
                            'blur' => 13,
                            'spread' => 0,
                            'color' => 'rgba('.\Gostudy_Theme_Helper::HexToRGB($secondary_color).', 0.45)',
                        ]
                    ]
                ]
            ]
        );

        $this->add_control(
            'b_hover_border_color',
            [
                'label' => esc_html__('Border Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'condition' => ['border_border!' => ''],
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .rt-button:hover, {{WRAPPER}} .rt-button:focus' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'selector' => '{{WRAPPER}} .rt-button',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'b_border_radius',
            [
                'label' => esc_html__('Border Radius', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rt-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'b_margin',
            [
                'label' => esc_html__('Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'condition' => [ 'b_switch' => 'yes' ],
                'separator' => 'before',
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .rt-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'b_padding',
            [
                'label' => esc_html__('Padding', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'condition' => [ 'b_switch' => 'yes' ],
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rt-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> BACKGROUND
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_bg',
            [
                'label' => esc_html__('Background', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'bg_scheme',
            [
                'label' => esc_html__('Customize for:', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'module' => esc_html__('whole module', 'gostudy-core'),
                    'sections'  => esc_html__('separate sections', 'gostudy-core'),
                ],
                'default' => 'module',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'module',
                'types' => ['classic', 'gradient'],
                'condition' => ['bg_scheme' => 'module'],
                'selector' => '{{WRAPPER}} .pricing_plan_wrap',
                'fields_options' => [
					'background' => ['default' => 'classic'],
					'color' => ['default' => '#ffffff'],
				],
            ]
        );

        $this->add_control(
			'header_s_label',
			[
				'label' => esc_html__('Header Section Background', 'gostudy-core'),
				'type' => Controls_Manager::HEADING,
			]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'header_s',
                'label' => esc_html__('Background', 'gostudy-core'),
                'types' => [ 'classic', 'gradient' ],
                'condition' => [ 'bg_scheme' => 'sections' ],
                'selector' => '{{WRAPPER}} .pricing_header',
                'fields_options' => [
					'background' => [ 'default' => 'classic' ],
					'color' => [ 'default' => Gostudy_Globals::get_primary_color() ],
				],
            ]
        );

        $this->add_control(
            'content_s_bg',
            [
                'label' => esc_html__('Content Section Background', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'condition' => ['bg_scheme' => 'sections'],
                'separator' => 'before',
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .pricing_content' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'footer_s_bg',
            [
                'label' => esc_html__('Footer Section Background', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'condition' => ['bg_scheme' => 'sections'],
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .pricing_footer' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'bg_padding',
            [
                'label' => esc_html__('Padding', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'separator' => 'before',
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'top' => 40,
                    'right' => 40,
                    'bottom' => 40,
                    'left' => 40,
                ],
                'selectors' => [
                    '{{WRAPPER}} .pricing_plan_wrap' => 'padding-left: {{LEFT}}{{UNIT}}; padding-right: {{RIGHT}}{{UNIT}};padding-bottom: {{BOTTOM}}{{UNIT}};padding-top: {{TOP}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'bg_border_radius',
            [
                'label' => esc_html__('Border Radius', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default' => [
                    'top' => 10,
                    'right' => 10,
                    'bottom' => 10,
                    'left' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .pricing_plan_wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'bg_border',
                'selector' => '{{WRAPPER}} .pricing_plan_wrap',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $_s = $this->get_settings_for_display();

        $title = $description = $button = '';

        // Wrapper classes
        $wrap_classes = $_s['hover_animation'] ? ' hover-animation' : '';

        // Title
        if (!empty($_s['p_title'])) {
            $title .= '<div class="pricing_title_wrapper">';
            $title .= '<h4 class="pricing_title">';
                $title .= esc_html($_s['p_title']);
            $title .= '</h4>';
            $title .= '</div>';
        }

        // Currency
        $currency = ! empty($_s['p_currency']) ? '<span class="pricing_currency">' . esc_html($_s['p_currency']) . '</span>' : '';

        // Price
        if ( isset($_s['p_price']) ) {
            $price = '<div class="pricing_price">'.$_s['p_price'].'</div>';
        }

        // Period
        $period = ! empty($_s['p_period']) ? '<span class="pricing_period">' . esc_html($_s['p_period']) . '</span>' : '';

        // Description
        if ( $_s['p_description'] ) {
            $allowed_html = [
                'a' => [
                    'href' => true, 'title' => true,
                    'class' => true, 'style' => true,
                    'rel' => true, 'target' => true
                ],
                'br' => ['class' => true, 'style' => true],
                'em' => ['class' => true, 'style' => true],
                'strong' => ['class' => true, 'style' => true],
                'span' => ['class' => true, 'style' => true],
                'p' => ['class' => true, 'style' => true],
                'ul' => ['class' => true, 'style' => true],
                'ol' => ['class' => true, 'style' => true],
            ];
            $description = '<div class="pricing_desc">'
                . wp_kses($_s['p_description'], $allowed_html)
                . '</div>';
        }

        // Button
        if ( $_s['b_switch'] ) {
            $button_options = [
                'icon_type' => '',
                'text' => $_s['b_title'],
                'link' => $_s['b_link'],
                'size' => 'lg',
            ];
            $button = new RT_Button();
            ob_start();
                echo $button->render($this, $button_options);
            $button = ob_get_clean();
        }

        // Render
        echo '<div class="rt-pricing_plan', $wrap_classes, '">',
            '<div class="pricing_plan_wrap">',
                '<div class="pricing_header">',
                    $title,
                    '<div class="pricing_price_wrap">',
                        $currency,
                        $price,
                        $period,
                    '</div>',
                '</div>',
                '<div class="pricing_content">',
                    $_s['p_content'],
                '</div>',
                '<div class="pricing_footer">',
                    $description,
                    $button,
                '</div>',
            '</div>',
        '</div>';
    }
}
