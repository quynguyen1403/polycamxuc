<?php
/*
 * This template can be overridden by copying it to yourtheme/gostudy-core/elementor/widgets/rt-team.php.
 */
namespace RTAddons\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

class RT_CF_Seven extends Widget_Base
{
    public function get_name()
    {
        return 'rt-cf-seven';
    }

    public function get_title()
    {
        return esc_html__('Contact Forms 7', 'gostudy-core');
    }
    public function get_keywords()
    {
        return ['contact form', 'contact', 'contact form', 'contact Form 7', 'wp form', 'wpform'];
    }
    public function get_icon()
    {
        return 'rt-cf-seven';
    }

    public function get_categories()
    {
        return ['rt-extensions'];
    }
    public function rt_contact_form_seven()
    {
        $countactform      = array();
        $htmega_forms_args = array('posts_per_page' => -1, 'post_type' => 'wpcf7_contact_form');
        $htmega_forms      = get_posts($htmega_forms_args);
        if ($htmega_forms) {
            foreach ($htmega_forms as $htmega_form) {
                $countactform[$htmega_form->ID] = $htmega_form->post_title;
            }
        } else {
            $countactform[esc_html__('No contact form found', 'gostudy-core')] = 0;
        }
        return $countactform;
    }
    protected function _register_controls()
    {

        $this->start_controls_section(
            'wpcf7_content',
            [
                'label' => __('Contact Forms 7', 'gostudy-core'),
            ]
        );
        $this->add_control(
            'cf_seven_contact_form_id',
            [
                'label'   => esc_html__('Select Form', 'gostudy-core'),
                'type'    => Controls_Manager::SELECT,
                'options' => $this->rt_contact_form_seven(),
            ]
        );
        $this->add_control(
            'form_subtitle',
            [
                'label'       => __('Form Subtitle', 'rt-core'),
                'type'        => Controls_Manager::TEXT,
                'default'     => 'Send your queries',
            ]
        );
        $this->add_control(
            'form_subtitle_tag',
            [
                'label'   => __('Form Subtitle Tag', 'gostudy-core'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'h1'   => 'H1',
                    'h2'   => 'H2',
                    'h3'   => 'H3',
                    'h4'   => 'H4',
                    'h5'   => 'H5',
                    'h6'   => 'H6',
                    'div'  => 'div',
                    'span' => 'span',
                    'p'    => 'p',
                ],
                'default' => 'p',
            ]
        );

        $this->add_control(
            'form_title',
            [
                'label'       => __('Form Title', 'rt-core'),
                'type'        => Controls_Manager::TEXT,
                'default'     => 'Get in Touch!',
            ]
        );
        $this->add_control(
            'form_title_tag',
            [
                'label'   => __('Form Title Tag', 'gostudy-core'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'h1'   => 'H1',
                    'h2'   => 'H2',
                    'h3'   => 'H3',
                    'h4'   => 'H4',
                    'h5'   => 'H5',
                    'h6'   => 'H6',
                    'div'  => 'div',
                    'span' => 'span',
                    'p'    => 'p',
                ],
                'default' => 'h3',
            ]
        );

        $this->add_control(
            'show_input_icon',
            [
                'label'        => __('Show Input Icon', 'gostudy-core'),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'label_on'     => __('Show', 'gostudy-core'),
                'label_off'    => __('Hide', 'gostudy-core'),
                'return_value' => 'yes',
            ]
        );
        $this->end_controls_section();


        // Style section start
        $this->start_controls_section(
            'wpcf7_style_section',
            [
                'label' => __('Style', 'gostudy-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'wpcf7_heading_bg_color',
            [
                'label'     => __('Background', 'gostudy-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .rt-wpcf7-form-control-wrap' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->start_controls_tabs('body_box_tabs');

        $this->start_controls_tab(
            'body_box_normal_tab',
            [
                'label' => __('Normal', 'gostudy-core'),
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'box_shadow',
                'selector' => '{{WRAPPER}} .rt-wpcf7-form-control-wrap',
            ]
        );

        $this->end_controls_tab(); // Normal Tab end

        $this->start_controls_tab(
            'body_box_hover_tab',
            [
                'label' => __('Hover', 'gostudy-core'),
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            ['label'   => __('Box Shadow Hover', 'gostudy-core'),
                'name'     => 'box_shadow_hover',
                'selector' => '{{WRAPPER}} .rt-wpcf7-form-control-wrap:hover',
            ]
        );

        $this->end_controls_tab(); // Hover Tab end

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'wpcf7_style_padding',
            [
                'label'      => __('Padding', 'gostudy-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .rt-wpcf7-form-control-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'before',
            ]
        );

        // $this->add_responsive_control(
        //     'wpcf7_style_botton_padding',
        //     [
        //         'label'      => __('Submit Padding', 'gostudy-core'),
        //         'type'       => Controls_Manager::DIMENSIONS,
        //         'size_units' => ['px', '%', 'em'],
        //         'selectors'  => [
        //             '{{WRAPPER}} .rt-wpcf7-form-control-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        //         ],
        //         'separator'  => 'before',
        //     ]
        // );

        $this->end_controls_section();

        // Style Title tab section
        $this->start_controls_section(
            'wpcf7_title_style_section',
            [
                'label' => __('Title', 'gostudy-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'description_align',
            [
                'label'     => __('Alignment', 'gostudy'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'  => [
                        'title' => __('Left', 'gostudy'),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center'  => [
                        'title' => __('Center', 'gostudy'),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'gostudy'),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .rt-wpcf7-form-control-wrap .wpcf7-heading-wrap' => 'text-align: {{VALUE}};',
                ],
                'default'   => 'center',
            ]
        );
        $this->add_control(
            'wpcf7_title_color',
            [
                'label'     => __('Color', 'gostudy-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .rt-wpcf7-form-control-wrap .wpcf7-heading-wrap .wpcf7-heading' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'wpcf7_title_typography',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .rt-wpcf7-form-control-wrap .wpcf7-heading-wrap .wpcf7-heading',
            ]
        );

        $this->add_responsive_control(
            'wpcf7_title_padding',
            [
                'label'      => __('Padding', 'gostudy-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .rt-wpcf7-form-control-wrap .wpcf7-heading-wrap .wpcf7-heading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'before',
            ]
        );

        $this->add_responsive_control(
            'wpcf7_title_margin',
            [
                'label'      => __('Margin', 'gostudy-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .rt-wpcf7-form-control-wrap .wpcf7-heading-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section(); // Form title style

        // Label style tab start
        $this->start_controls_section(
            'wpcf7_label_style',
            [
                'label' => __('Label', 'gostudy-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'wpcf7_label_text_color',
            [
                'label'     => __('Color', 'gostudy-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .rt-wpcf7-form-control-wrap label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'wpcf7_label_typography',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .rt-wpcf7-form-control-wrap label',
            ]
        );

        $this->add_responsive_control(
            'wpcf7_label_padding',
            [
                'label'      => __('Padding', 'gostudy-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .rt-wpcf7-form-control-wrap label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'before',
            ]
        );

        $this->add_responsive_control(
            'wpcf7_label_margin',
            [
                'label'      => __('Margin', 'gostudy-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .rt-wpcf7-form-control-wrap label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'before',
            ]
        );

        $this->end_controls_section(); // // Label style tab end

        // Style Input tab section
        $this->start_controls_section(
            'wpcf7_input_style_section',
            [
                'label' => __('Input', 'gostudy-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'wpcf7_input_background_color',
            [
                'label'     => __('Background Color', 'gostudy-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .rt-wpcf7-form-control-wrap input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .rt-wpcf7-form-control-wrap select' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'wpcf7_input_color',
            [
                'label'     => __('Color', 'gostudy-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .rt-wpcf7-form-control-wrap input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .rt-wpcf7-form-control-wrap select' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'wpcf7_input_typography',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_ACCENT,
                ],
                'selector' => '{{WRAPPER}} .rt-wpcf7-form-control-wrap input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .rt-wpcf7-form-control-wrap select',
            ]
        );

        $this->add_responsive_control(
            'wpcf7_input_height',
            [
                'label'      => __('Height', 'gostudy-core'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 1,
                    ],
                ],
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .rt-wpcf7-form-control-wrap input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .rt-wpcf7-form-control-wrap select' => 'height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'wpcf7_input_padding',
            [
                'label'      => __('Padding', 'gostudy-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .rt-wpcf7-form-control-wrap input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file])' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .rt-wpcf7-form-control-wrap select'                                                                                                                => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'before',
            ]
        );

        $this->add_responsive_control(
            'wpcf7_input_margin',
            [
                'label'      => __('Margin', 'gostudy-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .rt-wpcf7-form-control-wrap input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file])' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .rt-wpcf7-form-control-wrap select'                                                                                                                => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'wpcf7_input_border',
                'label'    => __('Border', 'gostudy-core'),
                'selector' => '{{WRAPPER}} .rt-wpcf7-form-control-wrap input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .rt-wpcf7-form-control-wrap select',
            ]
        );

        $this->add_responsive_control(
            'wpcf7_input_border_radius',
            [
                'label'     => esc_html__('Border Radius', 'gostudy-core'),
                'type'      => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .rt-wpcf7-form-control-wrap input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file])' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    '{{WRAPPER}} .rt-wpcf7-form-control-wrap select'                                                                                                                => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                ],
            ]
        );

        $this->end_controls_section(); // Form input style

        // Style Textarea tab section
        $this->start_controls_section(
            'wpcf7_textarea_style_section',
            [
                'label' => __('Textarea', 'gostudy-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'wpcf7_textarea_background_color',
            [
                'label'     => __('Background Color', 'gostudy-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .rt-wpcf7-form-control-wrap textarea' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'wpcf7_textarea_color',
            [
                'label'     => __('Color', 'gostudy-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .rt-wpcf7-form-control-wrap textarea' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'wpcf7_textarea_typography',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_ACCENT,
                ],
                'selector' => '{{WRAPPER}} .rt-wpcf7-form-control-wrap textarea',
            ]
        );

        $this->add_responsive_control(
            'wpcf7_textarea_height',
            [
                'label'      => __('Height', 'gostudy-core'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 500,
                        'step' => 1,
                    ],
                ],
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .rt-wpcf7-form-control-wrap textarea' => 'height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'wpcf7_textarea_padding',
            [
                'label'      => __('Padding', 'gostudy-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .rt-wpcf7-form-control-wrap textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'before',
            ]
        );

        $this->add_responsive_control(
            'wpcf7_textarea_margin',
            [
                'label'      => __('Margin', 'gostudy-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .rt-wpcf7-form-control-wrap textarea' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'wpcf7_textarea_border',
                'label'    => __('Border', 'gostudy-core'),
                'selector' => '{{WRAPPER}} .rt-wpcf7-form-control-wrap textarea',
            ]
        );

        $this->add_responsive_control(
            'wpcf7_textarea_border_radius',
            [
                'label'     => esc_html__('Border Radius', 'gostudy-core'),
                'type'      => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .rt-wpcf7-form-control-wrap textarea' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                ],
            ]
        );

        $this->end_controls_section(); // Form input style

        // Input submit button style tab start
        $this->start_controls_section(
            'wpcf7_inputsubmit_style',
            [
                'label' => __('Button', 'gostudy-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->start_controls_tabs('wpcf7_submit_style_tabs');

        // Button Normal tab start
        $this->start_controls_tab(
            'wpcf7_submit_style_normal_tab',
            [
                'label' => __('Normal', 'gostudy-core'),
            ]
        );
        $this->add_responsive_control(
            'submit_align',
            [
                'label'     => __('Alignment', 'gostudy'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'  => [
                        'title' => __('Left', 'gostudy'),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'none'  => [
                        'title' => __('Center', 'gostudy'),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'gostudy'),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .rt-wpcf7-form-control-wrap input[type="submit"]' => 'float: {{VALUE}};',
                ],
                'default'   => 'left',
            ]
        );
        $this->add_responsive_control(
            'wpcf7_input_submit_width',
            [
                'label'      => __('Width', 'gostudy-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => [
                        'max' => 350,
                    ],
                    '%'  => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors'  => [
                    '{{WRAPPER}} .rt-wpcf7-form-control-wrap input[type="submit"]' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'wpcf7_input_submit_height',
            [
                'label'     => __('Height', 'gostudy-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max' => 150,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .rt-wpcf7-form-control-wrap input[type="submit"]' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'wpcf7_input_submit_typography',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_TEXT,
                ],
                'selector' => '{{WRAPPER}} .rt-wpcf7-form-control-wrap input[type="submit"]',
            ]
        );

        $this->add_control(
            'wpcf7_input_submit_text_color',
            [
                'label'     => __('Color', 'gostudy-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .rt-wpcf7-form-control-wrap input[type="submit"]' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'wpcf7_input_submit_background_color',
            [
                'label'     => __('Background Color', 'gostudy-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .rt-wpcf7-form-control-wrap input[type="submit"]' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'wpcf7_input_submit_padding',
            [
                'label'      => __('Padding', 'gostudy-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .rt-wpcf7-form-control-wrap input[type="submit"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'before',
            ]
        );

        $this->add_responsive_control(
            'wpcf7_input_submit_margin',
            [
                'label'      => __('Margin', 'gostudy-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .rt-wpcf7-form-control-wrap input[type="submit"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'wpcf7_input_submit_border',
                'label'    => __('Border', 'gostudy-core'),
                'selector' => '{{WRAPPER}} .rt-wpcf7-form-control-wrap input[type="submit"]',
            ]
        );

        $this->add_responsive_control(
            'wpcf7_input_submit_border_radius',
            [
                'label'     => esc_html__('Border Radius', 'gostudy-core'),
                'type'      => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .rt-wpcf7-form-control-wrap input[type="submit"]' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'wpcf7_input_submit_box_shadow',
                'label'    => __('Box Shadow', 'gostudy-core'),
                'selector' => '{{WRAPPER}} .rt-wpcf7-form-control-wrap input[type="submit"]',
            ]
        );

        $this->end_controls_tab(); // Button Normal tab end

        // Button Hover tab start
        $this->start_controls_tab(
            'wpcf7_submit_style_hover_tab',
            [
                'label' => __('Hover', 'gostudy-core'),
            ]
        );

        $this->add_control(
            'wpcf7_input_submithover_text_color',
            [
                'label'     => __('Color', 'gostudy-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .rt-wpcf7-form-control-wrap input[type="submit"]:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'wpcf7_input_submithover_background_color',
            [
                'label'     => __('Background Color', 'gostudy-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .rt-wpcf7-form-control-wrap input[type="submit"]:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'wpcf7_input_submithover_border',
                'label'    => __('Border', 'gostudy-core'),
                'selector' => '{{WRAPPER}} .rt-wpcf7-form-control-wrap input[type="submit"]:hover',
            ]
        );

        $this->end_controls_tab(); // Button Hover tab end

        $this->end_controls_tabs();

    }

    protected function render($instance = [])
    {

        $settings = $this->get_settings_for_display();

       if (!$settings['show_input_icon']) {
         $icon_show_hide = 'rt_icon_none';
       } else {
         $icon_show_hide = '';
       }
       

        $this->add_render_attribute('rt_form_area_attr', 'class', 'rt-wpcf7-form-control-wrap');
        $this->add_render_attribute('rt_form_area_attr', 'class', $icon_show_hide);

        ?>
        <div <?php echo $this->get_render_attribute_string('rt_form_area_attr'); ?> >
            <div class="wpcf7-heading-wrap">

               <<?php echo esc_attr($settings['form_subtitle_tag']); ?> class="wpcf7-sub-heading"><?php echo $settings['form_subtitle']; ?></<?php echo esc_attr($settings['form_subtitle_tag']); ?>>

               <<?php echo esc_attr($settings['form_title_tag']); ?> class="wpcf7-heading"><?php echo $settings['form_title']; ?></<?php echo esc_attr($settings['form_title_tag']); ?>>
               
            </div>
            <?php
            if (!empty($settings['cf_seven_contact_form_id'])) {
                echo do_shortcode('[contact-form-7  id="' . $settings['cf_seven_contact_form_id'] . '"]');
            } else {
                echo '<div class="form_no_select">' . __('Please Select contact form.', 'gostudy-core') . '</div>';
            }
        ?>
        </div>
       <?php }

}
