<?php
/*
 * This template can be overridden by copying it to yourtheme/gostudy-core/elementor/templates/rt-courses-alt.php.
*/
namespace RTAddons\Templates;

defined('ABSPATH') || exit; // Abort, if called directly.

use RTAddons\Includes\{
    RT_Loop_Settings,
    RT_Carousel_Settings,
    RT_Elementor_Helper
};

/**
 * RT Elementor Courses Template
 *
 *
 * @package gostudy-core\includes\elementor
 * @author RaisTheme <help.raistheme@gmail.com>
 * @since 1.0.0
 */
class RTCoursesAlt
{
    private $attributes;
    private $query;

    public function render($attributes = [], $self = false)
    {
        $this->attributes = $attributes;
        $this->item       = !empty($self) ? $self : $this;
        $this->query      = $this->_formalize_query();

        if (!$this->query->have_posts()) {
            // Bailout, if nothing to render
            learn_press_display_message( __( 'Sorry, no any course found.', 'gostudy-core' ), 'error' );
            return;
        }

        $_ = $attributes; // assign shorthand for attributes array

        echo '<section class="rt-courses-alt">';

        echo '<div class="rt-courses__grid', $this->_get_wrapper_classes(), '">';

        if ($_['course_layout'] == 'carousel') {
            ob_start();
        }

        while ($this->query->have_posts()) : $this->query->the_post();

            $this->_render_course_post($attributes);

        endwhile;
        wp_reset_postdata();

        if ('carousel' === $_['course_layout']) {
            $course_items = ob_get_clean();
            $course_items = $this->_apply_carousel_settings($course_items);
            echo $course_items;
        }

        echo '</div>'; //* rt-course__grid

        $this->_render_navigation_section();

        echo '</section>';
    }

    public function _render_course_post($attributes)
    {
        $_ = $attributes;
        $media_intro_url = get_post_meta(get_the_ID(), 'gostudy_course_media_intro', true);

        // item course tag in courses tab of user profile page.
        $tag = isset($_['item_tag']) && !empty($_['item_tag']) ? $_['item_tag'] : 'article';

        echo '<', $tag, ' class="rt-course', $this->_get_item_classes(), '">';
        echo '<div class="course__container">';

        // Featured Image
        $media_condition = !$_['hide_media'] && (has_post_thumbnail() || $media_intro_url);
        echo '<div class="course__media">';
        if ($media_condition) {
            echo $this->_render_featured_image($attributes);
        }
        echo '</div>';

        // Cats
        $_['hide_tax'] || $this->_render_tax();
        // Price
        echo (!$_['hide_price']) ? $this->_render_price_button() : '';

        echo '<div class="course__content">';

        echo '<div class="course__content--info">';

        // Title
        $_['hide_title'] || $this->_render_title($attributes);
        // Excerpt|Content
        $_['hide_excerpt'] || $this->_render_excerpt();
        // Instructor
        $_['hide_instructor'] || $this->_render_instructor();

        echo '</div>'; // course content info

        echo '<div class="course__content--meta">';

        // Students
        $_['hide_students'] || $this->_render_students();
        // Lessons
        $_['hide_lessons'] || $this->_render_lessons();
        // Reviews
        if (!$_['hide_reviews'] && class_exists('LP_Addon_Course_Review_Preload')) {
            $this->_render_reviews();
        }
        // Wishlist Button
        $_['hide_wishlist'] || $this->_render_wishlist_button();

        echo '</div>'; // course content meta

        echo '</div>'; // course content

        echo '</div>'; // course container
        echo '</', $tag, '>'; // course item

    }

    protected function _formalize_query()
    {
        list($query_args) = RT_Loop_Settings::buildQuery($this->attributes);

        $query_args['post_type'] = 'lp_course';

        //* Add Page to Query
        global $paged;
        if (empty($paged)) {
            $paged = get_query_var('page') ?: 1;
        }
        $query_args['paged'] = $paged;

        return RT_Loop_Settings::cache_query($query_args);
    }

