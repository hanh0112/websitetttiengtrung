<?php $submitted = get_post_meta ($post_id, 'submitted', true); ?>

<div class="dtlms-custom-box">
    <div class="dtlms-column dtlms-one-half first">
        <h3><?php echo sprintf( esc_html__( '%1$s Grading', 'dtlms' ), $class_singular_label ); ?></h3>
    </div>
    <div class="dtlms-column dtlms-one-half">
    </div>
</div>

<div class="dtlms-custom-box">

    <div class="dtlms-column dtlms-one-half first">

        <div class="dtlms-column dtlms-one-third first"><?php esc_html_e( 'User Name', 'dtlms');?></div>
        <div class="dtlms-column dtlms-two-third">
            <strong><?php echo esc_html($user_info->display_name); ?></strong>
        </div>

    </div>

    <div class="dtlms-column dtlms-one-half">

        <div class="dtlms-column dtlms-one-third first"><?php esc_html_e( 'Review or Feedback', 'dtlms');?></div>
        <div class="dtlms-column dtlms-two-third">
            <?php $review_or_feedback = get_post_meta ($post_id, 'review-or-feedback', true); ?>
            <textarea id="review-or-feedback" name="review-or-feedback" class="large" rows="4" style="width:90%;"><?php echo dtlms_html_output($review_or_feedback); ?></textarea>
            <p class="dtlms-note"> <?php esc_html_e('You can add feedback or review for this item here, which will displayed to that student.','dtlms');?> </p>
        </div>

    </div>

</div>

<?php
if($submitted != '1') {
    ?>
    <div class="dtlms-custom-box">
    <p class="dtlms-note"><strong><?php echo esc_html__('User haven\'t submitted this class yet!', 'dtlms'); ?></strong></p>
    </div>
    <?php
}
?>

<div class="dtlms-custom-box">

    <h3><?php esc_html_e('Courses', 'dtlms'); ?></h3>

    <?php

    $class_curriculum_details = get_user_meta($user_id, $class_id, true);

    $class_courses = get_post_meta($class_id, 'dtlms-class-courses', true);

    $total_count = 0;
    if(is_array($class_courses) && !empty($class_courses)) {
    $total_count = count($class_courses);
    }


    if(is_array($class_courses) && !empty($class_courses)) {

    echo '<table class="dtlms-custom-table" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col">'.esc_html__('#', 'dtlms').'</th>
                <th scope="col">'.esc_html__('Course', 'dtlms').'</th>
                <th scope="col" class="aligncenter">'.esc_html__('Percentage Achieved', 'dtlms').'</th>
                <th scope="col" class="aligncenter">'.esc_html__('Status', 'dtlms').'</th>
                <th scope="col" class="aligncenter">'.esc_html__('Options', 'dtlms').'</th>
            </tr>';

    $total_percentage = 0;
    $i = 1;
    foreach($class_courses as $course_id) {

        $curriculum_details = get_user_meta($user_id, $course_id, true);

        $course_grade_id = (isset($curriculum_details['grade-post-id']) && $curriculum_details['grade-post-id'] != '') ? $curriculum_details['grade-post-id'] : -1;

        $course_user_percentage = get_post_meta ($course_grade_id, 'user-percentage', true);
        $course_user_percentage = (isset($course_user_percentage) && !empty($course_user_percentage)) ? $course_user_percentage : 0;

        $total_percentage = $total_percentage + $course_user_percentage;
        if($course_user_percentage != '' && $course_user_percentage >= 0) {
            $course_user_percentage = $course_user_percentage.'%';
        }

        $status = esc_html__('Pending', 'dtlms');
        if(isset($curriculum_details['completed']) && $curriculum_details['completed'] == 1) {
            $status = esc_html__('Completed', 'dtlms');
        } else if(isset($curriculum_details['submitted']) && $curriculum_details['submitted'] == 1) {
            $status = esc_html__('Submitted', 'dtlms');
        } else if(isset($curriculum_details['started']) && $curriculum_details['started'] == 1) {
            $status = esc_html__('Started', 'dtlms');
        }

        $option_html = '';
        if($course_grade_id > 0) {
            $option_html = '<a href="'.esc_url(get_edit_post_link($course_grade_id)).'" target="_blank">'.esc_html__('Edit','dtlms').'</a>';
        }

        echo '<tr>
                <td>'.$i.'</td>
                <td>'.get_the_title($course_id).'</td>
                <td class="aligncenter">'.$course_user_percentage.'</td>
                <td class="aligncenter">'.$status.'</td>
                <td class="aligncenter">'.$option_html.'</td>
            </tr>';

        $i++;

    }

    echo '</table>';

    }

    ?>

</div>

