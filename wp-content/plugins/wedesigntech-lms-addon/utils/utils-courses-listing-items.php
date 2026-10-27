<?php

function dtlms_course_listing_thumb($course_id, $course_title, $course_permalink, $display_type, $column, $type, $class) {

	$output = '';

	if(has_post_thumbnail($course_id)) {

		$classes = explode(' ', $class);
		$classes = array_map('trim', $classes);

		$image_size = 'full';
		if($type == 'type10') {

			if($column == 3 || in_array('dtlms-three', $classes)) {
				$image_size = 'full';
			} else if($column == 2 || in_array('dtlms-two', $classes)) {
				$image_size = 'dtlms-960x735';
			}

		} else if($type == 'type9') {

			if($column == 3 || in_array('dtlms-three', $classes)) {
				$image_size = 'full';
			} else if($column == 2 || in_array('dtlms-two', $classes)) {
				$image_size = 'dtlms-960x581';
			}

		} else if($type == 'type1') {

			if($column == 3 || in_array('dtlms-three', $classes)) {
				$image_size = 'full';
			} else if($column == 2 || in_array('dtlms-two', $classes)) {
				$image_size = 'full';
			}

		} else {

			if($column == 3 || in_array('dtlms-three', $classes)) {
				$image_size = 'full';
			} else if($column == 2 || in_array('dtlms-two', $classes)) {
				$image_size = 'dtlms-960x640';
			}

		}


		if($display_type == 'list-item') {

			if($type == 'type1'){
				$output .= '<div class="dtlms-course-list-overlay">';
					$output .= '<a href="'.esc_url($course_permalink).'" title="'.esc_attr($course_title).'">'.esc_html__('View Course','dtlms').'</a>';
					$output .= get_the_post_thumbnail($course_id, $image_size);
				$output .= '</div>';
			} else {
				$image_src = wp_get_attachment_image_src(get_post_thumbnail_id($course_id), $image_size, false);
				$output .= '<a href="'.esc_url($course_permalink).'" title="'.esc_attr($course_title).'">
								<div class="dtlms-courselist-thumb-inner" style="background:url('.esc_url($image_src[0]).');"></div>
							</a>';
			}

		} else {

			if($type == 'type1'){
				//$output .= '<a href="'.esc_url($course_permalink).'" title="'.esc_attr($course_title).'">'.esc_html__('Add To Cart ','dtlms').'</a>';
				$output .= get_the_post_thumbnail($course_id, $image_size);
			} else {
				$output .= '<a href="'.esc_url($course_permalink).'" title="'.esc_attr($course_title).'">'.get_the_post_thumbnail($course_id, $image_size).'</a>';
			}
			

		}

	} else {

		if($display_type == 'list-item') {

			$output .= '<a href="'.esc_url($course_permalink).'" title="'.esc_attr($course_title).'">
							<div class="dtlms-courselist-thumb-inner" style="background:url('.esc_url(DTLMS_PLUGIN_URL.'assets/images/no-image-1920x800.jpg').');"></div>
						</a>';

		} else {

			$output .= '<a href="'.esc_url($course_permalink).'" title="'.esc_attr($course_title).'"><img src="'.esc_url(DTLMS_PLUGIN_URL.'assets/images/no-image-1920x800.jpg').'" alt="'.esc_attr($course_title).'" title="'.esc_attr($course_title).'" /></a>';

		}

	}

	return $output;

}

function dtlms_course_listing_certificatenbadge($course_id) {

	$dtlms_modules = dtlms_instance()->active_modules;
	$dtlms_modules = (is_array($dtlms_modules) && !empty($dtlms_modules)) ? $dtlms_modules : array ();

	$output = '';

	$enable_certificate = get_post_meta($course_id, 'enable-certificate', true);
	$enable_badge = get_post_meta($course_id, 'enable-badge', true);

	if((in_array('certificate', $dtlms_modules) && $enable_certificate) || (in_array('badge', $dtlms_modules) && $enable_badge)) {

		$output .= '<div class="dtlms-certificate-badge">';
			if(in_array('badge', $dtlms_modules) && $enable_badge) {
				$output .= '<span class="dtlms-badge"></span>';
			}
			if(in_array('certificate', $dtlms_modules) && $enable_certificate) {
				$output .= '<span class="dtlms-certificate"></span>';
			}
		$output .= '</div>';

	}

	return $output;

}

