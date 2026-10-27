<?php get_header('dtlms'); ?>

	<?php
	/**
	* dtlms_before_main_content hook.
	*/
	do_action( 'dtlms_before_main_content' );
	?>

		<?php
		/**
		* dtlms_before_content hook.
		*/
		do_action( 'dtlms_before_content' );
		?>


			<?php

			$author_id = get_queried_object_id();

			$user_meta = get_userdata($author_id);
			$user_roles = $user_meta->roles;
			$user_name = $user_meta->data->display_name;
			$user_url = $user_meta->data->user_url;
			$usermeta = get_user_meta($author_id);
			$user_social_items = get_the_author_meta('user-social-items', $author_id);
			$user_social_items = (isset($user_social_items) && is_array($user_social_items)) ? $user_social_items : array();
			
				$user_social_items_value = get_the_author_meta('user-social-items-value', $author_id);
				$user_social_items_value = (isset($user_social_items_value) && is_array($user_social_items_value)) ? $user_social_items_value : array();

				$social_links_str = '';
				if(is_array($user_social_items) && !empty($user_social_items)) {
							$j = 0;
							$social_links_str .= '<ul>';
							foreach($user_social_items as $user_social_item) {
								$social_links_str .= '<li><a class="fab '.$user_social_item.'" href="'.$user_social_items_value[$j].'"></a></li>';
								$j++;
							}
							$social_links_str .= '</ul>';
				}
			$data = get_the_author_meta( 'dtlms_user_profile_image_url' , $author_id);	
			$billing_phone=get_the_author_meta('billing_phone',$author_id); //Get the author /user details use get_the_author_meta
	
			if(in_array('instructor', $user_roles)) {

				echo '<div class="dtlms-column dtlms-one-third first">';
					echo '<img src="'.esc_url($data).'" alt="'.esc_html__('Instructor Image', 'dtlms').'" title="'.esc_html__('Instructor Image', 'dtlms').'" />';
				echo '</div>';

				echo '<div class="dtlms-column dtlms-two-third">';
					echo '<div class="dtlms-single-instructor-about">';
					echo '<h3 class="dtlms-single-instructor-description-title">About Me</h3>';
							echo '<p class="dtlms-single-instructor-description">'.esc_attr($usermeta['description'][0]).'</p>';
					echo '</div>';
				echo '</div>';

				echo '<div class="dtlms-column dtlms-two-third">';
					// echo '<div class="dtlms_instructor_name">';
					// 	echo "<h4>".$user_name."</h4>";
					// 	echo "<h6>".esc_attr($usermeta['user-specialization'][0])."</h6>";
					// echo '</div>';
					echo '<ul class="teachers-details">
						<li><span class="exp-icon"></span><span>'.esc_html__('Experience : ','dtlms'). '</span>'.esc_attr($usermeta['user-experience'][0]).'</li>
						<li><span class="role-icon"></span><span>'.esc_html__('Role : ','dtlms').'</span>'.esc_attr($usermeta['user-specialization'][0]).'</li>
						<li><span class="website-icon"></span><span>'.esc_html__('Website : ','dtlms').'</span>'.'<a href="'.esc_url($user_url).'">' .$user_url .'</a></li>
						<li><span class="phone-icon"></span><span>'.esc_html__('Phone : ','dtlms'). '</span>'.esc_attr($billing_phone).'</li>
						<li><span class="email-icon"></span><span>'.esc_html__('Email : ','dtlms'). '</span>'.esc_attr($user_meta->user_email).'</li>
						<li class="social-share"><span class="social-icon"></span><span>'.esc_html__('Social : ','dtlms'). '</span>'.($social_links_str).'</li>
					</ul>';

				echo '</div>';


			}

			if(in_array('student', $user_roles)) {

				echo '<div class="dtlms-column dtlms-one-third first">';
					echo '<img src="'.esc_url($data).'" alt="'.esc_html__('Student Image', 'dtlms').'" title="'.esc_html__('Student Image', 'dtlms').'" />';
				echo '</div>';

				echo '<div class="dtlms-column dtlms-two-third">';
					echo '<div class="dtlms-single-instructor-about">';
					echo '<h3 class="dtlms-single-instructor-description-title">About Me</h3>';
							echo '<p class="dtlms-single-instructor-description">'.esc_attr($usermeta['description'][0]).'</p>';
					echo '</div>';
				echo '</div>';

				echo '<div class="dtlms-column dtlms-two-third">';
					// echo '<div class="dtlms_instructor_name">';
					// 	echo "<h4>".$user_name."</h4>";
					// 	echo "<h6>".esc_attr($usermeta['user-specialization'][0])."</h6>";
					// echo '</div>';
					echo '<ul class="teachers-details">
						<li><span class="exp-icon"></span><span>'.esc_html__('Experience : ','dtlms'). '</span>'.esc_attr($usermeta['user-experience'][0]).'</li>
						<li><span class="role-icon"></span><span>'.esc_html__('Role : ','dtlms').'</span>'.esc_attr($usermeta['user-specialization'][0]).'</li>
						<li><span class="website-icon"></span><span>'.esc_html__('Website : ','dtlms').'</span>'.'<a href="'.esc_url($user_url).'">' .$user_url .'</a></li>
						<li><span class="phone-icon"></span><span>'.esc_html__('Phone : ','dtlms'). '</span>'.esc_attr($billing_phone).'</li>
						<li><span class="email-icon"></span><span>'.esc_html__('Email : ','dtlms'). '</span>'.esc_attr($user_meta->user_email).'</li>
						<li class="social-share"><span class="social-icon"></span><span>'.esc_html__('Social : ','dtlms'). '</span>'.($social_links_str).'</li>
					</ul>';

				echo '</div>';

			}

			echo '<div class="dtlms-column dtlms-two-third author-curriculam-details">';
				
				// Classes

				$dtlms_modules = dtlms_instance()->active_modules;
				$dtlms_module_active = (is_array($dtlms_modules) && !empty($dtlms_modules) && in_array('class', $dtlms_modules)) ? true : false;

				if($dtlms_module_active) {

					$classes_args = array (
										'post_type' => 'dtlms_classes',
										'posts_per_page' => -1,
										'author__in' => $author_id,
										'orderby' => 'post_date',
										'order' => 'DESC'
									);
					$class_array = get_posts( $classes_args );

					if(is_array($class_array) && !empty($class_array)) {

						echo '<div class="instructor-handling-classes">';
							echo '<h5 class="border-title">'.esc_html__('Classes Handling', 'dtlms').'<span></span></h5>';

							echo '<table>
									<thead>
									<tr>
										<th>'.esc_html__('Class Name','dtlms').'</th>
										<th>'.esc_html__('Class Type','dtlms').'</th>
									</tr>
									</thead>
									<tbody>';
							// echo '</div>';			

										foreach($class_array as $class_item) {

											$class_id = $class_item->ID;
											$class_type = get_post_meta($class_id, 'dtlms-class-type', true);

											echo '<tr>
													<td><a href="'.get_permalink($class_id).'">'.$class_item->post_title.'</a></td>
													<td>'.$class_type.'</td>
												</tr>';

										}

								echo '</tbody>';
							echo '</table>';
						echo '</div>';



					} else {

						echo '<div class="instructor-handling-classes">';
							echo '<h5 class="border-title">'.esc_html__('Classes Handling', 'dtlms').'<span></span></h5>';

							echo '<table>
									<thead>
									<tr>
										<th>'.esc_html__('Class Name','dtlms').'</th>
										<th>'.esc_html__('Class Type','dtlms').'</th>
									</tr>
									</thead>
									<tbody>
										<tr>
											<td colspan="2">'.esc_html__('No Records found!','dtlms').'</td>
										</tr>
									</tbody>
								</table>';
						echo '</div>';	
					}

				}

				// Courses

				$courses_args = array (
									'post_type' => 'dtlms_courses',
									'posts_per_page' => -1,
									'author__in' => $author_id,
									'orderby' => 'post_date',
									'order' => 'DESC'
								);
				$course_array = get_posts( $courses_args );

				if(is_array($course_array) && !empty($course_array)) {

					echo '<div class="instructor-handling-courses">';
						echo '<h5 class="border-title">'.esc_html__('Courses Handling', 'dtlms').'<span></span></h5>';

						echo '<table>
								<thead>
								<tr>
									<th>'.esc_html__('Course Name','dtlms').'</th>
									<th>'.esc_html__('Curriculum(s)','dtlms').'</th>
								</tr>
								</thead>
								<tbody>';

									foreach($course_array as $course_item) {

										$course_id = $course_item->ID;
										$total_curriculum_count = dtlms_course_curriculum_counts($course_id, true);

										echo '<tr>
												<td><a href="'.get_permalink($course_id).'">'.$course_item->post_title.'</a></td>
												<td>'.$total_curriculum_count.'</td>
											</tr>';

									}

							echo '</tbody>';
						echo '</table>';
					echo '</div>';	

				} else {

					echo '<div class="instructor-handling-courses">';
						echo '<h5 class="border-title">'.esc_html__('Courses Handling', 'dtlms').'<span></span></h5>';

						echo '<table>
								<thead>
								<tr>
									<th>'.esc_html__('Course Name','dtlms').'</th>
									<th>'.esc_html__('Curriculum(s)','dtlms').'</th>
								</tr>
								</thead>
								<tbody>
									<tr>
										<td colspan="2">'.esc_html__('No Records found!','dtlms').'</td>
									</tr>
								</tbody>
							</table>';
					echo '</div>';	
				}

			echo '</div>';
			//echo '</div>';

			?>


		<?php

		/**
		* dtlms_after_content hook.
		*/
		do_action( 'dtlms_after_content' );
		?>
	<?php
	/**
	* dtlms_after_main_content hook.
	*/
	do_action( 'dtlms_after_main_content' );

	echo '<div class="dtlms-column one-column first dtlms-single-instructor-education">';
		if (class_exists("\\Elementor\\Plugin")) {
			$template_id = $usermeta['user_template_id'][0];
			$pluginElementor = \Elementor\Plugin::instance();
			$contentElementor = $pluginElementor->frontend->get_builder_content($template_id);
		}

		echo $contentElementor;
	echo '</div>';
	?>

<?php get_footer('dtlms'); ?>