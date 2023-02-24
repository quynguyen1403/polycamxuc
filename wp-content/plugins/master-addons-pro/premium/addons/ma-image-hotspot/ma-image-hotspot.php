<?php

namespace MasterAddons\Addons;

// Elementor Classes
use \Elementor\Widget_Base;
use \Elementor\Utils;
use \Elementor\Icons_Manager;
use \Elementor\Controls_Manager;
use \Elementor\Repeater;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Core\Schemes\Typography;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Css_Filter;

use MasterAddons\Inc\Helper\Master_Addons_Helper;
use MasterAddons\Inc\Controls\MA_Group_Control_Transition;

/**
 * Author Name: Liton Arefin
 * Author URL : https: //jeweltheme.com
 * Date       : 10/12/19
 */
// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

/**
 * News Ticker Widget
 */
class JLTMA_Image_Hotspot extends Widget_Base
{

	public function get_name()
	{
		return 'ma-image-hotspot';
	}

	public function get_title()
	{
		return __('Image Hotspot', 'master-addons' );
	}

	public function get_categories()
	{
		return ['master-addons'];
	}

	public function get_icon()
	{
		return 'jltma-icon eicon-image-hotspot';
	}

	public function get_script_depends()
	{
		return [
			'jltma-popper',
			'jltma-tippy',
		];
	}

	public function get_style_depends()
	{
		return ['jltma-tippy'];
	}

	public function get_keywords()
	{
		return ['image', 'tooltips', 'image tooltips', 'hotspot', 'marker', 'image hotspot', 'content', 'index', 'marker', 'pinpoint', 'image pinpoint'];
	}


	public function get_help_url()
	{
		return 'https://master-addons.com/demos/image-hotspot/';
	}


