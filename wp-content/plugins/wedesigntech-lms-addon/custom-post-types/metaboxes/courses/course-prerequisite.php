<div class="dtlms-custom-box">

    <!-- Course Prerequisite -->
    <div class="dtlms-column dtlms-one-half first">

        <div class="dtlms-column dtlms-one-third first">
           <label><?php esc_html_e('Course Prerequisite', 'dtlms'); ?></label>
        </div>
        <div class="dtlms-column dtlms-two-third">
            <?php
            $course_prerequisite = get_post_meta ( $post_id, 'course-prerequisite', true );
            $args = array (
                            'post_type'=> 'dtlms_courses',
                            'numberposts'=> -1,
                            'suppress_filters'  => FALSE,
                            'exclude' => $post_id
                        );

            $post_types = get_posts($args);

            echo '<select data-placeholder="'.esc_html__('Select...', 'dtlms').'" class="course-prerequisite dtlms-chosen-select" name="course-prerequisite">';
                echo '<option value="">' .esc_html__('None', 'dtlms') . '</option>';
                foreach ( $post_types as $post_type ){
                    echo '<option value="'.$post_type->ID.'" '.selected( $post_type->ID, $course_prerequisite, false ).'>' . $post_type->post_title . '</option>';
                }
            echo '</select>';

            wp_reset_postdata();
            ?>
            <p class="dtlms-note">
                <?php esc_html_e('Course pre reuired to take this course.','dtlms');?>
                <?php echo "<br>"; ?>
                <?php esc_html_e('You can do further configuration in Settings -> General -> Course Settings.','dtlms');?>
            </p>
        </div>

    </div>
    <!-- Course Prerequisite End -->

    <!-- Allow Purchases Before Course Prerequisite -->
    <div class="dtlms-column dtlms-one-half">

        <div class="dtlms-column dtlms-one-third first"><?php esc_html_e( 'Allow Purchases Before Course Prerequisite', 'dtlms');?></div>
        <div class="dtlms-column dtlms-two-third">
            <?php
            $current = get_post_meta($post_id, 'allowpurchases-before-course-prerequisite', true);
            $switchclass = ( $current === "true") ? 'checkbox-switch-on' :'checkbox-switch-off';
            $checked = ( $current === "true") ? ' checked="checked" ' : '';
            ?>
            <div data-for="allowpurchases-before-course-prerequisite" class="dtlms-checkbox-switch <?php echo esc_attr($switchclass); ?>"></div>
            <input id="allowpurchases-before-course-prerequisite" class="hidden" type="checkbox" name="allowpurchases-before-course-prerequisite" value="true" <?php echo dtlms_html_output($checked); ?> />
            <p class="dtlms-note"> <?php esc_html_e('If you like to allow student to make purchases before submitting or completing prerequisite course, but they won\'t be able to take course until course prerequisite submitted or completed.', 'dtlms');?> </p>
        </div>

    </div>
    <!-- Allow Purchases Before Course Prerequisite End -->

</div>