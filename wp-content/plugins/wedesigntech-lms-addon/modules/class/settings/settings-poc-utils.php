<?php

// Point Of Contacts
if(!function_exists('dtlms_point_of_contacts_update_class_module')) {
    function dtlms_point_of_contacts_update_class_module($dtlms_point_of_contacts) {

		$dtlms_point_of_contacts['class_added'] = array (
			'label' => sprintf( esc_html__( 'New %1$s Added', 'dtlms' ), DTLMS_CLASS_SINGULAR_LABEL ),
			'name' => 'class_added',
			'hook' => 'dtlms_poc_class_added',
			'params' => 2,
		);
		$dtlms_point_of_contacts['class_subscribed'] = array (
			'label' => sprintf( esc_html__( '%1$s Subscribed', 'dtlms' ), DTLMS_CLASS_SINGULAR_LABEL ),
			'name' => 'class_subscribed',
			'hook' => 'dtlms_poc_class_subscribed',
			'params' => 2,
		);
		$dtlms_point_of_contacts['class_subscription_cancellation'] = array (
			'label' => sprintf( esc_html__( '%1$s Subscription Cancellation', 'dtlms' ), DTLMS_CLASS_SINGULAR_LABEL ),
			'name' => 'class_subscription_cancellation',
			'hook' => 'dtlms_poc_class_subscription_cancellation',
			'params' => 2,
		);
		$dtlms_point_of_contacts['class_assigned'] = array (
			'label' => sprintf( esc_html__( '%1$s Assigned', 'dtlms' ), DTLMS_CLASS_SINGULAR_LABEL ),
			'name' => 'class_assigned',
			'hook' => 'dtlms_poc_class_assigned',
			'params' => 2,
		);
		$dtlms_point_of_contacts['class_submitted'] = array (
			'label' => sprintf( esc_html__( '%1$s Submitted', 'dtlms' ), DTLMS_CLASS_SINGULAR_LABEL ),
			'name' => 'class_submitted',
			'hook' => 'dtlms_poc_class_submitted',
			'params' => 2,
		);
		$dtlms_point_of_contacts['class_evaluated'] = array (
			'label' => sprintf( esc_html__( '%1$s Evaluated', 'dtlms' ), DTLMS_CLASS_SINGULAR_LABEL ),
			'name' => 'class_evaluated',
			'hook' => 'dtlms_poc_class_evaluated',
			'params' => 2,
		);
		$dtlms_point_of_contacts['class_submission_revoke'] = array (
			'label' => sprintf( esc_html__( '%1$s Submission Revoke', 'dtlms' ), DTLMS_CLASS_SINGULAR_LABEL ),
			'name' => 'class_submission_revoke',
			'hook' => 'dtlms_poc_class_submission_revoke',
			'params' => 2,
		);

        return $dtlms_point_of_contacts;

    }
    add_filter ( 'dtlms_point_of_contacts', 'dtlms_point_of_contacts_update_class_module', 10, 1 );
}


// POC - Class Added

function dtlms_poc_student_notification_class_added($class_id, $author_id) {

	$student_ids = dtlms_poc_get_student_ids();

	foreach($student_ids as $student_id) {
		bp_notifications_add_notification( array(
			'user_id'           => $student_id,
			'item_id'           => $class_id,
			'secondary_item_id'	=> $author_id,
			'component_name'    => 'dtlms_poc',
			'component_action'  => 'class_added_student',
			'date_notified'     => bp_core_current_time(),
			'is_new'            => 1,
		) );
	}

}

