<?php

// Point Of Contacts
if(!function_exists('dtlms_point_of_contacts_update_certificate_module')) {
    function dtlms_point_of_contacts_update_certificate_module($dtlms_point_of_contacts) {

        $dtlms_point_of_contacts['course_certificate_achieved'] = array (
			'label' => esc_html__('Course Certificate Achieved', 'dtlms'),
			'name' => 'course_certificate_achieved',
			'hook' => 'dtlms_poc_course_certificate_achieved',
			'params' => 2,
        );
        $dtlms_point_of_contacts['class_certificate_achieved'] = array (
			'label' => sprintf( esc_html__( '%1$s Certificate Achieved', 'dtlms' ), DTLMS_CLASS_SINGULAR_LABEL ),
			'name' => 'class_certificate_achieved',
			'hook' => 'dtlms_poc_class_certificate_achieved',
			'params' => 2,
		);

        return $dtlms_point_of_contacts;

    }
    add_filter ( 'dtlms_point_of_contacts', 'dtlms_point_of_contacts_update_certificate_module', 15, 1 );
}


// POC - Course Certificate Achieved

function dtlms_poc_student_notification_course_certificate_achieved($course_id, $student_id) {

	bp_notifications_add_notification( array(
		'user_id'           => $student_id,
		'item_id'           => $course_id,
		'secondary_item_id'	=> false,
		'component_name'    => 'dtlms_poc',
		'component_action'  => 'course_certificate_achieved_student',
		'date_notified'     => bp_core_current_time(),
		'is_new'            => 1,
	) );

}

function dtlms_poc_student_email_course_certificate_achieved($course_id, $student_id) {

	$poc_settings = get_option('dtlms-poc-settings');
	$poc_email_subject_prefix = ( isset($poc_settings['poc-email-subject-prefix']) && '' !=  $poc_settings['poc-email-subject-prefix'] ) ? $poc_settings['poc-email-subject-prefix'] : '';

	$to = get_the_author_meta('email', $student_id);
	$subject = $poc_email_subject_prefix.esc_html__('Course Certificate Achieved', 'dtlms');
	$poc_content = sprintf(esc_html__('Congratulations! You have achieved certificate for the course %1$s.','dtlms'),'<a href="'.get_permalink($course_id).'">'.get_the_title($course_id).'</a>');
	dtlms_poc_email_configuration($to, $subject, $poc_content);

}

function dtlms_poc_instructor_notification_course_certificate_achieved($course_id, $student_id) {

	$instructor_ids = dtlms_poc_get_instructor_ids($course_id);
	foreach($instructor_ids as $instructor_id) {
		bp_notifications_add_notification( array(
			'user_id'           => $instructor_id,
			'item_id'           => $course_id,
			'secondary_item_id'	=> $student_id,
			'component_name'    => 'dtlms_poc',
			'component_action'  => 'course_certificate_achieved_instructor',
			'date_notified'     => bp_core_current_time(),
			'is_new'            => 1,
		) );
	}

}

function dtlms_poc_instructor_email_course_certificate_achieved($course_id, $student_id) {

	$poc_settings = get_option('dtlms-poc-settings');
	$poc_email_subject_prefix = ( isset($poc_settings['poc-email-subject-prefix']) && '' !=  $poc_settings['poc-email-subject-prefix'] ) ? $poc_settings['poc-email-subject-prefix'] : '';

	$instructor_ids = dtlms_poc_get_instructor_ids($course_id);
	foreach($instructor_ids as $instructor_id) {
		$to = get_the_author_meta('email', $instructor_id);
		$subject = $poc_email_subject_prefix.esc_html__('Student - Course Certificate Achieved', 'dtlms');
		$poc_content = sprintf(esc_html__('%2$s have achieved certificate for the course %1$s.','dtlms'),'<a href="'.get_permalink($course_id).'">'.get_the_title($course_id).'</a>', '<a href="'.get_author_posts_url($student_id).'">'.get_the_author_meta('display_name', $student_id).'</a>');
		dtlms_poc_email_configuration($to, $subject, $poc_content);
	}

}



// POC - Class Certificate Achieved

function dtlms_poc_student_notification_class_certificate_achieved($class_id, $student_id) {

	bp_notifications_add_notification( array(
		'user_id'           => $student_id,
		'item_id'           => $class_id,
		'secondary_item_id'	=> false,
		'component_name'    => 'dtlms_poc',
		'component_action'  => 'class_certificate_achieved_student',
		'date_notified'     => bp_core_current_time(),
		'is_new'            => 1,
	) );

}

