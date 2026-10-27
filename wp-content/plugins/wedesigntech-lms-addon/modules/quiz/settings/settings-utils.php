<?php

if(!function_exists('dtlms_process_imported_file')) {
	function dtlms_process_imported_file() {

		$import_type = dtlms_recursive_sanitize_text_field($_REQUEST['import_type']);
		$import_file = dtlms_recursive_sanitize_text_field($_REQUEST['import_file']);

		$extension = pathinfo($import_file, PATHINFO_EXTENSION);

		if($extension == 'csv') {

			if(( $fh = @fopen($import_file, 'r')) !== false) {

				$i = 0;

				while(( $row = fgetcsv($fh)) !== false) {

					if($i > 0) {

						// Question
						if($import_type == 'question') {

							$title = $row[0];
							$content = $row[1];
							$question_type = $row[2];
							$answers = $row[3];
							$correct_answer = $row[4];
							$answer_hint = $row[5];
							$answer_explanation = $row[6];

							$question_post = array(
								'post_title' => $title,
								'post_content'  => $content,
								'post_status' => 'publish',
								'post_type' => 'dtlms_questions',
								'post_author' => 1,
							);
							$question_id = wp_insert_post($question_post);

							update_post_meta ( $question_id, 'question-type', dtlms_wp_kses($question_type) );

							if($question_type == 'multiple-choice') {

								$answers = explode('|', $answers);
								update_post_meta ( $question_id, 'multichoice-answers', array_filter($answers) );

								update_post_meta ( $question_id, 'multichoice-correct-answer', dtlms_wp_kses($correct_answer) );

							} else if($question_type == 'multiple-choice-image') {

								$answers = explode('|', $answers);
								update_post_meta ( $question_id, 'multichoice-image-answers', array_filter($answers) );

								update_post_meta ( $question_id, 'multichoice-image-correct-answer', dtlms_wp_kses($correct_answer) );

							} else if($question_type == 'multiple-correct') {

								$answers = explode('|', $answers);
								update_post_meta ( $question_id, 'multicorrect-answers', array_filter($answers) );

								$correct_answer = explode('|', $correct_answer);
								update_post_meta ( $question_id, 'multicorrect-correct-answer', array_filter($correct_answer) );

							} else if($question_type == 'boolean') {

								update_post_meta ( $question_id, 'boolean-answer', dtlms_wp_kses(strtolower($correct_answer)) );

							} else if($question_type == 'gap-fill') {

								$answers = explode('|', $answers);

								update_post_meta ( $question_id, 'text-before-gap', dtlms_wp_kses($answers[0]) );
								update_post_meta ( $question_id, 'text-after-gap', dtlms_wp_kses($answers[1]) );

								update_post_meta ( $question_id, 'gap', dtlms_wp_kses($correct_answer) );

							} else if($question_type == 'single-line') {

								update_post_meta ( $question_id, 'singleline-answer', dtlms_wp_kses($correct_answer) );

							} else if($question_type == 'multi-line') {

								update_post_meta ( $question_id, 'multiline-answer', dtlms_wp_kses($correct_answer) );

							}

							update_post_meta ( $question_id, 'answer-hint', dtlms_wp_kses($answer_hint) );
							update_post_meta ( $question_id, 'answer-explanation', dtlms_wp_kses($answer_explanation) );

						}

						// Quiz
						if($import_type == 'quiz') {

							$title = $row[0];
							$content = $row[1];
							$freequiz = $row[2];
							$subtitle = $row[3];
							$duration = $row[4];
							$duration_parameter = $row[5];
							$number_of_retakes = $row[6];
							$post_quiz_message = $row[7];
							$randomize_question = $row[8];
							$enable_auto_evaluation = $row[9];
							$marks_as_graded_in_auto_evaluation = $row[10];
							$question_type = $row[11];
							$add_questions = $row[12];
							$add_categories = $row[13];
							$pass_percentage = $row[14];
							$show_questions_onebyone = $row[15];
							$show_correct_answer_explanation = $row[16];
							$show_question_counter = $row[17];


							$durationparameters = array ('seconds' => '1', 'minutes' => '60', 'hours' => '3600', 'days' => '86400', 'weeks' => '604800', 'months' => '2592000', 'years' => '31536000');

							$duration_parameter = $durationparameters[$duration_parameter];

							if($question_type == 'add-questions') {
								$add_questions = explode('#', $add_questions);
								$questions = explode('|', $add_questions[0]);
								$grade = explode('|', $add_questions[1]);
								$negative_grade = explode('|', $add_questions[2]);
							}

							if($question_type == 'add-categories') {
								$add_categories = explode('#', $add_categories);
								$categories = explode('|', $add_categories[0]);
								$categories_questions = explode('|', $add_categories[1]);
								$grade = explode('|', $add_categories[2]);
								$negative_grade = explode('|', $add_categories[3]);
							}

							$total_grade = array_sum($grade);


							$quiz_post = array(
								'post_title' => $title,
								'post_content'  => $content,
								'post_status' => 'publish',
								'post_type' => 'dtlms_quizzes',
								'post_author' => 1,
							);
							$quiz_id = wp_insert_post($quiz_post);

							update_post_meta ( $quiz_id, 'free-quiz', dtlms_wp_kses($freequiz) );
							update_post_meta ( $quiz_id, 'quiz-subtitle', dtlms_wp_kses($subtitle) );
							update_post_meta ( $quiz_id, 'duration', dtlms_wp_kses($duration) );
							update_post_meta ( $quiz_id, 'duration-parameter', dtlms_wp_kses($duration_parameter) );
							update_post_meta ( $quiz_id, 'quiz-retakes', dtlms_wp_kses($number_of_retakes) );
							update_post_meta ( $quiz_id, 'quiz-postmsg', dtlms_wp_kses($post_quiz_message) );

							if(strtolower(trim($randomize_question)) == 'true') {
								update_post_meta ( $quiz_id, 'quiz-randomize-questions', 'true' );
							}
							if(strtolower(trim($enable_auto_evaluation)) == 'true') {
								update_post_meta ( $quiz_id, 'quiz-auto-evaluation', 'true' );
							}
							if(strtolower(trim($marks_as_graded_in_auto_evaluation)) == 'true') {
								update_post_meta ( $quiz_id, 'quiz-markasgraded-in-autoevaluation', 'true' );
							}

							update_post_meta ( $quiz_id, 'quiz-question-type', dtlms_wp_kses($question_type) );

							if($question_type == 'add-questions') {
								update_post_meta ( $quiz_id, 'quiz-question', array_filter($questions) );
								update_post_meta ( $quiz_id, 'quiz-question-grade', array_filter($grade) );
								update_post_meta ( $quiz_id, 'quiz-question-negative-grade', array_filter($negative_grade) );
							}
							if($question_type == 'add-categories') {
								update_post_meta ( $quiz_id, 'quiz-categories', array_filter($categories) );
								update_post_meta ( $quiz_id, 'quiz-categories-questions', array_filter($categories_questions) );
								update_post_meta ( $quiz_id, 'quiz-categories-grade', array_filter($grade) );
								update_post_meta ( $quiz_id, 'quiz-categories-negative-grade', array_filter($negative_grade) );
							}

							update_post_meta ( $quiz_id, 'quiz-total-grade', dtlms_wp_kses($total_grade) );
							update_post_meta ( $quiz_id, 'quiz-pass-percentage', dtlms_wp_kses($pass_percentage) );

							if(strtolower(trim($show_questions_onebyone)) == 'true') {
								update_post_meta ( $quiz_id, 'quiz-questions-onebyone', 'true' );
							}
							if(strtolower(trim($show_correct_answer_explanation)) == 'true') {
								update_post_meta ( $quiz_id, 'quiz-correctanswer-and-answerexplanation', 'true' );
							}
							if(strtolower(trim($show_question_counter)) == 'true') {
								update_post_meta ( $quiz_id, 'quiz-questions-counter', 'true' );
							}

						}

					}

					$i++;

				}

			}

			echo '<p class="dtlms-note"><strong>'.esc_html__('Data imported successfully!', 'dt_themes').'</strong></p>';

		} else {

			echo '<p class="dtlms-note"><strong>'.esc_html__('Only .csv file format is allowed!', 'dt_themes').'</strong></p>';

		}

		die();

	}
	add_action( 'wp_ajax_dtlms_process_imported_file', 'dtlms_process_imported_file' );
	add_action( 'wp_ajax_nopriv_dtlms_process_imported_file', 'dtlms_process_imported_file' );
}

?>