<?php
if($submitted == '1') {
    ?>
    <div class="dtlms-custom-box">
    <div class="dtlms-column dtlms-two-third first">

        <div class="dtlms-column dtlms-one-third first"><?php esc_html_e( 'Graded', 'dtlms');?></div>
        <div class="dtlms-column dtlms-two-third">
            <?php
            $graded = get_post_meta ($post_id, 'graded', true);
            $switchclass = ($graded != '') ? 'checkbox-switch-on' : 'checkbox-switch-off';
            $checked = ($graded != '') ? ' checked="checked"' : '';
            ?>
            <div data-for="graded" class="dtlms-checkbox-switch dtlms-update-revoke-user-submission <?php echo esc_attr($switchclass);?>"></div>
            <input id="graded" class="hidden" type="checkbox" name="graded" value="true" <?php echo dtlms_html_output($checked); ?> />
            <p class="dtlms-note"><?php esc_html_e('Once you enable this option, then this class will be marked as completed!', 'dtlms');?></p>
        </div>

        <div class="dtlms-hr-invisible"></div>

        <a class="dtlms-button small dtlms-revoke-user-submission <?php echo esc_attr($class_graded_class); ?>" data-classid="<?php echo esc_attr($class_id); ?>" data-courseid="-1" data-userid="<?php echo esc_attr($user_id); ?>" data-itemtype="class" href="#"><?php echo esc_html__('Revoke User Submission', 'dtlms'); ?></a>

    </div>
    <div class="dtlms-column dtlms-one-third">
        <?php

        if(in_array('certificate', $dtlms_modules) || in_array('badge', $dtlms_modules)) {

            $enable_certificate = get_post_meta($class_id, 'enable-certificate', true);

            $user_percentage = 0;
            if($total_count > 0) {
            $user_percentage = round(($total_percentage / $total_count), 2);
            }

            echo '<table class="dtlms-custom-table" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <th class="aligncenter"></th>
                        <th class="aligncenter"></th>
                        <th class="aligncenter">'.esc_html__('Approve', 'dtlms').'</th>
                    </tr>
                    <tr>
                        <td class="aligncenter">'.esc_html__('User Percentage', 'dtlms').'</td>
                        <td class="aligncenter">'.$user_percentage.'%';

                        echo '<input id="user-percentage" name="user-percentage" type="hidden" value="'.$user_percentage.'" />';

                echo '</td>
                        <td class="aligncenter"></td>
                    </tr>';

                if(in_array('certificate', $dtlms_modules)) {

                    if($enable_certificate == 'true') {

                        $certificate_percentage = get_post_meta($class_id, 'certificate-percentage', true );

                        $certificate_switch_html = '';
                        if($user_percentage > $certificate_percentage) {

                            $switchclass = 'checkbox-switch-on';
                            $checked = 'checked="checked"';

                            $certificate_achieved = get_post_meta($post_id, 'certificate-achieved', true);
                            if($certificate_achieved == 'true') {
                                $switchclass = 'checkbox-switch-on';
                                $checked = 'checked="checked"';
                            } else {
                                $switchclass = 'checkbox-switch-off';
                                $checked = '';
                            }

                            $certificate_switch_html = '<div data-for="certificate-achieved" class="dtlms-checkbox-switch '.$switchclass.'"></div><input id="certificate-achieved" class="hidden" type="checkbox" name="certificate-achieved" value="true" '.$checked.' />';

                        } else {

                        delete_post_meta ( $post_id, 'certificate-achieved' );
                        $certificate_switch_html = '';

                        }

                        echo '<tr>
                                <td class="aligncenter">'.esc_html__('Certificate Percentage', 'dtlms').'</td>
                                <td class="aligncenter">'.$certificate_percentage.'%</td>
                                <td class="aligncenter">'.$certificate_switch_html.'</td>
                            </tr>';

                    }

                }

                if(in_array('badge', $dtlms_modules)) {

                    $enable_badge = get_post_meta($class_id, 'enable-badge', true);
                    if($enable_badge == 'true') {

                        $badge_percentage = get_post_meta($class_id, 'badge-percentage', true);

                        $badge_switch_html = '';
                        if($user_percentage > $badge_percentage) {

                        $badge_achieved = get_post_meta($post_id, 'badge-achieved', true);
                        if($badge_achieved == 'true') {
                            $switchclass = 'checkbox-switch-on';
                            $checked = 'checked="checked"';
                        } else {
                            $switchclass = 'checkbox-switch-off';
                            $checked = '';
                        }

                        $badge_switch_html = '<div data-for="badge-achieved" class="dtlms-checkbox-switch '.$switchclass.'"></div><input id="badge-achieved" class="hidden" type="checkbox" name="badge-achieved" value="true" '.$checked.' />';

                        } else {

                        delete_post_meta ( $post_id, 'badge-achieved' );
                        $badge_switch_html = '';

                        }

                        echo '<tr>
                                <td class="aligncenter">'.esc_html__('Badge Percentage', 'dtlms').'</td>
                                <td class="aligncenter">'.$badge_percentage.'%</td>
                                <td class="aligncenter">'.$badge_switch_html.'</td>
                            </tr>';

                    }

                }

            echo '</table>';

        }

        ?>
    </div>
    </div>

    <div class="dtlms-custom-box">
    <div class="dtlms-column dtlms-two-third first">

    </div>
    <div class="dtlms-column dtlms-one-third">
        <?php

        if($enable_certificate == 'true' && in_array('certificate', $dtlms_modules)) {

            echo '<table class="dtlms-custom-table" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="aligncenter">'.esc_html__('Date On Certificate', 'dtlms').'</td>
                        <td class="aligncenter">';

                        $date_on_certificate = get_post_meta($post_id, 'date-on-certificate', true);
                        if($date_on_certificate == '') {
                            $date_on_certificate = get_the_date(get_option('date_format'));
                        }
                        echo '<input id="date-on-certificate" name="date-on-certificate" class="date-on-certificate dtlms-datepicker" class="large" type="text" value="'.$date_on_certificate.'" readonly />';

                    echo '</td>
                    </tr>
                </table>';

        }

        ?>
    </div>
    </div>
    <?php
}
?>