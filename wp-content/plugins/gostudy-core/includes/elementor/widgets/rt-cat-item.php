<?php
/*
 * This template can be overridden by copying it to yourtheme/gostudy-core/elementor/widgets/rt-Cat-item.php.
*/
namespace RTAddons\Widgets;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\{Widget_Base, Controls_Manager, Control_Media, Group_Control_Background, Group_Control_Box_Shadow, Group_Control_Typography, Utils};
use RTAddons\Gostudy_Global_Variables as Gostudy_Globals;

class RT_Cat_Item extends Widget_Base
{

    public function get_name()
    {
        return 'rt-cat-item';
    }

    public function get_title()
    {
        return esc_html__('RT Category Item', 'gostudy-core');
    }

    public function get_icon()
    {
        return 'rt-cat-item';
    }

    public function get_categories()
    {
        return ['rt-extensions'];
    }

    protected function register_controls()
    {
        /*-----------------------------------------------------------------------------------*/
        /*  Content
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'rt_cat_item_section',
            [
                'label' => esc_html__('Category Item Settings', 'gostudy-core'),
            ]
        );

        $this->add_control(
            'cat_title',
            [
                'label' => esc_html__('Title', 'gostudy-core'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'dynamic' => ['active' => true],
                'default' => esc_html__('This is the heading​', 'gostudy-core'),
            ]
        );

        $this->add_control(
            'title_tag',
            [
                'label' => esc_html__('HTML Tag', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => '‹h1›',
                    'h2' => '‹h2›',
                    'h3' => '‹h3›',
                    'h4' => '‹h4›',
                    'h5' => '‹h5›',
                    'h6' => '‹h6›',
                    'div' => '‹div›',
                    'span' => '‹span›',
                ],
                'default' => 'h3',
            ]
        );

        $this->add_control(
            'cat_name',
            [
                'label' => esc_html__('Category Name', 'gostudy-core'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'dynamic' => ['active' => true],
                'default' => esc_html__('Category Name', 'gostudy-core'),
            ]
        );

        $this->add_control(
            'cat_tag',
            [
                'label' => esc_html__('HTML Tag', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => '‹h1›',
                    'h2' => '‹h2›',
                    'h3' => '‹h3›',
                    'h4' => '‹h4›',
                    'h5' => '‹h5›',
                    'h6' => '‹h6›',
                    'div' => '‹div›',
                    'span' => '‹span›',
                ],
                'default' => 'h4',
            ]
        );

        $this->add_control(
            'thumbnail',
            [
                'label' => esc_html__('Image', 'gostudy-core'),
                'type' => Controls_Manager::MEDIA,
                'label_block' => true,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );
        $this->add_responsive_control(
            'image_fixed_height',
            [
                'label' => __( 'Height', 'eduent-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 900,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 160,
                ],
                'selectors' => [
                    '{{WRAPPER}} .rt-cat-item .items-image' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .rt-cat-item .items-image img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'cat_link',
            [
                'label' => esc_html__('Category Link', 'gostudy-core'),
                'type' => Controls_Manager::URL,
                'label_block' => true,
            ]
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  Carousel styles
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__('Category Item Styles', 'gostudy-core'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
        );
        // $this->add_control(
        //     'overlay_color',
        //     [
        //         'label' => esc_html__('Overlay Color', 'gostudy-core'),
        //         'type' => Controls_Manager::COLOR,
        //         'default' => '#3B3E4987',
        //         'selectors' => [
        //             '{{WRAPPER}} .rt-cat-item .single-items .items-image::before' => 'background-color: {{VALUE}};',
        //         ],
        //     ]
        // );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'lp_catogories_bg_color',
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .rt-cat-item .single-items .items-image::before',
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_title',
                'label' => __( 'Category Typography', 'eduent-core' ),
                'selector' => '{{WRAPPER}} .rt-cat-item .single-items .items-cont .course-cat',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'custom_fonts_count',
                'label' => __( 'Count Typography', 'eduent-core' ),
                'selector' => '{{WRAPPER}} .rt-cat-item .single-items .items-cont .total-course',
            ]
        );

        $this->start_controls_tabs( 'title_color_tab' );

        $this->start_controls_tab(
            'custom_title_color',
            [ 'label' => esc_html__('Title Color' , 'gostudy-core') ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Category Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .rt-cat-item .single-items .items-cont .course-cat' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'count_color',
            [
                'label' => esc_html__('Count Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .rt-cat-item .single-items .items-cont .total-course' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'custom_title_color_hover',
            [ 'label' => esc_html__('Hover' , 'gostudy-core') ]
        );

        $this->add_control(
            'title_color_hover',
            [
                'label' => esc_html__('Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'default' => Gostudy_Globals::get_secondary_color(),
                'selectors' => [
                    '{{WRAPPER}} .rt-cat-item:hover .course-cat' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->add_control(
            'image_border_radius',
            [
                'label' => esc_html__('Image Border Radius', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'default' => [
                    'top' => 10,
                    'right' => 10,
                    'bottom' => 10,
                    'left' => 10,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .cat-item_image, {{WRAPPER}} .rt-cat-item .single-items .items-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'image_box_shadow',
                'selector' => '{{WRAPPER}} .rt-cat-item .items-image',
            ]
        );
        $this->add_responsive_control(
            'space_between',
            [
                'label' => __( 'Space Between', 'eduent-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 900,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .rt-cat-item .items-cont .course-cat' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

       $this->add_responsive_control(
            'space_top',
            [
                'label' => __( 'Top Space', 'eduent-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .rt-cat-item .items-cont' => 'top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();

    }

    protected function render()
    {
        $_s = $this->get_settings_for_display();

        $this->add_render_attribute('cat', 'class', 'rt-cat-item');

        if (!empty($settings['cat_link']['url'])) {
            $this->add_link_attributes('cat_button', $_s['cat_link']);
        }
        $this->add_render_attribute('cat_link', 'class', 'cat-item_image-link');
        if (!empty($_s['cat_link']['url'])) {
            $this->add_link_attributes('cat_link', $_s['cat_link']);
        }

        $this->add_render_attribute('title_link', 'class', 'cat-item_title-link');
        if (!empty($_s['cat_link']['url'])) {
            $this->add_link_attributes('title_link', $_s['cat_link']);
        }

        $this->add_render_attribute('cat_img', [
            'class' => 'cat-item_image',
            'src' => isset($_s['thumbnail']['url']) ? esc_url($_s['thumbnail']['url']) : '',
            'alt' => Control_Media::get_image_alt( $_s['thumbnail'] ),
        ]);

        ?>

        <div <?php echo $this->get_render_attribute_string('cat'); ?>>
            <div class="single-items text-center">

            <?php if(!empty($settings['cat_link']['url'])) : ?>
                <a href="<?php echo esc_url($title_link['url']); ?>">
            <?php endif ?>

            <?php if (!empty($_s['thumbnail'])) {?>
                <div class="items-image">
                    <img <?php echo $this->get_render_attribute_string('cat_img'); ?> />
                </div>
            <?php } ?>

                <div class="items-cont">

                    <?php                 
                        if (!empty($_s['cat_title'])) {
                            echo '<a ', $this->get_render_attribute_string('title_link'), '>',
                                '<', $_s['title_tag'], ' class="course-cat">',
                                    $_s['cat_title'],
                                '</', $_s['title_tag'], '>',
                            '</a>';
                        }
                    ?>

                    <?php                 
                        if (!empty($_s['cat_name'])) {
                            echo '<', $_s['cat_tag'], ' class="total-course">',
                                    $_s['cat_name'],
                                '</', $_s['cat_tag'], '>';
                        }
                    ?>
                   
                </div>
                <?php if(!empty($settings['cat_link']['url'])) : ?>
                </a>
                <?php endif ?>
            </div> 
        </div>

        <?php
    }

}