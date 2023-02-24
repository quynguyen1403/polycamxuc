<?php
/*
 * This template can be overridden by copying it to yourtheme/gostudy-core/elementor/widgets/rt-tabs.php.
*/
namespace RTAddons\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use RTAddons\Includes\RT_Icons;
use RTAddons\Includes\RT_Elementor_Helper;
use Elementor\Frontend;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Control_Media;
use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;
use Elementor\Repeater;


class RT_Tabs extends Widget_Base
{

    public function get_name()
    {
        return 'rt-tabs';
    }

    public function get_title()
    {
        return esc_html__('RT Tabs', 'gostudy-core');
    }

    public function get_icon()
    {
        return 'rt-tabs';
    }

    public function get_categories()
    {
        return ['rt-extensions'];
    }

    protected function register_controls()
    {
        $primary_color = esc_attr(\Gostudy_Theme_Helper::get_option('theme-primary-color'));
        $secondary_color = esc_attr(\Gostudy_Theme_Helper::get_option('theme-secondary-color'));
        $h_font_color = esc_attr(\Gostudy_Theme_Helper::get_option('header-font')['color']);
        $main_font_color = esc_attr(\Gostudy_Theme_Helper::get_option('main-font')['color']);


        /*-----------------------------------------------------------------------------------*/
        /*  CONTENT -> GENERAL
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_content_general',
            ['label' => esc_html__('General', 'gostudy-core')]
        );

        $this->add_responsive_control(
            'tabs_tab_align',
            [
                'label' => esc_html__('Title Alignment', 'gostudy-core'),
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
                    'justify' => [
                        'title' => esc_html__('Justified', 'gostudy-core'),
                        'icon' => 'fa fa-align-justify',
                    ],
                ],
                'default' => 'justify',
                'render_type' => 'template',
            ]
        );

        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  CONTENT -> CONTENT
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_content_content',
            ['label' => esc_html__('Content', 'gostudy-core')]
        );

        $repeater = new Repeater();
        $repeater->add_control(
			'tabs_tab_title',
			[
                'label' => esc_html__('Tab Title', 'gostudy-core'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Tab Title', 'gostudy-core'),
                'dynamic' => ['active' => true],
			]
        );

        $repeater->add_control(
			'tabs_tab_icon_type',
			[
                'label'             => esc_html__('Add Icon/Image', 'gostudy-core'),
                'type'              => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options'           => [
                    ''              => [
                        'title' => esc_html__('None', 'gostudy-core'),
                        'icon' => 'fa fa-ban',
                    ],
                    'font'          => [
                        'title' => esc_html__('Icon', 'gostudy-core'),
                        'icon' => 'fa fa-smile-o',
                    ],
                    'image'         => [
                        'title' => esc_html__('Image', 'gostudy-core'),
                        'icon' => 'fa fa-picture-o',
                    ]
                ],
                'default'           => '',
			]
        );
        $repeater->add_control(
			'tabs_tab_icon_fontawesome',
			[
                'label'       => esc_html__( 'Icon', 'gostudy-core' ),
                'type'        => Controls_Manager::ICONS,
                'label_block' => true,
                'condition'     => [
                    'tabs_tab_icon_type'  => 'font',
                ],
                'description' => esc_html__( 'Select icon from Fontawesome library.', 'gostudy-core' ),
			]
        );
        $repeater->add_control(
			'tabs_tab_icon_thumbnail',
			[
                'label'       => esc_html__( 'Image', 'gostudy-core' ),
                'type'        => Controls_Manager::MEDIA,
                'label_block' => true,
                'condition'     => [
                    'tabs_tab_icon_type'   => 'image',
                ],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
			]
        );
        $repeater->add_control(
			'tabs_content_type',
			[
                'label' => esc_html__('Content Type', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'content' => esc_html__('Content', 'gostudy-core'),
                    'template' => esc_html__('Saved Templates', 'gostudy-core'),
                ],
                'default' => 'content',
			]
        );
        $repeater->add_control(
			'tabs_content_templates',
			[
                'label' => esc_html__('Choose Template', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'options' => RT_Elementor_Helper::get_instance()->get_elementor_templates(),
                'condition' => [
                    'tabs_content_type' => 'template',
                ],
			]
        );
        $repeater->add_control(
			'tabs_content',
			[
                'label' => esc_html__('Tab Content', 'gostudy-core'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio, neque qui velit. Magni dolorum quidem ipsam eligendi, totam, facilis laudantium cum accusamus ullam voluptatibus commodi numquam, error, est. Ea, consequatur.', 'gostudy-core'),
                'dynamic' => ['active' => true],
                'condition' => [
                    'tabs_content_type' => 'content',
                ],
			]
        );

        $this->add_control(
            'tabs_tab',
            [
                'type' => Controls_Manager::REPEATER,
                'seperator' => 'before',
                'default' => [
                    ['tabs_tab_title' => esc_html__('Tab Title 1', 'gostudy-core')],
                    ['tabs_tab_title' => esc_html__('Tab Title 2', 'gostudy-core')],
                    ['tabs_tab_title' => esc_html__('Tab Title 3', 'gostudy-core')],
                ],
                'fields' => $repeater->get_controls(),
                'title_field' => '{{tabs_tab_title}}',
            ]
        );

        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> TITLE
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
                'name' => 'tabs_title_typo',
                'selector' => '{{WRAPPER}} .rt-tabs_title',
            ]
        );

        $this->add_control(
            'tabs_title_tag',
            [
                'label' => esc_html__('Title HTML Tag', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => '‹h1›',
                    'h2' => '‹h2›',
                    'h3' => '‹h3›',
                    'h4' => '‹h4›',
                    'h5' => '‹h5›',
                    'h6' => '‹h6›',
                    'div' => '‹div›',
                ],
                'default' => 'h4',
            ]
        );

        $this->add_responsive_control(
            'title_padding',
            [
                'label' => esc_html__('Padding', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '0',
                    'right' => '35',
                    'bottom' => '15',
                    'left' => '35',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .rt-tabs_header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .rt-tabs_header' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tabs_title_line',
            [
                'label' => esc_html__('Add Title Bottom Line', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'return_value' => 'yes',
            ]
        );

        $this->start_controls_tabs('tabs_header_tabs');

        $this->start_controls_tab(
            'tabs_header_idle',
            ['label' => esc_html__('Idle', 'gostudy-core')]
        );

        $this->add_control(
            'title_color_idle',
            [
                'label' => esc_html__('Text Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $h_font_color,
                'selectors' => [
                    '{{WRAPPER}} .rt-tabs_header' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            't_title_line_color_idle',
            [
                'label' => esc_html__('Title Bottom Line Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'condition' => ['tabs_title_line' => 'yes'],
                'default' => '#e5e5e5',
                'selectors' => [
                    '{{WRAPPER}} .rt-tabs_header:after' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_bg_color_idle',
            [
                'label' => esc_html__('Background Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-tabs_header' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            't_title_border_radius_idle',
            [
                'label' => esc_html__('Border Radius', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .rt-tabs_header' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'tabs_title_border',
                'selector' => '{{WRAPPER}} .rt-tabs_header',
                'fields_options' => [
                    'border' => [ 'default' => 'solid' ],
                    'width' => [ 'default' => [
                        'top' => 0,
                        'right' => 0,
                        'bottom' => 3,
                        'left' => 0,
                    ] ],
                    'color' => [
                        'default' => 'transparent'
                    ],
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tabs_header_hover',
            ['label' => esc_html__('Hover', 'gostudy-core')]
        );

        $this->add_control(
            't_title_color_hover',
            [
                'label' => esc_html__('Text Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $h_font_color,
                'selectors' => [
                    '{{WRAPPER}} .rt-tabs_header:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            't_title_bg_color_hover',
            [
                'label' => esc_html__('Background Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-tabs_header:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            't_title_line_color_hover',
            [
                'label' => esc_html__('Title Bottom Line Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'condition' => ['tabs_title_line' => 'yes'],
                'default' => $primary_color,
                'selectors' => [
                    '{{WRAPPER}} .rt-tabs_header:hover:after' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            't_title_border_radius_hover',
            [
                'label' => esc_html__('Border Radius', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .rt-tabs_header:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 't_title_border_hover',
                'selector' => '{{WRAPPER}} .rt-tabs_header:hover',
                'fields_options' => [
                    'border' => [ 'default' => 'solid' ],
                    'width' => [ 'default' => [
                        'top' => 0,
                        'right' => 0,
                        'bottom' => 3,
                        'left' => 0,
                    ] ],
                    'color' => [
                        'default' => $primary_color
                    ],
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            't_header_active',
            ['label' => esc_html__('Active', 'gostudy-core')]
        );

        $this->add_control(
            't_title_color_active',
            [
                'label' => esc_html__('Text Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $h_font_color,
                'selectors' => [
                    '{{WRAPPER}} .rt-tabs_header.active' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            't_title_bg_color_active',
            [
                'label' => esc_html__('Background Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-tabs_header.active' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            't_title_line_color_active',
            [
                'label' => esc_html__('Title Bottom Line Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'condition' => ['tabs_title_line' => 'yes'],
                'default' => $primary_color,
                'selectors' => [
                    '{{WRAPPER}} .rt-tabs_header.active:after' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            't_title_border_radius_active',
            [
                'label' => esc_html__('Border Radius', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .rt-tabs_header.active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 't_title_border_active',
                'selector' => '{{WRAPPER}} .rt-tabs_header.active',
                'fields_options' => [
                    'border' => [ 'default' => 'solid' ],
                    'width' => [ 'default' => [
                        'top' => 0,
                        'right' => 0,
                        'bottom' => 3,
                        'left' => 0,
                    ] ],
                    'color' => [
                        'default' => $primary_color
                    ],
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> ICON
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => esc_html__('Icon', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'tabs_icon_size',
            [
                'label' => esc_html__('Icon Size', 'gostudy-core'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 26,
                    'unit' => 'px',
                ],
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .rt-tabs_icon:not(.rt-tabs_icon-image)' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tabs_icon_position',
            [
                'label' => esc_html__('Icon/Image Position', 'gostudy-core'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    'top' => [
                        'title' => esc_html__('Top', 'gostudy-core'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'gostudy-core'),
                        'icon' => 'eicon-h-align-right',
                    ],
                    'bottom' => [
                        'title' => esc_html__('Bottom', 'gostudy-core'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                    'left' => [
                        'title' => esc_html__('Left', 'gostudy-core'),
                        'icon' => 'eicon-h-align-left',
                    ]
                ],
                'default' => 'top',
                'render_type' => 'template',
            ]
        );

        $this->add_responsive_control(
            'tabs_icon_margin',
            [
                'label' => esc_html__('Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .rt-tabs_icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_icon_tabs');

        $this->start_controls_tab(
            'tabs_icon_idle',
            ['label' => esc_html__('Idle', 'gostudy-core')]
        );

        $this->add_control(
            'tabs_icon_color',
            [
                'label' => esc_html__('Icon Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-tabs_icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .rt-tabs_icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tabs_icon_hover',
            ['label' => esc_html__('Hover', 'gostudy-core')]
        );

        $this->add_control(
            'tabs_icon_color_hover',
            [
                'label' => esc_html__('Icon Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-tabs_header:hover .rt-tabs_icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .rt-tabs_header:hover .rt-tabs_icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tabs_icon_active',
            ['label' => esc_html__('Active', 'gostudy-core')]
        );

        $this->add_control(
            'tabs_icon_color_active',
            [
                'label' => esc_html__('Icon Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-tabs_header.active .rt-tabs_icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .rt-tabs_header.active .rt-tabs_icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> CONTENT
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_content',
            [
                'label' => esc_html__('Content', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'tabs_content_typo',
                'selector' => '{{WRAPPER}} .rt-tabs_content',
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__('Padding', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '32',
                    'right' => '0',
                    'bottom' => '15',
                    'left' => '0',
                    'unit'  => 'px',
                    'isLinked' => false
                ],
                'selectors' => [
                    '{{WRAPPER}} .rt-tabs_content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tabs_content_margin',
            [
                'label' => esc_html__('Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .rt-tabs_content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'tabs_content_color',
            [
                'label' => esc_html__('Content Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'default' => $main_font_color,
                'selectors' => [
                    '{{WRAPPER}} .rt-tabs_content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'tabs_content_bg_color',
            [
                'label' => esc_html__('Content Background Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .rt-tabs_content' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'tabs_content_border_radius',
            [
                'label' => esc_html__('Border Radius', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .rt-tabs_content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'tabs_content_border',
                'selector' => '{{WRAPPER}} .rt-tabs_content',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {

        $_s = $this->get_settings_for_display();
        $id_int = substr( $this->get_id_int(), 0, 3 );

        $this->add_render_attribute(
            'tabs',
            [
                'class' => [
                    'rt-tabs',
                    'icon_position-'.$_s[ 'tabs_icon_position' ],
                    'tabs_align-'.$_s[ 'tabs_tab_align' ],
	                'tabs_align-'.$_s['tabs_tab_align'],
	                'tabs_align-tablet-'.$_s['tabs_tab_align_tablet'],
	                'tabs_align-mobile-'.$_s['tabs_tab_align_mobile'],
	                'icon_position-'.$_s['tabs_icon_position'],
	                'icon_position-tablet-'.$_s['tabs_icon_position_tablet'],
	                'icon_position-mobile-'.$_s['tabs_icon_position_mobile'],
                ],
            ]
        );

        ?>
        <div <?php echo $this->get_render_attribute_string( 'tabs' ); ?>>

            <div class="rt-tabs_headings"><?php
                foreach ( $_s[ 'tabs_tab' ] as $index => $item ) :

                    $tab_count = $index + 1;
                    $tab_title_key = $this->get_repeater_setting_key( 'tabs_tab_title', 'tabs_tab', $index );
                    $this->add_render_attribute(
                        $tab_title_key,
                        [
                            'data-tab-id' => 'rt-tab_' . $id_int . $tab_count,
                            'class' => [ 'rt-tabs_header' ],
                        ]
                    );

                    ?>
                    <<?php echo $_s[ 'tabs_title_tag' ]; ?> <?php echo $this->get_render_attribute_string( $tab_title_key ); ?>>
                        <span class="rt-tabs_title"><?php echo $item[ 'tabs_tab_title' ] ?></span>

                        <?php
                        // Tab Icon/image
                        if ( $item[ 'tabs_tab_icon_type' ] != '' ) {
                            if ( $item[ 'tabs_tab_icon_type' ] == 'font' && (!empty( $item[ 'tabs_tab_icon_fontawesome' ] )) ) {

                                $icon_font = $item[ 'tabs_tab_icon_fontawesome' ];
                                $icon_out = '';
                                // add icon migration
                                $migrated = isset( $item['__fa4_migrated'][$item[ 'tabs_tab_icon_fontawesome' ]] );
                                $is_new = Icons_Manager::is_migration_allowed();
                                if ( $is_new || $migrated ) {
                                    ob_start();
                                    Icons_Manager::render_icon( $item[ 'tabs_tab_icon_fontawesome' ], [ 'aria-hidden' => 'true' ] );
                                    $icon_out .= ob_get_clean();
                                } else {
                                    $icon_out .= '<i class="icon '.esc_attr($icon_font).'"></i>';
                                }

                                ?>
                                <span class="rt-tabs_icon">
                                    <?php
                                        echo $icon_out;
                                    ?>
                                </span>
                                <?php
                             }
                            if ($item['tabs_tab_icon_type'] == 'image' && !empty($item['tabs_tab_icon_thumbnail'])) {
                                if (!empty($item['tabs_tab_icon_thumbnail']['url'])) {
                                    $this->add_render_attribute('thumbnail', 'src', $item['tabs_tab_icon_thumbnail']['url']);
                                    $this->add_render_attribute('thumbnail', 'alt', Control_Media::get_image_alt($item['tabs_tab_icon_thumbnail']));
                                    $this->add_render_attribute('thumbnail', 'title', Control_Media::get_image_title($item['tabs_tab_icon_thumbnail']));
                                    ?>
                                    <span class="rt-tabs_icon rt-tabs_icon-image">
                                    <?php
                                        echo Group_Control_Image_Size::get_attachment_image_html($item, 'thumbnail', 'tabs_tab_icon_thumbnail');
                                    ?>
                                    </span>
                                    <?php
                                }
                            }
                        }
                        // End Tab Icon/image
                        ?>

                    </<?php echo $_s[ 'tabs_title_tag' ]; ?>>

                <?php endforeach;?>
            </div>

            <div class="rt-tabs_content-wrap"><?php
                foreach ( $_s[ 'tabs_tab' ] as $index => $item ) :

                    $tab_count = $index + 1;
                    $tab_content_key = $this->get_repeater_setting_key( 'tab_content', 'tabs_tab', $index );
                    $this->add_render_attribute(
                        $tab_content_key,
                        [
                            'data-tab-id' => 'rt-tab_' . $id_int . $tab_count,
                            'class' => [ 'rt-tabs_content' ],
                        ]
                    );

                    ?>
                    <div <?php echo $this->get_render_attribute_string( $tab_content_key ); ?>>
                    <?php
                        if ( $item[ 'tabs_content_type' ] == 'content' ) {
                            echo do_shortcode( $item[ 'tabs_content' ] );
                        } else if ( $item[ 'tabs_content_type' ] == 'template' ) {
                            $id = $item[ 'tabs_content_templates' ];
                            $rt_frontend = new Frontend;
                            echo $rt_frontend->get_builder_content_for_display( $id, false );
                        }
                    ?>
                    </div>

                <?php endforeach; ?>
            </div>

        </div>
        <?php

    }

}