function dtlms_poc_student_email_class_added($class_id, $author_id) {

	$poc_settings = get_option('dtlms-poc-settings');
	$poc_email_subject_prefix = ( isset($poc_settings['poc-email-subject-prefix']) && '' !=  $poc_settings['poc-email-subject-prefix'] ) ? $poc_settings['poc-email-subject-prefix'] : '';

	$class_singular_label = apply_filters( 'class_label', 'singular' );

	$student_ids = dtlms_poc_get_student_ids();
	foreach($student_ids as $student_id) {
		$to = get_the_author_meta('email', $student_id);
		$subject = $poc_email_subject_prefix.sprintf( esc_html__( 'New %1$s Added', 'dtlms' ), $class_singular_label );
		$poc_content = sprintf(esc_html__('New %1$s %2$s have been added by %3$s','dtlms'), strtolower($class_singular_label),'<a href="'.get_permalink($class_id).'">'.get_the_title($class_id).'</a>', '<a href="'.get_author_posts_url($author_id).'">'.get_the_author_meta('display_name', $author_id).'</a>');
		dtlms_poc_email_configuration($to, $subject, $poc_content);
	}

}

function dtlms_poc_instructor_notification_class_added($class_id, $author_id) {

	$instructor_ids = dtlms_poc_get_instructor_ids(-1);
	foreach($instructor_ids as $instructor_id) {
		bp_notifications_add_notification( array(
			'user_id'           => $instructor_id,
			'item_id'           => $class_id,
			'secondary_item_id'	=> $author_id,
			'component_name'    => 'dtlms_poc',
			'component_action'  => 'class_added_instructor',
			'date_notified'     => bp_core_current_time(),
			'is_new'            => 1,
		) );
	}

}

function dtlms_poc_instructor_email_class_added($class_id, $author_id) {

	$poc_settings = get_option('dtlms-poc-settings');
	$poc_email_subject_prefix = ( isset($poc_settings['poc-email-subject-prefix']) && '' !=  $poc_settings['poc-email-subject-prefix'] ) ? $poc_settings['poc-email-subject-prefix'] : '';

	$class_singular_label = apply_filters( 'class_label', 'singular' );

	$instructor_ids = dtlms_poc_get_instructor_ids(-1);
	foreach($instructor_ids as $instructor_id) {
		$to = get_the_author_meta('email', $instructor_id);
		$subject = $poc_email_subject_prefix.sprintf( esc_html__( 'New %1$s Added', 'dtlms' ), $class_singular_label );
		$poc_content = sprintf(esc_html__('New %1$s %2$s have been added by %3$s','dtlms'), strtolower($class_singular_label), '<a href="'.get_permalink($class_id).'">'.get_the_title($class_id).'</a>', '<a href="'.get_author_posts_url($author_id).'">'.get_the_author_meta('display_name', $author_id).'</a>');
		dtlms_poc_email_configuration($to, $subject, $poc_content);
	}

}

// POC - Class Subscribed

function dtlms_poc_student_notification_class_subscribed($class_id, $student_id) {

	bp_notifications_add_notification( array(
		'user_id'           => $student_id,
		'item_id'           => $class_id,
		'secondary_item_id'	=> false,
		'component_name'    => 'dtlms_poc',
		'component_action'  => 'class_subscribed_student',
		'date_notified'     => bp_core_current_time(),
		'is_new'            => 1,
	) );

}

function dtlms_poc_student_email_class_subscribed($class_id, $student_id) {

	$class_singular_label = apply_filters( 'class_label', 'singular' );

	$poc_settings = get_option('dtlms-poc-settings');
	$poc_email_subject_prefix = ( isset($poc_settings['poc-email-subject-prefix']) && '' !=  $poc_settings['poc-email-subject-prefix'] ) ? $poc_settings['poc-email-subject-prefix'] : '';

	$class_singular_label = apply_filters( 'class_label', 'singular' );

	$to = get_the_author_meta('email', $student_id);
	$subject = $poc_email_subject_prefix.sprintf( esc_html__( '%1$s Subscribed', 'dtlms' ), $class_singular_label );
	$poc_content = sprintf(esc_html__('You have subscribed %1$s %2$s','dtlms'), strtolower($class_singular_label),'<a href="'.get_permalink($class_id).'">'.get_the_title($class_id).'</a>');
	dtlms_poc_email_configuration($to, $subject, $poc_content);

}

