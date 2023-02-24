<?php
/*
 * This template can be overridden by copying it to yourtheme/gostudy-core/elementor/widgets/rt-gallery.php.
*/
namespace RTAddons\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\{
    Widget_Base,
    Controls_Manager,
    Group_Control_Background,
    Group_Control_Border,
    Group_Control_Box_Shadow,
    Group_Control_Typography
};
use RTAddons\{
    Gostudy_Global_Variables as Gostudy_Globals,
    Includes\RT_Carousel_Settings,
    Includes\RT_Elementor_Helper
};

class RT_Gallery extends Widget_Base
{
    public function get_name()
    {
        return 'rt-gallery';
    }

    public function get_title()
    {
        return esc_html__('RT Gallery', 'gostudy-core');
    }

    public function get_icon()
    {
        return 'rt-gallery';
    }

    public function get_categories()
    {
        return ['rt-extensions'];
    }

    public function get_script_depends()
    {
        return [
            'slick',
            'imagesloaded',
            'isotope',
            'jquery-justifiedGallery',
            'rt-elementor-extensions-widgets',
        ];
    }

    protected function register_controls()
    {
        /*-----------------------------------------------------------------------------------*/
        /*  GENERAL -> Gallery Settings
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'rt_gallery_section',
            [
                'label' => esc_html__('Gallery Settings', 'gostudy-core'),
            ]
        );

        $this->add_control(
            'gallery',
            [
                'type' => Controls_Manager::GALLERY,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'gallery_layout',
            [
                'label' => esc_html__('Gallery Layout', 'gostudy-core'),
                'type' => 'rt-radio-image',
                'options' => [
                    'grid' => [
                        'title' => esc_html__('Grid', 'gostudy-core'),
                        'image' => RT_ELEMENTOR_ADDONS_URL . 'assets/img/rt_elementor_addon/icons/layout_grid.png',
                    ],
                    'masonry' => [
                        'title' => esc_html__('Masonry', 'gostudy-core'),
                        'image' => RT_ELEMENTOR_ADDONS_URL . 'assets/img/rt_elementor_addon/icons/layout_masonry.png',
                    ],
                    'justified' => [
                        'title' => esc_html__('Justified', 'gostudy-core'),
                        'image' => RT_ELEMENTOR_ADDONS_URL . 'assets/img/rt_elementor_addon/icons/layout_justified.png',
                    ],
                    'carousel' => [
                        'title' => esc_html__('Carousel', 'gostudy-core'),
                        'image' => RT_ELEMENTOR_ADDONS_URL . 'assets/img/rt_elementor_addon/icons/layout_carousel.png',
                    ],
                ],
                'default' => 'grid',
            ]
        );

        $this->add_responsive_control(
            'columns',
            [
                'label' => esc_html__('Columns', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '1' => esc_html__('1', 'gostudy-core'),
                    '2' => esc_html__('2', 'gostudy-core'),
                    '3' => esc_html__('3', 'gostudy-core'),
                    '4' => esc_html__('4', 'gostudy-core'),
                    '5' => esc_html__('5', 'gostudy-core'),
                ],
                'default' => '3',
                'tablet_default' => '2',
                'mobile_default' => '1',
                'render_type' => 'template',
                'prefix_class' => 'col%s-',
                'condition' => [
                    'gallery_layout!' => 'justified'
                ],
            ]
        );

        $this->add_responsive_control(
            'justified_height',
            [
                'label' => esc_html__('Row Height', 'gostudy-core'),
                'type' => Controls_Manager::SLIDER,
                'condition' => ['gallery_layout' => 'justified'],
                'range' => [
                    'px' => ['min' => 20, 'max' => 600],
                ],
                'default' => ['size' => 200],
                'tablet_default' => ['size' => 150],
                'mobile_default' => ['size' => 100],
                'render_type' => 'template',
            ]
        );

        $this->add_responsive_control(
            'gap',
            [
                'label' => esc_html__('Gap', 'gostudy-core'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 10,
                ],
                'tablet_default' => [
                    'size' => 10,
                ],
                'mobile_default' => [
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .rt-gallery_items:not(.gallery-justified) .rt-gallery_item-wrapper' => 'padding: calc({{SIZE}}px / 2);',
                    '{{WRAPPER}} .rt-gallery_items:not(.gallery-justified)' => 'margin: calc(-{{SIZE}}px / 2);',
                ],
                'render_type' => 'template',
            ]
        );

        $this->add_control(
            'img_size_string',
            [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Image Size', 'gostudy-core'),
                'options' => [
                    '150' => 'Thumbnail - 150x150',
                    '300' => 'Medium - 300x300',
                    '768' => 'Medium Large - 768x768',
                    '1024' => 'Large - 1024x1024',
                    'full' => 'Full',
                    'custom' => 'Custom',
                ],
                'default' => 'full',
                'condition' => [
                    'gallery_layout' => ['grid', 'carousel']
                ],
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'img_size_array',
            [
                'label' => esc_html__('Image Dimension', 'gostudy-core'),
                'type' => Controls_Manager::IMAGE_DIMENSIONS,
                'condition' => [
                    'img_size_string' => 'custom',
                    'gallery_layout' => ['grid', 'carousel']
                ],
                'description' => esc_html__('Crop the original image to any custom size. You can also set a single value for width to keep the initial ratio.', 'gostudy-core'),
            ]
        );

        $this->add_control(
            'img_aspect_ratio',
            [
                'label' => esc_html__('Image Aspect Ratio', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => [
                    'gallery_layout' => ['grid', 'carousel']
                ],
                'options' => [
                    '1:1' => '1:1',
                    '3:2' => '3:2',
                    '4:3' => '4:3',
                    '9:16' => '9:16',
                    '16:9' => '16:9',
                    '21:9' => '21:9',
                    '' => 'Not Crop',
                ],
                'default' => '1:1',
            ]
        );

        $this->add_control(
            'link_to',
            [
                'label' => esc_html__('Link', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'none' => esc_html__('None', 'gostudy-core'),
                    'file' => esc_html__('Media File', 'gostudy-core'),
                    'custom' => esc_html__('Custom URL', 'gostudy-core'),
                ],
                'default' => 'file',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'link_custom_notice',
            [
                'type' => Controls_Manager::RAW_HTML,
                'condition' => [
                    'link_to' => 'custom',
                ],
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
                'raw' => esc_html__('Note: Specify the link in the attachment details of each corresponding image.', 'gostudy-core'),
            ]
        );

        $this->add_control(
            'link_target',
            [
                'label' => esc_html__('Open in New Tab', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => [
                    'link_to' => 'custom',
                ],
            ]
        );

        $this->add_control(
            'file_popup',
            [
                'label' => esc_html__('Open in Popup', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => [
                    'link_to' => 'file',
                ],
            ]
        );

        $this->add_control(
            'order_by',
            [
                'label' => esc_html__('Order By', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('Default', 'gostudy-core'),
                    'random' => esc_html__('Random', 'gostudy-core'),
                    'asc' => esc_html__('ASC', 'gostudy-core'),
                    'desc' => esc_html__('DESC', 'gostudy-core'),
                ],
                'separator' => 'before',
                'default' => '',
            ]
        );

        $this->add_control(
            'add_animation',
            [
                'label' => esc_html__('Add Appear Animation', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before',
                'condition' => [
                    'gallery_layout!' => 'carousel'
                ],
            ]
        );

        $this->add_control(
            'appear_animation',
            [
                'label' => esc_html__('Animation Style', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => [
                    'add_animation' => 'yes',
                    'gallery_layout!' => 'carousel'
                ],
                'options' => [
                    'fade-in' => esc_html__('Fade In', 'gostudy-core'),
                    'slide-top' => esc_html__('Slide Top', 'gostudy-core'),
                    'slide-bottom' => esc_html__('Slide Bottom', 'gostudy-core'),
                    'slide-left' => esc_html__('Slide Left', 'gostudy-core'),
                    'slide-right' => esc_html__('Slide Right', 'gostudy-core'),
                    'zoom' => esc_html__('Zoom', 'gostudy-core'),
                ],
                'default' => 'fade-in',
            ]
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  GENERAL -> Carousel Settings
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'rt_carousel_section',
            [
                'label' => esc_html__('Carousel Settings', 'gostudy-core'),
                'condition' => [
                    'gallery_layout' => 'carousel',
                ],
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => esc_html__('Autoplay', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'gostudy-core'),
                'label_off' => esc_html__('Off', 'gostudy-core'),
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label' => esc_html__('Autoplay Speed', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'condition' => ['autoplay' => 'yes'],
                'min' => 1,
                'default' => '3000',
            ]
        );

        $this->add_control(
            'slides_to_scroll',
            [
                'label' => esc_html__('Slide One Item per time', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'gostudy-core'),
                'label_off' => esc_html__('Off', 'gostudy-core'),
            ]
        );

        $this->add_control(
            'infinite',
            [
                'label' => esc_html__('Infinite loop sliding', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'gostudy-core'),
                'label_off' => esc_html__('Off', 'gostudy-core'),
            ]
        );

        $this->add_control(
            'fade_animation',
            [
                'label' => esc_html__('Fade Animation', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['columns' => '1'],
                'label_on' => esc_html__('On', 'gostudy-core'),
                'label_off' => esc_html__('Off', 'gostudy-core'),
            ]
        );

        $this->add_control(
            'use_pagination',
            [
                'label' => esc_html__('Add Pagination control', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'gostudy-core'),
                'label_off' => esc_html__('Off', 'gostudy-core'),
            ]
        );

        $this->add_control(
            'pag_type',
            [
                'label' => esc_html__('Pagination Type', 'gostudy-core'),
                'type' => 'rt-radio-image',
                'condition' => ['use_pagination' => 'yes'],
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
                        'image' => RT_ELEMENTOR_ADDONS_URL . 'assets/img/rt_elementor_addon/icons/pag_circle.png',
                    ],
                ],
                'default' => 'circle',
            ]
        );

        $this->add_control(
            'pag_align',
            [
                'label' => esc_html__('Pagination Aligning', 'gostudy-core'),
	            'type' => Controls_Manager::SLIDER,
                'condition' => ['use_pagination' => 'yes'],

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

        $this->add_control(
            'pag_offset',
            [
                'label' => esc_html__('Pagination Top Offset', 'gostudy-core'),
                'type' => Controls_Manager::SLIDER,
                'condition' => ['use_pagination' => 'yes'],
                'size_units' => ['px'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 1000, 'step' => 5],
                ],
                'selectors' => [
                    '{{WRAPPER}} .rt-carousel .slick-dots' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'custom_pag_color',
            [
                'label' => esc_html__('Custom Pagination Color', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['use_pagination' => 'yes'],
                'label_on' => esc_html__('On', 'gostudy-core'),
                'label_off' => esc_html__('Off', 'gostudy-core'),
            ]
        );

        $this->add_control(
            'pag_color',
            [
                'label' => esc_html__('Pagination Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'condition' => ['custom_pag_color' => 'yes'],
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .pagination_circle .slick-dots li button, {{WRAPPER}} .pagination_square .slick-dots li button, {{WRAPPER}} .pagination_line .slick-dots li button:before' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'use_prev_next',
            [
                'label' => esc_html__('Add Prev/Next buttons', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );
        $this->add_control(
            'custom_prev_next_offset',
            [
                'label' => esc_html__('Custom offset', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['use_prev_next!' => ''],
                'label_on' => esc_html__('On', 'gostudy-core'),
                'label_off' => esc_html__('Off', 'gostudy-core'),
            ]
        );

        $this->add_control(
            'prev_next_offset',
            [
                'label' => esc_html__('Buttons Top Offset', 'gostudy-core'),
                'type' => Controls_Manager::SLIDER,
                'condition' => [
                    'use_prev_next!' => '',
                    'custom_prev_next_offset!' => '',
                ],
                'size_units' => ['%'],
                'range' => [
                    '%' => ['min' => 0, 'max' => 1000],
                ],
                'default' => ['size' => 50, 'unit' => '%'],
                'selectors' => [
                    '{{WRAPPER}} .rt-carousel .slick-next, {{WRAPPER}} .rt-carousel .slick-prev' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'custom_prev_next_color',
            [
                'label' => esc_html__('Customize Arrows Colors', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['use_prev_next' => 'yes'],
            ]
        );

        $this->start_controls_tabs(
            'arrows_style',
            [
                'condition' => [
                    'use_prev_next' => 'yes',
                    'custom_prev_next_color' => 'yes'
                ]
            ]
        );

        $this->start_controls_tab(
            'arrows_button_normal',
            ['label' => esc_html__('Idle', 'gostudy-core')]
        );

        $this->add_control(
            'prev_next_color',
            [
                'label' => esc_html__('Button Text Color', 'gostudy-core'),
                'type' =>  Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => '#ffffff',
            ]
        );

        $this->add_control(
            'prev_next_bg_idle',
            [
                'label' => esc_html__('Button Background Color', 'gostudy-core'),
                'type' =>  Controls_Manager::COLOR,
                'default' => Gostudy_Globals::get_secondary_color(),
            ]
        );

        $this->add_control(
            'prev_next_border_color',
            [
                'label' => esc_html__('Button Border Color', 'gostudy-core'),
                'type' =>  Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => '#ffffff',
                'separator' => 'after',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'arrows_button_hover',
            ['label' => esc_html__('Hover', 'gostudy-core')]
        );

        $this->add_control(
            'prev_next_color_hover',
            [
                'label' => esc_html__('Button Text Color', 'gostudy-core'),
                'type' =>  Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => '#ffffff',
            ]
        );

        $this->add_control(
            'prev_next_bg_hover',
            [
                'label' => esc_html__('Button Background Color', 'gostudy-core'),
                'type' =>  Controls_Manager::COLOR,
                'default' => Gostudy_Globals::get_secondary_color(),
            ]
        );

        $this->add_control(
            'prev_next_border_color_hover',
            [
                'label' => esc_html__('Button Border Color', 'gostudy-core'),
                'type' =>  Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => '#ffffff',
                'separator' => 'after',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  GENERAL -> Content
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'rt_content_section',
            [
                'label' => esc_html__('Image Attachment', 'gostudy-core'),
            ]
        );

        $this->add_control(
            'info_animation',
            [
                'label' => esc_html__('Animation', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('Default', 'gostudy-core'),
                    'until_hover' => esc_html__('Visible Until Hover', 'gostudy-core'),
                    'always' => esc_html__('Always Visible', 'gostudy-core'),
                ],
                'render_type' => 'template',
            ]
        );

        $this->add_control(
            'image_title',
            [
                'label' => esc_html__('Title', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('None', 'gostudy-core'),
                    'alt' => esc_html__('Alt', 'gostudy-core'),
                    'title' => esc_html__('Title', 'gostudy-core'),
                    'caption' => esc_html__('Caption', 'gostudy-core'),
                    'description' => esc_html__('Description', 'gostudy-core'),
                ],
            ]
        );

        $this->add_control(
            'image_descr',
            [
                'label' => esc_html__('Description', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => esc_html__('None', 'gostudy-core'),
                    'alt' => esc_html__('Alt', 'gostudy-core'),
                    'title' => esc_html__('Title', 'gostudy-core'),
                    'caption' => esc_html__('Caption', 'gostudy-core'),
                    'description' => esc_html__('Description', 'gostudy-core'),
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> IMAGE
         */

        $this->start_controls_section(
            'image_styles_section',
            [
                'label' => esc_html__('Image', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('tabs_bg_color');

        $this->start_controls_tab(
            'tab_bg_idle',
            ['label' => esc_html__('Idle', 'gostudy-core')]
        );

        $this->add_control(
            'bg_radius',
            [
                'label' => esc_html__('Border Radius', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .rt-gallery_item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'bg_margin',
            [
                'label' => esc_html__('Image Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .rt-gallery_item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'bg_border',
                'selector' => '{{WRAPPER}} .rt-gallery_item',
                'separator' => 'before',
                'condition' => [
                    'gallery_layout!' => 'justified'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'bg_shadow',
                'selector' => '{{WRAPPER}} .rt-gallery_item',
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'image_bg',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .rt-gallery_item:before',
                'separator' => 'before',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_bg_hover',
            ['label' => esc_html__('Hover', 'gostudy-core')]
        );

        $this->add_control(
            'bg_radius_hover',
            [
                'label' => esc_html__('Border Radius', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .rt-gallery_item:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'bg_border_hover',
                'selector' => '{{WRAPPER}} .rt-gallery_item:hover',
                'separator' => 'before',
                'condition' => [
                    'gallery_layout!' => 'justified'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'bg_shadow_hover',
                'selector' => '{{WRAPPER}} .rt-gallery_item:hover',
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'image_bg_hover',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .rt-gallery_item:after',
                'separator' => 'before',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> INFO
         */

        $this->start_controls_section(
            'info_styles_section',
            [
                'label' => esc_html__('Info', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'info_alignment',
            [
                'label' => esc_html__('Alignment', 'gostudy-core'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'gostudy-core'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'gostudy-core'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'gostudy-core'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .rt-gallery_image-info' => 'text-align: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'info_vertical',
            [
                'label' => esc_html__('Vertical Position', 'gostudy-core'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'top' => [
                        'title' => esc_html__('Top', 'gostudy-core'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'middle' => [
                        'title' => esc_html__('Middle', 'gostudy-core'),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'bottom' => [
                        'title' => esc_html__('Bottom', 'gostudy-core'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'selectors_dictionary' => [
                    'top' => 'flex-start',
                    'middle' => 'center',
                    'bottom' => 'flex-end',
                ],
                'default' => 'middle',
                'selectors' => [
                    '{{WRAPPER}} .rt-gallery_image-info' => 'justify-content: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'info_padding',
            [
                'label' => esc_html__('Info Padding', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .rt-gallery_image-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Title Styles
        $this->add_control(
            'divider_1_1',
            ['type' => Controls_Manager::DIVIDER]
        );

        $this->add_control(
            'divider_1',
            [
                'label' => esc_html__('Title Styles', 'gostudy-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'divider_1_2',
            ['type' => Controls_Manager::DIVIDER]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typo',
                'selector' => '{{WRAPPER}} .rt-gallery_image-title',
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .rt-gallery_image-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_title_color');

        $this->start_controls_tab(
            'tab_title_idle',
            ['label' => esc_html__('Idle', 'gostudy-core')]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Text Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .rt-gallery_image-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_title_hover',
            ['label' => esc_html__('Hover', 'gostudy-core')]
        );

        $this->add_control(
            'title_hover',
            [
                'label' => esc_html__('Text Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-gallery_item:hover .rt-gallery_image-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        // Description Styles
        $this->add_control(
            'divider_2_1',
            ['type' => Controls_Manager::DIVIDER]
        );

        $this->add_control(
            'divider_2',
            [
                'label' => esc_html__('Description Styles', 'gostudy-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'divider_2_2',
            ['type' => Controls_Manager::DIVIDER]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'descr_typo',
                'selector' => '{{WRAPPER}} .rt-gallery_image-descr',
            ]
        );

        $this->add_responsive_control(
            'descr_margin',
            [
                'label' => esc_html__('Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .rt-gallery_image-descr' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_descr_color');

        $this->start_controls_tab(
            'tab_descr_idle',
            ['label' => esc_html__('Idle', 'gostudy-core')]
        );

        $this->add_control(
            'descr_color',
            [
                'label' => esc_html__('Text Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .rt-gallery_image-descr' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_descr_hover',
            ['label' => esc_html__('Hover', 'gostudy-core')]
        );

        $this->add_control(
            'descr_hover',
            [
                'label' => esc_html__('Text Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-gallery_item:hover .rt-gallery_image-descr' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    protected function render()
    {
        $_s = $this->get_settings_for_display();
        $gallery = $_s['gallery'] ?? '';
        $img_size_string = $_s['img_size_string'] ?? '';
        $img_size_array = $_s['img_size_array'] ?? [];
        $img_aspect_ratio = $_s['img_aspect_ratio'] ?? '';
        $open_in_popup = $_s['file_popup'] ? 'yes' : 'no';
        $item_tag = $_s['link_to'] == 'none' ? 'div' : 'a';

        switch ($_s['gallery_layout']) {
            case 'masonry':
                $layout_class = 'gallery-masonry';
                break;
            case 'justified':
                $layout_class = 'gallery-justified';
                $this->add_render_attribute('gallery_items', [
                    'data-height' => $_s['justified_height']['size'],
                    'data-tablet-height' => $_s['justified_height_tablet']['size'],
                    'data-mobile-height' => $_s['justified_height_mobile']['size'],
                    'data-gap' => $_s['gap']['size'],
                    'data-tablet-gap' => $_s['gap_tablet']['size'],
                    'data-mobile-gap' => $_s['gap_mobile']['size'],
                ]);
                break;
            case 'carousel':
                $layout_class = 'gallery-carousel';
                break;
            default:
                $layout_class = '';
                break;
        }

        // Gallery order
        if ($_s['order_by'] == 'random') {
            shuffle($gallery);
        } else if ($_s['order_by'] == 'desc') {
            krsort($gallery);
        }

        $this->add_render_attribute('gallery', [
            'class' => [
                'rt-gallery',
            ],
        ]);

        $this->add_render_attribute('gallery_items', [
            'class' => [
                'rt-gallery_items',
                $layout_class,
            ],
        ]);

        $this->add_render_attribute('gallery_item_wrap', [
            'class' => [
                'rt-gallery_item-wrapper',
            ],
        ]);

        $this->add_render_attribute('gallery_image_info', [
            'class' => [
                'rt-gallery_image-info',
                !empty($_s['info_animation']) ? 'show_' . $_s['info_animation'] : '',
            ],
        ]);

        // Appear Animation
        if ($_s['gallery_layout'] != 'carousel' && $_s['add_animation']) {
            $this->add_render_attribute('gallery_items', [
                'class' => [
                    'appear-animation',
                    $_s['appear_animation'],
                ],
            ]);
        }

        ob_start();
        foreach ($gallery as $index => $item) {
            $id = $item['id'];
            $attachment = get_post($id);
            $image_data = wp_get_attachment_image_src($id, 'full');

            // Image size
            $dim = RT_Elementor_Helper::get_image_dimensions(
                $img_size_array ?: $img_size_string,
                $img_aspect_ratio,
                $image_data
            );

            if ($dim == null) {
                return;
            }

            $image_url = aq_resize($image_data[0], $dim['width'], $dim['height'], true, true, true) ?: $image_data[0];

            // Image Attachment
            $image_arr = [
                'image' => $image_url,
                'src' => $image_url,
                'alt' => get_post_meta($id, '_wp_attachment_image_alt', true),
                'title' => $attachment->post_title,
                'caption' => $attachment->post_excerpt,
                'description' => $attachment->post_content
            ];

            $this->add_render_attribute('gallery_item_' . $index, 'class', 'rt-gallery_item');

            // Link
            switch ($_s['link_to']) {
                case 'file':
                    $this->add_lightbox_data_attributes('gallery_item_' . $index, $id, $open_in_popup, 'all-' . $this->get_id());
                    $this->add_render_attribute('gallery_item_' . $index, [
                        'href' => $image_arr['image'],
                    ]);
                    break;
                case 'custom':
                    $custom_link = get_post_meta($id, 'custom_image_link', true);
                    if (!empty($custom_link)) {
                        $this->add_render_attribute('gallery_item_' . $index, [
                            'href' => $custom_link,
                            'target' => $_s['link_target'] ? '_blank' : '_self',
                        ]);
                        $item_tag = 'a';
                    } else {
                        $item_tag = 'div';
                    }
                    break;
            }

            $this->add_render_attribute(
                'gallery_image' . $index,
                [
                    'class' => 'rt-gallery_image',
                    'src' => $image_arr['src'],
                    'alt' => $image_arr['alt']
                ]
            );

            echo '<div ', $this->get_render_attribute_string('gallery_item_wrap'), '>';
            echo '<', $item_tag, ' ', $this->get_render_attribute_string('gallery_item_' . $index), '>';
            echo '<img ', $this->get_render_attribute_string('gallery_image' . $index), ' />'; // gallery image
            echo !empty($this->attachment_info($_s, $image_arr))
                ? '<div ' . $this->get_render_attribute_string('gallery_image_info') . '>' . $this->attachment_info($_s, $image_arr) . '</div>'
                : ''; // attachment info
            echo '</', $item_tag, '>'; // gallery item
            echo '</div>'; // gallery item wrapper
        }
        $gallery_items = ob_get_clean();

        echo '<div ', $this->get_render_attribute_string('gallery'), '>';
        echo '<div ', $this->get_render_attribute_string('gallery_items'), '>';

        switch ($_s['gallery_layout']) {
            case 'carousel':
                echo RT_Carousel_Settings::init($this->carousel_options($_s), $gallery_items, false);
                break;
            default:
                echo \Gostudy_Theme_Helper::render_html($gallery_items);
                break;
        }

        echo '</div>'; // gallery items
        echo '</div>'; // gallery module wrapper
    }

    private function attachment_info($_s, $image_arr)
    {
        ob_start();
        if ($_s['image_title'] && !empty($image_arr[$_s['image_title']])) {
            echo '<div class="rt-gallery_image-title">', $image_arr[$_s['image_title']], '</div>';
        }
        if ($_s['image_descr'] && !empty($image_arr[$_s['image_descr']])) {
            echo '<div class="rt-gallery_image-descr">', $image_arr[$_s['image_descr']], '</div>';
        }

        return ob_get_clean();
    }

    private function carousel_options($_s)
    {
        return [
            // General
            'slide_to_show' => $_s['columns'],
            'autoplay' => $_s['autoplay'],
            'autoplay_speed' => $_s['autoplay_speed'],
            'slides_to_scroll' => $_s['slides_to_scroll'],
            'infinite' => $_s['infinite'],
            'fade_animation' => $_s['fade_animation'],
            // Navigation
            'use_pagination' => $_s['use_pagination'],
            'pag_type' => $_s['pag_type'],
            'pag_align' => $_s['pag_align'],
            'custom_pag_color' => $_s['custom_pag_color'],
            'pag_color' => $_s['pag_color'],
            'use_prev_next' => $_s['use_prev_next'],
            'custom_prev_next_color' => $_s['custom_prev_next_color'],
            'prev_next_color' => $_s['prev_next_color'],
            'prev_next_color_hover' => $_s['prev_next_color_hover'],
            'prev_next_bg_idle' => $_s['prev_next_bg_idle'],
            'prev_next_bg_hover' => $_s['prev_next_bg_hover'],
            'prev_next_border_color' => $_s['prev_next_border_color'],
            'prev_next_border_color_hover' => $_s['prev_next_border_color_hover'],
            // Responsive
            'custom_resp' => true,
            'resp_medium' => '',
            'resp_medium_slides' => '',
            'resp_tablets' => '1025',
            'resp_tablets_slides' => $_s['columns_tablet'],
            'resp_mobile' => '767',
            'resp_mobile_slides' => $_s['columns_mobile'],
        ];
    }
}
