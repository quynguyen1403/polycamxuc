<?php


    $filter_object = new \TUTOR\Course_Filter();
    $filter_levels = array(
        'beginner'=> __('Beginner', 'gostudy'),
        'intermediate'=> __('Intermediate', 'gostudy'),
        'expert'=> __('Expert', 'gostudy')
    );
    $filter_prices=array(
        'free'=> __('Free', 'gostudy'),
        'paid'=> __('Paid', 'gostudy'),
    );

    $supported_filters = tutor_utils()->get_option('supported_course_filters', array());
    $supported_filters = array_keys($supported_filters);

    // Theme Options
    use Gostudy_Theme_Helper as Gostudy;
    $tutor_filter_price = Gostudy_Theme_Helper::get_option('tutor_filter_price');
    $tutor_filter_cat = Gostudy_Theme_Helper::get_option('tutor_filter_cat');
    $tutor_filter_tag = Gostudy_Theme_Helper::get_option('tutor_filter_tag');
    $tutor_filter_skill_level = Gostudy_Theme_Helper::get_option('tutor_filter_skill_level');
    $tutor_filter_clear_all_filter = Gostudy_Theme_Helper::get_option('tutor_filter_clear_all_filter');

?>
<form>  
    <?php do_action('tutor_course_filter/before'); ?>
    <?php
        if(in_array('search', $supported_filters)){
            ?>
            <div class="tutor-course-search-field widget">
                <input type="text" name="keyword" placeholder="<?php echo esc_html__('Tìm kiếm...', 'gostudy'); ?>"/>
                <i class="tutor-icon-magnifying-glass-1"></i>
            </div>

            <?php
        }
    ?>
    <div class="tutor-filter-sidebar-wrap">
        <?php

            $is_membership = get_tutor_option('monetize_by')=='pmpro' && tutils()->has_pmpro();
            if(!$is_membership && in_array('price_type', $supported_filters)){
                ?>
                <div class="tutor-filter-sidebar widget">
                    <div class="title-wrapper"><span class="title"><?php echo esc_html($tutor_filter_price); ?></span></div>
                    <?php 
                        foreach($filter_prices as $value=>$title){
                            ?>
                                <label>
                                    <input type="checkbox" name="tutor-course-filter-price" value="<?php echo esc_html($value); ?>"/>&nbsp;
                                    <?php echo esc_html($title); ?>
                                </label>
                            <?php
                        }
                    ?>
                </div>
                <?php
            }
            if(in_array('category', $supported_filters)){
                ?>
                <div class="tutor-filter-sidebar widget">
                    <div class="title-wrapper"><span class="title"><?php echo esc_html($tutor_filter_cat); ?></span></div>
                    <?php $filter_object->render_terms('category'); ?>
                </div>
                <?php
            }

            if(in_array('tag', $supported_filters)){
                ?>
                <div class="tutor-filter-sidebar widget">
                    <div class="title-wrapper"><span class="title"><?php echo esc_html($tutor_filter_tag); ?></span></div>
                    <?php $filter_object->render_terms('tag'); ?>
                </div>
                <?php
            }
        ?>
    </div>
    <div class="tutor-filter-level-wrap">
        <?php
            if(in_array('difficulty_level', $supported_filters)){
                ?>
                <div class="tutor-filter-sidebar widget">
                    <div class="title-wrapper"><span class="title"><?php echo esc_html($tutor_filter_skill_level); ?></span></div>
                    <?php 
                        foreach($filter_levels as $value=>$title){
                            ?>
                                <label>
                                    <input type="checkbox" name="tutor-course-filter-level" value="<?php echo esc_html($value); ?>"/>&nbsp;
                                    <?php echo esc_html($title); ?>
                                </label>
                            <?php
                        }
                    ?>
                </div>
                <?php
            }

        ?>
    </div>
    <div class="tutor-clear-all-filter">
        <a href="#" onclick="window.location.reload()">
            <i class="tutor-icon-cross"></i> <?php echo esc_html($tutor_filter_clear_all_filter); ?>
        </a>
    </div>
    <?php do_action('tutor_course_filter/after'); ?>
</form>