<?php

// Classes- Assign Students

add_action( 'wp_ajax_dtlms_assigning_classes_load_students_data', 'dtlms_assigning_classes_load_students_data' );
add_action( 'wp_ajax_nopriv_dtlms_assigning_classes_load_students_data', 'dtlms_assigning_classes_load_students_data' );
function dtlms_assigning_classes_load_students_data() {

	$class_id = dtlms_recursive_sanitize_text_field($_REQUEST['class_id']);

	$output = '';

	if($class_id != '') {

		// Pagination script Start
		$ajax_call = (isset($_REQUEST['ajax_call']) && $_REQUEST['ajax_call'] == true) ? true : false;
		$current_page = isset($_REQUEST['current_page']) ? dtlms_recursive_sanitize_text_field($_REQUEST['current_page']) : 1;
		$offset = isset($_REQUEST['offset']) ? dtlms_recursive_sanitize_text_field($_REQUEST['offset']) : 0;
		$backend_postperpage = (dtlms_option('general','backend-postperpage') != '') ? dtlms_recursive_sanitize_text_field(dtlms_option('general','backend-postperpage')) : 10;
		$post_per_page = isset($_REQUEST['post_per_page']) ? $_REQUEST['post_per_page'] : $backend_postperpage;

		if($dashboard_function_call != '') {
			$function_call = $dashboard_function_call;
		} else {
			$function_call = (isset($_REQUEST['function_call']) && $_REQUEST['function_call'] != '') ? dtlms_recursive_sanitize_text_field($_REQUEST['function_call']) : 'dtlms_assigning_classes_load_students_data';
		}

		if($dashboard_output_div != '') {
			$output_div = $dashboard_output_div;
		} else {
			$output_div = (isset($_REQUEST['output_div']) && $_REQUEST['output_div'] != '') ? dtlms_recursive_sanitize_text_field($_REQUEST['output_div']) : 'dtlms-assign-studentstoclass-container';
		}
		// Pagination script End

		$output .= '<form name="formAssignStudents" class="formAssignStudents" method="post">';

			$output .= '<table border="0" cellpadding="0" cellspacing="0" class="dtlms-custom-table">
							<tr>
								<th scope="col">'.esc_html__('#', 'dtlms').'</th>
								<th scope="col">'.esc_html__('Student', 'dtlms').'</th>
								<th scope="col">'.esc_html__('Purchased', 'dtlms').'</th>
								<th scope="col">'.esc_html__('Assigned', 'dtlms').'</th>
							</tr>';

				$page_student_ids = '';

				$students = get_users ( array ('role' => 'student' ) );
				$students_filtered = array_slice($students, $offset, $post_per_page, true);
				if(is_array($students_filtered) && !empty($students_filtered)) {

					$i = $offset+1;
					foreach ( $students_filtered as $student ) {
						setup_postdata( $student );

						$student_id = $student->data->ID;

		                $purchase_checked = '';
		                $purchase_switchclass = 'checkbox-switch-off';

						$active_package_classes = dtlms_get_user_active_packages($student_id, 'classes');
						$active_package_classes = (is_array($active_package_classes) && !empty($active_package_classes)) ? $active_package_classes : array();
						$purchased_classes = get_user_meta($student_id, 'purchased_classes', true);
						if((is_array($purchased_classes) && in_array($class_id, $purchased_classes)) || (is_array($active_package_classes) && in_array($class_id, $active_package_classes))) {
		                    $purchase_checked = 'checked="checked"';
		                    $purchase_switchclass = 'checkbox-switch-on';
						}

		                $assigned_checked = '';
		                $assigned_switchclass = 'checkbox-switch-off';
						$assigned_classes = get_user_meta($student_id, 'assigned_classes', true);
						if(is_array($assigned_classes) && in_array($class_id, $assigned_classes)) {
		                    $assigned_checked = 'checked="checked"';
		                    $assigned_switchclass = 'checkbox-switch-on';
						}

						$output .= '<tr>
										<td>'.$i.'</td>
										<td>'.get_the_author_meta('display_name', $student_id).'</td>
										<td>'
											.'<div class="dtlms-checkbox-switch disabled '.$purchase_switchclass.'"></div>'.
										'</td>
										<td>'
											.'<div data-for="assign-students-to-class-'.$student_id.'" class="dtlms-checkbox-switch '.$assigned_switchclass.'"></div>'
											.'<input id="assign-students-to-class-'.$student_id.'" class="assign-students-to-class hidden" type="checkbox" name="assign-students-to-class" value="'.$student_id.'" '.$assigned_checked.' />'.
										'</td>
									</tr>';

						$i++;

						$page_student_ids = $student_id.','.$page_student_ids;

					}

				} else {
					$output .= '<tr>
									<td colspan="4">'.esc_html__('No records found!', 'dtlms').'</td>
								</tr>';
				}

			$output .= '</table>';

		$output .= '</form>';


		$output .= '<div class="dtlms-assign-classes-students-response-holder"></div>';

		$output .= '<a href="#" class="dtlms-button dtlms-save-assign-classes-students-settings small" data-classid="'.$class_id.'" data-pagestudentids="'.rtrim($page_student_ids, ',').'">'.esc_html__('Assign', 'dtlms').'</a>';


		wp_reset_postdata();

		// Pagination script Start
		$students_count = count($students);
		$max_num_pages = ceil($students_count / $post_per_page);

		$item_ids['class_id'] = $class_id;

		$output .= dtlms_ajax_pagination($max_num_pages, $current_page, $function_call, $output_div, $item_ids);
		// Pagination script End

	} else {

		$output .= esc_html__('Please choose class!', 'dtlms');

	}

	echo dtlms_html_output($output);

	die();

}

