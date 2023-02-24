<?php

namespace MasterAddons\Modules;

use \Elementor\Controls_Manager;

use MasterAddons\Inc\Helper\Master_Addons_Helper;

/**
 * Author Name: Liton Arefin
 * Author URL: https://jeweltheme.com
 * Date: 1/2/20
 */

if (!defined('ABSPATH')) {
	exit;
} // Exit if accessed directly.

class JLTMA_Extension_Entrance_Animation
{

	/*
	 * Instance of this class
	 */
	private static $instance = null;


	public function __construct()
	{

		// Add new controls to advanced tab globally
		add_action("elementor/element/after_section_end", array($this, 'jltma_section_add_transition_controls'), 18, 3);
	}


	public function jltma_section_add_transition_controls($widget, $section_id, $args)
	{

		// Anchor element sections
		$target_sections = array('section_custom_css');

		if (!defined('ELEMENTOR_PRO_VERSION')) {
			$target_sections[] = 'section_custom_css_pro';
		}

		if (!in_array($section_id, $target_sections)) {
			return;
		}

		// Adds transition options to all elements
		// ---------------------------------------------------------------------
		$widget->start_controls_section(
			'ma_el_section_common_inview_transition',
			array(
				'label'     => JLTMA_BADGE . __(' Entrance Animation', 'master-addons' ),
				'tab'       => Controls_Manager::TAB_ADVANCED
			)
		);

		$widget->add_control(
			'ma_el_animation_name',
			array(
				'label'   => __('Animation', 'master-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => Master_Addons_Helper::jltma_animation_options(),
				'default'            => '',
				'prefix_class'       => 'jltma-appear-watch-animation jltma-animated jltma-animated-once ',
				'label_block'        => false
			)
		);


		$widget->add_control(
			'ma_el_animation_duration',
			array(
				'label'     => __('Duration', 'master-addons' ) . ' (ms)',
				'type'      => Controls_Manager::NUMBER,
				'default'   => '',
				'min'       => 0,
				'step'      => 1,
				'selectors'    => array(
					'{{WRAPPER}}' => 'animation-duration:{{SIZE}}ms;'
				),
				'condition' => array(
					'ma_el_animation_name!' => ''
				),
				'render_type' => 'template'
			)
		);

		$widget->add_control(
			'ma_el_animation_delay',
			array(
				'label'     => __('Delay', 'master-addons' ) . ' (ms)',
				'type'      => Controls_Manager::NUMBER,
				'default'   => '',
				'min'       => 0,
				'step'      => 1,
				'selectors' => array(
					'{{WRAPPER}}' => 'animation-delay:{{SIZE}}ms;'
				),
				'condition' => array(
					'ma_el_animation_name!' => ''
				)
			)
		);

		$widget->add_control(
			'ma_el_animation_easing',
			array(
				'label'   => __('Easing', 'master-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					''                       =>  esc_html__('Default', 'master-addons' ),
					'initial'                =>  esc_html__('Initial', 'master-addons' ),

					'linear'                 =>  esc_html__('Linear', 'master-addons' ),
					'ease-in' 				 =>  esc_html__('Ease In', 'master-addons' ),
					'ease-out'               =>  esc_html__('Ease Out', 'master-addons' ),
					'0.19,1,0.22,1'          =>  esc_html__('Ease In Out', 'master-addons' ),

					'0.47,0,0.745,0.715'     =>  esc_html__('Sine In', 'master-addons' ),
					'0.39,0.575,0.565,1'     =>  esc_html__('Sine Out', 'master-addons' ),
					'0.445,0.05,0.55,0.95'   =>  esc_html__('Sine In Out', 'master-addons' ),

					'0.55,0.085,0.68,0.53'   =>  esc_html__('Quad In', 'master-addons' ),
					'0.25,0.46,0.45,0.94'    =>  esc_html__('Quad Out', 'master-addons' ),
					'0.455,0.03,0.515,0.955' =>  esc_html__('Quad In Out', 'master-addons' ),

					'0.55,0.055,0.675,0.19'  =>  esc_html__('Cubic In', 'master-addons' ),
					'0.215,0.61,0.355,1'     =>  esc_html__('Cubic Out', 'master-addons' ),
					'0.645,0.045,0.355,1'    =>  esc_html__('Cubic In Out', 'master-addons' ),

					'0.895,0.03,0.685,0.22'  =>  esc_html__('Quart In', 'master-addons' ),
					'0.165,0.84,0.44,1'      =>  esc_html__('Quart Out', 'master-addons' ),
					'0.77,0,0.175,1'         =>  esc_html__('Quart In Out', 'master-addons' ),

					'0.895,0.03,0.685,0.22'  =>  esc_html__('Quint In', 'master-addons' ),
					'0.895,0.03,0.685,0.22'  =>  esc_html__('Quint Out', 'master-addons' ),
					'0.895,0.03,0.685,0.22'  =>  esc_html__('Quint In Out', 'master-addons' ),

					'0.95,0.05,0.795,0.035'  =>  esc_html__('Expo In', 'master-addons' ),
					'0.19,1,0.22,1'          =>  esc_html__('Expo Out', 'master-addons' ),
					'1,0,0,1'                =>  esc_html__('Expo In Out', 'master-addons' ),

					'0.6,0.04,0.98,0.335'    =>  esc_html__('Circ In', 'master-addons' ),
					'0.075,0.82,0.165,1'     =>  esc_html__('Circ Out', 'master-addons' ),
					'0.785,0.135,0.15,0.86'  =>  esc_html__('Circ In Out', 'master-addons' ),

					'0.6,-0.28,0.735,0.045'  =>  esc_html__('Back In', 'master-addons' ),
					'0.175,0.885,0.32,1.275' =>  esc_html__('Back Out', 'master-addons' ),
					'0.68,-0.55,0.265,1.55'  =>  esc_html__('Back In Out', 'master-addons' )
				),
				'selectors' => array(
					'{{WRAPPER}}' => 'animation-timing-function:cubic-bezier({{VALUE}});'
				),
				'condition' => array(
					'ma_el_animation_name!' => ''
				),
				'default'      => '',
				'return_value' => ''
			)
		);

		$widget->add_control(
			'ma_el_animation_count',
			array(
				'label'   => esc_html__('Repeat Count', 'master-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					''  => esc_html__('Default', 'master-addons' ),
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'infinite' => esc_html__('Infinite', 'master-addons' )
				),
				'selectors' => array(
					'{{WRAPPER}}' => 'animation-iteration-count:{{VALUE}};opacity:1;' // opacity is required to prevent flick between repetitions
				),
				'condition' => array(
					'ma_el_animation_name!' => ''
				),
				'default'      => ''
			)
		);

		$widget->end_controls_section();
	}


	public static function get_instance()
	{
		if (!self::$instance) {
			self::$instance = new self;
		}
		return self::$instance;
	}
}

JLTMA_Extension_Entrance_Animation::get_instance();
