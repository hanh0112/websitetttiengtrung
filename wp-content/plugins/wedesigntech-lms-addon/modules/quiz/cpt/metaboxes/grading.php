    <div class="dtlms-custom-box">

        <div class="dtlms-column dtlms-one-half first">

            <div class="dtlms-column dtlms-one-third first"><?php esc_html_e( 'Item Type', 'dtlms');?></div>
            <div class="dtlms-column dtlms-two-third">
                <strong><?php echo esc_html__( 'Quiz', 'dtlms' ); ?></strong>
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

            <div class="dtlms-column dtlms-one-third first"><?php esc_html_e( 'Marks Obtained', 'dtlms');?></div>
            <div class="dtlms-column dtlms-two-third">
              <?php $marks_obtained = get_post_meta ($post_id, 'marks-obtained', true);  ?>
              <input id="dtlms-marks-obtained" name="dtlms-marks-obtained" class="large" type="number" value="<?php echo esc_attr($marks_obtained); ?>" style="width:20%;" <?php echo dtlms_html_output($input_graded_attr); ?> />
            </div>

        </div>

        <div class="dtlms-column dtlms-one-half">

            <div class="dtlms-column dtlms-one-third first"><?php esc_html_e( 'Maximum Marks', 'dtlms');?></div>
            <div class="dtlms-column dtlms-two-third">
              <?php
              $maximum_mark = get_post_meta ($quiz_id, 'quiz-total-grade', true);
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
              $pass_percentage = get_post_meta ($quiz_id, 'quiz-pass-percentage', true);
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

        <div class="dtlms-column dtlms-one-half first">

            <div class="dtlms-column dtlms-one-third first"><?php esc_html_e( 'Attempt', 'dtlms');?></div>
            <div class="dtlms-column dtlms-two-third">
              <?php
              $user_attempts = get_post_meta ( $post_id, 'user-attempts', true );
              echo esc_html($user_attempts);
              ?>
            </div>

        </div>

        <div class="dtlms-column dtlms-one-half">

            <div class="dtlms-column dtlms-one-third first"><?php esc_html_e( 'Attempts Remaining', 'dtlms');?></div>
            <div class="dtlms-column dtlms-two-third">
              <?php
              $quiz_retakes = get_post_meta ( $quiz_id, 'quiz-retakes', true );
              echo esc_html($quiz_retakes-$user_attempts);
              ?>
            </div>

        </div>

    </div>

    <div class="dtlms-custom-box">

        <div class="dtlms-column dtlms-one-half first">

            <div class="dtlms-column dtlms-one-third first"><?php esc_html_e( 'Time Taken', 'dtlms');?></div>
            <div class="dtlms-column dtlms-two-third">
              <?php
              $timings = get_post_meta ( $post_id, 'timings', true );

              $duration = get_post_meta ( $quiz_id, 'duration', true );
              $duration_parameter = get_post_meta ( $quiz_id, 'duration-parameter', true );
              $duration_in_seconds = ($duration * $duration_parameter);

              $time_taken = ($duration_in_seconds - $timings);
              $time_taken = gmdate('H:i:s', $time_taken);
              echo esc_html($time_taken);
              ?>
            </div>

        </div>

        <div class="dtlms-column dtlms-one-half">

        </div>

    </div>

    <div class="dtlms-custom-box">

        <div class="dtlms-column dtlms-one-half first">

            <a class="custom-button-style" id="dtlms-reset-grade" href="#"><?php echo esc_html__('Reset', 'dtlms'); ?></a>
            <a class="custom-button-style" id="dtlms-auto-grade" href="#"><?php echo esc_html__('Auto Grade', 'dtlms'); ?></a>

        </div>

        <div class="dtlms-column dtlms-one-half">

        </div>

    </div>

    <div class="dtlms-custom-box">
      <p class="dtlms-note"><?php esc_html_e('Once course to which this quiz belongs to is graded you can\'t regrade this item.','dtlms');?></p>
    </div>

    <div class="dtlms-custom-box">

      <h3><?php esc_html_e('Questions & Answers', 'dtlms'); ?></h3>

      <?php

      if($quiz_id > 0) {

        $quiz_question_type = get_post_meta($quiz_id, 'quiz-question-type', true);

        $dtlms_question_ids = get_post_meta ( $post_id, 'question-ids',  true );
        $dtlms_question_grades = get_post_meta ( $post_id, 'question-grades',  true );
        $dtlms_question_negative_grades = get_post_meta ( $post_id, 'question-negative-grades',  true );

        $quiz_question = explode(',', $dtlms_question_ids);
        $quiz_question_grade = explode(',', $dtlms_question_grades);
        $quiz_question_negative_grade = explode(',', $dtlms_question_negative_grades);

        echo '<table class="dtlms-custom-table" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <th scope="col">'.esc_html__('#', 'dtlms').'</th>';

                  if($quiz_question_type == 'add-categories') {
                    echo '<th scope="col">'.esc_html__('Categories', 'dtlms').'</th>';
                  }

            echo '<th scope="col">'.esc_html__('Question', 'dtlms').'</th>
                  <th scope="col" class="aligncenter">'.esc_html__('Answer Options', 'dtlms').'</th>
                  <th scope="col" class="aligncenter">'.esc_html__('Correct Answer', 'dtlms').'</th>
                  <th scope="col" class="aligncenter">'.esc_html__('User Answer', 'dtlms').'</th>
                  <th scope="col" class="aligncenter">'.esc_html__('Grade', 'dtlms').'</th>
                  <th scope="col" class="aligncenter">'.esc_html__('Option', 'dtlms').'</th>
                </tr>';

        $i = 1;
        foreach($quiz_question as $question_id) {

          $question_args = array( 'post_type' => 'dtlms_questions', 'p' => $question_id );
          $question = get_posts( $question_args );

          if($quiz_question_type == 'add-categories') {
            $categories_array = array ();
            $categories = get_the_terms( $question_id, 'question_category' );
            if(is_array($categories) && !empty($categories)) {
              foreach( $categories as $category ) {
                  array_push($categories_array, $category->name);
              }
            }
          }

          $multichoice_image = '';

          $question_type = get_post_meta ( $question_id, 'question-type', true );

          if($question_type == 'multiple-choice') {

            $answers_op = get_post_meta ( $question_id, 'multichoice-answers', true );
            $answers_op = (is_array($answers_op) && !empty($answers_op)) ? $answers_op : array ();
            $answers = '<ul><li>';
            $answers .= implode('</li><li>', $answers_op);
            $answers .= '</li></ul>';

            $correct_answer_op = get_post_meta ( $question_id, 'multichoice-correct-answer', true );
            $correct_answer = '<ul><li>'.$correct_answer_op.'</li></ul>';

          } else if($question_type == 'multiple-choice-image') {

            $answers_op = get_post_meta ( $question_id, 'multichoice-image-answers', true );
            $answers = '<ul>';
            foreach($answers_op as $answer) {
              $answers .= '<li><img src="'.$answer.'" width="60" height="60" /></li>';
            }
            $answers .= '</ul>';

            $correct_answer_op = get_post_meta ( $question_id, 'multichoice-image-correct-answer', true );
            $correct_answer = '<ul><li><img src="'.$correct_answer_op.'" width="60" height="60" /></li></ul>';

            $multichoice_image = 'data-multichoiceimage="true"';

          } else if($question_type == 'multiple-correct') {

            $answers_op = get_post_meta ( $question_id, 'multicorrect-answers', true );
            $answers = '<ul><li>';
            $answers .= implode('</li><li>', $answers_op);
            $answers .= '</li></ul>';

            $correct_answer_op = get_post_meta ( $question_id, 'multicorrect-correct-answer', true );
            $correct_answer = '<ul><li>';
            $correct_answer .= implode('</li><li>', $correct_answer_op);
            $correct_answer .= '</li></ul>';

          } else if($question_type == 'boolean') {

            $answers = '<ul><li>'.esc_html__('true', 'dtlms').'</li><li>'.esc_html__('false', 'dtlms').'</li></ul>';

            $correct_answer_op = get_post_meta ( $question_id, 'boolean-answer', true );
            $correct_answer = '<ul><li>'.$correct_answer_op.'</li></ul>';

          } else if($question_type == 'gap-fill') {

            $text_before_gap = get_post_meta ( $question_id, 'text-before-gap', true );
            $text_before_gap = !empty($text_before_gap) ? $text_before_gap : '';
            $text_gap = get_post_meta ( $question_id, 'gap', true );
            $text_gap = !empty($text_gap) ? $text_gap : '';
            $text_after_gap = get_post_meta ( $question_id, 'text-after-gap', true );
            $text_after_gap = !empty($text_after_gap) ? $text_after_gap : '';

            $answers = $text_before_gap.' <strong>'.$text_gap.'</strong> '.$text_after_gap;
            $correct_answer_op = $text_gap;
            $correct_answer = '<ul><li>'.$correct_answer_op.'</li></ul>';

          } else if($question_type == 'single-line') {

            $answers = '';
            $correct_answer_op = get_post_meta ( $question_id, 'singleline-answer', true );
            $correct_answer = '<ul><li>'.$correct_answer_op.'</li></ul>';

          } else if($question_type == 'multi-line') {

            $answers = '';
            $correct_answer_op = get_post_meta ( $question_id, 'multiline-answer', true );
            $correct_answer = '<ul><li>'.$correct_answer_op.'</li></ul>';

          }

          $question_name = 'dtlms-question-'.$question_id;

          $user_answer = '';
          $user_answer_op = get_post_meta ( $post_id, $question_name, true );
          if($question_type == 'multiple-choice-image') {
            if($user_answer_op != '') {
              $user_answer .= '<ul><li><img src="'.$user_answer_op.'" width="60" height="60" /></li></ul>';
            }
          } else {
            $user_answer .= '<ul><li>';
            if(is_array($user_answer_op) && !empty($user_answer_op)) {
              $user_answer .= implode('</li><li>',$user_answer_op);
            } else {
              $user_answer .= $user_answer_op;
            }
            $user_answer .= '</li></ul>';
          }


          $question_grade = get_post_meta ( $post_id, 'question-id-'.$question_id.'-grade',true);

          if(isset($quiz_question_negative_grade[$i-1]) && $quiz_question_negative_grade[$i-1] > 0) {
            $quiz_question_negative_grade_data = '-'.$quiz_question_negative_grade[$i-1];
            $quiz_question_negative_grade_value = $quiz_question_negative_grade[$i-1];
          } else {
            $quiz_question_negative_grade_data = 0;
            $quiz_question_negative_grade_value = 0;
          }

          $skipped_class = '';
          if($user_answer == '') {
            $skipped_class = 'skipped';
          }

          if( defined( 'DOING_AJAX' ) && DOING_AJAX && class_exists('WPBMap') && method_exists('WPBMap', 'addAllMappedShortcodes') ) {
            WPBMap::addAllMappedShortcodes();
          }

          echo '<tr class="dtlms-answers '.$skipped_class.'" data-grade="'.$quiz_question_grade[$i-1].'" data-negative-grade="'.$quiz_question_negative_grade_value.'">
                  <td>'.$i.'</td>';
                  if($quiz_question_type == 'add-categories') {
                    echo '<td>'.implode(',', $categories_array).'</td>';
                  }
            echo '<td>'.do_shortcode($question[0]->post_content).'</td>
                  <td class="aligncenter">'.do_shortcode($answers).'</td>
                  <td class="aligncenter dtlms-correct-answer" '.$multichoice_image.' data-correctanswer="'.htmlentities($correct_answer, ENT_QUOTES).'">'.do_shortcode($correct_answer).'</td>
                  <td class="aligncenter dtlms-user-answer" '.$multichoice_image.' data-useranswer="'.htmlentities($user_answer, ENT_QUOTES).'">'.do_shortcode($user_answer).'</td>';
                    if($user_answer == '') {
                      echo '<td class="aligncenter">'.esc_html__('Skipped', 'dtlms').'</td>';
                      echo '<td></td>';
                    } else {
                      if(isset($question_grade) && $question_grade == true) {
                        echo '<td class="aligncenter dtlms-grade-display-field">'.$quiz_question_grade[$i-1].' / '.$quiz_question_grade[$i-1].'</td>
                            <td class="aligncenter dtlms-grade-option-field">
                              <div data-for="dtlms-question-id-'.$question_id.'-grade" data-quesid="'.$question_id.'" class="dtlms-quiz-answer-switch dtlms-quiz-answer-switch-on '.$course_graded_class.'">Right</div>
                              <input class="hidden" id="dtlms-question-id-'.$question_id.'-grade" type="checkbox" name="dtlms-question-id-'.$question_id.'-grade" value="true" checked="checked" />
                            </td>';
                      } else {
                        echo '<td class="aligncenter dtlms-grade-display-field">'.$quiz_question_negative_grade_data.' / '.$quiz_question_grade[$i-1].'</td>
                            <td class="aligncenter dtlms-grade-option-field">
                              <div data-for="dtlms-question-id-'.$question_id.'-grade" data-quesid="'.$question_id.'" class="dtlms-quiz-answer-switch dtlms-quiz-answer-switch-off '.$course_graded_class.'">Wrong</div>
                              <input class="hidden" id="dtlms-question-id-'.$question_id.'-grade" type="checkbox" name="dtlms-question-id-'.$question_id.'-grade" value="false" />
                            </td>';
                      }
                    }
            echo '</tr>';

          $i++;

        }

        echo '</table>';

        echo '<input id="question-ids" name="question-ids" type="hidden" value="'.$dtlms_question_ids.'" />';

      }

      $total_questions = get_post_meta ( $post_id, 'total-questions', true );
      $skipped_questions = get_post_meta ( $post_id, 'skipped-questions', true );
      $correct_questions = get_post_meta ( $post_id, 'correct-questions', true );
      $wrong_questions = get_post_meta ( $post_id, 'wrong-questions', true );

      echo '<input id="total-questions" name="total-questions" type="hidden" value="'.$total_questions.'" />';
      echo '<input id="skipped-questions" name="skipped-questions" type="hidden" value="'.$skipped_questions.'" />';
      echo '<input id="correct-questions" name="correct-questions" type="hidden" value="'.$correct_questions.'" />';
      echo '<input id="wrong-questions" name="wrong-questions" type="hidden" value="'.$wrong_questions.'" />';

      ?>

    </div>

    <?php
    $prev_gradings = get_post_meta ( $post_id, 'prev-gradings', true );
    if(isset($prev_gradings) && !empty($prev_gradings)) {
      ?>
      <div class="dtlms-custom-box">
          <h3><?php esc_html_e('Previous Attempts', 'dtlms'); ?></h3>
          <?php
          echo '<table border="0" cellpadding="0" cellspacing="10" style="width:100%;">
                    <tr>
                      <th scope="col" class="aligncenter">'.esc_html__('Attempt', 'dtlms').'</th>
                      <th scope="col" class="aligncenter">'.esc_html__('Mark', 'dtlms').'</th>
                      <th scope="col" class="aligncenter">'.esc_html__('Percentage', 'dtlms').'</th>
                      <th scope="col" class="aligncenter">'.esc_html__('Timings', 'dtlms').'</th>
                    </tr>';

              foreach($prev_gradings as $grading) {

                $timings = $grading['timings'];
                if($timings == 'undefined') {
                  $time_taken = 'N/A';
                } else {
                  $duration = get_post_meta ( $quiz_id, 'duration', true );
                  $duration_parameter = get_post_meta ( $quiz_id, 'duration-parameter', true );
                  $duration_in_seconds = ($duration * $duration_parameter);

                  $time_taken = ($duration_in_seconds - $timings);
                  $time_taken = gmdate('H:i:s', $time_taken);
                }

                echo '<tr>
                        <td class="aligncenter">'.$grading['attempts'].'</td>
                        <td class="aligncenter">'.$grading['mark'].'</td>
                        <td class="aligncenter">'.$grading['percentage'].'%</td>
                        <td class="aligncenter">'.$time_taken.'</td>
                    </tr>';

              }

          echo '</table>';
          ?>
      </div>
      <?php
    }
    ?>