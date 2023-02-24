<?php
/*
 * This template can be overridden by copying it to yourtheme/gostudy-core/elementor/widgets/rt-button-widget.php.
*/
namespace RTAddons\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\{Widget_Base, Controls_Manager};
use Elementor\{Group_Control_Border, Group_Control_Typography, Group_Control_Background, Group_Control_Box_Shadow};
use RTAddons\Gostudy_Global_Variables as Gostudy_Globals;
use RTAddons\Includes\RT_Icons;
use RTAddons\templates\RT_Button;

class RT_Button_widget extends Widget_Base
{
    public function get_name()
    {
        return 'rt-button';
    }

    public function get_title()
    {
        return esc_html__('Button', 'gostudy-core');
    }

    public function get_icon()
    {
        return 'rt-button';
    }

    public function get_categories()
    {
        return ['rt-extensions'];
    }

    public static function get_button_sizes()
    {
        return [
            'sm' => esc_html__('Small', 'gostudy-core'),
            'md' => esc_html__('Medium', 'gostudy-core'),
            'lg' => esc_html__('Large', 'gostudy-core'),
            'xl' => esc_html__('Extra Large', 'gostudy-core'),
        ];
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
            ['label' => esc_html__('General', 'gostudy-core')]
        );

        $this->add_control(
            'text',
            [
                'label' => esc_html__('Text', 'gostudy-core'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
                'placeholder' => esc_attr__('Button Text', 'gostudy-core'),
                'default' => esc_html__('Learn More', 'gostudy-core'),
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => esc_html__('Link', 'gostudy-core'),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_attr__('https://your-link.com', 'gostudy-core'),
                'default' => ['url' => '#'],
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label' => esc_html__('Alignment', 'gostudy-core'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
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
                    'justify' => [
                        'title' => esc_html__('Full Width', 'gostudy-core'),
                        'icon' => 'fa fa-align-justify',
                    ],
                ],
                'prefix_class' => 'a%s',
            ]
        );

        $this->add_control(
            'size',
            [
                'label' => esc_html__('Size', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'options' => self::get_button_sizes(),
                'default' => 'lg',
                'style_transfer' => true,
            ]
        );

        $this->end_controls_section();

        $output['icon_align'] = [
            'label' => esc_html__('Position', 'gostudy-core'),
            'type' => Controls_Manager::SELECT,
            'condition' => ['icon_type!' => ''],
            'options' => [
                'left' => esc_html__('Before', 'gostudy-core'),
                'right' => esc_html__('After', 'gostudy-core'),
            ],
            'default' => 'left',
        ];

        $output['icon_indent'] = [
            'label' => esc_html__('Offset', 'gostudy-core'),
            'type' => Controls_Manager::SLIDER,
            'condition' => ['icon_type!' => ''],
            'range' => [
                'px' => ['max' => 50],
            ],
            'selectors' => [
                '{{WRAPPER}} .align-icon-right .media-wrapper' => 'margin-left: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .align-icon-left .media-wrapper' => 'margin-right: {{SIZE}}{{UNIT}};',
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
        /*  STYLE -> BUTTON
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_button',
            [
                'label' => esc_html__('Button', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'selector' => '{{WRAPPER}} .rt-button',
            ]
        );

        $this->start_controls_tabs('tabs_button_style');

        $this->start_controls_tab(
            'tab_button_idle',
            ['label' => esc_html__('Idle', 'gostudy-core')]
        );

        $this->add_control(
            'button_color_idle',
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
            'button_bg_idle',
            [
                'label' => esc_html__('Background Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => $secondary_color,
                'selectors' => [
                    '{{WRAPPER}} .rt-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_border_color_idle',
            [
                'label' => esc_html__('Border Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'condition' => ['border_border!' => ''],
                'dynamic' => ['active' => true],
                'default' => $secondary_color,
                'selectors' => [
                    '{{WRAPPER}} .rt-button' => 'border-color: {{VALUE}};',
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
                            'color' => 'rgba('.\Gostudy_Theme_Helper::HexToRGB($secondary_color).', 0.45)',
                        ]
                    ]
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            ['label' => esc_html__('Hover', 'gostudy-core')]
        );

        $this->add_control(
            'button_color_hover',
            [
                'label' => esc_html__('Text Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .rt-button:hover,
                    {{WRAPPER}} .rt-button:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_bg_hover',
            [
                'label' => esc_html__('Background Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => $primary_color,
                'selectors' => [
                    '{{WRAPPER}} .rt-button:hover,
                    {{WRAPPER}} .rt-button:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_border_color',
            [
                'label' => esc_html__('Border Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => ['border_border!' => ''],
                'selectors' => [
                    '{{WRAPPER}} .rt-button:hover,
                    {{WRAPPER}} .rt-button:focus' => 'border-color: {{VALUE}};',
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
                            'color' => 'rgba('.\Gostudy_Theme_Helper::HexToRGB($primary_color).', 0.45)',
                        ]
                    ]
                ]
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .rt-button',
                'fields_options' => [
                    'color' => ['type' => Controls_Manager::HIDDEN],
                ],
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label' => esc_html__('Border Radius', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .rt-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'text_padding',
            [
                'label' => esc_html__('Padding', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'separator' => 'before',
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .rt-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> ICON/IMAGE
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => esc_html__('Icon/Image', 'gostudy-core'),
                'condition' => ['icon_type!' => ''],
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'media_margin',
            [
                'label' => esc_html__('Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'allowed_dimensions' => 'vertical',
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .media-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'tabs_icon',
            ['condition' => ['icon_type' => 'font'],]
        );

        $this->start_controls_tab(
            'tab_icon_idle',
            ['label' => esc_html__('Idle', 'gostudy-core')]
        );

        $this->add_control(
            'icon_color_idle',
            [
                'label' => esc_html__('Icon Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_icon_hover',
            ['label' => esc_html__('Hover', 'gostudy-core')]
        );

        $this->add_control(
            'icon_color_hover',
            [
                'label' => esc_html__('Icon Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .rt-button:hover .elementor-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'icon_size',
            [
                'label' => esc_html__('Font Size', 'gostudy-core'),
                'type' => Controls_Manager::SLIDER,
                'condition' => ['icon_type' => 'font'],
                'separator' => 'before',
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => ['max' => 80],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> ANIMATION
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_animation',
            [
                'label' => esc_html__('Animation', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'hover_animation',
            [
                'label' => esc_html__('Button Hover', 'gostudy-core'),
                'type' => Controls_Manager::HOVER_ANIMATION,
                'separator' => 'after',
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $atts = $this->get_settings_for_display();

        $button = new RT_Button();
        $button->render($this, $atts);
    }
}