    protected function _get_wrapper_classes()
    {
        $_ = $this->attributes;

        $class = ' grid-col--' . $_['grid_columns'];
        $class .= $_['course_layout'] === 'carousel' ? ' carousel' : '';
        if ('masonry' === $_['course_layout']) {
            wp_enqueue_script('imagesloaded');
            wp_enqueue_script('isotope', RT_ELEMENTOR_ADDONS_URL . 'assets/js/isotope.pkgd.min.js');
            $class .= ' isotope';
        }

        return esc_attr($class);
    }

    protected function _get_item_classes()
    {
        $media_intro_url = get_post_meta(get_the_ID(), 'gostudy_course_media_intro', true);
        $media_condition = $this->attributes['hide_media'] || !has_post_thumbnail();
        $class = $this->_cats_class();
        $class .= $media_condition ? ' no-media' : '';
        $class .= $media_intro_url ? ' media-intro' : '';

        return esc_attr($class);
    }

    protected function _render_featured_image($attributes)
    {
        $_ = $attributes;
        $featured_image = '';
        $thumb_id = get_post_thumbnail_id(get_the_ID());
        $media_intro_url = get_post_meta(get_the_ID(), 'gostudy_course_media_intro', true);

        $image_full_size = wp_get_attachment_image_src($thumb_id, 'full');
        $attachment_url = !empty($image_full_size[0]) ? $image_full_size[0] : '';
        $thumb_alt = trim(strip_tags(get_post_meta($thumb_id, '_wp_attachment_image_alt', true)));

        $image_dims = RT_Elementor_Helper::get_image_dimensions(
            ('custom' == $_['img_size_string'] ? $_['img_size_array'] : $_['img_size_string']),
            $_['img_aspect_ratio']
        );

        if (null == $image_dims)  {
            return;
        }
        $rt_featured_image_url = aq_resize($attachment_url, $image_dims['width'], $image_dims['height'], true, true, true);

        if (!$rt_featured_image_url) {
            $rt_featured_image_url = $attachment_url;
        }

        if ($media_intro_url) {
            if (has_post_thumbnail()) {
                $featured_image .= '<div class="rt-video_popup with_image">';
                $featured_image .= '<div class="videobox_content">';
                    $featured_image .= '<div class="videobox_background">';
                        $featured_image .= '<img src="' . esc_url($rt_featured_image_url) . '" alt="' . esc_attr($thumb_alt) . '">';
                    $featured_image .= '</div>';

                    $featured_image .= '<div class="videobox_link_wrapper">';

                    $lightbox_url = \Elementor\Embed::get_embed_url( $media_intro_url, [], [] );

                    $lightbox_options = [
                        'type' => 'video',
                        'url' => $lightbox_url,
                        'modalOptions' => [
                            'id' => 'elementor-lightbox-' . uniqid(),
                        ],
                    ];

                    $this->item->add_render_attribute( 'video-lightbox', [
                        'class' => 'videobox_link videobox',
                        'data-elementor-open-lightbox' => 'yes',
                        'data-elementor-lightbox' =>  wp_json_encode( $lightbox_options ),
                    ] );

                    $featured_image .= '<div ' . $this->item->get_render_attribute_string( 'video-lightbox' ) . '>';
                        $featured_image .= '<svg class="videobox_icon" width="33%" height="33%" viewBox="0 0 232 232"><path d="M203,99L49,2.3c-4.5-2.7-10.2-2.2-14.5-2.2 c-17.1,0-17,13-17,16.6v199c0,2.8-0.07,16.6,17,16.6c4.3,0,10,0.4,14.5-2.2 l154-97c12.7-7.5,10.5-16.5,10.5-16.5S216,107,204,100z"/></svg>';
                    $featured_image .= '</div>';
                    $featured_image .= '</div>';

                $featured_image .= '</div>'; // videobox_content
                $featured_image .= '</div>';
            } else {
                $featured_image .= '<div class="course__media-video">';
                $featured_image .= rwmb_meta('gostudy_course_media_intro', 'type=oembed');
                $featured_image .= '</div>';
            }
        } else {
            $featured_image .= $_['single_link_image'] ? '<a class="course__media-link" href="' . esc_url(get_permalink()) . '">' : '';
            $featured_image .= '<img src="' . esc_url($rt_featured_image_url) . '" alt="' . esc_attr($thumb_alt) . '" />';
            $featured_image .= $_['single_link_image'] ? '</a>' : '';
        }

        return $featured_image;
    }

