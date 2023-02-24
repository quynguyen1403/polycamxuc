<?php

namespace MasterAddons\Addons;

use \Elementor\Utils;
use \Elementor\Repeater;
use \Elementor\Icons_Manager;
use \Elementor\Controls_Manager as Controls_Manager;
use \Elementor\Group_Control_Border as Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow as Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography as Group_Control_Typography;
use \Elementor\Core\Schemes\Typography;
use \Elementor\Widget_Base as Widget_Base;
use MasterAddons\Inc\Helper\Master_Addons_Helper;

/**
 * Author Name: Liton Arefin
 * Author URL : https: //jeweltheme.com
 * Date       : 6/25/19
 */

if (!defined('ABSPATH')) exit; // If this file is called directly, abort.

class JLTMA_Featured_Product extends Widget_Base
{

    public function get_name()
    {
        return 'jltma-featured-product';
    }

    public function get_title()
    {
        return esc_html__('Featured Product', 'master-addons' );
    }

    public function get_icon()
    {
        return 'jltma-icon eicon-image-box';
    }

    public function get_categories()
    {
        return ['master-addons'];
    }

    public function get_style_depends()
    {
        return ['jltma-pro'];
    }


    public function get_help_url()
    {
        return 'https://master-addons.com/demos/featured-product';
    }

    // General Section
    protected function jltma_fp_general_section()
    {

        // Start General Section
        $this->start_controls_section(
            'jltma_fp_section_general',
            array(
                'label'         => esc_html__('General', 'master-addons' ),
            )
        );

        $this->add_control(
            'jltma_fp_skin',
            [
                'label'         => esc_html__('Layouts', 'master-addons' ),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'style-1' => esc_html__('Design 1', 'master-addons' ),
                    'style-2' => esc_html__('Design 2', 'master-addons' ),
                    'style-3' => esc_html__('Design 3', 'master-addons' ),
                ],
                'default'       => 'style-1',
            ]
        );