function dtlms_poc_instructor_notification_class_subscribed($class_id, $student_id) {

	$instructor_ids = dtlms_poc_get_instructor_ids($class_id);
	foreach($instructor_ids as $instructor_id) {
		bp_notifications_add_notification( array(
			'user_id'           => $instructor_id,
			'item_id'           => $class_id,
			'secondary_item_id'	=> $student_id,
			'component_name'    => 'dtlms_poc',
			'component_action'  => 'class_subscribed_instructor',
			'date_notified'     => bp_core_current_time(),
			'is_new'            => 1,
		) );
	}

}

function dtlms_poc_instructor_email_class_subscribed($class_id, $student_id) {

	$poc_settings = get_option('dtlms-poc-settings');
	$poc_email_subject_prefix = ( isset($poc_settings['poc-email-subject-prefix']) && '' !=  $poc_settings['poc-email-subject-prefix'] ) ? $poc_settings['poc-email-subject-prefix'] : '';

	$class_singular_label = apply_filters( 'class_label', 'singular' );

	$instructor_ids = dtlms_poc_get_instructor_ids($class_id);
	foreach($instructor_ids as $instructor_id) {
		$to = get_the_author_meta('email', $instructor_id);
		$subject = $poc_email_subject_prefix.sprintf( esc_html__( 'Student - %1$s Subscribed', 'dtlms' ), $class_singular_label );
		$poc_content = sprintf(esc_html__('%1$s %2$s have been subscribed by %3$s','dtlms'), $class_singular_label,'<a href="'.get_permalink($class_id).'">'.get_the_title($class_id).'</a>', '<a href="'.get_author_posts_url($student_id).'">'.get_the_author_meta('display_name', $student_id).'</a>');
		dtlms_poc_email_configuration($to, $subject, $poc_content);
	}

}

// POC - Class Subscribed Cancellation

function dtlms_poc_student_notification_class_subscription_cancellation($class_id, $student_id) {

	bp_notifications_add_notification( array(
		'user_id'           => $student_id,
		'item_id'           => $class_id,
		'secondary_item_id'	=> false,
		'component_name'    => 'dtlms_poc',
		'component_action'  => 'class_subscription_cancellation_student',
		'date_notified'     => bp_core_current_time(),
		'is_new'            => 1,
	) );

}

function dtlms_poc_student_email_class_subscription_cancellation($class_id, $student_id) {

	$poc_settings = get_option('dtlms-poc-settings');
	$poc_email_subject_prefix = ( isset($poc_settings['poc-email-subject-prefix']) && '' !=  $poc_settings['poc-email-subject-prefix'] ) ? $poc_settings['poc-email-subject-prefix'] : '';

	$class_singular_label = apply_filters( 'class_label', 'singular' );

	$to = get_the_author_meta('email', $student_id);
	$subject = $poc_email_subject_prefix.sprintf( esc_html__( '%1$s Subscription Cancellation', 'dtlms' ), $class_singular_label );
	$poc_content = sprintf(esc_html__('Your subscription for %1$s %2$s have been cancelled','dtlms'), strtolower($class_singular_label),'<a href="'.get_permalink($package_id).'">'.get_the_title($class_id).'</a>');
	dtlms_poc_email_configuration($to, $subject, $poc_content);

}

function dtlms_poc_instructor_notification_class_subscription_cancellation($class_id, $student_id) {

	$instructor_ids = dtlms_poc_get_instructor_ids($class_id);
	foreach($instructor_ids as $instructor_id) {
		bp_notifications_add_notification( array(
			'user_id'           => $instructor_id,
			'item_id'           => $class_id,
			'secondary_item_id'	=> $student_id,
			'component_name'    => 'dtlms_poc',
			'component_action'  => 'class_subscription_cancellation_instructor',
			'date_notified'     => bp_core_current_time(),
			'is_new'            => 1,
		) );
	}

}

