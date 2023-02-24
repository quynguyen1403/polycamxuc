<?php
/*
 * This template can be overridden by copying it to yourtheme/gostudy-core/elementor/templates/rt-team2.php.
*/
namespace RTAddons\Templates;

defined('ABSPATH') || exit; // Abort, if called directly.
//use Elementor\{Repeater, Utils, Icons_Manager};

use Elementor\{
    Group_Control_Image_Size
};
use RTAddons\Includes\{
    RT_Loop_Settings,
    RT_Carousel_Settings,
    RT_Elementor_Helper
};

/**
 * RT Elementor Team Template
 *
 *
 * @package gostudy-core\includes\elementor
 * @author RaisTheme <help.raistheme@gmail.com>
 * @since 1.0.0
 */
class RTTeachers
{
    private static $instance;

    public static function get_instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function render($atts, $content = null)
    {

            //$settings = $this->get_settings_for_display();
 
        extract($atts);

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
            'p' => ['class' => true, 'style' => true]
        ];

        if ($use_carousel) {
            $carousel_options = [
                'slide_to_show' => $posts_per_line,
                'autoplay' => $autoplay,
                'autoplay_speed' => $autoplay_speed,
                'use_pagination' => $use_pagination,
                'pag_type' => $pag_type,
                'pag_offset' => $pag_offset,
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
                'infinite' => $infinite,
                'slides_to_scroll' => $slides_to_scroll,
                'center_mode' => $center_mode,
            ];

            wp_enqueue_script('slick', get_template_directory_uri() . '/js/slick.min.js');
        }

        $wrapper_classes = 'team-col_' . $posts_per_line;
        $wrapper_classes .= ' a' . $info_align;
        $wrapper_classes .= ' item_separator-' . $item_separator;

        ob_start();
            $this->render_rt_team($atts);
        $team_items = ob_get_clean();

        ob_start();


        ?>

        <div class="rt_module_team <?php echo esc_attr($wrapper_classes); ?>">
            <div class="team-items_wrap">
                <?php
                switch ($use_carousel) {
                    case true:
                        echo RT_Carousel_Settings::init($carousel_options, $team_items, false);
                        break;
                    default:
                        echo \Gostudy_Theme_Helper::render_html($team_items);
                        break;
                }
                ?>
            </div>
        </div>
        <?php