	protected function register_controls()
	{
		/*
		 * MA Hotspots: Image
		 */
		$this->start_controls_section(
			'ma_el_hotspot_image_section',
			[
				'label' => __('Image', 'master-addons' ),
			]
		);

		$this->add_control(
			'ma_el_hotspot_image',
			[
				'label'   => __('Choose Image', 'master-addons' ),
				'type'    => Controls_Manager::MEDIA,
				'dynamic' => ['active' => true],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'    => 'image',                     // Actually its `image_size`
				'label'   => __('Image Size', 'master-addons' ),
				'default' => 'large',
			]
		);

		$this->add_responsive_control(
			'ma_el_hotspot_align',
			[
				'label'   => __('Alignment', 'master-addons' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __('Left', 'master-addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center' => [
						'title' => __('Center', 'master-addons' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right' => [
						'title' => __('Right', 'master-addons' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}}' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'ma_el_hotspot_view',
			[
				'label'   => __('View', 'master-addons' ),
				'type'    => Controls_Manager::HIDDEN,
				'default' => 'traditional',
			]
		);
		$this->end_controls_section();



		/*
		 * MA Hotspots Section
		 */
		$this->start_controls_section(
			'ma_el_hotspots_section',
			[
				'label'     => __('Hotspots', 'master-addons' ),
				'condition' => [
					'ma_el_hotspot_image[url]!' => '',
				]
			]
		);

		$repeater = new Repeater();

		$repeater->start_controls_tabs('ma_el_hotspots_repeater_section');

		$repeater->start_controls_tab('tab_content', ['label' => __('Content', 'master-addons' )]);

		$repeater->add_control(
			'ma_el_hotspot_type',
			[
				'label'   => __('Type', 'master-addons' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'text',
				'options' => [
					'none'  => [
						'title' => __('None', 'master-addons' ),
						'icon'  => 'eicon-editor-close',
					],
					'text' => [
						'title' => __('Text', 'master-addons' ),
						'icon' => 'eicon-text-area',
					],
					'icon' => [
						'title' => __('Icon', 'master-addons' ),
						'icon' => 'eicon-star',
					],
					'image' => [
						'title' => __('Image', 'master-addons' ),
						'icon' => 'eicon-image',
					],
				],
			]
		);

		$repeater->add_control(
			'ma_el_hotspot_text',
			[
				'default'   => __('+', 'master-addons' ),
				'type'      => Controls_Manager::TEXT,
				'label'     => __('Text', 'master-addons' ),
				'separator' => 'none',
				'dynamic'   => [
					'active' => true,
				],
				'condition'		=> [
					'ma_el_hotspot_type' => 'text'
				]
			]
		);

		$repeater->add_control(
			'ma_el_hotspot_selected_icon',
			array(
				'label'            => __('Icon', 'master-addons' ),
				'description'      => __('Please choose an icon from the list.', 'master-addons' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default'          => [
					'value'   => 'fa fa-search',
					'library' => 'fa-solid',
				],
				'render_type' => 'template',
				'condition'   => array(
					'ma_el_hotspot_type' => 'icon'
				)
			)
		);

		$repeater->add_control(
			'image',
			[
				'type' => Controls_Manager::MEDIA,
				'show_label' => false,
				'dynamic' => [
					'active' => true
				],
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'ma_el_hotspot_type' => 'image'
				],
			]
		);

		$repeater->add_control(
			'ma_el_hotspot_link',
			[
				'label'       => __('Link', 'master-addons' ),
				'description' => __('Active only when tolltips\' Trigger is set to Hover or if tooltip is disabled responsively, below a certain breakpoint.', 'master-addons' ),
				'type'        => Controls_Manager::URL,
				'label_block' => false,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder'        => esc_url(home_url('/')),
				'frontend_available' => true,
			]
		);

		$repeater->add_control(
			'ma_el_hotspot_content',
			[
				'label'   => __('Tooltip Content', 'master-addons' ),
				'type'    => Controls_Manager::WYSIWYG,
				'dynamic' => [
					'active' => true,
				],
				'default' => __('I am a tooltip for a hotspot', 'master-addons' ),
			]
		);

		//			$repeater->add_control(
		//				'ma_el_hotspot_item_id',
		//				[
		//					'label' 		=> __( 'CSS ID', 'master-addons' ),
		//					'type' 			=> Controls_Manager::TEXT,
		//					'default' 		=> '',
		//					'dynamic' 		=> [ 'active' => true ],
		//					'label_block' 	=> true,
		//					'title' 		=> __( 'Add your custom id WITHOUT the Pound key. e.g: my-id', 'master-addons' ),
		//				]
		//			);
		//			$repeater->add_control(
		//				'ma_el_hotspot_css_classes',
		//				[
		//					'label' 		=> __( 'CSS Classes', 'master-addons' ),
		//					'type' 			=> Controls_Manager::TEXT,
		//					'default' 		=> '',
		//					'prefix_class' 	=> '',
		//					'dynamic' 		=> [ 'active' => true ],
		//					'label_block' 	=> true,
		//					'title' 		=> __( 'Add your custom class WITHOUT the dot. e.g: my-class', 'master-addons' ),
		//				]
		//			);
		$repeater->end_controls_tab();



		$repeater->start_controls_tab('ma_el_hotspot_tab_style', ['label' => __('Style', 'master-addons' )]);

		$repeater->add_control(
			'ma_el_hotspot_default',
			[
				'label' => __('Default', 'master-addons' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$repeater->add_control(
			'ma_el_hotspot_color',
			[
				'label'     => __('Color', 'master-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .jltma-hotspots__wrapper' => 'color: {{VALUE}};',
				],
			]
		);


		$repeater->add_control(
			'ma_el_hotspot_background_color',
			[
				'label'     => __('Background Color', 'master-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .jltma-hotspots__wrapper'        => 'background-color: {{VALUE}};',
					'{{WRAPPER}} {{CURRENT_ITEM}} .jltma-hotspots__wrapper:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$repeater->add_responsive_control(
			'ma_el_hotspot_opacity',
			[
				'label' => __('Opacity (%)', 'master-addons' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' 	=> [
						'max'  => 1,
						'min'  => 0,
						'step' => 0.1,
					],
				],
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .jltma-hotspots-container {{CURRENT_ITEM}} .jltma-hotspots__wrapper' => 'opacity: {{SIZE}};',
				],
			]
		);

		$repeater->add_control(
			'ma_el_hotspot_hover',
			[
				'label' => __('Hover', 'master-addons' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$repeater->add_control(
			'ma_el_hotspot_color_hover',
			[
				'label'     => __('Color', 'master-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .jltma-hotspots-container {{CURRENT_ITEM}} .jltma-hotspots__wrapper:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$repeater->add_control(
			'ma_el_hotspot_background_color_hover',
			[
				'label'     => __('Background Color', 'master-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} .jltma-hotspots__wrapper:hover'        => 'background-color: {{VALUE}};',
					'{{WRAPPER}} {{CURRENT_ITEM}} .jltma-hotspots__wrapper:hover:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$repeater->add_responsive_control(
			'ma_el_hotspot_opacity_hover',
			[
				'label' => __('Opacity (%)', 'master-addons' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' 	=> [
						'max'  => 1,
						'min'  => 0,
						'step' => 0.1,
					],
				],
				'selectors' 	=> [
					'{{WRAPPER}} .jltma-hotspots-container {{CURRENT_ITEM}} .jltma-hotspots__wrapper:hover' => 'opacity: {{SIZE}};',
				],
			]
		);

		$repeater->end_controls_tab();


		$repeater->start_controls_tab('ma_el_hotspot_tab_position', ['label' => __('Position', 'master-addons' )]);

		$repeater->add_control(
			'ma_el_hotspot_position_horizontal',
			[
				'label'   => __('Horizontal position (%)', 'master-addons' ),
				'type'    => Controls_Manager::SLIDER,
				'range' 	=> [
					'px' 	=> [
						'min'  => 0,
						'max'  => 100,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'left: {{SIZE}}%;',
				],
			]
		);

		$repeater->add_control(
			'ma_el_hotspot_position_vertical',
			[
				'label'   => __('Vertical position (%)', 'master-addons' ),
				'type'    => Controls_Manager::SLIDER,
				'range' 	=> [
					'px' 	=> [
						'min'  => 0,
						'max'  => 100,
						'step' => 0.1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'top: {{SIZE}}%;',
				],
			]
		);

		$repeater->add_control(
			'ma_el_hotspot_tooltips_heading',
			[
				'label' => __('Tooltips', 'master-addons' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$repeater->add_control(
			'ma_el_hotspot_tooltip_position',
			[
				'label'   => __('Show to', 'master-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''       => __('Global', 'master-addons' ),
					'bottom' => __('Bottom', 'master-addons' ),
					'left'   => __('Left', 'master-addons' ),
					'top'    => __('Top', 'master-addons' ),
					'right'  => __('Right', 'master-addons' ),
				],
			]
		);


		$repeater->end_controls_tab();

		$repeater->end_controls_tabs();

		$this->add_control(
			'ma_el_hotspots',
			[
				'label'   => __('Hotspots', 'master-addons' ),
				'type'    => Controls_Manager::REPEATER,
				'default' => [
					[
						'text'                              => '+',
						'ma_el_hotspot_content'             => 'Hotspot #1',
						'ma_el_hotspot_position_horizontal' => [
							'size' => 50,
							'unit' => '%',
						],
						'ma_el_hotspot_position_vertical' => [
							'size' => 50,
							'unit' => '%',
						]
					],
					[
						'text'                              => '+',
						'ma_el_hotspot_position_horizontal' => [
							'size' => 40,
							'unit' => '%',
						],
						'ma_el_hotspot_position_vertical' => [
							'size' => 30,
							'unit' => '%',
						]
					],
					[
						'text'                              => '+',
						'ma_el_hotspot_position_horizontal' => [
							'size' => 80,
							'unit' => '%',
						],
						'ma_el_hotspot_position_vertical' => [
							'size' => 25,
							'unit' => '%',
						]
					],
				],
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ ma_el_hotspot_content }}}',
				'condition'   => [
					'ma_el_hotspot_image[url]!' => '',
				]
			]
		);


		$this->add_control(
			'ma_el_hotspot_pulse',
			[
				'label'        => __('Disable Pulse Effect?', 'master-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '""',
				'return_value' => 'none',
				'selectors'    => [
					'{{WRAPPER}} .jltma-hotspots__wrapper:before' => 'content: {{VALUE}};'
				]
			]
		);

		$this->end_controls_section();



		/*
		 * Tooltips
		 */

		$this->start_controls_section(
			'ma_el_hotspot_section_tooltips',
			[
				'label'     => __('Tooltips', 'master-addons' ),
				'condition' => [
					'ma_el_hotspot_image[url]!' => '',
				]
			]
		);

		$this->add_control(
			'ma_el_hotspot_position',
			[
				'label'   => __('Show Position', 'master-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'top',
				'options' => [
					'bottom' => __('Bottom', 'master-addons' ),
					'left'   => __('Left', 'master-addons' ),
					'top'    => __('Top', 'master-addons' ),
					'right'  => __('Right', 'master-addons' ),
				],
				'condition'		=> [
					'ma_el_hotspot_image[url]!' => '',
				],
				'frontend_available' => true
			]
		);

		$this->add_control(
			'jltma_tooltip_animation',
			[
				'label'   => esc_html__('Animation', 'master-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'shift-toward',
				'options' => [
					'shift-away'   => esc_html__('Shift-Away', 'master-addons' ),
					'shift-toward' => esc_html__('Shift-Toward', 'master-addons' ),
					'fade'         => esc_html__('Fade', 'master-addons' ),
					'scale'        => esc_html__('Scale', 'master-addons' ),
					'perspective'  => esc_html__('Perspective', 'master-addons' ),
				],
				'render_type'  => 'template',
			]
		);

		$this->add_control(
			'jltma_tooltip_arrow',
			[
				'label'   => esc_html__('Arrow', 'master-addons' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => true,
			]
		);

		$this->add_control(
			'jltma_tooltip_x_offset',
			[
				'label'   => esc_html__('Offset', 'master-addons' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
			]
		);

		$this->add_control(
			'jltma_tooltip_y_offset',
			[
				'label'   => esc_html__('Distance', 'master-addons' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
			]
		);


		$this->add_control(
			'jltma_tooltip_trigger',
			[
				'label'       => __('Trigger on Click', 'master-addons' ),
				'description' => __('Don\'t set yes when you set lightbox image with marker.', 'master-addons' ),
				'type'        => Controls_Manager::SWITCHER,
			]
		);



		$this->add_control(
			'ma_el_hotspot_margin',
			[
				'label'      => __('Margin', 'master-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors'  => [
					'{{WRAPPER}} .jltma-tooltip .jltma-tooltip-item .jltma-tooltip-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// $this->add_responsive_control(
		// 	'ma_el_hotspot_width',
		// 	[
		// 		'label'   => __('Maximum Width', 'master-addons' ),
		// 		'type'    => Controls_Manager::SLIDER,
		// 		'default' => [
		// 			'size' => 200,
		// 		],
		// 		'range' 	=> [
		// 			'px' 	=> [
		// 				'min' => 0,
		// 				'max' => 500,
		// 			],
		// 		],
		// 		'condition'		=> [
		// 			'ma_el_hotspot_image[url]!' => '',
		// 		],
		// 		'frontend_available' => true,
		// 	]
		// );

		$this->add_control(
			'ma_el_hotspot_disable',
			[
				'label'   => esc_html__('Disable On', 'master-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''       => esc_html__('None', 'master-addons' ),
					'tablet' => esc_html__('Tablet & Mobile', 'master-addons' ),
					'mobile' => esc_html__(
						'Mobile',
						'master-addons' 
					),
				],
				'frontend_available' => true,
				'selectors'          => [
					'(tablet){{WRAPPER}} .jltma-hotspot .jltma-tooltip-text' => 'display: none;',
					'(mobile){{WRAPPER}} .jltma-hotspot .jltma-tooltip-text' => 'display: none;',
				],

			]
		);
		$this->end_controls_section();




		/*
		 * MA Image Hotspot: Image Style Tab
		 */

		$this->start_controls_section(
			'ma_el_hotspot_section_style_image',
			[
				'label' => __('Image', 'master-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'ma_el_hotspot_opacity',
			[
				'label'   => __('Opacity (%)', 'master-addons' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' 	=> [
					'px' 	=> [
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' 	=> [
					'{{WRAPPER}} .jltma-hotspots-wrapper img' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'ma_el_hotspot_image_border',
				'label'    => __('Image Border', 'master-addons' ),
				'selector' => '{{WRAPPER}} .jltma-hotspots-wrapper img',
			]
		);

		$this->add_control(
			'ma_el_hotspot_image_border_radius',
			[
				'label'      => __('Border Radius', 'master-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .jltma-hotspots-wrapper img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'ma_el_hotspot_image_box_shadow',
				'selector'  => '{{WRAPPER}} .jltma-hotspots-wrapper img',
				'separator' => '',
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name'     => 'ma_el_hotspot_image_css_filters',
				'selector' => '{{WRAPPER}} .jltma-hotspots-wrapper img',
			]
		);

		$this->end_controls_section();


		/*
		 * MA Hotspots: Hotspots
		 */

		$this->start_controls_section(
			'ma_el_hotspots_section_style',
			[
				'label' => __('Hotspots', 'master-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'ma_el_hotspots_padding',
			[
				'label'      => __('Text Padding', 'master-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors'  => [
					'{{WRAPPER}} .jltma-hotspots-wrapper .jltma-hotspots__wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'ma_el_hotspots_border_radius',
			[
				'label'   => __('Border Radius', 'master-addons' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 100,
				],
				'range' 	=> [
					'px' 	=> [
						'max' => 100,
						'min' => 0,
					],
				],
				'selectors' 	=> [
					'{{WRAPPER}} .jltma-hotspots-wrapper .jltma-hotspots__wrapper'        => 'border-radius: {{SIZE}}px;',
					'{{WRAPPER}} .jltma-hotspots-wrapper .jltma-hotspots__wrapper:before' => 'border-radius: {{SIZE}}px;',
					'{{WRAPPER}} .jltma-hotspots-wrapper .jltma-hotspot__text' => 'border-radius: {{SIZE}}px;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'ma_el_hotspots_typography',
				'selector'  => '{{WRAPPER}} .jltma-hotspots-wrapper .jltma-hotspots__wrapper',
				'scheme'    => Typography::TYPOGRAPHY_3,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			MA_Group_Control_Transition::get_type(),
			[
				'name'     => 'ma_el_hotspots',
				'selector' => '{{WRAPPER}} .jltma-hotspots-wrapper .jltma-hotspots__wrapper,
									{{WRAPPER}} .jltma-hotspots-wrapper .jltma-hotspots__wrapper:before',
			]
		);

		$this->start_controls_tabs('tabs_ma_el_hotspots_style');

		$this->start_controls_tab(
			'tab_ma_el_hotspots_default',
			[
				'label' => __('Default', 'master-addons' ),
			]
		);

		$this->add_responsive_control(
			'ma_el_hotspots_opacity',
			[
				'label'   => __('Opacity (%)', 'master-addons' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' 	=> [
					'px' 	=> [
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' 	=> [
					'{{WRAPPER}} .jltma-hotspots-wrapper .jltma-hotspots__wrapper' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_responsive_control(
			'ma_el_hotspots_size',
			[
				'label'   => __('Size', 'master-addons' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' 	=> [
					'px' 	=> [
						'max'  => 2,
						'min'  => 0.5,
						'step' => 0.01,
					],
				],
				'selectors' 	=> [
					'{{WRAPPER}} .jltma-hotspots-wrapper .jltma-tooltip-content' => 'transform: scale({{SIZE}})',
				],
			]
		);

		$this->add_control(
			'ma_el_hotspots_color',
			[
				'label'     => __('Color', 'master-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => [
					'{{WRAPPER}} .jltma-hotspots-wrapper .jltma-hotspot__text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'ma_el_hotspots_background_color',
			[
				'label'   => __('Background Color', 'master-addons' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .jltma-hotspots-wrapper .jltma-hotspots__wrapper'
					=>  'background-color: {{VALUE}};',
					'{{WRAPPER}} .jltma-hotspots-wrapper .jltma-hotspots__wrapper .jltma-hotspots__wrapper:before'
					=>  'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'ma_el_hotspots_border',
				'label'    => __('Text Border', 'master-addons' ),
				'selector' => '{{WRAPPER}} .jltma-hotspots-wrapper .jltma-hotspots__wrapper',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'ma_el_hotspots_box_shadow',
				'selector'  => '{{WRAPPER}} .jltma-hotspots-wrapper .jltma-hotspots__wrapper',
				'separator' => ''
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_ma_el_hotspots_hover',
			[
				'label' => __('Hover', 'master-addons' ),
			]
		);

		$this->add_responsive_control(
			'ma_el_hotspots_hover_opacity',
			[
				'label'   => __('Opacity (%)', 'master-addons' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' 	=> [
					'px' 	=> [
						'max'  => 1,
						'min'  => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' 	=> [
					'{{WRAPPER}} .jltma-hotspots-wrapper:hover .jltma-hotspots__wrapper' => 'opacity: {{SIZE}};',
				],
			]
		);

		$this->add_responsive_control(
			'ma_el_hotspots_hover_size',
			[
				'label'   => __('Size', 'master-addons' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' 	=> [
					'px' 	=> [
						'max'  => 2,
						'min'  => 0.5,
						'step' => 0.01,
					],
				],
				'selectors' 	=> [
					'{{WRAPPER}} .jltma-hotspots-wrapper:hover .jltma-hotspots__wrapper' =>
					'transform: scale({{SIZE}})',
				],
			]
		);

		$this->add_control(
			'ma_el_hotspots_hover_color',
			[
				'label'     => __('Color', 'master-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .jltma-hotspots-wrapper:hover .jltma-hotspot__text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'ma_el_hotspots_hover_background_color',
			[
				'label'   => __('Background Color', 'master-addons' ),
				'type'    => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .jltma-hotspots-wrapper:hover .jltma-hotspots__wrapper'        => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .jltma-hotspots-wrapper:hover .jltma-hotspots__wrapper:before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'ma_el_hotspots_hover_border',
				'label'    => __('Text Border', 'master-addons' ),
				'selector' => '{{WRAPPER}} .jltma-hotspots-wrapper:hover .jltma-hotspots__wrapper',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'ma_el_hotspots_hover_box_shadow',
				'selector'  => '{{WRAPPER}} .jltma-hotspots-wrapper:hover .jltma-hotspots__wrapper',
				'separator' => ''
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();



		/*
		 * MA Hotspots: Tooltips
		 */


		$this->start_controls_section(
			'ma_el_hotspot_tooltips_style',
			[
				'label' => __('Tooltips', 'master-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_control(
			'ma_el_hotspot_tooltips_align',
			[
				'label'   => __('Alignment', 'master-addons' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => Master_Addons_Helper::jltma_content_alignment(),
				'selectors' => [
					'{{WRAPPER}} .jltma-hotspot-tooltip.jltma-hotspot-tooltip-{{ID}}' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'ma_el_hotspot_tooltips_padding',
			[
				'label'      => __('Padding', 'master-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors'  => [
					'{{WRAPPER}} .jltma-hotspots-container .jltma-tooltip-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'ma_el_hotspot_tooltips_border_radius',
			[
				'label'      => __('Border Radius', 'master-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .jltma-hotspots-container .jltma-tooltip-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'ma_el_hotspot_tooltips_background_color',
			[
				'label'     => __('Background Color', 'master-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .jltma-hotspot .jltma-tooltip-text' => 'background-color: {{VALUE}};',
				]
			]
		);

		$this->add_control(
			'ma_el_hotspot_tooltips_color',
			[
				'label'     => __('Color', 'master-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .jltma-hotspots-container .jltma-tooltip-text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'ma_el_hotspot_tooltips_border',
				'label'    => __('Border', 'master-addons' ),
				'selector' => '{{WRAPPER}} .jltma-hotspots-container .jltma-tooltip-text',
			]
		);


		$this->add_control(
			'ma_el_hotspot_tooltips_arrow_color',
			[
				'label'     => __('Arrow Color', 'master-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .jltma-tooltip .jltma-tooltip-item.tooltip-top .jltma-tooltip-text:after'    => 'border-top-color: {{VALUE}};',
					'{{WRAPPER}} .jltma-tooltip .jltma-tooltip-item.tooltip-right .jltma-tooltip-text:after'  => 'border-right-color: {{VALUE}};',
					'{{WRAPPER}} .jltma-tooltip .jltma-tooltip-item.tooltip-bottom .jltma-tooltip-text:after' => 'border-bottom-color: {{VALUE}};',
					'{{WRAPPER}} .jltma-tooltip .jltma-tooltip-item.tooltip-left .jltma-tooltip-text:after'   => 'border-left-color: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'ma_el_hotspot_tooltips_typography',
				'scheme'   => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .jltma-tooltip .jltma-tooltip-item .jltma-tooltip-text',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'ma_el_hotspot_tooltips_box_shadow',
				'selector' => '{{WRAPPER}} .jltma-tooltip .jltma-tooltip-item .jltma-tooltip-text',
			]
		);
		$this->end_controls_section();




		/**
		 * Content Tab: Docs Links
		 */
		$this->start_controls_section(
			'jltma_section_help_docs',
			[
				'label' => esc_html__('Help Docs', 'master-addons' ),
			]
		);


		$this->add_control(
			'help_doc_1',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => sprintf(esc_html__('%1$s Live Demo %2$s', 'master-addons' ), '<a href="https://master-addons.com/demos/image-hotspot/" target="_blank" rel="noopener">', '</a>'),
				'content_classes' => 'jltma-editor-doc-links',
			]
		);

		$this->add_control(
			'help_doc_2',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => sprintf(esc_html__('%1$s Documentation %2$s', 'master-addons' ), '<a href="https://master-addons.com/docs/addons/image-hotspot/?utm_source=widget&utm_medium=panel&utm_campaign=dashboard" target="_blank" rel="noopener">', '</a>'),
				'content_classes' => 'jltma-editor-doc-links',
			]
		);

		$this->add_control(
			'help_doc_3',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => sprintf(esc_html__('%1$s Watch Video Tutorial %2$s', 'master-addons' ), '<a href="https://www.youtube.com/watch?v=IDAd_d986Hg" target="_blank" rel="noopener">', '</a>'),
				'content_classes' => 'jltma-editor-doc-links',
			]
		);
		$this->end_controls_section();




		//Upgrade to Pro
		if (ma_el_fs()->is_not_paying()) {

			$this->start_controls_section(
				'jltma_section_pro_style_section',
				[
					'label' => esc_html__('Upgrade to Pro Version for More Features', 'master-addons' ),
				]
			);

			$this->add_control(
				'jltma_control_get_pro_style_tab',
				[
					'label'   => esc_html__('Unlock more possibilities', 'master-addons' ),
					'type'    => Controls_Manager::CHOOSE,
					'options' => [
						'1' => [
							'title' => esc_html__('', 'master-addons' ),
							'icon'  => 'fa fa-unlock-alt',
						],
					],
					'default'     => '1',
					'description' => '<span class="pro-feature"> Upgrade to  <a href="' . ma_el_fs()->get_upgrade_url() . '" target="_blank">Pro Version</a> for more Elements with Customization Options.</span>'
				]
			);

			$this->end_controls_section();
		}
	}




	protected function render()
	{
		$settings = $this->get_settings_for_display();

		if (empty($settings['ma_el_hotspot_image']['url']))
			return;

		$this->add_render_attribute('ma_el_hotspot_wrapper', 'class', 'jltma-hotspots-wrapper');
		$this->add_render_attribute('ma_el_hotspot_container', 'class', 'jltma-hotspots-container');
		$this->add_render_attribute('ma_el_tooltip_wrapper', ['class' => 'jltma-tooltip']);
?>

		<div <?php echo $this->get_render_attribute_string('ma_el_hotspot_wrapper'); ?>>
			<?php echo Group_Control_Image_Size::get_attachment_image_html($settings, 'ma_el_hotspot_image'); ?>



			<?php if ($settings['ma_el_hotspots']) { ?>
				<div <?php echo $this->get_render_attribute_string('ma_el_hotspot_container'); ?>>

					<?php foreach ($settings['ma_el_hotspots'] as $index => $item) {
						//								print_r($item);

						$has_icon         = false;
						$hotspot_tag      = 'div';
						$hotspot_key      = $this->get_repeater_setting_key('hotspot', 'ma_el_hotspots', $index);
						$wrapper_key      = $this->get_repeater_setting_key('wrapper', 'ma_el_hotspots', $index);
						$icon_key         = $this->get_repeater_setting_key('icon', 'ma_el_hotspots', $index);
						$icon_wrapper_key = $this->get_repeater_setting_key('icon-wrapper', 'ma_el_hotspots', $index);
						$text_key         = $this->get_repeater_setting_key('text', 'ma_el_hotspots', $index);
						$tooltip_key      = $this->get_repeater_setting_key('content', 'ma_el_hotspots', $index);

						$content_id = $this->get_id() . '_' . $item['_id'];


						$this->add_render_attribute([
							$wrapper_key => [
								'class' => 'jltma-hotspots__wrapper',
							],
							$text_key => [
								'class' => 'jltma-hotspot__text',
							],
							$tooltip_key => [
								'class' => 'jltma-tooltip-text',
								'id'    => 'jltma-tooltip-text-' . $content_id,
							],
							$hotspot_key => [
								'class' => [
									'elementor-repeater-item-' . $item['_id'],
									'jltma-hotspot',
								],
								'data-tippy-content'  => $this->parse_text_editor($item['ma_el_hotspot_content']),
								'data-tippy-class' 			=> [
									'jltma-global',
									'jltma-hotspot-tooltip',
									'jltma-hotspot-tooltip-' . $this->get_id(),
								]
							],
						]);


						// Tooltip settings
						$this->add_render_attribute($hotspot_key, 'class', 'jltma-tooltip-item');
						$this->add_render_attribute($hotspot_key, 'data-tippy', '', true);

						$hotspot_position = !empty($item['ma_el_hotspot_tooltip_position']) ? $item['ma_el_hotspot_tooltip_position'] : $settings['ma_el_hotspot_position'];
						$this->add_render_attribute($hotspot_key, 'data-tippy-placement', $hotspot_position, true);

						if ($settings['jltma_tooltip_animation']) {
							$this->add_render_attribute($hotspot_key, 'data-tippy-animation', $settings['jltma_tooltip_animation'], true);
						}

						if ($settings['jltma_tooltip_x_offset']['size'] or $settings['jltma_tooltip_y_offset']['size']) {
							$this->add_render_attribute($hotspot_key, 'data-tippy-offset', '[' . esc_attr($settings['jltma_tooltip_x_offset']['size']) . ',' . esc_attr($settings['jltma_tooltip_y_offset']['size']) . ']', true);
						}

						if ('yes' == $settings['jltma_tooltip_arrow']) {
							$this->add_render_attribute($hotspot_key, 'data-tippy-arrow', 'true', true);
						} else {
							$this->add_render_attribute($hotspot_key, 'data-tippy-arrow', 'false', true);
						}

						if ('yes' == $settings['jltma_tooltip_trigger']) {
							$this->add_render_attribute($hotspot_key, 'data-tippy-trigger', 'click', true);
						}

						// if ($settings['ma_el_hotspot_width']['size']) {
						// 	$this->add_render_attribute($hotspot_key, 'data-tippy-max-width', $settings['ma_el_hotspot_width']['size'], true);
						// }




						if ('icon' === $item['ma_el_hotspot_type'] && (!empty($item['icon']) || !empty($item['ma_el_hotspot_selected_icon']['value']))) {
							$migrated = isset($item['__fa4_migrated']['ma_el_hotspot_selected_icon']);
							$is_new   = empty($item['icon']) && Icons_Manager::is_migration_allowed();

							$has_icon = true;

							$this->add_render_attribute($icon_wrapper_key, 'class', [
								'jltma-hotspot__icon',
								'jltma-icon',
								'jltma-icon-support--svg',
							]);

							if (!empty($item['icon'])) {
								$this->add_render_attribute($icon_key, [
									'class'       => esc_attr($item['icon']),
									'aria-hidden' => 'true',
								]);
							}
						}

						//								if ( $item['_item_id'] ) {
						//									$this->add_render_attribute( $hotspot_key, 'id', $item['ma_el_hotspot_item_id'] );
						//								}

						//								if ( $item['css_classes'] ) {
						//									$this->add_render_attribute( $hotspot_key, 'class', $item['ma_el_hotspot_css_classes'] );
						//								}

						if (!empty(trim($item['ma_el_hotspot_link']['url']))) {

							$hotspot_tag = 'a';

							$this->add_render_attribute($hotspot_key, 'href', $item['ma_el_hotspot_link']['url']);

							if ($item['ma_el_hotspot_link']['is_external']) {
								$this->add_render_attribute($hotspot_key, 'target', '_blank');
							}

							if (!empty($item['ma_el_hotspot_link']['nofollow'])) {
								$this->add_render_attribute($hotspot_key, 'rel', 'nofollow');
							}
						}

						// Tooltip Item
						$this->add_render_attribute('jltma_hotspot_item', 'class', ['jltma-tooltip-item']);

					?>

						<<?php echo esc_attr($hotspot_tag); ?> <?php echo $this->get_render_attribute_string($hotspot_key); ?>>

							<div <?php echo $this->get_render_attribute_string('ma_el_tooltip_wrapper'); ?>>
								<div <?php echo $this->get_render_attribute_string('jltma_hotspot_item'); ?>>
									<div class="jltma-tooltip-content">
										<span <?php echo $this->get_render_attribute_string($wrapper_key); ?>>
											<span <?php echo $this->get_render_attribute_string($text_key); ?>>
												<?php
												if ('icon' === $item['ma_el_hotspot_type']) {
													if ($has_icon) { ?>
														<span <?php echo $this->get_render_attribute_string($icon_wrapper_key); ?>>
															<?php if ($is_new || $migrated) {
																Icons_Manager::render_icon($item['ma_el_hotspot_selected_icon'], ['aria-hidden' => 'true']);
															} else {
															?>
																<i <?php echo $this->get_render_attribute_string($icon_key); ?>></i>
															<?php
															}
															?>
														</span>
												<?php }
												} elseif ($item['ma_el_hotspot_type'] === 'image') {
													echo wp_get_attachment_image($item['image']['id']);
												} else {
													echo $this->parse_text_editor($item['ma_el_hotspot_text']);
												} ?>
											</span>
										</span>
									</div>
								</div>
							</div>

						</<?php echo esc_attr($hotspot_tag); ?>>

					<?php } ?>

				</div>

			<?php } ?>

		</div>

<?php
	}
}