function dtlms_course_listing_featured($course_id) {

    $output = '';

	$featured_course = get_post_meta($course_id, 'featured-course', true);

	if(isset($featured_course) && $featured_course == 'true') {
		$output .= '<div class="dtlms-course-listing-featured">';
			$output .= '<span class="dtlms-course-listing-featured-text">'.esc_html__('Featured','dtlms').'</span>';
		$output .= '</div>';
	}

	return $output;

}

function dtlms_course_listing_title($course_id, $course_title, $course_permalink) {

	$output = '<h5><a href="'.esc_url($course_permalink).'">'.esc_attr($course_title).'</a></h5>';

	return $output;

}

function dtlms_course_listing_description($course_id,$excerpt_length='') {

	$output = '<div class="dtlms-courselist-description">
                    '.wp_trim_words(get_the_excerpt($course_id), $excerpt_length).'
                </div>';

	return $output;

}

function dtlms_course_listing_rating($course_id, $type = '') {

	$output = '';

	$average_rating = get_post_meta($course_id, 'average-ratings', true);
	$average_rating = (isset($average_rating) && !empty($average_rating)) ? round($average_rating, 1) : 0;

	$comments = get_approved_comments($course_id);
	$total_comments = count($comments);

	if($type == 'type5') {

	    $output .= '<div class="dtlms-courselist-ratings-container">';
			$output .= '<p class="dtlms-courselist-ratings">'.dtlms_comment_rating_display($average_rating).'</p>';
		$output .= '</div>';

	} else if($type == 'type4') {

	    $output .= '<div class="dtlms-courselist-ratings-container">';
			$output .= '<p class="dtlms-courselist-ratings">'.dtlms_comment_rating_display($average_rating).'</p>';
			//$output .= '<p class="dtlms-courselist-total-reviews">'.sprintf(esc_html__('%1$s Reviews', 'dtlms'), $total_comments).'</p>';
			$output .= '<p class="dtlms-courselist-total-reviews">'.sprintf( _n( '%d Review', '%d Reviews', $total_comments, 'dtlms' ), number_format_i18n($total_comments) ).'</p>';
		$output .= '</div>';

	} else if($type == 'type3') {

	    $output .= '<div class="dtlms-courselist-ratings-container">';
			$output .= '<p class="dtlms-courselist-ratings">'.dtlms_comment_rating_display($average_rating).'</p>';
			$output .= '<p class="dtlms-courselist-overall-ratings">';
				$output .= '(' .esc_attr($average_rating). ')';
				//$output .= '<span class="dtlms-courselist-total-reviews">'.sprintf(esc_html__('%1$s Reviews', 'dtlms'), $total_comments).'</span>';
				$output .= '<span class="dtlms-courselist-total-reviews">'.sprintf( _n( '%d Review', '%d Reviews', $total_comments, 'dtlms' ), number_format_i18n($total_comments) ).'</span>';
			$output .= '</p>';
		$output .= '</div>';

	} else if($type == 'type2') {

	    $output .= '<div class="dtlms-courselist-ratings-container">';
			$output .= '<p class="dtlms-courselist-ratings">'.dtlms_comment_rating_display($average_rating).'</p>';
			$output .= '<p class="dtlms-courselist-overall-ratings">';
				$output .= esc_attr($average_rating);
			$output .= '</p>';
		$output .= '</div>';

	} else {

		$output .= '<div class="dtlms-courselist-ratings-container">
            			<p class="dtlms-courselist-overall-ratings">
            				<span class="icon-moon icon-moon-star-full"></span>
            				'.sprintf(esc_html__('%1$s Stars', 'dtlms'), $average_rating).'
            			</p>
            		</div>';

	}

	return $output;

}