add_action( 'wp_ajax_dtlms_save_assign_classes_students_settings', 'dtlms_save_assign_classes_students_settings' );
add_action( 'wp_ajax_nopriv_dtlms_save_assign_classes_students_settings', 'dtlms_save_assign_classes_students_settings' );
function dtlms_save_assign_classes_students_settings() {

	$class_id = dtlms_recursive_sanitize_text_field($_REQUEST['class_id']);
	$page_student_ids = !empty($_REQUEST['page_student_ids']) ? explode(',', dtlms_recursive_sanitize_text_field($_REQUEST['page_student_ids'])) : array ();
	$student_ids = is_array($_REQUEST['student_ids']) && !empty($_REQUEST['student_ids']) ? dtlms_recursive_sanitize_text_field($_REQUEST['student_ids']) : array ();

	$output = '';

	if($class_id != '') {

		$students = get_users ( array ('role' => 'student', 'include' => $page_student_ids) );
        if ( count( $students ) > 0 ) {
            foreach ($students as $student) {

            	$student_id = $student->data->ID;

            	if(in_array($student_id, $student_ids)) {
					$assigned_classes = get_user_meta($student_id, 'assigned_classes', true);
					$assigned_classes = (is_array($assigned_classes) && !empty($assigned_classes)) ? $assigned_classes : array();
					array_push($assigned_classes, $class_id);
					update_user_meta($student_id, 'assigned_classes', array_unique($assigned_classes));

					// Start class for user
					$class_data = get_post($class_id);
					$author_id = $class_data->post_author;
					dtlms_start_class_initialize($class_id, $student_id, $author_id, false);

					// Notification & Mail
					do_action('dtlms_poc_class_assigned', $class_id, $student_id);
            	} else {
					$assigned_classes = get_user_meta($student_id, 'assigned_classes', true);
					$assigned_classes = (is_array($assigned_classes) && !empty($assigned_classes)) ? $assigned_classes : array();
					if(in_array($class_id, $assigned_classes)) {
					    unset($assigned_classes[array_search($class_id, $assigned_classes)]);
					}
					update_user_meta($student_id, 'assigned_classes', array_unique($assigned_classes));
            	}

			}
		}

		update_post_meta($class_id, 'assigned_users', array_unique($student_ids));

		$output .= esc_html__('Students assigned successfully!', 'dtlms');

	} else {

		$output .= esc_html__('Something went wrong!', 'dtlms');

	}

	echo dtlms_html_output($output);

	die();

}

// Classes- Assign Classes