    protected function _render_price_button()
    {
        ob_start();
        get_template_part('templates/learnpress/price_within_button');
        $button = ob_get_clean();

        return $button;
    }

    protected function _render_tax()
    {
        $postID = get_post()->ID;

        $tax_html = '';
        $terms = get_the_terms($postID, 'course_category');
        if (!empty($terms) && !is_wp_error($terms)) {
            foreach ($terms as $cat) {
                $tax_html .= '<a href="' . get_term_link($cat, $cat->taxonomy) . '" rel="tag">' . $cat->name . '</a>';
            }
        }

        if (!$tax_html) {
            //* Bailout, if nothing to render
            return;
        }

        printf('<div class="course__categories">%s</div>', $tax_html);
    }

    protected function _render_title($attributes)
    {
        $title = get_the_title();
        $_ = $attributes;

        if (!$title) {
            return;
        }

        $title_out = '';
        $title_out .= $_['single_link_title'] ? '<a class="course__media-link" href="' . esc_url(get_permalink()) . '">' : '';
        $title_out .= $title;
        $title_out .= $_['single_link_title'] ? '</a>' : '';

        printf(
            '<%1$s class="course__title">%2$s</%1$s>',
            esc_html($_['title_tag'] ?? 'h4'),
            $title_out
        );
    }

    protected function _render_excerpt()
    {
        $id = get_the_ID();
        if (has_excerpt($id)) :
            $excerpt = get_the_excerpt($id);
        else :
            $excerpt = get_the_content(null, false, $id);
        endif;

        if (!$excerpt) {
            //* Bailout, if nothing to render
            return;
        }

        $excerpt_limited = $this->attributes['excerpt_chars'] ?? true;

        $excerpt_stripped = strip_tags($excerpt);
        $excerpt = $excerpt_limited ? \Gostudy_Theme_Helper::modifier_character($excerpt_stripped, $this->attributes['excerpt_chars']) : $excerpt;
        $excerpt = trim($excerpt);

        if ($excerpt) {
            printf('<div class="course__excerpt">%s</div>', $excerpt);
        }
    }

    protected function _render_instructor()
    {
        ob_start();
        learn_press_courses_loop_item_instructor();
        $author_name = ob_get_clean();

        echo '<span class="course__author">', esc_html__('by', 'gostudy-core'), $author_name, '</span>';
    }

    protected function _render_students()
    {
        $students = (int) learn_press_get_course()->count_students();
        $students_text = ('1' == $students) ? esc_html__('STUDENT', 'gostudy-core') : esc_html__('STUDENTS', 'gostudy-core');
        printf(
            '<span class="course-students" title="%s">%d %s</span>',
            esc_attr(strip_tags(learn_press_get_course()->get_students_html())),
            $students,
            $students_text
        );
    }

    protected function _render_lessons()
    {
        $course = \LP_Global::course();
        $lessons = $course->get_items('lp_lesson', false) ? count($course->get_items('lp_lesson', false)) : 0;
        $lessons_text = ('1' == $lessons) ? esc_html__('LESSON', 'gostudy-core') : esc_html__('LESSONS', 'gostudy-core');
        printf('<span class="course-lessons">%s %s</span>', $lessons, $lessons_text);
    }

