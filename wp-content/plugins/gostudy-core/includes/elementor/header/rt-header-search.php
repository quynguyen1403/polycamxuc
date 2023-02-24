<?php
namespace RTAddons\Widgets;

defined('ABSPATH') || exit; // Abort, If called directly.

use RTAddons\Gostudy_Global_Variables as Gostudy_Globals;
use Elementor\{Widget_Base, Controls_Manager, Group_Control_Typography};

/**
 * Search widget for Header CPT
 *
 *
 * @category Class
 * @package gostudy-core\includes\elementor
 * @author RaisTheme <help.raistheme@gmail.com>
 * @since 1.0.0
 */
class RT_Header_Search extends Widget_Base
{
    public function get_name()
    {
        return 'rt-header-search';
    }

    public function get_title()
    {
        return esc_html__('RT Search', 'gostudy-core');
    }

    public function get_icon()
    {
        return 'rt-header-search';
    }

    public function get_categories()
    {
        return ['rt-header-modules'];
    }

    public function get_script_depends()
    {
        return [ 'rt-elementor-extensions-widgets' ];
    }

    protected function register_controls()
    {
        /*-----------------------------------------------------------------------------------*/
        /*  CONTENT -> GENERAL
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_content_general',
            ['label' => esc_html__('General', 'gostudy-core')]
        );

        $this->add_control(
            'alignment',
            [
                'label' => esc_html__('Alignment', 'gostudy-core'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'gostudy-core'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'gostudy-core'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'gostudy-core'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .rt-search' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'height_full',
            [
                'label' => esc_html__('Full Height', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before',
                'default' => 'yes',
                'prefix_class' => 'full-height-',
                
            ]
        );

        $this->add_control(
            'height_custom',
            [
                'label' => esc_html__('Height', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'condition' => ['height_full' => ''],
                'min' => 0,
                'default' => 55,
                'selectors' => [
                    '{{WRAPPER}} .header_search' => 'height: {{VALUE}}px;',
                ],
            ]
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> SEARCH
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_search',
            [
                'label' => esc_html__('Search', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'search',
                'selector' => '{{WRAPPER}} .header_search-button, {{WRAPPER}} .header_search-close',
                'exclude' => ['font_family', 'text_transform', 'font_style', 'text_decoration', 'letter_spacing'],
            ]
        );

        $this->start_controls_tabs(
            'icon',
            ['separator' => 'before']
        );

        $this->start_controls_tab(
            'tab_icon_idle',
            ['label' => esc_html__('Idle' , 'gostudy-core')]
        );

        $this->add_control(
            'icon_color_idle',
            [
                'label' => esc_html__('Icon Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .header_search-button,
                     {{WRAPPER}} .header_search-close' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'icon_bg_idle',
            [
                'label' => esc_html__('Background Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .header_search .rt-search' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_icon_hover',
            ['label' => esc_html__('Hover' , 'gostudy-core')]
        );

        $this->add_control(
            'icon_color_hover',
            [
                'label' => esc_html__('Icon Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .rt-search:hover .header_search-button' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'icon_bg_hover',
            [
                'label' => esc_html__('Background Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .rt-search:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_icon_active',
            ['label' => esc_html__('Active' , 'gostudy-core')]
        );

        $this->add_control(
            'icon_color_active',
            [
                'label' => esc_html__('Icon Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .header_search-close' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'icon_bg_active',
            [
                'label' => esc_html__('Background Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .header_search.header_search-open .rt-search' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'search_margin',
            [
                'label' => esc_html__('Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'separator' => 'before',
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .rt-search' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'search_padding',
            [
                'label' => esc_html__('Padding', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .rt-search' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'search_radius',
            [
                'label' => esc_html__('Border Radius', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .header_search,
                     {{WRAPPER}} .rt-search' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    public function render()
    {
        $description = esc_html__('Type To Search', 'gostudy-core');
        $search_style = \Gostudy_Theme_Helper::get_option('search_style') ?? 'standard';
        $search_counter = null;

        if (class_exists('\Gostudy_Get_Header')) {
            $search_counter = \Gostudy_Get_Header::$search_form_counter ?? null;
        }

        $search_class = ' search_' . \Gostudy_Theme_Helper::get_option('search_style');

        $render_search = true;
        if ($search_style === 'alt') {
            // the only search form in Default and Sticky headers is allowed
            $render_search = $search_counter > 0 ? false : true;

            if (isset($search_counter)) \Gostudy_Get_Header::$search_form_counter++;
        }

        $this->add_render_attribute('search', 'class', 'rt-search elementor-search header_search-button-wrapper');
        $this->add_render_attribute('search', 'role', 'button'); ?>

        <div class="header_search<?php echo esc_attr($search_class); ?>">
	        <div <?php echo $this->get_render_attribute_string('search'); ?>>
	            <div class="header_search-button flaticon-loupe"></div>
	            <div class="header_search-close flaticon-close"></div>
	        </div><?php

	        if ($render_search) { ?>
	            <div class="header_search-field"><?php
	            if ($search_style === 'alt') { ?>
	                <div class="header_search-wrap">
	                    <div class="gostudy_module_double_headings aleft">
	                    <h3 class="header_search-heading_description heading_title"><?php
	                        echo apply_filters('gostudy/search/description', $description); ?>
	                    </h3>
	                    </div>
	                    <div class="header_search-close"></div>
	                </div><?php
	            }
	            echo get_search_form(false); ?>
	            </div><?php
	        }?>
        </div><?php
    }
}