add_action( 'wp_ajax_dtlms_assigning_classes_load_classes_data', 'dtlms_assigning_classes_load_classes_data' );
add_action( 'wp_ajax_nopriv_dtlms_assigning_classes_load_classes_data', 'dtlms_assigning_classes_load_classes_data' );
function dtlms_assigning_classes_load_classes_data() {

	$student_id = dtlms_recursive_sanitize_text_field($_REQUEST['student_id']);

	$output = '';

	if($student_id != '') {

		// Pagination script Start
		$ajax_call = (isset($_REQUEST['ajax_call']) && $_REQUEST['ajax_call'] == true) ? true : false;
		$current_page = isset($_REQUEST['current_page']) ? dtlms_recursive_sanitize_text_field($_REQUEST['current_page']) : 1;
		$offset = isset($_REQUEST['offset']) ? dtlms_recursive_sanitize_text_field($_REQUEST['offset']) : 0;
		$backend_postperpage = (dtlms_option('general','backend-postperpage') != '') ? dtlms_recursive_sanitize_text_field(dtlms_option('general','backend-postperpage')) : 10;
		$post_per_page = isset($_REQUEST['post_per_page']) ? dtlms_recursive_sanitize_text_field($_REQUEST['post_per_page']) : $backend_postperpage;

		if($dashboard_function_call != '') {
			$function_call = $dashboard_function_call;
		} else {
			$function_call = (isset($_REQUEST['function_call']) && $_REQUEST['function_call'] != '') ? dtlms_recursive_sanitize_text_field($_REQUEST['function_call']) : 'dtlms_assigning_classes_load_classes_data';
		}

		if($dashboard_output_div != '') {
			$output_div = $dashboard_output_div;
		} else {
			$output_div = (isset($_REQUEST['output_div']) && $_REQUEST['output_div'] != '') ? dtlms_recursive_sanitize_text_field($_REQUEST['output_div']) : 'dtlms-assign-classestostudent-container';
		}
		// Pagination script End

		$class_title_plural = apply_filters( 'class_label', 'plural' );

		$output .= '<form name="formAssignClasses" class="formAssignClasses" method="post">';

			$output .= '<table border="0" cellpadding="0" cellspacing="0" class="dtlms-custom-table">
							<tr>
								<th scope="col">'.esc_html__('#', 'dtlms').'</th>
								<th scope="col">'.sprintf( esc_html__( '%1$s', 'dtlms' ), $class_title_plural ).'</th>
								<th scope="col">'.esc_html__('Purchased', 'dtlms').'</th>
								<th scope="col">'.esc_html__('Assigned', 'dtlms').'</th>
							</tr>';

				$page_class_ids = '';

				$args = array (
					'offset' => $offset,
					'paged' => $current_page,
					'posts_per_page' => $post_per_page,
				    'post_type' => 'dtlms_classes',
			    );
				$args['meta_query'][] = array (
											'key'     => '_regular_price',
											'value'   => 0,
											'type'    => 'numeric',
											'compare' => '>'
										);

			    $classes = get_posts($args);
			    if(isset($classes) && !empty($classes)) {
			    	$i = 1;
			    	foreach( $classes as $class ) {

			    		$class_id = $class->ID;

		                $purchase_checked = '';
		                $purchase_switchclass = 'checkbox-switch-off';

						$active_package_classes = dtlms_get_user_active_packages($student_id, 'classes');
						$active_package_classes = (is_array($active_package_classes) && !empty($active_package_classes)) ? $active_package_classes : array();
						$purchased_users = get_post_meta($class_id, 'purchased_users', true);
						if((is_array($purchased_users) && in_array($student_id, $purchased_users)) || (is_array($active_package_classes) && in_array($class_id, $active_package_classes))) {
		                    $purchase_checked = 'checked="checked"';
		                    $purchase_switchclass = 'checkbox-switch-on';
						}

		                $assigned_checked = '';
		                $assigned_switchclass = 'checkbox-switch-off';
						$assigned_users = get_post_meta($class_id, 'assigned_users', true);
						if(is_array($assigned_users) && in_array($student_id, $assigned_users)) {
		                    $assigned_checked = 'checked="checked"';
		                    $assigned_switchclass = 'checkbox-switch-on';
						}

						$output .= '<tr>
										<td>'.$i.'</td>
										<td>'.get_the_title($class_id).'</td>
										<td>'
											.'<div class="dtlms-checkbox-switch disabled '.$purchase_switchclass.'"></div>'.
										'</td>
										<td>'
											.'<div data-for="assign-classes-to-student-'.$class_id.'" class="dtlms-checkbox-switch '.$assigned_switchclass.'"></div>'
											.'<input id="assign-classes-to-student-'.$class_id.'" class="assign-classes-to-student hidden" type="checkbox" name="assign-classes-to-student" value="'.$class_id.'" '.$assigned_checked.' />'.
										'</td>
									</tr>';

						$page_class_ids = $class_id.','.$page_class_ids;

						$i++;

					}

				} else {
					$output .= '<tr>
									<td colspan="4">'.esc_html__('No records found!', 'dtlms').'</td>
								</tr>';
				}

			$output .= '</table>';

		$output .= '</form>';

		$output .= '<div class="dtlms-assign-classes-classes-response-holder"></div>';

		$output .= '<a href="#" class="dtlms-button dtlms-save-assign-classes-classes-settings small" data-studentid="'.$student_id.'" data-pageclassids="'.rtrim($page_class_ids, ',').'">'.esc_html__('Assign', 'dtlms').'</a>';


		wp_reset_postdata();

		// Pagination script Start
		$total_post_args = array (
						'posts_per_page' => -1,
						'post_type'=> 'dtlms_classes'
					);
		$total_post_args['meta_query'][] = array (
			'key'     => '_regular_price',
			'value'   => 0,
			'type'    => 'numeric',
			'compare' => '>'
		);
		$total_post_classes = get_posts( $total_post_args );
		wp_reset_postdata();

		$classes_post_count = count($total_post_classes);
		$max_num_pages = ceil($classes_post_count / $post_per_page);

		$item_ids['student_id'] = $student_id;

		$output .= dtlms_ajax_pagination($max_num_pages, $current_page, $function_call, $output_div, $item_ids);
		// Pagination script End

	} else {

		$output .= esc_html__('Please choose student!' , 'dtlms');

	}

	echo dtlms_html_output($output);

	die();

}

