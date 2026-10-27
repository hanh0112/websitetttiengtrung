<?php

if(!function_exists('dtlms_certificate_details')) {
	function dtlms_certificate_details($attrs, $content = null) {

		extract ( shortcode_atts ( array (
				'item_type' => 'student_name',
		), $attrs ) );

		$out = '';

		$user_id = isset($_REQUEST['user_id']) ? dtlms_recursive_sanitize_text_field($_REQUEST['user_id']) : get_current_user_id();
		$item_id = isset($_REQUEST['item_id']) ? dtlms_recursive_sanitize_text_field($_REQUEST['item_id']) : -1;
		$grade_id = isset($_REQUEST['grade_id']) ? dtlms_recursive_sanitize_text_field($_REQUEST['grade_id']) : -1;

		if($item_type == 'student_name') {

			$user_info = get_userdata($user_id);
			$out .=  isset($user_info->display_name) ? '<div class="dtlms-certificate-studentname">'.$user_info->display_name.'</div>' : '';

		} else if($item_type == 'item_name') {

			$out .= '<div class="dtlms-certificate-itemname">'.get_the_title($item_id).'</div>';

		} else if($item_type == 'student_percent') {

			$user_percentage = get_post_meta($grade_id, 'user-percentage', true);
			if($user_percentage != '') {
				$out .=  '<div class="dtlms-certificate-userpercentage">'.$user_percentage.esc_html__('%', 'dtlms').'</div>';
			}

		} else if($item_type == 'date') {

			$date_on_certificate = get_post_meta($grade_id, 'date-on-certificate', true);
			if($date_on_certificate != '') {
				$out .=  '<div class="dtlms-certificate-date">'.$date_on_certificate.'</div>';
			} else {
				$out .=  '<div class="dtlms-certificate-date">'.get_the_date(get_option('date_format'), $grade_id).'</div>';
			}

		}

		return $out;

	}
    add_shortcode ( 'dtlms_certificate_details', 'dtlms_certificate_details' );
}


