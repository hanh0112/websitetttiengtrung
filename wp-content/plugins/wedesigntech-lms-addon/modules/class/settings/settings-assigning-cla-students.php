<?php

if(!function_exists('dtlms_get_classes_assign_students_content')) {

	function dtlms_get_classes_assign_students_content() {

		$class_title_singular = apply_filters( 'class_label', 'singular' );
		$class_title_plural = apply_filters( 'class_label', 'plural' );

		$output = '';

		$output .= '<div class="dtlms-settings-assign-students-container">';

			$output .= '<div class="dtlms-column dtlms-one-fifth first">';

				$output .= '<label>'.sprintf( esc_html__( 'Choose %1$s', 'dtlms' ), $class_title_singular ).'</label>';

			$output .= '</div>';


			$output .= '<div class="dtlms-column dtlms-four-fifth">';

			    $output .= '<select class="dtlms-assigning-classes-students" name="dtlms-assigning-classes-students" data-placeholder="'.sprintf( esc_html__( 'Choose %1$s...', 'dtlms' ), $class_title_singular ).'" class="dtlms-chosen-select">';

					$output .= '<option value="">'.esc_html__('None', 'dtlms').'</option>';

					$args = array (
					    'post_type'         =>  'dtlms_classes',
					    'posts_per_page' 	=> -1
				    );
					$args['meta_query'][] = array (
												'key'     => '_regular_price',
												'value'   => 0,
												'type'    => 'numeric',
												'compare' => '>'
											);

				    $classes = get_posts($args);

				    if(isset($classes) && !empty($classes)) {
				    	foreach( $classes as $class ) {

				    		$class_id = $class->ID;
				    		$output .= '<option value="' . esc_attr( $class_id ) . '"' . selected( $class_id, '', false ) . '>' . get_the_title($class_id) . '</option>';

				    	}
				    }

			    $output .= '</select>';

			$output .= '</div>';

			$output .= dtlms_generate_loader_html(false);

			$output .= '<div class="dtlms-assign-studentstoclass-container"></div>';


		$output .= '</div>';

		return $output;

	}

	echo dtlms_get_classes_assign_students_content();

}

?>