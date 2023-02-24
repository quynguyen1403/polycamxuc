<?php
/*
 * This template can be overridden by copying it to yourtheme/gostudy-core/elementor/widgets/rt-info-box.php.
*/
namespace RTAddons\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\{Widget_Base, Controls_Manager};
use Elementor\{Core\Schemes\Typography as Typography};
use Elementor\{Group_Control_Typography, Group_Control_Box_Shadow, Group_Control_Background, Group_Control_Css_Filter, Group_Control_Border};
use Elementor\Icons_Manager;
use RTAddons\Gostudy_Global_Variables as Gostudy_Globals;
use RTAddons\Includes\RT_Icons;
use RTAddons\Templates\RTInfoBoxes;


class RT_Info_Box extends Widget_Base
{
    public function get_name()
    {
        return 'rt-info-box';
    }

    public function get_title()
    {
        return esc_html__('RT Info Box', 'gostudy-core');
    }

    public function get_icon()
    {
        return 'rt-info-box';
    }

    public function get_categories()
    {
        return ['rt-extensions'];
    }


    protected function register_controls()
    {
        /**
         * CONTENT -> GENERAL
         */

        $this->start_controls_section(
            'section_content_general',
            ['label' => esc_html__('General', 'gostudy-core')]
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
            'alignment',
            [
                'label' => esc_html__('Alignment', 'gostudy-core'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => true,
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

        /**
         * CONTENT -> ICON/IMAGE
         */

        $output = [];

        $output['view'] = [
            'label' => esc_html__('View', 'gostudy-core'),
            'type' => Controls_Manager::SELECT,
            'condition' => ['icon_type' => 'font'],
            'options' => [
                'default' => esc_html__('Default', 'gostudy-core'),
                'stacked' => esc_html__('Stacked', 'gostudy-core'),
                'framed' => esc_html__('Framed', 'gostudy-core'),
            ],
            'default' => 'default',
            'prefix_class' => 'elementor-view-',
        ];

        $output['shape'] = [
            'label' => esc_html__('Shape', 'gostudy-core'),
            'type' => Controls_Manager::SELECT,
            'condition' => [
                'icon_type' => 'font',
                'view!' => 'default',
            ],
            'options' => [
                'circle' => esc_html__('Circle', 'gostudy-core'),
                'square' => esc_html__('Square', 'gostudy-core'),
            ],
            'default' => 'circle',
            'prefix_class' => 'elementor-shape-',
        ];

        RT_Icons::init(
            $this,
            [
                'output' => $output,
                'section' => true,
                'default' => [
                    'media_type' => 'font',
                    'icon' => [
                        'library' => 'flaticon',
                        'value' => 'flaticon-gear'
                    ],
                ]
            ]
        );

        /**
         * CONTENT -> CONTENT
         */

        $this->start_controls_section(
            'rt_ib_content',
            ['label' => esc_html__('Content', 'gostudy-core')]
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
            'ib_title_add',
            [
                'label' => esc_html__('Additional Title', 'gostudy-core'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'ib_subtitle',
            [
                'label' => esc_html__('Subtitle', 'gostudy-core'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => esc_attr__('ex: 01', 'gostudy-core'),
            ]
        );

        $this->add_control(
            'ib_content',
            [
                'label' => esc_html__('Content', 'gostudy-core'),
                'type' => Controls_Manager::WYSIWYG,
                'placeholder' => esc_attr__('Description Text', 'gostudy-core'),
                'label_block' => true,
                'dynamic' => ['active' => true],
                'default' => esc_html__('Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'gostudy-core'),
            ]
        );

        $this->end_controls_section();

        /**
         * CONTENT -> LINK
         */

        $this->start_controls_section(
            'section_style_link',
            ['label' => esc_html__('Link', 'gostudy-core')]
        );

        $this->add_control(
            'link',
            [
                'label' => esc_html__('Link', 'gostudy-core'),
                'type' => Controls_Manager::URL,
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'module_link',
                            'operator' => '!=',
                            'value' => '',
                        ],
                        [
                            'name' => 'add_read_more',
                            'operator' => '!=',
                            'value' => '',
                        ],
                    ],
                ],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'module_link',
            [
                'label' => esc_html__('Whole Module Link', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'add_read_more',
            [
                'label' => esc_html__('\'Read More\' Button', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Use', 'gostudy-core'),
                'label_off' => esc_html__('Hide', 'gostudy-core'),
            ]
        );

        $this->add_control(
            'read_more_inline',
            [
                'label' => esc_html__('Inline Button', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [
                    'layout' => ['left', 'right'],
                    'add_read_more!' => ''
                ],
            ]
        );

        $this->add_control(
            'read_more_text',
            [
                'label' => esc_html__('Button Text', 'gostudy-core'),
                'type' => Controls_Manager::TEXT,
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'terms' => [
                                [
                                    'name' => 'layout',
                                    'operator' => '=',
                                    'value' => 'top',
                                ], [
                                    'name' => 'add_read_more',
                                    'operator' => '!=',
                                    'value' => '',
                                ]
                            ]
                        ],
                        [
                            'terms' => [
                                [
                                    'name' => 'layout',
                                    'operator' => 'in',
                                    'value' => ['left', 'right'],
                                ], [
                                    'name' => 'add_read_more',
                                    'operator' => '!=',
                                    'value' => '',
                                ], [
                                    'name' => 'read_more_inline',
                                    'operator' => '=',
                                    'value' => '',
                                ]
                            ]
                        ],
                    ],
                ],
                'label_block' => true,
                'default' => esc_html__('LEARN MORE', 'gostudy-core'),
            ]
        );

        $this->end_controls_section();

        /**
         * CONTENT -> HOVER ANIMATION
         */

        $this->start_controls_section(
            'section_content_animation',
            ['label' => esc_html__('Hover Animation', 'gostudy-core')]
        );

        $this->add_control(
            'hover_lifting',
            [
                'label' => esc_html__('Lift Up the Item', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['hover_toggling' => ''],
                'label_on' => esc_html__('On', 'gostudy-core'),
                'label_off' => esc_html__('Off', 'gostudy-core'),
                'return_value' => 'lifting',
                'prefix_class' => 'animation_',
            ]
        );

        $this->add_control(
            'hover_toggling',
            [
                'label' => esc_html__('Toggle Icon/Content Visibility', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [
                    'hover_lifting' => '',
                    'layout!' => ['left', 'right'],
                    'icon_type!' => '',
                ],
                'label_on' => esc_html__('On', 'gostudy-core'),
                'label_off' => esc_html__('Off', 'gostudy-core'),
                'return_value' => 'toggling',
                'prefix_class' => 'animation_',
            ]
        );

        $this->add_responsive_control(
            'hover_toggling_offset',
            [
                'label' => esc_html__('Animation Distance', 'gostudy-core'),
                'type' => Controls_Manager::SLIDER,
                'condition' => [
                    'hover_toggling!' => '',
                    'layout!' => ['left', 'right'],
                    'icon_type!' => '',
                ],
                'range' => [
                    'px' => ['min' => 30, 'max' => 100],
                ],
                'default' => ['size' => 40],
                'selectors' => [
                    '{{WRAPPER}}.animation_toggling .rt-infobox_wrapper' => 'transform: translateY({{SIZE}}{{UNIT}});',
                    '{{WRAPPER}}.animation_toggling .elementor-widget-container:hover .rt-infobox_wrapper' => 'transform: translateY(-{{SIZE}}{{UNIT}});',
                ],
            ]
        );

        $this->add_responsive_control(
            'hover_toggling_transition',
            [
                'label' => esc_html__('Transition Duration', 'gostudy-core'),
                'type' => Controls_Manager::SLIDER,
                'condition' => [
                    'hover_toggling!' => '',
                    'layout!' => ['left', 'right'],
                    'icon_type!' => '',
                ],
                'range' => [
                    'px' => ['min' => 0.1, 'max' => 2, 'step' => 0.1],
                ],
                'default' => ['size' => 0.6],
                'selectors' => [
                    '{{WRAPPER}}.animation_toggling .rt-infobox_wrapper,
                     {{WRAPPER}}.animation_toggling .media-wrapper,
                     {{WRAPPER}}.animation_toggling .rt-infobox-button_wrapper' => 'transition-duration: {{SIZE}}s;',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> ICON
         */

        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => esc_html__('Icon', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['icon_type' => 'font'],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Font Size', 'gostudy-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => ['min' => 6, 'max' => 300],
                ],
                'default' => ['size' => 40],
                'selectors' => [
                    '{{WRAPPER}} .media-wrapper .elementor-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_rotate',
            [
                'label' => esc_html__('Rotate', 'gostudy-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['deg', 'turn'],
                'range' => [
                    'deg' => ['max' => 360],
                    'turn' => ['min' => 0, 'max' => 1, 'step' => 0.1],
                ],
                'default' => ['unit' => 'deg'],
                'selectors' => [
                    '{{WRAPPER}} .media-wrapper .elementor-icon' => 'transform: rotate({{SIZE}}{{UNIT}});',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_margin',
            [
                'label' => esc_html__('Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'separator' => 'before',
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .media-wrapper .elementor-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_padding',
            [
                'label' => esc_html__('Padding', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .media-wrapper .elementor-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'border_width',
            [
                'label' => esc_html__('Border Width', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'condition' => ['view' => 'framed'],
                'selectors' => [
                    '{{WRAPPER}} .media-wrapper .elementor-icon' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label' => esc_html__('Border Radius', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'condition' => ['view!' => 'default'],
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .media-wrapper .elementor-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'tabs_icons',
            ['separator' => 'before']
        );

        $this->start_controls_tab(
            'tab_icon_idle',
            ['label' => esc_html__('Idle', 'gostudy-core')]
        );

        $this->add_control(
            'icon_primary_color_idle',
            [
                'label' => esc_html__('Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}}.elementor-view-stacked .elementor-icon' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}}.elementor-view-framed .elementor-icon,
                     {{WRAPPER}}.elementor-view-default .elementor-icon' => 'color: {{VALUE}}; border-color: {{VALUE}};',
                    '{{WRAPPER}}.elementor-view-framed .elementor-icon svg,
                     {{WRAPPER}}.elementor-view-default .elementor-icon svg' => 'fill: {{VALUE}}; border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_secondary_color_idle',
            [
                'label' => esc_html__('Additional Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'condition' => ['view!' => 'default'],
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}}.elementor-view-framed .elementor-icon' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}}.elementor-view-stacked .elementor-icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}}.elementor-view-stacked .elementor-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'icon_idle',
                'selector' => '{{WRAPPER}} .elementor-icon',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_icon_hover',
            ['label' => esc_html__('Hover', 'gostudy-core')]
        );

        $this->add_control(
            'icon_primary_color_hover',
            [
                'label' => esc_html__('Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}}.elementor-view-stacked:hover .elementor-icon' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}}.elementor-view-framed:hover .elementor-icon,
                     {{WRAPPER}}.elementor-view-default:hover .elementor-icon' => 'color: {{VALUE}}; border-color: {{VALUE}};',
                    '{{WRAPPER}}.elementor-view-framed:hover .elementor-icon svg,
                     {{WRAPPER}}.elementor-view-default:hover .elementor-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_secondary_color_hover',
            [
                'label' => esc_html__('Additional Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'condition' => ['view!' => 'default'],
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}}.elementor-view-framed:hover .elementor-icon' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}}.elementor-view-stacked:hover .elementor-icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}}.elementor-view-stacked:hover .elementor-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'icon_hover',
                'selector' => '{{WRAPPER}}:hover .elementor-icon',
            ]
        );

        $this->add_control(
            'hover_animation_icon',
            [
                'label' => esc_html__('Hover Animation', 'gostudy-core'),
                'type' => Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> IMAGE
         */

        $this->start_controls_section(
            'section_style_image',
            [
                'label' => esc_html__('Image', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['icon_type' => 'image'],
            ]
        );

        $this->add_responsive_control(
            'image_space',
            [
                'label' => esc_html__('Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .rt-image-box_img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_size',
            [
                'label' => esc_html__('Width', 'gostudy-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => ['min' => 50, 'max' => 800],
                    '%' => ['min' => 5, 'max' => 100],
                ],
                'default' => ['size' => 100, 'unit' => '%'],
                'selectors' => [
                    '{{WRAPPER}} .rt-image-box_img' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .rt-image-box_img img' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .rt-image-box_img img' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'hover_animation_image',
            [
                'label' => esc_html__('Hover Animation', 'gostudy-core'),
                'type' => Controls_Manager::HOVER_ANIMATION,
            ]
        );
	
	    $this->add_control(
		    'image_border',
		    [
			    'label' => esc_html__('Show Border for Image?', 'gostudy-core'),
			    'type' => Controls_Manager::SWITCHER,
			    'prefix_class' => 'show_border-',
		    ]
	    );
	
	    $this->start_controls_tabs('image_effects');

        $this->start_controls_tab(
            'Idle',
            ['label' => esc_html__('Idle', 'gostudy-core')]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters',
                'selector' => '{{WRAPPER}} .rt-image-box_img img',
            ]
        );

        $this->add_control(
            'image_opacity',
            [
                'label' => esc_html__('Opacity', 'gostudy-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['min' => 0.10, 'max' => 1, 'step' => 0.01],
                ],
                'selectors' => [
                    '{{WRAPPER}} .rt-image-box_img img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_control(
            'background_hover_transition',
            [
                'label' => esc_html__('Transition Duration', 'gostudy-core'),
                'type' => Controls_Manager::SLIDER,
                'default' => ['size' => 0.3],
                'range' => [
                    'px' => ['max' => 3, 'step' => 0.1],
                ],
                'selectors' => [
                    '{{WRAPPER}} .rt-image-box_img img' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );
	
	    $this->add_control(
		    'image_border_idle',
		    [
			    'label' => esc_html__('Image Border Color', 'gostudy-core'),
			    'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
			    'condition' => ['image_border!' => ''],
			    'default' => Gostudy_Globals::get_secondary_color(),
			    'selectors' => [
				    '{{WRAPPER}} .rt-image-box_img' => 'color: {{VALUE}};',
			    ],
		    ]
	    );
	
        $this->end_controls_tab();

        $this->start_controls_tab(
            'hover',
            ['label' => esc_html__('Hover', 'gostudy-core')]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters_hover',
                'selector' => '{{WRAPPER}} .elementor-widget-container:hover .rt-image-box_img img',
            ]
        );

        $this->add_control(
            'image_opacity_hover',
            [
                'label' => esc_html__('Opacity', 'gostudy-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['min' => 0.10, 'max' => 1, 'step' => 0.01],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .rt-image-box_img img' => 'opacity: {{SIZE}};',
                ],
            ]
        );
	
	    $this->add_control(
		    'image_border_hover',
		    [
			    'label' => esc_html__('Image Border Color', 'gostudy-core'),
			    'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
			    'condition' => ['image_border!' => ''],
			    'default' => Gostudy_Globals::get_primary_color(),
			    'selectors' => [
				    '{{WRAPPER}} .elementor-widget-container:hover .rt-image-box_img' => 'color: {{VALUE}};',
			    ],
		    ]
	    );
	
	    $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> TITLE
         */

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

	    $this->add_control(
		    'title_separator',
		    [
			    'label' => esc_html__('Show Separator?', 'gostudy-core'),
			    'type' => Controls_Manager::SWITCHER,
			    'selectors' => [
				    '{{WRAPPER}} .rt-infobox_title:after' => 'display: block;',
			    ],
		    ]
	    );

        $this->add_responsive_control(
            'title_offset',
            [
                'label' => esc_html__('Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '10',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .rt-infobox_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_title',
                'selector' => '{{WRAPPER}} .rt-infobox_title',
            ]
        );

        $this->start_controls_tabs('tabs_title_styles');

        $this->start_controls_tab(
            'tab_title_idle',
            ['label' => esc_html__('Idle', 'gostudy-core')]
        );

        $this->add_control(
            'title_color_idle',
            [
                'label' => esc_html__('Title Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => '#232323',
                'selectors' => [
                    '{{WRAPPER}} .rt-infobox_title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'separator_color_idle',
            [
                'label' => esc_html__('Separator Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_primary_color(),
                'condition' => ['title_separator!' => ''],
                'selectors' => [
                    '{{WRAPPER}} .rt-infobox_title:after' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_title_hover',
            ['label' => esc_html__('Hover', 'gostudy-core')]
        );

        $this->add_control(
            'title_color_hover',
            [
                'label' => esc_html__('Title Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .rt-infobox_title' => 'color: {{VALUE}};',
                ],
            ]
        );

	    $this->add_control(
		    'separator_color_hover',
		    [
			    'label' => esc_html__('Separator Color', 'gostudy-core'),
			    'type' => Controls_Manager::COLOR,
			    'dynamic' => ['active' => true],
			    'default' => Gostudy_Globals::get_primary_color(),
			    'condition' => ['title_separator!' => ''],
			    'selectors' => [
				    '{{WRAPPER}} .elementor-widget-container:hover .rt-infobox_title:after' => 'color: {{VALUE}};',
			    ],
		    ]
	    );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> TITLE ADDITIONAL
         */

        $this->start_controls_section(
            'title_add_style_section',
            [
                'label' => esc_html__('Additional Title', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_title_add',
                'selector' => '{{WRAPPER}} .rt-infobox_title-add',
            ]
        );

        $this->start_controls_tabs('tabs_title_add_styles');

        $this->start_controls_tab(
            'tab_title_add',
            ['label' => esc_html__('Idle', 'gostudy-core')]
        );

        $this->add_control(
            'title_color_add',
            [
                'label' => esc_html__('Text Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .rt-infobox_title-add' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_title_add_hover',
            ['label' => esc_html__('Hover', 'gostudy-core')]
        );

        $this->add_control(
            'title_add_color_hover',
            [
                'label' => esc_html__('Text Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .rt-infobox_title-add' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> SUBTITLE
         */

        $this->start_controls_section(
            'subtitle_style_section',
            [
                'label' => esc_html__('Subtitle', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['ib_subtitle!' => ''],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'subtitle_typography',
                'selector' => '{{WRAPPER}} .rt-infobox_subtitle',
            ]
        );

        $this->add_responsive_control(
            'subtitle_offset',
            [
                'label' => esc_html__('Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'default' => [
	                'top' => '-50',
	                'right' => '0',
	                'bottom' => '-56',
	                'left' => '-30',
	                'unit'  => 'px',
	                'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .rt-infobox_subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_subtitle_styles');

        $this->start_controls_tab(
            'tab_subtitle_idle',
            ['label' => esc_html__('Idle', 'gostudy-core')]
        );

        $this->add_control(
            'subtitle_color_idle',
            [
                'label' => esc_html__('Text Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => '#eef9fd',
                'selectors' => [
                    '{{WRAPPER}} .rt-infobox_subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_subtitle_hover',
            ['label' => esc_html__('Hover', 'gostudy-core')]
        );

        $this->add_control(
            'subtitle_color_hover',
            [
                'label' => esc_html__('Text Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .rt-infobox_subtitle' => 'color: {{VALUE}};'
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> CONTENT
         */

        $this->start_controls_section(
            'content_style_section',
            [
                'label' => esc_html__('Content', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['ib_content!' => ''],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_content',
                'selector' => '{{WRAPPER}} .rt-infobox_content',
            ]
        );

        $this->add_control(
            'content_tag',
            [
                'label' => esc_html__('HTML Tag', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => '‹h1›',
                    'h2' => '‹h2›',
                    'h3' => '‹h3›',
                    'h4' => '‹h4›',
                    'h5' => '‹h5›',
                    'h6' => '‹h5›',
                    'div' => '‹div›',
                    'span' => '‹span›',
                ],
                'default' => 'div',
            ]
        );

        $this->add_responsive_control(
            'content_offset',
            [
                'label' => esc_html__('Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .rt-infobox_content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__('Padding', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .rt-infobox_content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'custom_content_mask_color',
                'label' => esc_html__('Background', 'gostudy-core'),
                'types' => ['classic', 'gradient'],
                'condition' => ['custom_bg' => 'custom'],
                'selector' => '{{WRAPPER}} .rt-infobox_content',
            ]
        );

        $this->start_controls_tabs('content_color_tab');

        $this->start_controls_tab(
            'custom_content_color_idle',
            ['label' => esc_html__('Idle', 'gostudy-core')]
        );

        $this->add_control(
            'content_color',
            [
                'label' => esc_html__('Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .rt-infobox_content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_content_color_hover',
            ['label' => esc_html__('Hover', 'gostudy-core')]
        );

        $this->add_control(
            'content_color_hover',
            [
                'label' => esc_html__('Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .rt-infobox_content' => 'color: {{VALUE}};'
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> BUTTON
         */

        $this->start_controls_section(
            'section_style_button',
            [
                'label' => esc_html__('Button', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['add_read_more!' => ''],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_button',
                'selector' => '{{WRAPPER}} .rt-infobox_button span',
            ]
        );

        $this->add_responsive_control(
            'button_margin',
            [
                'label' => esc_html__('Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .rt-infobox-button_wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label' => esc_html__('Padding', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .rt-infobox-button_wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'tabs_button',
            ['separator' => 'before']
        );

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
                'default' => Gostudy_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .rt-infobox_button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_icon_bg_idle',
            [
                'label' => esc_html__('Additional Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .rt-infobox_button:after' => 'background: {{VALUE}};',
                ],
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
                'selectors' => [
                    '{{WRAPPER}} .rt-infobox_button:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .rt-infobox__link:hover + .rt-infobox .rt-infobox_button' => 'color: {{VALUE}};',
                ],
                'default' => Gostudy_Globals::get_secondary_color(),
            ]
        );

        $this->add_control(
            'button_icon_bg_hover',
            [
                'label' => esc_html__('Additional Hover Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .rt-infobox_button:before' => 'background: {{VALUE}};',
                ],
                'default' => Gostudy_Globals::get_secondary_color(),
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> BACKGROUND
         */

        $this->start_controls_section(
            'section_style_bg',
            [
                'label' => esc_html__('Background', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'item_overflow',
            [
                'label' => esc_html__('Module Overflow', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('Theme Default', 'gostudy-core'),
                    'overflow: visible;' => esc_html__('Visible', 'gostudy-core'),
                    'overflow: hidden;' => esc_html__('Hidden', 'gostudy-core'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container' => '{{VALUE}}',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_background');

        $this->start_controls_tab(
            'tab_bg_idle',
            ['label' => esc_html__('Idle', 'gostudy-core')]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'item_idle',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .elementor-widget-container',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_bg_hover',
            ['label' => esc_html__('Hover', 'gostudy-core')]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'item_hover',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .elementor-widget-container:before',
            ]
        );

        $this->add_control(
            'item_bg_transition',
            [
                'label' => esc_html__('Transition Delay', 'gostudy-core'),
                'type' => Controls_Manager::SLIDER,
                'separator' => 'before',
                'range' => [
                    'px' => ['max' => 3, 'step' => 0.1],
                ],
                'default' => ['size' => 0.4],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container' => 'transition: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    protected function render()
    {
        $atts = $this->get_settings_for_display();

        $info_box = new RTInfoBoxes();
        $info_box->render($this, $atts);
    }
}
