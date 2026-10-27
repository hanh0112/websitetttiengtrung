<?php
global $post;
$post_id = $post->ID;

echo '<input type="hidden" name="dtlms_gradings_meta_nonce" value="'.wp_create_nonce('dtlms_gradings_nonce').'" />';

$user_id         = get_post_meta ( $post_id, 'dtlms-user-id', true );
$user_info       = get_userdata($user_id);

$class_id        = get_post_meta ( $post_id, 'dtlms-class-id', true );
$class_grade_id  = get_post_meta ( $post_id, 'dtlms-class-grade-id', true );
$course_id       = get_post_meta ( $post_id, 'dtlms-course-id', true );
$course_grade_id = get_post_meta ( $post_id, 'dtlms-course-grade-id', true );
$lesson_id       = get_post_meta ( $post_id, 'dtlms-lesson-id', true );
$quiz_id         = get_post_meta ( $post_id, 'dtlms-quiz-id', true );
$assignment_id   = get_post_meta ( $post_id, 'dtlms-assignment-id', true );

$grade_type      = get_post_meta ( $post_id, 'grade-type', true );

$course_graded = get_post_meta ($course_grade_id, 'graded', true);
$course_graded_class = $input_graded_attr = '';
if($course_graded == 'true') {
  $course_graded_class = 'disabled';
  $input_graded_attr = 'readonly';
}

$class_graded = get_post_meta ($class_grade_id, 'graded', true);
$class_graded_class = '';
if($grade_type == 'class' && $class_graded == 'true') {
  $class_graded_class = 'disabled';
}

$class_singular_label = apply_filters( 'class_label', 'singular' );

$dtlms_modules = dtlms_instance()->active_modules;
$dtlms_modules = (is_array($dtlms_modules) && !empty($dtlms_modules)) ? $dtlms_modules : array ();