        return ob_get_clean();
    }

    public function render_rt_team($atts)
    {
        extract($atts);

        $compile = '';

        list($query_args) = RT_Loop_Settings::buildQuery($atts);
        $query_args['post_type'] = 'team';
        $rt_posts = new \WP_Query($query_args);

        while ($rt_posts->have_posts()) {
            $rt_posts -> the_post();
            $compile .= $this->render_rt_team_item(false, $atts, false);
        }
        wp_reset_postdata();
        
            $values = (array) $items;
            $item_data = [];
            foreach ($values as $data) {
                $new_data = $data;
                $compile .= $this->render_rt_team_item(false, $atts, false);

                $item_data[] = $new_data;
            }
        echo $compile;
    }

    public function render_rt_team_item($single_member = false, $item_atts, $team_image_dims)
    {
        extract($item_atts);

        $info_array = $info_bg_url = null;
        $t_info = $t_icons = $featured_image = $title = $icons_wrap = '';

        $id = get_the_ID();
        $post = get_post($id);
        $permalink = esc_url(get_permalink($id));
	    $highlighted = get_post_meta($id, 'highlighted', true);
	    $department = get_post_meta($id, 'department', true);
	    $social_array = get_post_meta($id, 'soc_icon', true);
	    $wp_get_attachment_url = wp_get_attachment_url(get_post_thumbnail_id($id));

        if ($single_member) {
            $info_array = get_post_meta($id, 'info_items', true);
            $info_bg_id = get_post_meta($id, 'mb_info_bg', true);
            $info_bg_url = wp_get_attachment_url($info_bg_id);
        } else {
            $team_image_dims = RT_Elementor_Helper::get_image_dimensions(
                $img_size_array ?: $img_size_string,
                $img_aspect_ratio
            );

            if (null == $team_image_dims) {
                return;
            }
        }

        // Info
        if ($info_array) {
            for ($i = 0, $count = count($info_array); $i < $count; $i++) {
                $info = $info_array[$i];
                $info_name = ! empty($info['name']) ? $info['name'] : '';
                $info_description = ! empty($info['description']) ? $info['description'] : '';
                $info_link = ! empty($info['link']) ? $info['link'] : '';

                if (
                    $single_member
                    && (!empty($info_name) || !empty($info_description))
                ) {
                    $t_info .= '<div class="team-info_item">';
                        $t_info .= ! empty($info_name) ? '<h5>' . esc_html($info_name) . '</h5>' : '';
                        $t_info .= ! empty($info_link) ? '<a href="'.esc_url($info_link).'">' : '';
                            $t_info .= '<span>' . esc_html($info_description) . '</span>';
                        $t_info .= ! empty($info_link) ? '</a>' : '';
                    $t_info .= '</div>';
                }
            }
        }

        // Social icons
        if (!$hide_soc_icons && $social_array) {
            for ($i = 0, $count = count($social_array); $i < $count; $i++) {
                $icon = $social_array[$i];
                $icon_name = $icon['select'] ?: '';
                $icon_link = $icon['link'] ?: '#';
                if ($icon['select']) {
                    $t_icons .= '<a href="' . $icon_link . '" class="team-icon ' . $icon_name . '"></a>';
                }
            }
            if ($t_icons) {
                $icons_wrap  = '<div class="team__icons">';
                    $icons_wrap .= '<span class="team-icon fas fa-share-alt"></span>';
                    $icons_wrap .= $t_icons;
                $icons_wrap .= '</div>';
            }
        }

        // // Featured Image
        // if ($wp_get_attachment_url) {
        //     $img_url = aq_resize($wp_get_attachment_url, $team_image_dims['width'], $team_image_dims['height'], true, true, true);
        //     $img_alt = get_post_meta(get_post_thumbnail_id($id), '_wp_attachment_image_alt', true);

        //     $featured_image = sprintf('<%s class="team__image"><img src="%s" alt="%s" /></%s>',
        //         $single_link_wrapper && ! $single_member ? 'a href="'.$permalink.'"' : 'div',
        //         esc_url($img_url),
        //         $img_alt ?: '',
        //         $single_link_wrapper && ! $single_member ? 'a' : 'div'
        //     );
        // }

        // Title
        // if (! $hide_title) {
        //     $title .= '<h2 class="team-title">';
        //         $title .= $single_link_heading && ! $single_member ? '<a href="'.$permalink.'">' : '';
        //             $title .= get_the_title();
        //         $title .= $single_link_heading && ! $single_member ? '</a>' : '';
        //     $title .= '</h2>';
        // }

        // Excerpt
        // if (! $single_member && ! $hide_content) {
        //     $excerpt = $post->post_excerpt ?: $post->post_content;
        //     $excerpt = preg_replace( '~\[[^\]]+\]~', '', $excerpt);
        //     $excerpt = strip_tags($excerpt);
        //     $excerpt = \Gostudy_Theme_Helper::modifier_character($excerpt, $letter_count, '');
        // }

        // Render grid & single
        if (!$single_member) : ?>

<?php 
            $values = (array) $items;
            $item_data = [];
            foreach ($values as $data) {
                $new_data = $data;
                $new_data['teacher_thumb'] = $data['teacher_thumb'] ?? '';
                $new_data['teacher_thumbsize'] = $data['teacher_thumbsize'] ?? '';
                $new_data['service_title'] = $data['service_title'] ?? '';
                $new_data['service_text'] = $data['service_text'] ?? '';

                $item_data[] = $new_data;
            }

 ?>

 <?php 
            foreach ($item_data as $item_d) {
  ?>
            <div class="team-item">
               <div class="team-item_wrap">
                  <div class="team__media-wrapper">
                     <div class="team__image-wrapper">

                        <?php if (!empty($item_d['service_link']['url'])) { ?>
                            <a href="<?php echo esc_url( $item_d['service_link']['url']); ?>" class="team__image">
                        <?php }?>
                            <?php
                            echo '<div class="teacher-image">' . Group_Control_Image_Size::get_attachment_image_html($item_d, 'teacher_thumbsize', 'teacher_thumb') . '</div>';
                            ?>
                        <?php if (!empty($item_d['service_link']['url'])) { ?>
                            </a>
                        <?php }?>

                        <div class="team__icons">
                            <span class="team-icon fas fa-share-alt"></span>
                            <a href="https://twitter.com/" class="team-icon fab fa-twitter"></a>
                            <a href="https://www.instagram.com/" class="team-icon fab fa-instagram"></a>
                            <a href="https://www.facebook.com/" class="team-icon fab fa-facebook-f"></a>
                        </div>
                     </div>
                  </div>
                  <div class="team-item_info">

                          <?php                     
                        if (!empty($item_d['service_title'])) { ?>
                            <<?php echo $item_atts[ 'title_tag' ]; ?> class="team-title"><?php echo $item_d['service_title']; ?></<?php echo $item_atts[ 'title_tag' ]; ?>><?php
                        } ?>

                          <?php                     
                        if (!empty($item_d['service_text'])) { ?>
                            <<?php echo $item_atts[ 'content_tag' ]; ?> class="team-item_excerpt"><?php echo $item_d['service_text']; ?></<?php echo $item_atts[ 'content_tag' ]; ?>><?php
                        } ?>

                  </div>
               </div>
            </div>
<?php } ?>
            <?php

        else :

            echo '<div class="team-single_wrapper"', ($info_bg_url ? ' style="background-image: url(' . esc_url($info_bg_url) . ')"' : ''), '>';

                if ($featured_image) {
                    echo '<div class="team-image_wrap">',
                        $featured_image,
                    '</div>';
                }

                echo '<div class="team-info_wrapper">',
                    $title,
	                ($department ? '<div class="team-info_item department"><span>' . esc_html($department) . '</span></div>' : ''),
                    $t_info,
                    $icons_wrap,
                '</div>';

	            echo $highlighted ? '<div class="team-info_item highlighted"><span>' . esc_html($highlighted) . '</span></div>' : '';

            echo '</div>';

        endif;
    }
}
