<?php
/*
 * This template can be overridden by copying it to yourtheme/gostudy-core/elementor/templates/rt-button.php.
*/
namespace RTAddons\Templates;

defined('ABSPATH') || exit; // Abort, if called directly.

use Elementor\Plugin;
use Elementor\Frontend;
use Elementor\Scheme_Color;
use RTAddons\Includes\RT_Icons;

if (!class_exists('RT_Button')) {
    /**
     * RT Elementor Button Template
     *
     *
     * @category Class
     * @package gostudy-core\includes\elementor
     * @author RaisTheme <help.raistheme@gmail.com>
     * @since 1.0.0
     */
    class RT_Button
    {
        private static $instance = null;
        public static function get_instance()
        {
            if (null == self::$instance) {
                self::$instance = new self();
            }

            return self::$instance;
        }

        public function render($self, $settings)
        {
            $self->add_render_attribute([
                'wrapper' => [
                    'class' => 'button-wrapper',
                ],
                'button' => [
                    'class' => [
                        'rt-button',
                        !empty($settings['size']) ? 'btn-size-' . $settings['size'] : '',
                        !empty($settings['hover_animation']) ? 'elementor-animation-' . $settings['hover_animation'] : '',
                    ],
                    'role' => 'button',
                ],
                'content-wrapper' => [
                    'class' => [
                        'button-content-wrapper',
                        !empty($settings['icon_align']) ? 'align-icon-' . $settings['icon_align'] : '',
                    ],
                ],
                'text' => [
                    'class' => 'rt-button-text',
                ],
            ] );

            if (!empty($settings['link']['url'])) {
                $self->add_link_attributes('button', $settings['link']);
            }

            // Render
            echo '<div ', $self->get_render_attribute_string('wrapper'), '>';
            echo '<a  ', $self->get_render_attribute_string('button'), '>';
            if (!empty($settings['text']) || !empty($settings['icon_type'])) {
                echo '<div ', $self->get_render_attribute_string('content-wrapper'), '>';

                if (!empty($settings['icon_type'])) {
                    $icons = new RT_Icons;
                    $button_icon_out = $icons->build($self, $settings, []);
                    echo $button_icon_out;
                }
                echo '<span ', $self->get_render_attribute_string('text'), '>',
                    $settings['text'],
                '</span>';

                echo '</div>';
            }
            echo '</a>';
            echo '</div>';
        }
    }
}
