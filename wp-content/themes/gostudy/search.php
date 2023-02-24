<?php

defined('ABSPATH') || exit;

use Gostudy_Theme_Helper as Gostudy;

/**
 * The template for displaying search result page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package gostudy
 * @since 1.0.0
 */

get_header();

$sb = Gostudy::get_sidebar_data('blog_list');
$container_class = $sb['container_class'] ?? '';
$row_class = $sb['row_class'] ?? '';
$column = $sb['column'] ?? '';

?>
<div class="rt-container<?php echo apply_filters('gostudy/container/class', esc_attr( $container_class )); ?>">
<div class="row<?php echo apply_filters('gostudy/row/class', esc_attr( $row_class )); ?>">
    <div id='main-content' class="rt_col-<?php echo apply_filters('gostudy/column/class', esc_attr( $column )); ?>">
        <?php
        if (have_posts()) :
            echo '<header class="searсh-header">',
                '<h1 class="page-title">',
                    esc_html__('Tìm kiếm kết quả cho: ', 'gostudy'),
                    '<span>', get_search_query(), '</span>',
                '</h1>',
            '</header>';

            global $rt_blog_atts;
            global $wp_query;

            $rt_blog_atts = [
                'query' => $wp_query,
                // Layout
                'blog_layout' => 'grid',
                'blog_columns' => Gostudy::get_option('blog_list_columns') ?: '12',
                // Appearance
                'hide_media' => Gostudy::get_option('blog_list_hide_media'),
                'hide_content' => Gostudy::get_option('blog_list_hide_content'),
                'hide_blog_title' => Gostudy::get_option('blog_list_hide_title'),
                'hide_all_meta' => Gostudy::get_option('blog_list_meta'),
                'meta_author' => Gostudy::get_option('blog_list_meta_author'),
                'meta_comments' => Gostudy::get_option('blog_list_meta_comments'),
                'meta_categories' => Gostudy::get_option('blog_list_meta_categories'),
                'meta_date' => Gostudy::get_option('blog_list_meta_date'),
                'hide_likes' => !Gostudy::get_option('blog_list_likes'),
                'hide_views' => !Gostudy::get_option('blog_list_views'),
                'hide_share' => !Gostudy::get_option('blog_list_share'),
                'read_more_hide' => Gostudy::get_option('blog_list_read_more'),
                'content_letter_count' => Gostudy::get_option('blog_list_letter_count') ?: '85',
                'read_more_text' => esc_html__('Đọc thêm', 'gostudy'),
                'heading_tag' => 'h3',
                'items_load' => 4,
            ];

            // Blog Archive Template
            get_template_part('templates/post/posts-list');
            echo Gostudy::pagination();

        else :
            echo '<div class="page_404_wrapper">';
                echo '<header class="searсh-header">',
                    '<h1 class="page-title">',
                    esc_html__('Không tìm thấy kết quả', 'gostudy'),
                    '</h1>',
                '</header>';

                echo '<div class="page-content">';
                    if (is_search()) :
                        echo '<p class="banner_404_text">';
                        esc_html_e('Xin lỗi, Poly Cảm Xúc không có nội dung liên quan đến từ khóa mà bạn đang tìm kiếm. Hãy thử lại với các từ khóa khác', 'gostudy');
                        echo '</p>';
                    else : ?>
                        <p class="banner_404_text"><?php esc_html_e('Có vẻ như chúng tôi không thể tìm thấy những gì bạn đang tìm kiếm. Bạn có thể liên hệ fanpage Poly Cảm Xúc', 'gostudy'); ?></p>
                        <?php
                    endif;
                    ?>
                    <div class="search_result_form">
                        <?php get_search_form(); ?>
                    </div>
                    <div class="gostudy_404__button">
                        <a class="rt-button btn-size-lg" href="<?php echo esc_url(home_url('/')); ?>">
                            <div class="button-content-wrapper">
                            <?php esc_html_e('Quay về trang chủ', 'gostudy'); ?>
                            </div>
                        </a>
                    </div>
                </div>

            </div>
            <?php
        endif;
    echo '</div>';

    if ($sb) {
        Gostudy::render_sidebar($sb);
    }

echo '</div>';
echo '</div>';

get_footer();