if(!function_exists('dtlms_certificate')) {
    function dtlms_certificate($attrs, $content = null) {

        extract ( shortcode_atts ( array (
                'type' => 'type1',
                'logo1' => '',
                'logo2' => '',
                'heading' => '',
                'subheading' => '',
                'footer_logo' => '',
                'signature' => '',
        ), $attrs ) );


        $logo1_attachment = wp_get_attachment_image_src($logo1, 'full');
        $logo2_attachment = wp_get_attachment_image_src($logo2, 'full');
        $footer_logo_attachment = wp_get_attachment_image_src($footer_logo, 'full');
        $signature_attachment = wp_get_attachment_image_src($signature, 'full');


        $output = '';

        $student_name = do_shortcode('[dtlms_certificate_details item_type="student_name" /]');
        $item_name = do_shortcode('[dtlms_certificate_details item_type="item_name" /]');
        $student_percent = do_shortcode('[dtlms_certificate_details item_type="student_percent" /]');
        $date = do_shortcode('[dtlms_certificate_details item_type="date" /]');

        if($type == 'type1') {

            $output .= '<div class="dtlms-certificate-body">';
                $output .= '<div class="dtlms-certificate-container type1">';
                    $output .= '<div class="dtlms-certificate-wrapper">';
                        $output .= '<div class="dtlms-certificate-inner-wrapper">';
                            $output .= '<div class="dtlms-certificate-header">';
                                $output .= '<h2>'.esc_html($heading).'</h2>';
                                $output .= '<h3>'.esc_html($subheading).'</h3>';
                            $output .= '</div>';
                            $output .= '<div class="dtlms-certificate-content-holder">';
                                $output .= sprintf( esc_html__( '%1$s Who Has Successfully Completed %2$s with %3$s', 'dtlms' ), $student_name, $item_name, $student_percent );
                                $output .= '<div class="dtlms-certificate-content">'.do_shortcode($content).'</div>';
                            $output .= '</div>';
                            $output .= '<div class="dtlms-certificate-footer">';
                                $output .= '<div class="dtlms-certificate-date">';
                                    $output .= '<span>'.esc_html__('Date', 'dtlms').'</span>';
                                    $output .= $date;
                                $output .= '</div>';
                                if(isset($footer_logo_attachment[0]) && $footer_logo_attachment[0] != '') {
                                    $output .= '<div class="dtlms-certificate-footer-logo">';
                                        $output .= '<img src="'.esc_url($footer_logo_attachment[0]).'" alt="'.esc_html__('Footer Logo', 'dtlms').'" title="'.esc_html__('Footer Logo', 'dtlms').'">';
                                    $output .= '</div>';
                                }
                                if(isset($signature_attachment[0]) && $signature_attachment[0] != '') {
                                    $output .= '<div class="dtlms-certificate-sign">';
                                        $output .= '<span>'.esc_html__('Signature', 'dtlms').'</span>';
                                        $output .= '<img src="'.esc_url($signature_attachment[0]).'" alt="'.esc_html__('Signature', 'dtlms').'" title="'.esc_html__('Signature', 'dtlms').'">';
                                    $output .= '</div>';
                                }
                            $output .= '</div>';
                        $output .= '</div>';
                    $output .= '</div>';
                $output .= '</div>';
            $output .= '</div>';

        } else if($type == 'type2') {

            $output .= '<div class="dtlms-certificate-container type2">';
                $output .= '<div class="dtlms-certificate-wrapper">';
                    $output .= '<div class="dtlms-certificate-inner-wrapper">';
                        $output .= '<div class="dtlms-certificate-header">';
                            if(isset($logo1_attachment[0]) && $logo1_attachment[0] != '') {
                                $output .= '<img src="'.esc_url($logo1_attachment[0]).'" alt="'.esc_html__('Logo 1', 'dtlms').'" title="'.esc_html__('Logo 1', 'dtlms').'">';
                            }
                            if(isset($logo2_attachment[0]) && $logo2_attachment[0] != '') {
                                $output .= '<img src="'.esc_url($logo2_attachment[0]).'" alt="'.esc_html__('Logo 2', 'dtlms').'" title="'.esc_html__('Logo 2', 'dtlms').'">';
                            }
                            $output .= '<h2>'.esc_html($heading).'</h2>';
                            $output .= '<h3>'.esc_html($subheading).'</h3>';
                        $output .= '</div>';
                        $output .= '<div class="dtlms-certificate-content-holder">';
                            $output .= sprintf( esc_html__( '%1$s Who Has Successfully Completed %2$s with %3$s', 'dtlms' ), $student_name, $item_name, $student_percent );
                            $output .= '<div class="dtlms-certificate-content">'.do_shortcode($content).'</div>';
                        $output .= '</div>';
                        $output .= '<div class="dtlms-certificate-footer">';
                            $output .= '<div class="dtlms-certificate-date">';
                                $output .= $date;
                                $output .= '<span>'.esc_html__('Date', 'dtlms').'</span>';
                            $output .= '</div>';
                            if(isset($footer_logo_attachment[0]) && $footer_logo_attachment[0] != '') {
                                $output .= '<div class="dtlms-certificate-footer-logo">';
                                    $output .= '<img src="'.esc_url($footer_logo_attachment[0]).'" alt="'.esc_html__('Footer Logo', 'dtlms').'" title="'.esc_html__('Footer Logo', 'dtlms').'">';
                                $output .= '</div>';
                            }
                            if(isset($signature_attachment[0]) && $signature_attachment[0] != '') {
                                $output .= '<div class="dtlms-certificate-sign">';
                                    $output .= '<img src="'.esc_url($signature_attachment[0]).'" alt="'.esc_html__('Signature', 'dtlms').'" title="'.esc_html__('Signature', 'dtlms').'">';
                                    $output .= '<span>'.esc_html__('Signature', 'dtlms').'</span>';
                                $output .= '</div>';
                            }
                        $output .= '</div>';
                    $output .= '</div>';
                $output .= '</div>';
            $output .= '</div>';

        } else if($type == 'type3') {

            $output .= '<div class="dtlms-certificate-container type3">';
                $output .= '<div class="dtlms-certificate-wrapper">';
                    $output .= '<div class="dtlms-certificate-inner-wrapper">';
                        $output .= '<div class="dtlms-certificate-header">';
                            if(isset($logo1_attachment[0]) && $logo1_attachment[0] != '') {
                                $output .= '<img src="'.esc_url($logo1_attachment[0]).'" alt="'.esc_html__('Logo 1', 'dtlms').'" title="'.esc_html__('Logo 1', 'dtlms').'">';
                            }
                            $output .= '<h2>'.esc_html($heading).'</h2>';
                            $output .= '<h3>'.esc_html($subheading).'</h3>';
                            if(isset($logo2_attachment[0]) && $logo2_attachment[0] != '') {
                                $output .= '<img src="'.esc_url($logo2_attachment[0]).'" alt="'.esc_html__('Logo 2', 'dtlms').'" title="'.esc_html__('Logo 2', 'dtlms').'">';
                            }
                        $output .= '</div>';
                        $output .= '<div class="dtlms-certificate-content-holder">';
                            $output .= sprintf( esc_html__( '%1$s Who Has Successfully Completed %2$s with %3$s', 'dtlms' ), $student_name, $item_name, $student_percent );
                            $output .= '<div class="dtlms-certificate-content">'.do_shortcode($content).'</div>';
                        $output .= '</div>';
                        $output .= '<div class="dtlms-certificate-footer">';
                            $output .= '<div class="dtlms-certificate-date">';
                                $output .= $date;
                                $output .= '<span>'.esc_html__('Date', 'dtlms').'</span>';
                            $output .= '</div>';
                            if(isset($signature_attachment[0]) && $signature_attachment[0] != '') {
                                $output .= '<div class="dtlms-certificate-sign">';
                                    $output .= '<img src="'.esc_url($signature_attachment[0]).'" alt="'.esc_html__('Signature', 'dtlms').'" title="'.esc_html__('Signature', 'dtlms').'">';
                                    $output .= '<span>'.esc_html__('Signature', 'dtlms').'</span>';
                                $output .= '</div>';
                            }
                        $output .= '</div>';
                    $output .= '</div>';
                $output .= '</div>';
            $output .= '</div>';

        }

        return $output;

    }
    add_shortcode ( 'dtlms_certificate', 'dtlms_certificate' );
}

