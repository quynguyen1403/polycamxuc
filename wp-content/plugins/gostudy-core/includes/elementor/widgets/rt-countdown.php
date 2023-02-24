<?php
/*
 * This template can be overridden by copying it to yourtheme/gostudy-core/elementor/widgets/rt-countdown.php.
*/
namespace RTAddons\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use RTAddons\Templates\RTCountDown;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use RTAddons\Gostudy_Global_Variables as Gostudy_Globals;


class RT_CountDown extends Widget_Base
{

	public function get_name()
	{
		return 'rt-countdown';
	}

	public function get_title()
	{
		return esc_html__('RT Countdown Timer', 'gostudy-core');
	}

	public function get_icon()
	{
		return 'rt-countdown';
	}

	public function get_categories()
	{
		return ['rt-extensions'];
	}

	public function get_script_depends()
	{
		return [
			'jquery-countdown',
			'rt-elementor-extensions-widgets',
		];
	}

	protected function register_controls() {
		/* Start General Settings Section */
		$this->start_controls_section( 'rt_countdown_section',
			array(
				'label' => esc_html__( 'Countdown Timer Settings', 'gostudy-core' ),
			)
		);

		$this->add_control( 'countdown_year',
			array(
				'label'       => esc_html__( 'Year', 'gostudy-core' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter your title', 'gostudy-core' ),
				'default'     => esc_html__( '2020', 'gostudy-core' ),
				'label_block' => true,
				'description' => esc_html__( 'Example: 2020', 'gostudy-core' ),
			)
		);

		$this->add_control( 'countdown_month',
			array(
				'label'       => esc_html__( 'Month', 'gostudy-core' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( '12', 'gostudy-core' ),
				'default'     => esc_html__( '12', 'gostudy-core' ),
				'label_block' => true,
				'description' => esc_html__( 'Example: 12', 'gostudy-core' ),
			)
		);

		$this->add_control( 'countdown_day',
			array(
				'label'       => esc_html__( 'Day', 'gostudy-core' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( '31', 'gostudy-core' ),
				'default'     => esc_html__( '31', 'gostudy-core' ),
				'label_block' => true,
				'description' => esc_html__( 'Example: 31', 'gostudy-core' ),
			)
		);

		$this->add_control( 'countdown_hours',
			array(
				'label'       => esc_html__( 'Hours', 'gostudy-core' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( '24', 'gostudy-core' ),
				'default'     => esc_html__( '24', 'gostudy-core' ),
				'label_block' => true,
				'description' => esc_html__( 'Example: 24', 'gostudy-core' ),
			)
		);

		$this->add_control( 'countdown_min',
			array(
				'label'       => esc_html__( 'Minutes', 'gostudy-core' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( '59', 'gostudy-core' ),
				'default'     => esc_html__( '59', 'gostudy-core' ),
				'label_block' => true,
				'description' => esc_html__( 'Example: 59', 'gostudy-core' ),
			)
		);

		/*End General Settings Section*/
		$this->end_controls_section();

		/*-----------------------------------------------------------------------------------*/
		/*  Button Section
		/*-----------------------------------------------------------------------------------*/

		$this->start_controls_section( 'rt_countdown_content_section',
			array(
				'label' => esc_html__( 'Countdown Timer Content', 'gostudy-core' ),
			)
		);

		$this->add_control( 'hide_day',
			array(
				'label'        => esc_html__( 'Hide Days?', 'gostudy-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'gostudy-core' ),
				'label_off'    => esc_html__( 'Off', 'gostudy-core' ),
				'return_value' => 'yes',
			)
		);

		$this->add_control( 'hide_hours',
			array(
				'label'        => esc_html__( 'Hide Hours?', 'gostudy-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'gostudy-core' ),
				'label_off'    => esc_html__( 'Off', 'gostudy-core' ),
				'return_value' => 'yes',
			)
		);

		$this->add_control( 'hide_minutes',
			array(
				'label'        => esc_html__( 'Hide Minutes?', 'gostudy-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'gostudy-core' ),
				'label_off'    => esc_html__( 'Off', 'gostudy-core' ),
				'return_value' => 'yes',
			)
		);

		$this->add_control( 'hide_seconds',
			array(
				'label'        => esc_html__( 'Hide Seconds?', 'gostudy-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'gostudy-core' ),
				'label_off'    => esc_html__( 'Off', 'gostudy-core' ),
				'return_value' => 'yes',
			)
		);

		$this->add_control( 'show_value_names',
			array(
				'label'        => esc_html__( 'Show Value Names?', 'gostudy-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'gostudy-core' ),
				'label_off'    => esc_html__( 'Off', 'gostudy-core' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'prefix_class' => 'show_value_names-',
			)
		);

		$this->add_control( 'show_separating',
			array(
				'label'        => esc_html__( 'Show Separating?', 'gostudy-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'On', 'gostudy-core' ),
				'label_off'    => esc_html__( 'Off', 'gostudy-core' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'prefix_class' => 'show_separating-',
			)
		);
		$this->add_responsive_control(
			'align',
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
				'prefix_class' => 'elementor%s-align-',
				'default' => 'center',
			]
		);

		/*End General Settings Section*/
		$this->end_controls_section();

		$this->start_controls_section(
			'countdown_style_section',
			array(
				'label' => esc_html__( 'Style', 'gostudy-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control( 'size',
			array(
				'label'   => esc_html__( 'Countdown Size', 'gostudy-core' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'large'  => esc_html__( 'Large', 'gostudy-core' ),
					'medium' => esc_html__( 'Medium', 'gostudy-core' ),
					'small'  => esc_html__( 'Small', 'gostudy-core' ),
					'custom' => esc_html__( 'Custom', 'gostudy-core' ),
				],
				'default' => 'large'
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'label'     => esc_html__( 'Number Typography', 'gostudy-core' ),
				'name'      => 'custom_fonts_number',
				'selector'  => '{{WRAPPER}} .rt-countdown .countdown-section',
				'condition' => [
					'size' => 'custom'
				]
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'label'     => esc_html__( 'Text Typography', 'gostudy-core' ),
				'name'      => 'custom_fonts_text',
				'selector'  => '{{WRAPPER}} .rt-countdown .countdown-section .countdown-period',
				'condition' => [
					'size' => 'custom'
				]
			)
		);

		$this->add_control(
			'number_text_color',
			array(
				'label'     => esc_html__( 'Number Color', 'gostudy-core' ),
				'type'      => Controls_Manager::COLOR,
				'default' => Gostudy_Globals::get_h_font_color(),
				'selectors' => [
					'{{WRAPPER}} .rt-countdown .countdown-section .countdown-amount' => 'color: {{VALUE}};',
				],
			)
		);

		$this->add_control(
			'period_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'gostudy-core' ),
				'type'      => Controls_Manager::COLOR,
				'default' => Gostudy_Globals::get_main_font_color(),
				'selectors' => [
					'{{WRAPPER}} .rt-countdown .countdown-section .countdown-period' => 'color: {{VALUE}};',
				],
			)
		);

		$this->add_control(
			'separating_color',
			array(
				'label'     => esc_html__( 'Separate Color', 'gostudy-core' ),
				'type'      => Controls_Manager::COLOR,
				'default' => Gostudy_Globals::get_primary_color(),
				'selectors' => [
					'{{WRAPPER}}.show_separating-yes .rt-countdown .countdown-amount:after,
					{{WRAPPER}}.show_separating-yes .rt-countdown .countdown-amount:before'  => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'show_separating' => 'yes'
				]
			)
		);

		$this->add_responsive_control(
			'separating_size',
			[
				'label' => esc_html__('Separate Size', 'gostudy-core'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => ['max' => 20],
				],
				'selectors' => [
					'{{WRAPPER}}.show_separating-yes .rt-countdown .countdown-amount:after,
					{{WRAPPER}}.show_separating-yes .rt-countdown .countdown-amount:before' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'separating_position',
			[
				'label' => esc_html__('Separate Position', 'gostudy-core'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => ['max' => 20],
				],
				'selectors' => [
					'{{WRAPPER}}.show_separating-yes .rt-countdown .countdown-amount:after' => 'transform: translateX(50%) translateY(calc(50% - 8px + {{SIZE}}{{UNIT}}));',
					'{{WRAPPER}}.show_separating-yes .rt-countdown .countdown-amount:before' => 'transform: translateX(50%) translateY(calc(-50% - {{SIZE}}{{UNIT}}));',
				],
			]
		);

		/*End Style Section*/
		$this->end_controls_section();
	}

	protected function render()
	{
		$atts = $this->get_settings_for_display();

		$countdown = new RTCountDown();
		$countdown->render($this, $atts);
	}
}