function dtlms_poc_student_email_class_certificate_achieved($class_id, $student_id) {

	$poc_settings = get_option('dtlms-poc-settings');
	$poc_email_subject_prefix = ( isset($poc_settings['poc-email-subject-prefix']) && '' !=  $poc_settings['poc-email-subject-prefix'] ) ? $poc_settings['poc-email-subject-prefix'] : '';

	$class_singular_label = apply_filters( 'class_label', 'singular' );

	$to = get_the_author_meta('email', $student_id);
	$subject = $poc_email_subject_prefix.sprintf( esc_html__( '%1$s Certificate Achieved', 'dtlms' ), $class_singular_label );
	$poc_content = sprintf(esc_html__('Congratulations! You have achieved certificate for the %1$s %2$s.','dtlms'), strtolower($class_singular_label), '<a href="'.get_permalink($class_id).'">'.get_the_title($class_id).'</a>');
	dtlms_poc_email_configuration($to, $subject, $poc_content);

}

function dtlms_poc_instructor_notification_class_certificate_achieved($class_id, $student_id) {

	$instructor_ids = dtlms_poc_get_instructor_ids($class_id);
	foreach($instructor_ids as $instructor_id) {
		bp_notifications_add_notification( array(
			'user_id'           => $instructor_id,
			'item_id'           => $class_id,
			'secondary_item_id'	=> $student_id,
			'component_name'    => 'dtlms_poc',
			'component_action'  => 'class_certificate_achieved_instructor',
			'date_notified'     => bp_core_current_time(),
			'is_new'            => 1,
		) );
	}

}

function dtlms_poc_instructor_email_class_certificate_achieved($class_id, $student_id) {

	$poc_settings = get_option('dtlms-poc-settings');
	$poc_email_subject_prefix = ( isset($poc_settings['poc-email-subject-prefix']) && '' !=  $poc_settings['poc-email-subject-prefix'] ) ? $poc_settings['poc-email-subject-prefix'] : '';

	$class_singular_label = apply_filters( 'class_label', 'singular' );

	$instructor_ids = dtlms_poc_get_instructor_ids($class_id);
	foreach($instructor_ids as $instructor_id) {
		$to = get_the_author_meta('email', $instructor_id);
		$subject = $poc_email_subject_prefix.sprintf( esc_html__( 'Student - %1$s Certificate Achieved', 'dtlms' ), $class_singular_label );
		$poc_content = sprintf(esc_html__('%1$s have achieved certificate for the %2$s %3$s.','dtlms'), '<a href="'.get_author_posts_url($student_id).'">'.get_the_author_meta('display_name', $student_id).'</a>', strtolower($class_singular_label),'<a href="'.get_permalink($class_id).'">'.get_the_title($class_id).'</a>');
		dtlms_poc_email_configuration($to, $subject, $poc_content);
	}

}


// Configure notification message here
if(!function_exists('dtlms_format_buddypress_notifications_certificate_module')) {
	function dtlms_format_buddypress_notifications_certificate_module( $action, $item_id, $secondary_item_id, $total_items, $format = 'string' ) {

		switch ( $action ) {
			case 'course_certificate_achieved_student':
				return sprintf(esc_html__('Congratulations! You have achieved certificate for the course %1$s.','dtlms'),'<a href="'.get_permalink($item_id).'">'.get_the_title($item_id).'</a>');
			break;
			case 'course_certificate_achieved_instructor':
				return sprintf(esc_html__('%2$s have achieved certificate for the course %1$s.','dtlms'),'<a href="'.get_permalink($item_id).'">'.get_the_title($item_id).'</a>', '<a href="'.get_author_posts_url($secondary_item_id).'">'.get_the_author_meta('display_name', $secondary_item_id).'</a>');
			break;
			case 'class_certificate_achieved_student':
				return sprintf(esc_html__('Congratulations! You have achieved certificate for the %1$s %2$s.','dtlms'), strtolower($class_singular_label), '<a href="'.get_permalink($item_id).'">'.get_the_title($item_id).'</a>');
			break;
			case 'class_certificate_achieved_instructor':
				return sprintf(esc_html__('%1$s have achieved certificate for the %2$s %3$s.','dtlms'), '<a href="'.get_author_posts_url($secondary_item_id).'">'.get_the_author_meta('display_name', $secondary_item_id).'</a>', strtolower($class_singular_label), '<a href="'.get_permalink($item_id).'">'.get_the_title($item_id).'</a>');
			break;
		}

		return apply_filters( 'bp_course_format_notifications',false, $action, $item_id, $secondary_item_id, $total_items );

	}
	add_filter( 'bp_course_format_notifications', 'dtlms_format_buddypress_notifications_certificate_module', 30, 5 );
}

?>