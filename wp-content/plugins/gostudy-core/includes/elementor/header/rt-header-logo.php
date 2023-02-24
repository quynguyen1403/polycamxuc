<?php
namespace RTAddons\Widgets;

defined('ABSPATH') || exit; // Abort, If called directly.

use Elementor\{Widget_Base, Controls_Manager, Utils};

/**
 * Logo widget for Header CPT
 *
 *
 * @category Class
 * @package gostudy-core\includes\elementor
 * @author RaisTheme <help.raistheme@gmail.com>
 * @since 1.0.0
 */
class RT_Header_Logo extends Widget_Base
{
    public function get_name()
    {
        return 'rt-header-logo';
    }

    public function get_title()
    {
        return esc_html__('RT Logo', 'gostudy-core');
    }

    public function get_icon()
    {
        return 'rt-header-logo';
    }

    public function get_categories()
    {
        return ['rt-header-modules'];
    }

    protected function register_controls()
    {
        /*-----------------------------------------------------------------------------------*/
        /*  CONTENT -> GENERAL
        /*-----------------------------------------------------------------------------------*/

        $this->start_controls_section(
            'section_content_general',
            ['label' => esc_html__('General', 'gostudy-core')]
        );

        $this->add_control(
            'use_custom_logo',
            [
                'label' => esc_html__('Use Custom Logo?', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'custom_logo',
            [
                'label' => esc_html__('Custom Logo', 'gostudy-core'),
                'type' => Controls_Manager::MEDIA,
                'condition' => ['use_custom_logo!' => ''],
                'label_block' => true,
                'default' => ['url' => Utils::get_placeholder_image_src()],
            ]
        );

        $this->add_control(
            'enable_logo_height',
            [
                'label' => esc_html__('Enable Logo Height?', 'gostudy-core'),
                'type' => Controls_Manager::SWITCHER,
                'condition' => ['use_custom_logo!' => ''],
            ]
        );

        $this->add_control(
            'logo_height',
            [
                'label' => esc_html__('Logo Height', 'gostudy-core'),
                'type' => Controls_Manager::NUMBER,
                'condition' => [
                    'use_custom_logo!' => '',
                    'enable_logo_height!' => '',
                ],
                'min' => 1,
                'default' => 90,
            ]
        );

        $this->add_control(
            'logo_align',
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
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .rt-logotype-container' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    public function render()
    {
        $settings = $this->get_settings_for_display();
        extract($settings);

        $custom_size = false;

        $logo = !empty($custom_logo) ? $custom_logo : false;

        if (
            $logo
            && !empty($enable_logo_height)
            && !empty($logo_height)
        ) {
            $custom_size = $logo_height;
        }

        require_once (get_theme_file_path('/templates/header/components/logo.php'));

        new \Gostudy_Get_Logo('bottom', false, $logo, $custom_size);
    }
}
