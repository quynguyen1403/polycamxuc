<?php
/*
 * This template can be overridden by copying it to yourtheme/gostudy-core/elementor/widgets/rt-satellite-service.php.
*/
namespace RTAddons\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\{Widget_Base, Controls_Manager};
use Elementor\{Group_Control_Border, Group_Control_Typography, Group_Control_Box_Shadow, Group_Control_Background};
use RTAddons\Gostudy_Global_Variables as Gostudy_Globals;
use RTAddons\Includes\RT_Icons;

class RT_Satellite_Service extends Widget_Base
{
    public function get_name()
    {
        return 'rt-satellite-service';
    }

    public function get_title()
    {
        return esc_html__('RT Satellite Service', 'gostudy-core');
    }

    public function get_icon()
    {
        return 'rt-services-sat';
    }

    public function get_categories()
    {
        return [ 'rt-extensions' ];
    }


    protected function register_controls()
    {
        /*-----------------------------------------------------------------------------------*/
        /*  Build Icon/Image Box
        /*-----------------------------------------------------------------------------------*/

        $output[ 'media_width' ] = [
            'label' => esc_html__('Media Width (Height)', 'gostudy-core'),
            'type' => Controls_Manager::NUMBER,
            'condition' => [ 'icon_type!' => '' ],
            'separator' => 'before',
            'min' => 50,
            'step' => 1,
            'default' => 110,
            'selectors' => [
                '{{WRAPPER}} .rt-services_media-wrap' => 'width: {{VALUE}}px; height: {{VALUE}}px; line-height: {{VALUE}}px;',
            ],
        ];

        RT_Icons::init(
            $this,
            [
                'output' => $output,
                'section' => true,
            ]
        );

        /*-----------------------------------------------------------------------------------*/
        /*  Content
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'rt_ib_content',
            [
                'label' => esc_html__('Service Content', 'gostudy-core'),
            ]
        );

        $this->add_control(
            'ib_title',
            [
                'label' => esc_html__('Title', 'gostudy-core'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => esc_html__('This is the heading​', 'gostudy-core'),
            ]
        );

        $this->add_control(
            'ib_content',
            [
                'label' => esc_html__('Service Text', 'gostudy-core'),
                'type' => Controls_Manager::WYSIWYG,
                'label_block' => true,
                'dynamic' => ['active' => true],
				'placeholder' => esc_attr__('Description Text', 'gostudy-core'),
                'default' => esc_html__('Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'gostudy-core'),
            ]
        );

        $this->add_control(
            'alignment',
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
                'default' => 'center',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .rt-services_wrap' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_link',
            [ 'label' => esc_html__('Service Link', 'gostudy-core') ]
        );

        $this->add_control(
            'add_item_link',
            [
                'label' => esc_html__('Add Link To Whole Item', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'gostudy-core'),
                'label_off' => esc_html__('Off', 'gostudy-core'),
                'condition' => [ 'add_read_more!' => 'yes' ],
            ]
        );

        $this->add_control(
            'item_link',
            [
                'label' => esc_html__('Link', 'gostudy-core'),
                'type' => Controls_Manager::URL,
                'condition' => [ 'add_item_link' => 'yes' ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'add_read_more',
            [
                'label' => esc_html__('Add \'Read More\' Button', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [ 'add_item_link!' => 'yes' ],
                'label_on' => esc_html__('On', 'gostudy-core'),
                'label_off' => esc_html__('Off', 'gostudy-core'),
            ]
        );

        $this->add_control(
            'read_more_text',
            [
                'label' => esc_html__('Button Text', 'gostudy-core'),
                'type' => Controls_Manager::TEXT,
                'condition' => [ 'add_read_more' => 'yes' ],
                'default' =>  esc_html__('Read More', 'gostudy-core'),
				'label_block' => true,
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => esc_html__('Button Link', 'gostudy-core'),
                'type' => Controls_Manager::URL,
                'condition' => [ 'add_read_more' => 'yes' ],
                'label_block' => true,
            ]
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  Style Section
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => esc_html__('Media', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs(
            'icon_colors',
            [
                'condition' => [ 'icon_type' => 'font' ],
            ]
        );

        $this->start_controls_tab(
            'icon_colors_idle',
            [
                'label' => esc_html__('Idle', 'gostudy-core'),
            ]
        );

        $this->add_control(
            'primary_color',
            [
                'label' => esc_html__('Primary Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_secondary_color(),
                'selectors' => [
                    '{{WRAPPER}} .rt-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'icon_colors_hover',
            [
                'label' => esc_html__('Hover', 'gostudy-core'),
            ]
        );

        $this->add_control(
            'hover_primary_color',
            [
                'label' => esc_html__('Primary Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}}:hover .rt-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control(
            'icon_space',
            [
                'label' => esc_html__('Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rt-services_media-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Size', 'gostudy-core'),
                'type' => Controls_Manager::SLIDER,
                'condition' => [ 'icon_type' => 'font' ],
                'range' => [
                    'px' => [ 'min' => 16, 'max' => 100 ],
                ],
                'default' => [ 'size' => 45, 'unit' => 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .rt-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_size',
            [
                'label' => esc_html__('Width', 'gostudy-core') . ' (%)',
                'type' => Controls_Manager::SLIDER,
                'condition' => [ 'icon_type' => 'image' ],
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [ 'min' => 50, 'max' => 800 ],
                    '%' => [ 'min' => 5, 'max' => 100 ],
                ],
                'default' => [ 'size' => 100, 'unit' => '%' ],
                'tablet_default' => [ 'unit' => '%' ],
                'mobile_default' => [ 'unit' => '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rt-image-box_img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'border_width',
            [
                'label' => esc_html__('Border Width', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'separator' => 'before',
                'default' => [
                    'top' => 1,
                    'right' => 1,
                    'bottom'=> 1,
                    'left' => 1,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .rt-services_media-wrap' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'border_type',
            [
                'label' => esc_html__('Border Type', 'Border Control', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'solid' => esc_html__('Solid', 'Border Control', 'gostudy-core'),
                    'double' => esc_html__('Double', 'Border Control', 'gostudy-core'),
                    'dotted' => esc_html__('Dotted', 'Border Control', 'gostudy-core'),
                    'dashed' => esc_html__('Dashed', 'Border Control', 'gostudy-core'),
                    'groove' => esc_html__('Groove', 'Border Control', 'gostudy-core'),
                ],
                'default' => 'dashed',
                'selectors' => [
                    '{{WRAPPER}} .rt-services_media-wrap' => 'border-style: {{VALUE}};',
                ],
            ]
        );

        $this->start_controls_tabs('border_colors');

        $this->start_controls_tab(
            'border_colors_idle',
            [
                'label' => esc_html__('Idle', 'gostudy-core'),
            ]
        );

        $this->add_control(
            'border_primary_color',
            [
                'label' => esc_html__('Border Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_secondary_color(),
                'selectors' => [
                    '{{WRAPPER}} .rt-services_media-wrap' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'border_colors_hover',
            [
                'label' => esc_html__('Hover', 'gostudy-core'),
            ]
        );

        $this->add_control(
            'border_hover_primary_color',
            [
                'label' => esc_html__('Border Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}}:hover .rt-services_media-wrap' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'circle_width',
            [
                'label' => esc_html__('Circles Width(Height)', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'min' => 2,
                'step' => 1,
                'default' => 8,
                'description' => esc_html__('Enter value in pixels', 'gostudy-core'),
                'condition' => [ 'icon_type!' => '' ],
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .rt-services_circle' => 'width: {{VALUE}}px; height: {{VALUE}}px;',
                ],
            ]
        );

        $this->add_control(
            'circle_color_1',
            [
                'label' => esc_html__('First Circle Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_secondary_color(),
                'selectors' => [
                    '{{WRAPPER}} .rt-services_circle-wrapper:nth-child(1) .rt-services_circle' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'circle_color_2',
            [
                'label' => esc_html__('Second Circle Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_secondary_color(),
                'selectors' => [
                    '{{WRAPPER}} .rt-services_circle-wrapper:nth-child(2) .rt-services_circle' => 'background-color: {{VALUE}};',
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
                    'div' => '‹DIV›',
                    'span' => '‹SPAN›',
                ],
                'default' => 'h3',
            ]
        );

        $this->add_responsive_control(
            'title_offset',
            [
                'label' => esc_html__('Title Offset', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => 15,
                    'right' => 0,
                    'bottom' => 10,
                    'left' => 0,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .rt-services_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_title',
                'selector' => '{{WRAPPER}} .rt-services_title',
            ]
        );


        $this->start_controls_tabs( 'title_color_tab' );

        $this->start_controls_tab(
            'custom_title_color_idle',
            [
                'label' => esc_html__('Idle' , 'gostudy-core'),
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
                    '{{WRAPPER}} .rt-services_title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_title_color_hover',
            [
                'label' => esc_html__('Hover' , 'gostudy-core'),
            ]
        );

        $this->add_control(
            'title_color_hover',
            [
                'label' => esc_html__('Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_h_font_color(),
                'selectors' => [
                    '{{WRAPPER}}:hover .rt-services_title' => 'color: {{VALUE}};',
                    '{{WRAPPER}}:hover .rt-services_title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'content_style_section',
            [
                'label' => esc_html__('Content', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'content_tag',
            [
                'label' => esc_html__('HTML Tag', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'default' => 'div',
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
            ]
        );

        $this->add_responsive_control(
            'content_offset',
            [
                'label' => esc_html__('Content Offset', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom'=> 20,
                    'left' => 0,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .rt-services_text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__('Content Padding', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rt-services_text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'custom_content_mask_color',
                'label' => esc_html__('Background', 'gostudy-core'),
                'types' => [ 'classic', 'gradient' ],
                'condition' => [ 'custom_bg' => 'custom' ],
                'selector' => '{{WRAPPER}} .rt-services_text',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_content',
                'selector' => '{{WRAPPER}} .rt-services_text',
            ]
        );

        $this->start_controls_tabs( 'content_color_tab' );

        $this->start_controls_tab(
            'custom_content_color_idle',
            [
                'label' => esc_html__('Idle' , 'gostudy-core'),
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label' => esc_html__('Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_main_font_color(),
                'selectors' => [
                    '{{WRAPPER}} .rt-services_text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_content_color_hover',
            [
                'label' => esc_html__('Hover' , 'gostudy-core'),
            ]
        );

        $this->add_control(
            'content_color_hover',
            [
                'label' => esc_html__('Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_main_font_color(),
                'selectors' => [
                    '{{WRAPPER}}:hover .rt-services_text' => 'color: {{VALUE}};'
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();


        $this->start_controls_section(
            'button_style_section',
            [
                'label' => esc_html__('Button', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'add_read_more!' => '',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_button',
                'selector' => '{{WRAPPER}} .rt-services_readmore',
            ]
        );

        $this->add_responsive_control(
            'custom_button_padding',
            [
                'label' => esc_html__('Padding', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rt-services_readmore' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'custom_button_margin',
            [
                'label' => esc_html__('Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rt-services_readmore' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'custom_button_border',
            [
                'label' => esc_html__('Border Radius', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rt-services_readmore' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],

            ]
        );

        $this->start_controls_tabs( 'button_color_tab' );

        $this->start_controls_tab(
            'custom_button_color_idle',
            [
                'label' => esc_html__('Idle' , 'gostudy-core'),
            ]
        );

        $this->add_control(
            'button_background',
            [
                'label' => esc_html__('Background Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .rt-services_readmore' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => esc_html__('Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .rt-services_readmore' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'label' => esc_html__('Border Type', 'gostudy-core'),
                'selector' => '{{WRAPPER}} .rt-services_readmore',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_shadow',
                'selector' => '{{WRAPPER}} .rt-services_readmore',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_button_color_hover',
            [
                'label' => esc_html__('Hover' , 'gostudy-core'),
            ]
        );

        $this->add_control(
            'button_background_hover',
            [
                'label' => esc_html__('Background Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .rt-services_readmore:hover' => 'background: {{VALUE}};'
                ],
            ]
        );

        $this->add_control(
            'button_color_hover',
            [
                'label' => esc_html__('Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_secondary_color(),
                'selectors' => [
                    '{{WRAPPER}} .rt-services_readmore:hover' => 'color: {{VALUE}};'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_border_hover',
                'label' => esc_html__('Border Type', 'gostudy-core'),
                'selector' => '{{WRAPPER}} .rt-services_readmore:hover',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_shadow_hover',
                'selector' => '{{WRAPPER}} .rt-services_readmore:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'service_2_style_section',
            [
                'label' => esc_html__('Item', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'service_2_offset',
            [
                'label' => esc_html__('Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rt-services_wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'service_2_padding',
            [
                'label' => esc_html__('Padding', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rt-services_wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'service_2_border_radius',
            [
                'label' => esc_html__('Border Radius', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rt-services_wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'service_2_color_tab' );

        $this->start_controls_tab(
            'custom_service_2_color_idle',
            [
                'label' => esc_html__('Idle' , 'gostudy-core'),
            ]
        );

        $this->add_control(
            'bg_service_2_color',
            [
                'label' => esc_html__('Background Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .rt-services_wrap' => 'background-color: {{VALUE}};'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'service_2_border',
                'label' => esc_html__('Border Type', 'gostudy-core'),
                'selector' => '{{WRAPPER}} .rt-services_wrap',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'service_2_shadow',
                'selector' => '{{WRAPPER}} .rt-services_wrap',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_service_2_color_hover',
            [
                'label' => esc_html__('Hover' , 'gostudy-core'),
            ]
        );

        $this->add_control(
            'bg_service_2_color_hover',
            [
                'label' => esc_html__('Background Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}}:hover .rt-services_wrap' => 'background-color: {{VALUE}};'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'service_2_border_hover',
                'label' => esc_html__('Border Type', 'gostudy-core'),
                'selector' => '{{WRAPPER}}:hover .rt-services_wrap',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'service_2_shadow_hover',
                'selector' => '{{WRAPPER}}:hover .rt-services_wrap',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

    }

    public function render()
    {
        $_s = $this->get_settings_for_display();
        $circle_w = $_s['media_width'];

        $this->add_render_attribute('services', 'class', 'rt-service-sat');

        $this->add_render_attribute('circle_wrap', [
			'class' => [
                'rt-services_circle-wrapper',
            ],
            'style' => [
                'width: '.(round($circle_w/sqrt(2))).'px;',
                'height: '.(round($circle_w/sqrt(2))).'px;',
                'left: '.(($circle_w - round($circle_w/sqrt(2)))/2).'px;',
                'top: '.(($circle_w - round($circle_w/sqrt(2)))/2).'px;',
            ]
        ]);

        $this->add_render_attribute('serv_link', 'class', 'rt-services_readmore');
        if (isset($_s['link']['url'])) $this->add_link_attributes('serv_link', $_s['link']);

        $this->add_render_attribute('item_link', 'class', 'rt-services_item-link');
        if (isset($_s['item_link']['url'])) $this->add_link_attributes('item_link', $_s['item_link']);

        // Allowed HTML tags
        $allowed_html = [
            'a' => [
                'href' => true, 'title' => true,
                'class' => true, 'style' => true,
                'rel' => true, 'target' => true
            ],
            'br' => [ 'class' => true, 'style' => true ],
            'em' => [ 'class' => true, 'style' => true ],
            'strong' => [ 'class' => true, 'style' => true ],
            'span' => [ 'class' => true, 'style' => true ],
            'p' => [ 'class' => true, 'style' => true ]
        ];

        // Icon/Image output
        ob_start();
        if (!empty($_s['icon_type'])) {
            $icons = new RT_Icons;
            echo $icons->build($this, $_s, []);
        }
        $services_media = ob_get_clean();

        ?>
        <div <?php echo $this->get_render_attribute_string('services'); ?>>
            <div class="rt-services_wrap"><?php
                if ($_s[ 'icon_type' ] != '') {?>
                <div class="rt-services_media-wrap">
                    <div <?php echo $this->get_render_attribute_string('circle_wrap'); ?>><div class="rt-services_circle"></div></div>
                    <div <?php echo $this->get_render_attribute_string('circle_wrap'); ?>><div class="rt-services_circle"></div></div><?php
                    if (!empty($services_media)) {
                        echo $services_media;
                    }?>
                </div><?php
                }?>
                <div class="rt-services_content-wrap">
                    <<?php echo $_s['title_tag']; ?> class="rt-services_title"><?php echo wp_kses($_s['ib_title'], $allowed_html);?></<?php echo $_s[ 'title_tag' ]; ?>><?php
                    if (!empty($_s['ib_content'])) {?>
                        <<?php echo $_s['content_tag']; ?> class="rt-services_text"><?php echo wp_kses($_s['ib_content'], $allowed_html);?></<?php echo $_s[ 'content_tag' ]; ?>><?php
                    }
                    if ($_s['add_read_more']) {?>
                        <a <?php echo $this->get_render_attribute_string('serv_link'); ?>><?php echo esc_html($_s['read_more_text']);?></a><?php
                    }?>
                </div><?php
                if ($_s['add_item_link']) {?>
                    <a <?php echo $this->get_render_attribute_string('item_link'); ?>></a><?php
                }?>
            </div>
        </div>

        <?php
    }

}