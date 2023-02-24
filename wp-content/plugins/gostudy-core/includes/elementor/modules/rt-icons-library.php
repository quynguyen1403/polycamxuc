<?php

namespace RTAddons\Modules;

defined('ABSPATH') || exit;

use RTAddons\Includes\RT_Elementor_Helper;

/**
 * RT Elementor Custom Icon Control
 *
 *
 * @package gostudy-core\includes\elementor
 * @author RaisTheme <help.raistheme@gmail.com>
 * @since 1.0.0
 */
class RT_Icons_Library
{
    public function __construct()
    {
        add_filter('elementor/icons_manager/additional_tabs', [$this, 'extended_icons_library']);
    }

    public function extended_icons_library()
    {
        // global $wp_version;

        return [
            'rt_icons' => [
                'name' => 'rt_icons',
                'label' => esc_html__('RT Icons Library', 'gostudy-core'),
                // 'url' => get_template_directory_uri() . '/fonts/flaticon/flaticon.css',
                // 'enqueue' => [get_template_directory_uri() . '/fonts/flaticon/flaticon.css'],
                'prefix' => 'flaticon-',
                'displayPrefix' => 'flaticon',
                'labelIcon' => 'flaticon',
                // 'ver' => $wp_version,
                'icons' => RT_Elementor_Helper::get_instance()->get_rt_icons(),
                'native' => true,
            ]
        ];
    }
}