function dtlms_course_listing_duration($course_id, $design_type = '', $style = '') {

	$duration = dtlms_get_course_duration($course_id, $style, 'course');

	if($design_type == 'type2') {

		if($duration != '') {

			$output = '<div class="dtlms-courselist-duration">
			                <i class="far fa-clock"></i>
			                <span>'.esc_html($duration).'</span>
			            </div>';

		}

    } else {

    	if($duration != '') {

			$output = '<div class="dtlms-courselist-duration">
			<svg width="800px" height="800px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
			<g id="Complete"><g id="Clock"><g>
			<polyline fill="none" points="11.9 5.9 11.9 11.9 12 12 14.1 14.1" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></polyline>
			<circle cx="12" cy="12" data-name="Circle" fill="none" id="Circle-2" r="10" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></circle>
			</g></g></g></svg>
			                <span>'.esc_html($duration).'</span>
			            </div>';

		}

    }

	return $output;

}

function dtlms_course_listing_author($course_id, $type = '') {

	$author_id = get_the_author_meta( 'ID');

	if($type == 'type6') {

		$user_specialization = get_the_author_meta('user-specialization', $author_id);
		$user_specialization = isset($user_specialization) ? $user_specialization : '';

		$output = '<div class="dtlms-courselist-author-image">
						<a href="'.get_author_posts_url($author_id).'" rel="author">'.get_avatar($author_id, 150).'</a>
	                </div>
	                <div class="dtlms-courselist-author-description">
						<p>
							<a href="'.get_author_posts_url($author_id).'" rel="author">
								'.get_the_author().'
							</a>';
							if($user_specialization != '') {
								$output .= '<span>'.esc_html($user_specialization).'</span>';
							}
			$output .= '</p>
	                </div>';

	} else if($type == 'type5') {

		$instructor_singular = apply_filters( 'instructor_label', 'singular' );

		$output = '<h5><a href="'.get_author_posts_url($author_id).'" rel="author">'.get_the_author().'</a><span>'.esc_html($instructor_singular).'</span></h5>';

	} else if($type == 'type2') {

		$user_specialization = get_the_author_meta('user-specialization', $author_id);
		$user_specialization = isset($user_specialization) ? $user_specialization : '';

		$output = '<h5><a href="'.get_author_posts_url($author_id).'" rel="author">'.get_the_author().'</a>';
			if($user_specialization != '') {
				$output .= '<span>'.esc_html($user_specialization).'</span>';
			}
		$output .= '</h5>';

	} else {

		$user_specialization = get_the_author_meta('user-specialization', $author_id);
		$user_specialization = isset($user_specialization) ? $user_specialization : '';

		$output = '<div class="dtlms-courselist-author-image">
						<a href="'.get_author_posts_url($author_id).'" rel="author">'.get_avatar($author_id, 150).'</a>
	                </div>
	                <div class="dtlms-courselist-author-description">
						<h5>
							<a href="'.get_author_posts_url($author_id).'" rel="author">
								'.get_the_author().'
							</a>';
							if($user_specialization != '') {
								$output .= '<span>'.esc_html($user_specialization).'</span>';
							}
			$output .= '</h5>
	                </div>';

    }

	return $output;

}

function dtlms_course_listing_tags($course_id, $with_icon = false, $type = '') {

	$icon_html = '';
	if($with_icon) {
		$icon_html = '<i class="fas fa-tag"></i>';
	}

	if($type == 'type4') {
		$output = get_the_term_list($course_id, 'course_category', '<p class="dtlms-courselist-tags">'.$icon_html, ' ', '</p>');

	} else {
		$output = get_the_term_list($course_id, 'course_category', '<p class="dtlms-courselist-tags">'.$icon_html, ', ', '</p>');
	}

	return $output;

}