function dtlms_poc_instructor_email_class_subscription_cancellation($class_id, $student_id) {

	$poc_settings = get_option('dtlms-poc-settings');
	$poc_email_subject_prefix = ( isset($poc_settings['poc-email-subject-prefix']) && '' !=  $poc_settings['poc-email-subject-prefix'] ) ? $poc_settings['poc-email-subject-prefix'] : '';

	$class_singular_label = apply_filters( 'class_label', 'singular' );

	$instructor_ids = dtlms_poc_get_instructor_ids($class_id);
	foreach($instructor_ids as $instructor_id) {
		$to = get_the_author_meta('email', $instructor_id);
		$subject = $poc_email_subject_prefix.sprintf( esc_html__( 'Student - %1$s Subscription Cancellation', 'dtlms' ), $class_singular_label );
		$poc_content = sprintf(esc_html__('%1$s subscription for %2$s %3$s have been cancelled','dtlms'), $class_singular_label, '<a href="'.get_author_posts_url($student_id).'">'.get_the_author_meta('display_name', $student_id).'</a>','<a href="'.get_permalink($class_id).'">'.get_the_title($class_id).'</a>');
		dtlms_poc_email_configuration($to, $subject, $poc_content);
	}

}

// POC - Class Assigned

function dtlms_poc_student_notification_class_assigned($class_id, $student_id) {

	bp_notifications_add_notification( array(
		'user_id'           => $student_id,
		'item_id'           => $class_id,
		'secondary_item_id'	=> false,
		'component_name'    => 'dtlms_poc',
		'component_action'  => 'class_assigned_student',
		'date_notified'     => bp_core_current_time(),
		'is_new'            => 1,
	) );

}

function dtlms_poc_student_email_class_assigned($class_id, $student_id) {

	$poc_settings = get_option('dtlms-poc-settings');
	$poc_email_subject_prefix = ( isset($poc_settings['poc-email-subject-prefix']) && '' !=  $poc_settings['poc-email-subject-prefix'] ) ? $poc_settings['poc-email-subject-prefix'] : '';

	$class_singular_label = apply_filters( 'class_label', 'singular' );

	$to = get_the_author_meta('email', $student_id);
	$subject = $poc_email_subject_prefix.sprintf( esc_html__( '%1$s Assigned', 'dtlms' ), $class_singular_label );
	$poc_content = sprintf(esc_html__('%1$s %2$s have been assigned to you.','dtlms'), $class_singular_label,'<a href="'.get_permalink($class_id).'">'.get_the_title($class_id).'</a>');
	dtlms_poc_email_configuration($to, $subject, $poc_content);

}

function dtlms_poc_instructor_notification_class_assigned($class_id, $student_id) {

	$instructor_ids = dtlms_poc_get_instructor_ids($class_id);
	foreach($instructor_ids as $instructor_id) {
		bp_notifications_add_notification( array(
			'user_id'           => $instructor_id,
			'item_id'           => $class_id,
			'secondary_item_id'	=> $student_id,
			'component_name'    => 'dtlms_poc',
			'component_action'  => 'class_assigned_instructor',
			'date_notified'     => bp_core_current_time(),
			'is_new'            => 1,
		) );
	}

}

function dtlms_poc_instructor_email_class_assigned($class_id, $student_id) {

	$poc_settings = get_option('dtlms-poc-settings');
	$poc_email_subject_prefix = ( isset($poc_settings['poc-email-subject-prefix']) && '' !=  $poc_settings['poc-email-subject-prefix'] ) ? $poc_settings['poc-email-subject-prefix'] : '';

	$class_singular_label = apply_filters( 'class_label', 'singular' );

	$instructor_ids = dtlms_poc_get_instructor_ids($class_id);
	foreach($instructor_ids as $instructor_id) {
		$to = get_the_author_meta('email', $instructor_id);
		$subject = $poc_email_subject_prefix.sprintf( esc_html__( 'Student - %1$s Assigned', 'dtlms' ), $class_singular_label );
		$poc_content = sprintf(esc_html__('%1$s %2$s have been assigned to %3$s','dtlms'), $class_singular_label,'<a href="'.get_permalink($class_id).'">'.get_the_title($class_id).'</a>', '<a href="'.get_author_posts_url($student_id).'">'.get_the_author_meta('display_name', $student_id).'</a>');
		dtlms_poc_email_configuration($to, $subject, $poc_content);
	}

}

