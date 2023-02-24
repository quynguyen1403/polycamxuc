<?php

namespace MasterAddons\Addons;

use \Elementor\Utils;
use \Elementor\Repeater;
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

class JLTMA_Comparison_Table extends Widget_Base
{

    public function get_name()
    {
        return 'jltma-comparison-table';
    }

    public function get_title()
    {
        return esc_html__('Comparison Table', 'master-addons' );
    }

    public function get_icon()
    {
        return 'jltma-icon eicon-price-table';
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
        return 'https://master-addons.com/demos/comparison-table/';
    }

    protected function register_controls()
    {

        $this->start_controls_section(
            'jltma_cmpt_section_general',
            [
                'label' => esc_html__('General', 'master-addons' )
            ]
        );

        $this->add_control(
            'jltma_cmpt_skin',
            [
                'label'         => esc_html__('Layouts', 'master-addons' ),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'style-1' => esc_html__('Style 1', 'master-addons' ),
                    'style-2' => esc_html__('Style 2', 'master-addons' ),
                    'style-3' => esc_html__('Style 3', 'master-addons' ),
                    'style-4' => esc_html__('Style 4', 'master-addons' ),
                ],
                'default'       => 'style-1',
            ]
        );

        $this->add_control(
            'jltma_cmpt_product_count',
            [
                'label'         => esc_html__('Products', 'master-addons' ),
                'type'          => Controls_Manager::NUMBER,
                'default'       => 3,
                'min'           => 2,
                'max'           => 6,
            ]
        );
        $this->end_controls_section();
        // End General Section


        // Start Features Section
        $this->start_controls_section(
            'jltma_cmpt_section_feature',
            array(
                'label'         => esc_html__('Features Box', 'master-addons' ),
            )
        );

