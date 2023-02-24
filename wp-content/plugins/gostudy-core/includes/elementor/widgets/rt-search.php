<?php
namespace RTAddons\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

use Elementor\{Widget_Base, Controls_Manager};
// use Elementor\{Core\Schemes\Typography as Typography};
use Elementor\{Group_Control_Typography, Group_Control_Box_Shadow, Group_Control_Background, Group_Control_Border};
use Elementor\Icons_Manager;
use RTAddons\RT_Global_Variables as RT_Globals;
use RTAddons\Includes\RT_Icons;
use RTAddons\Templates\RTSearch;


class RT_Search extends Widget_Base
{

    public function get_name() {
        return 'rt-search';
    }
    
    public function get_title() {
        return __( 'RT Course Search', 'rt-core' );
    }

    public function get_icon() {
        return 'rt-icon eicon-search';
    }

    public function get_categories() {
        return [ 'rt-core' ];
    }

    public function get_script_depends() {
        return [''];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'section_style',
            [
                'label' => __( 'Content', 'rt-core' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'search_type',
            [
                'label'   => __('Search Type', 'rt-core'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'rt_wp_search',
                'options' => [
                    'rt_wp_search'    => __('WordPress Search', 'rt-core'),
                    'rt_tutor_search' => __('Tutor Search', 'rt-core'),
                    'rt_lp_search'    => __('LearnPress Search', 'rt-core'),
                    'rt_ld_search'    => __('LearnDash Search', 'rt-core'),
                ],
            ]
        );
        $this->add_control(
            'search_btn_text',
            [
                'label'       => __('Button Text', 'rt-core'),
                'type'        => Controls_Manager::TEXT,
                'default'     => '',
                'label_block' => true,
            ]
        );
        $this->add_control(
            'search_placeholder',
            [
                'label'       => __('Placeholder', 'rt-core'),
                'type'        => Controls_Manager::TEXT,
                'default'     => 'What do you want to learn?',
                'label_block' => true,
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'section_testimoni',
            [
                'label' => __( 'Style', 'rt-core' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'align',
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
                'label'  => __( 'Width', 'rt-core' ),
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
                'label'  => __( 'Height', 'rt-core' ),
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
                'label'  => __( 'Submit Button Width', 'rt-core' ),
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
                'label'  => __( 'Border Radius', 'rt-core' ),
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
                'label'     => __( 'Input Text', 'rt-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-course-form-wrapper .rt-course-input' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'input_border_color',
            [
                'label'     => __( 'Input Border', 'rt-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-course-form-wrapper .rt-course-input' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'input_bg_color',
            [
                'label'     => __( 'Input Background', 'rt-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-course-form-wrapper .rt-course-input' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'btn_bg_color',
            [
                'label'     => __( 'Submit Background', 'rt-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-course-form-wrapper .rt-course-btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'btn_bg_hover_color',
            [
                'label'     => __( 'Submit Background Hover', 'rt-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-course-form-wrapper .rt-course-btn:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'btn_border_color',
            [
                'label'     => __( 'Submit Border', 'rt-core' ),
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
                'label'    => __( 'Submit Typography', 'rt-core' ),
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_ACCENT,
                ],
                'selector' => '{{WRAPPER}} .rt-course-form-wrapper .rt-course-btn',
            ]
        );
        
        $this->add_control(
            'input_placholder_color',
            [
                'label'     => __( 'Placeholder', 'rt-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-course-form-wrapper input::placeholder' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'btn_text_color',
            [
                'label'     => __( 'Submit Text', 'rt-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-course-form-wrapper .rt-course-btn' => 'color: {{VALUE}};',

                ],
            ]
        );

        $this->add_control(
            'btn_text_hover_color',
            [
                'label'     => __( 'Submit Text Hover', 'rt-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rt-course-form-wrapper .rt-course-btn:hover' => 'color: {{VALUE}};',

                ],
            ]
        );
        $this->end_controls_section();

    } // End options

    protected function render( $instance = [] ) {
        
        $settings = $this->get_settings();
        ?>

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

                            <input type="text" value="" name="s" placeholder="<?php echo $settings['search_placeholder']; ?>" class="rt-course-input" autocomplete="off" />
                            <input type="hidden" value="course" name="ref" />
                            <button class="rt-course-btn" type="submit"><?php if ($settings['search_btn_text']): echo $settings['search_btn_text'];else: ?> <i class="fa fa-search"></i><?php endif;?></button>
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

    }

}