function dtlms_course_listing_curriculum_count($course_id) {

	$total_curriculum_count = dtlms_course_curriculum_counts($course_id, true);

	$output = '<p class="dtlms-courselist-curriculum">
					<span class="curriculam-icon"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
	 viewBox="0 0 50 50" style="enable-background:new 0 0 50 50;" xml:space="preserve">
<g>
	<g>
		<path d="M46.3,49H3.7c-1.5,0-2.6-1.2-2.6-2.5V3.6C1.1,2.2,2.2,1,3.7,1h42.7C47.9,1,49,2.2,49,3.6v42.9C48.9,47.8,47.8,49,46.3,49z
			 M3.7,2C2.8,2,2,2.7,2,3.6v42.9C2,47.3,2.8,48,3.7,48h42.7c0.9,0,1.7-0.7,1.7-1.6V3.6c0-0.9-0.8-1.6-1.7-1.6C46.4,2,3.7,2,3.7,2z"
			/>
		<path d="M46.3,49.5H3.7c-1.7,0-3.2-1.4-3.2-3.1V3.6c0-1.7,1.4-3.1,3.2-3.1h42.7c1.7,0,3.2,1.4,3.2,3.1v42.9
			C49.4,48.2,48,49.5,46.3,49.5z M3.7,2.5C3.1,2.5,2.6,3,2.6,3.6v42.9c0,0.6,0.5,1.1,1.2,1.1h42.7c0.6,0,1.2-0.5,1.2-1.1V3.6
			c0-0.6-0.5-1.1-1.2-1.1H3.7z"/>
	</g>
	<g>
		<path d="M16.5,22.5c-0.1,0-0.2,0-0.2-0.1C16.1,22.3,16,22.1,16,22V1.5C16,1.2,16.2,1,16.5,1h17.1C33.8,1,34,1.2,34,1.5v20.4
			c0,0.2-0.1,0.4-0.3,0.4c-0.2,0.1-0.4,0.1-0.5,0L25,16.4l-8.2,5.9C16.7,22.4,16.6,22.5,16.5,22.5z M17,2v19l7.8-5.6
			c0.2-0.1,0.4-0.1,0.6,0L33,21V2H17z"/>
		<path d="M16.5,23c-0.3,0-0.5-0.1-0.6-0.3c-0.2-0.2-0.4-0.5-0.4-0.7V1.5c0-0.6,0.4-1,1-1h17.1c0.6,0,1,0.4,1,1v20.4
			c0,0.5-0.3,0.8-0.7,0.9c-0.4,0.2-0.7,0.1-1-0.1L25,17l-7.9,5.7C17,22.8,16.8,23,16.5,23z M16.4,21.9l0,0.5L16.4,21.9L16.4,21.9
			L16.4,21.9C16.4,21.9,16.4,21.9,16.4,21.9z M16.8,22.3L16.8,22.3C16.8,22.3,16.8,22.3,16.8,22.3z M16.5,22L16.5,22l0.1,0.1
			C16.6,22,16.5,22,16.5,22z M33.7,21.7C33.7,21.7,33.7,21.8,33.7,21.7L33.7,21.7z M25,14.8c0.2,0,0.3,0,0.5,0.1l7,5V2.5H17.5V20
			l6.9-5C24.6,14.9,24.8,14.8,25,14.8z"/>
	</g>
	<g>
		<path d="M16.5,36.8H7.9c-0.3,0-0.5-0.2-0.5-0.5c0-0.3,0.2-0.5,0.5-0.5h8.5c0.3,0,0.5,0.2,0.5,0.5C17,36.6,16.8,36.8,16.5,36.8z"/>
		<path d="M16.5,37.3H7.9c-0.6,0-1-0.4-1-1c0-0.6,0.4-1,1-1h8.5c0.6,0,1,0.4,1,1C17.5,36.8,17,37.3,16.5,37.3z M16.5,36.2l-8.6,0
			L16.5,36.2C16.5,36.2,16.5,36.2,16.5,36.2z"/>
	</g>
	<g>
		<path d="M27.2,42.8H7.9c-0.3,0-0.5-0.2-0.5-0.5c0-0.3,0.2-0.5,0.5-0.5h19.2c0.3,0,0.5,0.2,0.5,0.5C27.7,42.6,27.5,42.8,27.2,42.8z
			"/>
		<path d="M27.2,43.3H7.9c-0.6,0-1-0.4-1-1c0-0.6,0.4-1,1-1h19.2c0.6,0,1,0.4,1,1C28.2,42.9,27.7,43.3,27.2,43.3z M27.2,42.3
			l-19.2,0L27.2,42.3C27.2,42.3,27.2,42.3,27.2,42.3z"/>
	</g>
</g>
</svg>
</span>'.sprintf(esc_html__('%1$s Curriculum', 'dtlms'), $total_curriculum_count).'
				</p>';

	return $output;

}