add_action( 'wp_ajax_dtlms_save_assign_classes_classes_settings', 'dtlms_save_assign_classes_classes_settings' );
add_action( 'wp_ajax_nopriv_dtlms_save_assign_classes_classes_settings', 'dtlms_save_assign_classes_classes_settings' );
function dtlms_save_assign_classes_classes_settings() {

	$student_id = dtlms_recursive_sanitize_text_field($_REQUEST['student_id']);
	$page_class_ids = !empty($_REQUEST['page_class_ids']) ? explode(',', dtlms_recursive_sanitize_text_field($_REQUEST['page_class_ids'])) : array ();
	$class_ids = is_array($_REQUEST['class_ids']) && !empty($_REQUEST['class_ids']) ? dtlms_recursive_sanitize_text_field($_REQUEST['class_ids']) : array ();

	$output = '';

	if($student_id != '') {

		$class_plural_label = apply_filters( 'class_label', 'plural' );

		$args = array (
		    'post_type'   => 'dtlms_classes',
			'posts_per_page' => -1,
			'post__in'       => $page_class_ids
	    );

	    $classes = get_posts($args);

	    if(isset($classes) && !empty($classes)) {
	    	foreach( $classes as $class ) {

	    		$class_id = $class->ID;

            	if(in_array($class_id, $class_ids)) {

					$assigned_users = get_post_meta($class_id, 'assigned_users', true);
					$assigned_users = (is_array($assigned_users) && !empty($assigned_users)) ? $assigned_users : array();
					array_push($assigned_users, $student_id);
					update_post_meta($class_id, 'assigned_users', array_unique($assigned_users));

					// Start class for user
					$class_data = get_post($class_id);
					$author_id = $class_data->post_author;
					dtlms_start_class_initialize($class_id, $student_id, $author_id, false);

					// Notification & Mail
					do_action('dtlms_poc_class_assigned', $class_id, $student_id);

            	} else {

					$assigned_users = get_post_meta($class_id, 'assigned_users', true);
					$assigned_users = (is_array($assigned_users) && !empty($assigned_users)) ? $assigned_users : array();
					if(in_array($student_id, $assigned_users)) {
					    unset($assigned_users[array_search($student_id, $assigned_users)]);
					}
					update_post_meta($class_id, 'assigned_users', array_unique($assigned_users));

            	}

			}
		}

		update_user_meta($student_id, 'assigned_classes', array_unique($class_ids));

		$output .= sprintf( esc_html__( '%1$s assigned successfully!', 'dtlms' ), $class_plural_label );

	} else {

		$output .= esc_html__('Something went wrong!', 'dtlms');

	}

	echo dtlms_html_output($output);

	die();

}


?>