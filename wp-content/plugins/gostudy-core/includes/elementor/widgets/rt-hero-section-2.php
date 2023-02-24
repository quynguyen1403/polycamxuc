<?php
/*
 * This template can be overridden by copying it to yourtheme/gostudy-core/elementor/widgets/rt-hero-section.php.
*/
namespace RTAddons\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\{
    Widget_Base,
    Controls_Manager,
    Repeater,
    Icons_Manager,
    Group_Control_Border,
    Group_Control_Typography,
    Group_Control_Image_Size,
    Group_Control_Background,
    Group_Control_Box_Shadow
};
use RTAddons\{
    Gostudy_Global_Variables as Gostudy_Globals,
};

class RT_Hero_Section_2 extends Widget_Base
{
    public function get_name()
    {
        return 'rt-here-section-2';
    }

    public function get_title()
    {
        return esc_html__('Hero Section 2', 'gostudy-core');
    }

    public function get_icon()
    {
        return 'rt-hero-section';
    }

    public function get_categories()
    {
        return ['rt-extensions'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_and_position',
            [
                'label' => __('Position', 'gostudy-core'),
            ]
        );
        $this->add_responsive_control(
            'content_section_position',
            [
                'label'     => __('Content Section Position', 'gostudy-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .rt-hero-content' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'section_height',
            [
                'label'     => __('Section Height', 'gostudy-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 1500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .rt-hero-section' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'section_top_position',
            [
                'label'     => __('Section Top Position', 'gostudy-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 1500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .rt-hero-right' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'section_right_position',
            [
                'label'     => __('Section Right Position', 'gostudy-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 1500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .rt-hero-right' => 'right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Content', 'gostudy-core'),
            ]
        );
        $this->add_control(
            'title',
            [
                'label'       => __('Title', 'gostudy-core'),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => __('Build skills with courses and degrees from our courses', 'gostudy-core'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'description',
            [
                'label'     => __('Description', 'gostudy-core'),
                'type'      => Controls_Manager::TEXTAREA,
                'default'   => __('Start streaming on-demand video lectures today from top level instructors Attention heatmaps. ', 'gostudy-core'),
                'separator' =>'before',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_content_front_image',
            [
                'label' => __( 'Images', 'gostudy-core' ),
            ]
        );
        $this->add_control(
            'image_1',
            [
                'label' => __( 'Image 1', 'gostudy-core' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => plugins_url('/gostudy-core/includes/elementor/assets/img/rt_elementor_addon/img_1.png'),
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'image_1',
                'default' => 'full',
                'separator' => 'none',
            ]
        );      
        $this->add_responsive_control(
            'image_1_width',
            [
                'label'     => __('Image Width', 'gostudy-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 100,
                        'max' => 800,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .image1 img' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .image1 img' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );     
        $this->add_responsive_control(
            'image_1_position',
            [
                'label'     => __('Image Position', 'gostudy-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 1500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .image1' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        ); 
        $this->add_control(
            'image_2',
            [
                'label' => __( 'Image 2', 'gostudy-core' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => plugins_url('/gostudy-core/includes/elementor/assets/img/rt_elementor_addon/img_2.png'),
                ],
                'separator' =>'before',
            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'image_2',
                'default' => 'full',
                'separator' => 'none',
            ]
        );   
        $this->add_responsive_control(
            'image_2_width',
            [
                'label'     => __('Image Width', 'gostudy-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 10,
                        'max' => 800,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .image2 img' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .image2 img' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );    
        $this->add_responsive_control(
            'image_2_position',
            [
                'label'     => __('Image Position', 'gostudy-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 1500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .image2' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        ); 
        $this->add_control(
            'image_3',
            [
                'label' => __( 'Image 3', 'gostudy-core' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => plugins_url('/gostudy-core/includes/elementor/assets/img/rt_elementor_addon/img_3.png'),
                ],
                'separator' =>'before',
            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'image_3',
                'default' => 'full',
                'separator' => 'none',
            ]
        );        
        $this->add_responsive_control(
            'image_3_width',
            [
                'label'     => __('Image Width', 'gostudy-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 10,
                        'max' => 800,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .image3 img' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .image3 img' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        ); 
        $this->add_responsive_control(
            'image_3_position',
            [
                'label'     => __('Image Position', 'gostudy-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 1500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .image3' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        ); 
        $this->end_controls_section();

        $this->start_controls_section(
            'section_search',
            [
                'label' => __( 'Search', 'gostudy-core' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'search_type',
            [
                'label'   => __('Search Type', 'gostudy-core'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'rt_wp_search',
                'options' => [
                    'rt_wp_search'    => __('WordPress Search', 'gostudy-core'),
                    'rt_tutor_search' => __('Tutor Search', 'gostudy-core'),
                    'rt_lp_search'    => __('LearnPress Search', 'gostudy-core'),
                    'rt_ld_search'    => __('LearnDash Search', 'gostudy-core'),
                ],
            ]
        );
        $this->add_control(
            'search_btn_text',
            [
                'label'       => __('Button Text', 'gostudy-core'),
                'type'        => Controls_Manager::TEXT,
                'default'     => '',
                'label_block' => true,
            ]
        );

        $this->add_control(
            'search_placeholder',
            [
                'label'       => __('Placeholder', 'gostudy-core'),
                'type'        => Controls_Manager::TEXT,
                'default'     => 'What do you want to learn?',
                'label_block' => true,
            ]
        );
        $this->end_controls_section();
 
        /*-----------------------------------------------------------------------------------*/
        /*  CONTENT -> GENERAL
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_content_general',
            ['label' => esc_html__('Icon Text', 'gostudy-core')]
        );

        $this->add_control(
            'view',
            [
                'label' => esc_html__('Layout', 'gostudy-core'),
                'type' => Controls_Manager::HIDDEN,
                'label_block' => false,
                'classes' => 'elementor-control-start-end',
                'default' => 'inline',
                'prefix_class' => 'elementor-icon-list--layout-',
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'text',
            [
                'label' => esc_html__('Text', 'gostudy-core'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'dynamic' => ['active' => true],
                'placeholder' => esc_attr__('List Item', 'gostudy-core'),
                'default' => esc_html__('List Item', 'gostudy-core'),
            ]
        );

        $repeater->add_control(
            'selected_icon_fontawesome',
            [
                'label' => esc_html__('Icon', 'gostudy-core'),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'label_block' => true,
                'default' => [
                    'value' => 'fab fa-wordpress',
                    'library' => 'fa-brands',
                ],
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label' => esc_html__('Link', 'gostudy-core'),
                'type' => Controls_Manager::URL,
                'dynamic' => ['active' => true],
                'label_block' => true,
                'placeholder' => esc_attr__('https://your-link.com', 'gostudy-core'),
            ]
        );

        $this->add_control(
            'icon_list',
            [
                'label' => '',
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    ['text' => esc_html__('List Item #1', 'gostudy-core')],
                    ['text' => esc_html__('List Item #2', 'gostudy-core')],
                    ['text' => esc_html__('List Item #3', 'gostudy-core')],
                ],
                'title_field' => '{{{ text }}}',
            ]
        );
        $this->end_controls_section();

        // === Style sections start ====
         $this->start_controls_section(
            'style_section',
            [
                'label' => __('Style', 'gostudy-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'section_background',
                'label' => __( 'Background', 'gostudy-core' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .footer-app, .home2-hero, .home6-hero',
            ]
        );
        $this->add_responsive_control(
            'image_setion_padding',
            [
                'label'      => __('Image Section Padding', 'gostudy-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .rt-hero-right' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'before',
            ]
        );
        $this->add_responsive_control(
            'image_setion_margin',
            [
                'label'      => __('Image Section Margin', 'gostudy-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .rt-hero-right' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'before',
            ]
        );
         $this->end_controls_section();

         $this->start_controls_section(
            'title_style_section',
            [
                'label' => __('Title', 'gostudy-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'label'    => __('Title Typography', 'gostudy-core'),
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .rt-hero-content h1, .home2-hero-title h1, .home3-hero-title h1, .home4-hero-title h1, .hero-5-text h1, .home6-rt-hero-content h1',
            ]
        );
        $this->add_control(
            'title_color',
            [
                'label'     => __('Title Color', 'gostudy-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}}  .rt-hero-content .title' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'underline_active',
            [
                'label' => esc_html__('Underline', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );
        $this->add_control(
            'underline_color',
            [
                'label'     => __('Underline Color', 'gostudy-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}}  .rt-hero-content .underline-active' => 'text-decoration-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // ==== Content Style Section ====

        $this->start_controls_section(
            'content_style_section',
            [
                'label' => __('Content', 'gostudy-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'content_typography',
                'label'    => __('Content Typography', 'gostudy-core'),
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_TEXT,
                ],
                'selector' => '{{WRAPPER}} .rt-hero-content p',
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label'      => __('Padding', 'gostudy-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .rt-hero-content p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'before',
            ]
        );

        $this->end_controls_section();

        // Search style
        $this->start_controls_section(
            'section_search_style',
            [
                'label' => __( 'Search', 'gostudy-core' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'search_margin',
            [
                'label' => esc_html__('Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => 00,
                    'left' => 0,
                    'right' => 0,
                    'bottom' => 40,
                ],
                'selectors' => [
                    '{{WRAPPER}} .rt-course-form-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'search_align',
            [
                'label' => __( 'Alignment', 'rt' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'rt' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'none' => [
                        'title' => __( 'Center', 'rt' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'rt' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .rt-courses-searching.rt-searching' => 'float: {{VALUE}};',
                ],
                'default' => 'center',
                'separator' =>'before',
            ]
        );
        $this->add_responsive_control(
            'froms_width',
            [
                'label'  => __( 'Width', 'gostudy-core' ),
                'type'   => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 150,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 450,
                ],
                'selectors' => [
                    '{{WRAPPER}} .rt-course-form-wrapper input[type="text"], .rt-courses-searching.rt-searching' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );        
        $this->add_responsive_control(
            'froms_height',
            [
                'label'  => __( 'Height', 'gostudy-core' ),
                'type'   => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 50,
                ],
                'range'  => [
                    'px' => [
                        'min' => 42,
                        'max' => 120,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} form.rt-course-form-wrapper' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'froms_submit_width',
            [
                'label'  => __( 'Submit Button Width', 'gostudy-core' ),
                'type'   => Controls_Manager::SLIDER,
                'range'  => [
                    'px' => [
                        'min' => 10,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .rt-course-form-wrapper .rt-course-btn' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'froms_border_radious',
            [
                'label'  => __( 'Border Radius', 'gostudy-core' ),
                'type'   => Controls_Manager::SLIDER,
                'range'  => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .rt-courses-searching' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'input_color',
            [
                'label'     => __( 'Input Text', 'gostudy-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-course-form-wrapper .rt-course-input' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'input_border_color',
            [
                'label'     => __( 'Input Border', 'gostudy-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-course-form-wrapper .rt-course-input' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'input_bg_color',
            [
                'label'     => __( 'Input Background', 'gostudy-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-course-form-wrapper .rt-course-input' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'btn_bg_color',
            [
                'label'     => __( 'Submit Background', 'gostudy-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-course-form-wrapper .rt-course-btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'btn_bg_hover_color',
            [
                'label'     => __( 'Submit Background Hover', 'gostudy-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-course-form-wrapper .rt-course-btn:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'btn_border_color',
            [
                'label'     => __( 'Submit Border', 'gostudy-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-course-form-wrapper .rt-course-btn' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'submit_typography',
                'label'    => __( 'Submit Typography', 'gostudy-core' ),
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_ACCENT,
                ],
                'selector' => '{{WRAPPER}} .rt-course-form-wrapper .rt-course-btn',
            ]
        );
        
        $this->add_control(
            'input_placholder_color',
            [
                'label'     => __( 'Placeholder', 'gostudy-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-course-form-wrapper input::placeholder' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'btn_text_color',
            [
                'label'     => __( 'Submit Text', 'gostudy-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-course-form-wrapper .rt-course-btn' => 'color: {{VALUE}};',

                ],
            ]
        );

        $this->add_control(
            'btn_text_hover_color',
            [
                'label'     => __( 'Submit Text Hover', 'gostudy-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-course-form-wrapper .rt-course-btn:hover' => 'color: {{VALUE}};',

                ],
            ]
        );
        $this->end_controls_section();


 /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> LIST
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_list',
            [
                'label' => esc_html__('Icon Text', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'space_between',
            [
                'label' => esc_html__('Gap Items', 'gostudy-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['max' => 200],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-items.elementor-inline-items .elementor-icon-list-item' => 'margin-right: calc({{SIZE}}{{UNIT}}/2); margin-left: calc({{SIZE}}{{UNIT}}/2)',
                    '{{WRAPPER}} .elementor-icon-list-items.elementor-inline-items' => 'margin-right: calc(-{{SIZE}}{{UNIT}}/2); margin-left: calc(-{{SIZE}}{{UNIT}}/2)',
                    'body.rtl {{WRAPPER}} .elementor-icon-list-items.elementor-inline-items .elementor-icon-list-item:after' => 'left: calc(-{{SIZE}}{{UNIT}}/2)',
                    'body:not(.rtl) {{WRAPPER}} .elementor-icon-list-items.elementor-inline-items .elementor-icon-list-item:after' => 'right: calc(-{{SIZE}}{{UNIT}}/2)',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_align',
            [
                'label' => esc_html__('Alignment', 'gostudy-core'),
                'type' => Controls_Manager::CHOOSE,
                'toggle' => false,
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
                'prefix_class' => 'elementor%s-align-',
            ]
        );

        $this->add_control(
            'divider',
            [
                'label' => esc_html__('Divider', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'separator' => 'before',
                'label_off' => esc_html__('Off', 'gostudy-core'),
                'label_on' => esc_html__('On', 'gostudy-core'),
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-item:not(:last-child):after' => 'content: \'\'',
                ],
            ]
        );

        $this->add_control(
            'divider_style',
            [
                'label' => esc_html__('Style', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => ['divider' => 'yes'],
                'options' => [
                    'solid' => esc_html__('Solid', 'gostudy-core'),
                    'double' => esc_html__('Double', 'gostudy-core'),
                    'dotted' => esc_html__('Dotted', 'gostudy-core'),
                    'dashed' => esc_html__('Dashed', 'gostudy-core'),
                ],
                'default' => 'solid',
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-items.elementor-inline-items .elementor-icon-list-item:not(:last-child):after' => 'border-left-style: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'divider_weight',
            [
                'label' => esc_html__('Weight', 'gostudy-core'),
                'type' => Controls_Manager::SLIDER,
                'condition' => ['divider' => 'yes'],
                'range' => [
                    'px' => ['min' => 1, 'max' => 20],
                ],
                'default' => ['size' => 1],
                'selectors' => [
                    '{{WRAPPER}} .elementor-inline-items .elementor-icon-list-item:not(:last-child):after' => 'border-left-width: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'divider_height',
            [
                'label' => esc_html__('Height', 'gostudy-core'),
                'type' => Controls_Manager::SLIDER,
                'condition' => ['divider' => 'yes'],
                'size_units' => ['%', 'px'],
                'range' => [
                    'px' => ['min' => 1, 'max' => 100],
                    '%' => ['min' => 1, 'max' => 100],
                ],
                'default' => ['unit' => '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-item:not(:last-child):after' => 'height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'divider_color',
            [
                'label' => esc_html__('Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'condition' => ['divider' => 'yes'],
                'dynamic' => ['active' => true],
                'default' => '#ddd',
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-item:not(:last-child):after' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_icon');

        $this->start_controls_tab(
            'tab_icon_idle',
            ['label' => esc_html__('Idle', 'gostudy-core')]
        );

        $this->add_control(
            'icon_color_idle',
            [
                'label' => esc_html__('Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-icon-list-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_stacked_color',
            [
                'label' => esc_html__('Stacked Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => '#cfe9e0',
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-icon i' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_icon_hover',
            ['label' => esc_html__('Hover', 'gostudy-core')]
        );

        $this->add_control(
            'icon_color_hover',
            [
                'label' => esc_html__('Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_secondary_color(),
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-item:hover .elementor-icon-list-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-icon-list-item:hover .elementor-icon-list-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Size', 'gostudy-core'),
                'type' => Controls_Manager::SLIDER,
                'separator' => 'before',
                'range' => [
                    'px' => ['min' => 6, 'max' => 60],
                ],
                'default' => ['size' => 14],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-icon-list-icon svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_spacing',
            [
                'label' => esc_html__('Gap Icons', 'gostudy-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => ['min' => 0, 'max' => 100],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-icon' => is_rtl() ? 'margin-left:' : 'margin-right:' . ' {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'icon_typography',
                'selector' => '{{WRAPPER}} .elementor-icon-list-item',
            ]
        );

        $this->start_controls_tabs('text_color_tabs');

        $this->start_controls_tab(
            'tab_text_idle',
            ['label' => esc_html__('Idle', 'gostudy-core')]
        );

        $this->add_control(
            'text_color_idle',
            [
                'label' => esc_html__('Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_text_hover',
            ['label' => esc_html__('Hover', 'gostudy-core')]
        );

        $this->add_control(
            'text_color_hover',
            [
                'label' => esc_html__('Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-item:hover .elementor-icon-list-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_control(
            'text_indent',
            [
                'label' => esc_html__('Text Indent', 'gostudy-core'),
                'type' => Controls_Manager::SLIDER,
                'separator' => 'before',
                'range' => [
                    'px' => ['max' => 50],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-text' => is_rtl() ? 'padding-right: {{SIZE}}{{UNIT}};' : 'padding-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    } // End options

    protected function render( $instance = [] ) {

    $settings = $this->get_settings_for_display();

    $fallback_defaults = [
        'fa fa-check',
        'fa fa-times',
        'fa fa-dot-circle-o',
    ];

    $this->add_render_attribute([
        'icon_list' => [
            'class' => [
                'rt-header-list-info',
                'elementor-icon-list-items',
                'elementor-inline-items',
                'rt-hero-section-list-icon',
            ],
        ],
        'list_item' => [
            'class' => [
                'elementor-icon-list-item',
                'elementor-inline-item'
            ],
        ],
    ]);
    ?>



    <section class="rt-hero-section">

        <div class="container">
            <div class="col-lg-6">

                <div class="rt-hero-content">
                     <?php if ($settings['title']): ?>
                        <h1 class="title <?php if($settings['underline_active']) : echo esc_attr('underline-active'); endif; ?>"><?php echo $settings['title'] ?></h1>
                     <?php endif;?>

                     <?php if ($settings['description']): ?>
                        <p><?php echo $settings['description'] ?></p>
                     <?php endif;?>


                <div class="rt-courses-searching rt-searching">

                    <?php if ($settings['search_type'] == 'rt_wp_search'): ?>

                        <form class="rt-course-form-wrapper" action="<?php echo esc_html(home_url('/')); ?>" method="get">
                            <input class="rt-course-input" placeholder="<?php echo $settings['search_placeholder']; ?>" type="text" name="s" value="<?php the_search_query();?>" />
                             <button class="rt-course-btn" type="submit"><?php if ($settings['search_btn_text']): echo $settings['search_btn_text'];else: ?> <i class="fa fa-search"></i><?php endif;?></button>
                            <span class="widget-search-close"></span>
                        </form>

                    <?php elseif ($settings['search_type'] == 'rt_tutor_search'): ?>

                        <?php if (function_exists('tutor')): ?>
                            <form class="rt-course-form-wrapper" method="get" action="<?php echo esc_url(get_post_type_archive_link(tutor()->course_post_type)); ?>">

                                <input type="text" value="" name="s" placeholder="<?php echo $settings['search_placeholder']; ?>" class="rt-course-input" autocomplete="off" />
                                <input type="hidden" value="course" name="ref" />
                                <button class="rt-course-btn" type="submit"><?php if ($settings['search_btn_text']): echo $settings['search_btn_text'];else: ?> <i class="fa fa-search"></i><?php endif;?></button>
                                <span class="widget-search-close"></span>

                            </form>

                        <?php else: ?>
                            <p class="none-massage"><?php echo esc_html__('Tutor LMS plugin not install', 'rt'); ?></p>
                        <?php endif;?>

                    <?php elseif ($settings['search_type'] == 'rt_lp_search'): ?>

                        <?php if (class_exists('LearnPress')): ?>
                        <form class="rt-course-form-wrapper" method="get" action="<?php echo esc_url(get_post_type_archive_link('lp_course')); ?>">

                            <input type="text" value="" name="s" placeholder="<?php echo $settings['placeholder']; ?>" class="rt-course-input" autocomplete="off" />
                            <input type="hidden" value="course" name="ref" />
                            <button class="rt-course-btn" type="submit"><?php if ($settings['btn_text']): echo $settings['btn_text'];else: ?> <i class="fa fa-search"></i><?php endif;?></button>
                            <span class="widget-search-close"></span>

                        </form>

                        <?php else: ?>
                            <p class="none-massage"><?php echo esc_html__('LearnPress LMS plugin not install', 'rt'); ?></p>
                        <?php endif;?>

                    <?php elseif ($settings['search_type'] == 'rt_ld_search'): ?>

                        <?php if (class_exists('SFWD_LMS')): ?>
                        <form class="rt-course-form-wrapper" method="get" action="<?php echo esc_url(get_post_type_archive_link('sfwd-courses')); ?>">

                            <input type="text" value="" name="s" placeholder="<?php echo $settings['search_placeholder']; ?>" class="rt-course-input" autocomplete="off" />
                            <input type="hidden" value="course" name="ref" />
                            <button class="rt-course-btn" type="submit"><?php if ($settings['search_btn_text']): echo $settings['search_btn_text'];else: ?> <i class="fa fa-search"></i><?php endif;?></button>
                            <span class="widget-search-close"></span>
                        </form>

                        <?php else: ?>
                            <p class="none-massage"><?php echo esc_html__('LearnDash LMS plugin not install', 'rt'); ?></p>
                        <?php endif;?>

                    <?php endif;?> <!-- //End LMS Search -->

                </div>

                <?php 
                echo '<ul ', $this->get_render_attribute_string('icon_list'), '>';
                    foreach ($settings['icon_list'] as $index => $item) :
                        $repeater_setting_key = $this->get_repeater_setting_key('text', 'icon_list', $index);

                        $this->add_render_attribute($repeater_setting_key, 'class', 'rt-header-list-text elementor-icon-list-text');

                        $this->add_inline_editing_attributes($repeater_setting_key);
                        $migration_allowed = Icons_Manager::is_migration_allowed();

                        echo '<li class="elementor-icon-list-item" >';
                        if (!empty($item['link']['url'])) {
                            $link_key = 'link_' . $index;

                            $this->add_link_attributes($link_key, $item['link']);

                            echo '<a ', $this->get_render_attribute_string($link_key), '>';
                        }

                        // add old default
                        if (!isset($item['icon']) && !$migration_allowed) {
                            $item['icon'] = $fallback_defaults[$index] ?? 'fa fa-check';
                        }

                        $migrated = isset($item['__fa4_migrated']['selected_icon_fontawesome']);
                        $is_new = !isset($item['icon']) && $migration_allowed;

                        if (
                            !empty($item['icon'])
                            || (!empty($item['selected_icon_fontawesome']['value']) && $is_new)
                        ) {
                            echo '<span class="rt-header-list-icon elementor-icon-list-icon">';
                            if ($is_new || $migrated) {
                                Icons_Manager::render_icon($item['selected_icon_fontawesome'], ['aria-hidden' => 'true']);
                            } else {
                                echo '<i class="', esc_attr($item['icon']), '" aria-hidden="true"></i>';
                            }
                            echo '</span>';
                        }

                        echo '<span ', $this->get_render_attribute_string($repeater_setting_key), '>',
                            $item['text'],
                            '</span>';

                        if (!empty($item['link']['url'])) {
                            echo '</a>';
                        }

                        echo '</li>';
                    endforeach;

                    echo '</ul>';
                ?>
                </div>

            </div>
            <div class="rt-hero-right">

                <div class="rt-hero-right-animate ">
                    <div class="image1">
                         <?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'image_1_size', 'image_1' );?>
                    </div>
                    <div class="image2 parallaxed">
                        <?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'image_2_size', 'image_2' ); ?>
                    </div>
                    <div class="image3 parallaxed">
                        <?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'image_3_size', 'image_3' ); ?>
                    </div>

                </div>

            </div>
        </div>
    </section>
<?php

    }

}

