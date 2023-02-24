<?php
/*
 * This template can be overridden by copying it to yourtheme/gostudy-core/elementor/widgets/rt-double-headings.php.
*/
namespace RTAddons\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\{Group_Control_Box_Shadow, Widget_Base, Controls_Manager, Group_Control_Typography};
use Gostudy_Theme_Helper;
use RTAddons\Gostudy_Global_Variables as Gostudy_Globals;

class RT_Double_Headings extends Widget_Base
{
    public function get_name()
    {
        return 'rt-double-headings';
    }

    public function get_title()
    {
        return esc_html__('Custom Heading', 'gostudy-core');
    }

    public function get_icon()
    {
        return 'rt-double-headings';
    }

    public function get_categories()
    {
        return ['rt-extensions'];
    }

    protected function register_controls()
    {
        /*-----------------------------------------------------------------------------------*/
        /*  CONTENT -> GENERAL
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'rt_double_headings_section',
            ['label' => esc_html__('General', 'gostudy-core')]
        );

        $this->add_control(
            'subtitle',
            [
                'label' => esc_html__('Subtitle', 'gostudy-core'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'dynamic' => ['active' => true],
                'placeholder' => esc_attr__('ex: About Us', 'gostudy-core'),
                'default' => esc_html__('Subtitle', 'gostudy-core'),
            ]
        );

        $this->add_control(
            'dbl_title',
            [
                'label' => esc_html__('Title 1st Part', 'gostudy-core'),
                'type' => Controls_Manager::TEXTAREA,
                'dynamic' => ['active' => true],
                'rows' => 1,
                'placeholder' => esc_attr__('1st part', 'gostudy-core'),
                'default' => esc_html_x('Title', 'RT Double Heading', 'gostudy-core'),
            ]
        );

        $this->add_control(
            'dbl_title2',
            [
                'label' => esc_html__('Title 2nd Part', 'gostudy-core'),
                'type' => Controls_Manager::TEXTAREA,
                'dynamic' => ['active' => true],
                'rows' => 1,
                'placeholder' => esc_attr__('2nd part', 'gostudy-core'),
                'default' => esc_html_x(' consists of parts', 'RT Double Heading', 'gostudy-core'),
            ]
        );

        $this->add_control(
            'dbl_title3',
            [
                'label' => esc_html__('Title 3rd Part', 'gostudy-core'),
                'type' => Controls_Manager::TEXTAREA,
                'dynamic' => ['active' => true],
                'rows' => 1,
                'placeholder' => esc_attr__('3rd part', 'gostudy-core'),
            ]
        );

        $this->add_responsive_control(
            'alignment',
            [
                'label' => esc_html__('Alignment', 'gostudy-core'),
                'type' => Controls_Manager::CHOOSE,
                'separator' => 'before',
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
                ],
                'default' => 'left',
                'selector' => '{{WRAPPER}} .edubin-hero-2 .title',
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => esc_html__('Title Link', 'gostudy-core'),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_attr__('https://your-link.com', 'gostudy-core'),
            ]
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  STYLES -> TITLE
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_title',
            [
                'label' => esc_html__('Title', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_all',
                'selector' => '{{WRAPPER}} .dbl__title',
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
                    'span' => '‹span›',
                    'div' => '‹div›',
                ],
                'default' => 'h3',
            ]
        );

        $this->add_control(
            'heading_1st_part',
            [
                'label' => esc_html__('1st Part', 'gostudy-core'),
                'type' => Controls_Manager::HEADING,
                'condition' => ['dbl_title!' => ''],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_1st',
                'condition' => ['dbl_title!' => ''],
                'selector' => '{{WRAPPER}} .dbl-title_1',
            ]
        );

        $this->add_control(
            'title_1st_color',
            [
                'label' => esc_html__('Text Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'condition' => ['dbl_title!' => ''],
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_h_font_color(),
                'selectors' => [
                    '{{WRAPPER}} .dbl-title_1' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'heading_2nd_part',
            [
                'label' => esc_html__('2nd Part', 'gostudy-core'),
                'type' => Controls_Manager::HEADING,
                'condition' => ['dbl_title2!' => ''],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_2nd',
                'condition' => ['dbl_title2!' => ''],
                'selector' => '{{WRAPPER}} .dbl-title_2',
            ]
        );

        $this->add_control(
            'title_2nd_color',
            [
                'label' => esc_html__('Text Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'condition' => ['dbl_title2!' => ''],
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .dbl-title_2' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'heading_3rd_part',
            [
                'label' => esc_html__('3rd Part', 'gostudy-core'),
                'type' => Controls_Manager::HEADING,
                'condition' => ['dbl_title3!' => ''],
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_3rd',
                'condition' => ['dbl_title3!' => ''],
                'selector' => '{{WRAPPER}} .dbl-title_3',
            ]
        );

        $this->add_control(
            'title_3rd_color',
            [
                'label' => esc_html__('Text Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'condition' => ['dbl_title3!' => ''],
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_h_font_color(),
                'selectors' => [
                    '{{WRAPPER}} .dbl-title_3' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  STYLES -> SUBTITLE
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_subtitle',
            [
                'label' => esc_html__('Subtitle', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['subtitle!' => ''],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'subtitle_typo',
                'selector' => '{{WRAPPER}} .dbl__subtitle',
            ]
        );

        $this->add_control(
            'subtitle_color',
            [
                'label' => esc_html__('Subtitle Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => '#4c5e78',
                'selectors' => [
                    '{{WRAPPER}} .dbl__subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'subtitle_bg_color',
            [
                'label' => esc_html__('Subtitle Background Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .dbl__subtitle' => 'background-color: {{VALUE}};',
                ],
            ]
        );

	    $this->add_control(
		    'hide_circle',
		    [
			    'label' => esc_html__('Hide Circle?', 'gostudy-core'),
			    'type' => Controls_Manager::SWITCHER,
			    'selectors' => [
				    '{{WRAPPER}} .dbl__subtitle span:before' => 'display: none;',
			    ],
		    ]
	    );

        $this->add_control(
            'additional_color',
            [
                'label' => esc_html__('Additional Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_secondary_color(),
                'condition' => [ 'hide_circle' => '' ],
                'selectors' => [
                    '{{WRAPPER}} .dbl__subtitle span:before' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'subtitle_padding',
            [
                'label' => esc_html__('Padding', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'separator' => 'before',
	            'default' => [
		            'top' => '7',
		            'right' => '12',
		            'bottom' => '7',
		            'left' => '12',
		            'unit'  => 'px',
		            'isLinked' => false
	            ],
                'selectors' => [
                    '{{WRAPPER}} .dbl__subtitle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'subtitle_margin',
            [
                'label' => esc_html__('Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .dbl__subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

	    $this->add_control(
		    'subtitle_border_radius',
		    [
			    'label' => esc_html__('Border Radius', 'gostudy-core'),
			    'type' => Controls_Manager::DIMENSIONS,
			    'size_units' => ['px', '%'],
			    'default' => [
				    'top' => '20',
				    'right' => '20',
				    'bottom' => '20',
				    'left' => '20',
				    'unit'  => 'px',
				    'isLinked' => false
			    ],
			    'selectors' => [
				    '{{WRAPPER}} .dbl__subtitle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			    ],
		    ]
	    );

	    $this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
			    'name' => 'subtitle_shadow',
			    'selector' => '{{WRAPPER}} .dbl__subtitle',
			    // 'fields_options' => [
				   //  'box_shadow_type' => [
					  //   'default' => 'yes'
				   //  ],
				   //  'box_shadow' => [
					  //   'default' => [
						 //    'horizontal' => 5,
						 //    'vertical' => 4,
						 //    'blur' => 13,
						 //    'spread' => 0,
						 //    'color' => 'rgba( 46, 63, 99, .15)',
					  //   ]
				   //  ]
			    // ]
		    ]
	    );

        $this->end_controls_section();
    }

    protected function render()
    {
        $_s = $this->get_settings_for_display();

        if (!empty($_s['link']['url'])) {
            $this->add_render_attribute('link', 'class', 'dbl__link');
            $this->add_link_attributes('link', $_s['link']);
        }

        $this->add_render_attribute('heading_wrapper', 'class', 'rt-double_heading');

        echo '<div ', $this->get_render_attribute_string('heading_wrapper'), '>';

            if ($_s['subtitle']) {
                echo '<div class="dbl__subtitle">';
                    if ($_s['subtitle']) echo '<span>', $_s['subtitle'], '</span>';
                echo '</div>';
            }

            if ($_s['dbl_title'] || $_s['dbl_title2'] || $_s['dbl_title3']) {

                if (!empty($_s['link']['url'])) echo '<a ', $this->get_render_attribute_string('link'), '>';

                echo '<', $_s['title_tag'], ' class="dbl__title-wrapper">';
                    if ($_s['dbl_title']) echo '<span class="dbl__title dbl-title_1">', $_s['dbl_title'], '</span>';
                    if ($_s['dbl_title2']) echo '<span class="dbl__title dbl-title_2">', $_s['dbl_title2'], '</span>';
                    if ($_s['dbl_title3']) echo '<span class="dbl__title dbl-title_3">', $_s['dbl_title3'], '</span>';
                echo '</', $_s['title_tag'], '>';

                if (!empty($_s['link']['url'])) echo '</a>';

            }

        echo '</div>';
    }
}
