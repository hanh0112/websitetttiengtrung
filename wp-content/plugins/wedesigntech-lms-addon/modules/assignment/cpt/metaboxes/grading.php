<div class="dtlms-custom-box">

    <div class="dtlms-column dtlms-one-half first">

        <div class="dtlms-column dtlms-one-third first"><?php esc_html_e( 'Item Type', 'dtlms');?></div>
        <div class="dtlms-column dtlms-two-third">
            <?php echo esc_html__( 'Assignment', 'dtlms' ); ?>
        </div>

    </div>

    <div class="dtlms-column dtlms-one-half">

    </div>

</div>

<div class="dtlms-custom-box">

    <div class="dtlms-column dtlms-one-half first">

        <div class="dtlms-column dtlms-one-third first"><?php esc_html_e( 'Course', 'dtlms');?></div>
        <div class="dtlms-column dtlms-two-third">
            <strong><?php echo get_the_title($course_id); ?></strong>
        </div>

    </div>

    <div class="dtlms-column dtlms-one-half">

        <div class="dtlms-column dtlms-one-third first"><?php esc_html_e( 'User Name', 'dtlms');?></div>
        <div class="dtlms-column dtlms-two-third">
            <strong><?php echo esc_html($user_info->display_name); ?></strong>
        </div>

    </div>

</div>

<div class="dtlms-custom-box">

    <div class="dtlms-column dtlms-one-half first">

        <div class="dtlms-column dtlms-one-third first"><?php esc_html_e( 'Notes', 'dtlms');?></div>
        <div class="dtlms-column dtlms-two-third">
            <?php
            $assignment_notes = get_post_meta ($post_id, 'assignment-notes', true);
            if($assignment_notes != '') {
            echo nl2br($assignment_notes);
            }
            ?>
        </div>
    </div>

    <div class="dtlms-column dtlms-one-half">

        <div class="dtlms-column dtlms-one-third first"><?php esc_html_e( 'Attachment', 'dtlms');?></div>
        <div class="dtlms-column dtlms-two-third">
            <?php

            $attachment_id = get_post_meta ($post_id, 'attachment-id', true);
            $attachment_name = get_post_meta ($post_id, 'attachment-name', true);

            if(is_array($attachment_id) && !empty($attachment_id)) {
                $i = 0;
                foreach($attachment_id as $attachmentid) {
                echo '<div class="dtlms-attachments-link">';
                    echo '<img src="'.DTLMS_PLUGIN_URL . 'assets/images/attachment.png'.'" />';
                    echo '<p>';
                    echo dtlms_html_output($attachment_name[$i]);
                    echo '</p>';
                    echo '<a href="'.wp_get_attachment_url($attachmentid).'" target="_blank">'.esc_html__('View Attachment', 'dtlms').'</a>';
                echo '</div>';

                $i++;

                }
            } else {
                echo esc_html__('No attachments found!', 'dtlms');
            }

            ?>
        </div>

    </div>

</div>

<div class="dtlms-custom-box">

    <div class="dtlms-column dtlms-one-half first">

        <div class="dtlms-column dtlms-one-third first"><?php esc_html_e( 'Marks Obtained', 'dtlms');?></div>
        <div class="dtlms-column dtlms-two-third">
            <?php $marks_obtained = get_post_meta ($post_id, 'marks-obtained', true);  ?>
            <input id="dtlms-marks-obtained" name="dtlms-marks-obtained" class="large" type="number" value="<?php echo esc_attr($marks_obtained); ?>" style="width:20%;" <?php echo esc_attr($input_graded_attr); ?> />
        </div>

    </div>

    <div class="dtlms-column dtlms-one-half">

        <div class="dtlms-column dtlms-one-third first"><?php esc_html_e( 'Maximum Marks', 'dtlms');?></div>
        <div class="dtlms-column dtlms-two-third">
            <?php
            $maximum_mark = get_post_meta ($assignment_id, 'assignment-maximum-mark', true);
            if($maximum_mark == '') {
            $maximum_mark = 100;
            }
            ?>
            <?php echo esc_html($maximum_mark); ?>
            <input id="dtlms-maximum-marks" name="dtlms-maximum-marks" class="large" type="hidden" value="<?php echo esc_attr($maximum_mark); ?>" />
        </div>

    </div>

</div>

<div class="dtlms-custom-box">

    <div class="dtlms-column dtlms-one-half first">

        <div class="dtlms-column dtlms-one-third first"><?php esc_html_e( 'Percentage Obtained (%)', 'dtlms');?></div>
        <div class="dtlms-column dtlms-two-third">
            <?php $marks_obtained_percent = get_post_meta ( $post_id, 'marks-obtained-percentage', true);  ?>
            <input type="text" name="dtlms-marks-obtained-percentage" id="dtlms-marks-obtained-percentage" value="<?php echo esc_attr($marks_obtained_percent); ?>" readonly="readonly"  />
        </div>

    </div>

    <div class="dtlms-column dtlms-one-half">

        <div class="dtlms-column dtlms-one-third first"><?php esc_html_e( 'Pass Percentage (%)', 'dtlms');?></div>
        <div class="dtlms-column dtlms-two-third">
            <?php
            $pass_percentage = get_post_meta ($assignment_id, 'assignment-pass-percentage', true);
            if($pass_percentage == '') {
            $pass_percentage = 100;
            }
            ?>
            <?php echo esc_html($pass_percentage); ?>
        </div>

    </div>

</div>

<div class="dtlms-custom-box">

    <div class="dtlms-column dtlms-one-half first">

        <div class="dtlms-column dtlms-one-third first"><?php esc_html_e( 'Review or Feedback', 'dtlms');?></div>
        <div class="dtlms-column dtlms-two-third">
            <?php $review_or_feedback = get_post_meta ($post_id, 'review-or-feedback', true); ?>
            <textarea id="review-or-feedback" name="review-or-feedback" class="large" rows="6" style="width:90%;"><?php echo dtlms_html_output($review_or_feedback); ?></textarea>
            <p class="dtlms-note"> <?php esc_html_e('You can add feedback or review for this item here, which will displayed to that student.','dtlms');?> </p>
        </div>

    </div>

    <div class="dtlms-column dtlms-one-half">

        <div class="dtlms-column dtlms-one-third first"><?php esc_html_e( 'Graded', 'dtlms');?></div>
        <div class="dtlms-column dtlms-two-third">
            <?php
            $graded = get_post_meta ($post_id, 'graded', true);
            $switchclass = ($graded != '') ? 'checkbox-switch-on' : 'checkbox-switch-off';
            $checked = ($graded != '') ? ' checked="checked"' : '';
            ?>
            <div data-for="graded" class="dtlms-checkbox-switch <?php echo esc_attr($switchclass.' '.$course_graded_class);?>"></div>
            <input id="graded" class="hidden" type="checkbox" name="graded" value="true" <?php echo dtlms_html_output($checked); ?> />
            <p class="dtlms-note"><?php esc_html_e('Once you enable this option, then this user can\'t resubmit this item and it will be marked as completed!','dtlms');?></p>
        </div>

    </div>

</div>

<div class="dtlms-custom-box">
    <p class="dtlms-note"><?php esc_html_e('Once course to which this assignment belongs to is graded you can\'t regrade this item.','dtlms');?></p>
</div>