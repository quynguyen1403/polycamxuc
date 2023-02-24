<?php
/**
 * Add function to widgets_init that'll load our widget.
 */
add_action('widgets_init', 'rt_learnpress_course_load_widgets');

function rt_learnpress_course_load_widgets()
{
    register_widget('RT_LearnPress_Course_Widget');
}

/**
 * Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.
 *
 */
class RT_LearnPress_Course_Widget extends WP_Widget
{
    /**
     * Widget setup.
     */
    function __construct()
    {
        /* Widget settings. */
        $widget_ops = [
            'classname' => 'widget_rt_posts',
            'description' => esc_html__('Display LearnPress recent course by categories (or related)', 'gostudy-core')
        ];

        /* Create the widget. */
        parent::__construct('rt-learnpress-course', esc_html__('(GOSTUDY) LearnPress Courses', 'gostudy-core'), $widget_ops);
    }

    function widget($args, $instance)
    {
        extract($args);

        global $wpdb;
        global $post;
        $time_id = rand();

        /* Variables from the widget settings. */
        $title = $instance['title'] ?? '';
        $num_posts = $instance['num_posts'] ?? 4;
        $categories = $instance['categories'] ?? '';
        $show_image = $instance['show_image'] ?? true;
        $show_related = !empty($instance['show_related']) ? true : false;
        $show_content = !empty($instance['show_content']) ? true : false;
        $show_price = !empty($instance['show_price']) ? true : false;

        /* Before widget (defined by themes). */
        echo Gostudy_Theme_Helper::render_html($before_widget);

        /* Display the widget title if one was input (before and after defined by themes). */
        if ($title) {
            echo Gostudy_Theme_Helper::render_html($before_title),
                esc_attr($instance['title']),
            Gostudy_Theme_Helper::render_html($after_title);
        }

        if ($show_related) { // show related category
            $related_category = get_the_category($post->ID);
            if (isset($related_category[0]->cat_name)) {
                $related_category_id = get_cat_ID($related_category[0]->cat_name);
            } else {
                $related_category_id = '';
            }

            $recent_posts = new WP_Query([
                'post_type' => 'lp_course',
                'showposts' => $num_posts,
                'cat' => $related_category_id,
                'post__not_in' => [$post->ID],
                'ignore_sticky_posts' => 1,
            ]);
        } else {
            $recent_posts = new WP_Query([
                'post_type' => 'lp_course',
                'showposts' => $num_posts,
                'cat' => $categories,
                'ignore_sticky_posts' => 1,

            ]);
        }

        if ($recent_posts->have_posts()) :
            echo '<ul class="rt-learnpress-course-widget recent-widget-', esc_attr($time_id), '">';
                while ($recent_posts->have_posts()) :
                    $recent_posts->the_post();

                    $img_url = false;
                    if (
                        $show_image
                        && has_post_thumbnail()
                    ) {
                        $img_url = wp_get_attachment_image_url(get_post_thumbnail_id(get_the_ID()));
                    }

                    if ($show_content) {
                        if (has_excerpt()) {
                            $post_excerpt = get_the_excerpt();
                        } else {
                            $post_excerpt = get_the_content();
                        }

                        $without_tags = strip_tags($post_excerpt);
                        $text = Gostudy_Theme_Helper::modifier_character($without_tags, 65, '...');
                    } else {
                        $text = '';
                    }

                    // Render
                    echo '<li class="clearfix', ($img_url ? ' has_image' : ''), '">';
                        if ($img_url) {
                            echo '<a class="post__link" href="', esc_url(get_permalink()), '">';
                                echo '<div class="rt-learnpress-course-image_wrapper">',
                                    '<img',
                                        ' src="', esc_url(aq_resize($img_url, '160', '160', true, true, true)), '"',
                                        ' alt="', the_title_attribute(['echo' => false]), '"',
                                        '>',
                                '</div>';
                            echo '</a>'; // post__link
                        }
                        echo '<div class="rt-learnpress-course-content_wrapper">';
                            echo '<a class="post__link" href="', esc_url(get_permalink()), '">';
                            echo '<h6 class="post__title">',
                                esc_html(get_the_title()),
                            '</h6>'; // post-title
                             echo '</a>'; // post__link

                            if ($show_price) :

                                echo '<span class="course-price">';

                                        get_template_part('templates/learnpress/price_within_button_2');

                                echo '</span>';

                            endif;
                            if ($text) :
                                echo '<div class="rt-learnpress-course-content">',
                                    esc_html($text),
                                '</div>';
                            endif;
                        echo '</div>';
                  //  echo '</a>'; // post__link
                    echo '</li>';
                endwhile;
            echo '</ul>';

        else :

            esc_html_e('No posts were found.', 'gostudy-core');

        endif;

        /* After widget (defined by themes). */
        echo Gostudy_Theme_Helper::render_html($after_widget);

        // Restore original Query & Post Data
        wp_reset_query();
        wp_reset_postdata();
    }