// POC - Class Submitted

function dtlms_poc_student_notification_class_submitted($class_id, $student_id) {

	bp_notifications_add_notification( array(
		'user_id'           => $student_id,
		'item_id'           => $class_id,
		'secondary_item_id'	=> false,
		'component_name'    => 'dtlms_poc',
		'component_action'  => 'class_submitted_student',
		'date_notified'     => bp_core_current_time(),
		'is_new'            => 1,
	) );

}

function dtlms_poc_student_email_class_submitted($class_id, $student_id) {

	$poc_settings = get_option('dtlms-poc-settings');
	$poc_email_subject_prefix = ( isset($poc_settings['poc-email-subject-prefix']) && '' !=  $poc_settings['poc-email-subject-prefix'] ) ? $poc_settings['poc-email-subject-prefix'] : '';

	$class_singular_label = apply_filters( 'class_label', 'singular' );

	$to = get_the_author_meta('email', $student_id);
	$subject = $poc_email_subject_prefix.sprintf( esc_html__( '%1$s Submitted', 'dtlms' ), $class_singular_label );
	$poc_content = sprintf(esc_html__('You have submitted %1$s %2$s','dtlms'), strtolower($class_singular_label), '<a href="'.get_permalink($class_id).'">'.get_the_title($class_id).'</a>');
	dtlms_poc_email_configuration($to, $subject, $poc_content);

}

function dtlms_poc_instructor_notification_class_submitted($class_id, $student_id) {

	$instructor_ids = dtlms_poc_get_instructor_ids($class_id);
	foreach($instructor_ids as $instructor_id) {
		bp_notifications_add_notification( array(
			'user_id'           => $instructor_id,
			'item_id'           => $class_id,
			'secondary_item_id'	=> $student_id,
			'component_name'    => 'dtlms_poc',
			'component_action'  => 'class_submitted_instructor',
			'date_notified'     => bp_core_current_time(),
			'is_new'            => 1,
		) );
	}

}

function dtlms_poc_instructor_email_class_submitted($class_id, $student_id) {

	$poc_settings = get_option('dtlms-poc-settings');
	$poc_email_subject_prefix = ( isset($poc_settings['poc-email-subject-prefix']) && '' !=  $poc_settings['poc-email-subject-prefix'] ) ? $poc_settings['poc-email-subject-prefix'] : '';

	$class_singular_label = apply_filters( 'class_label', 'singular' );

	$instructor_ids = dtlms_poc_get_instructor_ids($class_id);
	foreach($instructor_ids as $instructor_id) {
		$to = get_the_author_meta('email', $instructor_id);
		$subject = $poc_email_subject_prefix.sprintf( esc_html__( 'Student - %1$s Submitted', 'dtlms' ), $class_singular_label );
		$poc_content = sprintf(esc_html__('%1$s %2$s have been submitted by %3$s','dtlms'), $class_singular_label,'<a href="'.get_permalink($class_id).'">'.get_the_title($class_id).'</a>', '<a href="'.get_author_posts_url($student_id).'">'.get_the_author_meta('display_name', $student_id).'</a>');
		dtlms_poc_email_configuration($to, $subject, $poc_content);
	}

}

// POC - Class Evaluated

