<?php
namespace RTAddons\Widgets;

defined('ABSPATH') || exit; // Abort, If called directly.

use Elementor\{Widget_Base, Controls_Manager};
use RTAddons\Gostudy_Global_Variables as Gostudy_Globals;

/**
 * Side Panel widget for Header CPT
 *
 *
 * @category Class
 * @package gostudy-core\includes\elementor
 * @author RaisTheme <help.raistheme@gmail.com>
 * @since 1.0.0
 */
class RT_Header_Side_panel extends Widget_Base
{
    public function get_name() {
        return 'rt-header-side_panel';
    }

    public function get_title() {
        return esc_html__('RT Side Panel Button', 'gostudy-core' );
    }

    public function get_icon() {
        return 'rt-header-side_panel';
    }

    public function get_categories() {
        return [ 'rt-header-modules' ];
    }

    public function get_script_depends() {
        return [ 'rt-elementor-extensions-widgets' ];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_side_panel_settings',
            [
                'label' => esc_html__( 'Side Panel', 'gostudy-core' ),
            ]
        );

        $this->add_responsive_control(
            'sp_width',
            [
                'label' => esc_html__( 'Item Width', 'gostudy-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [ 'min' => 30, 'max' => 200 ],
                    '%' => [ 'min' => 5, 'max' => 100 ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'sp_height',
            [
                'label' => esc_html__( 'Item Height', 'gostudy-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [ 'min' => 30, 'max' => 250 ],
                    '%' => [ 'min' => 5, 'max' => 100 ],
                ],
                'selectors' => [
                    '{{WRAPPER}}' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'alignment',
            [
                'label' => esc_html__( 'Alignment', 'gostudy-core' ),
                'type' => Controls_Manager::CHOOSE,
                'condition' => [ 'sp_width!' => 0 ],
                'options' => [
                    'margin-right' => [
                        'title' => esc_html__( 'Left', 'gostudy-core' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'margin' => [
                        'title' => esc_html__( 'Center', 'gostudy-core' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'margin-left' => [
                        'title' => esc_html__( 'Right', 'gostudy-core' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}}' => '{{VALUE}}: auto;',
                ],

            ]
        );

        $this->start_controls_tabs(
            'sp_color_tabs',
            [
                'separator' => 'before',
            ]
        );

        $this->start_controls_tab(
            'tab_color_idle',
            [ 'label' => esc_html__('Idle' , 'gostudy-core') ]
        );

        $this->add_control(
            'icon_color_idle',
            [
                'label' => esc_html__( 'Icon Color', 'gostudy-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .side_panel' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_bg_idle',
            [
                'label' => esc_html__( 'Item Background', 'gostudy-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .side_panel' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_color_hover',
            [ 'label' => esc_html__('Hover' , 'gostudy-core') ]
        );

        $this->add_control(
            'icon_color_hover',
            [
                'label' => esc_html__( 'Icon Color', 'gostudy-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}}:hover .side_panel' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'item_bg_hover',
            [
                'label' => esc_html__( 'Item Background', 'gostudy-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}}:hover .side_panel' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }


    public function render()
    {
        echo '<div class="side_panel">',
            '<div class="side_panel_inner">',
                '<a href="#" class="side_panel-toggle">',
                    '<span class="side_panel-toggle-inner">',
                        '<span></span>',
                        '<span></span>',
                        '<span></span>',
                    '</span>',
                '</a>',
            '</div>',
        '</div>';
    }
}