    /**
     * Update the widget settings.
     */
    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;

        // Strip tags for title and name to remove HTML (important for text inputs).
        $instance['title'] = isset($new_instance['title']) ? strip_tags($new_instance['title']) : '';
        $instance['num_posts'] = $new_instance['num_posts'] ?? '';
        $instance['categories'] = $new_instance['categories'] ?? '';
        $instance['show_image'] = $new_instance['show_image'] ?? '';
        $instance['show_related'] = $new_instance['show_related'] ?? '';
        $instance['show_content'] = $new_instance['show_content'] ?? '';
        $instance['show_price'] = $new_instance['show_price'] ?? '';

        return $instance;
    }

    /**
     * Displays the widget settings controls on the widget panel.
     * Make use of the get_field_id() and get_field_name() function
     * when creating your form elements. This handles the confusing stuff.
     */
    function form($instance)
    {
        /* Set up some default widget settings. */
        $defaults = [
            'title' => esc_html__('LearnPress Courses' , 'gostudy-core'),
            'num_posts' => 3,
            'categories' => 'all',
            'show_related'  => 'off',
            'show_image' => 'on',
            'show_price' => 'on',
            'show_content'  => 'off'
        ];

        $instance = wp_parse_args((array) $instance, $defaults); ?>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:' , 'gostudy-core') ?></label>
            <input class="widefat" style="width: 216px;" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('num_posts')); ?>"><?php esc_html_e('Number of posts:' , 'gostudy-core'); ?></label>
            <input type="number" min="1" max="100" class="widefat" id="<?php echo esc_attr($this->get_field_id('num_posts')); ?>" name="<?php echo esc_attr($this->get_field_name('num_posts')); ?>" value="<?php echo esc_attr($instance['num_posts']); ?>" />
        </p>

        <p>
            <input class="checkbox" type="checkbox" <?php checked($instance['show_related'], 'on'); ?> id="<?php echo esc_attr($this->get_field_id('show_related')); ?>" name="<?php echo esc_attr($this->get_field_name('show_related')); ?>" />
            <label for="<?php echo esc_attr($this->get_field_id('show_related')); ?>"><?php esc_html_e('Show related category posts' , 'gostudy-core'); ?></label>
        </p>

        <p>
            <input class="checkbox" type="checkbox" <?php checked($instance['show_image'], 'on'); ?> id="<?php echo esc_attr($this->get_field_id('show_image')); ?>" name="<?php echo esc_attr($this->get_field_name('show_image')); ?>" />
            <label for="<?php echo esc_attr($this->get_field_id('show_image')); ?>"><?php esc_html_e('Show thumbnail image' , 'gostudy-core'); ?></label>
        </p>

        <p style="margin-top: 20px;">
            <label style="font-weight: bold;"><?php esc_html_e('Post meta info' , 'gostudy-core'); ?></label>
        </p>

        <p>
            <input class="checkbox" type="checkbox" <?php checked($instance['show_price'], 'on'); ?> id="<?php echo esc_attr($this->get_field_id('show_price')); ?>" name="<?php echo esc_attr($this->get_field_name('show_price')); ?>" />
            <label for="<?php echo esc_attr($this->get_field_id('show_price')); ?>"><?php esc_html_e('Show Price' , 'gostudy-core'); ?></label>
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked($instance['show_content'], 'on'); ?> id="<?php echo esc_attr($this->get_field_id('show_content')); ?>" name="<?php echo esc_attr($this->get_field_name('show_content')); ?>" />
            <label for="<?php echo esc_attr($this->get_field_id('show_content')); ?>"><?php esc_html_e('Show content' , 'gostudy-core'); ?></label>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('categories')); ?>"><?php esc_html_e('Filter by Category:' , 'gostudy-core'); ?></label>
            <select id="<?php echo esc_attr($this->get_field_id('categories')); ?>" name="<?php echo esc_attr($this->get_field_name('categories')); ?>" class="widefat categories" style="width:100%;">
                <option value='all' <?php if ('all' == $instance['categories'] ) echo 'selected="selected"'; ?>><?php esc_html_e('All categories' , 'gostudy-core');?></option>
                <?php $categories = get_categories( 'hide_empty=0&depth=1&type=lp_course&taxonomy=course_category' ); ?>
                <?php foreach( $categories as $category) { ?>
                <option value='<?php echo esc_attr($category->term_id); ?>' <?php if ($category->term_id == $instance['categories']) echo 'selected="selected"'; ?>><?php echo esc_attr($category->cat_name); ?></option>
                <?php } ?>
            </select>
        </p>
    <?php
    }
}
