<?php
/*
 * This template can be overridden by copying it to yourtheme/gostudy-core/elementor/templates/rt-cat-boxes.php.
*/
namespace RTAddons\Templates;

defined('ABSPATH') || exit; // Abort, if called directly.

use RTAddons\Includes\RT_Icons;

/**
 * RT Elementor Cat Boxes Template
 *
 *
 * @category Class
 * @package gostudy-core\includes\elementor
 * @author RaisTheme <help.raistheme@gmail.com>
 * @since 1.0.0
 */
class RTCatBoxes
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

        $ib_media = $ib_button = $module_link_html = '';

        $icon_img_shape_class = $icon_img_shape ? ' rt-image-shape-' . $icon_img_shape : '';
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
        $catbox_title = '<div class="rt-catbox-title_wrapper">';
        $catbox_title .= !empty($ib_subtitle) ? '<div class="rt-catbox_subtitle">' . wp_kses($ib_subtitle, $kses_allowed_html) . '</div>' : '';
        $catbox_title .= !empty($ib_title) ? '<' . esc_attr($title_tag) . ' class="rt-catbox_title">' : '';
        $catbox_title .= !empty($ib_title) ? '<span class="rt-catbox_title-idle">' . wp_kses($ib_title, $kses_allowed_html) . '</span>' : '';
        $catbox_title .= (!empty($ib_title) && !empty($ib_title_add)) ? '<span class="rt-catbox_title-add">' . wp_kses($ib_title_add, $kses_allowed_html) . '</span>' : '';
        $catbox_title .= !empty($ib_title) ? '</' . esc_attr($title_tag) . '>' : '';
        $catbox_title .= '</div>';


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
            $self->add_render_attribute('btn', 'class', 'rt-catbox_button');

            $ib_button = '<div class="rt-catbox-button_wrapper">';
            $ib_button .= sprintf(
                '<%s %s %s>',
                $link['url'] ? 'div' : 'a',
                $link['url'] ? '' : $self->get_render_attribute_string('link'),
                $self->get_render_attribute_string('btn')
            );
            $ib_button .= $read_more_text ? '<span>' . esc_html($read_more_text) . '</span>' : '';
            $ib_button .= $link['url'] ? '</div>' : '</a>';
            $ib_button .= '</div>';
        }

        if (!empty($link['url'])) {
            $module_link_html = '<a class="rt-catbox__link" ' . $self->get_render_attribute_string('link') . '>';
        }
        if (!empty($link['url'])) {
            $module_link_html_2 = '</a>';
        }

        // Render
        echo "$module_link_html";

        echo '<div class="rt-catbox">',
                '<div class="rt-catbox_wrapper', esc_attr($wrapper_classes . $icon_img_shape_class), '">',
                    $ib_media,
                    '<div class="content_wrapper">',
                        $catbox_title,
                        '<div class="rt-catbox-lesson_wrapper">',
                        $total_lesson,
                        '</div>',
                        // $read_more_inline ? '' : $ib_button,
                    '</div>',
                      $ib_button,
                '</div>',
            '</div>';
            
        echo "$module_link_html_2";
   
    }
}