function dtlms_poc_student_notification_class_evaluated($class_id, $student_id) {

	bp_notifications_add_notification( array(
		'user_id'           => $student_id,
		'item_id'           => $class_id,
		'secondary_item_id'	=> false,
		'component_name'    => 'dtlms_poc',
		'component_action'  => 'class_evaluated_student',
		'date_notified'     => bp_core_current_time(),
		'is_new'            => 1,
	) );

}

function dtlms_poc_student_email_class_evaluated($class_id, $student_id) {

	$poc_settings = get_option('dtlms-poc-settings');
	$poc_email_subject_prefix = ( isset($poc_settings['poc-email-subject-prefix']) && '' !=  $poc_settings['poc-email-subject-prefix'] ) ? $poc_settings['poc-email-subject-prefix'] : '';

	$class_singular_label = apply_filters( 'class_label', 'singular' );

	$to = get_the_author_meta('email', $student_id);
	$subject = $poc_email_subject_prefix.sprintf( esc_html__( '%1$s Evaluated', 'dtlms' ), $class_singular_label );
	$poc_content = sprintf(esc_html__('Your %1$s %2$s have been evaluated.','dtlms'), strtolower($class_singular_label),'<a href="'.get_permalink($class_id).'">'.get_the_title($class_id).'</a>');
	dtlms_poc_email_configuration($to, $subject, $poc_content);

}

function dtlms_poc_instructor_notification_class_evaluated($class_id, $student_id) {

	$instructor_ids = dtlms_poc_get_instructor_ids($class_id);
	foreach($instructor_ids as $instructor_id) {
		bp_notifications_add_notification( array(
			'user_id'           => $instructor_id,
			'item_id'           => $class_id,
			'secondary_item_id'	=> $student_id,
			'component_name'    => 'dtlms_poc',
			'component_action'  => 'class_evaluated_instructor',
			'date_notified'     => bp_core_current_time(),
			'is_new'            => 1,
		) );
	}

}

function dtlms_poc_instructor_email_class_evaluated($class_id, $student_id) {

	$poc_settings = get_option('dtlms-poc-settings');
	$poc_email_subject_prefix = ( isset($poc_settings['poc-email-subject-prefix']) && '' !=  $poc_settings['poc-email-subject-prefix'] ) ? $poc_settings['poc-email-subject-prefix'] : '';

	$class_singular_label = apply_filters( 'class_label', 'singular' );

	$instructor_ids = dtlms_poc_get_instructor_ids($class_id);
	foreach($instructor_ids as $instructor_id) {
		$to = get_the_author_meta('email', $instructor_id);
		$subject = $poc_email_subject_prefix.sprintf( esc_html__( 'Student - %1$s Evaluated', 'dtlms' ), $class_singular_label );
		$poc_content = sprintf(esc_html__('%1$s %2$s %3$s have been evaluated.','dtlms'), $class_singular_label, '<a href="'.get_permalink($class_id).'">'.get_the_title($class_id).'</a>', '<a href="'.get_author_posts_url($student_id).'">'.get_the_author_meta('display_name', $student_id).'</a>');
		dtlms_poc_email_configuration($to, $subject, $poc_content);
	}

}


// POC - Class Submission Revoked

function dtlms_poc_student_notification_class_submission_revoke($class_id, $student_id) {

	bp_notifications_add_notification( array(
		'user_id'           => $student_id,
		'item_id'           => $class_id,
		'secondary_item_id'	=> false,
		'component_name'    => 'dtlms_poc',
		'component_action'  => 'class_submission_revoked_student',
		'date_notified'     => bp_core_current_time(),
		'is_new'            => 1,
	) );

}

