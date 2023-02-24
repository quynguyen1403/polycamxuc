<?php
namespace RTAddons\Includes;

defined('ABSPATH') || exit;

use Elementor\{
    Frontend,
    Controls_Manager,
    Group_Control_Box_Shadow,
    Group_Control_Image_Size
};
use RTAddons\Gostudy_Global_Variables as Globals;

if (!class_exists('RT_Feedback_Settings')) {
    /**
     * RT Elementor Feedback Settings
     *
     *
     * @package gostudy-core\includes\elementor
     * @author RaisTheme <help.raistheme@gmail.com>
     * @since 1.0.0
     */
    class RT_Feedback_Settings
    {
        private static $instance;

        public static function get_instance()
        {
            if (is_null(self::$instance)) {
                self::$instance = new self();
            }

            return self::$instance;
        }

        public static function options($self, $array = [])
        {
            $desktop_width = get_option('elementor_container_width') ?: '1140';
            $tablet_width = get_option('elementor_viewport_lg') ?: '1025';
            $mobile_width = get_option('elementor_viewport_md') ?: '768';

            $self->start_controls_section(
                'rt_carousel_section',
                ['label' => esc_html__('Carousel Options', 'gostudy-core')]
            );

            $self->add_control(
                'use_carousel',
                [
                    'label' => esc_html__('Use Carousel', 'gostudy-core'),
                    'type' => Controls_Manager::SWITCHER,
                    'default'      => 'yes',
                    'label_on'     => __('Show', 'gostudy-core'),
                    'label_off'    => __('Hide', 'gostudy-core'),
                    'return_value' => 'yes',
                ]
            );

	        $self->add_responsive_control(
		        'slider_padding',
		        [
			        'label' => esc_html__('Inner Padding', 'gostudy-core'),
			        'type' => Controls_Manager::DIMENSIONS,
			        'condition' => ['use_carousel' => 'yes'],
			        'size_units' => ['px', 'em', '%'],
			        'allowed_dimensions' => 'horizontal',
			        'render_type' => 'template',
			        'selectors' => [
				        '{{WRAPPER}} .rt-carousel_slick, {{WRAPPER}} .rt-carousel_motion_style' => 'padding: 0 {{RIGHT}}{{UNIT}} 0 {{LEFT}}{{UNIT}};',
			        ],
		        ]
	        );

	        if (isset($array['infinity_on_the_right']) && $array['infinity_on_the_right'] === true) {
		        $self->add_control(
			        'infinity_on_the_right',
			        [
				        'label' => esc_html__('Infinity on the Right', 'gostudy-core'),
				        'type' => Controls_Manager::SWITCHER,
				        'condition' => ['use_carousel' => 'yes'],
				        'label_on' => esc_html__('On', 'gostudy-core'),
				        'label_off' => esc_html__('Off', 'gostudy-core'),
				        'prefix_class' => 'infinity_',
			        ]
		        );
	        }

	        if (isset($array['rt_motion']) && $array['rt_motion'] === true) {
		        $self->add_control(
			        'motion_style',
			        [
				        'label' => esc_html__( 'Motion Style', 'gostudy-core' ),
				        'type' => Controls_Manager::SELECT,
				        'condition' => [ 'use_carousel' => 'yes' ],
				        'options' => [
                            'default' => esc_html__('Horizontal Default', 'unicoach-core'),
                            'horizontal' => esc_html__('Horizontal Animated', 'unicoach-core'),
                            'vertical' => esc_html__('Vertical Animated', 'unicoach-core'),
				        ],
				        'default' => 'horizontal',
			        ]
		        );

		        $self->add_responsive_control(
			        'motion_style_height',
			        [
				        'label' => esc_html__( 'Feedback Height', 'gostudy-core' ),
				        'type' => Controls_Manager::SLIDER,
				        'condition' => [
					        'use_carousel' => 'yes',
					        'motion_style' => 'vertical'
				        ],
				        'size_units' => [ 'px' ],
				        'range' => [
					        'px' => [
						        'min' => 300,
						        'max' => 1000
					        ],
				        ],
				        'default' => [ 'size' => 600, 'unit' => 'px' ],
				        'render_type' => 'template',
				        'selectors' => [
					        '{{WRAPPER}} .rt-carousel_motion_style' => 'height: {{SIZE}}{{UNIT}};',
				        ],
			        ]
		        );
	        }else{
		        $self->add_control(
			        'motion_style',
			        [
				        'type' => Controls_Manager::HIDDEN,
				        'condition' => ['use_carousel' => 'yes'],
				        'default' => 'default',
			        ]
		        );
	        }

	        $self->add_control(
		        'motion_rotate_by_scroll',
		        [
			        'label' => esc_html__('Rotation by Scroll', 'gostudy-core'),
			        'type' => Controls_Manager::SWITCHER,
			        'condition' => [
				        'use_carousel' => 'yes',
				        'motion_style!' => 'default'
			        ],
			        'label_on' => esc_html__('On', 'gostudy-core'),
			        'label_off' => esc_html__('Off', 'gostudy-core'),
			        'default' => 'yes',
		        ]
	        );

	        $self->add_control(
                'autoplay',
                [
                    'label' => esc_html__('Autoplay', 'gostudy-core'),
                    'type' => Controls_Manager::SWITCHER,
	                'condition' => [
		                'use_carousel' => 'yes',
		                'motion_style' => 'default'
	                ],
                    'label_on' => esc_html__('On', 'gostudy-core'),
                    'label_off' => esc_html__('Off', 'gostudy-core'),
                ]
            );

            $self->add_control(
                'autoplay_speed',
                [
                    'label' => esc_html__('Autoplay Speed', 'gostudy-core'),
                    'type' => Controls_Manager::NUMBER,
	                'condition' => [
		                'use_carousel' => 'yes',
		                'motion_style' => 'default'
	                ],
                    'min' => 1,
                    'step' => 1,
                    'default' => '3000',
                ]
            );

            $self->add_control(
                'fade_animation',
                [
                    'label' => esc_html__('Fade Animation', 'gostudy-core'),
                    'type' => Controls_Manager::SWITCHER,
	                'condition' => [
		                'use_carousel' => 'yes',
		                'posts_per_line' => '1',
		                'motion_style' => 'default'
	                ],
                    'label_on' => esc_html__('On', 'gostudy-core'),
                    'label_off' => esc_html__('Off', 'gostudy-core'),
                ]
            );

            $self->add_control(
                'slides_to_scroll',
                [
                    'label' => esc_html__('Slide per single item', 'gostudy-core'),
                    'type' => Controls_Manager::SWITCHER,
	                'condition' => [
		                'use_carousel' => 'yes',
		                'motion_style' => 'default'
	                ],
                    'label_on' => esc_html__('On', 'gostudy-core'),
                    'label_off' => esc_html__('Off', 'gostudy-core'),
                ]
            );

            $self->add_control(
                'infinite',
                [
                    'label' => esc_html__('Infinite Loop Sliding', 'gostudy-core'),
                    'type' => Controls_Manager::SWITCHER,
	                'condition' => [
		                'use_carousel' => 'yes',
		                'motion_style' => 'default'
	                ],
                    'label_on' => esc_html__('On', 'gostudy-core'),
                    'label_off' => esc_html__('Off', 'gostudy-core'),
                ]
            );

            $self->add_control(
                'center_mode',
                [
                    'label' => esc_html__('Center Mode', 'gostudy-core'),
                    'type' => Controls_Manager::SWITCHER,
	                'condition' => [
		                'use_carousel' => 'yes',
		                'motion_style' => 'default'
	                ],
                    'label_on' => esc_html__('On', 'gostudy-core'),
                    'label_off' => esc_html__('Off', 'gostudy-core'),
                ]
            );

            $self->add_control(
                'pagination_divider',
                [
                    'type' => Controls_Manager::DIVIDER,
                    'condition' => ['use_pagination!' => ''],
                ]
            );

            $self->add_control(
                'use_pagination',
                [
                    'label' => esc_html__('Add Pagination control', 'gostudy-core'),
                    'type' => Controls_Manager::SWITCHER,
	                'condition' => [
		                'use_carousel' => 'yes',
		                'motion_style' => 'default'
	                ],
                    'label_on' => esc_html__('On', 'gostudy-core'),
                    'label_off' => esc_html__('Off', 'gostudy-core'),
                ]
            );

            $self->add_control(
                'pag_type',
                [
                    'label' => esc_html__('Pagination Type', 'gostudy-core'),
                    'type' => 'rt-radio-image',
	                'condition' => [
		                'use_carousel' => 'yes',
		                'use_pagination' => 'yes',
		                'motion_style' => 'default'
	                ],
                    'options' => [
                        'circle' => [
                            'title' => esc_html__('Circle', 'gostudy-core'),
                            'image' => RT_ELEMENTOR_ADDONS_URL . 'assets/img/rt_elementor_addon/icons/pag_circle.png',
                        ],
                        'circle_border' => [
                            'title' => esc_html__('Empty Circle', 'gostudy-core'),
                            'image' => RT_ELEMENTOR_ADDONS_URL . 'assets/img/rt_elementor_addon/icons/pag_circle_border.png',
                        ],
                        'square' => [
                            'title' => esc_html__('Square', 'gostudy-core'),
                            'image' => RT_ELEMENTOR_ADDONS_URL . 'assets/img/rt_elementor_addon/icons/pag_square.png',
                        ],
                        'square_border' => [
                            'title' => esc_html__('Empty Square', 'gostudy-core'),
                            'image' => RT_ELEMENTOR_ADDONS_URL . 'assets/img/rt_elementor_addon/icons/pag_square_border.png',
                        ],
                        'line' => [
                            'title' => esc_html__('Line', 'gostudy-core'),
                            'image' => RT_ELEMENTOR_ADDONS_URL . 'assets/img/rt_elementor_addon/icons/pag_line.png',
                        ],
                        'line_circle' => [
                            'title' => esc_html__('Line - Circle', 'gostudy-core'),
                            'image' => RT_ELEMENTOR_ADDONS_URL . 'assets/img/rt_elementor_addon/icons/pag_line_circle.png',
                        ],
                    ],
                    'default' => 'circle',
                ]
            );

	        $self->add_responsive_control(
		        'pag_align',
		        [
			        'label' => esc_html__('Pagination Aligning', 'gostudy-core'),
			        'type' => Controls_Manager::SLIDER,
			        'condition' => [
				        'use_carousel' => 'yes',
				        'use_pagination' => 'yes',
				        'motion_style' => 'default'
			        ],
			        'size_units' => ['%'],
			        'range' => [
				        '%' => ['min' => 0, 'max' => 100],
			        ],
			        'default' => ['size' => 50, 'unit' => '%'],
			        'selectors' => [
				        '{{WRAPPER}} .slick-dots' => 'margin-left: {{SIZE}}%; transform: translateX(-{{SIZE}}%);',
			        ],
		        ]
	        );

            $self->add_control(
                'pag_offset',
                [
                    'label' => esc_html__('Pagination Top Offset', 'gostudy-core'),
                    'type' => Controls_Manager::NUMBER,
	                'condition' => [
		                'use_carousel' => 'yes',
		                'use_pagination' => 'yes',
		                'motion_style' => 'default'
	                ],
                    'min' => -500,
                    'step' => 1,
                    'default' => 33,
                    'selectors' => [
                        '{{WRAPPER}} .rt-carousel .slick-dots' => 'margin-top: {{VALUE}}px;',
                    ],
                ]
            );

            $self->add_control(
                'custom_pag_color',
                [
                    'label' => esc_html__('Custom Pagination Color', 'gostudy-core'),
                    'type' => Controls_Manager::SWITCHER,
	                'condition' => [
		                'use_carousel' => 'yes',
		                'use_pagination' => 'yes',
		                'motion_style' => 'default'
	                ],
                    'label_on' => esc_html__('On', 'gostudy-core'),
                    'label_off' => esc_html__('Off', 'gostudy-core'),
                ]
            );

            $self->add_control(
                'pag_color',
                [
                    'label' => esc_html__('Color', 'gostudy-core'),
                    'type' => Controls_Manager::COLOR,
	                'condition' => [
		                'use_carousel' => 'yes',
		                'custom_pag_color' => 'yes',
		                'motion_style' => 'default'
	                ],
                    'dynamic' => ['active' => true],
                ]
            );

            $self->add_control(
                'navigation_divider',
                [
                    'type' => Controls_Manager::DIVIDER,
                    'conditions' => [
                        'relation' => 'or',
                        'terms' => [[
                            'terms' => [[
                                'name' => 'use_pagination',
                                'operator' => '!=',
                                'value' => '',
                            ]]
                        ], [
                            'terms' => [[
                                'name' => 'use_prev_next',
                                'operator' => '!=',
                                'value' => '',
                            ]]
                        ],],
                    ],
                ]
            );

            $self->add_control(
                'use_prev_next',
                [
                    'label' => esc_html__('Add Prev/Next buttons', 'gostudy-core'),
                    'type' => Controls_Manager::SWITCHER,
	                'condition' => [ 'use_carousel' => 'yes' ],
                    'label_on' => esc_html__('On', 'gostudy-core'),
                    'label_off' => esc_html__('Off', 'gostudy-core'),
                ]
            );

            $self->add_control(
                'prev_next_position',
                [
                    'label' => esc_html__('Arrows Positioning', 'gostudy-core'),
                    'type' => Controls_Manager::SELECT,
	                'condition' => [
		                'use_carousel' => 'yes',
		                'use_prev_next!' => '',
		                'motion_style' => 'default'
	                ],
                    'options' => [
                        '' => esc_html__('Opposite each other', 'gostudy-core'),
                        'right' => esc_html__('Bottom right corner', 'gostudy-core'),
                    ],
                    'default' => 'right',
                ]
            );

            $self->add_responsive_control(
                'prev_next_offset',
                [
                    'label' => esc_html__('Arrows Vertical Offset', 'gostudy-core'),
                    'type' => Controls_Manager::SLIDER,
	                'condition' => [
		                'use_carousel' => 'yes',
		                'use_prev_next!' => '',
		                'motion_style' => 'default'
	                ],
                    'size_units' => ['px', '%', 'rem'],
                    'range' => [
                        'px' => ['max' => 500],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .slick-arrow' => 'top: {{SIZE}}{{UNIT}};',
                        '{{WRAPPER}} .prev_next_pos_right .slick-arrow' => 'bottom: {{SIZE}}{{UNIT}}; top: auto;',
                    ],
                ]
            );

	        $self->add_control(
		        'custom_prev_next_color',
		        [
			        'label' => esc_html__('Customize Prev/Next Buttons', 'gostudy-core'),
			        'type' => Controls_Manager::SWITCHER,
			        'condition' => [
				        'use_carousel' => 'yes',
				        'use_prev_next' => 'yes',
			        ],
		        ]
	        );

            $self->add_responsive_control(
                'prev_next_motion_style_offset',
                [
                    'label' => esc_html__('Arrows Offset', 'gostudy-core' ),
                    'type' => Controls_Manager::SLIDER,
                    'condition' => [
                        'use_carousel' => 'yes',
                        'motion_style!' => 'default',
                        'custom_prev_next_color' => 'yes'
                    ],
                    'size_units' => ['px'],
                    'range' => [
                        'px' => ['min' => -100, 'max' => 200],
                    ],
                    'default' => ['size' => 70, 'unit' => 'px'],
                    'selectors' => [
                        '{{WRAPPER}} .direction-horizontal .motion_style_navigation' => 'bottom: calc({{SIZE}}{{UNIT}} * -1);',
                        '{{WRAPPER}} .direction-vertical .motion_style_navigation' => 'right: calc({{SIZE}}{{UNIT}} * -1);',
                    ],
                ]
            );

            $self->start_controls_tabs(
                'arrows_style',
                [
                    'condition' => [
                        'use_prev_next' => 'yes',
                        'custom_prev_next_color' => 'yes'
                    ]
                ]
            );

            $self->start_controls_tab(
                'arrows_button_normal',
                ['label' => esc_html__('Idle', 'gostudy-core')]
            );

            $self->add_control(
                'prev_next_color',
                [
                    'label' => esc_html__('Button Text Color', 'gostudy-core'),
                    'type' =>  Controls_Manager::COLOR,
                    'dynamic' => ['active' => true],
                    'default' => Globals::get_primary_color(),
                ]
            );

            $self->add_control(
                'prev_next_bg_idle',
                [
                    'label' => esc_html__('Button Background Color', 'gostudy-core'),
                    'type' =>  Controls_Manager::COLOR,
                    'dynamic' => ['active' => true],
                    'default' => '#ffffff',
                ]
            );

            $self->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'prev_next_idle',
                    'selector' => '{{WRAPPER}} .slick-arrow, {{WRAPPER}} .motion_style_navigation',
                ]
            );

            $self->add_control(
                'prev_next_divider_idle',
                ['type' => Controls_Manager::DIVIDER]
            );

            $self->end_controls_tab();

            $self->start_controls_tab(
                'arrows_button_hover',
                ['label' => esc_html__('Hover', 'gostudy-core')]
            );

            $self->add_control(
                'prev_next_color_hover',
                [
                    'label' => esc_html__('Button Text Color', 'gostudy-core'),
                    'type' =>  Controls_Manager::COLOR,
                    'dynamic' => ['active' => true],
                    'default' => '#ffffff',
                ]
            );

            $self->add_control(
                'prev_next_bg_hover',
                [
                    'label' => esc_html__('Button Background Color', 'gostudy-core'),
                    'type' =>  Controls_Manager::COLOR,
                    'dynamic' => ['active' => true],
                    'default' => Globals::get_h_font_color(),
                ]
            );

            $self->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'prev_next_hover',
                    'selector' => '{{WRAPPER}} .slick-arrow:hover',
                ]
            );

            $self->add_control(
                'prev_next_divider_hover',
                ['type' => Controls_Manager::DIVIDER]
            );

            $self->end_controls_tab();
            $self->end_controls_tabs();

            $self->add_control(
                'responsive_divider',
                [
                    'type' => Controls_Manager::DIVIDER,
                    'conditions' => [
                        'relation' => 'or',
                        'terms' => [[
                            'terms' => [[
                                'name' => 'use_prev_next',
                                'operator' => '!=',
                                'value' => '',
                            ]]
                        ], [
                            'terms' => [[
                                'name' => 'custom_resp',
                                'operator' => '!=',
                                'value' => '',
                            ]]
                        ],],
                    ],
                ]
            );

            $self->add_control(
                'custom_resp',
                [
                    'label' => esc_html__('Customize Responsive', 'gostudy-core'),
                    'type' => Controls_Manager::SWITCHER,
	                'condition' => [
		                'use_carousel' => 'yes',
		                'motion_style' => 'default'
	                ],
                    'label_on' => esc_html__('On', 'gostudy-core'),
                    'label_off' => esc_html__('Off', 'gostudy-core'),
                ]
            );

            $self->add_control(
                'heading_desktop',
                [
                    'label' => esc_html__('Desktop Settings', 'gostudy-core'),
                    'type' => Controls_Manager::HEADING,
                    'condition' => ['custom_resp' => 'yes'],
                ]
            );

            $self->add_control(
                'resp_medium',
                [
                    'label' => esc_html__('Desktop Screen Breakpoint', 'gostudy-core'),
                    'type' => Controls_Manager::NUMBER,
                    'condition' => ['custom_resp' => 'yes'],
                    'default' => $desktop_width,
                    'min' => 500,
                ]
            );

            $self->add_control(
                'resp_medium_slides',
                [
                    'label' => esc_html__('Slides to show', 'gostudy-core'),
                    'type' => Controls_Manager::NUMBER,
                    'condition' => ['custom_resp' => 'yes'],
                    'min' => 1,
                ]
            );

            $self->add_control(
                'heading_tablet',
                [
                    'label' => esc_html__('Tablet Settings', 'gostudy-core'),
                    'type' => Controls_Manager::HEADING,
                    'condition' => ['custom_resp' => 'yes'],
                    'separator' => 'before',
                ]
            );

            $self->add_control(
                'resp_tablets',
                [
                    'label' => esc_html__('Tablet Screen Breakpoint', 'gostudy-core'),
                    'type' => Controls_Manager::NUMBER,
                    'condition' => ['custom_resp' => 'yes'],
                    'min' => 400,
                    'default' => $tablet_width,
                ]
            );

            $self->add_control(
                'resp_tablets_slides',
                [
                    'label' => esc_html__('Slides to show', 'gostudy-core'),
                    'type' => Controls_Manager::NUMBER,
                    'condition' => ['custom_resp' => 'yes'],
                    'min' => 1,
                    'step' => 1,
                ]
            );

            $self->add_control(
                'heading_mobile',
                [
                    'label' => esc_html__('Mobile Settings', 'gostudy-core'),
                    'type' => Controls_Manager::HEADING,
                    'condition' => ['custom_resp' => 'yes'],
                    'separator' => 'before',
                ]
            );

            $self->add_control(
                'resp_mobile',
                [
                    'label' => esc_html__('Mobile Screen Breakpoint', 'gostudy-core'),
                    'type' => Controls_Manager::NUMBER,
                    'condition' => ['custom_resp' => 'yes'],
                    'min' => 300,
                    'default' => $mobile_width,
                ]
            );

            $self->add_control(
                'resp_mobile_slides',
                [
                    'label' => esc_html__('Slides to show', 'gostudy-core'),
                    'type' => Controls_Manager::NUMBER,
                    'condition' => ['custom_resp' => 'yes'],
                    'min' => 1,
                ]
            );

            $self->end_controls_section();
        }

        public static function init($atts, $items = [], $templates = false)
        {
            extract(
                shortcode_atts([
                    // General
                    'motion_style' => 'default',
                    'motion_rotate_by_scroll' => 'yes',
                    'slide_to_show' => '1',
                    'speed' => '300',
                    'autoplay' => true,
                    'autoplay_speed' => '3000',
                    'slides_to_scroll' => false,
                    'infinite' => false,
                    'adaptive_height' => false,
                    'fade_animation' => false,
                    'variable_width' => false,
                    'extra_class' => '',
                    // Navigation
                    'use_pagination' => true,
                    'use_navigation' => false,
                    'pag_type' => 'circle',
                    'nav_type' => 'element',
                    'pag_align' => ['size' => 50, 'unit' => '%'],
                    'custom_pag_color' => false,
                    'pag_color' => Globals::get_h_font_color(),
                    'center_mode' => false,
                    'use_prev_next' => false,
                    'prev_next_position' => '',
                    'custom_prev_next_color' => false,
                    'prev_next_color' => Globals::get_primary_color(),
                    'prev_next_color_hover' => Globals::get_primary_color(),
                    'prev_next_border_color' => Globals::get_primary_color(),
                    'prev_next_bg_idle' => '#ffffff',
                    'prev_next_bg_hover' => '#ffffff',
                    // Responsive
                    'custom_resp' => false,
                    'resp_medium' => '1025',
                    'resp_medium_slides' => '',
                    'resp_tablets' => '993',
                    'resp_tablets_slides' => '',
                    'resp_mobile' => '601',
                    'resp_mobile_slides' => '',
                ], $atts)
            );

            if ($custom_prev_next_color || $custom_pag_color) {
                $carousel_id = uniqid('gostudy_carousel_');
            }
            $carousel_id_attr = isset($carousel_id) ? ' id=' . $carousel_id : '';

            // Custom styles
            ob_start();
            if ($custom_prev_next_color) {
                if ($prev_next_bg_idle) {
                    echo "#$carousel_id .slick-arrow, #$carousel_id .motion_style_navigation { background-color: ", esc_attr($prev_next_bg_idle), ' } ';
                }
                if ($prev_next_bg_hover) {
                    echo "#$carousel_id .slick-arrow:hover, #$carousel_id .motion_style_navigation:hover { background-color: ", esc_attr($prev_next_bg_hover), ' } ';
                }
                if ($prev_next_border_color) {
                    echo "#$carousel_id .slick-arrow, #$carousel_id .motion_style_navigation { border-color: ", esc_attr($prev_next_border_color), ' } ';
                }
                if ($prev_next_color) {
                    echo "#$carousel_id .slick-arrow:after, #$carousel_id .motion_style_navigation:after { color: ", esc_attr($prev_next_color), ' } ';
                }
                if ($prev_next_color_hover) {
                    echo "#$carousel_id .slick-arrow:hover:after, #$carousel_id .motion_style_navigation:hover:after { color: ", esc_attr($prev_next_color_hover), ' } ';
                }
                echo "#$carousel_id .slick-arrow:hover:before { opacity: 0; } ";
            }
            if ($custom_pag_color && $pag_color) {
                echo "#$carousel_id.pagination_circle .slick-dots li button,",
                    "#$carousel_id.pagination_line .slick-dots li button:before,",
                    "#$carousel_id.pagination_line_circle .slick-dots li button,",
                    "#$carousel_id.pagination_square .slick-dots li button,",
                    "#$carousel_id.pagination_square_border .slick-dots li button:before,",
                    "#$carousel_id.pagination_circle_border .slick-dots li button:before { ",
                        'background: ', esc_attr($pag_color), ';',
                    '}',
                    "#$carousel_id.pagination_circle_border .slick-dots li.slick-active button,",
                    "#$carousel_id.pagination_square_border .slick-dots li.slick-active button { ",
                        'border-color: ', esc_attr($pag_color), ';',
                '}';
            }
            $styles = ob_get_clean();
            RT_Elementor_Helper::enqueue_css($styles);

	        if ( 'default' === $motion_style ) {

		        wp_enqueue_script('slick', get_template_directory_uri() . '/js/slick.min.js');

		        switch ($slide_to_show) {
			        case '2':
				        $responsive_medium = 2;
				        $responsive_tablets = 2;
				        $responsive_mobile = 1;
				        break;
			        case '3':
				        $responsive_medium = 3;
				        $responsive_tablets = 2;
				        $responsive_mobile = 1;
				        break;
			        case '4':
			        case '5':
			        case '6':
				        $responsive_medium = 4;
				        $responsive_tablets = 2;
				        $responsive_mobile = 1;
				        break;
			        default:
				        $responsive_medium = 1;
				        $responsive_tablets = 1;
				        $responsive_mobile = 1;
				        break;
		        }

		        // If custom responsive
		        if ($custom_resp) {
			        $responsive_medium = !empty($resp_medium_slides) ? (int) $resp_medium_slides : $responsive_medium;
			        $responsive_tablets = !empty($resp_tablets_slides) ? (int) $resp_tablets_slides : $responsive_tablets;
			        $responsive_mobile = !empty($resp_mobile_slides) ? (int) $resp_mobile_slides : $responsive_mobile;
		        }

		        if ($slides_to_scroll) {
			        $responsive_sltscrl_medium = $responsive_sltscrl_tablets = $responsive_sltscrl_mobile = 1;
		        } else {
			        $responsive_sltscrl_medium = $responsive_medium;
			        $responsive_sltscrl_tablets = $responsive_tablets;
			        $responsive_sltscrl_mobile = $responsive_mobile;
		        }

		        $data_array = [];
		        $data_array['slidesToShow'] = (int) $slide_to_show;
		        $data_array['slidesToScroll'] = $slides_to_scroll ? 1 : (int) $slide_to_show;
		        $data_array['infinite'] = $infinite ? true : false;
		        $data_array['variableWidth'] = $variable_width ? true : false;

		        $data_array['autoplay'] = $autoplay ? true : false;
		        $data_array['autoplaySpeed'] = $autoplay_speed ?: '';
		        $data_array['speed'] = $speed ? (int) $speed : '300';
		        if ($center_mode) {
			        $data_array['centerMode'] = true;
			        $data_array['centerPadding'] = '0px';
		        }

		        $data_array['arrows'] = $use_prev_next ? true : false;
		        $data_array['dots'] = $use_pagination ? true : false;
		        $data_array['adaptiveHeight'] = $adaptive_height ? true : false;

		        // Responsive settings
		        $data_array['responsive'][0]['breakpoint'] = (int) $resp_medium;
		        $data_array['responsive'][0]['settings']['slidesToShow'] = (int) esc_attr($responsive_medium);
		        $data_array['responsive'][0]['settings']['slidesToScroll'] = (int) esc_attr($responsive_sltscrl_medium);

		        $data_array['responsive'][1]['breakpoint'] = (int) $resp_tablets;
		        $data_array['responsive'][1]['settings']['slidesToShow'] = (int) esc_attr($responsive_tablets);
		        $data_array['responsive'][1]['settings']['slidesToScroll'] = (int) esc_attr($responsive_sltscrl_tablets);

		        $data_array['responsive'][2]['breakpoint'] = (int) $resp_mobile;
		        $data_array['responsive'][2]['settings']['slidesToShow'] = (int) esc_attr($responsive_mobile);
		        $data_array['responsive'][2]['settings']['slidesToScroll'] = (int) esc_attr($responsive_sltscrl_mobile);

		        $prev_next_position_class = $use_prev_next && !empty($prev_next_position) ? ' prev_next_pos_' . $prev_next_position : '';
		        $data_attribute = " data-slick='" . json_encode($data_array, true) . "'";

		        // Classes
		        $carousel_wrap_classes = $use_pagination ? ' pagination_' . $pag_type : '';
		        $carousel_wrap_classes .= $use_navigation ? ' navigation_' . $nav_type : '';
		        $carousel_wrap_classes .= $prev_next_position_class;
		        $carousel_wrap_classes .= $extra_class;

		        $carousel_classes = $fade_animation ? ' fade_slick' : '';

		        // Render
		        $output = '<div class="rt-carousel_wrapper">';
		        $output .= '<div' . $carousel_id_attr . ' class="rt-carousel' . esc_attr($carousel_wrap_classes) . '">';
		        $output .= '<div class="rt-carousel_slick' . $carousel_classes . '"' . $data_attribute . '>';

		        if (!empty($templates)) {
                    if (!empty($items)) {
                        ob_start();
                        foreach ($items as $id) {
                            echo '<div class="item">',
                                (new Frontend())->get_builder_content_for_display($id, true),
                            '</div>';
                        }
                        $output .= ob_get_clean();
                    }
		        } else {
			        $output .= $items;
		        }

		        $output .= '</div>';
		        $output .= '</div>';
		        $output .= '</div>';

		        return $output;

	        } else {

		        // Render
		        $output = '<div' . $carousel_id_attr . ' class="rt-carousel rt-carousel_motion_style direction-'.$motion_style.' rotation_by_scroll-'.$motion_rotate_by_scroll.'">';
			        $output .= $use_prev_next ? '<button class="motion_style_navigation previous-button" type="button"></button>' : '';
			        $output .= '<div class="rt-carousel_wrap">';

			        if (!empty($templates)) {
                        if (!empty($items)) {
                            ob_start();
                            foreach ($items as $id) {
                                echo '<div class="item">',
                                    (new Frontend())->get_builder_content_for_display($id, true),
                                '</div>';
                            }
                            $output .= ob_get_clean();
                        }
			        } else {
				        $output .= $items;
			        }

			        $output .= '</div>';
			        $output .= $use_prev_next ? '<button class="motion_style_navigation next-button" type="button"></button>' : '';
		        $output .= '</div>';

		        return $output;
	        }
        }
    }

    new RT_Feedback_Settings();
}
