<?php
/*
 * This template can be overridden by copying it to yourtheme/gostudy-core/elementor/widgets/rt-feedback.php.
*/
namespace RTAddons\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\{Widget_Base, Controls_Manager, Control_Media};
use Elementor\{Group_Control_Border, Group_Control_Box_Shadow, Group_Control_Background, Group_Control_Image_Size, Group_Control_Typography};
use Elementor\{Repeater, Utils};
use RTAddons\Gostudy_Global_Variables as Gostudy_Globals;
use RTAddons\Includes\{RT_Feedback_Settings, RT_Elementor_Helper};

class RT_Feedback extends Widget_Base
{
    public function get_name() {
        return 'rt-testimonial';
    }

    public function get_title() {
        return esc_html__('Testimonials', 'gostudy-core');
    }

    public function get_icon() {
        return 'rt-feedback';
    }

    public function get_script_depends() {
        return [ 'slick' ];
    }

    public function get_categories() {
        return [ 'rt-extensions' ];
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
            'testi_style',
            [
                'label' => __( 'Style', 'gostudy-core' ),
                'type' => Controls_Manager::SELECT,
                'default' => '1',
                'options' => [
                    '1' => esc_html__('1 / One', 'gostudy-core'),
                    '2' => esc_html__('2 / Two', 'gostudy-core'),
                    '3' => esc_html__('3 / Three', 'gostudy-core'),
                ],
            ]
        );
        $this->add_control(
            'item_grid',
            [
                'label' => esc_html__('Grid Columns Amount', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '1' => esc_html__('1 / One', 'gostudy-core'),
                    '2' => esc_html__('2 / Two', 'gostudy-core'),
                    '3' => esc_html__('3 / Three', 'gostudy-core'),
                    '4' => esc_html__('4 / Four', 'gostudy-core'),
                    '5' => esc_html__('5 / Five', 'gostudy-core'),
                    '6' => esc_html__('6 / Six', 'gostudy-core'),
                ],
                'default' => '1',
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'thumbnail',
            [
                'label' => esc_html__('Thumbnail', 'gostudy-core'),
                'type' => Controls_Manager::MEDIA,
                'label_block' => true,
                'default' => [ 'url' => Utils::get_placeholder_image_src() ],
            ]
        );
        $repeater->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'client_imagesize',
                'default' => 'large',
                'separator' => 'none',
            ]
        );

        $repeater->add_control(
            'client_name',
            [
                'label'   => __( 'Name', 'gostudy-core' ),
                'type'    => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => __('Johan Doe','gostudy-core'),

            ]    
        );
        $repeater->add_control(
            'client_designation',
            [
                'label'   => __( 'Designation', 'gostudy-core' ),
                'type'    => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => __('Managing Director','gostudy-core'),
            ]
        );
        $repeater->add_control(
            'client_say',
            [
                'label'   => __( 'Client Say', 'gostudy-core' ),
                'type'    => Controls_Manager::TEXTAREA,
                'default' => __('I believe in lifelong learning and they are a great place to learn from experts. I have learned a lot and recommend it','gostudy-core'),
            ]
        );
        $repeater->add_control(
            'client_link',
            [
                'label' => esc_html__('Add Link', 'gostudy-core'),
                'type' => Controls_Manager::URL,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'list',
            [
                'label' => esc_html__('Items', 'gostudy-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                    'default' => [

                        [
                            'client_name'           => __('James Smith','gostudy-core'),
                            'client_designation'    => __( 'CFO Apple Corp','gostudy-core' ),
                            'client_say'            => __( 'I believe in lifelong learning and they are a great place to learn from experts. I have learned a lot and recommend it', 'gostudy-core' ),
                        ],

                        [
                            'client_name'           => __('Mark Donald','gostudy-core'),
                            'client_designation'    => __( 'Manager','gostudy-core' ),
                            'client_say'            => __( 'Lorem ipsum dolor sit amet consectetur adipisicing elit sed do eiusmod tempor incididunt labore Lorem ipsum', 'gostudy-core' ),
                        ],

                        [
                            'client_name'           => __('John Dowson','gostudy-core'),
                            'client_designation'    => __( 'Developer','gostudy-core' ),
                            'client_say'            => __( 'I believe in lifelong learning and they are a great place to learn from experts. I have learned a lot and recommend it', 'gostudy-core' ),
                        ],
                    ],
                    'title_field' => '{{{ client_name }}}',
            ]
        );

       
        // $this->add_control(
        //     'height',
        //     [
        //         'label' => esc_html__('Custom Items Height', 'gostudy-core'),
        //         'type' => Controls_Manager::SLIDER,
        //         'range' => [
        //             'px' => [ 'min' => 50, 'max' => 300 ],
        //         ],
        //         'selectors' => [
        //             '{{WRAPPER}} .clients_image' => 'height: {{SIZE}}{{UNIT}};',
        //         ],
        //     ]
        // );

        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  CONTENT -> CAROUSEL OPTIONS
        /*-----------------------------------------------------------------------------------*/

        RT_Feedback_Settings::options($this);


        /*-----------------------------------------------------------------------------------*/
        /*  STYLES -> ITEMS
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_items',
            [
                'label' => esc_html__('Items', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'image_margin',
            [
                'label' => esc_html__('Image Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .clients_image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_padding',
            [
                'label' => esc_html__('Image Padding', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .clients_image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'image_border_radius',
            [
                'label' => esc_html__('Image Border Radius', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .clients_image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs(
            'tabs_items',
            [ 'separator' => 'before' ]
        );

        $this->start_controls_tab(
            'tab_item_idle',
            [ 'label' => esc_html__('Idle', 'gostudy-core') ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'item_idle',
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .clients_image',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_idle',
                'selector' => '{{WRAPPER}} .clients_image',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_item_hover',
            [ 'label' => esc_html__('Hover', 'gostudy-core') ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'item_hover',
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .clients_image:hover',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'item_hover',
                'selector' => '{{WRAPPER}} .clients_image:hover',
            ]
        );

        $this->add_control(
            'item_transition',
            [
                'label' => esc_html__('Transition Duration', 'gostudy-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 's' ],
                'range' => [
                    's' => [ 'min' => 0, 'max' => 2, 'step' => 0.1 ],
                ],
                'default' => [ 'size' => 0.4, 'unit' => 's' ],
                'selectors' => [
                    '{{WRAPPER}} .clients_image' => 'transition: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control(
            'image_height',
            [
                'label'      => __('Image Height', 'gostudy-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 150,
                        'max'  => 800,
                        'step' => 1,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => '',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .feedback-img-wrapper .feedback-image' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .feedback-img-wrapper .feedback-image img' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_padding',
            [
                'label' => esc_html__('Item Padding', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .feedback-content-wrapper .feedback-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'item_height',
            [
                'label'      => __('Item Height', 'gostudy-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 150,
                        'max'  => 800,
                        'step' => 1,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => '',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .feedback-content-wrapper .feedback-content' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        /*-----------------------------------------------------------------------------------*/
        /*  STYLES -> IMAGES
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_images',
            [
                'label' => esc_html__('Images', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'tabs_images' );

        $this->start_controls_tab(
            'tab_image_idle',
            [ 'label' => esc_html__('Idle', 'gostudy-core') ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'image_idle',
                'selector' => '{{WRAPPER}} .image_wrapper > img',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'image_idle',
                'selector' => '{{WRAPPER}} .image_wrapper > img',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_image_hover',
            [ 'label' => esc_html__('Hover', 'gostudy-core') ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'image_hover',
                'selector' => '{{WRAPPER}} .image_wrapper:hover > img',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'image_hover',
                'selector' => '{{WRAPPER}} .image_wrapper:hover > img',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();



        // Style Testimonial area tab section
        $this->start_controls_section(
            'testi_style_area',
            [
                'label' => __( 'Style', 'gostudy-elements' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'feedback_height',
            [
                'label' => __( 'Height', 'gostudy' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'default' => [
                    'size' => '',
                ],
                'range' => [
                    'px' => [
                        'min' => 200,
                        'max' => 800,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .gostudy-feedback-style-1 .feedback-single' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .gostudy-feedback-style-1 .feedback-img-wrapper .feedback-image' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .gostudy-feedback-style-1 .feedback-img-wrapper .feedback-image img' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .gostudy-feedback-style-1 .feedback-content-wrapper .feedback-content' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'testi_style' => '1',
                ],
            ]
        );
        $this->add_responsive_control(
            'feedback_position_x',
            [
                'label' => __( 'Position X', 'gostudy' ),
                'description' => __('Keep blank for the default value', 'edubin-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'default' => [
                    'size' => '',
                ],
                'range' => [
                    'px' => [
                        'min' => -295,
                        'max' => 295,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .gostudy-feedback-style-2 .feedback-content-wrapper' => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );        
        $this->add_responsive_control(
            'feedback_position_y',
            [
                'label' => __( 'Position Y', 'gostudy' ),
                'description' => __('Keep blank for the default value', 'edubin-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'default' => [
                    'size' => '',
                ],
                'range' => [
                    'px' => [
                        'min' => -195,
                        'max' => 195,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .gostudy-feedback-style-2 .feedback-content-wrapper' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'bg_color',
            [
                'label' => __( 'Background', 'gostudy-elements' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .gostudy-feedback-style-1 .feedback-content-wrapper .feedback-content' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'bg_color_style_1',
            [
                'label' => __( 'Background A', 'gostudy-elements' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
            ]
        );
        $this->add_control(
            'bg_color_style_2',
            [
                'label' => __( 'Background B', 'gostudy-elements' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
            ]
        );
        $this->add_responsive_control(
            'gostudy_feedback_name_align',
            [
                'label' => __( 'Alignment', 'gostudy-elements' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'gostudy-elements' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'gostudy-elements' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'gostudy-elements' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .gostudy-feedback-style-1 .feedback-content' => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} .gostudy-feedback-style-2 .feedback-content' => 'text-align: {{VALUE}};',
                ],
                'default' => 'left',
                'separator' =>'before',
            ]
        );
        $this->add_responsive_control(
            'gostudy_feedback_section_padding',
            [
                'label' => __( 'Padding', 'gostudy-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .gostudy-feedback-style-1 .feedback-content-wrapper .feedback-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .gostudy-feedback-style-2 .feedback-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .gostudy-feedback-style-3 .feedback-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',

                ]
            ]
        );
        $this->add_responsive_control(
            'gostudy_feedback_image_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'gostudy-elements' ),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .gostudy-feedback-style-1 .feedback-single' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                    '{{WRAPPER}} .gostudy-feedback-style-2 .feedback-content-wrapper' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                ],
                'condition' => [
                    'testi_style' => '1',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'testi_quote_style',
            [
                'label'     => __( 'Quote', 'gostudy-core' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'quote_icon_color',
            [
                'label' => __( 'Icon Color', 'gostudy-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .gostudy-feedback-style-3 .flaticon-straight-quotes' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section(); // Style Testimonial image style end

        $this->start_controls_section(
            'gostudy_feedback_name_style',
            [
                'label'     => __( 'Name', 'gostudy-core' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'feedback_name_color',
            [
                'label' => __( 'Color', 'gostudy-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .gostudy-feedback-style-1 .feedback-content-wrapper .feedback-name' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .gostudy-feedback-style-2 .feedback-content-wrapper .feedback-name' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .gostudy-feedback-style-3 .feedback-content-wrapper .feedback-name' => 'color: {{VALUE}};',
                ],
            ]
        );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'gostudy_feedback_name_typography',
                    'global' => [
                        'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                    ],
                    'selector' => '{{WRAPPER}} .gostudy-feedback-style-1 .feedback-content-wrapper .feedback-name, .gostudy-feedback-style-2 .feedback-content-wrapper .feedback-name, .gostudy-feedback-style-3 .feedback-content-wrapper .feedback-name',
                ]
            );

            $this->add_responsive_control(
                'gostudy_feedback_name_padding',
                [
                    'label' => __( 'Padding', 'gostudy-core' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .gostudy-feedback-style-1 .feedback-content-wrapper .feedback-name' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        '{{WRAPPER}} .gostudy-feedback-style-2 .feedback-content-wrapper .feedback-name' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        '{{WRAPPER}} .gostudy-feedback-style-3 .feedback-content-wrapper .feedback-name' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

        $this->end_controls_section(); // Style Testimonial name style end

        // Style Testimonial designation style start
        $this->start_controls_section(
            'gostudy_feedback_designation_style',
            [
                'label'     => __( 'Degree', 'gostudy-core' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );
            
            $this->add_control(
                'gostudy_feedback_degree_color',
                [
                    'label' => __( 'Color', 'gostudy-core' ),
                    'type' => Controls_Manager::COLOR,
                    'default' => '',
                    'selectors' => [
                        '{{WRAPPER}} .gostudy-feedback-style-1 .feedback-content-wrapper .feedback-degree' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .gostudy-feedback-style-2 .feedback-content-wrapper .feedback-degree' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .gostudy-feedback-style-3 .feedback-content-wrapper .feedback-degree' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'gostudy_feedback_degree_typography',
                    'global' => [
                        'default' => Global_Typography::TYPOGRAPHY_TEXT,
                    ],
                    'selector' => '{{WRAPPER}} .gostudy-feedback-style-1 .feedback-content-wrapper .feedback-degree, .gostudy-feedback-style-2 .feedback-content-wrapper .feedback-degree, .gostudy-feedback-style-3 .feedback-content-wrapper .feedback-degree',
                ]
            );

            $this->add_responsive_control(
                'gostudy_feedback_degree_padding',
                [
                    'label' => __( 'Padding', 'gostudy-core' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .gostudy-feedback-style-1 .feedback-content-wrapper .feedback-degree' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        '{{WRAPPER}} .gostudy-feedback-style-2 .feedback-content-wrapper .feedback-degree' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        '{{WRAPPER}} .gostudy-feedback-style-3 .feedback-content-wrapper .feedback-degree' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

        $this->end_controls_section(); // Style Testimonial designation style end


        // Style Testimonial designation style start
        $this->start_controls_section(
            'gostudy_feedback_clientsay_style',
            [
                'label'     => __( 'Client say', 'gostudy-core' ),
                'tab'       => Controls_Manager::TAB_STYLE,
            ]
        );
          
        $this->add_control(
            'gostudy_feedback_clientsay_color',
            [
                'label' => __( 'Color', 'gostudy-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .gostudy-feedback-style-1 .feedback-content-wrapper .feedback-text' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .gostudy-feedback-style-2 .feedback-content-wrapper .feedback-text' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .gostudy-feedback-style-3 .feedback-content-wrapper .feedback-text' => 'color: {{VALUE}};',
                ],
            ]
        );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'gostudy_feedback_clientsay_typography',
                    'global' => [
                        'default' => Global_Typography::TYPOGRAPHY_TEXT,
                    ],
                    'selector' => '{{WRAPPER}} .gostudy-feedback-style-1 .feedback-content-wrapper .feedback-text, .gostudy-feedback-style-2 .feedback-content-wrapper .feedback-text, .gostudy-feedback-style-3 .feedback-content-wrapper .feedback-text',
                ]
            );

            $this->add_responsive_control(
                'gostudy_feedback_clientsay_padding',
                [
                    'label' => __( 'Padding', 'gostudy-core' ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .gostudy-feedback-style-1 .feedback-content-wrapper .feedback-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        '{{WRAPPER}} .gostudy-feedback-style-2 .feedback-content-wrapper .feedback-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        '{{WRAPPER}} .gostudy-feedback-style-3 .feedback-content-wrapper .feedback-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' =>'before',
                ]
            );

        $this->end_controls_section(); // Style Testimonial designation style end

        // Style arrow style start
        $this->start_controls_section(
            'gostudy_feedback_arrow_style',
            [
                'label'     => __('Navigation Arrow', 'gostudy-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'slider_on' => 'yes',
                    'slarrows'  => 'yes',
                ],
            ]
        );

        $this->start_controls_tabs('feedback_arrow_style_tabs');

        // Normal tab Start
        $this->start_controls_tab(
            'feedback_arrow_style_normal_tab',
            [
                'label' => __('Normal', 'gostudy-core'),
            ]
        );

        $this->add_control(
            'gostudy_feedback_arrow_color',
            [
                'label'     => __('Color', 'gostudy-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .gostudy-carousel-btn-dot button.slick-arrow i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'gostudy_feedback_arrow_fontsize',
            [
                'label'      => __('Font Size', 'gostudy-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 50,
                        'step' => 1,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => '',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .gostudy-carousel-btn-dot button.slick-arrow i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'arrow_bg_color',
            [
                'label'     => __('Background Color', 'gostudy-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .gostudy-carousel-btn-dot button.gostudy-carosul-prev.slick-arrow, .gostudy-carousel-btn-dot button.gostudy-carosul-next.slick-arrow' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'gostudy_feedback_arrow_border',
                'label'    => __('Border', 'gostudy-core'),
                'selector' => '{{WRAPPER}} .gostudy-carousel-btn-dot button.gostudy-carosul-prev.slick-arrow, .gostudy-carousel-btn-dot button.gostudy-carosul-next.slick-arrow',
            ]
        );

        $this->add_responsive_control(
            'gostudy_feedback_arrow_border_radius',
            [
                'label'     => __('Border Radius', 'gostudy-core'),
                'type'      => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .gostudy-carousel-btn-dot button.gostudy-carosul-prev.slick-arrow, .gostudy-carousel-btn-dot button.gostudy-carosul-next.slick-arrow' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                ],
            ]
        );

        $this->add_responsive_control(
            'gostudy_feedback_arrow_height',
            [
                'label'      => __('Arrow Size', 'gostudy-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 10,
                        'max'  => 70,
                        'step' => 1,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => '',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .gostudy-carousel-btn-dot button.gostudy-carosul-prev.slick-arrow, .gostudy-carousel-btn-dot button.gostudy-carosul-next.slick-arrow' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_tab(); // Normal tab end

        // Hover tab Start
        $this->start_controls_tab(
            'feedback_arrow_style_hover_tab',
            [
                'label' => __('Hover', 'gostudy-core'),
            ]
        );

        $this->add_control(
            'gostudy_feedback_arrow_hover_color',
            [
                'label'     => __('Color', 'gostudy-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .gostudy-carousel-btn-dot button.slick-arrow:hover i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrow_bg_hover_color',
            [
                'label'     => __('Background Color', 'gostudy-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .gostudy-carousel-btn-dot button.slick-arrow:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'gostudy_feedback_arrow_hover_border',
                'label'    => __('Border', 'gostudy-core'),
                'selector' => '{{WRAPPER}} .gostudy-icon-category-style-1 .slick-arrow:hover',
            ]
        );

        $this->add_responsive_control(
            'gostudy_feedback_arrow_hover_border_radius',
            [
                'label'     => __('Border Radius', 'gostudy-core'),
                'type'      => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .gostudy-icon-category-style-1 .slick-arrow:hover' => 'border-radius: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
                ],
            ]
        );

        $this->end_controls_tab(); // Hover tab end

        $this->end_controls_tabs();

        $this->end_controls_section(); // Style cat box arrow style end

        // Style cat box Dots style start
        $this->start_controls_section(
            'gostudy_feedback_dots_style',
            [
                'label'     => __('Dot Pagination', 'gostudy-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'slider_on' => 'yes',
                    'sldots'    => 'yes',
                ],
            ]
        );

        $this->start_controls_tabs('feedback_dots_style_tabs');

        // Normal tab Start
        $this->start_controls_tab(
            'feedback_dots_style_normal_tab',
            [
                'label' => __('Normal', 'gostudy-core'),
            ]
        );

        $this->add_control(
            'dot_color',
            [
                'label'     => __('Dot Color', 'gostudy-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .gostudy-carousel-btn-dot .slick-dots li button' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .gostudy-carousel-btn-dot .slick-dots li button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'gostudy_feedback_dots_height',
            [
                'label'      => __('Dot Size', 'gostudy-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 30,
                        'step' => 1,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => '',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .gostudy-carousel-btn-dot .slick-dots li.slick-active button, .gostudy-carousel-btn-dot .slick-dots li button' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'gostudy_feedback_dots_space',
            [
                'label'      => __('Space Between', 'gostudy-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 30,
                        'step' => 1,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => '',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .gostudy-carousel-btn-dot .slick-dots li' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'gostudy_feedback_dots_position',
            [
                'label'      => __('Dot Position', 'gostudy-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => -100,
                        'max'  => 10,
                        'step' => 1,
                    ],
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => '',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .gostudy-carousel-btn-dot .slick-dots' => 'bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab(); // Normal tab end

        // Hover tab Start
        $this->start_controls_tab(
            'feedback_dots_style_hover_tab',
            [
                'label' => __('Active', 'gostudy-core'),
            ]
        );
        $this->add_control(
            'dot_hover_color',
            [
                'label'     => __('Dot Active Color', 'gostudy-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .gostudy-carousel-btn-dot .slick-dots li.slick-active button' => 'border-color: {{VALUE}}; background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab(); // Hover tab end

        $this->end_controls_tabs();

        $this->end_controls_section(); // Style cat box dots style end

    }

    protected function render()
    {
        $content = '';
        $settings = $this->get_settings_for_display();
        extract($settings);

        if ($use_carousel) {
            $carousel_options = [
                'slide_to_show' => $item_grid,
                'autoplay' => $autoplay,
                'autoplay_speed' => $autoplay_speed,
                'fade_animation' => $fade_animation,
                'slides_to_scroll' => $slides_to_scroll,
                'infinite' => true,
                'use_pagination' => $use_pagination,
                'pag_type' => $pag_type,
                'pag_offset' => $pag_offset,
                'pag_align' => $pag_align,
                'custom_pag_color' => $custom_pag_color,
                'pag_color' => $pag_color,
                // Prev/next
                'use_prev_next' => $use_prev_next,
                'prev_next_position' => $prev_next_position,
                'custom_prev_next_color' => $custom_prev_next_color,
                'prev_next_color' => $prev_next_color,
                'prev_next_color_hover' => $prev_next_color_hover,
                'prev_next_bg_idle' => $prev_next_bg_idle,
                'prev_next_bg_hover' => $prev_next_bg_hover,
                // Responsive
                'custom_resp' => $custom_resp,
                'resp_medium' => $resp_medium,
                'resp_medium_slides' => $resp_medium_slides,
                'resp_tablets' => $resp_tablets,
                'resp_tablets_slides' => $resp_tablets_slides,
                'resp_mobile' => $resp_mobile,
                'resp_mobile_slides' => $resp_mobile_slides,
            ];

            wp_enqueue_script('slick', get_template_directory_uri() . '/js/slick.min.js');

            /* ↓ Fix box-shadow issue with Elementor capabilities only ↓ */
            $styles = '';
            if (isset($_margin['left'])) {
                $styles .= '.elementor-element-' . $this->get_id() .' .slick-slider .slick-list { '
                    . 'margin-left: ' . $_margin['left'] . $_margin['unit'] . ';'
                    . 'margin-right: ' . $_margin['right'] . $_margin['unit'] . ';'
                . ' } ';
            }
            if (isset($_padding['left'])) {
                $styles .= '.elementor-element-' . $this->get_id() .' .slick-slider .slick-list { '
                    . 'padding-left: ' . $_padding['left'] . $_padding['unit'] . ';'
                    . 'padding-right: ' . $_padding['right'] . $_padding['unit'] . ';'
                . ' } ';
            }
            if ($styles) RT_Elementor_Helper::enqueue_css($styles);
            /* ↑ fix box-shadow issue ↑ */
        }

        $this->add_render_attribute(
            'clients',
            [
                'class' => [
                    'rt-clients',
                    'clearfix',
                    'items-' . $item_grid,
                    'gostudy-feedback-style-'.$settings['testi_style'],
                ],
                'data-carousel' => $use_carousel
            ]
        );
