<?php
/*
 * This template can be overridden by copying it to yourtheme/gostudy-core/elementor/widgets/rt-wpfroms.php.
 */
namespace RTAddons\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

class RT_WPForms extends Widget_Base
{
    public function get_name()
    {
        return 'rt-wpfroms';
    }

    public function get_title()
    {
        return esc_html__('WPForms', 'gostudy-core');
    }
    public function get_keywords()
    {
        return ['contact form', 'contact', 'contact form', 'contact Form 7', 'wp form', 'wpform'];
    }
    public function get_icon()
    {
        return 'rt-wpfroms';
    }

    public function get_categories()
    {
        return ['rt-extensions'];
    }
    public function rt_wpforms_forms()
    {
        $formlist   = array();
        $forms_args = array('posts_per_page' => -1, 'post_type' => 'wpforms');
        $forms      = get_posts($forms_args);
        if ($forms) {
            foreach ($forms as $form) {
                $formlist[$form->ID] = $form->post_title;
            }
        } else {
            $formlist[__('Form not found', 'gostudy-core')] = 0;
        }
        return $formlist;
    }
    protected function _register_controls()
    {

        $this->start_controls_section(
            'wpforms_content',
            [
                'label' => __('WPForms', 'gostudy-core'),
            ]
        );
        $this->add_control(
            'contact_form_list',
            [
                'label'       => esc_html__('Select Form', 'gostudy-core'),
                'type'        => Controls_Manager::SELECT,
                'label_block' => true,
                'options'     => $this->rt_wpforms_forms(),
                'default'     => '0',
            ]
        );

        $this->add_control(
            'show_form_title',
            [
                'label'        => __('Title', 'gostudy-core'),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => 'yes',
                'label_on'     => __('Show', 'gostudy-core'),
                'label_off'    => __('Hide', 'gostudy-core'),
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'show_form_description',
            [
                'label'        => __('Description', 'gostudy-core'),
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
            'wpforms_style_section',
            [
                'label' => __('Style', 'gostudy-elements'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'wpforms_heading_bg_color',
            [
                'label'     => __('Header Background', 'gostudy-elements'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .rt-wpforms-wrapper .wpforms-container .wpforms-head-container' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->start_controls_tabs('body_box_tabs');

        $this->start_controls_tab(
            'body_box_normal_tab',
            [
                'label' => __('Normal', 'gostudy-elements'),
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'box_shadow',
                'selector' => '{{WRAPPER}} .rt-wpforms-wrapper',
            ]
        );

        $this->end_controls_tab(); // Normal Tab end

        $this->start_controls_tab(
            'body_box_hover_tab',
            [
                'label' => __('Hover', 'gostudy-elements'),
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            ['label'   => __('Box Shadow Hover', 'gostudy-elements'),
                'name'     => 'box_shadow_hover',
                'selector' => '{{WRAPPER}} .rt-wpforms-wrapper:hover',
            ]
        );

        $this->end_controls_tab(); // Hover Tab end

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'wpforms_style_padding',
            [
                'label'      => __('Padding', 'gostudy-elements'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .rt-wpforms-wrapper .wpforms-container .wpforms-field-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'before',
            ]
        );

        $this->add_responsive_control(
            'wpforms_style_botton_padding',
            [
                'label'      => __('Submit Padding', 'gostudy-elements'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .rt-wpforms-wrapper div.wpforms-container.wpforms-container-full .wpforms-form .wpforms-submit-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'before',
            ]
        );
        $this->add_responsive_control(
            'wpforms_heading_padding',
            [
                'label'      => __('Heading Padding', 'gostudy-elements'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .rt-wpforms-wrapper .wpforms-container .wpforms-head-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'before',
            ]
        );
        $this->end_controls_section();

        // Style Title tab section
        $this->start_controls_section(
            'wpforms_title_style_section',
            [
                'label'     => __('Title', 'gostudy-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_form_title' => 'yes',
                ],
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
                    '{{WRAPPER}} .wpforms-container .wpforms-description'                                       => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .rt-wpforms-wrapper .wpforms-container .wpforms-head-container .wpforms-title' => 'text-align: {{VALUE}};',
                ],
                'default'   => 'center',
            ]
        );
        $this->add_control(
            'wpforms_title_color',
            [
                'label'     => __('Color', 'gostudy-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .wpforms-container .wpforms-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'wpforms_title_typography',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .wpforms-container .wpforms-title',
            ]
        );

        $this->add_responsive_control(
            'wpforms_title_padding',
            [
                'label'      => __('Padding', 'gostudy-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .wpforms-container .wpforms-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'before',
            ]
        );
        $this->add_responsive_control(
            'wpforms_title_margin',
            [
                'label'      => __('Margin', 'gostudy-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .wpforms-container .wpforms-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section(); // Form title style

        // Style Description tab section
        $this->start_controls_section(
            'wpforms_description_style_section',
            [
                'label'     => __('Description', 'gostudy-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_form_description' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'wpforms_description_color',
            [
                'label'     => __('Color', 'gostudy-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .wpforms-container .wpforms-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'wpforms_description_typography',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .wpforms-container .wpforms-description',
            ]
        );

        $this->add_responsive_control(
            'wpforms_description_padding',
            [
                'label'      => __('Padding', 'gostudy-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .wpforms-container .wpforms-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'before',
            ]
        );
        $this->add_responsive_control(
            'wpforms_description_margin',
            [
                'label'      => __('Margin', 'gostudy-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .wpforms-container .wpforms-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section(); // Form Description style

        // Label style tab start
        $this->start_controls_section(
            'wpforms_label_style',
            [
                'label' => __('Label', 'gostudy-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        // $this->add_control(
        //     'wpforms_label_background',
        //     [
        //         'label'     => __( 'Background', 'gostudy-core' ),
        //         'type'      => Controls_Manager::COLOR,
        //         'default' => '',
        //         'selectors' => [
        //             '{{WRAPPER}} .wpforms-form .wpforms-field-label'   => 'background-color: {{VALUE}};',
        //         ],
        //     ]
        // );

        $this->add_control(
            'wpforms_label_text_color',
            [
                'label'     => __('Color', 'gostudy-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .wpforms-form .wpforms-field-label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'wpforms_label_typography',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .wpforms-form .wpforms-field-label',
            ]
        );

        $this->add_responsive_control(
            'wpforms_label_padding',
            [
                'label'      => __('Padding', 'gostudy-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .wpforms-form .wpforms-field-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'before',
            ]
        );

        $this->add_responsive_control(
            'wpforms_label_margin',
            [
                'label'      => __('Margin', 'gostudy-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .wpforms-form .wpforms-field-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'before',
            ]
        );

        $this->end_controls_section(); // // Label style tab end

        // Style Input tab section
        $this->start_controls_section(
            'wpforms_input_style_section',
            [
                'label' => __('Input', 'gostudy-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'wpforms_input_background_color',
            [
                'label'     => __('Background Color', 'gostudy-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .wpforms-field input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .wpforms-field select' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'wpforms_input_color',
            [
                'label'     => __('Color', 'gostudy-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .wpforms-field input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .wpforms-field select' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'wpforms_input_typography',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_ACCENT,
                ],
                'selector' => '{{WRAPPER}} .wpforms-field input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .wpforms-field select',
            ]
        );

        $this->add_responsive_control(
            'wpforms_input_height',
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
                    '{{WRAPPER}} .wpforms-field input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .wpforms-field select' => 'height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'wpforms_input_padding',
            [
                'label'      => __('Padding', 'gostudy-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .wpforms-field input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file])' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .wpforms-field select'                                                                                                                => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'before',
            ]
        );

        $this->add_responsive_control(
            'wpforms_input_margin',
            [
                'label'      => __('Margin', 'gostudy-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .wpforms-field input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file])' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .wpforms-field select'                                                                                                                => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'wpforms_input_border',
                'label'    => __('Border', 'gostudy-core'),
                'selector' => '{{WRAPPER}} .wpforms-field input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .wpforms-field select',
            ]
        );

        $this->add_responsive_control(
            'wpforms_input_border_radius',
            [
                'label'     => esc_html__('Border Radius', 'gostudy-core'),
                'type'      => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .wpforms-field input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file])' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    '{{WRAPPER}} .wpforms-field select'                                                                                                                => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                ],
            ]
        );

        $this->end_controls_section(); // Form input style

        // Style Textarea tab section
        $this->start_controls_section(
            'wpforms_textarea_style_section',
            [
                'label' => __('Textarea', 'gostudy-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'wpforms_textarea_background_color',
            [
                'label'     => __('Background Color', 'gostudy-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .wpforms-field textarea' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'wpforms_textarea_color',
            [
                'label'     => __('Color', 'gostudy-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .wpforms-field textarea' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'wpforms_textarea_typography',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_ACCENT,
                ],
                'selector' => '{{WRAPPER}} .wpforms-field textarea',
            ]
        );

        $this->add_responsive_control(
            'wpforms_textarea_height',
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
                    '{{WRAPPER}} .wpforms-field textarea' => 'height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'wpforms_textarea_padding',
            [
                'label'      => __('Padding', 'gostudy-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .wpforms-field textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'before',
            ]
        );

        $this->add_responsive_control(
            'wpforms_textarea_margin',
            [
                'label'      => __('Margin', 'gostudy-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .wpforms-field textarea' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'wpforms_textarea_border',
                'label'    => __('Border', 'gostudy-core'),
                'selector' => '{{WRAPPER}} .wpforms-field textarea',
            ]
        );

        $this->add_responsive_control(
            'wpforms_textarea_border_radius',
            [
                'label'     => esc_html__('Border Radius', 'gostudy-core'),
                'type'      => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .wpforms-field textarea' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                ],
            ]
        );

        $this->end_controls_section(); // Form input style

        // Input submit button style tab start
        $this->start_controls_section(
            'wpforms_inputsubmit_style',
            [
                'label' => __('Button', 'gostudy-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->start_controls_tabs('wpforms_submit_style_tabs');

        // Button Normal tab start
        $this->start_controls_tab(
            'wpforms_submit_style_normal_tab',
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
                    '{{WRAPPER}} .wpforms-form button[type="submit"]' => 'float: {{VALUE}};',
                ],
                'default'   => 'left',
            ]
        );
        $this->add_responsive_control(
            'wpforms_input_submit_width',
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
                'default'    => [
                    'unit' => 'px',
                    'size' => 135,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .wpforms-form button[type="submit"]' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'wpforms_input_submit_height',
            [
                'label'     => __('Height', 'gostudy-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max' => 150,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wpforms-form button[type="submit"]' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'wpforms_input_submit_typography',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_TEXT,
                ],
                'selector' => '{{WRAPPER}} .wpforms-form button[type="submit"]',
            ]
        );

        $this->add_control(
            'wpforms_input_submit_text_color',
            [
                'label'     => __('Color', 'gostudy-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .wpforms-form button[type="submit"]' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'wpforms_input_submit_background_color',
            [
                'label'     => __('Background Color', 'gostudy-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .wpforms-form button[type="submit"]' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'wpforms_input_submit_padding',
            [
                'label'      => __('Padding', 'gostudy-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .wpforms-form button[type="submit"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'before',
            ]
        );

        $this->add_responsive_control(
            'wpforms_input_submit_margin',
            [
                'label'      => __('Margin', 'gostudy-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .wpforms-form button[type="submit"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'wpforms_input_submit_border',
                'label'    => __('Border', 'gostudy-core'),
                'selector' => '{{WRAPPER}} .wpforms-form button[type="submit"]',
            ]
        );

        $this->add_responsive_control(
            'wpforms_input_submit_border_radius',
            [
                'label'     => esc_html__('Border Radius', 'gostudy-core'),
                'type'      => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .wpforms-form button[type="submit"]' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'wpforms_input_submit_box_shadow',
                'label'    => __('Box Shadow', 'gostudy-core'),
                'selector' => '{{WRAPPER}} .wpforms-form button[type="submit"]',
            ]
        );

        $this->end_controls_tab(); // Button Normal tab end

        // Button Hover tab start
        $this->start_controls_tab(
            'wpforms_submit_style_hover_tab',
            [
                'label' => __('Hover', 'gostudy-core'),
            ]
        );

        $this->add_control(
            'wpforms_input_submithover_text_color',
            [
                'label'     => __('Color', 'gostudy-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .wpforms-form button[type="submit"]:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'wpforms_input_submithover_background_color',
            [
                'label'     => __('Background Color', 'gostudy-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .wpforms-form button[type="submit"]:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'wpforms_input_submithover_border',
                'label'    => __('Border', 'gostudy-core'),
                'selector' => '{{WRAPPER}} .wpforms-form button[type="submit"]:hover',
            ]
        );

        $this->end_controls_tab(); // Button Hover tab end

        $this->end_controls_tabs();

    }

    protected function render($instance = [])
    {

        $settings = $this->get_settings_for_display();
        $this->add_render_attribute('rt_form_area_attr', 'class', 'rt-wpforms-wrapper');

        if (!$settings['contact_form_list']) {
            // echo '<p>'.esc_html__('Please Select WPFoms','gostudy-core').'</p>';
        } else {
            ?>
        <div <?php echo $this->get_render_attribute_string('rt_form_area_attr'); ?> >
           <?php
            $show_form_title       = $settings['show_form_title'];
            $show_form_description = $settings['show_form_description'];?>
           <?php echo wpforms_display($settings['contact_form_list'], $show_form_title, $show_form_description); ?>
        </div>
       <?php }

    }
}
