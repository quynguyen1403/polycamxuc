<?php
namespace RTAddons\Modules;

defined('ABSPATH') || exit;

use Elementor\{Controls_Manager, Group_Control_Typography, Repeater, Plugin, Utils};
use RTAddons\Gostudy_Global_Variables as Gostudy_Globals;

/**
 * RT Elementor Section
 *
 *
 * @category Class
 * @package gostudy-core\includes\elementor
 * @author RaisTheme <help.raistheme@gmail.com>
 * @since 1.0.0
 */
class RT_Section
{
    public $sections = [];

    public function __construct()
    {
        add_action('elementor/init', [$this, 'add_hooks']);
    }

    public function add_hooks()
    {
        // Add RT extension control section to Section panel
        add_action('elementor/element/section/section_typo/after_section_end', [$this, 'extened_animation_options'], 10, 2);

        // add_action( 'elementor/element/section/section_layout/after_section_end', [ $this, 'extends_header_params' ], 10, 2 );
        add_action('elementor/element/column/layout/after_section_end', [$this, 'extends_column_params'], 10, 2);

        add_action('elementor/frontend/section/before_render', [$this, 'extened_row_render'], 10, 1);

        add_action('elementor/frontend/column/before_render', [$this, 'extened_column_render'], 10, 1);

        add_action('elementor/frontend/before_enqueue_scripts', [$this, 'enqueue_scripts']);

       add_action('elementor/element/section/section_typo/after_section_end', [$this, 'header_metaboxes'], 10, 1);
    }

