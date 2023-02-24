<?php

namespace MasterAddons\Addons;

// Elementor Classes
use \Elementor\Widget_Base;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Core\Schemes\Typography;


use MasterAddons\Inc\Helper\Master_Addons_Helper;

/**
 * Author Name: Liton Arefin
 * Author URL : https: //jeweltheme.com
 * Date       : 9/29/19
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

/**
 * News Ticker Widget
 */
class JLTMA_News_Ticker extends Widget_Base
{


	public function get_name()
	{
		return 'ma-news-ticker';
	}
	public function get_title()
	{
		return __('News Ticker', 'master-addons' );
	}

	public function get_categories()
	{
		return ['master-addons'];
	}

	public function get_icon()
	{
		return 'jltma-icon eicon-posts-ticker';
	}

	public function get_keywords()
	{
		return ['blog', 'latest news', 'latest blog', 'latest', 'news', 'scroll', 'scrolling', 'ticker', 'report', 'message', 'information',];
	}

	public function get_help_url()
	{
		return 'https://master-addons.com/demos/news-ticker/';
	}

	public function get_script_depends()
	{
		return [
			'ma-news-ticker',
			'master-addons-scripts'
		];
	}


	protected function register_controls()
	{

		$this->start_controls_section(
			'ma_el_news_ticker_type_section',
			[
				'label' => __('News Ticker Type', 'master-addons' ),
			]
		);

		$this->add_control(
			'ma_el_news_ticker_type',
			[
				'label'   => __('Ticker Type', 'master-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'content',
				'options' => [
					'content' => __('Content', 'master-addons' ),
					'feed'    => __('RSS Feed', 'master-addons' ),
				],
			]
		);

		$this->end_controls_section();


		/*
             * RSS Feed Options
             */
		$this->start_controls_section(
			'ma_el_news_ticker_feed_section',
			[
				'label'     => __('RSS Feed Options', 'master-addons' ),
				'condition' => [
					'ma_el_news_ticker_type' => 'feed'
				]
			]
		);

		$this->add_control(
			'ma_el_news_ticker_feed_url',
			[
				'label'       => __('RSS Feed URL', 'master-addons' ),
				'type'        => Controls_Manager::TEXTAREA,
				'placeholder' => 'https://jeweltheme.com/feed/',


			]
		);

		$this->add_control(
			'ma_el_news_ticker_feed_posts',
			[
				'label'   => __('Limit Posts', 'master-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 30,
				'step'    => 1,
				'default' => 5,
			]
		);

		$this->add_control(
			'ma_el_news_ticker_feed_animation_styles',
			[
				'label'   => __('Animation Styles', 'master-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'slideFastSynced',
				'options' => [
					'slide'           => __('Slide', 'master-addons' ),
					'show'            => __('Show', 'master-addons' ),
					'slideFast'       => __('Slide Fast', 'master-addons' ),
					'slideSynced'     => __('Slide Synced', 'master-addons' ),
					'slideFastSynced' => __('Slide Fast Synced', 'master-addons' ),
				],
			]
		);
		$this->end_controls_section();


		/*
			 * Content Settings
			 */

		$this->start_controls_section(
			'ma_el_news_ticker_design_section',
			[
				'label' => __('Design Options', 'master-addons' ),
			]
		);


		$this->add_control(
			'ma_el_news_ticker_show_label',
			[
				'label'        => __('Show Label?', 'master-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes'
			]
		);

		$this->add_control(
			'ma_el_news_ticker_news_label',
			[
				'label'       => __('Label', 'master-addons' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => ['active' => true],
				'default'     => __('Breaking News', 'master-addons' ),
				'placeholder' => __('Breaking News', 'master-addons' ),
				'condition'   => [
					'ma_el_news_ticker_show_label' => 'yes'
				]
			]
		);

		$this->add_control(
			'ma_el_news_ticker_content',
			[
				'label'   => __('News Type', 'master-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'title',
				'options' => [
					'title'   => __('Title', 'master-addons' ),
					'excerpt' => __('Excerpt', 'master-addons' ),
				],
			]
		);

		$this->add_control(
			'ma_el_news_ticker_thumbnail',
			[
				'label'        => __('Show Thumbnail', 'master-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'return_value' => 'yes'
			]
		);

		$this->add_control(
			'ma_el_news_ticker_highlight_title',
			[
				'label'        => __('Highlight Words?', 'master-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'return_value' => 'yes'
			]
		);

		$this->add_control(
			'ma_el_news_ticker_highlight_content',
			[
				'label'     => __('Limit Posts', 'master-addons' ),
				'type'      => Controls_Manager::NUMBER,
				'min'       => 1,
				'max'       => 10,
				'step'      => 1,
				'default'   => 2,
				'condition' => [
					'ma_el_news_ticker_highlight_title' => 'yes'
				],
				'selectors' => [
					'{{WRAPPER}} .jltma-ticker-content-items .jltma-nt-title::nth-word(2)' => 'color: red',
				],
			]
		);


		$this->add_control(
			'ma_el_news_ticker_date',
			[
				'label'     => __('Show Date', 'master-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => [
					'ma_el_news_ticker_content' => 'title'
				],
			]
		);


		$this->add_control(
			'ma_el_news_ticker_height',
			[
				'label'   => __('Height', 'master-addons' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 40,
				],
				'range' => [
					'px' => [
						'min' => 40,
						'max' => 500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .jltma-ticker-content' => 'height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();

		/*
			 * News Ticker: Animation Section
			 */

		$this->start_controls_section(
			'ma_el_news_ticker_section_style_animation',
			[
				'label' => __('Animation', 'master-addons' )
			]
		);


		$this->add_control(
			'ma_el_news_ticker_scroll',
			[
				'label'   => __('Scroll Type', 'master-addons' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'slide-h'  => __('Horizontal', 'master-addons' ),
					'slide-v'  => __('Vertical', 'master-addons' ),
					'scroll-h' => __('Horiziontal Scroll', 'master-addons' )
				],
				'default'     => 'slide-h',
				'label_block' => true
			]
		);


		$this->add_control(
			'ma_el_news_ticker_autoplay',
			[
				'label'   => __('Autoplay', 'master-addons' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'ma_el_news_ticker_autoplay_interval',
			[
				'label'     => __('Autoplay Interval', 'master-addons' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 3000,
				'condition' => [
					'ma_el_news_ticker_autoplay' => 'yes',
				],
			]
		);

		$this->add_control(
			'ma_el_news_ticker_pause_on_hover',
			[
				'label'   => __('Pause on Hover', 'master-addons' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'ma_el_news_ticker_news_duration',
			[
				'label'   => __('Animation Speed', 'master-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 3000,
			]
		);

		$this->end_controls_section();



		/*
			 * Navigation Settings
			 */

		$this->start_controls_section(
			'ma_el_news_ticker_content_navigation_section',
			[
				'label' => __('Navigation', 'master-addons' ),
			]
		);

		$this->add_control(
			'ma_el_news_ticker_navigation',
			[
				'label'   => __('Show Navigation?', 'master-addons' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes'
			]
		);

		$this->add_control(
			'ma_el_news_ticker_navigation_size',
			[
				'label'      => __('Navigation Size', 'master-addons' ),
				'size_units' => ['px', 'em', '%'],
				'type'       => Controls_Manager::SLIDER,
				'default'    => [
					'size' => 14,
				],
				'range' => [
					'px' => [
						'min' => 3,
						'max' => 26,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .jltma-ticker-content-inner>.jltma-ticker-nav>span' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'ma_el_news_ticker_navigation' => 'yes'
				]
			]
		);

		$this->end_controls_section();


		/*
			 * Post Query
			 */
		$this->start_controls_section(
			'ma_el_news_ticker_section_content_query',
			[
				'label' => __('Post Query', 'master-addons' ),
			]
		);

		$this->add_control(
			'ma_el_news_ticker_post_types',
			[
				'label'   => __('Post Type', 'master-addons' ),
				'type'    => Controls_Manager::SELECT2,
				'options' => Master_Addons_Helper::ma_el_get_post_types(),
				'default' => 'post'
			]
		);

		$this->add_control(
			'ma_el_news_ticker_categories',
			[
				'label'       => __('Categories', 'master-addons' ),
				'type'        => Controls_Manager::SELECT2,
				'description' => __('Get posts for specific category(s)', 'master-addons' ),
				'label_block' => true,
				'multiple'    => true,
				'options'     => Master_Addons_Helper::ma_el_blog_post_type_categories(),
				'condition'   => [
					'ma_el_news_ticker_post_types' => 'post'
				]
			]
		);

		$this->add_control(
			'ma_el_news_ticker_tags',
			[
				'label'       => __('Post Tags', 'master-addons' ),
				'type'        => Controls_Manager::SELECT2,
				'description' => __('Get posts from specific tag(s)', 'master-addons' ),
				'label_block' => true,
				'multiple'    => true,
				'options'     => Master_Addons_Helper::ma_el_blog_post_type_tags(),
				'condition'   => [
					'ma_el_news_ticker_post_types' => 'post'
				]
			]
		);

		$this->add_control(
			'ma_el_news_ticker_posts_advanced',
			[
				'label' => __('Advanced', 'master-addons' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'ma_el_news_ticker_posts_limit',
			[
				'label'   => __('Posts Limit', 'master-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 5,
			]
		);


		$this->add_control(
			'ma_el_news_ticker_posts_orderby',
			[
				'label'       => __('Order By', 'master-addons' ),
				'type'        => Controls_Manager::SELECT,
				'label_block' => true,
				'options'     => [
					'none'          => __('None', 'master-addons' ),
					'ID'            => __('ID', 'master-addons' ),
					'author'        => __('Author', 'master-addons' ),
					'title'         => __('Title', 'master-addons' ),
					'name'          => __('Name', 'master-addons' ),
					'date'          => __('Date', 'master-addons' ),
					'modified'      => __('Last Modified', 'master-addons' ),
					'rand'          => __('Random', 'master-addons' ),
					'comment_count' => __('Number of Comments', 'master-addons' ),
				],
				'default' => 'date'
			]
		);


		$this->add_control(
			'ma_el_news_ticker_posts_order',
			[
				'label'   => __('Order', 'master-addons' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'desc',
				'options' => [
					'asc'  => __('ASC', 'master-addons' ),
					'desc' => __('DESC', 'master-addons' ),
				],
			]
		);

		$this->end_controls_section();


		/*
			 * News Ticker: Label Settings
			 */

		$this->start_controls_section(
			'ma_el_news_ticker_section_style',
			[
				'label'     => __('Label', 'master-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'ma_el_news_ticker_show_label' => 'yes'
				]
			]
		);

		//			$this->add_control(
		//				'ma_el_news_ticker_heading_label',
		//				[
		//					'label'     => __( 'Label', 'master-addons' ),
		//					'type'      => Controls_Manager::HEADING,
		//					'default' => 'yes',
		//					'condition' => [
		//						'ma_el_news_ticker_show_label' => 'yes'
		//					]
		//				]
		//			);

		$this->add_control(
			'ma_el_news_ticker_label_color',
			[
				'label'     => __('Text Color', 'master-addons' ),
				'separator' => 'before',
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => [
					'{{WRAPPER}} .jltma-ticker-heading' => 'color: {{VALUE}};',
				],
				'condition' => [
					'ma_el_news_ticker_show_label' => 'yes'
				]
			]
		);


		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'ma_el_news_ticker_border_color',
				'label'       => __('Border', 'master-addons' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .jltma-ticker-heading',
				'condition'   => [
					'ma_el_news_ticker_show_label' => 'yes'
				]
			]
		);


		$this->add_control(
			'ma_el_news_ticker_angle_color',
			[
				'label'     => __('Ribbon Angle Color', 'master-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e81739',
				'selectors' => [
					'{{WRAPPER}} .jltma-ticker-content-details:before' => 'border-left-color: {{VALUE}};',
				],
				'condition' => [
					'ma_el_news_ticker_show_label' => 'yes'
				]
			]
		);

		$this->add_responsive_control(
			'ma_el_news_ticker_label_border_radius',
			[
				'label'      => __('Border Radius', 'master-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors'  => [
					'{{WRAPPER}} .jltma-ticker-heading' => 'border-top-left-radius: {{TOP}}{{UNIT}}; border-top-right-radius: {{BOTTOM}}{{UNIT}}; border-bottom-left-radius: {{RIGHT}}{{UNIT}}; border-bottom-right-radius: {{LEFT}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'ma_el_news_ticker_angle_margin',
			[
				'label'      => __('Angle Margin', 'master-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors'  => [
					'{{WRAPPER}} .jltma-ticker-content-details:before' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				]
			]
		);


		$this->add_control(
			'ma_el_news_ticker_label_background',
			[
				'label'     => __('Background', 'master-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => "#e81739",
				'condition' => [
					'ma_el_news_ticker_show_label' => 'yes'
				],
				'selectors' => [
					'{{WRAPPER}} .jltma-ticker-heading' => 'background: {{VALUE}};',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'ma_el_news_ticker_label_typography',
				'label'     => __('Typography', 'master-addons' ),
				'scheme'    => Typography::TYPOGRAPHY_1,
				'selector'  => '{{WRAPPER}} .jltma-news-ticker .jltma-ticker-heading',
				'condition' => [
					'ma_el_news_ticker_show_label' => 'yes'
				]
			]
		);



		$this->end_controls_section();


		/*
			 * News Ticker: Content Settings
			 */

		$this->start_controls_section(
			'ma_el_news_ticker_content_heading',
			[
				'label' => __('Content', 'master-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_control(
			'ma_el_news_ticker_content_color',
			[
				'label'     => __('Text Color', 'master-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '##999',
				'selectors' => [
					'{{WRAPPER}} .jltma-news-ticker a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'ma_el_news_ticker_content_hover_color',
			[
				'label'     => __('Text Hover Color', 'master-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '##999',
				'selectors' => [
					'{{WRAPPER}} .jltma-news-ticker a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'ma_el_news_ticker_content_background',
			[
				'label'     => __('Background', 'master-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .jltma-ticker-content-details' => 'background: {{VALUE}};',
					'{{WRAPPER}} .jltma-ticker-nav'             => 'background: {{VALUE}};',
				],
			]
		);


		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'ma_el_news_ticker_content_border_color',
				'label'       => __('Border', 'master-addons' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .jltma-ticker-content-details'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'ma_el_news_ticker_content_typography',
				'label'    => __('Typography', 'master-addons' ),
				'selector' => '{{WRAPPER}} .jltma-news-ticker .jltma-ticker-content-items li',
			]
		);

		$this->end_controls_section();



		/*
			 * Navigation
			 */

		$this->start_controls_section(
			'ma_el_news_ticker_navigation_style_section',
			[
				'label'     => __('Navigation', 'master-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'ma_el_news_ticker_navigation' => 'yes'
				]
			]
		);



		$this->start_controls_tabs('ma_el_news_ticker_tabs_arrow_style');

		$this->start_controls_tab(
			'ma_el_news_ticker_tab_arrow_normal',
			[
				'label' => __('Normal', 'master-addons' ),
			]
		);

		$this->add_control(
			'ma_el_news_ticker_navigation_color',
			[
				'label'     => __('Text Color', 'master-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .jltma-news-ticker .jltma-ticker-nav span' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ma_el_news_ticker_navigation_bg',
			[
				'label'     => __('Background Color', 'master-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .jltma-news-ticker .jltma-ticker-nav span' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'        => 'ma_el_news_ticker_arrow_border',
				'label'       => __('Border', 'master-addons' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .jltma-news-ticker  .jltma-ticker-nav span',
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'ma_el_news_ticker_arrow_border_radius',
			[
				'label'      => __('Border Radius', 'master-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors'  => [
					'{{WRAPPER}} .jltma-news-ticker .jltma-ticker-nav span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'ma_el_news_ticker_arrow_padding',
			[
				'label'      => __('Padding', 'master-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors'  => [
					'{{WRAPPER}} .jltma-news-ticker .jltma-ticker-nav span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'ma_el_news_ticker_arrow_spacing',
			[
				'label' => __('Spacing', 'master-addons' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -4,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .jltma-news-ticker  .jltma-ticker-nav span.eicon-chevron-left' => 'right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'ma_el_news_ticker_tab_arrow_hover',
			[
				'label' => __('Hover', 'master-addons' ),
			]
		);

		$this->add_control(
			'ma_el_news_ticker_hover_color',
			[
				'label'     => __('Text Hover Color', 'master-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .jltma-news-ticker  .jltma-ticker-nav span:hover' => 'color: {{VALUE}};',
				],
			]
		);


		$this->add_control(
			'ma_el_news_ticker_navigation_hover_bg',
			[
				'label'     => __('Background Color', 'master-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .jltma-news-ticker .jltma-ticker-nav span:hover' => 'background-color: {{VALUE}}',
				],
			]
		);


		$this->add_control(
			'ma_el_news_ticker_arrow_hover_border_color',
			[
				'label'     => __('Border Color', 'master-addons' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => [
					'ma_el_news_ticker_arrow_border!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .jltma-news-ticker  .jltma-ticker-nav span:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

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
				'raw'             => sprintf(esc_html__('%1$s Live Demo %2$s', 'master-addons' ), '<a href="https://master-addons.com/demos/news-ticker/" target="_blank" rel="noopener">', '</a>'),
				'content_classes' => 'jltma-editor-doc-links',
			]
		);

		$this->add_control(
			'help_doc_2',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => sprintf(esc_html__('%1$s Documentation %2$s', 'master-addons' ), '<a href="https://master-addons.com/docs/addons/news-ticker-element/?utm_source=widget&utm_medium=panel&utm_campaign=dashboard" target="_blank" rel="noopener">', '</a>'),
				'content_classes' => 'jltma-editor-doc-links',
			]
		);

		$this->add_control(
			'help_doc_3',
			[
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => sprintf(esc_html__('%1$s Watch Video Tutorial %2$s', 'master-addons' ), '<a href="https://www.youtube.com/watch?v=jkrBCzebQ-E" target="_blank" rel="noopener">', '</a>'),
				'content_classes' => 'jltma-editor-doc-links',
			]
		);
		$this->end_controls_section();




		//Upgrade to Pro
		if (ma_el_fs()->is_not_paying()) {

			$this->start_controls_section(
				'jltma_section_pro_style_section',
				[
					'label' => esc_html__('Upgrade to Pro for More Features', 'master-addons' ),
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

		$this->add_render_attribute(
			'ma_el_news_ticker',
			'class',
			[
				'jltma-news-ticker'
			]
		);

		$ticker_id = 'jltma-news-ticker-' . $this->get_id();

		/* Animation Settings */
		$ma_el_news_ticker_feed_url              = ($settings['ma_el_news_ticker_feed_url']) ? $settings['ma_el_news_ticker_feed_url'] : "";
		$ma_el_news_ticker_feed_posts            = $settings['ma_el_news_ticker_feed_posts'];
		$ma_el_news_ticker_feed_animation_styles = $settings['ma_el_news_ticker_feed_animation_styles'];
		$ma_el_news_ticker_type                  = $settings['ma_el_news_ticker_type'];
		$ma_el_news_ticker_scroll                = $settings['ma_el_news_ticker_scroll'];
		$autoplay                                = 'yes' == $settings['ma_el_news_ticker_autoplay'] ? true : false;
		$timer                                   = $settings['ma_el_news_ticker_news_duration'];
		//			$border = 'yes' == $settings['ma_el_news_ticker_show_border'] ? true : false;

		$this->add_render_attribute('ma_el_news_ticker', 'data-limitposts', $ma_el_news_ticker_feed_posts);
		$this->add_render_attribute('ma_el_news_ticker', 'data-tickertype', $ma_el_news_ticker_type);
		$this->add_render_attribute(
			'ma_el_news_ticker',
			'data-feedanimation',
			$ma_el_news_ticker_feed_animation_styles
		);
		$this->add_render_attribute('ma_el_news_ticker', 'data-feedurl', $ma_el_news_ticker_feed_url);
		$this->add_render_attribute('ma_el_news_ticker', 'data-scroll', $ma_el_news_ticker_scroll);
		//			$this->add_render_attribute('ma_el_news_ticker', 'data-tickerid', $layout_style );
		$this->add_render_attribute('ma_el_news_ticker', 'data-autoplay', $autoplay);
		$this->add_render_attribute('ma_el_news_ticker', 'data-timer', $timer);
		$this->add_render_attribute('ma_el_news_ticker', 'data-tickerid', $ticker_id);
		//			$this->add_render_attribute('ma_el_news_ticker', 'data-border', $border );

		$date_format = get_option('date_format');

?>

		<div <?php echo $this->get_render_attribute_string('ma_el_news_ticker'); ?> id="<?php echo esc_attr($ticker_id); ?>">
			<div class="jltma-ticker-content">
				<div class="jltma-ticker-heading">
					<span>
						<?php echo $this->parse_text_editor($settings['ma_el_news_ticker_news_label']); ?>
					</span>
				</div>
				<div class="jltma-ticker-content-details <?php if ($settings['ma_el_news_ticker_scroll'] == 'scroll-h') echo "horizontal-scroll"; ?>">
					<div class="jltma-ticker-content-inner">

						<?php if ($ma_el_news_ticker_type == "content") { ?>

							<ul class="jltma-ticker-content-items">

								<?php
								global $post;
								$args          = array('posts_per_page' => $settings['ma_el_news_ticker_posts_limit']);
								$breaking_news = get_posts($args);
								$i             = 0;
								foreach ($breaking_news as $post) {
									setup_postdata($post);
									$i++; ?>

									<?php if ('title' == $settings['ma_el_news_ticker_content']) : ?>

										<li class="<?php echo ($i == 1) ? "active" : ""; ?>">

											<?php if ($settings['ma_el_news_ticker_thumbnail']) {
												the_post_thumbnail('thumbnail');
											} ?>

											<a href="<?php esc_url(the_permalink()); ?>">
												<?php the_title(); ?>

												<?php if ($settings['ma_el_news_ticker_date']) { ?>
													- <?php the_time($date_format); ?>
												<?php } ?>
											</a>

										</li>

									<?php endif; ?>

									<?php if ('excerpt' == $settings['ma_el_news_ticker_content']) : ?>
										<li class="<?php echo ($i == 1) ? "active" : ""; ?> ">
											<a href="<?php esc_url(the_permalink()); ?>">

												<?php if ($settings['ma_el_news_ticker_thumbnail']) {
													the_post_thumbnail('thumbnail');
												} ?>

												<?php the_excerpt(); ?>

												<?php if ($settings['ma_el_news_ticker_date']) { ?>
													- <?php the_time($date_format); ?>
												<?php } ?>
											</a>
										</li>
									<?php endif; ?>

								<?php }
								wp_reset_postdata(); ?>

							</ul>


						<?php } ?>


						<?php if ($settings['ma_el_news_ticker_navigation'] == "yes") { ?>
							<div class="jltma-ticker-nav">
								<span class="eicon-chevron-left"></span>
								<span class="eicon-chevron-right"></span>
							</div>
						<?php } ?>

					</div>
				</div>
			</div>
		</div>

<?php }
}