        $this->add_control(
            'jltma_fp_image',
            [
                'label'     => esc_html__('Image', 'master-addons' ),
                'type'      => Controls_Manager::MEDIA,
                'default'   => [
                    'url'   => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'jltma_fp_title',
            [
                'label'         => esc_html__('Title', 'master-addons' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => esc_html__('Title', 'master-addons' ),
            ]
        );

        $this->add_control(
            'jltma_fp_content_type',
            [
                'label'         => esc_html__('Content Type', 'master-addons' ),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'desc' => esc_html__('Description', 'master-addons' ),
                    'list' => esc_html__('List', 'master-addons' ),
                ],
                'default'       => 'desc',
            ]
        );

        $this->add_control(
            'jltma_fp_description',
            [
                'label'         => esc_html__('Description', 'master-addons' ),
                'type'          => Controls_Manager::TEXTAREA,
                'default'       => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'master-addons' ),
                'condition'     => [
                    'jltma_fp_content_type' => 'desc',
                ],
            ]
        );

        $this->add_control(
            'jltma_fp_list_icon',
            [
                'label'         => esc_html__('List Icon', 'master-addons' ),
                'type'          => Controls_Manager::ICONS,
                'default'       => [
                    'value'     => 'fas fa-check-circle',
                    'library'   => 'fa-solid',
                ],
                'condition'     => [
                    'jltma_fp_content_type' => 'list',
                ],
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'jltma_fp_product_list',
            [
                'type'          => Controls_Manager::TEXTAREA,
                'label_block'   => true,
                'rows'          => 2,
                'default'       => esc_html__('Lorem ipsum dolor sit amet', 'master-addons' ),
            ]
        );

        $this->add_control(
            'jltma_fp_product_lists',
            [
                'label'         => esc_html__('List', 'master-addons' ),
                'type'          => Controls_Manager::REPEATER,
                'fields'        => $repeater->get_controls(),
                'render_type'   => 'template',
                'default'       => [
                    [
                        'jltma_fp_product_list' => esc_html__('Lorem ipsum dolor sit amet', 'master-addons' ),
                    ],
                    [
                        'jltma_fp_product_list' => esc_html__('Lorem ipsum dolor sit amet', 'master-addons' ),
                    ],
                    [
                        'jltma_fp_product_list' => esc_html__('Lorem ipsum dolor sit amet', 'master-addons' ),
                    ],
                ],
                'title_field'   => '{{{ jltma_fp_product_list }}}',
                'condition'     => [
                    'jltma_fp_content_type' => 'list',
                ],
            ]
        );

        $this->add_control(
            'jltma_fp_price',
            [
                'label'         => esc_html__('Price', 'master-addons' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => esc_html__('$63.50', 'master-addons' ),
                'separator'     => 'before',
            ]
        );

        $this->add_control(
            'jltma_fp_original_price',
            [
                'label'         => esc_html__('Original Price', 'master-addons' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => esc_html__('$83.50', 'master-addons' ),
            ]
        );

        $this->add_control(
            'jltma_fp_button',
            [
                'label'         => esc_html__('Button Text', 'master-addons' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => esc_html__('BUY NOW', 'master-addons' ),
                'separator'     => 'before',
                'condition'     => [
                    'jltma_fp_skin!' => 'style-2',
                ],
            ]
        );

        $this->add_control(
            'jltma_fp_button_icon',
            [
                'label'         => esc_html__('Button Icon', 'master-addons' ),
                'type'          => Controls_Manager::ICONS,
                'default'       => [
                    'value'     => 'fa fa-shopping-bag',
                    'library'   => 'fa-solid',
                ],
                'condition'     => [
                    'jltma_fp_skin' => 'style-2',
                ],
            ]
        );

        $this->add_control(
            'jltma_fp_link',
            [
                'label'         => esc_html__('Link', 'master-addons' ),
                'type'          => Controls_Manager::URL,
            ]
        );

        $this->add_control(
            'jltma_fp_show_ribbon',
            [
                'label'         => esc_html__('Ribbon', 'master-addons' ),
                'type'          => Controls_Manager::SWITCHER,
                'default'       => 'yes',
                'label_on'      => esc_html__('Show', 'master-addons' ),
                'label_off'     => esc_html__('Hide', 'master-addons' ),
                'separator'     => 'before',
            ]
        );

        $this->add_control(
            'jltma_fp_ribbon_skin',
            [
                'label'         => esc_html__('Ribbon Type', 'master-addons' ),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'style-1' => esc_html__('Style 1', 'master-addons' ),
                    'style-2' => esc_html__('Style 2', 'master-addons' ),
                    'style-3' => esc_html__('Style 3', 'master-addons' ),
                    'style-4' => esc_html__('Style 4', 'master-addons' ),
                ],
                'condition'     => [
                    'jltma_fp_show_ribbon' => 'yes',
                ],
                'default'       => 'style-1',
            ]
        );

        $this->add_control(
            'jltma_fp_ribbon',
            [
                'label'         => esc_html__('Ribbon Text', 'master-addons' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => esc_html__('NEW', 'master-addons' ),
                'condition'     => [
                    'jltma_fp_show_ribbon' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'jltma_fp_ribbon_icon',
            [
                'label'         => esc_html__('Ribbon Icon', 'master-addons' ),
                'type'          => Controls_Manager::ICONS,
                'default'       => [
                    'value'     => 'fas fa-trophy',
                    'library'   => 'fa-solid',
                ],
                'condition'     => [
                    'jltma_fp_show_ribbon' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'jltma_fp_rating',
            [
                'label'         => esc_html__('Rating', 'master-addons' ),
                'type'          => Controls_Manager::NUMBER,
                'min'           => 0,
                'max'           => 5,
                'step'          => 0.1,
                'default'       => 4.5,
                'separator'     => 'before',
            ]
        );

        $this->end_controls_section();
        // End General Section
    }

    // Pros Section
    protected function jltma_fp_content_box_section()
    {

        // Start Box Style Section
        $this->start_controls_section(
            'jltma_fp_box_style',
            [
                'label'         => esc_html__('Box', 'master-addons' ),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'jltma_fp_box_padding',
            [
                'label'         => esc_html__('Padding', 'master-addons' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', '%'],
                'default'   => [
                    'top'   => '30',
                    'right' => '30',
                    'bottom' => '30',
                    'left'  => '30',
                ],
                'selectors'     => [
                    '{{WRAPPER}} .jltma-featured-product .jltma-fp-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'jltma_fp_box_color',
            [
                'label'         => esc_html__('Background Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .jltma-featured-product .jltma-fp-container' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'jltma_fp_box_border',
                'fields_options' => [
                    'border'    => [
                        'default'   => 'solid',
                    ],
                    'width'     => [
                        'default'   => [
                            'top'       => '1',
                            'right'     => '1',
                            'bottom'    => '1',
                            'left'      => '1',
                        ],
                    ],
                    'color'     => [
                        'default'   => '#dadada',
                    ],
                ],
                'selector'      => '{{WRAPPER}} .jltma-featured-product',
            ]
        );

        $this->add_responsive_control(
            'jltma_fp_box_radius',
            [
                'label'         => esc_html__('Border Radius', 'master-addons' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px'],
                'default'   => [
                    'top'   => '10',
                    'right' => '10',
                    'bottom' => '10',
                    'left'  => '10',
                ],
                'selectors'     => [
                    '{{WRAPPER}} .jltma-featured-product' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'          => 'jltma_fp_box_shadow',
                'label'         => esc_html__('Box Shadow', 'master-addons' ),
                'selector'      => '{{WRAPPER}} .jltma-featured-product',
            ]
        );

        $this->end_controls_section();
        // End Box Style Section
    }


    protected function jltma_fp_content_title_section()
    {

        // Start Title Style Section
        $this->start_controls_section(
            'jltma_fp_title_style',
            [
                'label'         => esc_html__('Title', 'master-addons' ),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'jltma_fp_title_color',
            [
                'label'         => esc_html__('Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .jltma-featured-product .jltma-fp-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'typography_fp_title',
                'selector'      => '{{WRAPPER}} .jltma-featured-product .jltma-fp-title',
            ]
        );

        $this->add_responsive_control(
            'jltma_fp_title_spacing',
            [
                'label'         => esc_html__('Spacing', 'master-addons' ),
                'type'          => Controls_Manager::SLIDER,
                'selectors'     => [
                    '{{WRAPPER}} .jltma-featured-product .jltma-fp-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        // End Title Style Section
    }

    // Section: Content
    protected function jltma_fp_content_section()
    {

        // Start Content Style Section
        $this->start_controls_section(
            'jltma_fp_content_style',
            [
                'label'         => esc_html__('Content', 'master-addons' ),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'jltma_fp_icon_color',
            [
                'label'         => esc_html__('Icon Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#F54141',
                'selectors'     => [
                    '{{WRAPPER}} .jltma-featured-product .jltma-fp-list-icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .jltma-featured-product .jltma-fp-list-icon svg' => 'fill: {{VALUE}};',
                ],
                'condition'     => [
                    'jltma_fp_content_type' => 'list',
                ],
            ]
        );

        $this->add_responsive_control(
            'jltma_fp_icon_size',
            [
                'label'         => esc_html__('Icon Size', 'master-addons' ),
                'type'          => Controls_Manager::SLIDER,
                'default'       => ['size'  => 18],
                'selectors'     => [
                    '{{WRAPPER}} .jltma-featured-product .jltma-fp-list-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .jltma-featured-product .jltma-fp-list-icon svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition'     => [
                    'jltma_fp_content_type' => 'list',
                ],
            ]
        );

        $this->add_control(
            'jltma_fp_icon_spacing',
            [
                'label'         => esc_html__('Icon Spacing', 'master-addons' ),
                'type'          => Controls_Manager::SLIDER,
                'default'       => ['size'  => 10],
                'selectors'     => [
                    '{{WRAPPER}} .jltma-featured-product .jltma-fp-list-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
                'condition'     => [
                    'jltma_fp_content_type' => 'list',
                ],
            ]
        );

        $this->add_control(
            'jltma_fp_content_color',
            [
                'label'         => esc_html__('Content Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#000000',
                'selectors'     => [
                    '{{WRAPPER}} .jltma-featured-product .jltma-fp-content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'typography_fp_content',
                'selector'      => '{{WRAPPER}} .jltma-featured-product .jltma-fp-content',
            ]
        );

        $this->add_responsive_control(
            'jltma_fp_content_spacing',
            [
                'label'         => esc_html__('List Spacing', 'master-addons' ),
                'type'          => Controls_Manager::SLIDER,
                'selectors'     => [
                    '{{WRAPPER}} .jltma-featured-product .jltma-fp-lists .jltma-fp-list' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition'     => [
                    'jltma_fp_content_type' => 'list',
                ],
            ]
        );

        $this->add_responsive_control(
            'jltma_fp_content_spacing_bottom',
            [
                'label'         => esc_html__('Spacing Bottom', 'master-addons' ),
                'type'          => Controls_Manager::SLIDER,
                'default'       => ['size'  => 10],
                'selectors'     => [
                    '{{WRAPPER}} .jltma-featured-product .jltma-fp-lists' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition'     => [
                    'jltma_fp_content_type' => 'list',
                ],
            ]
        );

        $this->add_responsive_control(
            'jltma_fp_content_spacing_bottom_content',
            [
                'label'         => esc_html__('Spacing Bottom', 'master-addons' ),
                'type'          => Controls_Manager::SLIDER,
                'default'       => ['size'  => 10],
                'selectors'     => [
                    '{{WRAPPER}} .jltma-featured-product .jltma-fp-content' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition'     => [
                    'jltma_fp_content_type' => 'desc',
                ],
            ]
        );

        $this->end_controls_section();
        // End Content Style Section

    }


    // Section: Image Section
    protected function jltma_fp_content_image_section()
    {
    }

    // Style Tab: Price
    protected function jltma_fp_style_price_section()
    {
        // Start Price Style Section
        $this->start_controls_section(
            'jltma_fp_price_style',
            [
                'label'         => esc_html__('Price', 'master-addons' ),
                'tab'           => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'jltma_fp_price!' => '',
                ],
            ]
        );

        $this->add_control(
            'jltma_fp_price_color',
            [
                'label'         => esc_html__('Price Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#F54141',
                'selectors'     => [
                    '{{WRAPPER}} .jltma-featured-product .jltma-fp-price' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'typography_fp_price',
                'selector'      => '{{WRAPPER}} .jltma-featured-product .jltma-fp-price',
            ]
        );

        $this->add_control(
            'jltma_fp_original_price_color',
            [
                'label'         => esc_html__('Original Price Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#717171',
                'selectors'     => [
                    '{{WRAPPER}} .jltma-featured-product .jltma-fp-original-price' => 'color: {{VALUE}};',
                ],
                'condition'     => [
                    'jltma_fp_original_price!' => '',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label'         => esc_html__('Original Price Typography', 'master-addons' ),
                'name'          => 'typography_fp_orginal_price',
                'selector'      => '{{WRAPPER}} .jltma-featured-product .jltma-fp-original-price',
                'condition'     => [
                    'jltma_fp_original_price!' => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'jltma_fp_price_space_between',
            [
                'label'         => esc_html__('Space Between', 'master-addons' ),
                'type'          => Controls_Manager::SLIDER,
                'default'       => ['size'  => 5],
                'selectors'     => [
                    '{{WRAPPER}} .jltma-featured-product .jltma-fp-original-price' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
                'condition'     => [
                    'jltma_fp_original_price!' => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'jltma_fp_price_spacing',
            [
                'label'         => esc_html__('Spacing Bottom', 'master-addons' ),
                'type'          => Controls_Manager::SLIDER,
                'selectors'     => [
                    '{{WRAPPER}} .jltma-featured-product .jltma-fp-price-container' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition'     => [
                    'jltma_fp_skin' => 'style-2',
                ],
            ]
        );

        $this->end_controls_section();
        // End Price Style Section
    }


    // Style Tab: Button
    protected function jltma_fp_style_button_section()
    {
        // Start Button Style Section
        $this->start_controls_section(
            'jltma_fp_button_style',
            [
                'label'         => esc_html__('Button', 'master-addons' ),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('jltma_fp_button_color_setting');

        $this->start_controls_tab(
            'jltma_fp_button_normal_tab',
            [
                'label'         => esc_html__('Normal', 'master-addons' ),
            ]
        );

        $this->add_control(
            'jltma_fp_button_color',
            [
                'label'         => esc_html__('Text Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#FFFFFF',
                'selectors'     => [
                    '{{WRAPPER}} .jltma-fp-button' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .jltma-fp-button svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'jltma_fp_button_background_color',
            [
                'label'         => esc_html__('Background Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#F54141',
                'selectors'     => [
                    '{{WRAPPER}} .jltma-fp-button' => 'background-color: {{VALUE}};',
                ],
                'separator'     => 'after',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'jltma_fp_button_hover_tab',
            [
                'label'         => esc_html__('Hover', 'master-addons' ),
            ]
        );

        $this->add_control(
            'jltma_fp_button_color_hover',
            [
                'label'         => esc_html__('Text Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .jltma-fp-button:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .jltma-fp-button:hover svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'jltma_fp_button_background_color_hover',
            [
                'label'         => esc_html__('Background Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .jltma-fp-button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'jltma_fp_button_border_color_hover',
            [
                'label'         => esc_html__('Border Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .jltma-fp-button:hover' => 'border-color: {{VALUE}};',
                ],
                'separator'     => 'after',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'jltma_fp_button_text_typography',
                'label'         => esc_html__('Typography', 'master-addons' ),
                'selector'      => '{{WRAPPER}} .jltma-fp-button',
                'condition'     => [
                    'jltma_fp_skin!' => 'style-2',
                ],
            ]
        );

        $this->add_responsive_control(
            'jltma_fp_button_icon_size',
            [
                'label'         => esc_html__('Icon Size', 'master-addons' ),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .jltma-fp-button' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .jltma-fp-button svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition'     => [
                    'jltma_fp_skin' => 'style-2',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'jltma_fp_button_border',
                'label'         => esc_html__('Border', 'master-addons' ),
                'selector'      => '{{WRAPPER}} .jltma-fp-button',
            ]
        );

        $this->add_control(
            'jltma_fp_button_border_radius',
            [
                'label'         => esc_html__('Border Radius', 'master-addons' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .jltma-fp-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'jltma_fp_button_padding',
            [
                'label'         => esc_html__('Padding', 'master-addons' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .jltma-fp-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'jltma_fp_button_spacing',
            [
                'label'         => esc_html__('Spacing', 'master-addons' ),
                'type'          => Controls_Manager::SLIDER,
                'default'       => ['size'  => 10],
                'selectors'     => [
                    '{{WRAPPER}} .jltma-featured-product.jltma-fp-style-2 .jltma-fp-button' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
                'condition'     => [
                    'jltma_fp_skin' => 'style-2',
                ],
            ]
        );

        $this->end_controls_section();
        // End Button Style Section
    }

    // Style Tab: Rating
    protected function jltma_fp_style_rating_section()
    {
        // Start Rating Style Section
        $this->start_controls_section(
            'jltma_fp_rating_style',
            [
                'label'         => esc_html__('Rating', 'master-addons' ),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'jltma_fp_star_size',
            [
                'label'         => esc_html__('Size', 'master-addons' ),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default'       => ['size'  => 30],
                'selectors' => [
                    '{{WRAPPER}} .jltma-fp-rating .elementor-star-rating' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'jltma_fp_star_space',
            [
                'label'         => esc_html__('Spacing', 'master-addons' ),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    'body:not(.rtl) {{WRAPPER}} .jltma-fp-rating .elementor-star-rating i:not(:last-of-type)' => 'margin-right: {{SIZE}}{{UNIT}};',
                    'body.rtl {{WRAPPER}} .jltma-fp-rating .elementor-star-rating i:not(:last-of-type)' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'jltma_fp_star_spacing_bottom',
            [
                'label'         => esc_html__('Spacing Bottom', 'master-addons' ),
                'type'          => Controls_Manager::SLIDER,
                'selectors'     => [
                    '{{WRAPPER}} .jltma-featured-product .jltma-fp-rating' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition'     => [
                    'jltma_fp_skin' => 'style-2',
                ],
            ]
        );

        $this->add_control(
            'jltma_fp_stars_color',
            [
                'label'         => esc_html__('Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#F54141',
                'selectors'     => [
                    '{{WRAPPER}} .jltma-fp-rating .elementor-star-rating i:before' => 'color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'jltma_fp_stars_unmarked_color',
            [
                'label'         => esc_html__('Unmarked Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#FDA0A0',
                'selectors'     => [
                    '{{WRAPPER}} .jltma-fp-rating .elementor-star-rating i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
        // End Rating Style Section
    }


    // Style Tab: Ribbon
    protected function jltma_fp_style_ribbon_section()
    {
        // Start Ribbon Style Section
        $this->start_controls_section(
            'jltma_fp_ribbon_style',
            [
                'label'         => esc_html__('Ribbon', 'master-addons' ),
                'tab'           => Controls_Manager::TAB_STYLE,
                'condition'     => [
                    'jltma_fp_show_ribbon' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'jltma_fp_ribbon_space',
            [
                'label'         => esc_html__('Distance', 'master-addons' ),
                'type'          => Controls_Manager::SLIDER,
                'default'       => ['size'  => 35],
                'selectors' => [
                    '{{WRAPPER}} .jltma-fp-ribbon' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
                'condition'     => [
                    'jltma_fp_ribbon_skin' => 'style-2',
                ],
            ]
        );

        $this->add_responsive_control(
            'jltma_fp_ribbon_size',
            [
                'label'         => esc_html__('Ribbon Size', 'master-addons' ),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                ],
                'default'       => ['size'  => 150],
                'selectors' => [
                    '{{WRAPPER}} .jltma-fp-ribbon-container.ribbon-style-1' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; top: calc(-{{SIZE}}{{UNIT}} / 2); left: calc(-{{SIZE}}{{UNIT}} / 2);',
                ],
                'condition'     => [
                    'jltma_fp_ribbon_skin' => 'style-1',
                ],
            ]
        );

        $this->add_responsive_control(
            'jltma_fp_ribbon_size_three',
            [
                'label'         => esc_html__('Size', 'master-addons' ),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'default'       => ['size'  => 75],
                'selectors' => [
                    '{{WRAPPER}} .ribbon-style-3 .jltma-fp-ribbon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
                'condition'     => [
                    'jltma_fp_ribbon_skin' => 'style-3',
                ],
            ]
        );

        $this->add_responsive_control(
            'jltma_fp_ribbon_radius',
            [
                'label'         => esc_html__('Radius', 'master-addons' ),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default'       => ['size'  => 100],
                'selectors' => [
                    '{{WRAPPER}} .ribbon-style-3 .jltma-fp-ribbon' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
                'condition'     => [
                    'jltma_fp_ribbon_skin' => 'style-3',
                ],
            ]
        );

        $this->add_control(
            'jltma_fp_ribbon_color',
            [
                'label'         => esc_html__('Text Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#FFFFFF',
                'selectors'     => [
                    '{{WRAPPER}} .jltma-fp-ribbon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'jltma_fp_ribbon_icon_color',
            [
                'label'         => esc_html__('Icon Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#FFFFFF',
                'selectors'     => [
                    '{{WRAPPER}} .jltma-fp-ribbon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .jltma-fp-ribbon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'jltma_fp_ribbon_background_color',
            [
                'label'         => esc_html__('Background Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#F54141',
                'selectors'     => [
                    '{{WRAPPER}} .jltma-fp-ribbon-container.ribbon-style-1' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .ribbon-style-2 .jltma-fp-ribbon, {{WRAPPER}} .ribbon-style-3 .jltma-fp-ribbon, {{WRAPPER}} .ribbon-style-4 .jltma-fp-ribbon' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'jltma_fp_ribbon_text_typography',
                'label'         => esc_html__('Typography', 'master-addons' ),
                'selector'      => '{{WRAPPER}} .jltma-fp-ribbon-text',
            ]
        );

        $this->add_responsive_control(
            'jltma_fp_ribbon_icon_size',
            [
                'label'         => esc_html__('Icon Size', 'master-addons' ),
                'type'          => Controls_Manager::SLIDER,
                'default'       => ['size'  => 22],
                'selectors' => [
                    '{{WRAPPER}} .jltma-fp-ribbon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .jltma-fp-ribbon svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'jltma_fp_ribbon_icon_spacing',
            [
                'label'         => esc_html__('Icon Spacing', 'master-addons' ),
                'type'          => Controls_Manager::SLIDER,
                'default'       => ['size'  => 5],
                'selectors' => [
                    '{{WRAPPER}} .ribbon-style-1 .jltma-fp-ribbon-icon' => 'margin-top: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .ribbon-style-2 .jltma-fp-ribbon .jltma-fp-ribbon-icon, {{WRAPPER}} .ribbon-style-3 .jltma-fp-ribbon .jltma-fp-ribbon-icon, {{WRAPPER}} .ribbon-style-4 .jltma-fp-ribbon .jltma-fp-ribbon-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'jltma_fp_ribbon_border',
                'selector'      => '{{WRAPPER}} .jltma-fp-ribbon-container.ribbon-style-1, {{WRAPPER}} .ribbon-style-2 .jltma-fp-ribbon, {{WRAPPER}} .ribbon-style-3 .jltma-fp-ribbon, {{WRAPPER}} .ribbon-style-4 .jltma-fp-ribbon',
            ]
        );

        $this->add_responsive_control(
            'jltma_fp_ribbon_border_radius',
            [
                'label'         => esc_html__('Border Radius', 'master-addons' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px'],
                'selectors'     => [
                    '{{WRAPPER}} .ribbon-style-4 .jltma-fp-ribbon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'     => [
                    'jltma_fp_ribbon_skin' => 'style-4',
                ],
            ]
        );

        $this->add_responsive_control(
            'jltma_fp_ribbon_padding',
            [
                'label'         => esc_html__('Padding', 'master-addons' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px'],
                'selectors'     => [
                    '{{WRAPPER}} .jltma-fp-ribbon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'     => [
                    'jltma_fp_ribbon_skin!' => 'style-3',
                ],
            ]
        );

        $this->add_responsive_control(
            'jltma_fp_ribbon_margin',
            [
                'label'         => esc_html__('Margin', 'master-addons' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px'],
                'selectors'     => [
                    '{{WRAPPER}} .ribbon-style-3 .jltma-fp-ribbon, {{WRAPPER}} .ribbon-style-4 .jltma-fp-ribbon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'     => [
                    'jltma_fp_ribbon_skin' => ['style-3', 'style-4'],
                ],
            ]
        );

        $this->end_controls_section();
        // End Ribbon Style Section}
    }

    protected function register_controls()
    {
        $this->jltma_fp_general_section();
        $this->jltma_fp_content_box_section();
        $this->jltma_fp_content_title_section();
        $this->jltma_fp_content_section();
        $this->jltma_fp_content_image_section();

        // Style Tab
        $this->jltma_fp_style_price_section();
        $this->jltma_fp_style_button_section();
        $this->jltma_fp_style_rating_section();
        $this->jltma_fp_style_ribbon_section();
    }



    /**
     * @since 1.0.0
     * @access protected
     */
    protected function get_rating()
    {
        $settings       = $this->get_settings_for_display();
        $rating_scale   = 5;
        $rating         = (float) $settings['jltma_fp_rating'] > $rating_scale ? $rating_scale : $settings['jltma_fp_rating'];

        return [$rating, $rating_scale];
    }

    /**
     * @since 1.0.0
     * @access protected
     */
    protected function render_stars($icon)
    {
        $rating_data    = $this->get_rating();
        $rating         = $rating_data[0];
        $floored_rating = (int) $rating;
        $stars_html     = '';

        for ($stars = 1; $stars <= $rating_data[1]; $stars++) {
            if ($stars <= $floored_rating) {
                $stars_html .= '<i class="elementor-star-full">' . esc_html($icon) . '</i>';
            } elseif ($floored_rating + 1 === $stars && $rating !== $floored_rating) {
                $stars_html .= '<i class="elementor-star-' . ($rating - $floored_rating) * 10 . '">' . esc_html($icon) . '</i>';
            } else {
                $stars_html .= '<i class="elementor-star-empty">' . esc_html($icon) . '</i>';
            }
        }

        return $stars_html;
    }

    protected function render_ribbons()
    {
        $settings       = $this->get_settings();

        if ($settings['jltma_fp_show_ribbon'] === 'yes') {
            if ($settings['jltma_fp_ribbon_skin'] === 'style-1') { ?>
                <div class="jltma-fp-ribbon-container ribbon-style-1"></div>
                <div class="jltma-fp-ribbon ribbon-style-1">
                    <div class="jltma-fp-ribbon-text">
                        <?php esc_html_e($settings['jltma_fp_ribbon']); ?>
                    </div>
                    <div class="jltma-fp-ribbon-icon">
                        <?php Icons_Manager::render_icon($settings['jltma_fp_ribbon_icon'], ['aria-hidden' => 'true']); ?>
                    </div>
                </div>
            <?php } elseif ($settings['jltma_fp_ribbon_skin'] === 'style-2') { ?>
                <div class="jltma-fp-ribbon-container ribbon-style-2">
                    <div class="jltma-fp-ribbon">
                        <span class="jltma-fp-ribbon-text">
                            <?php esc_html_e($settings['jltma_fp_ribbon']); ?>
                        </span>
                        <span class="jltma-fp-ribbon-icon">
                            <?php Icons_Manager::render_icon($settings['jltma_fp_ribbon_icon'], ['aria-hidden' => 'true']); ?>
                        </span>
                    </div>
                </div>
            <?php } elseif ($settings['jltma_fp_ribbon_skin'] === 'style-3') { ?>
                <div class="jltma-fp-ribbon-container ribbon-style-3">
                    <div class="jltma-fp-ribbon">
                        <span class="jltma-fp-ribbon-text"><?php esc_html_e($settings['jltma_fp_ribbon']); ?></span>
                        <span class="jltma-fp-ribbon-icon"><?php Icons_Manager::render_icon($settings['jltma_fp_ribbon_icon'], ['aria-hidden' => 'true']); ?></span>
                    </div>
                </div>
            <?php } else { ?>
                <div class="jltma-fp-ribbon-container ribbon-style-4">
                    <div class="jltma-fp-ribbon">
                        <span class="jltma-fp-ribbon-text"><?php esc_html_e($settings['jltma_fp_ribbon']); ?></span>
                        <span class="jltma-fp-ribbon-icon"><?php Icons_Manager::render_icon($settings['jltma_fp_ribbon_icon'], ['aria-hidden' => 'true']); ?></span>
                    </div>
                </div>
<?php }
        }
        return;
    }


    /**
     * Render MA Pros and Cons Elements widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @access protected
     */
    protected function render()
    {
        $settings    = $this->get_settings();
        $id          = '.elementor-element-' . $this->get_id();
        $rating_data = $this->get_rating();
        $icon        = '&#9733;';
        $button_link = $settings['jltma_fp_link']['url'];
        $target      = $settings['jltma_fp_link']['is_external'] ? ' target="_blank"' : '';
        $rel         = $settings['jltma_fp_link']['nofollow'] ? ' rel="nofollow"' : '';

        switch ($settings['jltma_fp_skin']) {
            case 'style-1':
                include JLTMA_PRO_ADDONS . 'ma-featured-product/skins/style-1.php';
                break;
            case 'style-2':
                include JLTMA_PRO_ADDONS . 'ma-featured-product/skins/style-2.php';
                break;
            case 'style-3':
                include JLTMA_PRO_ADDONS . 'ma-featured-product/skins/style-3.php';
                break;
            case 'style-4':
                include JLTMA_PRO_ADDONS . 'ma-featured-product/skins/style-4.php';
                break;
            default:
                include JLTMA_PRO_ADDONS . 'ma-featured-product/skins/style-1.php';
                break;
        }
    }


    protected function content_template()
    {
    }
}
