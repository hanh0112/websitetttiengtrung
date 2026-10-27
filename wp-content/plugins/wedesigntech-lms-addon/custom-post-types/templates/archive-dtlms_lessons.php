<?php get_header('dtlms'); ?>

    <?php
    /**
    * dtlms_before_main_content hook.
    */
    do_action( 'dtlms_before_main_content' );
    ?>

        <?php
        /**
        * dtlms_before_content hook.
        */
        do_action( 'dtlms_before_content' );
        ?>

			<?php
	        $out ='';
			$out .= '<div class="dtlms-container">';

				
                $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
                $args = array (
                    'paged'          => $paged,
                    'posts_per_page' => 10,
                    'post_type'      => 'dtlms_lessons'
                );

                $archive_query = new WP_Query( $args );

					if( $archive_query -> have_posts() ) {
                        $out .= '<ol class="dt-sc-lessons-list">';
                            while( $archive_query -> have_posts() ) {
                                $archive_query -> the_post();
                                $lesson_id = get_the_ID();

                                $exceprt = wp_trim_words(get_the_excerpt(), 30);

                                $free_lesson = get_post_meta ( $lesson_id, 'free-lesson', true );
                                if(isset($free_lesson) && $free_lesson == true) {
                                    $private_lesson = 'class="dtlms-hidden-lesson"';
                                } else {
                                    $private_lesson = '';
                                }

                                $lesson_duration = get_post_meta ( $lesson_id, 'duration', true );
                                $lesson_duration_parameter = get_post_meta ( $lesson_id, 'duration-parameter', true );
                                $lesson_duration_in_seconds = ((int)$lesson_duration * (int)$lesson_duration_parameter);
                                $terms = get_the_terms($post->ID,'lesson_complexity');

                                $lesson_terms = '';
                                    if(isset($terms) && !empty($terms)) {
                                        $lesson_terms = array();
                                        foreach ( $terms as $term ) {
                                            if($private_lesson != '') {
                                            $lesson_terms[] = $term->name;
                                            } else {
                                            $lesson_terms[] = '<a href="'.get_term_link( $term->slug, 'lesson_complexity' ).'">'.$term->name.'</a>';
                                            }
                                        }
                                            $lesson_terms = join( ", ", $lesson_terms );
                                    }

                            $out .= '<li '.$private_lesson.'>';
                                if($private_lesson != '') {
                                    $out .= '<div class="hidden-lesson-overlay"> </div>';
                                }
                            $out .= '<article class="dt_lessons">
                                        <div class="lesson-title">';
                                            if($free_lesson == true) {
                                                $out .= '<h2>'.$post->post_title.'</h2>';
                                            } else {
                                                $out .= '<h2> <a href="'.get_permalink($post->ID).'" title="'.$post->post_title.'">'.$post->post_title.'</a> </h2>';
                                           }
                                        $out .= '<div class="lesson-metadata">';
                                                if($lesson_terms != '') { 
                                                    $out .= '<p> <i class="fa fa-tags"> </i> '.$lesson_terms.' </p>';
                                                }                       
                                                $lesson_teacher = '';
                                                $teacher = get_post_meta($lesson_id, 'teacher', true);
                                                    $args = array( 'role' => 'instructor' );
                                                    $user_query = new WP_User_Query( $args );
                                                    if ( !empty( $user_query->results ) ) {
                                                        foreach ( $user_query->results as $user ) {
                                                            $teachername= $user->display_name;
                                                        }
                                                    }
                                                if(isset($teacher) && $teacher != '') {
                                                    $lesson_teacher = '<p> <i class="fa fa-user"></i> <a href="'.get_permalink($teacher).'">'.$teachername.'</a></p>';
                                                }
                                                $out .='<p> <i class="fa fa-clock"> </i>'.dtlms_convert_seconds_to_readable_format($lesson_duration_in_seconds, 'style4').'</p>';
                                                $out .= $lesson_teacher.'
                                                </div>
                                        </div>

                                        <div class="lesson-details">'.$exceprt.'</div>
                                    </article>';
                            $out .= '</li>';	
                            }
                            $out .= '</ol>';
                        }

                        $out .= dtlms_lessons_listing_pagination($archive_query, $paged);
                $out .=  '</div>';

                echo $out;

            echo '<div class="dtlms-course-detail-sidebar-content">';
                dynamic_sidebar('wdt-cw-lms-left-side');
            echo '</div>';
            
			?>

		<?php
		/**
		* dtlms_after_content hook.
		*/
		do_action( 'dtlms_after_content' );
		?>

	<?php
	/**
	* dtlms_after_main_content hook.
	*/
	do_action( 'dtlms_after_main_content' );
	?>

<?php get_footer('dtlms'); ?>