function dtlms_course_listing_post_date($course_id) {

	$course_date = get_the_date( 'd M, Y', $course_id );

	$output = '<p class="dtlms-courselist-post_date">
	<span class="clock-icon"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
	 viewBox="0 0 50 50" style="enable-background:new 0 0 50 50;" xml:space="preserve">
<g>
	<g>
		<path d="M5.6,12.3c-0.3,0-0.5-0.2-0.5-0.5V1.5C5.1,1.2,5.3,1,5.6,1s0.5,0.3,0.5,0.5v10.2C6.1,12,5.9,12.3,5.6,12.3z"/>
		<path d="M5.6,12.8c-0.6,0-1-0.4-1-1V1.5c0-0.6,0.4-1,1-1c0.6,0,1,0.5,1,1v10.2C6.6,12.3,6.2,12.8,5.6,12.8z"/>
	</g>
	<g>
		<path d="M15.8,12.3H5.6c-0.3,0-0.5-0.2-0.5-0.5s0.2-0.5,0.5-0.5h10.2c0.3,0,0.5,0.2,0.5,0.5S16.1,12.3,15.8,12.3z"/>
		<path d="M15.8,12.8H5.6c-0.6,0-1-0.4-1-1c0-0.6,0.4-1,1-1h10.2c0.6,0,1,0.4,1,1C16.8,12.4,16.4,12.8,15.8,12.8z M15.8,11.8
			l-10.2,0L15.8,11.8C15.8,11.8,15.8,11.8,15.8,11.8z"/>
	</g>
	<g>
		<path d="M25,49C11.8,49,1,38.2,1,25c0-0.3,0.2-0.5,0.5-0.5S2,24.7,2,25c0,12.6,10.3,23,23,23c12.6,0,23-10.3,23-23
			C48,12.4,37.6,2,25,2c-0.3,0-0.5-0.2-0.5-0.5S24.7,1,25,1c13.2,0,24,10.8,24,24S38.2,49,25,49z"/>
		<path d="M25,49.5c-13.5,0-24.5-11-24.5-24.5c0-0.6,0.4-1,1-1s1,0.4,1,1c0,12.4,10.1,22.5,22.5,22.5S47.5,37.4,47.5,25
			S37.4,2.5,25,2.5c-0.6,0-1-0.4-1-1s0.4-1,1-1c13.5,0,24.5,11,24.5,24.5S38.5,49.5,25,49.5z"/>
	</g>
	<g>
		<path d="M5.6,12.3c-0.1,0-0.2,0-0.3-0.1C5.1,12,5,11.7,5.2,11.5C9.7,4.9,17.1,1,25,1c0.3,0,0.5,0.2,0.5,0.5S25.3,2,25,2
			C17.5,2,10.3,5.7,6.1,12C6,12.2,5.8,12.3,5.6,12.3z"/>
		<path d="M5.6,12.8c-0.1,0-0.4,0-0.7-0.2c-0.4-0.4-0.5-1-0.1-1.4C9.4,4.5,17,0.5,25,0.5c0.6,0,1,0.4,1,1s-0.4,1-1,1
			c-7.5,0-14.4,3.6-18.5,9.8C6.4,12.6,6,12.8,5.6,12.8z M5.6,11.8l0,0.5L5.6,11.8C5.6,11.8,5.6,11.8,5.6,11.8z"/>
	</g>
	<g>
		<path d="M26,26.5c-0.3,0-0.5-0.2-0.5-0.5V11.8c0-0.3,0.2-0.5,0.5-0.5c0.3,0,0.5,0.2,0.5,0.5V26C26.5,26.3,26.3,26.5,26,26.5z"/>
		<path d="M26,27c-0.6,0-1-0.4-1-1V11.8c0-0.6,0.4-1,1-1c0.6,0,1,0.4,1,1V26C27,26.6,26.6,27,26,27z"/>
	</g>
	<g>
		<path d="M38.2,26.5H26c-0.3,0-0.5-0.2-0.5-0.5c0-0.3,0.2-0.5,0.5-0.5h12.2c0.3,0,0.5,0.2,0.5,0.5C38.7,26.3,38.5,26.5,38.2,26.5z"
			/>
		<path d="M38.2,27H26c-0.6,0-1-0.4-1-1c0-0.6,0.4-1,1-1h12.2c0.6,0,1,0.4,1,1C39.2,26.6,38.8,27,38.2,27z M38.2,26L26,26L38.2,26
			C38.2,26,38.2,26,38.2,26z"/>
	</g>
</g>
</svg>
</span>'.$course_date.'
				</p>';

	return $output;

}

