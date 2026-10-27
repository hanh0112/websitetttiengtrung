<?php


// Class result

add_action( 'wp_ajax_dtlms_generate_class_result', 'dtlms_generate_class_result' );
add_action( 'wp_ajax_nopriv_dtlms_generate_class_result', 'dtlms_generate_class_result' );
function dtlms_generate_class_result() {

	$class_id = dtlms_recursive_sanitize_text_field($_REQUEST['class_id']);
	$user_id = dtlms_recursive_sanitize_text_field($_REQUEST['user_id']);

	$author_id = get_post_field( 'post_author', $class_id );

	$class_curriculum_details = get_user_meta($user_id, $class_id, true);
	$course_grade_id = $curriculum_details['grade-post-id'];

	$purchased_classes = get_user_meta($user_id, 'purchased_classes', true);
	$purchased_classes = (is_array($purchased_classes) && !empty($purchased_classes)) ? $purchased_classes : array ();

	$started_classes = get_user_meta($user_id, 'started_classes', true);
	$started_classes = (is_array($started_classes) && !empty($started_classes)) ? $started_classes : array ();

	$submitted_classes = get_user_meta($user_id, 'submitted_classes', true);
	$submitted_classes = (is_array($submitted_classes) && !empty($submitted_classes)) ? $submitted_classes : array ();

	$completed_classes = get_user_meta($user_id, 'completed_classes', true);
	$completed_classes = (is_array($completed_classes) && !empty($completed_classes)) ? $completed_classes : array ();

	$classes_undergoing = array_diff($started_classes, $submitted_classes);
	$classes_underevaluation = array_diff($submitted_classes, $completed_classes);

	$class_singular_label = apply_filters( 'class_label', 'singular' );

	$dtlms_modules = dtlms_instance()->active_modules;
	$dtlms_modules = (is_array($dtlms_modules) && !empty($dtlms_modules)) ? $dtlms_modules : array ();

	$output = '';

	$output .= '<div id="dtlms-class-result-popup">';

		$output .= dtlms_generate_loader_html(false);

		$output .= '<div class="dtlms-class-result-popup-header">';

			$output .= '<div class="dtlms-class-result-popup-intro">';

				$output .= '<h2>'.get_the_title($class_id).'</h2>';

				$output .= '<div class="dtlms-item-status-details">';

					if(in_array($class_id, $classes_undergoing)) {
						$output .= '<span class="dtlms-undergoing">'.esc_html__('Undergoing', 'dtlms').'</span>';
					}

					if(in_array($class_id, $classes_underevaluation)) {
						$output .= '<span class="dtlms-underevaluation">'.esc_html__('Under Evaluation', 'dtlms').'</span>';
					}

					if(in_array($class_id, $completed_classes)) {
						$output .= '<span class="dtlms-completed">'.esc_html__('Completed', 'dtlms').'</span>';
					}

				$output .= '</div>';

			$output .= '</div>';

			$output .= '<div class="dtlms-refresh-class-result" data-classid="'.$class_id.'" data-userid="'.$user_id.'"></div>';

			$output .= '<div class="dtlms-close-class-result-popup"></div>';

			$output .= '<div class="dtlms-expand-class-result-main-details"></div>';

			$output .= '<div class="dtlms-class-results-main-detail-wrapper">';

				$output .= '<div class="dtlms-column dtlms-one-fifth first">';

					if(has_post_thumbnail($class_id)) {
						$output .= get_the_post_thumbnail($class_id);
					}

				$output .= '</div>';

				$output .= '<div class="dtlms-column dtlms-one-fifth">';

					if($class_curriculum_details['completed'] == 1) {

						$class_grade_id = $class_curriculum_details['grade-post-id'];
						$user_percentage = get_post_meta($class_grade_id, 'user-percentage', true);
						$user_percentage = round($user_percentage, 2);

						$output .= '<div class="dtlms-item-progress-details-holder">';
							$output .= '<div class="dtlms-title">'.esc_html__('Your Percentage', 'dtlms').'</div>';
							$output .= '<div class="dtlms-quiz-results">';
								$output .= '<h5><span>'.$user_percentage.'%</span></h5>';
							$output .= '</div>';
							$output .= dtlms_generate_progressbar($user_percentage);
						$output .= '</div>';

					} else if($class_curriculum_details['submitted'] == 1) {

						$output .= '<p>'.esc_html__('Your class have been submitted successfully for evaluation.', 'dtlms').'</p>';

					} else {

						$total_curriculum_count = $submitted_items_count = $completed_items_count = 0;

						$class_courses = get_post_meta($class_id, 'dtlms-class-courses', true);
						if(is_array($class_courses) && !empty($class_courses)) {
							$total_curriculum_count = count($class_courses);
							foreach($class_courses as $course_id) {

								// Submitted Items
								$submitted_args = array (
													'post_type' => 'dtlms_gradings',
													'meta_query'=>array(),
												);
								$submitted_args['meta_query'][] = array (
																		'key'     => 'dtlms-course-id',
																		'value'   => $course_id,
																		'compare' => '=='
																	);
								$submitted_args['meta_query'][] = array (
																		'key'     => 'dtlms-user-id',
																		'value'   => $user_id,
																		'compare' => '=='
																	);
								$submitted_args['meta_query'][] = array (
																		'key'     => 'grade-type',
																		'value'   => 'course',
																		'compare' => '=='
																	);
								$submitted_args['meta_query'][] = array (
																		'key'     => 'submitted',
																		'value'   => '1',
																		'compare' => '=='
																	);
								$submitted_gradings = new WP_Query( $submitted_args );
								$submitted_gradings_count = $submitted_gradings->found_posts;
								wp_reset_postdata();

								$submitted_items_count = $submitted_items_count + $submitted_gradings_count;


								// Completed Items
								$completed_args = array (
													'post_type' => 'dtlms_gradings',
													'meta_query'=>array(),
												);
								$completed_args['meta_query'][] = array (
																		'key'     => 'dtlms-course-id',
																		'value'   => $course_id,
																		'compare' => '=='
																	);
								$completed_args['meta_query'][] = array (
																		'key'     => 'dtlms-user-id',
																		'value'   => $user_id,
																		'compare' => '=='
																	);
								$completed_args['meta_query'][] = array (
																		'key'     => 'grade-type',
																		'value'   => 'course',
																		'compare' => '=='
																	);
								$completed_args['meta_query'][] = array (
																		'key'     => 'graded',
																		'value'   => 'true',
																		'compare' => '=='
																	);
								$completed_gradings = new WP_Query( $completed_args );
								$completed_gradings_count = $completed_gradings->found_posts;
								wp_reset_postdata();

								$completed_items_count = $completed_items_count + $completed_gradings_count;

							}
						}

						$submitted_percentage = $completed_percentage = 0;
						if($total_curriculum_count > 0) {

							if($submitted_items_count > 0) {
								$submitted_percentage = round((($submitted_items_count/$total_curriculum_count)*100), 2);
							} else {
								$submitted_percentage = 0;
							}

							if($completed_items_count > 0) {
								$completed_percentage = round((($completed_items_count/$total_curriculum_count)*100), 2);
							} else {
								$completed_percentage = 0;
							}

						}

						$output .= '<div class="dtlms-item-progress-details-holder">
										<div class="dtlms-title">'.sprintf( esc_html__( '%1$s Progress', 'dtlms' ), $class_singular_label ).'</div>';
							$output .= '<div class="dtlms-item-student-submitted-item-details">';
								$output .= sprintf( esc_html__('You have submitted %1$s out of %2$s items.', 'dtlms'), $submitted_items_count, $total_curriculum_count );
								$output .= dtlms_generate_progressbar($submitted_percentage);
							$output .= '</div>';
							$output .= '<div class="dtlms-item-student-completed-item-details">';
								$output .= sprintf( esc_html__('%1$s out of %2$s items are graded and marked as completed.', 'dtlms'), $completed_items_count, $total_curriculum_count );
								$output .= dtlms_generate_progressbar($completed_percentage);
							$output .= '</div>';
						$output .= '</div>';

					}

				$output .= '</div>';

				$output .= '<div class="dtlms-column dtlms-one-fifth">';

					$output .= '<div class="dtlms-badge-certificate-holder">';

						$output .= '<div class="dtlms-title">'.esc_html__('Certificate & Badge', 'dtlms').'</div>';

							$badge_achieved = get_post_meta($class_grade_id, 'badge-achieved', true);
							$certificate_achieved = get_post_meta($class_grade_id, 'certificate-achieved', true);

							if((in_array('badge', $dtlms_modules) && $badge_achieved == 'true') || (in_array('certificate', $dtlms_modules) && $certificate_achieved == 'true')) {

								$class_singular_label = apply_filters( 'class_label', 'singular' );

								if(in_array('badge', $dtlms_modules) && $badge_achieved == 'true') {
									$badge_image_url = get_post_meta($class_id, 'badge-image-url', true);
									$output .= '<img src="'.$badge_image_url.'" alt="'.sprintf( esc_html__( '%1$s Badge', 'dtlms' ), $class_singular_label ).'" title="'.sprintf( esc_html__( '%1$s Badge', 'dtlms' ), $class_singular_label ).'" />';
								}

								if(in_array('certificate', $dtlms_modules) && $certificate_achieved == 'true') {
									$certificate_template = get_post_meta($class_id, 'certificate-template', true);
									$output .= '<a href="#" class="dtlms-generate-certificate-content" data-certificateid="'.$certificate_template.'"  data-itemid="'.$class_id.'" data-gradeid="'.$class_grade_id.'" data-userid="'.$user_id.'" onclick="return false;">'.esc_html__('Download Certificate', 'dtlms').'</a>';
								}

							} else {

								$output .= '<p class="dtlms-note">'.esc_html__('No Records Found!', 'dtlms');

							}

						$output .= '</div>';

				$output .= '</div>';

				$output .= '<div class="dtlms-column dtlms-one-fifth">';

					$output .= '<div class="dtlms-title">'.esc_html__('Instructor Feedback', 'dtlms').'</div>';

					$review_or_feedback = get_post_meta ($class_grade_id, 'review-or-feedback', true);
					if($review_or_feedback != '') {
						$output .= '<div class="dtlms-course-review-holder">'.$review_or_feedback.'</div>';
					} else {
						$output .= '<p class="dtlms-note">'.esc_html__('No Records Found!', 'dtlms');
					}

				$output .= '</div>';

				$output .= '<div class="dtlms-column dtlms-one-fifth">';

					$instructor_label = apply_filters( 'instructor_label', 'singular' );
					$output .= '<div class="dtlms-author-details">
									<div class="dtlms-title">'.esc_html__('Author', 'dtlms').'</div>
									<div class="dtlms-author-image">
										'.get_avatar($author_id, 150).'
									</div>
									<div class="dtlms-author-desc">
										<div class="dtlms-author-title">
											<h5>
												<a href="#" rel="author">
													'.get_the_author_meta('display_name', $author_id).'
												</a>
											</h5>
											<span>'.$instructor_label.'</span>
										</div>
									</div>
								</div>';

				$output .= '</div>';

			$output .= '</div>';

		$output .= '</div>';

		$output .= '<div class="dtlms-class-result-popup-container">';

			$output .= '<div class="dtlms-column dtlms-one-fourth first">';

				$output .= '<div class="dtlms-title">'.esc_html__('Courses', 'dtlms').'</div>';

				$output .= '<div class="dtlms-class-result-curriculum-container">'.dtlms_load_class_curriculum_list($class_id, $user_id).'</div>';

			$output .= '</div>';

			$output .= '<div class="dtlms-column dtlms-three-fourth dtlms-view-class-curriculum-details-holder"></div>';

		$output .= '</div>';

	$output .= '</div>';

	echo dtlms_html_output($output);

	die();

}