?>
<?php if ($settings['testi_style'] == '2'): ?>
<!--     For style two only -->
    <div class="gostudy-feedback-style-2">

        <div class="feedback-single">
            <div class="feedback-content-wrapper" <?php if ($settings['bg_color_style_2']): ?> style="background: <?php echo $settings['bg_color_style_2']; ?> <?php endif ?>>

                <div class="feedback-svg-bg">

                        <svg class="feedback-svg-large" 
                         xmlns="http://www.w3.org/2000/svg"
                         xmlns:xlink="http://www.w3.org/1999/xlink"
                         width="554px" height="526px">
                        <defs>
                        <linearGradient id="PSgrad_0" x1="0%" x2="100%" y1="0%" y2="0%">
                          <stop offset="0%" stop-color="<?php if ($settings['bg_color_style_1']): ?> <?php echo $settings['bg_color_style_1']; else : echo 'rgb(113,27,82)'; ?> <?php endif ?>" stop-opacity="1" />
                          <stop offset="100%" stop-color="<?php if ($settings['bg_color_style_2']): ?> <?php echo $settings['bg_color_style_2']; else : echo 'rgb(235,82,82)'; ?> <?php endif ?>" stop-opacity="1" />
                        </linearGradient>

                        </defs>
                        <path fill-rule="evenodd"  fill="rgb(255, 31, 89)"
                         d="M342.000,436.999 L10.000,436.999 C4.477,436.999 -0.000,432.522 -0.000,426.999 L-0.000,9.999 C-0.000,4.476 4.477,-0.001 10.000,-0.001 L544.000,-0.001 C549.523,-0.001 554.000,4.476 554.000,9.999 L554.000,426.999 C554.000,432.522 549.523,436.999 544.000,436.999 L483.000,436.999 L483.000,525.999 L342.000,436.999 Z"/>
                        <path fill="url(#PSgrad_0)"
                         d="M342.000,436.999 L10.000,436.999 C4.477,436.999 -0.000,432.522 -0.000,426.999 L-0.000,9.999 C-0.000,4.476 4.477,-0.001 10.000,-0.001 L544.000,-0.001 C549.523,-0.001 554.000,4.476 554.000,9.999 L554.000,426.999 C554.000,432.522 549.523,436.999 544.000,436.999 L483.000,436.999 L483.000,525.999 L342.000,436.999 Z"/>
                        </svg>
                </div>
