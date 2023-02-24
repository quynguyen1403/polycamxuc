<?php
namespace RTAddons\Widgets;

defined('ABSPATH') || exit; // Abort, If called directly.

use Elementor\{Widget_Base, Controls_Manager, Group_Control_Typography, Group_Control_Box_Shadow};
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
class RT_Header_Wc_login extends Widget_Base
{
    public function get_name() {
        return 'rt-header-wc-login';
    }

    public function get_title() {
        return esc_html__('RT Wc Login Button', 'gostudy-core' );
    }

    public function get_icon() {
        return 'rt-header-wc-login';
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
            'section_wc-login_settings',
            [
                'label' => esc_html__( 'Wc Login', 'gostudy-core' ),
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => esc_html__('Button Text', 'gostudy-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'def' => esc_html__('Default', 'gostudy-core'),
                    'custom' => esc_html__('Custom', 'gostudy-core'),
                ],
                'default' => 'def',
            ]
        );

        $this->add_control(
            'login_text',
            [
                'label' => esc_html__('Login Text', 'gostudy-core'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
                'default' => esc_html__('WC LOGIN', 'gostudy-core'),
                'condition' => [
                    'button_text' => 'custom',
                ],
            ]
        );

        $this->add_control(
            'logout_text',
            [
                'label' => esc_html__('Logout Text', 'gostudy-core'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
                'default' => esc_html__('WC LOGOUT', 'gostudy-core'),
                'condition' => [
                    'button_text' => 'custom',
                ],
            ]
        );

        $this->end_controls_section();

        /**
        * STYLE
        */

        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__('Style', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typo',
                'selector' => '{{WRAPPER}} .login-in .login-in_wrapper a',
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label' => esc_html__('Padding', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .login-in .login-in_wrapper a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
            'color_idle',
            [
                'label' => esc_html__( 'Color', 'gostudy-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .login-in .login-in_wrapper a' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'bg_idle',
            [
                'label' => esc_html__( 'Background', 'gostudy-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .login-in .login-in_wrapper a' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'load_more_shadow_idle',
                'selector' => '{{WRAPPER}} .login-in .login-in_wrapper a',
                'fields_options' => [
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 5,
                            'vertical' => 4,
                            'blur' => 13,
                            'spread' => 0,
                            'color' => 'rgba(' . \Gostudy_Theme_Helper::HexToRGB(Gostudy_Globals::get_primary_color()) . ', 0.45)',
                        ]
                    ]
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_color_hover',
            [ 'label' => esc_html__('Hover' , 'gostudy-core') ]
        );

        $this->add_control(
            'color_hover',
            [
                'label' => esc_html__( 'Color', 'gostudy-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .login-in .login-in_wrapper a:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'bg_hover',
            [
                'label' => esc_html__( 'Background', 'gostudy-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_secondary_color(),
                'selectors' => [
                    '{{WRAPPER}} .login-in .login-in_wrapper a:hover' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'load_more_shadow_hover',
                'selector' => '{{WRAPPER}} .login-in .login-in_wrapper a:hover',
                'fields_options' => [
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 5,
                            'vertical' => 4,
                            'blur' => 13,
                            'spread' => 0,
                            'color' => 'rgba(' . \Gostudy_Theme_Helper::HexToRGB(Gostudy_Globals::get_secondary_color()) . ', 0.45)',
                        ]
                    ]
                ]
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
        $_ = $this->get_settings_for_display();

        $logout_text = esc_html__('WC LOGOUT', 'gostudy-core');
        $login_text = esc_html__('WC LOGIN', 'gostudy-core');
        if ($_['button_text'] == 'custom') {
            $logout_text = !empty($_['logout_text']) ? $_['logout_text'] : $logout_text;
            $login_text = !empty($_['login_text']) ? $_['login_text'] : $login_text;
        }
        $link = get_permalink( get_option('woocommerce_myaccount_page_id') );
        $query_args = [
            'action' => urlencode('signup_form'),
        ];
        $url = add_query_arg($query_args, $link);

        $link_logout = wp_logout_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) );
        echo '<div class="login-in woocommerce">';

            echo '<span class="login-in_wrapper">';
            if (is_user_logged_in()) {
                echo "<a class='login-in_link-logout' href='", esc_url($link_logout), "'>", $logout_text, "</a>";
            } else {
                echo "<a class='login-in_link' href='", esc_url_raw($url), "'>", $login_text, '</a>';
            }

            echo '</span>';

            echo '<div class="login-modal rt_modal-window">';
                echo '<div class="overlay"></div>';
                echo '<div class="modal-dialog modal_window-login">';
                    echo '<div class="modal_header"></div>';
                    echo '<div class="modal_content">';
                        wc_get_template('myaccount/form-login.php');
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
    }
}