add_action( 'wp_ajax_dtlms_load_class_curriculum_list', 'dtlms_load_class_curriculum_list' );
add_action( 'wp_ajax_nopriv_dtlms_load_class_curriculum_list', 'dtlms_load_class_curriculum_list' );
function dtlms_load_class_curriculum_list($dashboard_class_id, $user_id) {

	$output = '';

	if($dashboard_class_id > 0) {
		$class_id = $dashboard_class_id;
	} else {
		$class_id = isset($_REQUEST['class_id']) ? dtlms_recursive_sanitize_text_field($_REQUEST['class_id']) : -1;
	}

	// Pagination script Start
	$ajax_call = (isset($_REQUEST['ajax_call']) && $_REQUEST['ajax_call'] == true) ? true : false;
	$current_page = isset($_REQUEST['current_page']) ? dtlms_recursive_sanitize_text_field($_REQUEST['current_page']) : 1;
	$offset = isset($_REQUEST['offset']) ? dtlms_recursive_sanitize_text_field($_REQUEST['offset']) : 0;
	$frontend_postperpage = (dtlms_option('general','frontend-postperpage') != '') ? dtlms_recursive_sanitize_text_field(dtlms_option('general','frontend-postperpage')) : 10;
	$post_per_page = isset($_REQUEST['post_per_page']) ? dtlms_recursive_sanitize_text_field($_REQUEST['post_per_page']) : $frontend_postperpage;

	$function_call = (isset($_REQUEST['function_call']) && $_REQUEST['function_call'] != '') ? dtlms_recursive_sanitize_text_field($_REQUEST['function_call']) : 'dtlms_load_class_curriculum_list';
	$output_div = (isset($_REQUEST['output_div']) && $_REQUEST['output_div'] != '') ? dtlms_recursive_sanitize_text_field($_REQUEST['output_div']) : 'dtlms-class-result-curriculum-container';
	// Pagination script End


	$class_courses = get_post_meta($class_id, 'dtlms-class-courses', true);

	if(is_array($class_courses) && !empty($class_courses)) {

		$output .= '<table class="dtlms-class-curriculum-table" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<th scope="col">'.esc_html__('#', 'dtlms').'</th>
							<th scope="col">'.esc_html__('Course', 'dtlms').'</th>
							<th scope="col">'.esc_html__('Percentage', 'dtlms').'</th>
							<th scope="col">'.esc_html__('Status', 'dtlms').'</th>
							<th scope="col">'.esc_html__('Options', 'dtlms').'</th>
						</tr>';

		$total_percentage = 0;
		$i = 1;
		$class_courses_filtered = array_slice($class_courses, $offset, $post_per_page, true);
		foreach($class_courses_filtered as $course_id) {

			$curriculum_details = get_user_meta($user_id, $course_id, true);

			$course_grade_id = (isset($curriculum_details['grade-post-id']) && $curriculum_details['grade-post-id'] != '') ? $curriculum_details['grade-post-id'] : -1;

			$course_user_percentage = get_post_meta ($course_grade_id, 'user-percentage', true);
			$total_percentage = $total_percentage + $course_user_percentage;
			if($course_user_percentage != '' && $course_user_percentage >= 0) {
				$course_user_percentage = $course_user_percentage.'%';
			}

			$status = esc_html__('Pending', 'dtlms');
			$status_attribute = 'class="pending" data-title="'.$status.'"';
			if(isset($curriculum_details['completed']) && $curriculum_details['completed'] == 1) {
				$status = esc_html__('Completed', 'dtlms');
				$status_attribute = 'class="completed" data-title="'.$status.'"';
			} else if(isset($curriculum_details['submitted']) && $curriculum_details['submitted'] == 1) {
				$status = esc_html__('Submitted', 'dtlms');
				$status_attribute = 'class="submitted" data-title="'.$status.'"';
			} else if(isset($curriculum_details['started']) && $curriculum_details['started'] == 1) {
				$status = esc_html__('Started', 'dtlms');
				$status_attribute = 'class="started" data-title="'.$status.'"';
			}

			$option_html = '<a href="#" onclick="return false;" class="dtlms-view-class-curriculum-details" data-courseid="'.$course_id.'" data-userid="'.$user_id.'">'.esc_html__('Details','dtlms').'</a>';

			$output .= '<tr>
							<td>'.$i.'</td>
							<td class="dtlms-class-curriculum-item">'.get_the_title($course_id).'</td>
							<td>'.$course_user_percentage.'</td>
							<td '.$status_attribute.'>'.$status.'</td>
							<td>'.$option_html.'</td>
						</tr>';

			$i++;

		}

		$output .= '</table>';

		// Pagination script Start
		$class_courses_count = count($class_courses);
		$max_num_pages = ceil($class_courses_count / $post_per_page);

		$item_ids['class_id'] = $class_id;

		$output .= dtlms_ajax_pagination($max_num_pages, $current_page, $function_call, $output_div, $item_ids);
		// Pagination script End

	}


	if($ajax_call) {

		echo dtlms_html_output($output);
		die();

	} else {

		return $output;

	}

}


add_action( 'wp_ajax_dtlms_view_class_curriculum_details', 'dtlms_view_class_curriculum_details' );
add_action( 'wp_ajax_nopriv_dtlms_view_class_curriculum_details', 'dtlms_view_class_curriculum_details' );
function dtlms_view_class_curriculum_details() {

	$course_id = dtlms_recursive_sanitize_text_field($_REQUEST['course_id']);
	$user_id = dtlms_recursive_sanitize_text_field($_REQUEST['user_id']);

	echo dtlms_course_overall_result($course_id, $user_id, 'class');

	die();

}

?>