if($grade_type == 'class' && in_array('class', $dtlms_modules)) {

    require_once DTLMS_CLASS_PLUGIN_PATH . 'cpt/metaboxes/grading.php';

} else if($grade_type == 'course') {

  $submitted = get_post_meta ($post_id, 'submitted', true);

  $completed_count = get_post_meta($post_id, 'completed-count', true);
  ?>

  <div class="dtlms-custom-box">

      <div class="dtlms-column dtlms-one-half first">
        <h3><?php esc_html_e( 'Course Grading', 'dtlms');?></h3>
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
      <p class="dtlms-note"><strong><?php echo esc_html__('User haven\'t submitted this course yet!', 'dtlms'); ?></strong></p>
     </div>
    <?php
  }
  ?>

  <div class="dtlms-custom-box">

    <h3><?php esc_html_e('Course Curriculum', 'dtlms'); ?></h3>

    <?php

    $user_percentage = $total_percentage = 0;

    $curriculum_details = get_user_meta($user_id, $course_id, true);

    $course_curriculum = get_post_meta ($course_id, 'course-curriculum', true);

    if(is_array($course_curriculum) && !empty($course_curriculum)) {

      echo '<table class="dtlms-custom-table" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <th scope="col">'.esc_html__('#', 'dtlms').'</th>
                <th scope="col">'.esc_html__('Curriculum', 'dtlms').'</th>
                <th scope="col">'.esc_html__('Sub - Curriculum', 'dtlms').'</th>
                <th scope="col">'.esc_html__('Type', 'dtlms').'</th>
                <th scope="col" class="aligncenter">'.esc_html__('Pass Percentage', 'dtlms').'</th>
                <th scope="col" class="aligncenter">'.esc_html__('Marks Obtained', 'dtlms').'</th>
                <th scope="col" class="aligncenter">'.esc_html__('Marks Obtained Percentage', 'dtlms').'</th>
                <th scope="col" class="aligncenter">'.esc_html__('Status', 'dtlms').'</th>
                <th scope="col" class="aligncenter">'.esc_html__('Options', 'dtlms').'</th>
              </tr>';

      $i = 1; $total_count = 0;
      foreach($course_curriculum as $curriculum) {

        if(is_numeric($curriculum)) {

          $marks_obtained = isset($curriculum_details['curriculum'][$curriculum]['marks-obtained']) ? $curriculum_details['curriculum'][$curriculum]['marks-obtained'] : '';
          $marks_obtained_percentage = isset($curriculum_details['curriculum'][$curriculum]['marks-obtained-percentage']) ? $curriculum_details['curriculum'][$curriculum]['marks-obtained-percentage'] : 0;

          $total_percentage = $total_percentage + $marks_obtained_percentage;
          if($marks_obtained_percentage != '') {
            $marks_obtained_percentage = $marks_obtained_percentage.'%';
          }
          $completed = (isset($curriculum_details['curriculum'][$curriculum]['completed']) && $curriculum_details['curriculum'][$curriculum]['completed'] == 1) ? esc_html__('Completed', 'dtlms') : '';

          $option_html = '';
          $curriculum_grade_id = (isset($curriculum_details['curriculum'][$curriculum]['grade-post-id']) && $curriculum_details['curriculum'][$curriculum]['grade-post-id'] != '') ? $curriculum_details['curriculum'][$curriculum]['grade-post-id'] : -1;

          if($curriculum_grade_id > 0) {
            $option_html = '<a href="'.esc_url(get_edit_post_link($curriculum_grade_id)).'" target="_blank">'.esc_html__('Edit','dtlms').'</a>';
          }

          echo '<tr>
                  <td>'.$i.'</td>
                  <td>'.get_the_title($curriculum).'</td>
                  <td></td>
                  <td>'.dtlms_retrieve_curriculum_post_datas($curriculum, 'name').'</td>
                  <td class="aligncenter">'.dtlms_get_pass_percentage($curriculum, true).'</td>
                  <td class="aligncenter">'.$marks_obtained.'</td>
                  <td class="aligncenter">'.$marks_obtained_percentage.'</td>
                  <td class="aligncenter">'.$completed.'</td>
                  <td class="aligncenter">'.$option_html.'</td>
              </tr>';

          $lesson_curriculums = get_post_meta ($curriculum, 'lesson-curriculum', true);

          if(is_array($lesson_curriculums) && !empty($lesson_curriculums)) {

              $j = 1;
              foreach($lesson_curriculums as $lesson_curriculum) {

                if(is_numeric($lesson_curriculum)) {

                  $marks_obtained = isset($curriculum_details['curriculum'][$curriculum]['curriculum'][$lesson_curriculum]['marks-obtained']) ? $curriculum_details['curriculum'][$curriculum]['curriculum'][$lesson_curriculum]['marks-obtained'] : '';
                  $marks_obtained_percentage = isset($curriculum_details['curriculum'][$curriculum]['curriculum'][$lesson_curriculum]['marks-obtained-percentage']) ? $curriculum_details['curriculum'][$curriculum]['curriculum'][$lesson_curriculum]['marks-obtained-percentage'] : '';
                  $total_percentage = $total_percentage + $marks_obtained_percentage;
                  if($marks_obtained_percentage != '') {
                    $marks_obtained_percentage = $marks_obtained_percentage.'%';
                  }
                  $completed = (isset($curriculum_details['curriculum'][$curriculum]['curriculum'][$lesson_curriculum]['completed']) && $curriculum_details['curriculum'][$curriculum]['curriculum'][$lesson_curriculum]['completed'] == 1) ? esc_html__('Completed', 'dtlms') : '';

                  $option_html = '';
                  $subcurriculum_grade_id = (isset($curriculum_details['curriculum'][$curriculum]['curriculum'][$lesson_curriculum]['grade-post-id']) && $curriculum_details['curriculum'][$curriculum]['curriculum'][$lesson_curriculum]['grade-post-id'] != '') ? $curriculum_details['curriculum'][$curriculum]['curriculum'][$lesson_curriculum]['grade-post-id'] : -1;

                  if($subcurriculum_grade_id > 0) {
                    $option_html = '<a href="'.esc_url(get_edit_post_link($subcurriculum_grade_id)).'" target="_blank">'.esc_html__('Edit','dtlms').'</a>';
                  }

                  echo '<tr>
                            <td></td>
                            <td>'.$j.'</td>
                            <td>'.get_the_title($lesson_curriculum).'</td>
                            <td>'.dtlms_retrieve_curriculum_post_datas($lesson_curriculum, 'name').'</td>
                            <td class="aligncenter">'.dtlms_get_pass_percentage($curriculum, true).'</td>
                            <td class="aligncenter">'.$marks_obtained.'</td>
                            <td class="aligncenter">'.$marks_obtained_percentage.'</td>
                            <td class="aligncenter">'.$completed.'</td>
                            <td class="aligncenter">'.$option_html.'</td>
                        </tr>';

                  $j++;

                  $total_count = $total_count + 1;

                } else {

                    echo '<tr>
                              <td></td>
                              <td colspan="8" class="section">'.$lesson_curriculum.'</td>
                          </tr>';

                }

              }

          }

          $i++;

          $total_count = $total_count + 1;

        } else {

            echo '<tr>
                      <td colspan="9" class="section">'.$curriculum.'</td>
                  </tr>';

        }

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
            <div data-for="graded" class="dtlms-checkbox-switch dtlms-update-revoke-user-submission <?php echo dtlms_html_output($switchclass);?>"></div>
            <input id="graded" class="hidden" type="checkbox" name="graded" value="true" <?php echo dtlms_html_output($checked); ?> />
            <p class="dtlms-note"><?php esc_html_e('Once you enable this option, then this course will be marked as completed!', 'dtlms');?></p>
          </div>

          <div class="dtlms-hr-invisible"></div>

          <a class="dtlms-button small dtlms-revoke-user-submission <?php echo esc_attr($course_graded_class); ?>" data-classid="-1" data-courseid="<?php echo esc_attr($course_id); ?>" data-userid="<?php echo esc_attr($user_id); ?>" data-itemtype="course" href="#"><?php echo esc_html__('Revoke User Submission', 'dtlms'); ?></a>

      </div>
      <div class="dtlms-column dtlms-one-third">
        <?php

        if(in_array('certificate', $dtlms_modules) || in_array('badge', $dtlms_modules)) {

          $user_percentage = round(($total_percentage / $total_count), 2);

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

                $post_metas = get_post_meta($post_id);
                $post_meta_keys = array_keys($post_metas);


                if(in_array('certificate', $dtlms_modules)) {

                  $enable_certificate = get_post_meta($course_id, 'enable-certificate', true);
                  if($enable_certificate == 'true') {

                    $certificate_percentage = get_post_meta($course_id, 'certificate-percentage', true );

                    $certificate_switch_html = '';
                    if($user_percentage >= $certificate_percentage) {

                      $switchclass = 'checkbox-switch-on';
                      $checked = 'checked="checked"';

                      $certificate_achieved = get_post_meta($post_id, 'certificate-achieved', true);
                      if($certificate_achieved == 'true' || !in_array('certificate-achieved', $post_meta_keys)) {
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

                  $enable_badge = get_post_meta($course_id, 'enable-badge', true);
                  if($enable_badge == 'true') {

                    $badge_percentage = get_post_meta($course_id, 'badge-percentage', true);

                    $badge_switch_html = '';
                    if($user_percentage >= $badge_percentage) {

                      $badge_achieved = get_post_meta($post_id, 'badge-achieved', true);
                      if($badge_achieved == 'true' || !in_array('badge-achieved', $post_meta_keys)) {
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

        if(in_array('certificate', $dtlms_modules)) {

          echo '<table class="dtlms-custom-table" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                      <td class="aligncenter">'.esc_html__('Date On Certificate', 'dtlms').'</td>
                      <td class="aligncenter">';

                      $date_on_certificate = get_post_meta($post_id, 'date-on-certificate', true);
                      if($date_on_certificate == '') {
                        $date_on_certificate = get_the_date(get_option('date_format'));
                      }
                      echo '<input id="date-on-certificate" name="date-on-certificate" class="dtlms-datepicker" class="large" type="text" value="'.$date_on_certificate.'" readonly />';

                echo '</td>
                  </tr>
                </table>';

        }


        ?>
      </div>
    </div>
    <?php
  }

} else {

  if($grade_type == 'lesson') {
    $grade_type_updated = 'dtlms_lessons';
  } else if($grade_type == 'quiz') {
    $grade_type_updated = 'dtlms_quizzes';
  } else if($grade_type == 'assignment') {
    $grade_type_updated = 'dtlms_assignments';
  }

  $dtlms_course_curriculums = apply_filters( 'dtlms_course_curriculums', array () );
  if(isset($dtlms_course_curriculums[$grade_type_updated]['grading_metabox_path']) && !empty($dtlms_course_curriculums[$grade_type_updated]['grading_metabox_path'])) {
    require_once $dtlms_course_curriculums[$grade_type_updated]['grading_metabox_path'];
  }

}
?>