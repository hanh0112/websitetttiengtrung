<div class="dtlms-custom-box">

	<div class="dtlms-column dtlms-one-half first">

        <div class="dtlms-column dtlms-one-third first">
            <label><?php esc_html_e('Content Options', 'dtlms'); ?></label>
        </div>
        <div class="dtlms-column dtlms-two-third">
            <?php
            $class_content_options_value = get_post_meta ( $post_id, 'dtlms-class-content-options', TRUE );

            $course_hide_cls = 'style="display:none;"';
            $shortcode_hide_cls = 'style="display:none;"';
			if($class_content_options_value == 'shortcode') {
				$shortcode_hide_cls = 'style="display:block;"';
            } else if($class_content_options_value == 'course') {
                $course_hide_cls = 'style="display:block;"';
			}

            $class_content_options = array ('' => 'None', 'course' => 'Add Course', 'shortcode' => 'Add Shortcodes');

            $out = '';
            $out .= '<select id="dtlms-class-content-options" name="dtlms-class-content-options" style="width:70%;" data-placeholder="'.esc_html__('Select Content Options...', 'dtlms').'" class="dtlms-chosen-select">' . "\n";
			foreach ($class_content_options as $class_content_key => $class_content_value){
				$out .= '<option value="' . esc_attr( $class_content_key ) . '"' . selected( $class_content_key, $class_content_options_value, false ) . '>' . esc_html( $class_content_value ) . '</option>' . "\n";
			}
            $out .= '</select>' . "\n";
            echo dtlms_html_output($out);
            ?>
            <p class="dtlms-note"> <?php esc_html_e('Choose your content type here.', 'dtlms'); ?> </p>
        </div>

	</div>

</div>

<div class="dtlms-custom-box">

    <div class="dtlms-column dtlms-one-sixth first">
        <label><?php esc_html_e('Content Title', 'dtlms'); ?></label>
    </div>
    <div class="dtlms-column dtlms-five-sixth">
        <?php $dt_class_content_title = get_post_meta($post_id, "dtlms-class-content-title", true);?>
        <input class="dtlms-class-content-title" name="dtlms-class-content-title" type="text" value="<?php echo esc_attr($dt_class_content_title);?>" style="width:80%;" />
        <p class="dtlms-note"> <?php esc_html_e("Add title for your content here.", 'dtlms'); ?> </p>
        <div class="dtlms-clear"></div>
    </div>

</div>

<div class="dtlms-course-content" <?php echo dtlms_html_output($course_hide_cls); ?>>

    <div class="dtlms-custom-box">

    	<div class="dtlms-column dtlms-one-sixth first">

           <label><?php esc_html_e('Add Courses', 'dtlms'); ?></label>

    	</div>
    	<div class="dtlms-column dtlms-five-sixth">

            <?php
            $courses_args = array( 'post_type' => 'dtlms_courses', 'numberposts' => -1, 'orderby' => 'date', 'order' => 'DESC', 'suppress_filters' => FALSE );
            if ( !in_array( 'administrator', (array) $current_user->roles ) ) {
                $courses_args['author'] = $current_user_id;
            }

            $courses_array = get_posts( $courses_args );
    		?>

        	<div id="dtlms-class-courses-container">

            	<?php
    			$class_courses = get_post_meta ( $post_id, "dtlms-class-courses", true);

    			$j = 0;
    			if(isset($class_courses) && is_array($class_courses)) {
    				foreach($class_courses as $class_course) {
    				    ?>
    					<div class="dtlms-course-box">

    						<?php
    						echo '<select class="dtlms-class-courses dtlms-chosen-select" name="dtlms-class-courses[]" data-placeholder="'.sprintf( esc_html__('Choose a %1$s', 'dtlms'), $class_title_singular ).'" style="width:80%;">';
            						echo '<option value="">'.esc_html__('None', 'dtlms').'</option>';
            						if ( count( $courses_array ) > 0 ) {
            							foreach ($courses_array as $course) {
            								echo '<option value="' . esc_attr( $course->ID ) . '"' . selected( $course->ID, $class_course, false ) . '>' . esc_html( $course->post_title ) . '</option>';
            							}
            						}
    						echo '</select>';
    						?>

    						<span class="dtlms-remove-course"><span class="fas fa-times"></span></span>
                            <span class="fas fa-arrows-alt"></span>

    					</div>
    				    <?php
    				    $j++;
    				}
    			}
    			?>

            </div>

            <a href="#" class="dtlms-add-course custom-button-style"><?php esc_html_e('Add Course', 'dtlms'); ?></a>
            <p class="dtlms-note"> <?php esc_html_e('You can add course here.', 'dtlms'); ?> </p>

        	<div id="dtlms-course-to-clone" class="hidden">

    			<?php
                echo '<select data-placeholder="'.esc_html__('Choose a Course...', 'dtlms').'" style="width:80%;">';
                        echo '<option value="">'.esc_html__('None', 'dtlms').'</option>';
                        if ( count( $courses_array ) > 0 ) {
                            foreach ($courses_array as $course) {
                                echo '<option value="' . esc_attr( $course->ID ) . '">' . esc_html( $course->post_title ) . '</option>' ;
                            }
                        }
                echo '</select>'
                ?>
                <span class="dtlms-remove-course"><span class="fas fa-times"></span></span>
                <span class="fas fa-arrows-alt"></span>

            </div>

    	</div>

    </div>

</div>

<div class="dtlms-shortcode-content" <?php echo dtlms_html_output($shortcode_hide_cls); ?>>

    <div class="dtlms-custom-box">
    	<div class="dtlms-column dtlms-one-sixth first">

           <label><?php esc_html_e('Add Shortcode', 'dtlms'); ?></label>

    	</div>
    	<div class="dtlms-column dtlms-five-sixth">

    		<?php $class_shortcode = get_post_meta ( $post_id, "dtlms-class-shortcode", true); ?>
            <textarea class="dtlms-class-shortcode" name="dtlms-class-shortcode" type="text" style="width:80%; height:100px"><?php echo dtlms_html_output($class_shortcode); ?></textarea>
            <p class="dtlms-note"> <?php esc_html_e("Add any shortcode here. If you wish you can make use of \"Timetable Wordpress Plugin - Weekly Class Schedule\" plugin shortcode.", 'dtlms'); ?> </p>
            <div class="dtlms-clear"></div>

    	</div>
    </div>

</div>