    protected function _render_reviews()
    {
        $total_reviews = learn_press_get_course_rate_total(get_the_ID());
        $reviews_text = ('1' == $total_reviews) ? esc_html__('REVIEW', 'gostudy-core') : esc_html__('REVIEWS', 'gostudy-core');
        $reviews_title = !empty($total_reviews)
            ? sprintf(_n('review is submitted', 'reviews are submitted', $total_reviews, 'gostudy-core'), number_format_i18n($total_reviews))
            : esc_html__('No any reviews yet', 'gostudy-core');

        printf(
            '<span class="course-reviews" title="%1$s %2$s">%1$d %3$s</span>',
            $total_reviews,
            $reviews_title,
            $reviews_text
        );
    }

    protected function _render_wishlist_button()
    {
        $button = '';
        if (class_exists('LP_Addon_Wishlist_Preload')) {
            remove_action('learn-press/after-course-buttons', [\LP_Addon_Wishlist::instance(), 'wishlist_button'], 100);
            $button = \LP_Addon_Wishlist::instance()->wishlist_button();
        }

        return $button;
    }

    protected function _apply_carousel_settings($course_items)
    {
        $_ = $this->attributes;

        $options = [
            'slide_to_show' => $_['grid_columns'],
            'autoplay' => $_['autoplay'],
            'autoplay_speed' => $_['autoplay_speed'],
            'infinite' => $_['infinite_loop'],
            'center_mode' => $_['center_mode'],
            'variable_width' => $_['variable_width'],
            'slides_to_scroll' => $_['slide_single'],
            'use_pagination' => $_['use_pagination'],
            'use_navigation' => $_['use_navigation'],
            'use_prev_next' => $_['use_navigation'] ? true : false,
            'pag_type' => $_['pag_type'],
            'custom_pag_color' => $_['custom_pag_color'],
            'pag_color' => $_['pag_color'],
            'custom_resp' => $_['custom_resp'],
            'resp_medium_slides' => $_['resp_medium_slides'],
            'resp_tablets_slides' => $_['resp_tablets_slides'],
            'resp_mobile_slides' => $_['resp_mobile_slides'],
            'adaptive_height' => true
        ];

        $_['resp_medium'] && $options['resp_medium'] = $_['resp_medium'];
        $_['resp_tablets'] && $options['resp_medium'] = $_['resp_tablets'];
        $_['resp_mobile'] && $options['resp_medium'] = $_['resp_mobile'];

        return RT_Carousel_Settings::init($options, $course_items);
    }

    private function _cats_class()
    {
        $p_cats = wp_get_post_terms(get_the_id(), 'course_category');
        $p_cats_class = '';
        for ($i = 0, $count = count($p_cats); $i < $count; $i++) {
            $p_cat_term = $p_cats[$i];
            $p_cats_class .= ' course-' . $p_cat_term->slug;
        }

        return $p_cats_class;
    }

    protected function _render_navigation_section()
    {
        if ($this->attributes['pagination']) {
            echo \Gostudy_Theme_Helper::pagination($this->query, 'center');
        }
    }

    public function add_render_attribute($element, $key = null, $value = null, $overwrite = false)
    {
        if (is_array($element)) {
            foreach ($element as $element_key => $attributes) {
                $this->add_render_attribute($element_key, $attributes, null, $overwrite);
            }

            return $this;
        }

        if (is_array($key)) {
            foreach ($key as $attribute_key => $attributes) {
                $this->add_render_attribute($element, $attribute_key, $attributes, $overwrite);
            }

            return $this;
        }

        if (empty( $this->render_attributes[ $element ][ $key ] )) {
            $this->render_attributes[ $element ][ $key ] = [];
        }

        settype($value, 'array');

        if ($overwrite) {
            $this->render_attributes[ $element ][ $key ] = $value;
        } else {
            $this->render_attributes[ $element ][ $key ] = array_merge( $this->render_attributes[ $element ][ $key ], $value );
        }

        return $this;
    }

    public function get_render_attribute_string($element)
    {
        if (empty($this->render_attributes[$element])) {
            return '';
        }

        return ' ' . \Gostudy_Theme_Helper::render_html_attributes( $this->render_attributes[ $element ] );
    }

}
