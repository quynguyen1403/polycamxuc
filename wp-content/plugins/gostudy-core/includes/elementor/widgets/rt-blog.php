<?php
/*
 * This template can be overridden by copying it to yourtheme/gostudy-core/elementor/widgets/rt-blog.php.
*/
namespace RTAddons\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\{
    Widget_Base,
    Controls_Manager,
    Group_Control_Border,
    Group_Control_Typography,
    Group_Control_Background,
    Group_Control_Box_Shadow
};
use RTAddons\{
    Gostudy_Global_Variables as Gostudy_Globals,
    Includes\RT_Loop_Settings,
    Templates\RT_Blog as Blog_Template
};

class RT_Blog extends Widget_Base
{
    public function get_name()
    {
        return 'rt-blog';
    }

    public function get_title()
    {
        return esc_html__('RT Blog', 'gostudy-core');
    }

    public function get_icon()
    {
        return 'rt-blog';
    }

    public function get_script_depends()
    {
        return [
            'slick',
            'jarallax',
            'jarallax-video',
            'imagesloaded',
            'isotope',
            'rt-elementor-extensions-widgets',
        ];
    }

    public function get_categories()
    {
        return ['rt-extensions'];
    }

    protected function register_controls()
    {
        /**
         * CONTENT -> LAYOUT
         */

        $this->start_controls_section(
            'section_content_layout',
            ['label' => esc_html__('Layout', 'gostudy-core') ]
        );

        $this->add_control(
            'blog_title',
            [
                'label' => esc_html__('Title', 'gostudy-core'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
                'label_block' => true,
            ]
        );

        $this->add_control(
            'blog_subtitle',
            [
                'label' => esc_html__('Subitle', 'gostudy-core'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
                'separator' => 'after',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'blog_layout',
            [
                'label' => esc_html__('Layout', 'gostudy-core'),
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
                    'carousel' => [
                        'title' => esc_html__('Carousel', 'gostudy-core'),
                        'image' => RT_ELEMENTOR_ADDONS_URL . 'assets/img/rt_elementor_addon/icons/layout_carousel.png',
                    ],
                ],
                'default' => 'grid',
            ]
        );

        $this->add_control(
            'blog_columns',
            [
                'label' => esc_html__('Grid Columns Amount', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'label_block' => true,
                'options' => [
                    '12' => esc_html__('1 / One', 'gostudy-core'),
                    '6' => esc_html__('2 / Two', 'gostudy-core'),
                    '4' => esc_html__('3 / Three', 'gostudy-core'),
                    '3' => esc_html__('4 / Four', 'gostudy-core')
                ],
                'default' => '12',
                'tablet_default' => 'inherit',
                'mobile_default' => '1',
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'img_size_string',
            [
                'label' => esc_html__('Image Size', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => [
                    'blog_layout' => ['grid', 'carousel']
                ],
                'separator' => 'before',
                'options' => [
                    '150' => 'Thumbnail - 150x150',
                    '300' => 'Medium - 300x300',
                    '768' => 'Medium Large - 768x768',
                    '1024' => 'Large - 1024x1024',
                    '740x600' => '740x600 - 3 col',
                    '1140x950' => '1140x950 - 2 col',
                    '1170x725' => '1170x725 - 1 col',
                    'full' => 'Full',
                    'custom' => 'Custom',
                ],
                'default' => '1170x725', // 1col
            ]
        );

        $this->add_control(
            'img_size_array',
            [
                'label' => esc_html__('Image Dimension', 'gostudy-core'),
                'type' => Controls_Manager::IMAGE_DIMENSIONS,
                'condition' => [
                    'img_size_string' => 'custom',
                    'blog_layout' => ['grid', 'carousel']
                ],
                'description' => esc_html__('Crop the original image to any custom size. You can also set a single value for width to keep the initial ratio.', 'gostudy-core'),
                'default' => [
                    'width' => '1170',
                    'height' => '750',
                ]
            ]
        );

        $this->add_control(
            'img_aspect_ratio',
            [
                'label' => esc_html__('Image Aspect Ratio', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => [
                    'blog_layout' => ['grid', 'carousel'],
                    'img_size_string!' => 'custom',
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
                'default' => '',
            ]
        );

        $this->add_control(
            'navigation_type',
            [
                'label' => esc_html__('Navigation Type', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => [
                    'blog_layout' => ['grid', 'masonry']
                ],
                'separator' => 'before',
                'options' => [
                    'none' => esc_html__('None', 'gostudy-core'),
                    'pagination' => esc_html__('Pagination', 'gostudy-core'),
                    'load_more' => esc_html__('Load More', 'gostudy-core'),
                ],
                'default' => 'none',
            ]
        );

        $this->add_responsive_control(
            'navigation_align',
            [
                'label' => esc_html__('Navigation\'s Alignment', 'gostudy-core'),
                'type' => Controls_Manager::CHOOSE,
                'condition' => ['navigation_type' => 'pagination'],
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
                'prefix_class' => 'nav-%s',
            ]
        );

        $this->add_control(
            'navigation_offset',
            [
                'label' => esc_html__('Navigation Margin Top', 'gostudy-core'),
                'type' => Controls_Manager::SLIDER,
                'condition' => [
                    'navigation_type' => 'pagination',
                    'blog_layout' => ['grid', 'masonry']
                ],
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 240],
                ],
                'default' => ['size' => 60],
                'selectors' => [
                    '{{WRAPPER}} .rt-pagination' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'items_load',
            [
                'label' => esc_html__('Items to be loaded', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'condition' => [
                    'navigation_type' => 'load_more',
                    'blog_layout' => ['grid', 'masonry']
                ],
                'min' => 1,
                'default' => 4,
            ]
        );

        $this->add_control(
            'load_more_text',
            [
                'label' => esc_html__('Button Text', 'gostudy-core'),
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'navigation_type' => 'load_more',
                    'blog_layout' => ['grid', 'masonry']
                ],
                'dynamic' => ['active' => true],
                'default' => esc_html__('LOAD MORE', 'gostudy-core'),
            ]
        );

        $this->end_controls_section();

        /**
         * CONTENT -> APPEARANCE
         */

        $this->start_controls_section(
            'section_content_appearance',
            ['label' => esc_html__('Appearance', 'gostudy-core') ]
        );

        $this->add_control(
            'hide_media',
            [
                'label' => esc_html__('Hide Media?', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'media_link',
            [
                'label' => esc_html__('Clickable Image?', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['hide_media' => ''],
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'hide_blog_title',
            [
                'label' => esc_html__('Hide Title?', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'hide_content',
            [
                'label' => esc_html__('Hide Content?', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'content_letter_count',
            [
                'label' => esc_html__('Characters Amount in Content', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'condition' => ['hide_content' => ''],
                'min' => 1,
                'default' => '95',
            ]
        );

        $this->add_control(
            'read_more_hide',
            [
                'label' => esc_html__('Hide \'Read More\' button?', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        $this->add_control(
            'read_more_text',
            [
                'label' => esc_html__('Read More Text', 'gostudy-core'),
                'type' => Controls_Manager::TEXT,
                'condition' => ['read_more_hide' => ''],
                'dynamic' => ['active' => true],
                'default' => esc_html__('Read More', 'gostudy-core'),
            ]
        );

        $this->add_control(
            'hide_all_meta',
            [
                'label' => esc_html__('Hide all post meta?', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'meta_author',
            [
                'label' => esc_html__('Hide author?', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['hide_all_meta' => ''],
            ]
        );

        $this->add_control(
            'meta_comments',
            [
                'label' => esc_html__('Hide comments?', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['hide_all_meta' => ''],
            ]
        );

        $this->add_control(
            'meta_categories',
            [
                'label' => esc_html__('Hide post-meta categories?', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['hide_all_meta' => ''],
            ]
        );

        $this->add_control(
            'meta_date',
            [
                'label' => esc_html__('Hide post-meta date?', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['hide_all_meta' => ''],
            ]
        );

        $this->add_control(
            'hide_views',
            [
                'label' => esc_html__('Hide Views?', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'hide_likes',
            [
                'label' => esc_html__('Hide Likes?', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'hide_share',
            [
                'label' => esc_html__('Hide Shares?', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        /**
         * CONTENT -> CAROUSEL OPTIONS
         */

        $this->start_controls_section(
            'section_content_carousel',
            [
                'label' => esc_html__('Carousel Options', 'gostudy-core'),
                'condition' => ['blog_layout' => 'carousel']
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => esc_html__('Autoplay', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'gostudy-core'),
                'label_off' => esc_html__('Off', 'gostudy-core'),
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label' => esc_html__('Autoplay Speed', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'condition' => ['autoplay!' => ''],
                'min' => 1,
                'default' => '3000',
            ]
        );

        $this->add_control(
            'infinite_loop',
            [
                'label' => esc_html__('Infinite Loop', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'slides_to_scroll',
            [
                'label' => esc_html__('Slide One Item per time', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'use_pagination',
            [
                'label' => esc_html__('Add Pagination controls', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'pag_type',
            [
                'label' => esc_html__('Pagination Type', 'gostudy-core'),
                'type' => 'rt-radio-image',
                'condition' => ['use_pagination!' => ''],
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
                        'image' => RT_ELEMENTOR_ADDONS_URL . 'assets/img/rt_elementor_addon/icons/pag_line_circle.png',
                    ],
                ],
                'default' => 'circle',
            ]
        );
	
	    $this->add_responsive_control(
		    'pag_align',
		    [
			    'label' => esc_html__('Pagination Aligning', 'gostudy-core'),
			    'type' => Controls_Manager::SLIDER,
			    'condition' => ['use_pagination!' => ''],
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
                'label' => esc_html__('Top Offset', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'condition' => ['use_pagination!' => ''],
                'min' => -50,
                'max' => 150,
                'default' => -35,
                'selectors' => [
                    '{{WRAPPER}} .rt-carousel .slick-dots' => 'margin-top: {{VALUE}}px;',
                ],
            ]
        );

        $this->add_control(
            'custom_pag_color',
            [
                'label' => esc_html__('Customize Color', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['use_pagination!' => ''],
            ]
        );

        $this->add_control(
            'pag_color',
            [
                'label' => esc_html__('Pagination Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'use_pagination!' => '',
                    'custom_pag_color!' => '',
                ],
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_primary_color(),
            ]
        );

        $this->add_control(
            'use_navigation',
            [
                'label' => esc_html__('Add Navigation controls', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'custom_resp',
            [
                'label' => esc_html__('Customize Responsive', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'heading_desktop',
            [
                'label' => esc_html__('Desktop Settings', 'gostudy-core'),
                'type' => Controls_Manager::HEADING,
                'condition' => ['custom_resp' => 'yes'],
            ]
        );

        $this->add_control(
            'resp_medium',
            [
                'label' => esc_html__('Desktop Screen Breakpoint', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'condition' => ['custom_resp' => 'yes'],
                'min' => 1,
                'default' => '1025',
            ]
        );

        $this->add_control(
            'resp_medium_slides',
            [
                'label' => esc_html__('Slides to show', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'condition' => ['custom_resp' => 'yes'],
                'min' => 1,
            ]
        );

        $this->add_control(
            'heading_tablet',
            [
                'label' => esc_html__('Tablet Settings', 'gostudy-core'),
                'type' => Controls_Manager::HEADING,
                'condition' => ['custom_resp' => 'yes'],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'resp_tablets',
            [
                'label' => esc_html__('Tablet Screen Breakpoint', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'condition' => ['custom_resp' => 'yes'],
                'min' => 1,
                'default' => '800',
            ]
        );

        $this->add_control(
            'resp_tablets_slides',
            [
                'label' => esc_html__('Slides to show', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'condition' => ['custom_resp' => 'yes'],
                'min' => 1,
            ]
        );

        $this->add_control(
            'heading_mobile',
            [
                'label' => esc_html__('Mobile Settings', 'gostudy-core'),
                'type' => Controls_Manager::HEADING,
                'condition' => ['custom_resp' => 'yes'],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'resp_mobile',
            [
                'label' => esc_html__('Mobile Screen Breakpoint', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'condition' => ['custom_resp' => 'yes'],
                'min' => 1,
                'default' => '480',
            ]
        );

        $this->add_control(
            'resp_mobile_slides',
            [
                'label' => esc_html__('Slides to show', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'condition' => ['custom_resp' => 'yes'],
                'min' => 1,
            ]
        );

        $this->end_controls_section();

        /**
         * SETTINGS -> QUERY
         */

        RT_Loop_Settings::init(
            $this,
            ['post_type' => 'post']
        );

        /**
         * STYLE -> POST ITEM
         */

        $this->start_controls_section(
            'section_style_post_item',
            [
                'label' => esc_html__('Post Item', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'content_wrapper_padding',
            [
                'label' => esc_html__('Content Section Padding', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'separator' => 'after',
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .blog-post_wrapper .blog-post_content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .blog-post_wrapper .blog-post_meta-wrap' => 'padding-left: {{LEFT}}{{UNIT}};'
                                                                           . 'padding-right: {{RIGHT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'post_item',
                'selector' => '{{WRAPPER}} .blog-post_wrapper',
            ]
        );

        $this->add_control(
            'item_bg',
            [
                'label' => esc_html__('Add Item Background', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'item_bg',
                'label' => esc_html__('Background', 'gostudy-core'),
                'condition' => ['item_bg' => 'yes'],
                'types' => ['classic', 'gradient', 'video'],
                'selector' => '{{WRAPPER}} .blog-post_wrapper',
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> MODULE TITLE
         */

        $this->start_controls_section(
            'section_style_module_title',
            [
                'label' => esc_html__('Module Title', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['blog_title!' => ''],
            ]
        );

        $this->add_control(
            'heading_blog_title',
            [
                'label' => esc_html__('Title', 'gostudy-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'module_title',
                'selector' => '{{WRAPPER}} .blog_title',
            ]
        );

        $this->add_responsive_control(
            'blog_title_margin',
            [
                'label' => esc_html__('Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .blog_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'heading_blog_subtitle',
            [
                'label' => esc_html__('Subtitle', 'gostudy-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'module_subtitle',
                'selector' => '{{WRAPPER}} .blog_subtitle',
            ]
        );

        $this->add_responsive_control(
            'blog_subtitle_margin',
            [
                'label' => esc_html__('Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .blog_subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> HEADINGS
         */

        $this->start_controls_section(
            'section_style_headings',
            [
                'label' => esc_html__('Headings', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_blog_headings',
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .blog-post_title,
                               {{WRAPPER}} .blog-post_title > a',
            ]
        );

        $this->add_control(
            'heading_tag',
            [
                'label' => esc_html__('HTML tag', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => '‹h1›',
                    'h2' => '‹h2›',
                    'h3' => '‹h3›',
                    'h4' => '‹h4›',
                    'h5' => '‹h5›',
                    'h6' => '‹h6›',
                ],
                'default' => 'h3',
            ]
        );

        $this->add_responsive_control(
            'heading_margin',
            [
                'label' => esc_html__('Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .blog-post_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_headings');

        $this->start_controls_tab(
            'tab_headings_idle',
            ['label' => esc_html__('Idle', 'gostudy-core') ]
        );

        $this->add_control(
            'headings_color_idle',
            [
                'label' => esc_html__('Text Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_h_font_color(),
                'selectors' => [
                    '{{WRAPPER}} .blog-post_title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_headings_hover',
            ['label' => esc_html__('Hover', 'gostudy-core') ]
        );

        $this->add_control(
            'headings_color_hover',
            [
                'label' => esc_html__('Text Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_secondary_color(),
                'selectors' => [
                    '{{WRAPPER}} .blog-post_title a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> CONTENT
         */

        $this->start_controls_section(
            'section_style_content',
            [
                'label' => esc_html__('Content', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['hide_content' => ''],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content',
                'selector' => '{{WRAPPER}} .blog-post_text',
            ]
        );

        $this->add_responsive_control(
            'content_margin',
            [
                'label' => esc_html__('Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .blog-post_text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label' => esc_html__('Text Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_main_font_color(),
                'selectors' => [
                    '{{WRAPPER}} .blog-post_text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> META DATA
         */

        $this->start_controls_section(
            'section_style_meta_data',
            [
                'label' => esc_html__('Meta Data', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name' => 'hide_all_meta',
                            'operator' => '==',
                            'value' => ''
                        ],
                        [
                            'relation' => 'or',
                            'terms' => [
                                [
                                    'name' => 'meta_author',
                                    'operator' => '==',
                                    'value' => ''
                                ],
                                [
                                    'name' => 'meta_comments',
                                    'operator' => '==',
                                    'value' => ''
                                ],
                                [
                                    'name' => 'meta_categories',
                                    'operator' => '==',
                                    'value' => ''
                                ],
                                [
                                    'name' => 'meta_date',
                                    'operator' => '==',
                                    'value' => ''
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'meta_data',
                'selector' => '{{WRAPPER}} .blog-post_meta-wrap',
            ]
        );

        $this->add_responsive_control(
            'meta_data_margin',
            [
                'label' => esc_html__('Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .blog-post_meta-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'meta_data_padding',
            [
                'label' => esc_html__('Padding', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .blog-post_wrapper .blog-post_meta-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'meta_data',
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .blog-post_meta-wrap',
            ]
        );

        $this->start_controls_tabs(
            'tabs_meta_data',
            ['separator' => 'before']
        );

        $this->start_controls_tab(
            'tab_meta_data_idle',
            ['label' => esc_html__('Idle', 'gostudy-core') ]
        );

        $this->add_control(
            'meta_color_idle',
            [
                'label' => esc_html__('Text Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .blog-post_meta-wrap' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_meta_hover',
            ['label' => esc_html__('Hover', 'gostudy-core') ]
        );

        $this->add_control(
            'meta_color_hover',
            [
                'label' => esc_html__('Text Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .blog-post_meta-wrap a:hover,
                     {{WRAPPER}} .share_post-container:hover > a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> MEDIA
         */

        $this->start_controls_section(
            'section_style_media',
            [
                'label' => esc_html__('Media', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['hide_media' => ''],
            ]
        );

        $this->add_control(
            'media_overlay_idle',
            [
                'label' => esc_html__('Image Overlay Idle', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'selectors' => [
                    '{{WRAPPER}} .format-standard-image .image-overlay:before' => 'content: \'\'',
                    '{{WRAPPER}} .format-image .image-overlay:before' => 'content: \'\'',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'media_overlay_idle',
                'label' => esc_html__('Background', 'gostudy-core'),
                'condition' => ['media_overlay_idle!' => ''],
                'types' => ['classic', 'gradient', 'video'],
                'selector' => '{{WRAPPER}} .image-overlay:before',
            ]
        );

        $this->add_control(
            'media_overlay_hover',
            [
                'label' => esc_html__('Image Hover Overlay', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .format-standard-image .image-overlay:after' => 'content: \'\'',
                    '{{WRAPPER}} .format-image .image-overlay:after' => 'content: \'\'',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'media_overlay_hover',
                'label' => esc_html__('Background', 'gostudy-core'),
                'condition' => ['media_overlay_hover!' => ''],
                'types' => ['classic', 'gradient', 'video'],
                'default' => 'rgba(14,21,30,.6)',
                'selector' => '{{WRAPPER}} .image-overlay:after',
            ]
        );

        $this->end_controls_section();

        /**
         * STYLE -> READ MORE
         */

        $this->start_controls_section(
            'section_style_read_more',
            [
                'label' => esc_html__('Read More', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['read_more_hide' => ''],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'read_more',
                'selector' => '{{WRAPPER}} .button-read-more',
            ]
        );

        $this->add_responsive_control(
            'read_more_margin',
            [
                'label' => esc_html__('Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .read-more-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'read_more_padding',
            [
                'label' => esc_html__('Padding', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .read-more-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'tabs_read_more',
            ['separator' => 'before']
        );

        $this->start_controls_tab(
            'tab_read_more_idle',
            ['label' => esc_html__('Idle', 'gostudy-core') ]
        );

        $this->add_control(
            'read_more_color_idle',
            [
                'label' => esc_html__('Text Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .button-read-more' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'read_more_extra_idle',
            [
                'label' => esc_html__('Extra Element Background', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .button-read-more:before' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_read_more_hover',
            ['label' => esc_html__('Hover', 'gostudy-core') ]
        );

        $this->add_control(
            'read_more_color_hover',
            [
                'label' => esc_html__('Text Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .button-read-more:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'read_more_extra_hover',
            [
                'label' => esc_html__('Extra Element Background', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .button-read-more:hover:before' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .button-read-more:hover:after' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        /**
         * STYLE -> LOAD MORE
         */

        $this->start_controls_section(
            'section_style_load_more',
            [
                'label' => esc_html__('Load More', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'navigation_type' => 'load_more',
                    'blog_layout' => ['grid', 'masonry'],
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'load_more',
                'selector' => '{{WRAPPER}} .load_more_item',
            ]
        );

        $this->add_control(
            'align_load_more',
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
                    '{{WRAPPER}} .load_more_wrapper' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'load_more_margin',
            [
                'label' => esc_html__('Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => 30,
                    'right' => 0,
                    'bottom' => 50,
                    'left' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .load_more_wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'load_more_padding',
            [
                'label' => esc_html__('Padding', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .load_more_item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'tabs_load_more',
            ['separator' => 'before']
        );

        $this->start_controls_tab(
            'load_more_idle',
            ['label' => esc_html__('Idle', 'gostudy-core')]
        );

        $this->add_control(
            'load_more_color_idle',
            [
                'label' => esc_html__('Text Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .load_more_item' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'load_more_bg_idle',
            [
                'label' => esc_html__('Background Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .load_more_item' => 'background-color: {{VALUE}};',
                ],
            ]
        );

	    $this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
			    'name' => 'load_more_shadow_idle',
			    'selector' => '{{WRAPPER}} .load_more_item',
			    'fields_options' => [
				    'box_shadow' => [
					    'default' => [
						    'horizontal' => 5,
						    'vertical' => 4,
						    'blur' => 13,
						    'spread' => 0,
						    'color' => 'rgba('.\Gostudy_Theme_Helper::HexToRGB(Gostudy_Globals::get_btn_color_idle()).', 0.45)',
					    ]
				    ]
			    ]
		    ]
	    );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'load_more_hover',
            ['label' => esc_html__('Hover', 'gostudy-core')]
        );

        $this->add_control(
            'load_more_color_hover',
            [
                'label' => esc_html__('Text Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .load_more_item:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'load_more_bg_hover',
            [
                'label' => esc_html__('Background Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .load_more_item:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

	    $this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
			    'name' => 'load_more_shadow_hover',
			    'selector' => '{{WRAPPER}} .load_more_item:hover',
			    'fields_options' => [
				    'box_shadow' => [
					    'default' => [
						    'horizontal' => 5,
						    'vertical' => 4,
						    'blur' => 13,
						    'spread' => 0,
						    'color' => 'rgba('.\Gostudy_Theme_Helper::HexToRGB(Gostudy_Globals::get_btn_color_hover()).', 0.45)',
					    ]
				    ]
			    ]
		    ]
	    );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'load_more_border',
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .load_more_item',
            ]
        );

        $this->add_control(
            'load_more_radius',
            [
                'label' => esc_html__('Border Radius', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .load_more_item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        (new Blog_Template())->render($this->get_settings_for_display());
    }
}