function dtlms_course_listing_started_users($course_id) {

	$started_users = get_post_meta($course_id, 'started_users', true);
	if (!is_array($started_users)) {
        $started_users = !empty($started_users) ? array($started_users) : array();
    }
	$output = '<p class="dtlms-courselist-started-users">
					<span class="users-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 60">
<path d="M30,27.5c-.35,0-.7,0-1,0A11.68,11.68,0,0,1,18.67,15.67V12.83A11.67,11.67,0,0,1,29,1.05,
11.15,11.15,0,0,1,37.67,4a11.35,11.35,0,0,1,3.68,8.35v3.84a11.34,11.34,0,0,1-3.68,8.36A11.17,11.17,
0,0,1,30,27.5ZM30,4.6l-.71,0a8.05,8.05,0,0,0-7,8.2v2.84a8.06,8.06,0,0,0,7,8.21,7.63,7.63,0,0,0,5.94-2,
7.77,7.77,0,0,0,2.51-5.71V12.33A7.75,7.75,0,0,0,30,4.6Z">
</path>
<path d="M53.72,59H6.28A4.21,4.21,0,0,1,2.1,54.37,28,28,0,0,1,18.8,31.51a6.53,6.53,0,0,1,7.56,
1.85l3.19,3.82c.32.38.59.37.9,0l3.19-3.82h0a6.56,6.56,0,0,1,7.55-1.84A28.07,28.07,0,0,1,57.9,
54.37,4.21,4.21,0,0,1,53.72,59ZM21.31,34.58a2.66,2.66,0,0,0-1.07.22A24.38,24.38,0,0,0,5.68,
54.73a.6.6,0,0,0,.15.48.6.6,0,0,0,.45.2H53.72a.58.58,0,0,0,.45-.2.56.56,0,0,0,
.15-.47A24.5,24.5,0,0,0,39.77,34.8a3,3,0,0,0-3.37.87l-3.2,3.82a4.31,4.31,0,0,1-6.4,
0l-3.2-3.82A3,3,0,0,0,21.31,34.58Z">
</path>
</svg></span>'.count($started_users). esc_html(' Students ','dtlms').'
				</p>';

	return $output;

}

function dtlms_course_listing_metadata($course_id) {

	$duration = dtlms_get_course_duration($course_id, 'style3', 'course');

	$started_users = get_post_meta($course_id, 'started_users', true);
	$student_enrolled = $started_users[0];

	$output = '<div class="dtlms-courselist-meta">
		        	<ul>
		            	<li>
		                	<label>'.esc_html__('Instructor', 'dtlms').'</label>
		                    <span>'.get_the_author().'</span>
		                </li>
		                <li>
		                	<label>'.esc_html__('Duration', 'dtlms').'</label>
		                    <span>'.esc_attr($duration).'</span>
		                </li>
		                <li>
		                	<label>'.esc_html__('Categories', 'dtlms').'</label>
		                    <span>'.get_the_term_list($course_id, 'course_category', '', ', ', '').'</span>
		                </li>
		                <li>
		                	<label>'.esc_html__('Student Enrolled', 'dtlms').'</label>
		                    <span>'.esc_html($student_enrolled).'</span>
		                </li>
		            </ul>
		        </div>';

	return $output;

}

function dtlms_course_listing_students_enrolled($course_id) {

	$started_users = get_post_meta($course_id, 'started_users', true);
	$student_enrolled = $started_users[0];

	$output = '<div class="dtlms-courselist-students-enrolled">
        			<i class="fas fa-users"></i>
        			<span>'.esc_html($student_enrolled).'</span>
        		</div>';

    return $output;

}

function dtlms_course_listing_single_price($purchased_paid_course, $free_course, $woo_price) {

	$output = '';

	if($free_course) {

		$output = '<div class="dtlms-coursedetail-price-details">
						<span class="dtlms-price-status dtlms-free">
							<span class="fas fa-check"></span> '.esc_html__('Free', 'dtlms').'
						</span>
					</div>';

	} else {

		$output = '<div class="dtlms-coursedetail-price-details">
						<span class="dtlms-price-status dtlms-cost">
							'.$woo_price.'
						</span>
					</div>';

	}

	return $output;

}

