<?php

use Gostudy_Theme_Helper as Gostudy;

$tutor_archive_layout = Gostudy_Theme_Helper::get_option('tutor_archive_layout');

?>


	<?php if ($tutor_archive_layout == '1'): ?>
		<article class="rt-course layout-<?php echo esc_attr($tutor_archive_layout); ?>">
		 <div class="course__container">
		    <div class="course__media">

				<!-- ** Media **-->
		      <a href="<?php the_permalink(); ?>"> <?php get_tutor_course_thumbnail(); ?> </a>

				<!-- ** Category **-->

		       	<?php  
		       			$postID = get_post()->ID;
				        $tax_html = '';
				        $terms = get_the_terms($postID, 'course-category');
				        if (!empty($terms) && !is_wp_error($terms)) {
				            foreach ($terms as $cat) {
				                $tax_html .= '<a href="' . get_term_link($cat, $cat->taxonomy) . '" rel="tag">' . $cat->name . '</a>';
				            }
				        }

				        if (!$tax_html) {
				            //* Bailout, if nothing to render
				            return;
				        }

						printf('<div class="course__categories ">%s</div>', $tax_html); 
				?>
				<!-- ** Wishlist **-->

				<?php         
					$course_id = get_the_ID();
					$is_wishlisted = tutor_utils()->is_wishlisted($course_id);
					$has_wish_list = '';
					if ($is_wishlisted){
					    $has_wish_list = 'has-wish-listed';
					}

					$action_class = '';
					if ( is_user_logged_in()){
					    $action_class = apply_filters('tutor_wishlist_btn_class', 'tutor-course-wishlist-btn');
					}else{
					    $action_class = apply_filters('tutor_popup_login_class', 'cart-required-login');
					}

					echo '<span class="tutor-course-wishlist"><a href="javascript:;" class="tutor-icon-fav-line '.$action_class.' '.$has_wish_list.' " data-course-id="'.$course_id.'"></a> </span>';

				?> 

		    </div>
		    <div class="course__content">
		       <div class="course__content--info">
					<!-- ** Price **-->
		          <?php  get_template_part('templates/tutor/price_within_button'); ?>
					<!-- ** Author **-->
					<?php 
						global $post, $authordata;
						$profile_url = tutor_utils()->profile_url($authordata->ID);
						$disable_course_author = get_tutor_option('disable_course_author'); 
					?>

			        <?php if ( !$disable_course_author){ ?>

			            <div class="rt-course-author-name">
			                <?php echo get_avatar( get_the_author_meta( 'ID' ), 32 ); ?>
			                <a href="<?php echo tutor_utils()->profile_url($authordata->ID); ?>"><?php echo get_the_author(); ?></a>
			            </div>
			        <?php }  ?>
					<!-- ** Title **-->
		          <h4 class="course__title"><a class="course__media-link" href="<?php the_permalink(); ?>"><?php the_title(); ?>
		          </a>
		          </h4>


		       </div>
			<!-- ** Course total **-->
		       <div class="course__content--meta">
				<?php
					$disable_total_enrolled = get_tutor_option('disable_course_total_enrolled');
					if( !$disable_total_enrolled){ ?>
					    <span class="course-enroll"><i class="tutor-icon-user"></i> <?php echo (int) tutor_utils()->count_enrolled_users_by_course(); ?></span>
					<?php } 
		        ?>

			<!-- ** Enroll button **-->
				<?php 
				    $course_id = get_the_ID();
				    $enroll_btn = '<div  class="tutor-loop-cart-btn-wrap"><a href="'. get_the_permalink(). '">'.__('Get Enrolled', 'gostudy'). '</a></div>';
				    $price_html = '<div class="price"> '.$enroll_btn. '</div>';
				    if (tutor_utils()->is_course_purchasable()) {
				        $enroll_btn = tutor_course_loop_add_to_cart(false);

				        $product_id = tutor_utils()->get_course_product_id($course_id);
				        $product    = wc_get_product( $product_id );

				        if ( $product ) {
				            $price_html = '<div class="price"> '.$enroll_btn.' </div>';
				        }
				    }
				     echo wp_kses( $price_html, 'gostudy-default' );
				?>
		       </div>
		    </div>
		 </div>
		</article>
	<?php elseif($tutor_archive_layout == '2') : ?>
		<article class="rt-course layout-<?php echo esc_attr($tutor_archive_layout); ?>">
		 <div class="course__container">
		    <div class="course__media">

				<!-- ** Media **-->
		      <a href="<?php the_permalink(); ?>"> <?php get_tutor_course_thumbnail(); ?> </a>

				<!-- ** Category **-->

		       	<?php  
		       			$postID = get_post()->ID;
				        $tax_html = '';
				        $terms = get_the_terms($postID, 'course-category');
				        if (!empty($terms) && !is_wp_error($terms)) {
				            foreach ($terms as $cat) {
				                $tax_html .= '<a href="' . get_term_link($cat, $cat->taxonomy) . '" rel="tag">' . $cat->name . '</a>';
				            }
				        }

				        if (!$tax_html) {
				            //* Bailout, if nothing to render
				            return;
				        }

						printf('<div class="course__categories ">%s</div>', $tax_html); 
				?>
				<!-- ** Wishlist **-->

				<?php         
					$course_id = get_the_ID();
					$is_wishlisted = tutor_utils()->is_wishlisted($course_id);
					$has_wish_list = '';
					if ($is_wishlisted){
					    $has_wish_list = 'has-wish-listed';
					}

					$action_class = '';
					if ( is_user_logged_in()){
					    $action_class = apply_filters('tutor_wishlist_btn_class', 'tutor-course-wishlist-btn');
					}else{
					    $action_class = apply_filters('tutor_popup_login_class', 'cart-required-login');
					}

					echo '<span class="tutor-course-wishlist"><a href="javascript:;" class="tutor-icon-fav-line '.$action_class.' '.$has_wish_list.' " data-course-id="'.$course_id.'"></a> </span>';

				?> 

		    </div>
		    <div class="course__content">
		       <div class="course__content--info">

					<!-- ** Author **-->
					<?php 
						global $post, $authordata;
						$profile_url = tutor_utils()->profile_url($authordata->ID);
						$disable_course_author = get_tutor_option('disable_course_author'); 
					?>

			        <?php if ( !$disable_course_author){ ?>

			            <div class="rt-course-author-name">
			                <?php echo get_avatar( get_the_author_meta( 'ID' ), 32 ); ?>
			                <a href="<?php echo tutor_utils()->profile_url($authordata->ID); ?>"><?php echo get_the_author(); ?></a>
			            </div>
			        <?php }  ?>
					<!-- ** Title **-->
		          <h4 class="course__title"><a class="course__media-link" href="<?php the_permalink(); ?>"><?php the_title(); ?>
		          </a>
		          </h4>


		       </div>
			<!-- ** Course total **-->
		       <div class="course__content--meta">
				<?php
					$disable_total_enrolled = get_tutor_option('disable_course_total_enrolled');
					if( !$disable_total_enrolled){ ?>
					    <span class="course-enroll"><i class="tutor-icon-user"></i> <?php echo (int) tutor_utils()->count_enrolled_users_by_course(); ?></span>
					<?php } 
		        ?>
			<!-- ** Course Review **-->
				<?php
					$disable_course_review = get_tutor_option('disable_course_review');

			        $course_rating = tutor_utils()->get_course_rating();
			        $total_reviews = apply_filters('tutor_course_rating_count', $course_rating->rating_count);
					if( !$disable_course_review){ 
				        if ($course_rating->rating_avg > 0) {
				            printf(
				                '<span class="course-rating"><i class="flaticon-star-1"></i> %1$d</span>',
				                $total_reviews,
				            ); 
				        }
				     }
		        ?>

			<!-- ** price 2 **-->
				<?php 
		        	//ob_start();
			        get_template_part('templates/tutor/price_within_button_2');
			        //$button = ob_get_clean();
				?>
		       </div>
		    </div>
		 </div>
		</article>
	<?php elseif($tutor_archive_layout == '3') : ?>
		<article class="rt-course layout-<?php echo esc_attr($tutor_archive_layout); ?>">
		 <div class="course__container">
		    <div class="course__media">

				<!-- ** Media **-->
		      <a href="<?php the_permalink(); ?>"> <?php get_tutor_course_thumbnail(); ?> </a>

				<!-- ** Category **-->

		       	<?php  
		       			$postID = get_post()->ID;
				        $tax_html = '';
				        $terms = get_the_terms($postID, 'course-category');
				        if (!empty($terms) && !is_wp_error($terms)) {
				            foreach ($terms as $cat) {
				                $tax_html .= '<a href="' . get_term_link($cat, $cat->taxonomy) . '" rel="tag">' . $cat->name . '</a>';
				            }
				        }

				        if (!$tax_html) {
				            //* Bailout, if nothing to render
				            return;
				        }

						printf('<div class="course__categories ">%s</div>', $tax_html); 
				?>
				<!-- ** Wishlist **-->

				<?php         
					$course_id = get_the_ID();
					$is_wishlisted = tutor_utils()->is_wishlisted($course_id);
					$has_wish_list = '';
					if ($is_wishlisted){
					    $has_wish_list = 'has-wish-listed';
					}

					$action_class = '';
					if ( is_user_logged_in()){
					    $action_class = apply_filters('tutor_wishlist_btn_class', 'tutor-course-wishlist-btn');
					}else{
					    $action_class = apply_filters('tutor_popup_login_class', 'cart-required-login');
					}

					echo '<span class="tutor-course-wishlist"><a href="javascript:;" class="tutor-icon-fav-line '.$action_class.' '.$has_wish_list.' " data-course-id="'.$course_id.'"></a> </span>';

				?> 

		    </div>
		    <div class="course__content">
		       <div class="course__content--info">

					<!-- ** Author **-->
					<?php 
						global $post, $authordata;
						$profile_url = tutor_utils()->profile_url($authordata->ID);
						$disable_course_author = get_tutor_option('disable_course_author'); 
					?>

			        <?php if ( !$disable_course_author){ ?>

			            <div class="rt-course-author-name">
			                <?php echo get_avatar( get_the_author_meta( 'ID' ), 32 ); ?>
			                <a href="<?php echo tutor_utils()->profile_url($authordata->ID); ?>"><?php echo get_the_author(); ?></a>
			            </div>
			        <?php }  ?>
					<!-- ** Title **-->
		          <h4 class="course__title"><a class="course__media-link" href="<?php the_permalink(); ?>"><?php the_title(); ?>
		          </a>
		          </h4>

				<!-- ** Course Review **-->
				<?php
					$disable_course_review = get_tutor_option('disable_course_review');

			        $course_rating = tutor_utils()->get_course_rating();
			        $total_reviews = apply_filters('tutor_course_rating_count', $course_rating->rating_count);
					if( !$disable_course_review){ ?>
						<div class="course-meta">
					        <?php if ($course_rating->rating_avg > 0) {
					            printf(
					                '<span class="course-rating"><i class="flaticon-star-1"></i> %1$d</span>',
					                $total_reviews,
					            ); 
					        }?>
						</div>
				     <?php
				     }
		        ?>
		       </div>
			<!-- ** Course total **-->
		       <div class="course__content--meta">
				<?php
					$disable_total_enrolled = get_tutor_option('disable_course_total_enrolled');
					if( !$disable_total_enrolled){ ?>
					    <span class="course-enroll"><i class="tutor-icon-user"></i> <?php echo (int) tutor_utils()->count_enrolled_users_by_course(); ?></span>
					<?php } 
		        ?>

			<!-- ** price 2 **-->
				<?php 
		        	//ob_start();
			        get_template_part('templates/tutor/price_within_button_2');
			        //$button = ob_get_clean();
				?>
		       </div>
		    </div>
		 </div>
		</article>
	<?php endif ?>

