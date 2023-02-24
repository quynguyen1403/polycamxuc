<?php
/*
 * This template can be overridden by copying it to yourtheme/gostudy-core/elementor/templates/rt-slider.php.
*/
namespace RTAddons\Templates;

defined('ABSPATH') || exit;

use RTAddons\Includes\RT_Carousel_Settings;

if (!class_exists('RTSlider')) {
    /**
     * RT Elementor Testimonials Template
     *
     *
     * @category Class
     * @package gostudy-core\includes\elementor
     * @author RaisTheme <help.raistheme@gmail.com>
     * @since 1.0.0
     */
    class RTSlider
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
            $carousel_options = [];
            extract($atts);

            if ($use_carousel) {
                $carousel_options = [
                    'motion_style' => $motion_style,
                    'motion_rotate_by_scroll' => $motion_rotate_by_scroll,
                    'slide_to_show' => $posts_per_line,
                    'autoplay' => $autoplay,
                    'autoplay_speed' => $autoplay_speed,
                    'fade_animation' => $fade_animation,
                    'slides_to_scroll' => true,
                    'infinite' => true,
                    'use_pagination' => $use_pagination,
                    'pag_type' => $pag_type,
                    'pag_offset' => $pag_offset,
                    'pag_align' => $pag_align,
                    'custom_pag_color' => $custom_pag_color,
                    'pag_color' => $pag_color,
                    'use_prev_next' => $use_prev_next,
                    'prev_next_position' => $prev_next_position,
                    'custom_prev_next_color' => $custom_prev_next_color,
                    'prev_next_color' => $prev_next_color,
                    'prev_next_color_hover' => $prev_next_color_hover,
                    'prev_next_bg_idle' => $prev_next_bg_idle,
                    'prev_next_bg_hover' => $prev_next_bg_hover,
                    'custom_resp' => $custom_resp,
                    'resp_medium' => $resp_medium,
                    'resp_medium_slides' => $resp_medium_slides,
                    'resp_tablets' => $resp_tablets,
                    'resp_tablets_slides' => $resp_tablets_slides,
                    'resp_mobile' => $resp_mobile,
                    'resp_mobile_slides' => $resp_mobile_slides,
                ];

                wp_enqueue_script('slick', get_template_directory_uri() . '/js/slick.min.js');
            }

            switch ($posts_per_line) {
                case '1':
                    $col = 12;
                    break;
                case '2':
                    $col = 6;
                    break;
                case '3':
                    $col = 4;
                    break;
                case '4':
                    $col = 3;
                    break;
                case '5':
                    $col = '1/5';
                    break;
            }

            // Wrapper classes
            $self->add_render_attribute(
                'wrapper',
                [
                    'class' => [
                        'rt-slider',
                        'type-' . $item_type,
                        'a' . $item_align
                    ],
                ]
            );
            if ($hover_animation) {
                $self->add_render_attribute('wrapper', 'class', 'hover_animation');
            }

            // Image styles
            $image_size = $image_size['size'] ?? '';
            $image_height = $image_height['size'] ?? '';
            $image_width = $image_size ? 'width: ' . $image_size . 'px;' : '';
            $t_img_style = $image_width ? ' style="' . $image_width . '"' : '';

            $values = (array) $list;
            $item_data = [];
            foreach ($values as $data) {
                $new_data = $data;
                $new_data['thumbnail'] = $data['thumbnail'] ?? '';
                $new_data['quote'] = $data['quote'] ?? '';
                $new_data['author_name'] = $data['author_name'] ?? '';
                $new_data['author_position'] = $data['author_position'] ?? '';
                $new_data['link_author'] = $data['link_author'] ?? '';

                $item_data[] = $new_data;
            }

            $content =  '';

            foreach ($item_data as $item_d) {
                // image styles
                $slider_image_src = aq_resize($item_d['thumbnail']['url'], $image_size, $image_height, true, true, true);

                if (!empty($item_d['link_author']['url'])) {
                    $self->add_link_attributes('link_author', $item_d['link_author']);
                }

                // outputs
                $name_output = '<' . esc_attr($name_tag) . ' class="rt-slider_name">';
                $name_output .= !empty($item_d['link_author']['url']) ? '<a ' . $self->get_render_attribute_string('link_author') . '>' : '';
                $name_output .= esc_html($item_d['author_name']);
                $name_output .= !empty($item_d['link_author']['url']) ? '</a>' : '';
                $name_output .= '</' . esc_attr($name_tag) . '>';

                $quote_output = '<' . esc_attr($quote_tag) . ' class="rt-slider_quote">';
                $quote_output .= $item_d['quote'];
                $quote_output .= '</' . esc_attr($quote_tag) . '>';

                $status_output = !empty($item_d['author_position']) ? '<' . esc_attr($position_tag) . ' class="rt-slider_position">' . esc_html($item_d['author_position']) . '</' . esc_attr($position_tag) . '>' : '';
                $date_output = !empty($item_d['author_date']) ? '<span class="rt-slider_date">' . esc_html($item_d['author_date']) . '</span>' : '';

                $image_output = '';
                if (!empty($slider_image_src)) {
                    $image_output = '<div class="rt-slider_image">';
                    $image_output .= !empty($item_d['link_author']['url']) ? '<a ' . $self->get_render_attribute_string('link_author') . '>' : '';
                    $image_output .= '<img src="' . esc_url($slider_image_src) . '" alt="' . esc_attr($item_d['author_name']) . ' photo" ' . $t_img_style . '>';
                    $image_output .= !empty($item_d['link_author']['url']) ? '</a>' : '';
                    $image_output .= '</div>';
                }

                $content .= '<div class="rt-slider-item_wrap' . (!$use_carousel ? " rt_col-" . $col : '') . '">';
                switch ($item_type) {
                    case 'author_top':
                        $content .= '<div class="rt-slider_item">';
                        $content .= $image_output;
                        $content .= (bool)$additional_style ? '<div class="rt-slider_item-inner">' : '';
                        $content .= '<div class="content_wrap">';
                        $content .= $quote_output;
                        $content .= '</div>';
                        $content .= '<div class="meta_wrap">';
                        $content .= '<div class="name_wrap">';
                        $content .= $name_output;
                        $content .= $status_output;
                        $content .= '</div>';
                        $content .= '</div>';
                        $content .= (bool)$additional_style ? '</div>' : '';
                        $content .= '</div>';
                        break;
                    case 'author_bottom':
                        $content .= '<div class="rt-slider_item">';
                        $content .= '<div class="content_wrap">';
                        $content .= $quote_output;
                        $content .= '</div>';
                        $content .= '<div class="meta_wrap">';
                        $content .= $image_output;
                        $content .= '<div class="name_wrap">';
                        $content .= $name_output;
                        $content .= $status_output;
                        $content .= '</div>';
                        $content .= '</div>';
                        $content .= '</div>';
                        break;
                    case 'inline_top':
                        $content .= '<div class="rt-slider_item">';
                        $content .= '<div class="meta_wrap">';
                        $content .= $image_output;
                        $content .= '<div class="name_wrap">';
                        $content .= $name_output;
                        $content .= $status_output;
                        $content .= '</div>';
                        $content .= '</div>';
                        $content .= '<div class="content_wrap">';
                        $content .= $quote_output;
                        $content .= $date_output;
                        $content .= '</div>';
                        $content .= '</div>';
                        break;
                    case 'inline_bottom':
                        $content .= '<div class="rt-slider_item">';
                        $content .= '<div class="content_wrap">';
                        $content .= $date_output;
                        $content .= $quote_output;
                        $content .= '</div>';
                        $content .= '<div class="meta_wrap">';
                        $content .= $image_output;
                        $content .= '<div class="name_wrap">';
                        $content .= $name_output;
                        $content .= $status_output;
                        $content .= '</div>';
                        $content .= '</div>';
                        $content .= '</div>';
                        break;
                }
                $content .= '</div>';
            }

            $output = '<div  ' . $self->get_render_attribute_string('wrapper') . '>';
            if ($use_carousel) {
                $output .= RT_Carousel_Settings::init($carousel_options, $content, false);
            } else {
                $output .= $content;
            }
            $output .= '</div>';

            return $output;
        }
    }
}
