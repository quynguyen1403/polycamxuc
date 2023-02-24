    <?php 
        use Gostudy_Theme_Helper as Gostudy;
     ?>

     <div class="<?php tutor_container_classes(); ?>">
        <section class="rt-courses">
          <div class=" rt-courses__grid grid-col--<?php echo tutor_utils()->get_option( 'courses_col_per_row', 4 ); ?>" data-column_per_row="<?php echo tutor_utils()->get_option( 'courses_col_per_row', 4 ); ?>">
                <?php 

                        if ( have_posts() ) :
                            /* Start the Loop */

                            tutor_course_loop_start();

                            while ( have_posts() ) : the_post();

                                get_template_part( 'tutor/gostudy_course', 'item' );

                            endwhile;

                            tutor_course_loop_end();

                    else :

                        /**
                         * No course found
                         */
                        tutor_load_template('course-none');

                    endif;

                        //tutor_course_archive_pagination();
                    
                          // Pagination
                        echo Gostudy::pagination();

                    do_action('tutor_course/archive/after_loop');
                ?>

           </div>
        </section>
    </div>