function dtlms_poc_student_email_class_submission_revoke($class_id, $student_id) {

	$poc_settings = get_option('dtlms-poc-settings');
	$poc_email_subject_prefix = ( isset($poc_settings['poc-email-subject-prefix']) && '' !=  $poc_settings['poc-email-subject-prefix'] ) ? $poc_settings['poc-email-subject-prefix'] : '';

	$class_singular_label = apply_filters( 'class_label', 'singular' );

	$to = get_the_author_meta('email', $student_id);
	$subject = $poc_email_subject_prefix.sprintf( esc_html__( '%1$s Submission Revoked', 'dtlms' ), $class_singular_label );
	$poc_content = sprintf(esc_html__('Your %1$s %2$s submission have been revoked.','dtlms'), strtolower($class_singular_label),'<a href="'.get_permalink($class_id).'">'.get_the_title($class_id).'</a>');
	dtlms_poc_email_configuration($to, $subject, $poc_content);

}

function dtlms_poc_instructor_notification_class_submission_revoke($class_id, $student_id) {

	$instructor_ids = dtlms_poc_get_instructor_ids($class_id);
	foreach($instructor_ids as $instructor_id) {
		bp_notifications_add_notification( array(
			'user_id'           => $instructor_id,
			'item_id'           => $class_id,
			'secondary_item_id'	=> $student_id,
			'component_name'    => 'dtlms_poc',
			'component_action'  => 'class_submission_revoked_instructor',
			'date_notified'     => bp_core_current_time(),
			'is_new'            => 1,
		) );
	}

}

function dtlms_poc_instructor_email_class_submission_revoke($class_id, $student_id) {

	$poc_settings = get_option('dtlms-poc-settings');
	$poc_email_subject_prefix = ( isset($poc_settings['poc-email-subject-prefix']) && '' !=  $poc_settings['poc-email-subject-prefix'] ) ? $poc_settings['poc-email-subject-prefix'] : '';

	$class_singular_label = apply_filters( 'class_label', 'singular' );

	$instructor_ids = dtlms_poc_get_instructor_ids($class_id);
	foreach($instructor_ids as $instructor_id) {
		$to = get_the_author_meta('email', $instructor_id);
		$subject = $poc_email_subject_prefix.sprintf( esc_html__( 'Student - %1$s Submission Revoked', 'dtlms' ), $class_singular_label );
		$poc_content = sprintf(esc_html__('%1$s %2$s %3$s submission have been revoked.','dtlms'), '<a href="'.get_author_posts_url($student_id).'">'.get_the_author_meta('display_name', $student_id).'</a>', strtolower($class_singular_label), '<a href="'.get_permalink($class_id).'">'.get_the_title($class_id).'</a>');
		dtlms_poc_email_configuration($to, $subject, $poc_content);
	}

}


