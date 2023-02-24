<?php
/*
 * This template can be overridden by copying it to yourtheme/gostudy-core/elementor/widgets/rt-info-box.php.
*/
namespace RTAddons\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\{Widget_Base, Controls_Manager};
use Elementor\{Group_Control_Typography, Group_Control_Background, Group_Control_Box_Shadow};
use RTAddons\Gostudy_Global_Variables as Gostudy_Globals;
use RTAddons\Includes\{RT_Loop_Settings};
use RTAddons\Templates\RT_Courses_LearnDash;
use RTAddons\Templates\RT_Courses_LearnDash_2;
use RTAddons\Templates\RT_Courses_LearnDash_3;

class RT_Courses_LD extends Widget_Base
{
    public function get_name()
    {
        return 'rt-courses-ld';
    }

    public function get_title()
    {
        return esc_html__('LearnDash Courses', 'gostudy-core');
    }

    public function get_icon()
    {
        return 'rt-courses-ld';
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
            'section_content_general',
            [ 'label' => esc_html__('General', 'gostudy-core') ]
        );

        $this->add_control(
            'course_layout',
            [
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
            'layout',
            [
                'label' => esc_html__('Layout', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '1' => esc_html__('Layout 1', 'gostudy-core'),
                    '2' => esc_html__('Layout 2', 'gostudy-core'),
                    '3' => esc_html__('Layout 3', 'gostudy-core'),
                ],
                'default' => '1',
            ]
        );   

        $this->add_control(
            'grid_columns',
            [
                'label' => esc_html__('Grid Columns Amount', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '1' => esc_html__('1 / One', 'gostudy-core'),
                    '2' => esc_html__('2 / Two', 'gostudy-core'),
                    '3' => esc_html__('3 / Three', 'gostudy-core'),
                    '4' => esc_html__('4 / Four', 'gostudy-core'),
                    '5' => esc_html__('5 / Five', 'gostudy-core'),
                ],
                'default' => '3',
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
                    '740x540' => '740x540', // 3col
                    'full' => 'Full',
                    'custom' => 'Custom',
                ],
                'default' => '740x540', // 3col
            ]
        );

        $this->add_control(
            'img_size_array',
            [
                'label' => esc_html__('Image Dimension', 'gostudy-core'),
                'type' => Controls_Manager::IMAGE_DIMENSIONS,
                'description' => esc_html__('You can crop the original image size to any custom size. You can also set a single value for height or width in order to keep the original size ratio.', 'gostudy-core'),
                'condition' => [
                    'img_size_string' => 'custom',
                ],
                'default' => [
                    'width' => '740',
                    'height' => '540',
                ]
            ]
        );

        $this->add_control(
            'img_aspect_ratio',
            [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Image Aspect Ratio', 'gostudy-core'),
                'options' => [
                    '1:1' => '1:1',
                    '3:2' => '3:2',
                    '4:3' => '4:3',
                    '6:5' => '6:5',
                    '9:16' => '9:16',
                    '16:9' => '16:9',
                    '21:9' => '21:9',
                    '' => 'Not Crop',
                ],
                'default' => '',
            ]
        );

