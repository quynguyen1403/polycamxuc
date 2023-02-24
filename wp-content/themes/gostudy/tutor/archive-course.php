<?php

/**
 * Template for displaying courses
 *
 * @since v.1.0.0
 *
 * @author Themeum
 * @url https://themeum.com
 *
 * @package TutorLMS/Templates
 * @version 1.5.8
 */

get_header();


$course_filter = (bool) tutor_utils()->get_option('course_archive_filter', false);
$supported_filters = tutor_utils()->get_option('supported_course_filters', array());

if ($course_filter && count($supported_filters)) {
?>

	<div class=" rt-container">
		<div class="row">
			<div class="rt_col-3">
				<div class="tutor-course-filter-wrapper tutor-course-filter-container">
					<?php tutor_load_template('course-filter.filters'); ?>
				</div>
			</div>
		<div class="rt_col-9 less-p-15">
			<div class="<?php tutor_container_classes(); ?> tutor-course-filter-loop-container" data-column_per_row="<?php echo tutor_utils()->get_option( 'courses_col_per_row', 4 ); ?>">

					<?php 
						get_template_part('tutor/archive-course', 'item'); 
					?>
					
			</div><!-- .wrap -->
		</div>

		<?php
		} else {
			?>
				<?php 
					get_template_part('tutor/archive-course', 'item'); 
				?>
			<?php
		} ?>
		
	</div>
</div>
<?php 

get_footer(); ?>