    function header_metaboxes($page)
    {
        if (get_post_type() !== 'header') {
            return;
        }

        $page->start_controls_section(
            'header_options',
            [
                'label' => esc_html__('RT Header Options', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_SETTINGS
            ]
        );

        $page->add_control(
            'use_custom_logo',
            [
                'label' => esc_html__('Use Custom Mobile Logo?', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $page->add_control(
            'custom_logo',
            [
                'label' => esc_html__('Custom Logo', 'gostudy-core'),
                'type' => Controls_Manager::MEDIA,
                'condition' => [ 'use_custom_logo' => 'yes' ],
                'label_block' => true,
                'default' => [ 'url' => Utils::get_placeholder_image_src() ],
            ]
        );

        $page->add_control(
            'enable_logo_height',
            [
                'label' => esc_html__('Enable Logo Height?', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['use_custom_logo' => 'yes'],
            ]
        );

        $page->add_control(
            'logo_height',
            [
                'label' => esc_html__('Logo Height', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'condition' => [
                    'use_custom_logo' => 'yes',
                    'enable_logo_height' => 'yes',
                ],
                'min' => 1,
            ]
        );

        $page->add_control(
            'hr_mobile_logo',
            [ 'type' => Controls_Manager::DIVIDER ]
        );

        $page->add_control(
            'use_custom_menu_logo',
            [
                'label' => esc_html__('Use Custom Mobile Menu Logo?', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $page->add_control(
            'custom_menu_logo',
            [
                'label' => esc_html__('Custom Logo', 'gostudy-core'),
                'type' => Controls_Manager::MEDIA,
                'condition' => [ 'use_custom_menu_logo' => 'yes' ],
                'label_block' => true,
                'default' => [ 'url' => Utils::get_placeholder_image_src() ],
            ]
        );

        $page->add_control(
            'enable_menu_logo_height',
            [
                'label' => esc_html__('Enable Logo Height?', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [ 'use_custom_menu_logo' => 'yes' ],
            ]
        );

        $page->add_control(
            'logo_menu_height',
            [
                'label' => esc_html__('Logo Height', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'condition' => [
                    'use_custom_menu_logo' => 'yes',
                    'enable_menu_logo_height' => 'yes',
                ],
                'min' => 1,
            ]
        );

        $page->add_control(
            'hr_mobile_menu_logo',
            [ 'type' => Controls_Manager::DIVIDER ]
        );

        $page->add_control(
            'mobile_breakpoint',
            [
                'label' => esc_html__('Mobile Header resolution breakpoint', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'min' => 5,
                'max' => 1920,
                'default' => 1200,
            ]
        );

        $page->add_control(
            'header_on_bg',
            [
                'label' => esc_html__('Over content', 'gostudy-core'),
                'description' => esc_html__('Set Header to display over content.', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $page->end_controls_section();
    }

    public function extened_row_render(\Elementor\Element_Base $element)
    {
        if ('section' !== $element->get_name()) {
            return;
        }

        $settings = $element->get_settings();
        $data     = $element->get_data();

        // Background Text Extenions
        if (isset($settings['add_background_text'])
            && !empty($settings['add_background_text'])
        ) {

            wp_enqueue_script('jquery-appear', esc_url(get_template_directory_uri() . '/js/jquery.appear.js'), [], false, false);
            wp_enqueue_script('anime', esc_url(get_template_directory_uri() . '/js/anime.min.js'), [], false, false);
        }

        // Parallax Extenions
        if (
            isset($settings['add_background_animation'])
            && !empty($settings['add_background_animation'])
            && !(bool) Plugin::$instance->editor->is_edit_mode()
        ) {
            wp_enqueue_script('parallax', esc_url(get_template_directory_uri() . '/js/parallax.min.js'), [], false, false);
            wp_enqueue_script('jquery-paroller', esc_url(get_template_directory_uri() . '/js/jquery.paroller.min.js'), [], false, false);
            wp_enqueue_style('animate', esc_url(get_template_directory_uri() . '/css/animate.css'));
        }

        // Particles Extensions
        if (isset($settings['add_particles_animation']) && !empty($settings['add_particles_animation'])) {
            if (!(bool) Plugin::$instance->editor->is_edit_mode()) {
                wp_enqueue_script('tsparticles', get_template_directory_uri() . '/js/tsparticles.min.js', array('jquery'), false, true);
            }
        }

        // Particles Img Extensions
        if (isset($settings['add_particles_img_animation']) && !empty($settings['add_particles_img_animation'])) {
            if (!(bool) Plugin::$instance->editor->is_edit_mode()) {
                wp_enqueue_script('tsparticles', get_template_directory_uri() . '/js/tsparticles.min.js', array('jquery'), false, true);
            }
        }

        $this->sections[$data['id']] = $settings;
    }

    public function extened_column_render(\Elementor\Element_Base $element)
    {
        if ('column' !== $element->get_name()) {
            return;
        }

        $settings = $element->get_settings();
        $data     = $element->get_data();

        if (isset($settings['apply_sticky_column']) && !empty($settings['apply_sticky_column'])) {

            wp_enqueue_script('theia-sticky-sidebar', get_template_directory_uri() . '/js/theia-sticky-sidebar.min.js', [], false, false);
        }
    }

    public function enqueue_scripts()
    {
        if ((bool) Plugin::$instance->preview->is_preview_mode()) {
            wp_enqueue_style('animate', esc_url(get_template_directory_uri() . '/css/animate.css'));

            wp_enqueue_script('parallax', esc_url(get_template_directory_uri() . '/js/parallax.min.js'), [], false, false);
            wp_enqueue_script('jquery-paroller', esc_url(get_template_directory_uri() . '/js/jquery.paroller.min.js'), [], false, false);

            wp_enqueue_script('theia-sticky-sidebar', get_template_directory_uri() . '/js/theia-sticky-sidebar.min.js', [], false, false);

            wp_enqueue_script('tsparticles', get_template_directory_uri() . '/js/tsparticles.min.js', array('jquery'), false, true);

        }

        // Add options in the section
        wp_enqueue_script('rt-parallax', esc_url(RT_ELEMENTOR_ADDONS_URL . 'assets/js/rt_elementor_sections.js'), ['jquery'], false, true);

        // Add options in the column
        wp_enqueue_script('rt-column', esc_url(RT_ELEMENTOR_ADDONS_URL . 'assets/js/rt_elementor_column.js'), ['jquery'], false, true);

        wp_localize_script(
            'rt-parallax',
            'rt_parallax_settings',
            [
                $this->sections,
                'ajaxurl' => admin_url('admin-ajax.php'),
                'svgURL'  => esc_url(RT_ELEMENTOR_ADDONS_URL . 'assets/shapes/'),
            ]
        );
    }

    public function extened_animation_options($widget, $args)
    {
        $widget->start_controls_section(
            'extened_animation',
            [
                'label' => esc_html__('RT Background Text', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $widget->add_control(
            'add_background_text',
            [
                'label' => esc_html__('Add Background Text?', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'add-background-text',
                'prefix_class' => 'rt-',
            ]
        );

        $widget->add_control(
            'background_text',
            [
                'label' => esc_html__('Background Text', 'gostudy-core'),
                'type' => Controls_Manager::TEXTAREA,
                'condition' => [ 'add_background_text!' => '' ],
                'label_block' => true,
                'default' => esc_html__('Text', 'gostudy-core'),
                'selectors' => [
                    '{{WRAPPER}}.rt-add-background-text:before' => 'content: "{{VALUE}}"',
                    '{{WRAPPER}} .rt-background-text' => 'content: "{{VALUE}}"',
                ],
            ]
        );

        $widget->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'background_text_typo',
                'condition' => [
                    'add_background_text' => 'add-background-text',
                ],
                'selector' => '{{WRAPPER}}.rt-add-background-text:before, {{WRAPPER}} .rt-background-text',
            ]
        );

        $widget->add_responsive_control(
            'background_text_indent',
            [
                'label' => esc_html__('Text Indent', 'gostudy-core'),
                'type' => Controls_Manager::SLIDER,
                'condition' => [ 'add_background_text!' => '' ],
                'size_units' => ['px', 'vw'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 250],
                    'vw' => ['min' => 0, 'max' => 30],
                ],
                'default' => ['size' => 8.9, 'unit' => 'vw'],
                'selectors' => [
                    '{{WRAPPER}}.rt-add-background-text:before' => 'margin-left: calc({{SIZE}}{{UNIT}} / 2);',
                    '{{WRAPPER}} .rt-background-text .letter:last-child' => 'margin-right: -{{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_control(
            'background_text_color',
            [
                'label' => esc_html__('Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'condition' => [ 'add_background_text!' => '' ],
                'dynamic' => ['active' => true],
                'default' => '#ecf8fd',
                'selectors' => [
                    '{{WRAPPER}}.rt-add-background-text:before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .rt-background-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'background_text_spacing',
            [
                'label' => esc_html__('Top Spacing', 'gostudy-core'),
                'type' => Controls_Manager::SLIDER,
                'condition' => [ 'add_background_text!' => '' ],
                'range' => [
                    'px' => ['min' => -100, 'max' => 400],
                ],
                'default' => ['size' => 0, 'unit' => 'px'],
                'selectors' => [
                    '{{WRAPPER}}.rt-add-background-text:before' => 'margin-top: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .rt-background-text' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_control(
            'apply_animation_background_text',
            [
                'label' => esc_html__('Apply Animation?', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [ 'add_background_text!' => '' ],
                'return_value' => 'animation-background-text',
                'default' => 'animation-background-text',
                'prefix_class' => 'rt-',
            ]
        );

        $widget->end_controls_section();

        $widget->start_controls_section(
            'extened_parallax',
            [
                'label' => esc_html__('RT Parallax', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $widget->add_control(
            'add_background_animation',
            [
                'label' => esc_html__('Add Extended Background Animation?', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'image_effect',
            [
                'label' => esc_html__('Parallax Effect', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'scroll' => esc_html__('Scroll', 'gostudy-core'),
                    'mouse' => esc_html__('Mouse', 'gostudy-core'),
                    'css_animation' => esc_html__('CSS Animation', 'gostudy-core'),
                ],
                'default' => 'scroll',
            ]
        );

        $repeater->add_responsive_control(
            'animation_name',
            [
                'label' => esc_html__('Animation', 'gostudy-core'),
                'type' => Controls_Manager::SELECT2,
                'default' => 'fadeIn',
                'options' => [
                    'bounce' => 'bounce',
                    'flash' => 'flash',
                    'pulse' => 'pulse',
                    'rubberBand' => 'rubberBand',
                    'shake' => 'shake',
                    'swing' => 'swing',
                    'tada' => 'tada',
                    'wobble' => 'wobble',
                    'jello' => 'jello',
                    'bounceIn' => 'bounceIn',
                    'bounceInDown' => 'bounceInDown',
                    'bounceInUp' => 'bounceInUp',
                    'bounceOut' => 'bounceOut',
                    'bounceOutDown' => 'bounceOutDown',
                    'bounceOutLeft' => 'bounceOutLeft',
                    'bounceOutRight' => 'bounceOutRight',
                    'bounceOutUp' => 'bounceOutUp',
                    'fadeIn' => 'fadeIn',
                    'fadeInDown' => 'fadeInDown',
                    'fadeInDownBig' => 'fadeInDownBig',
                    'fadeInLeft' => 'fadeInLeft',
                    'fadeInLeftBig' => 'fadeInLeftBig',
                    'fadeInRightBig' => 'fadeInRightBig',
                    'fadeInUp' => 'fadeInUp',
                    'fadeInUpBig' => 'fadeInUpBig',
                    'fadeOut' => 'fadeOut',
                    'fadeOutDown' => 'fadeOutDown',
                    'fadeOutDownBig' => 'fadeOutDownBig',
                    'fadeOutLeft' => 'fadeOutLeft',
                    'fadeOutLeftBig' => 'fadeOutLeftBig',
                    'fadeOutRightBig' => 'fadeOutRightBig',
                    'fadeOutUp' => 'fadeOutUp',
                    'fadeOutUpBig' => 'fadeOutUpBig',
                    'flip' => 'flip',
                    'flipInX' => 'flipInX',
                    'flipInY' => 'flipInY',
                    'flipOutX' => 'flipOutX',
                    'flipOutY' => 'flipOutY',
                    'fadeOutDown' => 'fadeOutDown',
                    'lightSpeedIn' => 'lightSpeedIn',
                    'lightSpeedOut' => 'lightSpeedOut',
                    'rotateIn' => 'rotateIn',
                    'rotateInDownLeft' => 'rotateInDownLeft',
                    'rotateInDownRight' => 'rotateInDownRight',
                    'rotateInUpLeft' => 'rotateInUpLeft',
                    'rotateInUpRight' => 'rotateInUpRight',
                    'rotateOut' => 'rotateOut',
                    'rotateOutDownLeft' => 'rotateOutDownLeft',
                    'rotateOutDownRight' => 'rotateOutDownRight',
                    'rotateOutUpLeft' => 'rotateOutUpLeft',
                    'rotateOutUpRight' => 'rotateOutUpRight',
                    'slideInUp' => 'slideInUp',
                    'slideInDown' => 'slideInDown',
                    'slideInLeft' => 'slideInLeft',
                    'slideInRight' => 'slideInRight',
                    'slideOutUp' => 'slideOutUp',
                    'slideOutDown' => 'slideOutDown',
                    'slideOutLeft' => 'slideOutLeft',
                    'slideOutRight' => 'slideOutRight',
                    'zoomIn' => 'zoomIn',
                    'zoomInDown' => 'zoomInDown',
                    'zoomInLeft' => 'zoomInLeft',
                    'zoomInRight' => 'zoomInRight',
                    'zoomInUp' => 'zoomInUp',
                    'zoomOut' => 'zoomOut',
                    'zoomOutDown' => 'zoomOutDown',
                    'zoomOutLeft' => 'zoomOutLeft',
                    'zoomOutUp' => 'zoomOutUp',
                    'hinge' => 'hinge',
                    'rollIn' => 'rollIn',
                    'rollOut' => 'rollOut'
                ],
                'condition' => [
                    'image_effect' => 'css_animation',
                ],
            ]
        );

        $repeater->add_control(
            'animation_name_iteration_count',
            [
                'label' => esc_html__('Animation Iteration Count', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => ['image_effect' => 'css_animation'],
                'options' => [
                    'infinite' => esc_html__('Infinite', 'gostudy-core'),
                    '1' => esc_html__('1', 'gostudy-core'),
                ],
                'default' => '1',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'animation-iteration-count: {{VALUE}};'
                ],
            ]
        );

        $repeater->add_control(
            'animation_name_speed',
            [
                'label' => esc_html__('Animation speed', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'condition' => ['image_effect' => 'css_animation'],
                'min' => 1,
                'step' => 100,
                'default' => '1',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'animation-duration: {{VALUE}}s;'
                ],
            ]
        );

        $repeater->add_control(
            'animation_name_direction',
            [
                'label' => esc_html__('Animation Direction', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => ['image_effect' => 'css_animation'],
                'options' => [
                    'normal' => esc_html__('Normal', 'gostudy-core'),
                    'reverse' => esc_html__('Reverse', 'gostudy-core'),
                    'alternate' => esc_html__('Alternate', 'gostudy-core'),
                ],
                'default' => 'normal',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'animation-direction: {{VALUE}};'
                ],
            ]
        );

        $repeater->add_control(
            'image_bg',
            [
                'label' => esc_html__('Parallax Image', 'gostudy-core'),
                'type' => Controls_Manager::MEDIA,
                'label_block' => true,
                'default' => ['url' => ''],
            ]
        );

        $repeater->add_control(
            'parallax_dir',
            [
                'label' => esc_html__('Parallax Direction', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => ['image_effect' => 'scroll'],
                'options' => [
                    'vertical' => esc_html__('Vertical', 'gostudy-core'),
                    'horizontal' => esc_html__('Horizontal', 'gostudy-core'),
                ],
                'default' => 'vertical',
            ]
        );

        $repeater->add_control(
            'parallax_factor',
            [
                'label' => esc_html__('Parallax Factor', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'description' => esc_html__('Set elements offset and speed. It can be positive (0.3) or negative (-0.3). Less means slower.', 'gostudy-core'),
                'min' => -3,
                'max' => 3,
                'step' => 0.01,
                'default' => 0.03,
            ]
        );

        $repeater->add_responsive_control(
            'position_top',
            [
                'label' => esc_html__('Top Offset', 'gostudy-core'),
                'type' => Controls_Manager::SLIDER,
                'description' => esc_html__('Set figure vertical offset from top border.', 'gostudy-core'),
                'size_units' => ['%', 'px'],
                'range' => [
                    '%' => ['min' => -100, 'max' => 100],
                    'px' => ['min' => -200, 'max' => 1000, 'step' => 5],
                ],
                'default' => [ 'size' => 0, 'unit' => '%' ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'top: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'position_left',
            [
                'label' => esc_html__('Left Offset', 'gostudy-core'),
                'type' => Controls_Manager::SLIDER,
                'description' => esc_html__('Set figure horizontal offset from left border.', 'gostudy-core'),
                'size_units' => ['%', 'px'],
                'range' => [
                    '%' => ['min' => -100, 'max' => 100],
                    'px' => ['min' => -200, 'max' => 1000, 'step' => 5],
                ],
                'default' => ['size' => 0, 'unit' => '%'],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'left: {{SIZE}}{{UNIT}}',

                ],
            ]
        );

        $repeater->add_control(
            'image_index',
            [
                'label' => esc_html__('Image z-index', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'default' => -1,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'z-index: {{UNIT}};',
                ],
            ]
        );

        $repeater->add_control(
            'hide_on_mobile',
            [
                'label' => esc_html__('Hide On Mobile?', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );
        $repeater->add_control(
            'hide_mobile_resolution',
            [
                'label' => esc_html__('Screen Resolution', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'condition' => ['hide_on_mobile' => 'yes'],
                'default' => 768,
            ]
        );

        $widget->add_control(
            'items_parallax',
            [
                'label' => esc_html__('Layers', 'gostudy-core'),
                'type' => Controls_Manager::REPEATER,
                'condition' => [ 'add_background_animation' => 'yes' ],
                'fields' => $repeater->get_controls(),
            ]
        );

        $widget->end_controls_section();

        $widget->start_controls_section(
            'extened_shape',
            [
                'label' => esc_html__('RT Shape Divider', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $widget->start_controls_tabs('tabs_rt_shape_dividers');

        $shapes_options = [
            '' => esc_html__('None', 'gostudy-core'),
            'torn_line' => esc_html__('Torn Line', 'gostudy-core'),
        ];

        foreach ([
            'top' => esc_html__('Top', 'gostudy-core'),
            'bottom' => esc_html__('Bottom', 'gostudy-core'),
        ] as $side => $side_label) {
            $base_control_key = "rt_shape_divider_$side";

            $widget->start_controls_tab(
                "tab_$base_control_key",
                [
                    'label' => $side_label,
                ]
            );

            $widget->add_control(
                $base_control_key,
                [
                    'label' => esc_html__('Type', 'gostudy-core'),
                    'type' => Controls_Manager::SELECT,
                    'options' => $shapes_options,
                ]
            );

            $widget->add_control(
                $base_control_key . '_color',
                [
                    'label' => esc_html__('Color', 'gostudy-core'),
                    'type' => Controls_Manager::COLOR,
                    'condition' => [ "rt_shape_divider_$side!" => '' ],
                    'dynamic' => ['active' => true],
                    'selectors' => [
                        "{{WRAPPER}} > .rt-elementor-shape-$side path" => 'fill: {{VALUE}};',
                    ],
                ]
            );

            $widget->add_responsive_control(
                $base_control_key . '_height',
                [
                    'label' => esc_html__('Height', 'gostudy-core'),
                    'type' => Controls_Manager::SLIDER,
                    'condition' => [ "rt_shape_divider_$side!" => '' ],
                    'range' => [
                        'px' => ['max' => 500],
                    ],
                    'selectors' => [
                        "{{WRAPPER}} > .rt-elementor-shape-$side svg" => 'height: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $widget->add_control(
                $base_control_key . '_flip',
                [
                    'label' => __('Flip', 'gostudy-core'),
                    'type' => Controls_Manager::SWITCHER,
                    'condition' => [ "rt_shape_divider_$side!" => '' ],
                    'selectors' => [
                        "{{WRAPPER}} > .rt-elementor-shape-$side svg" => 'transform: translateX(-50%) rotateY(180deg)',
                    ],
                ]
            );

            $widget->add_control(
                $base_control_key . '_invert',
                [
                    'label' => __('Invert', 'gostudy-core'),
                    'type' => Controls_Manager::SWITCHER,
                    'condition' => [ "rt_shape_divider_$side!" => '' ],
                    'selectors' => [
                        "{{WRAPPER}} > .rt-elementor-shape-$side" => 'transform: rotate(180deg);',
                    ],
                ]
            );

            $widget->add_control(
                $base_control_key . '_above_content',
                [
                    'label' => esc_html__('Z-index', 'gostudy-core'),
                    'type' => Controls_Manager::NUMBER,
                    'condition' => [ "rt_shape_divider_$side!" => '' ],
                    'default' => 0,
                    'selectors' => [
                        "{{WRAPPER}} > .rt-elementor-shape-$side" => 'z-index: {{UNIT}}',
                    ],
                ]
            );

            $widget->end_controls_tab();
        }

        $widget->end_controls_tabs();
        $widget->end_controls_section();

        $widget->start_controls_section(
            'extened_particles',
            [
                'label' => esc_html__('RT Particles', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $widget->add_control(
            'add_particles_animation',
            [
                'label' => esc_html__('Add Particles Animation?', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'particles_effect',
            [
                'label' => esc_html__('Style: ', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'one_color' => esc_html__('One Color', 'gostudy-core'),
                    'random_colors' => esc_html__('Random Colors', 'gostudy-core'),
                ],
                'default' => 'one_color',
            ]
        );

        $repeater->add_control(
            'particles_color_one',
            [
                'label' => esc_html__('Color 1', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'default' => Gostudy_Globals::get_primary_color(),
                'dynamic' => ['active' => true],
            ]
        );

        $repeater->add_control(
            'particles_color_second',
            [
                'label' => esc_html__('Color 2', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'condition' => ['particles_effect' => 'random_colors'],
                'dynamic' => ['active' => true],
            ]
        );

        $repeater->add_control(
            'particles_color_third',
            [
                'label' => esc_html__('Color 3', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'condition' => ['particles_effect' => 'random_colors'],
                'dynamic' => ['active' => true],
            ]
        );

        $repeater->add_control(
            'particles_count',
            [
                'label' => esc_html__('Count Of Particles', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'default' => 50,
            ]
        );

        $repeater->add_control(
            'particles_max_size',
            [
                'label' => esc_html__('Particles Max Size', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'default' => 10,
            ]
        );

        $repeater->add_control(
            'particles_speed',
            [
                'label' => esc_html__('Particles Speed', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'step' => .1,
                'default' => 2,
            ]
        );

        $repeater->add_control(
            'particles_line',
            [
                'label' => esc_html__('Add Linked Line?', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $repeater->add_control(
            'particles_hover_animation',
            [
                'label' => esc_html__('Hover Animation', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'grab' => esc_html__('Grab', 'gostudy-core'),
                    'bubble' => esc_html__('Bubble', 'gostudy-core'),
                    'repulse' => esc_html__('Repulse', 'gostudy-core'),
                    'none' => esc_html__('None', 'gostudy-core'),
                ],
                'default' => 'grab',
            ]
        );

        $repeater->add_responsive_control(
            'position_particles_top',
            [
                'label' => esc_html__('Top Offset', 'gostudy-core'),
                'type' => Controls_Manager::SLIDER,
                'description' => esc_html__('Set particles vertical offset from top border.', 'gostudy-core'),
                'size_units' => ['%', 'px'],
                'range' => [
                    '%' => ['min' => -100, 'max' => 100],
                    'px' => ['min' => -200, 'max' => 1000, 'step' => 5],
                ],
                'default' => [ 'size' => 0, 'unit' => '%' ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'top: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'position_particles_left',
            [
                'label' => esc_html__('Left Offset', 'gostudy-core'),
                'type' => Controls_Manager::SLIDER,
                'description' => esc_html__('Set particles horizontal offset from left border.', 'gostudy-core'),
                'size_units' => ['%', 'px'],
                'range' => [
                    '%' => ['min' => -100, 'max' => 100],
                    'px' => ['min' => -200, 'max' => 1000, 'step' => 5],
                ],
                'default' => ['size' => 0, 'unit' => '%'],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'left: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $repeater->add_control(
            'particles_width',
            [
                'label' => esc_html__('Width', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'description' => esc_html__('Set particles container width in percent.', 'gostudy-core'),
                'min' => 0,
                'max' => 100,
                'default' => 100,
            ]
        );

        $repeater->add_control(
            'particles_height',
            [
                'label' => esc_html__('Height', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'description' => esc_html__('Set particles container height in percent.', 'gostudy-core'),
                'min' => 0,
                'max' => 100,
                'default' => 100,
            ]
        );

        $repeater->add_control(
            'hide_particles_on_mobile',
            [
                'label' => esc_html__('Hide On Mobile?', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'gostudy-core'),
                'label_off' => esc_html__('Off', 'gostudy-core'),
            ]
        );

        $repeater->add_control(
            'hide_particles_mobile_resolution',
            [
                'label' => esc_html__('Screen Resolution', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'condition' => ['hide_particles_on_mobile' => 'yes'],
                'default' => 768,
            ]
        );

        $widget->add_control(
            'items_particles',
            [
                'label' => esc_html__('Particles', 'gostudy-core'),
                'type' => Controls_Manager::REPEATER,
                'condition' => [ 'add_particles_animation' => 'yes' ],
                'fields' => $repeater->get_controls(),
            ]
        );

        $widget->end_controls_section();


        $widget->start_controls_section(
            'extened_particles_img',
            [
                'label' => esc_html__('RT Particles Image', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $widget->add_control(
            'add_particles_img_animation',
            [
                'label' => esc_html__('Add Particles Animation?', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'particles_image',
            [
                'label' => esc_html__('Image', 'gostudy-core'),
                'type' => Controls_Manager::MEDIA,
                'label_block' => true,
                'default' => [ 'url' => Utils::get_placeholder_image_src() ],
            ]
        );

        $repeater->add_control(
            'particles_img_width',
            [
                'label' => esc_html__('Image Width', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'description' => esc_html__('Set particles img width in px.', 'gostudy-core'),
                'min' => 0,
                'max' => 1000,
                'default' => 100,
            ]
        );

        $repeater->add_control(
            'particles_img_height',
            [
                'label' => esc_html__('Image Height', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'description' => esc_html__('Set particles img height in px.', 'gostudy-core'),
                'min' => 0,
                'max' => 1000,
                'default' => 100,
            ]
        );

        $widget->add_control(
            'items_particles_img',
            [
                'label' => esc_html__('Particles Image', 'gostudy-core'),
                'type' => Controls_Manager::REPEATER,
                'condition' => [ 'add_particles_img_animation' => 'yes' ],
                'fields' => $repeater->get_controls(),
            ]
        );

        $widget->add_control(
            'particles_img_color',
            [
                'label' => esc_html__('Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'condition' => [ 'add_particles_img_animation' => 'yes' ],
            ]
        );

        $widget->add_control(
            'particles_img_max_size',
            [
                'label' => esc_html__('Particles Max Size', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'default' => 60,
                'condition' => [ 'add_particles_img_animation' => 'yes' ],
            ]
        );

        $widget->add_control(
            'particles_img_count',
            [
                'label' => esc_html__('Count Of Particles', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'default' => 50,
                'condition' => [ 'add_particles_img_animation' => 'yes' ],
            ]
        );

        $widget->add_control(
            'particles_img_speed',
            [
                'label' => esc_html__('Particles Speed', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'step' => .1,
                'default' => 2,
                'condition' => [ 'add_particles_img_animation' => 'yes' ],
            ]
        );

        $widget->add_control(
            'particles_img_line',
            [
                'label' => esc_html__('Add Linked Line?', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => [ 'add_particles_img_animation' => 'yes' ],
            ]
        );

        $widget->add_control(
            'particles_img_rotate',
            [
                'label' => esc_html__('Add Rotate Animation?', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => [ 'add_particles_img_animation' => 'yes' ],
            ]
        );

        $widget->add_control(
            'particles_img_rotate_speed',
            [
                'label' => esc_html__('Rotate Speed Animation', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'step' => .1,
                'default' => 5,
                'condition' => [
                    'particles_img_rotate' => 'yes',
                    'add_particles_img_animation' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'particles_img_hover_animation',
            [
                'label' => esc_html__('Hover Animation', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'grab' => esc_html__('Grab', 'gostudy-core'),
                    'bubble' => esc_html__('Bubble', 'gostudy-core'),
                    'repulse' => esc_html__('Repulse', 'gostudy-core'),
                    'none' => esc_html__('None', 'gostudy-core'),
                ],
                'default' => 'grab',
                'condition' => [ 'add_particles_img_animation' => 'yes' ],
            ]
        );

        $widget->add_responsive_control(
            'position_particles_img_top',
            [
                'label' => esc_html__('Top Offset', 'gostudy-core'),
                'type' => Controls_Manager::SLIDER,
                'description' => esc_html__('Set particles vertical offset from top border.', 'gostudy-core'),
                'size_units' => ['%', 'px'],
                'range' => [
                    '%' => ['min' => -100, 'max' => 100],
                    'px' => ['min' => -200, 'max' => 1000, 'step' => 5],
                ],
                'default' => [ 'size' => 0, 'unit' => '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rt-particles-img-js' => 'top: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [ 'add_particles_img_animation' => 'yes' ],
            ]
        );

        $widget->add_responsive_control(
            'position_particles_img_left',
            [
                'label' => esc_html__('Left Offset', 'gostudy-core'),
                'type' => Controls_Manager::SLIDER,
                'description' => esc_html__('Set particles horizontal offset from left border.', 'gostudy-core'),
                'size_units' => ['%', 'px'],
                'range' => [
                    '%' => ['min' => -100, 'max' => 100],
                    'px' => ['min' => -200, 'max' => 1000, 'step' => 5],
                ],
                'default' => ['size' => 0, 'unit' => '%'],
                'selectors' => [
                    '{{WRAPPER}} .rt-particles-img-js' => 'left: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [ 'add_particles_img_animation' => 'yes' ],
            ]
        );

        $widget->add_control(
            'particles_img_container_width',
            [
                'label' => esc_html__('Width', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'description' => esc_html__('Set particles container width in percent.', 'gostudy-core'),
                'min' => 0,
                'max' => 100,
                'default' => 100,
                'condition' => [ 'add_particles_img_animation' => 'yes' ],
            ]
        );

        $widget->add_control(
            'particles_img_container_height',
            [
                'label' => esc_html__('Height', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'description' => esc_html__('Set particles container height in percent.', 'gostudy-core'),
                'min' => 0,
                'max' => 100,
                'default' => 100,
                'condition' => [ 'add_particles_img_animation' => 'yes' ],
            ]
        );

        $widget->add_control(
            'hide_particles_img_on_mobile',
            [
                'label' => esc_html__('Hide On Mobile?', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'gostudy-core'),
                'label_off' => esc_html__('Off', 'gostudy-core'),
                'condition' => [ 'add_particles_img_animation' => 'yes' ],
            ]
        );

        $widget->add_control(
            'hide_particles_img_mobile_resolution',
            [
                'label' => esc_html__('Screen Resolution', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'condition' => ['hide_particles_img_on_mobile' => 'yes' , 'add_particles_img_animation' => 'yes'],
                'default' => 768,
            ]
        );

        $widget->end_controls_section();
    }

    public function extends_header_params($widget, $args)
    {
        $widget->start_controls_section(
            'extened_header',
            [
                'label' => esc_html__('RT Header Layout', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_LAYOUT
            ]
        );

        $widget->add_control(
            'apply_sticky_row',
            [
                'label' => esc_html__('Apply Sticky?', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'sticky-on',
                'prefix_class' => 'rt-',
            ]
        );

        $widget->end_controls_section();
    }

    public function extends_column_params($widget, $args)
    {

        $widget->start_controls_section(
            'extened_header',
            [
                'label' => esc_html__('RT Column Options', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_LAYOUT
            ]
        );

        $widget->add_control(
            'apply_sticky_column',
            [
                'label' => esc_html__('Enable Sticky?', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('On', 'gostudy-core'),
                'label_off' => esc_html__('Off', 'gostudy-core'),
                'return_value' => 'sidebar',
                'prefix_class' => 'sticky-',
            ]
        );

        $widget->end_controls_section();
    }
}
