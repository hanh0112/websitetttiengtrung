<?php

if(!function_exists('dtlms_classes_listing')) {
	function dtlms_classes_listing($attrs, $content = null) {

		$attrs = shortcode_atts ( array (

						'disable-all-filters' => 'true',

						'enable-search-filter' => '',
						'enable-display-filter' => '',
						'enable-classtype-filter' => '',
						'enable-orderby-filter' => '',
						'enable-instructor-filter' => '',
						'enable-cost-filter' => '',
						'enable-date-filter' => '',

						'listing-output-page' => '',

						'default-filter' => '',
						'default-display-type' => 'grid',
						'class-item-ids' => '',
						'instructor-ids' => '',

						'apply-isotope' => '',

						'post-per-page' => 6,
						'columns' => 3,

						'enable-fullwidth' => 'true',
						'show-pagination' => 'true',
						'type' => 'type1',

						'class' => '',
						'excerpt_length'=>'',

						'enable-carousel' => '',
						'carousel-effect' => '',
						'carousel-autoplay' => 0,
						'carousel-slidesperview' => 2,
						'carousel-loopmode' => '',
						'carousel-mousewheelcontrol' => '',
						'carousel-bulletpagination' => 'true',
						'carousel-arrowpagination' => '',
						'carousel-spacebetween' => 0,
						'module_id' => '',

				), $attrs, 'dtlms_classes_listing' );

		$out = dtlms_classes_listing_content($attrs);

		return $out;

	}
	add_shortcode ( 'dtlms_classes_listing', 'dtlms_classes_listing' );
}

if(!function_exists('dtlms_class_details')) {
	function dtlms_class_details( $attrs, $content = null ) {

		$attrs = shortcode_atts ( array (

					'enable-instructor-filter' => 'false',

				), $attrs, 'dtlms_class_details' );


		$output = '';

		$current_user = wp_get_current_user();
		$user_id = $current_user->ID;

		if ( in_array( 'instructor', (array) $current_user->roles ) || in_array( 'administrator', (array) $current_user->roles ) ) {

			$output .= '<div class="dtlms-statistics-container">';

				if ( in_array( 'administrator', (array) $current_user->roles ) && $attrs['enable-instructor-filter'] == 'true' ) {

					$instructor_label = apply_filters( 'instructor_label', 'singular' );
				    $output .= '<select class="dtlms-statistics-classes-instructor" name="dtlms-statistics-classes-instructor" data-placeholder="'.sprintf( esc_html__('Choose %1$s ...', 'dtlms'), $instructor_label ).'" class="dtlms-chosen-select">';

						$output .= '<option value="-1">'.esc_html__('All', 'dtlms').'</option>';

						$instructors = get_users ( array ('role' => 'instructor') );
				        if ( count( $instructors ) > 0 ) {
				            foreach ($instructors as $instructor) {
								$instructor_id = $instructor->data->ID;
				                $output .= '<option value="' . esc_attr( $instructor_id ) . '">' . esc_html( $instructor->data->display_name ) . '</option>';
				            }
				        }

				    $output .= '</select>';

					$output .= '<div class="dtlms-hr-invisible"></div>';

					$output .= dtlms_generate_loader_html(true);

				    $output .= '<div class="dtlms-instructor-classes-container"></div>';

				} else {

					$instructor_label = apply_filters( 'instructor_label', 'singular' );
				    $output .= '<select class="dtlms-statistics-classes-instructor" name="dtlms-statistics-classes-instructor" data-placeholder="'.sprintf( esc_html__('Choose %1$s ...', 'dtlms'), $instructor_label ).'" class="dtlms-chosen-select" style="display:none;">';
						$output .= '<option value="'.$user_id.'">'.esc_html__('All', 'dtlms').'</option>';
				    $output .= '</select>';

					$output .= '<div class="dtlms-instructor-classes-container"></div>';

				}

			$output .= '</div>';

		} else {

			$output .= esc_html__('You are not authorized to view these datas.', 'dtlms');

		}

		return $output;

	}
	add_shortcode ( 'dtlms_class_details', 'dtlms_class_details' );
}

if(!function_exists('dtlms_student_class_curriculum_details')) {
	function dtlms_student_class_curriculum_details( $attrs, $content = null ) {

		$output = '';

		$current_user = wp_get_current_user();
		$user_id = $current_user->ID;

		if ( in_array( 'student', (array) $current_user->roles ) ) {

			$started_classes = get_user_meta($user_id, 'started_classes', true);
			$started_classes = (is_array($started_classes) && !empty($started_classes)) ? $started_classes : array ();

			$submitted_classes = get_user_meta($user_id, 'submitted_classes', true);
			$submitted_classes = (is_array($submitted_classes) && !empty($submitted_classes)) ? $submitted_classes : array ();

			$completed_classes = get_user_meta($user_id, 'completed_classes', true);
			$completed_classes = (is_array($completed_classes) && !empty($completed_classes)) ? $completed_classes : array ();

			$classes_undergoing = array_diff($started_classes, $submitted_classes);
			$classes_underevaluation = array_diff($submitted_classes, $completed_classes);

			$classes_list = array_merge($completed_classes, $classes_underevaluation, $classes_undergoing);
			$classes_list = array_filter($classes_list);

			$class_singular_label = apply_filters( 'class_label', 'singular' );

			$output .= '<div class="dtlms-custom-table-wrapper">';

				$output .= '<table border="0" cellpadding="0" cellspacing="0" class="dtlms-custom-table">
				              <tr>
				                <th scope="col">'.esc_html__('#', 'dtlms').'</th>
				                <th scope="col">'.sprintf( esc_html__( '%1$s', 'dtlms' ), $class_singular_label ).'</th>
				                <th scope="col">'.esc_html__('Option', 'dtlms').'</th>
				              </tr>';

					if(!empty($classes_list)) {

						$i = 1;
						foreach ($classes_list as $class_id) {

							$output .= '<tr>
											<td>'.$i.'</td>
											<td><a href="'.get_permalink($class_id).'">'.get_the_title($class_id).'</a></td>
											<td><a href="#" class="dtlms-button dtlms-view-class-result dtlms-dashboard filled small"  data-classid="'.$class_id.'" data-userid="'.$user_id.'">'.esc_html__('View Results', 'dtlms').'</a></td>
										</tr>';

							$i++;

						}

					} else {

						$output .= '<tr><td colspan="3">'.esc_html__('No records found!', 'dtlms').'</td></tr>';

					}

				$output .= '</table>';

			$output .= '</div>';

		} else if(in_array( 'administrator', (array) $current_user->roles )) {

			$output .= esc_html__('No records found.', 'dtlms');

		} else {

			$output .= esc_html__('You are not authorized to view these datas.', 'dtlms');

		}

		return $output;

	}
	add_shortcode ( 'dtlms_student_class_curriculum_details', 'dtlms_student_class_curriculum_details' );
}
?>