if(!function_exists('dtlms_student_certificates')) {
	function dtlms_student_certificates( $attrs, $content = null ) {

		$attrs = shortcode_atts ( array (

					'item-type' => '',
					'include-registration-class' => '',

				), $attrs, 'dtlms_student_certificates' );

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


			// Create completed courses array with grade id
			$certificate_achieved_items = array ();
			if(!empty($completed_items)) {
				foreach($completed_items as $completed_item) {
					$curriculum_details = get_user_meta($user_id, $completed_item, true);
					$completed_item_grade_id = $curriculum_details['grade-post-id'];

					$certificate_achieved = get_post_meta($completed_item_grade_id, 'certificate-achieved', true);
					if($certificate_achieved == 'true') {
						$certificate_achieved_items[$completed_item] = $completed_item_grade_id;
					}
				}
			}

			if(is_array($registered_classes) && !empty($registered_classes)) {
				foreach($registered_classes as $class_id) {
					$registered_users = get_post_meta($class_id, 'registered_users', true);
					$registered_users = (is_array($registered_users) && !empty($registered_users)) ? $registered_users : array ();

					if(isset($registered_users[$user_id]['certificate']) && $registered_users[$user_id]['certificate'] == 'approved') {
						$certificate_achieved_items[$class_id] = -1;
					}
				}
			}

			$output .= '<div class="dtlms-student-certificate-holder">';

				if(!empty($certificate_achieved_items)) {

					$output .= '<table border="0" cellpadding="0" cellspacing="0" class="dtlms-custom-table">
					              <tr>
					                <th scope="col">'.esc_html__('#', 'dtlms').'</th>
					                <th scope="col">'.esc_html__('Item Name', 'dtlms').'</th>
					                <th scope="col">'.esc_html__('Percentage', 'dtlms').'</th>
					                <th scope="col">'.esc_html__('Certificate', 'dtlms').'</th>
					                <th scope="col">'.esc_html__('Options', 'dtlms').'</th>
					              </tr>';

								$i = 1;
								foreach($certificate_achieved_items as $certificate_achieved_item => $item_grade_id) {

									$user_percentage = '';
									if($item_grade_id > 0) {
										$user_percentage = get_post_meta($item_grade_id, 'user-percentage', true);
										if($user_percentage != '') {
											$user_percentage = $user_percentage.'%';
										}
									}

									$certificate_template = get_post_meta($certificate_achieved_item, 'certificate-template', true);

									$output .= '<tr>
												<td>'.$i.'</td>
												<td><a href="'.get_permalink($certificate_achieved_item).'">'.get_the_title($certificate_achieved_item).'</a></td>
												<td>'.$user_percentage.'</td>';

												if($certificate_template != '') {
													$output .= '<td>'.get_the_title($certificate_template).'</td>
																<td>
																	<a href="#" class="dtlms-generate-certificate-content" data-certificateid="'.$certificate_template.'"  data-itemid="'.$certificate_achieved_item.'" data-gradeid="'.$item_grade_id.'" data-userid="'.$user_id.'" onclick="return false;">'.esc_html__('Download', 'dtlms').'</a>
																</td>';
												} else {
													$output .= '<td></td>
																<td></td>';
												}

									$output .= '</tr>';

									$i++;

								}

				    $output .= '</table>';

				} else {
					$output .= '<p class="dtlms-note">'.esc_html__('No certificates found!', 'dtlms').'</p>';
				}

				$output .= dtlms_generate_loader_html(false);

			$output .= '</div>';

		} else if(in_array( 'administrator', (array) $current_user->roles )) {

			$output .= esc_html__('No records found.', 'dtlms');

		} else {

			$output .= esc_html__('You are not authorized to view these datas.', 'dtlms');

		}

		return $output;

	}
    add_shortcode ( 'dtlms_student_certificates', 'dtlms_student_certificates' );
}

?>