        $this->add_control(
            'isotope_filter',
            [
                'label' => esc_html__('Use Filter?', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => [ 'course_layout!' => 'carousel' ],
            ]
        );

        $this->add_control(
            'pagination',
            [
                'label' => esc_html__('Add Pagination', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [ 'course_layout!' => 'carousel' ],
            ]
        );

        $this->add_control(
            'single_link_image',
            [
                'label' => esc_html__('Add Link on Image', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => [ 'hide_media!' => 'yes' ],
            ]
        );

        $this->add_control(
            'single_link_title',
            [
                'label' => esc_html__('Add Link on Title', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => [ 'hide_title!' => 'yes' ],
            ]
        );

        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  CONTENT -> APPEARANCE
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_content_appearance',
            [ 'label' => esc_html__('Appearance', 'gostudy-core') ]
        );

        $this->add_control(
            'hide_media',
            [
                'label' => esc_html__('Hide Media', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'hide_tax',
            [
                'label' => esc_html__('Hide Categories', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'hide_price',
            [
                'label' => esc_html__('Hide Price', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'hide_title',
            [
                'label' => esc_html__('Hide Title', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'hide_instructor',
            [
                'label' => esc_html__('Hide Instructor', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'hide_lessons',
            [
                'label' => esc_html__('Hide Lessons', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );
        $this->add_control(
            'hide_lessons_text',
            [
                'label' => esc_html__('Hide Lessons Text', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [ 'hide_lessons!' => 'yes' ],
            ]
        );
        $this->add_control(
            'lesson_text',
            [
                'label'   => __( 'Custom Lessons Text', 'gostudy-core' ),
                'type'    => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => __('Lesson','gostudy-core'),
                'condition' => [ 'hide_lessons!' => 'yes' ],

            ]    
        );
        $this->add_control(
            'lessons_text',
            [
                'label'   => __( 'Custom Lessons Text', 'gostudy-core' ),
                'type'    => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => __('Lessons','gostudy-core'),
                'condition' => [ 'hide_lessons!' => 'yes' ],
            ]    
        );
        $this->add_control(
            'hide_topic',
            [
                'label' => esc_html__('Hide Topic', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );
        $this->add_control(
            'hide_topic_text',
            [
                'label' => esc_html__('Hide Topic Text', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [ 'hide_topic!' => 'yes' ],
            ]
        );
        $this->add_control(
            'topic_text',
            [
                'label'   => __( 'Custom Topic Text', 'gostudy-core' ),
                'type'    => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => __('Topic','gostudy-core'),
                'condition' => [ 'hide_topic!' => 'yes' ],

            ]    
        );
        $this->add_control(
            'topics_text',
            [
                'label'   => __( 'Custom Topics Text', 'gostudy-core' ),
                'type'    => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => __('Topics','gostudy-core'),
                'condition' => [ 'hide_topic!' => 'yes' ],
            ]    
        );
        // $this->add_control(
        //     'hide_quiz',
        //     [
        //         'label' => esc_html__('Hide Quiz', 'gostudy-core'),
        //         'type' => Controls_Manager::SWITCHER,
        //         'default' => 'yes',
        //     ]
        // );
        // $this->add_control(
        //     'hide_quiz_text',
        //     [
        //         'label' => esc_html__('Hide Quiz Text', 'gostudy-core'),
        //         'type' => Controls_Manager::SWITCHER,
        //         'condition' => [ 'hide_quiz!' => 'yes' ],
        //     ]
        // );
        // $this->add_control(
        //     'quiz_text',
        //     [
        //         'label'   => __( 'Custom Quiz Text', 'gostudy-core' ),
        //         'type'    => Controls_Manager::TEXT,
        //         'label_block' => true,
        //         'default' => __('Quiz','gostudy-core'),
        //         'condition' => [ 'hide_quiz!' => 'yes' ],

        //     ]    
        // );
        // $this->add_control(
        //     'quizzes_text',
        //     [
        //         'label'   => __( 'Custom Quizzes Text', 'gostudy-core' ),
        //         'type'    => Controls_Manager::TEXT,
        //         'label_block' => true,
        //         'default' => __('Quizzes','gostudy-core'),
        //         'condition' => [ 'hide_quiz!' => 'yes' ],
        //     ]    
        // );
        $this->add_control(
            'hide_enroll',
            [
                'label' => esc_html__('Hide Enroll', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                // 'default' => 'yes',
            ]
        );

        $this->add_control(
            'enroll_now_text',
            [
                'label'   => __( 'Enroll Now', 'gostudy-core' ),
                'type'    => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => __('Enroll Now','gostudy-core'),

            ]    
        );
        $this->add_control(
            'hide_enroll_now_text',
            [
                'label' => esc_html__('See More/Arrow Icon', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'hide_excerpt',
            [
                'label' => esc_html__('Hide Excerpt/Content', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'excerpt_chars',
            [
                'label' => esc_html__('Limit the Excerpt/Content letters', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'condition' => [ 'hide_excerpt!' => 'yes' ],
                'min' => 1,
                'default' => '100',
            ]
        );

        $this->add_control(
            'enrolled_text',
            [
                'label'   => __( 'Enrolled Text', 'gostudy-core' ),
                'type'    => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => __('Enrolled','gostudy-core'),

            ]    
        );
        $this->add_control(
            'completed_text',
            [
                'label'   => __( 'completed Text', 'gostudy-core' ),
                'type'    => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => __('Completed','gostudy-core'),

            ]    
        );
        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  CONTENT -> CAROUSEL OPTIONS
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_content_carousel',
            [
                'label' => esc_html__('Carousel Options', 'gostudy-core'),
                'condition' => ['course_layout' => 'carousel']
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
            'infinity_on_the_right',
            [
                'label' => esc_html__('Infinity on the Right', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'gostudy-core'),
                'label_off' => esc_html__('Off', 'gostudy-core'),
                'prefix_class' => 'infinity_',
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
            'slide_single',
            [
                'label' => esc_html__('Slide One Item per time', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'pag_divider_before',
            [
                'type' => Controls_Manager::DIVIDER,
                'condition' => ['use_pagination!' => ''],
            ]
        );

        $this->add_control(
            'use_pagination',
            [
                'label' => esc_html__('Add Pagination controls', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
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
                'default' => 'line_circle',
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
                'default' => gostudy_Globals::get_primary_color(),
            ]
        );

        $this->add_control(
            'pag_divider_after',
            [
                'type' => Controls_Manager::DIVIDER,
                'condition' => ['use_pagination!' => ''],
            ]
        );

        $this->add_control(
            'use_navigation',
            [
                'label' => esc_html__('Add Navigation controls', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'resp_divider',
            [
                'type' => Controls_Manager::DIVIDER,
                'condition' => ['custom_resp!' => ''],
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
                'condition' => ['custom_resp!' => ''],
            ]
        );

        $this->add_control(
            'resp_medium',
            [
                'label' => esc_html__('Desktop Screen Breakpoint', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'condition' => ['custom_resp!' => ''],
                'min' => 1,
                'default' => '1025',
            ]
        );

        $this->add_control(
            'resp_medium_slides',
            [
                'label' => esc_html__('Slides to show', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'condition' => ['custom_resp!' => ''],
                'min' => 1,
            ]
        );

        $this->add_control(
            'heading_tablet',
            [
                'label' => esc_html__('Tablet Settings', 'gostudy-core'),
                'type' => Controls_Manager::HEADING,
                'condition' => ['custom_resp!' => ''],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'resp_tablets',
            [
                'label' => esc_html__('Tablet Screen Breakpoint', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'condition' => ['custom_resp!' => ''],
                'min' => 1,
                'default' => '800',
            ]
        );

        $this->add_control(
            'resp_tablets_slides',
            [
                'label' => esc_html__('Slides to show', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'condition' => ['custom_resp!' => ''],
                'min' => 1,
            ]
        );

        $this->add_control(
            'heading_mobile',
            [
                'label' => esc_html__('Mobile Settings', 'gostudy-core'),
                'type' => Controls_Manager::HEADING,
                'condition' => ['custom_resp!' => ''],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'resp_mobile',
            [
                'label' => esc_html__('Mobile Screen Breakpoint', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'condition' => ['custom_resp!' => ''],
                'min' => 1,
                'default' => '480',
            ]
        );

        $this->add_control(
            'resp_mobile_slides',
            [
                'label' => esc_html__('Slides to show', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'condition' => ['custom_resp!' => ''],
                'min' => 1,
            ]
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  SETTINGS -> QUERY
        /*-----------------------------------------------------------------------------------*/

        RT_Loop_Settings::init(
            $this,
            [
                'post_type' => 'sfwd-courses',
                'hide_cats' => true,
                'hide_tags' => true
            ]
        );

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> GENERAL
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_item',
            [
                'label' => esc_html__('General', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'item_content_padding',
            [
                'label' => esc_html__('Content Padding', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '0',
                    'right' => '30',
                    'bottom' => '20',
                    'left' => '30',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .course__content--info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_meta_padding',
            [
                'label' => esc_html__('Meta Padding', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '10',
                    'right' => '30',
                    'bottom' => '10',
                    'left' => '30',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .course__content--meta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'bg_content_color_idle',
            [
                'label' => esc_html__('Background Content Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .course__container' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
   /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> Filter
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_filter',
            [
                'label' => esc_html__('Filter', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'filter_title_align',
            [
                'label' => __( 'Alignment', 'gostudy-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'gostudy-core' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'gostudy-core' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'gostudy-core' ),
                        'icon' => 'fa fa-align-right',
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .course__filter, .rt-courses .course__filter' => 'text-align: {{VALUE}};',
                ],
                'default' => 'center',
            ]
        );
        $this->add_responsive_control(
            'filter_position',
            [
                'label' => __( 'Position', 'gostudy-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -150,
                        'max' => 150,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .course__filter, .rt-courses .course__filter' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'filter_padding',
            [
                'label' => esc_html__('Padding', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .course__filter, .rt-courses .course__filter' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'filter_margin',
            [
                'label' => esc_html__('Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .course__filter, .rt-courses .course__filter' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

         $this->end_controls_section();
        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> TITLE
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_title',
            [
                'label' => esc_html__('Heading', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['hide_title' => ''],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_title',
                'separator' => 'before',
                'selector' => '{{WRAPPER}} .course__title,
                                {{WRAPPER}} .course__title > a',
            ]
        );

        $this->add_control(
            'title_tag',
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
                'default' => 'h4',
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .course__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_title');

        $this->start_controls_tab(
            'tab_title_idle',
            ['label' => esc_html__('Idle', 'gostudy-core') ]
        );

        $this->add_control(
            'title_color_idle',
            [
                'label' => esc_html__('Text Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_h_font_color(),
                'selectors' => [
                    '{{WRAPPER}} .course__title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_title_hover',
            ['label' => esc_html__('Hover', 'gostudy-core') ]
        );

        $this->add_control(
            'title_color_hover',
            [
                'label' => esc_html__('Text Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .course__title:hover' => 'color: {{VALUE}};',
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
                'condition' => ['hide_excerpt' => ''],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content',
                'selector' => '{{WRAPPER}} .course__excerpt',
            ]
        );

        $this->add_responsive_control(
            'content_margin',
            [
                'label' => esc_html__('Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .course__excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .course__excerpt' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> META
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_meta',
            [
                'label' => esc_html__('Meta Data', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'meta',
                'selector' => '{{WRAPPER}} .rt-courses .course__content--meta > span',
            ]
        );

        $this->add_control(
            'meta_color',
            [
                'label' => esc_html__('Text Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_main_font_color(),
                'selectors' => [
                    '{{WRAPPER}} .rt-courses .course__content--meta > span' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'meta_icon_color',
            [
                'label' => esc_html__('Icon Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .rt-courses .course__content--meta > span:before,
                    {{WRAPPER}} .rt-courses .course__content--meta .course-wishlist:before' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> PRICE
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_price',
            [
                'label' => esc_html__('Price', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['hide_price' => '', 'hide_media' => ''],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'price',
                'selector' => '{{WRAPPER}} .rt-courses .course-price',
            ]
        );

        $this->add_responsive_control(
            'item_price_padding',
            [
                'label' => esc_html__('Price Padding', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .rt-courses .course-price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_price_margin',
            [
                'label' => esc_html__('Price Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .rt-courses .course-price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'price_color',
            [
                'label' => esc_html__('Text Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .rt-courses .course-price' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'price_bg_color',
            [
                'label' => esc_html__('Background Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .rt-courses .course-price' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }


    protected function render()
    {
        $atts = $this->get_settings_for_display();

          if (class_exists('SFWD_LMS')) {
                if ($atts['layout'] == '3') {
                   $courses = new RT_Courses_LearnDash_3();
                   echo $courses->render($atts, $this);
                }
                elseif ($atts['layout'] == '2') {
                   $courses = new RT_Courses_LearnDash_2();
                   echo $courses->render($atts, $this);
                } else {
                   $courses = new RT_Courses_LearnDash();
                   echo $courses->render($atts, $this);
                }
          
            }
    }

}