function dtlms_course_listing_single_addtocart($purchased_paid_course, $free_course, $course_id, $product, $submitted_courses, $completed_courses) {

	$output = '';

	if(!$purchased_paid_course && !$free_course) {

		if(dtlms_check_item_is_in_cart($course_id)) {

			$output .= '<div class="dtlms-coursedetail-cart-details">';
				$output .= '<a href="'.wc_get_cart_url().'" target="_self" class="dtlms-coursedetail-cart-link dtlms-button small filled"><i class="fas fa-cart-plus"></i>'.esc_html__('View Cart','dtlms').'</a>';
			$output .= '</div>';

		} else {

			$allow_purchase = true;

			$course_not_started = false;
			$course_need_prerequisite = false;

			$course_start_date = get_post_meta ( $course_id, 'course-start-date', true );

			if($course_start_date != '') {

				$course_startdate_timestamp = strtotime($course_start_date);
				$current_timestamp = current_time( 'timestamp', 1 );

				$allowpurchases_before_course_startdate = get_post_meta($course_id, 'allowpurchases-before-course-startdate', true);

				if(($current_timestamp >= $course_startdate_timestamp) || (($current_timestamp < $course_startdate_timestamp) && $allowpurchases_before_course_startdate =='true')) {
					$allow_purchase = true;
					$course_not_started = false;
				} else {
					$allow_purchase = false;
					$course_not_started = true;
				}

			}


			$course_prerequisite = get_post_meta ( $course_id, 'course-prerequisite', true );
			if($course_prerequisite > 0) {

				$allow_purchase = false;
				$course_need_prerequisite = true;

				$allowpurchases_before_course_prerequisite = get_post_meta($course_id, 'allowpurchases-before-course-prerequisite', true);

				if('true' ==  dtlms_option('course','course-prerequisite-on-complete')) {
					if(in_array($course_prerequisite, $completed_courses) || $allowpurchases_before_course_prerequisite == 'true') {
						$allow_purchase = true;
						$course_need_prerequisite = false;
					}
				} else {
					if(in_array($course_prerequisite, $submitted_courses) || $allowpurchases_before_course_prerequisite == 'true') {
						$allow_purchase = true;
						$course_need_prerequisite = false;
					}
				}

			}

			$capacity = get_post_meta ( $course_id, 'capacity', true );
			if($capacity != '' && $capacity > 0) {
				$disable_purchases_over_capacity = get_post_meta($course_id, 'disable-purchases-over-capacity', true);
				$actual_capacity = dtlms_calculate_course_available_seats($course_id, $capacity);
				if($actual_capacity <= 0 && $disable_purchases_over_capacity == 'true') {
					$allow_purchase = false;
				}
			}

			if($allow_purchase) {

				$output .= '<div class="dtlms-coursedetail-cart-details">';
					$output .= '<a href="'. apply_filters( 'add_to_cart_url', esc_url( $product->add_to_cart_url() ) ) .'" rel="nofollow" data-product_id="'.esc_attr($product->get_id()).'" class="dtlms-button small filled add_to_cart_button ajax_add_to_cart product_type_'.esc_attr($product->get_type()).'"><i class="fas fa-shopping-cart"></i><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
	 viewBox="0 0 50 50" style="enable-background:new 0 0 50 50;" xml:space="preserve">
<path d="M24.1,8.9c-11,0.4-17.9,8-17.9,19.9c0,6.7,2.2,12.9,6.1,17.2c0.2,0.2-0.1,0.5-0.3,0.4C4.9,42,0,34.1,0,25
	C0,11.5,10.7,0.5,24.1,0C24.6,0,25,0.4,25,0.9v7.1C25,8.5,24.6,8.9,24.1,8.9z M25.9,41.1c11-0.4,17.9-8,17.9-19.9
	c0-6.7-2.2-12.9-6.1-17.2c-0.2-0.2,0.1-0.5,0.3-0.4C45.1,8,50,15.9,50,25c0,13.5-10.7,24.5-24.1,25c-0.5,0-0.9-0.4-0.9-0.9v-7.1
	C25,41.5,25.4,41.1,25.9,41.1z"/>
</svg>
add to cart</a>';
				$output .= '</div>';

			} else if ($course_not_started) {

				$output .= '<div class="dtlms-coursedetail-cart-details dtlms-coursedetail-notes">';
					$output .= '<a href="#" class="dtlms-button small filled dtlms-disabled">'.sprintf(esc_html__('Starts On : %1$s', 'dtlms'), $course_start_date).'</a>';
				$output .= '</div>';

			} else if ($course_need_prerequisite) {

				$output .= '<div class="dtlms-coursedetail-cart-details dtlms-coursedetail-notes">';
					$output .= '<a href="#" class="dtlms-button small filled dtlms-disabled">'.sprintf(esc_html__('Require : %1$s', 'dtlms'), get_the_title($course_prerequisite)).'</a>';
				$output .= '</div>';

			}

		}

	}

	if($free_course && !is_user_logged_in()) {
		$output .= '<div class="dtlms-coursedetail-cart-details">';
			$output .= '<a href="#" title="'.esc_html__('Login', 'dtlms').'" class="dtlms-login-link" onclick="return false"><i class="fas fa-unlock-alt"></i>'.esc_html__('Login', 'dtlms').'</a>';
		$output .= '</div>';
	}

	return $output;

}

