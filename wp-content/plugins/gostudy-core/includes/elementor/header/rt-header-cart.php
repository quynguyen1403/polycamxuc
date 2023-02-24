<?php
namespace RTAddons\Widgets;

defined('ABSPATH') || exit; // Abort, If called directly.

use Elementor\{Plugin, Widget_Base, Controls_Manager};
use RTAddons\Gostudy_Global_Variables as Gostudy_Globals;

/**
 * Cart widget for Header CPT
 *
 *
 * @category Class
 * @package gostudy-core\includes\elementor
 * @author RaisTheme <help.raistheme@gmail.com>
 * @since 1.0.0
 */
class RT_Header_Cart extends Widget_Base
{
    public function get_name() {
        return 'rt-header-cart';
    }

    public function get_title() {
        return esc_html__('WooCart', 'gostudy-core');
    }

    public function get_icon() {
        return 'rt-header-cart';
    }

    public function get_categories() {
        return [ 'rt-header-modules' ];
    }

    public function get_script_depends() {
        return [
            'rt-elementor-extensions-widgets',
        ];
    }

    protected function register_controls()
    {
        /*-----------------------------------------------------------------------------------*/
        /*  CONTENT -> GENERAL
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_search_settings',
            [ 'label' => esc_html__('General', 'gostudy-core') ]
        );

        $this->add_control(
            'cart_height',
            [
                'label' => esc_html__('Cart Icon Height', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => [
                    '{{WRAPPER}} .mini-cart' => 'height: {{VALUE}}px;',
                ],
            ]
        );

        $this->add_control(
            'cart_align',
            [
                'label' => esc_html__('Alignment', 'gostudy-core'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'toggle' => true,
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
                'selectors' => [
                    '{{WRAPPER}} .rt-mini-cart_wrapper' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*  STYLE -> GENERAL
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_style_general',
            [
                'label' => esc_html__('General', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('icon_style_tabs');

        $this->start_controls_tab(
            'tab_idle',
            [ 'label' => esc_html__('Idle' , 'gostudy-core') ]
        );

        $this->add_control(
            'icon_color_idle',
            [
                'label' => esc_html__('Icon Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_h_font_color(),
                'selectors' => [
                    '{{WRAPPER}} .mini-cart .rt-cart' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'counter_bg_idle',
            [
                'label' => esc_html__('Items Counter Background', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .woo_mini-count > span' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_hover',
            [ 'label' => esc_html__('Hover' , 'gostudy-core') ]
        );

        $this->add_control(
            'icon_color_hover',
            [
                'label' => esc_html__('Icon Color', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .mini-cart:hover .rt-cart' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'counter_bg_hover',
            [
                'label' => esc_html__('Items Counter Background', 'gostudy-core'),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'selectors' => [
                    '{{WRAPPER}} .mini-cart:hover .woo_mini-count > span' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }

    public function render()
    {
        if (!class_exists('\WooCommerce')) {
            return;
        }

        echo '<div class="rt-mini-cart_wrapper">',
            '<div class="mini-cart woocommerce">',
                $this->icon_cart(),
                self::woo_cart(),
            '</div>',
        '</div>';
    }

    public function icon_cart()
    {
        ob_start();
        $link = function_exists('wc_get_cart_url') ? wc_get_cart_url() : \WooCommerce::instance()->cart->get_cart_url();

        $this->add_render_attribute('cart', 'class', 'rt-cart woo_icon elementor-cart');
        $this->add_render_attribute('cart', 'role', 'button' );
        $this->add_render_attribute('cart', 'title', esc_attr__('Click to open Shopping Cart', 'gostudy-core')); ?>

        <a <?php echo \Gostudy_Theme_Helper::render_html($this->get_render_attribute_string('cart')); ?>>
            <span class="woo_mini-count flaticon flaticon-shopping-cart"><?php
                if ((!(bool) Plugin::$instance->editor->is_edit_mode())) {
                    echo \WooCommerce::instance()->cart->cart_contents_count > 0
                        ? '<span>' . esc_html( \WooCommerce::instance()->cart->cart_contents_count ) .'</span>'
                        : '';
                } ?>
            </span>
        </a><?php

        return ob_get_clean();
    }

    public static function woo_cart()
    {
        ob_start(); ?>
        <div class="rt-woo_mini_cart"><?php
        if (!(bool) Plugin::$instance->editor->is_edit_mode() ) {
            woocommerce_mini_cart();
        } ?>
        </div><?php

        return ob_get_clean();
    }
}