<!--     End for style 2 only -->
<?php endif ?>

  <?php      
        foreach ($settings['list'] as $index => $item) {
        ob_start();

         if ($settings['testi_style'] == '1'): ?>

        <div class="feedback-single">
            <div class="feedback-img-wrapper">
                <?php
                    if( !empty($item['thumbnail']['url']) ){
                        echo '<div class="feedback-image">'.Group_Control_Image_Size::get_attachment_image_html( $item, 'client_imagesize', 'thumbnail' ).'</div>';
                    } 
                ?>
            </div>
            <div class="feedback-content-wrapper">
                <div class="feedback-content">
                        <div class="quote-svg">
                            <svg 
                                 xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink"
                                 width="70px" height="50px">
                                <path fill-rule="evenodd"  fill="<?php if ($settings['quote_icon_color']): ?> <?php echo $settings['quote_icon_color']; else: echo '#ff1f59'; ?> <?php endif ?>"
                                 d="M55.376,31.360 C55.235,32.892 55.341,37.067 59.311,42.872 C59.612,43.311 59.557,43.901 59.184,44.276 C57.560,45.912 56.555,46.943 55.853,47.664 C54.933,48.608 54.513,49.038 53.899,49.600 C53.691,49.791 53.428,49.885 53.164,49.885 C52.908,49.885 52.652,49.795 52.446,49.616 C45.527,43.551 37.842,31.022 38.954,15.667 C39.605,6.652 46.133,0.108 54.476,0.108 C63.036,0.108 70.000,7.123 70.000,15.746 C70.000,24.065 63.519,30.888 55.376,31.360 ZM54.476,2.311 C47.312,2.311 41.702,7.997 41.135,15.826 C39.885,33.096 50.075,44.309 53.153,47.278 C53.451,46.983 53.791,46.634 54.292,46.121 C54.901,45.497 55.736,44.639 57.003,43.359 C52.184,35.879 53.095,30.552 53.493,29.788 C53.682,29.426 54.070,29.181 54.476,29.181 C61.829,29.181 67.812,23.155 67.812,15.746 C67.812,8.339 61.829,2.311 54.476,2.311 ZM16.527,31.360 C16.386,32.891 16.493,37.063 20.464,42.872 C20.765,43.311 20.710,43.901 20.337,44.276 C18.719,45.907 17.717,46.936 17.014,47.656 C16.090,48.605 15.668,49.037 15.051,49.600 C14.843,49.791 14.579,49.885 14.316,49.885 C14.059,49.885 13.804,49.795 13.598,49.615 C6.679,43.551 -1.006,31.020 0.105,15.667 L0.105,15.665 C0.758,6.652 7.287,0.108 15.628,0.108 C24.188,0.108 31.153,7.123 31.153,15.746 C31.153,24.065 24.671,30.888 16.527,31.360 ZM15.628,2.311 C8.465,2.311 2.854,7.997 2.286,15.827 L2.286,15.826 C1.037,33.094 11.227,44.309 14.305,47.278 C14.605,46.981 14.948,46.629 15.454,46.110 C16.062,45.487 16.894,44.633 18.156,43.359 C13.337,35.879 14.246,30.552 14.644,29.788 C14.833,29.427 15.222,29.181 15.628,29.181 C22.982,29.181 28.965,23.155 28.965,15.746 C28.965,8.339 22.982,2.311 15.628,2.311 Z"/>
                            </svg>
                        </div>
                        <?php                             
                            if( !empty($item['client_say']) ){
                                echo '<p class="feedback-text">'.esc_html__( $item['client_say'], 'gostudy-core' ).'</p>';
                            }
                        ?>
                        <?php                             
                            if( !empty($item['client_name']) ){
                                echo '<p class="feedback-name">'.esc_html__( $item['client_name'], 'gostudy-core' ).'</p>';
                            }
                        ?>
                        <?php                             
                            if( !empty($item['client_designation']) ){
                                echo '<p class="feedback-degree">'.esc_html__( $item['client_designation'], 'gostudy-core' ).'</p>';
                            }
                        ?>
                </div>
            </div>
        </div>

        <?php elseif ($settings['testi_style'] == '2'): ?>

    <div class="feedback-content">
        <div class="quote-svg">
            <svg 
                 xmlns="http://www.w3.org/2000/svg"
                 xmlns:xlink="http://www.w3.org/1999/xlink"
                 width="70px" height="50px">
                <path fill-rule="evenodd"  fill="<?php if ($settings['quote_icon_color']): ?> <?php echo $settings['quote_icon_color']; else: echo '#fff'; ?> <?php endif ?>"
                 d="M55.376,31.360 C55.235,32.892 55.341,37.067 59.311,42.872 C59.612,43.311 59.557,43.901 59.184,44.276 C57.560,45.912 56.555,46.943 55.853,47.664 C54.933,48.608 54.513,49.038 53.899,49.600 C53.691,49.791 53.428,49.885 53.164,49.885 C52.908,49.885 52.652,49.795 52.446,49.616 C45.527,43.551 37.842,31.022 38.954,15.667 C39.605,6.652 46.133,0.108 54.476,0.108 C63.036,0.108 70.000,7.123 70.000,15.746 C70.000,24.065 63.519,30.888 55.376,31.360 ZM54.476,2.311 C47.312,2.311 41.702,7.997 41.135,15.826 C39.885,33.096 50.075,44.309 53.153,47.278 C53.451,46.983 53.791,46.634 54.292,46.121 C54.901,45.497 55.736,44.639 57.003,43.359 C52.184,35.879 53.095,30.552 53.493,29.788 C53.682,29.426 54.070,29.181 54.476,29.181 C61.829,29.181 67.812,23.155 67.812,15.746 C67.812,8.339 61.829,2.311 54.476,2.311 ZM16.527,31.360 C16.386,32.891 16.493,37.063 20.464,42.872 C20.765,43.311 20.710,43.901 20.337,44.276 C18.719,45.907 17.717,46.936 17.014,47.656 C16.090,48.605 15.668,49.037 15.051,49.600 C14.843,49.791 14.579,49.885 14.316,49.885 C14.059,49.885 13.804,49.795 13.598,49.615 C6.679,43.551 -1.006,31.020 0.105,15.667 L0.105,15.665 C0.758,6.652 7.287,0.108 15.628,0.108 C24.188,0.108 31.153,7.123 31.153,15.746 C31.153,24.065 24.671,30.888 16.527,31.360 ZM15.628,2.311 C8.465,2.311 2.854,7.997 2.286,15.827 L2.286,15.826 C1.037,33.094 11.227,44.309 14.305,47.278 C14.605,46.981 14.948,46.629 15.454,46.110 C16.062,45.487 16.894,44.633 18.156,43.359 C13.337,35.879 14.246,30.552 14.644,29.788 C14.833,29.427 15.222,29.181 15.628,29.181 C22.982,29.181 28.965,23.155 28.965,15.746 C28.965,8.339 22.982,2.311 15.628,2.311 Z"/>
            </svg>
        </div>
        <?php                             
            if( !empty($item['client_say']) ){
                echo '<p class="feedback-text">'.esc_html__( $item['client_say'], 'gostudy-elements' ).'</p>';
            }
        ?>
        <?php                             
            if( !empty($item['client_name']) ){
                echo '<p class="feedback-name">'.esc_html__( $item['client_name'], 'gostudy-elements' ).'</p>';
            }
        ?>
        <?php                             
            if( !empty($item['client_designation']) ){
                echo '<p class="feedback-degree">'.esc_html__( $item['client_designation'], 'gostudy-elements' ).'</p>';
            }
        ?>
    </div>

        <?php elseif ($settings['testi_style'] == '3'): ?>

            <div class="feedback-single">
                <?php
                    if( !empty($item['thumbnail']['url']) ){
                        echo '<div class="feedback-image">'.Group_Control_Image_Size::get_attachment_image_html( $item, 'client_imagesize', 'thumbnail' ).'</div>';
                    } 
                ?>
                <div class="feedback-content-wrapper">
                    <div class="feedback-content">
                            <?php                             
                                if( !empty($item['client_say']) ){
                                    echo '<p class="feedback-text">'.esc_html__( $item['client_say'], 'gostudy-core' ).'</p>';
                                }
                            ?>
                        <div class="name-degree">
                            
                            <?php                             
                                if( !empty($item['client_name']) ){
                                    echo '<p class="feedback-name">'.esc_html__( $item['client_name'], 'gostudy-core' ).'</p>';
                                }
                            ?>
                            <?php                             
                                if( !empty($item['client_designation']) ){
                                    echo '<p class="feedback-degree">'.esc_html__( $item['client_designation'], 'gostudy-core' ).'</p>';
                                }
                            ?>
                        </div>
                        <div class="quotes-icon-wrap">
                             <span class="flaticon-straight-quotes"></span>
                        </div>
                       
                    </div>
                </div>
            </div>

        <?php endif ?>
        <?php
            $content .= ob_get_clean();
        }

        // Render
        echo '<div ', $this->get_render_attribute_string('clients'), '>';
            if ($use_carousel) {
                echo RT_Feedback_Settings::init($carousel_options, $content, false);
            } else {
                echo $content;
            }
        echo '</div>';

if ($settings['testi_style'] == '2') { ?>
      <!--   For style 2 only  -->
           </div>
        </div>
    </div>
     <!--   End for style 2 only  -->
<?php
}


    }

}
