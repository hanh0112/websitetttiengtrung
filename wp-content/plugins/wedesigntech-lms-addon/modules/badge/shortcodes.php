<?php

if(!function_exists('dtlms_student_badges')) {
	function dtlms_student_badges( $attrs, $content = null ) {

		$attrs = shortcode_atts ( array (

					'item-type' => 'course',
					'include-registration-class' => '',

				), $attrs, 'dtlms_student_badges' );

		$output = '';

		$current_user = wp_get_current_user();
		$user_id = $current_user->ID;

		if ( in_array( 'student', (array) $current_user->roles ) ) {

			$registered_classes = $completed_items = array ();

			if($attrs['item-type'] == 'class' || $attrs['item-type'] == 'all') {

				$completed_classes = get_user_meta($user_id, 'completed_classes', true);
				$completed_classes = (is_array($completed_classes) && !empty($completed_classes)) ? array_filter($completed_classes) : array ();

				$completed_items = array_merge_recursive($completed_items, $completed_classes);

			}

			if($attrs['item-type'] == 'course' || $attrs['item-type'] == 'all') {

				$completed_courses = get_user_meta($user_id, 'completed_courses', true);
				$completed_courses = (is_array($completed_courses) && !empty($completed_courses)) ? array_filter($completed_courses) : array ();

				$completed_items = array_merge_recursive($completed_items, $completed_courses);

			}

			if(($attrs['item-type'] == 'class' && $attrs['include-registration-class'] == 'true') || $attrs['item-type'] == 'all') {
				$registered_classes = get_user_meta($user_id, 'registered_classes', true);
				$registered_classes = (is_array($registered_classes) && !empty($registered_classes)) ? $registered_classes : array ();
			}

			$output .= '<div class="dtlms-student-badges-holder">';

				if(is_array($completed_items) && !empty($completed_items)) {
					foreach($completed_items as $completed_item) {
						$curriculum_details = get_user_meta($user_id, $completed_item, true);
						$completed_item_grade_id = $curriculum_details['grade-post-id'];

			            $badge_achieved = get_post_meta($completed_item_grade_id, 'badge-achieved', true);
			            if($badge_achieved == 'true') {
							$badge_image_url = get_post_meta ( $completed_item, 'badge-image-url', true );
							$output .= '<img src="'.$badge_image_url.'" alt="'.esc_html__('LMS Badge', 'dtlms').'" title="'.esc_html__('LMS Badge', 'dtlms').'" />';
			            }
					}
				}

				if(is_array($registered_classes) && !empty($registered_classes)) {
					foreach($registered_classes as $class_id) {
						$registered_users = get_post_meta($class_id, 'registered_users', true);
						$registered_users = (is_array($registered_users) && !empty($registered_users)) ? $registered_users : array ();

						if(isset($registered_users[$user_id]['badge']) && $registered_users[$user_id]['badge'] == 'approved') {
							$badge_image_url = get_post_meta($class_id, 'badge-image-url', true);
							$output .= '<img src="'.$badge_image_url.'" alt="'.esc_html__('LMS Badge', 'dtlms').'" title="'.esc_html__('LMS Badge', 'dtlms').'" />';
						}
					}
				}

			$output .= '</div>';

		} else if(in_array( 'administrator', (array) $current_user->roles )) {

			$output .= esc_html__('No records found.', 'dtlms');

		} else {

			$output .= esc_html__('You are not authorized to view these datas.', 'dtlms');

		}

		return $output;

	}
    add_shortcode ( 'dtlms_student_badges', 'dtlms_student_badges' );
}

?>