// Configure notification message here
if(!function_exists('dtlms_format_buddypress_notifications_class_module')) {
	function dtlms_format_buddypress_notifications_class_module( $action, $item_id, $secondary_item_id, $total_items, $format = 'string' ) {

		$class_singular_label = apply_filters( 'class_label', 'singular' );

		switch ( $action ) {
			case 'class_added_student':
				return sprintf(esc_html__('New %1$s %2$s have been added by %3$s.','dtlms'), strtolower($class_singular_label),'<a href="'.get_permalink($item_id).'">'.get_the_title($item_id).'</a>', '<a href="'.get_author_posts_url($secondary_item_id).'">'.get_the_author_meta('display_name', $secondary_item_id).'</a>');
			break;
			case 'class_added_instructor':
				return sprintf(esc_html__('New %1$s %2$s have been added by %3$s.','dtlms'), strtolower($class_singular_label),'<a href="'.get_permalink($item_id).'">'.get_the_title($item_id).'</a>', '<a href="'.get_author_posts_url($secondary_item_id).'">'.get_the_author_meta('display_name', $secondary_item_id).'</a>');
			break;
			case 'class_subscribed_student':
				return sprintf(esc_html__('You have subscribed %1$s %2$s.','dtlms'), strtolower($class_singular_label),'<a href="'.get_permalink($item_id).'">'.get_the_title($item_id).'</a>');
			break;
			case 'class_subscribed_instructor':
				return sprintf(esc_html__('%1$s %2$s have been subscribed by %3$s.','dtlms'), $class_singular_label,'<a href="'.get_permalink($item_id).'">'.get_the_title($item_id).'</a>', '<a href="'.get_author_posts_url($secondary_item_id).'">'.get_the_author_meta('display_name', $secondary_item_id).'</a>');
			break;
			case 'class_subscription_cancellation_student':
				return sprintf(esc_html__('Your subscription for %1$s %2$s have been cancelled.','dtlms'), strtolower($class_singular_label), '<a href="'.get_permalink($item_id).'">'.get_the_title($item_id).'</a>');
			break;
			case 'class_subscription_cancellation_instructor':
				return sprintf(esc_html__('%1$s subscription for %2$s %3$s have been cancelled.','dtlms'), '<a href="'.get_author_posts_url($secondary_item_id).'">'.get_the_author_meta('display_name', $secondary_item_id).'</a>', strtolower($class_singular_label), '<a href="'.get_permalink($item_id).'">'.get_the_title($item_id).'</a>');
			break;
			case 'class_assigned_student':
				return sprintf(esc_html__('%1$s %2$s have been assigned to you.','dtlms'), $class_singular_label,'<a href="'.get_permalink($item_id).'">'.get_the_title($item_id).'</a>');
			break;
			case 'class_assigned_instructor':
				return sprintf(esc_html__('%1$s %2$s have been assigned to %2$s.','dtlms'), $class_singular_label,'<a href="'.get_permalink($item_id).'">'.get_the_title($item_id).'</a>', '<a href="'.get_author_posts_url($secondary_item_id).'">'.get_the_author_meta('display_name', $secondary_item_id).'</a>');
			break;
			case 'class_submitted_student':
				return sprintf(esc_html__('You have submitted %1$s %2$s.','dtlms'), strtolower($class_singular_label),'<a href="'.get_permalink($item_id).'">'.get_the_title($item_id).'</a>');
			break;
			case 'class_submitted_instructor':
				return sprintf(esc_html__('%1$s %2$s have been submitted by %2$s.','dtlms'), $class_singular_label,'<a href="'.get_permalink($item_id).'">'.get_the_title($item_id).'</a>', '<a href="'.get_author_posts_url($secondary_item_id).'">'.get_the_author_meta('display_name', $secondary_item_id).'</a>');
			break;
			case 'class_evaluated_student':
				return sprintf(esc_html__('Your class %1$s have been evaluated.','dtlms'), strtolower($class_singular_label),'<a href="'.get_permalink($item_id).'">'.get_the_title($item_id).'</a>');
			break;
			case 'class_evaluated_instructor':
				return sprintf(esc_html__('%1$s %2$s %3$s have been evaluated.','dtlms'), '<a href="'.get_author_posts_url($secondary_item_id).'">'.get_the_author_meta('display_name', $secondary_item_id).'</a>', strtolower($class_singular_label),'<a href="'.get_permalink($item_id).'">'.get_the_title($item_id).'</a>');
			break;
			case 'class_submission_revoked_student':
				return sprintf(esc_html__('Your %1$s %2$s submission have been revoked.','dtlms'), strtolower($class_singular_label),'<a href="'.get_permalink($item_id).'">'.get_the_title($item_id).'</a>');
			break;
			case 'class_submission_revoked_instructor':
				return sprintf(esc_html__('%1$s %2$s %3$s submission have been revoked.','dtlms'), '<a href="'.get_author_posts_url($secondary_item_id).'">'.get_the_author_meta('display_name', $secondary_item_id).'</a>', $class_singular_label,'<a href="'.get_permalink($item_id).'">'.get_the_title($item_id).'</a>');
			break;
		}

		return apply_filters( 'bp_course_format_notifications',false, $action, $item_id, $secondary_item_id, $total_items );

	}
	add_filter( 'bp_course_format_notifications', 'dtlms_format_buddypress_notifications_class_module', 20, 5 );
}


?>