        $this->add_control(
            'jltma_cmpt_feature_heading',
            [
                'label'         => esc_html__('Heading', 'master-addons' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => esc_html__('Product', 'master-addons' ),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'jltma_cmpt_feature',
            [
                'label'         => esc_html__('Feature', 'master-addons' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => esc_html__('Feature', 'master-addons' ),
            ]
        );

        $this->add_control(
            'jltma_cmpt_feature_list',
            [
                'label'         => esc_html__('Features', 'master-addons' ),
                'type'          => Controls_Manager::REPEATER,
                'fields'        => $repeater->get_controls(),
                'render_type'   => 'template',
                'default'       => [
                    [
                        'jltma_cmpt_feature' => esc_html__('Title', 'master-addons' ),
                    ],
                    [
                        'jltma_cmpt_feature' => esc_html__('Size', 'master-addons' ),
                    ],
                    [
                        'jltma_cmpt_feature' => esc_html__('Warranty', 'master-addons' ),
                    ],
                    [
                        'jltma_cmpt_feature' => esc_html__('Availability', 'master-addons' ),
                    ],
                ],
            ]
        );

        $this->add_control(
            'jltma_cmpt_feature_heading_button',
            [
                'label'         => esc_html__('Button Heading', 'master-addons' ),
                'type'          => Controls_Manager::TEXT,
            ]
        );

        $this->end_controls_section();
        // End General Section

        $this->jltma_add_product();
    }

    // Adding Products on the Section
    protected function jltma_add_product()
    {

        $repeater = new Repeater();

        $repeater->add_control(
            'jltma_cmpt_content_type',
            [
                'label'         => esc_html__('Content', 'master-addons' ),
                'type'          => Controls_Manager::CHOOSE,
                'label_block'   => false,
                'options'       => [
                    'fa fa-check' => [
                        'title' => esc_html__('Yes', 'master-addons' ),
                        'icon'  => 'fa fa-check',
                    ],
                    'fa fa-close' => [
                        'title' => esc_html__('No', 'master-addons' ),
                        'icon'  => 'fa fa-close',
                    ],
                    'icon' => [
                        'title' => esc_html__('Icon', 'master-addons' ),
                        'icon'  => 'fa fa-info',
                    ],
                    'text' => [
                        'title' => esc_html__('Text', 'master-addons' ),
                        'icon'  => 'fa fa-font',
                    ],
                ],
                'default'       => 'text',
            ]
        );

        $repeater->add_control(
            'jltma_cmpt_feature_text',
            [
                'label'         => esc_html__('Feature', 'master-addons' ),
                'type'          => Controls_Manager::TEXT,
                'default'       => esc_html__('Feature', 'master-addons' ),
                'condition'     => [
                    'jltma_cmpt_content_type' => 'text',
                ],
            ]
        );

        $repeater->add_control(
            'jltma_cmpt_feature_icon',
            [
                'label'         => esc_html__('Icon', 'master-addons' ),
                'type'          => Controls_Manager::ICONS,
                'default'       => [
                    'value'     => 'fa fa-shopping-bag',
                    'library'   => 'fa-solid',
                ],
                'condition'     => [
                    'jltma_cmpt_content_type' => 'icon',
                ],
            ]
        );


        for ($i = 1; $i < 7; $i++) {

            $this->start_controls_section(
                'jltma_cmpt_product_section_' . $i,
                [
                    'label'     => /* translators: %s: Product Name. */  sprintf(esc_html__('Product %s', 'master-addons' ), $i),
                    'operator'  => '>',
                    'condition' => [
                        'jltma_cmpt_product_count' => $this->jltma_cmpt_add_condition_value($i),
                    ],
                ]
            );

            $this->add_control(
                'jltma_cmpt_product_title_' . $i,
                [
                    'label'     => esc_html__('Title', 'master-addons' ),
                    'type'      => Controls_Manager::TEXT,
                    'default'   => esc_html__('Title', 'master-addons' ),
                ]
            );

            $this->add_control(
                'jltma_cmpt_product_price_' . $i,
                [
                    'label'     => esc_html__('Price', 'master-addons' ),
                    'type'      => Controls_Manager::TEXT,
                    'default'   => esc_html__('$199', 'master-addons' ),
                ]
            );

            $this->add_control(
                'jltma_cmpt_product_image_' . $i,
                [
                    'label'     => esc_html__('Image', 'master-addons' ),
                    'type'      => Controls_Manager::MEDIA,
                ]
            );

            $this->add_control(
                'jltma_cmpt_button_text_' . $i,
                [
                    'label'     => esc_html__('Button Text', 'master-addons' ),
                    'type'      => Controls_Manager::TEXT,
                    'default'   => esc_html__('Buy Now', 'master-addons' ),
                ]
            );

            $this->add_control(
                'jltma_cmpt_product_link_' . $i,
                [
                    'label'     => esc_html__('Link', 'master-addons' ),
                    'type'      => Controls_Manager::URL,
                    'default'   => [
                        'url'         => '#',
                        'is_external' => '',
                    ],
                ]
            );

            $this->add_control(
                'jltma_cmpt_feature_list_' . $i,
                [
                    'label'         => esc_html__('Features', 'master-addons' ),
                    'type'          => Controls_Manager::REPEATER,
                    'fields'        => $repeater->get_controls(),
                    'render_type'   => 'template',
                    'default'       => [
                        [
                            'jltma_cmpt_feature_text' => esc_html__('Watch', 'master-addons' ),
                        ],
                        [
                            'jltma_cmpt_feature_text' => esc_html__('All', 'master-addons' ),
                        ],
                        [
                            'jltma_cmpt_feature_text' => esc_html__('1 Year', 'master-addons' ),
                        ],
                        [
                            'jltma_cmpt_feature_text' => esc_html__('In Stock', 'master-addons' ),
                        ],
                    ],
                ]
            );

            $this->add_control(
                'jltma_cmpt_override_style_' . $i,
                [
                    'label'        => esc_html__('Override Style', 'master-addons' ),
                    'type'         => Controls_Manager::SWITCHER,
                    'return_value' => 'yes',
                    'default'      => 'no',
                    'separator'    => 'before',
                ]
            );

            $this->add_control(
                'jltma_cmpt_custom_heading_' . $i,
                [
                    'label'         => esc_html__('Heading', 'master-addons' ),
                    'type'          => Controls_Manager::HEADING,
                    'condition'     => [
                        'jltma_cmpt_override_style_' . $i => 'yes',
                    ],
                ]
            );

            $this->add_control(
                'jltma_cmpt_heading_custom_color_' . $i,
                [
                    'label'         => esc_html__('Color', 'master-addons' ),
                    'type'          => Controls_Manager::COLOR,
                    'selectors'     => [
                        '{{WRAPPER}} .jltma-cmpt-product-heading.jltma-cmpt-product-' . $i => 'color: {{VALUE}};',
                    ],
                    'condition'     => [
                        'jltma_cmpt_override_style_' . $i => 'yes',
                    ],
                ]
            );

            $this->add_control(
                'jltma_cmpt_heading_bg_custom_color_' . $i,
                [
                    'label'         => esc_html__('Background Color', 'master-addons' ),
                    'type'          => Controls_Manager::COLOR,
                    'selectors'     => [
                        '{{WRAPPER}} .jltma-cmpt-product-heading.jltma-cmpt-product-' . $i => 'background-color: {{VALUE}} !important;',
                        '{{WRAPPER}} .jltma-cmpt-product-heading.jltma-cmpt-product-' . $i . ' .jltma-cmpt-inner' => 'fill: {{VALUE}};',
                    ],
                    'condition'     => [
                        'jltma_cmpt_override_style_' . $i => 'yes',
                    ],
                ]
            );

            $this->add_control(
                'jltma_cmpt_heading_bg_custom_column_color_' . $i,
                [
                    'label'         => esc_html__('Column Background Color', 'master-addons' ),
                    'type'          => Controls_Manager::COLOR,
                    'selectors'     => [
                        '{{WRAPPER}} .jltma-cmpt-product-heading.jltma-cmpt-product-' . $i . ' .jltma-cmpt-rect' => 'fill: {{VALUE}};',
                    ],
                    'condition'     => [
                        'jltma_cmpt_override_style_' . $i => 'yes',
                        'jltma_cmpt_skin' => 'style-4',
                    ],
                ]
            );

            $this->add_control(
                'jltma_cmpt_heading_bg_custom_border_color_' . $i,
                [
                    'label'         => esc_html__('Border Color', 'master-addons' ),
                    'type'          => Controls_Manager::COLOR,
                    'selectors'     => [
                        '{{WRAPPER}} .jltma-cmpt-product-heading.jltma-cmpt-product-' . $i . ' .jltma-cmpt-border' => 'fill: {{VALUE}};',
                    ],
                    'condition'     => [
                        'jltma_cmpt_override_style_' . $i => 'yes',
                        'jltma_cmpt_skin' => 'style-4',
                    ],
                ]
            );

            $this->add_control(
                'jltma_cmpt_custom_count_' . $i,
                [
                    'label'         => esc_html__('Count', 'master-addons' ),
                    'type'          => Controls_Manager::HEADING,
                    'condition'     => [
                        'jltma_cmpt_override_style_' . $i => 'yes',
                        'jltma_cmpt_skin' => 'style-3',
                    ],
                    'separator'    => 'before',
                ]
            );

            $this->add_control(
                'jltma_cmpt_count_custom_color_' . $i,
                [
                    'label'         => esc_html__('Color', 'master-addons' ),
                    'type'          => Controls_Manager::COLOR,
                    'selectors'     => [
                        '{{WRAPPER}} .jltma-cmpt-product-' . $i . ' .jltma-cmpt-count' => 'color: {{VALUE}}; border-color: {{VALUE}};',
                    ],
                    'condition'     => [
                        'jltma_cmpt_override_style_' . $i => 'yes',
                        'jltma_cmpt_skin' => 'style-3',
                    ],
                ]
            );

            $this->add_control(
                'jltma_cmpt_count_bg_custom_color_' . $i,
                [
                    'label'         => esc_html__('Background Color', 'master-addons' ),
                    'type'          => Controls_Manager::COLOR,
                    'selectors'     => [
                        '{{WRAPPER}} .jltma-cmpt-product-' . $i . ' .jltma-cmpt-count-box' => 'background-color: {{VALUE}};',
                    ],
                    'condition'     => [
                        'jltma_cmpt_override_style_' . $i => 'yes',
                        'jltma_cmpt_skin' => 'style-3',
                    ],
                ]
            );

            $this->add_control(
                'jltma_cmpt_custom_price_' . $i,
                [
                    'label'         => esc_html__('Price', 'master-addons' ),
                    'type'          => Controls_Manager::HEADING,
                    'condition'     => [
                        'jltma_cmpt_override_style_' . $i => 'yes',
                    ],
                    'separator'    => 'before',
                ]
            );

            $this->add_control(
                'jltma_cmpt_price_custom_color_' . $i,
                [
                    'label'         => esc_html__('Color', 'master-addons' ),
                    'type'          => Controls_Manager::COLOR,
                    'selectors'     => [
                        '{{WRAPPER}} .jltma-cmpt-feature.jltma-cmpt-product-price.jltma-cmpt-product-' . $i => 'color: {{VALUE}};',
                    ],
                    'condition'     => [
                        'jltma_cmpt_override_style_' . $i => 'yes',
                    ],
                ]
            );

            $this->add_control(
                'jltma_cmpt_price_bg_custom_color_' . $i,
                [
                    'label'         => esc_html__('Background Color', 'master-addons' ),
                    'type'          => Controls_Manager::COLOR,
                    'selectors'     => [
                        '{{WRAPPER}} .jltma-cmpt-feature.jltma-cmpt-product-price.jltma-cmpt-product-' . $i . ' .jltma-cmpt-price' => 'background-color: {{VALUE}};',
                        '{{WRAPPER}} .jltma-cmpt-style-3 .jltma-cmpt-feature.jltma-cmpt-product-price.jltma-cmpt-product-' . $i => 'background-color: {{VALUE}};',
                    ],
                    'condition'     => [
                        'jltma_cmpt_override_style_' . $i => 'yes',
                        'jltma_cmpt_skin!' => ['style-1', 'style-4'],
                    ],
                ]
            );

            $this->add_control(
                'jltma_cmpt_price_bg_column_custom_color_' . $i,
                [
                    'label'         => esc_html__('Background Column Color', 'master-addons' ),
                    'type'          => Controls_Manager::COLOR,
                    'selectors'     => [
                        '{{WRAPPER}} .jltma-cmpt-feature.jltma-cmpt-product-price.jltma-cmpt-product-' . $i => 'background-color: {{VALUE}};',
                    ],
                    'condition'     => [
                        'jltma_cmpt_override_style_' . $i => 'yes',
                        'jltma_cmpt_skin' => 'style-2',
                    ],
                ]
            );

            $this->add_control(
                'jltma_cmpt_custom_feature_' . $i,
                [
                    'label'         => esc_html__('Features', 'master-addons' ),
                    'type'          => Controls_Manager::HEADING,
                    'condition'     => [
                        'jltma_cmpt_override_style_' . $i => 'yes',
                    ],
                    'separator'    => 'before',
                ]
            );

            $this->add_control(
                'jltma_cmpt_features_custom_color_' . $i,
                [
                    'label'         => esc_html__('Color', 'master-addons' ),
                    'type'          => Controls_Manager::COLOR,
                    'selectors'     => [
                        '{{WRAPPER}} .jltma-cmpt-feature.jltma-cmpt-product-' . $i => 'color: {{VALUE}};',
                    ],
                    'condition'     => [
                        'jltma_cmpt_override_style_' . $i => 'yes',
                    ],
                ]
            );

            $this->add_control(
                'jltma_cmpt_features_tbl_check_color_' . $i,
                [
                    'label'         => esc_html__('Check Color', 'master-addons' ),
                    'type'          => Controls_Manager::COLOR,
                    'selectors'     => [
                        '{{WRAPPER}} .jltma-cmpt-feature.jltma-cmpt-product-' . $i . ' i.fa.fa-check' => 'color: {{VALUE}};',
                    ],
                    'condition'     => [
                        'jltma_cmpt_override_style_' . $i => 'yes',
                    ],
                ]
            );

            $this->add_control(
                'jltma_cmpt_features_tbl_close_color_' . $i,
                [
                    'label'         => esc_html__('Close Color', 'master-addons' ),
                    'type'          => Controls_Manager::COLOR,
                    'selectors'     => [
                        '{{WRAPPER}} .jltma-cmpt-feature.jltma-cmpt-product-' . $i . ' i.fa.fa-close' => 'color: {{VALUE}};',
                    ],
                    'condition'     => [
                        'jltma_cmpt_override_style_' . $i => 'yes',
                    ],
                ]
            );

            $this->add_control(
                'jltma_cmpt_odd_row_custom_color_' . $i,
                [
                    'label'         => esc_html__('Odd Row Color', 'master-addons' ),
                    'type'          => Controls_Manager::COLOR,
                    'selectors'     => [
                        '{{WRAPPER}} tr:nth-child(even) td.jltma-cmpt-product-' . $i => 'background-color: {{VALUE}};',
                    ],
                    'condition'     => [
                        'jltma_cmpt_override_style_' . $i => 'yes',
                    ],
                ]
            );

            $this->add_control(
                'jltma_cmpt_even_row_custom_color_' . $i,
                [
                    'label'         => esc_html__('Even Row Color', 'master-addons' ),
                    'type'          => Controls_Manager::COLOR,
                    'selectors'     => [
                        '{{WRAPPER}} tr:nth-child(odd) td.jltma-cmpt-product-' . $i => 'background-color: {{VALUE}};',
                    ],
                    'condition'     => [
                        'jltma_cmpt_override_style_' . $i => 'yes',
                    ],
                ]
            );

            $this->add_control(
                'jltma_cmpt_custom_button_heading_' . $i,
                [
                    'label'         => esc_html__('Button', 'master-addons' ),
                    'type'          => Controls_Manager::HEADING,
                    'separator'     => 'before',
                    'condition'     => [
                        'jltma_cmpt_override_style_' . $i => 'yes',
                    ],
                ]
            );

            $this->add_control(
                'jltma_cmpt_custom_button_text_color_' . $i,
                [
                    'label'         => esc_html__('Color', 'master-addons' ),
                    'type'          => Controls_Manager::COLOR,
                    'selectors'     => [
                        '{{WRAPPER}} .jltma-cmpt-product-' . $i . ' .jltma-cmpt-product-btn' => 'color: {{VALUE}};',
                    ],
                    'condition'     => [
                        'jltma_cmpt_override_style_' . $i => 'yes',
                    ],
                ]
            );

            $this->add_control(
                'jltma_cmpt_custom_button_bg_color_' . $i,
                [
                    'label'         => esc_html__('Background Color', 'master-addons' ),
                    'type'          => Controls_Manager::COLOR,
                    'selectors'     => [
                        '{{WRAPPER}} .jltma-cmpt-product-' . $i . ' .jltma-cmpt-product-btn' => 'background-color: {{VALUE}};',
                        '{{WRAPPER}} .jltma-cmpt-style-3 .jltma-cmpt-feature-button.jltma-cmpt-product-' . $i => 'background-color: {{VALUE}} !important;',
                    ],
                    'condition'     => [
                        'jltma_cmpt_override_style_' . $i => 'yes',
                    ],
                ]
            );

            $this->add_control(
                'jltma_cmpt_custom_btn_clm_background_color_' . $i,
                [
                    'label'         => esc_html__('Column Background Color', 'master-addons' ),
                    'type'          => Controls_Manager::COLOR,
                    'selectors'     => [
                        '{{WRAPPER}} .jltma-cmpt-feature-button.jltma-cmpt-product-' . $i => 'background-color: {{VALUE}} !important;',
                    ],
                    'condition'     => [
                        'jltma_cmpt_override_style_' . $i => 'yes',
                        'jltma_cmpt_skin!' => 'style-3',
                    ],
                ]
            );

            $this->end_controls_section();
        }

        // Start General Style Tab
        $this->start_controls_section(
            'section_general_style',
            [
                'label'         => esc_html__('General', 'master-addons' ),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'jltma_cmpt_odd_color',
            [
                'label'         => esc_html__('Odd Row Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#E3E3FB',
                'selectors'     => [
                    '{{WRAPPER}} tr:nth-child(even) td' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'jltma_cmpt_even_color',
            [
                'label'         => esc_html__('Even Row Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#FFFFFF',
                'selectors'     => [
                    '{{WRAPPER}} tr:nth-child(odd) td' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'table_border',
                'label'         => esc_html__('Border', 'master-addons' ),
                'fields_options' => [
                    'border'    => [
                        'default' => 'solid',
                    ],
                    'width'     => [
                        'default' => [
                            'top'    => 1,
                            'right'  => 1,
                            'bottom' => 1,
                            'left'   => 1,
                        ],
                    ],
                    'color'  => [
                        'default' => '#FFFFFF',
                    ],
                ],
                'selector'       => '{{WRAPPER}} .jltma-comparison-table td',
                'label_block'   => true,
            ]
        );

        $this->add_control(
            'jltma_cmpt_box_radius_spacing',
            [
                'label'         => esc_html__('Box Radius', 'master-addons' ),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 100,
                    ],
                ],
                'default'       => ['size'  => 15],
                'selectors'     => [
                    '{{WRAPPER}} .jltma-comparison-table.jltma-cmpt-style-2 td.jltma-cmpt-product-price, {{WRAPPER}} .jltma-comparison-table.jltma-cmpt-style-4 .jltma-cmpt-header td' => 'border-top-left-radius: {{SIZE}}{{UNIT}}; border-top-right-radius: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .jltma-comparison-table.jltma-cmpt-style-2 td.jltma-cmpt-feature-button, {{WRAPPER}} .jltma-comparison-table.jltma-cmpt-style-4 td.jltma-cmpt-feature-button, {{WRAPPER}} .jltma-comparison-table.jltma-cmpt-style-4 td.jltma-cmpt-feature-heading-button' => 'border-bottom-left-radius: {{SIZE}}{{UNIT}}; border-bottom-right-radius: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .jltma-comparison-table.jltma-cmpt-style-3 td' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
                'condition'     => [
                    'jltma_cmpt_skin!' => ['style-1']
                ],
            ]
        );

        $this->add_control(
            'jltma_cmpt_box_column_spacing',
            [
                'label'         => esc_html__('Column Spacing', 'master-addons' ),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 100,
                    ],
                ],
                'default'       => ['size'  => 15],
                'selectors'     => [
                    '{{WRAPPER}} .jltma-comparison-table.jltma-cmpt-style-2 table' => 'border-spacing: {{SIZE}}{{UNIT}} 0px;',
                    '{{WRAPPER}} .jltma-comparison-table.jltma-cmpt-style-4 table' => 'border-spacing: {{SIZE}}{{UNIT}} 0px;',
                ],
                'condition'     => [
                    'jltma_cmpt_skin!' => ['style-1'],
                ],
            ]
        );

        $this->add_control(
            'jltma_cmpt_box_row_spacing',
            [
                'label'         => esc_html__('Row Spacing', 'master-addons' ),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 100,
                    ],
                ],
                'default'       => ['size'  => 15],
                'condition'     => [
                    'jltma_cmpt_skin' => ['style-3'],
                ],
            ]
        );

        $this->end_controls_section();
        // End General Style Tab






        // Start Feature Box Style Tab
        $this->start_controls_section(
            'section_feature_box_style',
            [
                'label'         => esc_html__('Feature Box', 'master-addons' ),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'jltma_cmpt_features_box_heading_style',
            [
                'label'         => esc_html__('Heading', 'master-addons' ),
                'type'          => Controls_Manager::HEADING,
            ]
        );

        $this->add_responsive_control(
            'jltma_cmpt_headings_width',
            [
                'label'         => esc_html__('Box Width', 'master-addons' ),
                'type'          => Controls_Manager::SLIDER,
                'size_units'     => ['px', '%'],
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 500,
                    ],
                ],
                'mobile_default'       => ['size' => 50, 'unit' => '%'],
                'selectors'     => [
                    '{{WRAPPER}} .jltma-cmpt-features-heading' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'jltma_cmpt_features_heading_color',
            [
                'label'         => esc_html__('Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#fff',
                'selectors'     => [
                    '{{WRAPPER}} .jltma-cmpt-features-heading' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'feature_heading_bg_color',
            [
                'label'         => esc_html__('Background Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#031468',
                'selectors'     => [
                    '{{WRAPPER}} td.jltma-cmpt-features-heading' => 'background-color: {{VALUE}} !important;',
                    '{{WRAPPER}} .jltma-cmpt-features-heading .jltma-cmpt-inner' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'feature_heading_bg_column_color',
            [
                'label'         => esc_html__('Column Background Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#ffffff',
                'selectors'     => [
                    '{{WRAPPER}} .jltma-cmpt-features-heading .jltma-cmpt-rect' => 'fill: {{VALUE}};',
                ],
                'condition'     => [
                    'jltma_cmpt_skin' => 'style-4',
                ],
            ]
        );

        $this->add_control(
            'feature_heading_bg_border_color',
            [
                'label'         => esc_html__('Border Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .jltma-cmpt-features-heading .jltma-cmpt-border' => 'fill: {{VALUE}};',
                ],
                'condition'     => [
                    'jltma_cmpt_skin' => 'style-4',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'jltma_cmpt_features_heading_typography',
                'selector'  => '{{WRAPPER}} .jltma-cmpt-features-heading',
            ]
        );

        $this->add_responsive_control(
            'jltma_cmpt_features_text_align',
            [
                'label'     => esc_html__('Alignment', 'master-addons' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left' => [
                        'title' => esc_html__('Left', 'master-addons' ),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'master-addons' ),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'master-addons' ),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'default'   => 'center',
                'selectors' => [
                    '{{WRAPPER}} .jltma-cmpt-features-heading' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'jltma_cmpt_features_text_padding',
            [
                'label'         => esc_html__('Padding', 'master-addons' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .jltma-cmpt-features-heading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'jltma_cmpt_feature_box_heading_style',
            [
                'label'         => esc_html__('Feature', 'master-addons' ),
                'type'          => Controls_Manager::HEADING,
                'separator'     => 'before',
            ]
        );

        $this->add_control(
            'jltma_cmpt_feature_text_color',
            [
                'label'         => esc_html__('Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .jltma-cmpt-feature-heading' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'jltma_cmpt_feature_text_bg_color',
            [
                'label'         => esc_html__('Primary Background Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} tbody tr:nth-child(odd) .jltma-cmpt-feature-heading' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'jltma_cmpt_feature_even_color',
            [
                'label'         => esc_html__('Secondary Row Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} tbody tr:nth-child(even) .jltma-cmpt-feature-heading' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'jltma_cmpt_feature_text_typography',
                'selector'      => '{{WRAPPER}} .jltma-cmpt-feature-heading',
            ]
        );

        $this->add_responsive_control(
            'jltma_cmpt_feature_text_align',
            [
                'label'         => esc_html__('Alignment', 'master-addons' ),
                'type'          => Controls_Manager::CHOOSE,
                'options'       => [
                    'left' => [
                        'title' => esc_html__('Left', 'master-addons' ),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'master-addons' ),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'master-addons' ),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'default'       => 'left',
                'selectors'     => [
                    '{{WRAPPER}} .jltma-cmpt-feature-heading' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'jltma_cmpt_feature_text_padding',
            [
                'label'         => esc_html__('Padding', 'master-addons' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .jltma-cmpt-feature-heading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        // End Feature Box Style Tab

        // Start Products Style Tab
        $this->start_controls_section(
            'section_products_box_style',
            [
                'label'         => esc_html__('Products', 'master-addons' ),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'jltma_cmpt_product_box_heading_style',
            [
                'label'         => esc_html__('Heading', 'master-addons' ),
                'type'          => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'jltma_cmpt_tab_format',
            [
                'label'         => esc_html__('Start Tab Format From', 'master-addons' ),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 1200,
                    ],
                ],
                'default'       => ['size'  => 767],
            ]
        );

        $this->add_control(
            'jltma_cmpt_heading_text_color',
            [
                'label'         => esc_html__('Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#FFFFFF',
                'selectors'     => [
                    '{{WRAPPER}} .jltma-cmpt-product-heading' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'jltma_cmpt_heading_active_text_color',
            [
                'label'         => esc_html__('Active Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .jltma-cmpt-product-heading.active' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'jltma_cmpt_heading_text_bg_color',
            [
                'label'         => esc_html__('Background Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#031468',
                'selectors'     => [
                    '{{WRAPPER}} .jltma-comparison-table.jltma-cmpt-style-1 tr:nth-child(odd) .jltma-cmpt-product-heading' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .jltma-comparison-table.jltma-cmpt-style-3 tr:nth-child(odd) .jltma-cmpt-product-heading' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .jltma-comparison-table.jltma-cmpt-style-2 tr:nth-child(even) .jltma-cmpt-product-heading' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .jltma-comparison-table.jltma-cmpt-style-4 tr:nth-child(odd) .jltma-cmpt-product-heading' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} li.jltma-cmpt-product-heading' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .jltma-cmpt-product-heading .jltma-cmpt-inner' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'jltma_cmpt_heading_active_text_bg_color',
            [
                'label'         => esc_html__('Active Background Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .jltma-cmpt-product-heading.active' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'feature_product_bg_column_color',
            [
                'label'         => esc_html__('Column Background Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#ffffff',
                'selectors'     => [
                    '{{WRAPPER}} .jltma-cmpt-product-heading .jltma-cmpt-rect' => 'fill: {{VALUE}};',
                ],
                'condition'     => [
                    'jltma_cmpt_skin' => 'style-4',
                ],
            ]
        );

        $this->add_control(
            'feature_product_bg_border_color',
            [
                'label'         => esc_html__('Border Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .jltma-cmpt-product-heading .jltma-cmpt-border' => 'fill: {{VALUE}};',
                ],
                'condition'     => [
                    'jltma_cmpt_skin' => 'style-4',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'jltma_cmpt_heading_text_typography',
                'selector'      => '{{WRAPPER}} .jltma-cmpt-product-heading',
            ]
        );

        $this->add_responsive_control(
            'jltma_cmpt_heading_text_align',
            [
                'label'         => esc_html__('Alignment', 'master-addons' ),
                'type'          => Controls_Manager::CHOOSE,
                'options'       => [
                    'left' => [
                        'title' => esc_html__('Left', 'master-addons' ),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'master-addons' ),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'master-addons' ),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'default'       => 'center',
                'selectors'     => [
                    '{{WRAPPER}} .jltma-cmpt-product-heading' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'jltma_cmpt_heading_text_padding',
            [
                'label'         => esc_html__('Padding', 'master-addons' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', '%'],
                'selectors'     => [
                    '{{WRAPPER}} td.jltma-cmpt-product-heading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'jltma_cmpt_heading_spacing',
            [
                'label'         => esc_html__('Spacing', 'master-addons' ),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 100,
                    ],
                ],
                'selectors'     => [
                    '{{WRAPPER}} .jltma-cmpt-product-img' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'jltma_cmpt_image_width',
            [
                'label'         => esc_html__('Image Width', 'master-addons' ),
                'type'          => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 1000,
                    ],
                ],
                'selectors'     => [
                    '{{WRAPPER}} .jltma-cmpt-product-img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'jltma_cmpt_heading_image_radius',
            [
                'label'         => esc_html__('Image Radius', 'master-addons' ),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 100,
                    ],
                ],
                'default'       => ['size' => 20],
                'selectors'     => [
                    '{{WRAPPER}} .jltma-cmpt-product-img' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'jltma_cmpt_product_box_count_style',
            [
                'label'         => esc_html__('Count', 'master-addons' ),
                'type'          => Controls_Manager::HEADING,
                'separator'     => 'before',
                'condition'     => [
                    'jltma_cmpt_skin' => 'style-3',
                ],
            ]
        );

        $this->add_control(
            'jltma_cmpt_product_count_text_color',
            [
                'label'         => esc_html__('Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#031468',
                'selectors'     => [
                    '{{WRAPPER}} .jltma-cmpt-count' => 'color: {{VALUE}}; border-color: {{VALUE}};',
                ],
                'condition'     => [
                    'jltma_cmpt_skin' => 'style-3',
                ],
            ]
        );

        $this->add_control(
            'jltma_cmpt_product_count_bg_color',
            [
                'label'         => esc_html__('Background Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#E3E3FB',
                'selectors'     => [
                    '{{WRAPPER}} .jltma-cmpt-count-box' => 'background-color: {{VALUE}};',
                ],
                'condition'     => [
                    'jltma_cmpt_skin' => 'style-3',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'jltma_cmpt_product_count_text_typography',
                'selector'      => '{{WRAPPER}} .jltma-cmpt-count-box',
                'condition'     => [
                    'jltma_cmpt_skin' => 'style-3',
                ],
            ]
        );

        $this->add_responsive_control(
            'jltma_cmpt_count_width',
            [
                'label'         => esc_html__('Width', 'master-addons' ),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 100,
                    ],
                ],
                'selectors'     => [
                    '{{WRAPPER}} .jltma-comparison-table.jltma-cmpt-style-3 .jltma-cmpt-count' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .jltma-comparison-table.jltma-cmpt-style-3 .jltma-cmpt-count-box' => 'top: -{{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .jltma-comparison-table.jltma-cmpt-style-3 table' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
                'condition'     => [
                    'jltma_cmpt_skin' => 'style-3',
                ],
            ]
        );

        $this->add_control(
            'jltma_cmpt_product_box_price_style',
            [
                'label'         => esc_html__('Price', 'master-addons' ),
                'type'          => Controls_Manager::HEADING,
                'separator'     => 'before',
            ]
        );

        $this->add_control(
            'jltma_cmpt_product_price_text_color',
            [
                'label'         => esc_html__('Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .jltma-cmpt-feature.jltma-cmpt-product-price' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .jltma-cmpt-product-heading .jltma-cmpt-product-price' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'jltma_cmpt_product_price_bg_color',
            [
                'label'         => esc_html__('Background Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#E3E3FB',
                'selectors'     => [
                    '{{WRAPPER}} .jltma-cmpt-feature.jltma-cmpt-product-price .jltma-cmpt-price' => 'background-color: {{VALUE}};',
                ],
                'condition'     => [
                    'jltma_cmpt_skin' => 'style-2',
                ],
            ]
        );

        $this->add_control(
            'jltma_cmpt_product_price_column_color',
            [
                'label'         => esc_html__('Column Background Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#FFFFFF',
                'selectors'     => [
                    '{{WRAPPER}} .jltma-cmpt-feature.jltma-cmpt-product-price' => 'background-color: {{VALUE}};',
                ],
                'condition'     => [
                    'jltma_cmpt_skin' => 'style-2',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'jltma_cmpt_product_price_text_typography',
                'selector'      => '{{WRAPPER}} .jltma-cmpt-feature.jltma-cmpt-product-price',
                'condition'     => [
                    'jltma_cmpt_skin!' => 'style-4',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'jltma_cmpt_product_price_text_typography_4',
                'selector'      => '{{WRAPPER}} .jltma-cmpt-product-heading .jltma-cmpt-product-price',
                'condition'     => [
                    'jltma_cmpt_skin' => 'style-4',
                ],
            ]
        );

        $this->add_responsive_control(
            'jltma_cmpt_price_box',
            [
                'label'         => esc_html__('Box size', 'master-addons' ),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'        => [
                        'min'   => 0,
                        'max'   => 150,
                    ],
                ],
                'default'       => ['size' => 80],
                'selectors'     => [
                    '{{WRAPPER}} .jltma-cmpt-price' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
                'condition'     => [
                    'jltma_cmpt_skin' => 'style-2',
                ],
            ]
        );

        $this->add_responsive_control(
            'jltma_cmpt_product_price_text_padding',
            [
                'label'         => esc_html__('Padding', 'master-addons' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .jltma-cmpt-style-2 .jltma-cmpt-feature.jltma-cmpt-product-price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .jltma-cmpt-style-3 .jltma-cmpt-feature.jltma-cmpt-product-price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'     => [
                    'jltma_cmpt_skin' => ['style-2', 'style-3']
                ],
            ]
        );

        $this->add_control(
            'jltma_cmpt_product_box_feature_style',
            [
                'label'         => esc_html__('Feature', 'master-addons' ),
                'type'          => Controls_Manager::HEADING,
                'separator'     => 'before',
            ]
        );

        $this->add_control(
            'jltma_cmpt_product_features_text_color',
            [
                'label'         => esc_html__('Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#000000',
                'selectors'     => [
                    '{{WRAPPER}} .jltma-cmpt-feature' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'jltma_cmpt_features_check_color',
            [
                'label'         => esc_html__('Check Icon Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#0AB179',
                'selectors'     => [
                    '{{WRAPPER}} .jltma-cmpt-feature i.fa.fa-check' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'jltma_cmpt_features_close_color',
            [
                'label'         => esc_html__('Close Icon Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#F44336',
                'selectors'     => [
                    '{{WRAPPER}} .jltma-cmpt-feature i.fa.fa-close' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'jltma_cmpt_product_feature_text_typography',
                'selector'      => '{{WRAPPER}} .jltma-cmpt-feature',
            ]
        );

        $this->add_responsive_control(
            'jltma_cmpt_product_feature_text_align',
            [
                'label'         => esc_html__('Alignment', 'master-addons' ),
                'type'          => Controls_Manager::CHOOSE,
                'options'       => [
                    'left' => [
                        'title' => esc_html__('Left', 'master-addons' ),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'master-addons' ),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'master-addons' ),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'default'       => 'center',
                'selectors'     => [
                    '{{WRAPPER}} .jltma-cmpt-feature' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'jltma_cmpt_product_feature_text_padding',
            [
                'label'         => esc_html__('Padding', 'master-addons' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .jltma-cmpt-feature, {{WRAPPER}} .jltma-cmpt-feature-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        // End Products Style Tab

        // Start Button Style Tab
        $this->start_controls_section(
            'jltma_cmpt_button_style',
            [
                'label'         => esc_html__('Button', 'master-addons' ),
                'tab'           => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'jltma_cmpt_button_heading_style',
            [
                'label'         => esc_html__('Heading', 'master-addons' ),
                'type'          => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'jltma_cmpt_button_heading_color',
            [
                'label'         => esc_html__('Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .jltma-cmpt-feature-heading-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'jltma_cmpt_button_heading_bg_color',
            [
                'label'         => esc_html__('Background Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .jltma-comparison-table .jltma-cmpt-feature-heading-button' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'button_heading_typography',
                'selector'      => '{{WRAPPER}} .jltma-cmpt-feature-heading-button',
            ]
        );

        $this->add_control(
            'jltma_cmpt_button_head_style',
            [
                'label'         => esc_html__('Button', 'master-addons' ),
                'type'          => Controls_Manager::HEADING,
                'separator'     => 'before',
            ]
        );

        $this->add_control(
            'jltma_cmpt_button_color_3',
            [
                'label'         => esc_html__('Text Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#FFFFFF',
                'selectors'     => [
                    '{{WRAPPER}} .jltma-cmpt-style-3 .jltma-cmpt-product-btn' => 'color: {{VALUE}};',
                ],
                'condition'     => [
                    'jltma_cmpt_skin' => 'style-3',
                ],
            ]
        );

        $this->add_control(
            'jltma_cmpt_btn_background_color_3',
            [
                'label'         => esc_html__('Background Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#031468',
                'selectors'     => [
                    '{{WRAPPER}} .jltma-cmpt-style-3 .jltma-cmpt-feature-button' => 'background-color: {{VALUE}};',
                ],
                'condition'     => [
                    'jltma_cmpt_skin' => 'style-3',
                ],
            ]
        );

        $this->start_controls_tabs(
            'jltma_cmpt_button_style_tabs',
            [
                'condition'     => [
                    'jltma_cmpt_skin!' => 'style-3',
                ],
            ]
        );

        $this->start_controls_tab(
            'jltma_cmpt_button_style_normal_tab',
            [
                'label'         => esc_html__('Normal', 'master-addons' ),
            ]
        );

        $this->add_control(
            'jltma_cmpt_button_color',
            [
                'label'         => esc_html__('Text Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#FFFFFF',
                'selectors'     => [
                    '{{WRAPPER}} .jltma-cmpt-product-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'jltma_cmpt_btn_background_color',
            [
                'label'         => esc_html__('Background Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'default'       => '#031468',
                'selectors'     => [
                    '{{WRAPPER}} .jltma-cmpt-product-btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'jltma_cmpt_button_style_hover_tab',
            [
                'label'         => esc_html__('Hover', 'master-addons' ),
            ]
        );

        $this->add_control(
            'jltma_cmpt_button_color_hover',
            [
                'label'         => esc_html__('Text Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .jltma-cmpt-product-btn:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'jltma_cmpt_btn_background_color_hover',
            [
                'label'         => esc_html__('Background Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .jltma-cmpt-product-btn:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'jltma_cmpt_btn_border_color_hover',
            [
                'label'         => esc_html__('Border Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} .jltma-cmpt-product-btn:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'jltma_cmpt_btn_clm_background_color',
            [
                'label'         => esc_html__('Column Background Color', 'master-addons' ),
                'type'          => Controls_Manager::COLOR,
                'selectors'     => [
                    '{{WRAPPER}} tr:last-child td' => 'background-color: {{VALUE}};',
                ],
                'separator'     => 'before',
                'condition'     => [
                    'jltma_cmpt_skin!' => 'style-3',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'          => 'btn_text_typography',
                'label'         => esc_html__('Typography', 'master-addons' ),
                'selector'      => '{{WRAPPER}} .jltma-cmpt-product-btn',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'          => 'jltma_cmpt_button_shadow',
                'label'         => 'Box Shadow',
                'selector'      => '{{WRAPPER}} .jltma-cmpt-product-btn',
                'condition'     => [
                    'jltma_cmpt_skin!' => 'style-3',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'          => 'jltma_cmpt_btn_border',
                'label'         => esc_html__('Border', 'master-addons' ),
                'selector'      => '{{WRAPPER}} .jltma-cmpt-product-btn',
                'condition'     => [
                    'jltma_cmpt_skin!' => 'style-3',
                ],
            ]
        );

        $this->add_control(
            'jltma_cmpt_btn_border_radius',
            [
                'label'         => esc_html__('Border Radius', 'master-addons' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .jltma-cmpt-product-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'     => [
                    'jltma_cmpt_skin!' => 'style-3',
                ],
            ]
        );

        $this->add_responsive_control(
            'jltma_cmpt_button_padding',
            [
                'label'         => esc_html__('Padding', 'master-addons' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .jltma-cmpt-product-btn ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'     => [
                    'jltma_cmpt_skin!' => 'style-3',
                ],
            ]
        );

        $this->add_responsive_control(
            'jltma_cmpt_button_margin',
            [
                'label'         => esc_html__('Margin', 'master-addons' ),
                'type'          => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px', 'em', '%'],
                'selectors'     => [
                    '{{WRAPPER}} .jltma-cmpt-product-btn ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'     => [
                    'jltma_cmpt_skin!' => 'style-3',
                ],
            ]
        );

        $this->end_controls_section();
        // End Button Style Tab


    }


    // Function for counting products
    public function jltma_cmpt_add_condition_value($j)
    {
        $value = [];

        for ($i = $j; $i < 7; $i++) {
            $value[] = $i;
        }
        return $value;
    }



    /**
     * Render Comparison Table Elements widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @access protected
     */
    protected function render()
    {
        $settings = $this->get_settings();
        $id = '.elementor-element-' . $this->get_id();

        switch ($settings['jltma_cmpt_skin']) {
            case 'style-1':
                include JLTMA_PRO_ADDONS . 'ma-comparison-table/skins/style-1.php';
                break;
            case 'style-2':
                include JLTMA_PRO_ADDONS . 'ma-comparison-table/skins/style-2.php';
                break;
            case 'style-3':
                include JLTMA_PRO_ADDONS . 'ma-comparison-table/skins/style-3.php';
                break;
            case 'style-4':
                include JLTMA_PRO_ADDONS . 'ma-comparison-table/skins/style-4.php';
                break;
            default:
                include JLTMA_PRO_ADDONS . 'ma-comparison-table/skins/style-1.php';
                break;
        }
?>


        <style type="text/css">
            <?php esc_attr_e($id); ?>.jltma-comparison-table.jltma-cmpt-style-3 table {
                border-spacing: <?php esc_attr_e($settings['jltma_cmpt_box_column_spacing']['size']); ?>px <?php esc_attr_e($settings['jltma_cmpt_box_row_spacing']['size']); ?>px;
            }

            @media (max-width: <?php esc_attr_e($settings['jltma_cmpt_tab_format']['size']); ?>px) {
                <?php esc_attr_e($id); ?>.jltma-comparison-table ul {
                    display: flex;
                }

                <?php esc_attr_e($id); ?>.jltma-comparison-table tr td:nth-child(2) {
                    display: table-cell;
                }

                <?php esc_attr_e($id); ?>.jltma-comparison-table td:nth-child(1) {
                    display: table-cell;
                }

                <?php esc_attr_e($id); ?>.jltma-comparison-table td {
                    display: none;
                }
            }

            @media (min-width: calc(<?php esc_attr_e($settings['jltma_cmpt_tab_format']['size']); ?>px + 1px)) {
                <?php esc_attr_e($id); ?>.jltma-comparison-table td {
                    display: table-cell !important;
                }

                <?php esc_attr_e($id); ?>.jltma-comparison-table td.jltma-cmpt-hide {
                    display: none !important;
                }
            }
        </style><?php
            }


            protected function content_template()
            {
            }
        }
