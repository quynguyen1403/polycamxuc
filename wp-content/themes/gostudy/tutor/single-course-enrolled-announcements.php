<?php
/**
 * Template for displaying single course
 *
 * @since v.1.0.0
 *
 * @author Themeum
 * @url https://themeum.com
 *
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

get_header();

do_action('tutor_course/single/enrolled/before/wrap');

?>
<?php  
    $sticky_sidebar = 'yes';
    if ($sticky_sidebar == 'yes') {
        wp_enqueue_script('theia-sticky-sidebar', get_template_directory_uri() . '/js/theia-sticky-sidebar.min.js');
        $sidebar_class = ' sticky-sidebar';
          $sb_data['class'] = $sidebar_class ?? '';
    }
?>
<div <?php tutor_post_class('tutor-single-anouncement-wrap tutor-page-wrap'); ?>>
    <div class="tutor-container">
        <div class="tutor-row">
            <div class="tutor-col-8  tutor-col-md-100">
                <?php do_action('tutor_course/single/enrolled/before/inner-wrap'); ?>
                <?php $count_completed_lesson = tutor_course_completing_progress_bar(); ?>
                <?php tutor_course_enrolled_nav(); ?>
                <?php tutor_course_announcements(); ?>
                <?php do_action('tutor_course/single/enrolled/after/inner-wrap'); ?>
            </div>
            <div class="tutor-col-4 <?php echo esc_attr( $sidebar_class ); ?>">
                <div class="tutor-single-course-sidebar">
                    <?php do_action('tutor_course/single/enrolled/before/sidebar'); ?>
                    <?php tutor_course_enroll_box(); ?>
                    <?php tutor_course_requirements_html(); ?>
                    <?php tutor_course_tags_html(); ?>
                    <?php tutor_course_target_audience_html(); ?>
                    <?php do_action('tutor_course/single/enrolled/after/sidebar'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
do_action('tutor_course/single/enrolled/after/wrap');
get_footer();