function dtlms_course_listing_purchase_status($purchased_paid_course, $course_id, $active_package_courses, $purchased_class_courses, $assigned_courses, $purchased_courses) {

	$output = '';

	if($purchased_paid_course) {

		$output .= '<div class="dtlms-courselist-purchase-status-details">';

			if(in_array($course_id, $active_package_courses)) {

				$output .= '<span class="dtlms-purchase-status dtlms-purchased-package">
								'.esc_html__('Purchased Package','dtlms').
							'</span>';

			} else if(in_array($course_id, $purchased_class_courses)) {

				$class_singular_label = apply_filters( 'class_label', 'singular' );

				$output .= '<span class="dtlms-purchase-status dtlms-purchased-class">
								'.sprintf( esc_html__( 'Purchased %1$s', 'dtlms' ), $class_singular_label ).
							'</span>';

			} else if(in_array($course_id, $assigned_courses)) {

				$output .= '<span class="dtlms-purchase-status dtlms-assigned">
								'.esc_html__('Assigned','dtlms').
							'</span>';

			} else if(in_array($course_id, $purchased_courses)) {

				$output .= '<span class="dtlms-purchase-status dtlms-purchased">
								'.esc_html__('Purchased','dtlms').
							'</span>';

			}

		$output .= '</div>';

	}

	return $output;

}

function dtlms_course_listing_progress_details($purchased_paid_course, $free_course, $course_id, $started_courses, $submitted_courses, $completed_courses, $origin) {

	$courses_undergoing = array_diff($started_courses, $submitted_courses);
	$courses_underevaluation = array_diff($submitted_courses, $completed_courses);

	$output = '';

	if($purchased_paid_course || $free_course) {

		$label_class = '';
		if($origin == 'single') {
			$label_class = '<label>'.esc_html__('Status : ', 'dtlms').'</label>';
		}

		if(in_array($course_id, $courses_undergoing)) {

			$output .= '<div class="dtlms-courselist-progress-details">';
				$output .= '<span class="dtlms-undergoing">
								'.$label_class.'
								'.esc_html__('Undergoing', 'dtlms').
							'</span>';
			$output .= '</div>';

		}

		if(in_array($course_id, $courses_underevaluation)) {

			$output .= '<div class="dtlms-courselist-progress-details">';
				$output .= '<span class="dtlms-underevaluation">
								'.$label_class.'
								'.esc_html__('Under Evaluation', 'dtlms').
							'</span>';
			$output .= '</div>';

		}

		if(in_array($course_id, $completed_courses)) {

			$output .= '<div class="dtlms-courselist-progress-details">';
				$output .= '<span class="dtlms-completed">
								'.$label_class.'
								'.esc_html__('Completed', 'dtlms').
							'</span>';
			$output .= '</div>';

		}

	}

	return $output;

}

?>