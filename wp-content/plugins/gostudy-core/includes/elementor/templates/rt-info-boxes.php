<?php
/*
 * This template can be overridden by copying it to yourtheme/gostudy-core/elementor/templates/rt-info-boxes.php.
*/
namespace RTAddons\Templates;

defined('ABSPATH') || exit; // Abort, if called directly.

use RTAddons\Includes\RT_Icons;

/**
 * RT Elementor Info Boxes Template
 *
 *
 * @category Class
 * @package gostudy-core\includes\elementor
 * @author RaisTheme <help.raistheme@gmail.com>
 * @since 1.0.0
 */
class RTInfoBoxes
{
    private static $instance = null;

    public static function get_instance()
    {
        if (null == self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function render($self, $atts)
    {
        extract($atts);

        $ib_media = $infobox_content = $ib_button = $module_link_html = '';

        $wrapper_classes = $layout ? ' rt-layout-' . $layout : '';

        $kses_allowed_html = [
            'a' => [
                'href' => true, 'title' => true,
                'class' => true, 'style' => true,
                'rel' => true, 'target' => true
            ],
            'br' => ['class' => true, 'style' => true],
            'em' => ['class' => true, 'style' => true],
            'strong' => ['class' => true, 'style' => true],
            'span' => ['class' => true, 'style' => true],
            'small' => ['class' => true, 'style' => true],
            'p' => ['class' => true, 'style' => true],
        ];

        // Title
        $infobox_title = '<div class="rt-infobox-title_wrapper">';
        $infobox_title .= !empty($ib_subtitle) ? '<div class="rt-infobox_subtitle">' . wp_kses($ib_subtitle, $kses_allowed_html) . '</div>' : '';
        $infobox_title .= !empty($ib_title) ? '<' . esc_attr($title_tag) . ' class="rt-infobox_title">' : '';
        $infobox_title .= !empty($ib_title) ? '<span class="rt-infobox_title-idle">' . wp_kses($ib_title, $kses_allowed_html) . '</span>' : '';
        $infobox_title .= (!empty($ib_title) && !empty($ib_title_add)) ? '<span class="rt-infobox_title-add">' . wp_kses($ib_title_add, $kses_allowed_html) . '</span>' : '';
        $infobox_title .= !empty($ib_title) ? '</' . esc_attr($title_tag) . '>' : '';
        $infobox_title .= '</div>';

        // Content
        if (!empty($ib_content)) {
            $infobox_content = '<' . esc_attr($content_tag) . ' class="rt-infobox_content">';
            $infobox_content .= $ib_content;
            $infobox_content .= '</' . esc_attr($content_tag) . '>';
        }

        // Media
        if (!empty($icon_type)) {
            $media = new RT_Icons;
            $ib_media .= $media->build($self, $atts, []);
        }

        // Link
        if (!empty($link['url'])) {
            $self->add_link_attributes('link', $link);
        }

        // Read more button
        if ($add_read_more) {
            $self->add_render_attribute('btn', 'class', 'rt-infobox_button button-read-more');

            $ib_button = '<div class="rt-infobox-button_wrapper">';
            $ib_button .= sprintf(
                '<%s %s %s>',
                $module_link ? 'div' : 'a',
                $module_link ? '' : $self->get_render_attribute_string('link'),
                $self->get_render_attribute_string('btn')
            );
            $ib_button .= $read_more_text ? '<span>' . esc_html($read_more_text) . '</span>' : '';
            $ib_button .= $module_link ? '</div>' : '</a>';
            $ib_button .= '</div>';
        }

        if ($module_link && !empty($link['url'])) {
            $module_link_html = '<a class="rt-infobox__link" ' . $self->get_render_attribute_string('link') . '></a>';
        }

        // Render
        echo $module_link_html,
            '<div class="rt-infobox">',
                '<div class="rt-infobox_wrapper', esc_attr($wrapper_classes), '">',
                    $ib_media,
                    '<div class="content_wrapper">',
                        $infobox_title,
                        $infobox_content,
                        $read_more_inline ? '' : $ib_button,
                    '</div>',
                    $read_more_inline ? $ib_button : '',
                '</div>',
            '</div>';
    }
}
