<?php
namespace RTAddons\Widgets;

defined('ABSPATH') || exit; // Abort, If called directly.

use Elementor\{Plugin, Widget_Base, Controls_Manager, Group_Control_Typography, Group_Control_Box_Shadow};
use RTAddons\Gostudy_Global_Variables as Gostudy_Globals;
// use Gostudy_Get_Header as Header;
/**
 * Side Panel widget for Header CPT
 *
 *
 * @category Class
 * @package gostudy-core\includes\elementor
 * @author RaisTheme <help.raistheme@gmail.com>
 * @since 1.0.0
 */
class RT_Header_login_Join extends Widget_Base
{
    public function get_name() {
        return 'rt-header-login-join';
    }

    public function get_title() {
        return esc_html__('Login/Join Button', 'gostudy-core' );
    }

    public function get_icon() {
        return 'rt-header-lp-login';
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
            'section-login-join-settings',
            [
                'label' => esc_html__( 'Login/Join', 'gostudy-core' ),
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
                'default' => esc_html__('Login', 'gostudy-core'),
            ]
        );

        $this->add_control(
            'login_page_url',
            [
                'label' => esc_html__('Login Page URL', 'gostudy-core'),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_attr__('https://your-link.com', 'gostudy-core'),
                'default' => ['url' => '#'],
            ]
        );

        $this->add_control(
            'join_text',
            [
                'label' => esc_html__('Join Now', 'gostudy-core'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
                'default' => esc_html__('Join Now', 'gostudy-core'),
            ]
        );
        $this->add_control(
            'join_page_url',
            [
                'label' => esc_html__('Join Page URL', 'gostudy-core'),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_attr__('https://your-link.com', 'gostudy-core'),
                'default' => ['url' => '#'],
            ]
        );

        $this->add_control(
            'profile_text',
            [
                'label' => esc_html__('Profile', 'gostudy-core'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
                'default' => esc_html__('Profile', 'gostudy-core'),
            ]
        );
        $this->add_control(
            'profile_page_url',
            [
                'label' => esc_html__('Profile Page URL', 'gostudy-core'),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_attr__('https://your-link.com', 'gostudy-core'),
                'default' => ['url' => '#'],
            ]
        );

        $this->add_control(
            'logout_text',
            [
                'label' => esc_html__('Logout Text', 'gostudy-core'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => ['active' => true],
                'default' => esc_html__('Logout', 'gostudy-core'),
            ]
        );
        if (class_exists('SFWD_LMS')) {

        $this->add_control(
            'ld_popup_login',
            [
                'label' => esc_html__('LearnDash PopUp Login', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes'
            ]
        );

        }
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
                'selector' => '{{WRAPPER}} .login-join .login-join_wrapper a',
            ]
        );

        $this->end_controls_section();

        /**
        * Login
        */

        $this->start_controls_section(
            'login_section_style',
            [
                'label' => esc_html__('Login', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
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
                'default' => '#1b2336',
                'selectors' => [
                    '{{WRAPPER}} .login-join .login-join_wrapper a.login_link' => 'color: {{VALUE}}',
                ],
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
                'default' => Gostudy_Globals::get_primary_color(),
                'selectors' => [
                    '{{WRAPPER}} .login-join .login-join_wrapper a.login_link:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();


        /**
        * Join
        */

        $this->start_controls_section(
            'join_section_style',
            [
                'label' => esc_html__('Join/Logout', 'gostudy-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->start_controls_tabs(
            'join_sp_color_tabs',
            [
                'separator' => 'before',
            ]
        );
        $this->start_controls_tab(
            'join_tab_color_idle',
            [ 'label' => esc_html__('Idle' , 'gostudy-core') ]
        );

        $this->add_control(
            'join_color_idle',
            [
                'label' => esc_html__( 'Color', 'gostudy-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .login-join .login-join_wrapper .join_link' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .login-join .login-join_wrapper .logout_link' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'join_bg_idle',
            [
                'label' => esc_html__( 'Background', 'gostudy-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_btn_color_idle(),
                'selectors' => [
                    '{{WRAPPER}} .login-join .login-join_wrapper .join_link' => 'background: {{VALUE}}',
                    '{{WRAPPER}} .login-join .login-join_wrapper .logout_link' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'join_shadow_idle',
                'selector' => '{{WRAPPER}} .login-join .login-join_wrapper .join_link, .login-join .login-join_wrapper .logout_link',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'join_tab_color_hover',
            [ 'label' => esc_html__('Hover' , 'gostudy-core') ]
        );

        $this->add_control(
            'join_color_hover',
            [
                'label' => esc_html__( 'Color', 'gostudy-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .login-join .login-join_wrapper .join_link:hover' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .login-join .login-join_wrapper .logout_link:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'join_bg_hover',
            [
                'label' => esc_html__( 'Background', 'gostudy-core' ),
                'type' => Controls_Manager::COLOR,
                'dynamic' => ['active' => true],
                'default' => Gostudy_Globals::get_btn_color_hover(),
                'selectors' => [
                    '{{WRAPPER}} .login-join .login-join_wrapper .join_link:hover' => 'background: {{VALUE}}',
                    '{{WRAPPER}} .login-join .login-join_wrapper .logout_link:hover' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'join_shadow_hover',
                'selector' => '{{WRAPPER}} .login-join .login-join_wrapper .join_link:hover, .login-join .login-join_wrapper .logout_link:hover',
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control(
            'button_padding',
            [
                'label' => esc_html__('Padding', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .login-join .login-join_wrapper a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'button_margin',
            [
                'label' => esc_html__('Margin', 'gostudy-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => 0,
                    'left' => 15,
                    'right' => 0,
                    'bottom' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .login-join .login-join_wrapper a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->end_controls_section();
    }

    public function render()
    {

        $_ = $this->get_settings_for_display();

        $login_page_url = $_['login_page_url'];
        $join_page_url = $_['join_page_url'];
        $profile_page_url = $_['profile_page_url'];
        $profile_text = $_['profile_text'];
        $login_text = $_['login_text'];
        $join_text = $_['join_text'];
        $logout_text = $_['logout_text'];

          if (class_exists('SFWD_LMS')) {
            $ld_popup_login = $_['ld_popup_login'];
          }

        echo '<div class="login-join tutor">';
        echo '<span class="login-join_wrapper">';

       if (!is_user_logged_in()) :

        if (class_exists('SFWD_LMS') && $ld_popup_login) :
            echo '<span class="login_link_mobile">';
               echo do_shortcode('[learndash_login]');
            echo '</span>';
        else :
            echo '<a class="login_link', '" href="', esc_url($login_page_url['url']), '">',
               $login_text,
                '</a>';

            echo '<a class="join_link', '" href="', esc_url($join_page_url['url']), '">',
            $join_text,
            '</a>';
        endif;

       else :

        echo '<a class="login_link', '" href="', esc_url($profile_page_url['url']), '">',
           $profile_text,
            '</a>';

            echo '<a class="logout_link" href="',
                esc_url(wp_logout_url(apply_filters('gostudy_default_logout_redirect', (!empty($_SERVER['HTTPS']) ? "https" : "http") . '://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]))), '">',
                $logout_text,
                '</a>';
       endif;

        echo '</span>';
        echo '</div>';

    }
}