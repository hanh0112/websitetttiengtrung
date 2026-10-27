<?php

if(!function_exists('dtlms_class_on_order_status_completion')) {
	function dtlms_class_on_order_status_completion($order_id) {

		$order = new WC_Order( $order_id );
		$user_id = get_post_meta($order_id, '_customer_user', true);

		$items = $order->get_items();
		foreach ( $items as $item_id => $item ) {

			$dtlms_item_id = wc_get_order_item_meta($item_id, 'dtlms_item_id');
			$post_type = get_post_type($dtlms_item_id);

			if(in_array($post_type, array('dtlms_classes'))) {

				$class_id = $dtlms_item_id;
				$class_data = get_post($class_id);
				$author_id = $class_data->post_author;

				$purchased_users = get_post_meta($class_id, 'purchased_users', true);
				$purchased_users = (is_array($purchased_users) && !empty($purchased_users)) ? $purchased_users : array();
				array_push($purchased_users, $user_id);
				update_post_meta($class_id, 'purchased_users', $purchased_users);

				$purchased_classes = get_user_meta($user_id, 'purchased_classes', true);
				$purchased_classes = (is_array($purchased_classes) && !empty($purchased_classes)) ? $purchased_classes : array();
				array_push($purchased_classes, $class_id);
				update_user_meta($user_id, 'purchased_classes', $purchased_classes);


				$current_timestamp = strtotime(current_time(get_option('date_format')));

				$purchased_users_timestamp = get_post_meta($class_id, 'purchased_users_timestamp', true);
				$purchased_users_timestamp = (is_array($purchased_users_timestamp) && !empty($purchased_users_timestamp)) ? $purchased_users_timestamp : array();
				$purchased_users_timestamp[$current_timestamp][] = $user_id;
				update_post_meta($class_id, 'purchased_users_timestamp', $purchased_users_timestamp);

				$purchased_classes_timestamp = get_user_meta($user_id, 'purchased_classes_timestamp', true);
				$purchased_classes_timestamp = (is_array($purchased_classes_timestamp) && !empty($purchased_classes_timestamp)) ? $purchased_classes_timestamp : array();
				$purchased_classes_timestamp[$current_timestamp][] = $class_id;
				update_user_meta($user_id, 'purchased_classes_timestamp', $purchased_classes_timestamp);


				// Start class for user
				dtlms_start_class_initialize($class_id, $user_id, $author_id, false);


				if($author_id > 0) {

					$classes_subscribed = get_user_meta($author_id, 'classes-subscribed', true);
					$classes_subscribed = (is_array($classes_subscribed) && !empty($classes_subscribed)) ? $classes_subscribed : array ();
					$classes_subscribed_timestamp = array_keys($classes_subscribed);

					$classes_subscribed[$current_timestamp][$class_id]['users'][] = $user_id;
					$classes_subscribed[$current_timestamp][$class_id]['status'] = 'unpaid';

					update_user_meta($author_id, 'classes-subscribed', $classes_subscribed);

				}

				// Notification & Mail
				do_action('dtlms_poc_class_subscribed', $class_id, $user_id);

			}

		}

		// Change the customer role to student
	    if ( $user_id > 0 ) {
	    	$user = new WP_User( $user_id );
	        $user->remove_role( 'customer' );
	        $user->remove_role( 'subscriber' );
	        $user->add_role( 'student' );
	    }

	}
	add_action('woocommerce_order_status_completed','dtlms_class_on_order_status_completion');
}

if(!function_exists('dtlms_on_order_status_cancellation')) {
	function dtlms_on_order_status_cancellation($order_id) {

		$order = new WC_Order( $order_id );
		$order_data = $order->get_data();

		$user_id = get_post_meta($order_id, '_customer_user', true);

		$items = $order->get_items();
		foreach ( $items as $item_id => $item ) {

			$dtlms_item_id = wc_get_order_item_meta($item_id, 'dtlms_item_id');
			$post_type = get_post_type($dtlms_item_id);

			if(in_array($post_type, array('dtlms_classes'))) {

				$class_id = $dtlms_item_id;
				$class_data = get_post($class_id);
				$author_id = $class_data->post_author;

				$purchased_users = get_post_meta($class_id, 'purchased_users', true);
				$purchased_users = (is_array($purchased_users) && !empty($purchased_users)) ? $purchased_users : array();
				if(in_array($user_id, $purchased_users)) {
				    unset($purchased_users[array_search($user_id, $purchased_users)]);
				}
				update_post_meta($class_id, 'purchased_users', $purchased_users);

				$purchased_classes = get_user_meta($user_id, 'purchased_classes', true);
				$purchased_classes = (is_array($purchased_classes) && !empty($purchased_classes)) ? $purchased_classes : array();
				if(in_array($class_id, $purchased_classes)) {
				    unset($purchased_classes[array_search($class_id, $purchased_classes)]);
				}
				update_user_meta($user_id, 'purchased_classes', $purchased_classes);


				$purchased_users_timestamp = get_post_meta($class_id, 'purchased_users_timestamp', true);
				$purchased_users_timestamp = (is_array($purchased_users_timestamp) && !empty($purchased_users_timestamp)) ? $purchased_users_timestamp : array();
				foreach($purchased_users_timestamp as $purchased_users_timestamp_key => $purchased_users_timestamp_data) {
					if(in_array($user_id, $purchased_users_timestamp_data)) {
					    unset($purchased_users_timestamp[$purchased_users_timestamp_key][array_search($user_id, $purchased_users_timestamp_data)]);
					}
				}
				update_post_meta($class_id, 'purchased_users_timestamp', $purchased_users_timestamp);

				$purchased_classes_timestamp = get_user_meta($user_id, 'purchased_classes_timestamp', true);
				$purchased_classes_timestamp = (is_array($purchased_classes_timestamp) && !empty($purchased_classes_timestamp)) ? $purchased_classes_timestamp : array();
				foreach($purchased_classes_timestamp as $purchased_classes_timestamp_key => $purchased_classes_timestamp_data) {
					if(in_array($class_id, $purchased_classes_timestamp_data)) {
					    unset($purchased_classes_timestamp[$purchased_classes_timestamp_key][array_search($class_id, $purchased_classes_timestamp_data)]);
					}
				}
				update_user_meta($user_id, 'purchased_classes_timestamp', $purchased_classes_timestamp);

				if($author_id > 0) {

					$classes_subscribed = get_user_meta($author_id, 'classes-subscribed', true);
					$classes_subscribed = (is_array($classes_subscribed) && !empty($classes_subscribed)) ? $classes_subscribed : array ();

					$order_timestamp_completed = $order_data['date_completed']->date(get_option('date_format'));
					$order_timestamp_completed = strtotime($order_timestamp_completed);

					foreach($classes_subscribed[$order_timestamp_completed][$class_id]['users'] as $order_user_key => $order_user) {
						if($order_user == $user_id) {
							unset($classes_subscribed[$order_timestamp_completed][$class_id]['users'][$order_user_key]);
						}
					}

					update_user_meta($author_id, 'classes-subscribed', $classes_subscribed);

				}

				// Notification & Mail
				do_action('dtlms_poc_class_subscription_cancellation', $class_id, $user_id);

			}

		}

	}
	add_action('woocommerce_order_status_cancelled','dtlms_on_order_status_cancellation');
	add_action('woocommerce_order_status_refunded','dtlms_on_order_status_cancellation');
}

?>