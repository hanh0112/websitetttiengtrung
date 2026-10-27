<?php

// Register user roles
if(!function_exists('dtlms_user_roles')) {

    function dtlms_user_roles() {

		$instructor_capability=array(
			'delete_posts'=> true,
			'delete_published_posts'=> true,
			'edit_posts'=> true,
			'manage_categories' => true,
			'edit_published_posts'=> true,
			'publish_posts'=> true,
			'read' => true,
			'upload_files'=> true,
			'unfiltered_html'=> true,
			'level_1' => true
		);

		$student_capability=array(
			'read'
		);

		add_role( 'instructor', esc_html__('Instructor','dtlms'), $instructor_capability);
		add_role( 'student', esc_html__('Student','dtlms'), $student_capability );

	}

	add_action('init','dtlms_user_roles');

}


// Remove admin bar
if(!function_exists('dtlms_remove_admin_bar')) {

    function dtlms_remove_admin_bar() {
        if (!current_user_can('edit_posts')) {
         	show_admin_bar(false);
        }
    }

    add_action('after_setup_theme', 'dtlms_remove_admin_bar');

}


// Register user profile fields
add_action( 'show_user_profile', 'dtlms_social_links_sc' );
add_action( 'edit_user_profile', 'dtlms_social_links_sc' );
function dtlms_social_links_sc( $user )
{

	$sociables = array('fa-dribbble' => 'Dribble', 'fa-flickr' => 'Flickr', 'fa-github' => 'GitHub', 'fa-pinterest-p' => 'Pinterest', 'fa-stack-overflow' => 'Stack Overflow', 'fa-twitter' => 'Twitter', 'fa-youtube' => 'YouTube', 'fa-android' => 'Android', 'fa-dropbox' => 'Dropbox', 'fa-instagram' => 'Instagram', 'fa-facebook-f' => 'Facebook', 'fa-google-plus-g' => 'Google Plus', 'fa-linkedin-in' => 'LinkedIn', 'fa-skype' => 'Skype', 'fa-tumblr' => 'Tumblr', 'fa-vimeo-square' => 'Vimeo');


	echo '<h2>'.esc_html__('Author additional information','dtlms').'</h2>';

	echo '<table class="form-table">
			<tbody>

				<tr class="user-description-wrap">
					<th>'.esc_html__('Specialization', 'dtlms').'</th>
					<td>';
						$user_specialization = get_the_author_meta('user-specialization', $user->ID);
						$user_specialization = isset($user_specialization) ? $user_specialization : '';
						echo '<input class="large" type="text" placeholder="'.esc_html__('Specialization', 'dtlms').'" style="width:80%" id="user-specialization" name="user-specialization" value="'.$user_specialization.'" />
					</td>
				</tr>

				<tr class="user-profile-picture">
					<th>'.esc_html__('Social Links', 'dtlms').'</th>
					<td>

						<div id="dtlms-user-details-container">';

							$user_social_items = get_the_author_meta('user-social-items', $user->ID);
							$user_social_items = (isset($user_social_items) && is_array($user_social_items)) ? $user_social_items : array();

							$user_social_items_value = get_the_author_meta('user-social-items-value', $user->ID);
							$user_social_items_value = (isset($user_social_items_value) && is_array($user_social_items_value)) ? $user_social_items_value : array();

							$i = 0;
							foreach($user_social_items as $user_social_item) {

							    echo '<div id="dtlms-user-section-item">';

									echo '<select class="social-item-list social-item-chosen" id="user-social-items" name="user-social-items[]">';
										foreach ( $sociables as $sociable_key => $sociable_value ) :
											$s = ($sociable_key == $user_social_item) ? 'selected="selected"' : '';
											$v = ucwords ( $sociable_value );
											echo '<option value="'.$sociable_key.'" '.$s.'>'.$v.'</option>';
										endforeach;
									echo '</select>';

							        echo '<input class="large" type="text" placeholder="'.esc_html__('Social Link', 'dtlms').'" style="width:91.2%" id="user-social-items-value" name="user-social-items-value[]" value="'.$user_social_items_value[$i].'" />';

							        echo '<span class="dtlms-remove-user-tab"><span class="fas fa-times"></span></span>';
							        echo '<span class="fas fa-arrows-alt"></span>';

							    echo '</div>';

							    $i++;

							}

					echo '</div>';

					echo '<a href="#" class="dtlms-add-user-social custom-button-style">'.esc_html__('Add Social Item', 'dtlms').'</a>';

				    echo '<div id="dtlms-user-section-to-clone" class="hidden">';

						echo '<select class="social-item-list">';
							foreach ( $sociables as $key => $value ) :
								$v = ucwords ( $value );
								echo '<option value="'.$key.'">'.$v.'</option>';
							endforeach;
						echo '</select>';

				        echo '<input class="large" type="text" placeholder="'.esc_html__('Social Link', 'dtlms').'" style="width:91.2%" />';

				        echo '<span class="dtlms-remove-user-tab"><span class="fas fa-times"></span></span>';
				        echo '<span class="fas fa-arrows-alt"></span>';

				    echo '</div>';

				 echo '</td>
				</tr>

				

				<tr class="user-description-wrap">
					<th>'.esc_html__('Select Elementor Template', 'dtlms').'</th>
					<td>';
					echo '<select class="elementor_template_select" name="user-tempalte-id">';
					$user_template_id = get_the_author_meta('user-tempalte-id', $user->ID);
					$user_template_id = isset($user_template_id) ? $user_template_id : '';
					$elementor_templates = get_elementor_templates_with_id();
					// Add an empty option
					echo '<option value="-1" ' . selected('', $user_template_id, false) . '>' . esc_html__('Select Template', 'dtlms') . '</option>';
					foreach ( $elementor_templates  as $key => $value ) :
						$v = ucwords ( $value );
						$selected = selected($key, $user_template_id, false);
						echo '<option value="' . esc_attr($key) . '" ' . $selected . '>' . esc_html($v) . '</option>';
						//echo '<option value="'.$key.'">'.$v.'</option>';
					endforeach;
					echo '</select>
					</td>
				</tr>

				<tr class="user-description-wrap">
					<th>'.esc_html__('Education ', 'dtlms').'</th>
					<td>';
						$user_education = get_the_author_meta('user-education', $user->ID);
						$user_education = isset($user_education) ? $user_education : '';
						echo '<input class="large" type="text" placeholder="'.esc_html__('Instructor Education', 'dtlms').'" style="width:50%" id="user-education" name="user-education" value="'.$user_education.'" />
					</td>
				</tr>
				
				<tr class="user-description-wrap">
					<th>'.esc_html__('Experience', 'dtlms').'</th>
					<td>';
						$user_experience = get_the_author_meta('user-experience', $user->ID);
						$user_experience = isset($user_experience) ? $user_experience : '';
						echo '<input class="large" type="text" placeholder="'.esc_html__('Instructor Experience', 'dtlms').'" style="width:50%" id="user-experience" name="user-experience" value="'.$user_experience.'" />
					</td>
				</tr>
				
				<th>'.esc_html__('Custom Profile Picture', 'dtlms').'</th>';
							echo '<td>'.dtlms_user_profile_picture_field($user->ID).'</td>';
						echo '</tr>
						<tr>

			</tbody>
		</table>';

}

add_action( 'personal_options_update', 'dtlms_save_social_links_sc' );
add_action( 'edit_user_profile_update', 'dtlms_save_social_links_sc' );
function dtlms_save_social_links_sc( $user_id )
{
	if(isset($_POST['user-specialization']) && $_POST['user-specialization'] != '') {
		update_user_meta( $user_id,'user-specialization', dtlms_recursive_sanitize_text_field($_POST['user-specialization']) );
	}
	if(isset($_POST['user-social-items']) && $_POST['user-social-items'] != '') {
		update_user_meta( $user_id,'user-social-items', dtlms_recursive_sanitize_text_field($_POST['user-social-items']) );
	}
	if(isset($_POST['user-social-items-value']) && $_POST['user-social-items-value'] != '') {
		update_user_meta( $user_id,'user-social-items-value', dtlms_recursive_sanitize_text_field($_POST['user-social-items-value']) );
	}
	if(isset($_POST['dtlms_user_profile_image_url']) && $_POST['dtlms_user_profile_image_url'] != '') {
		update_user_meta( $user_id,'dtlms_user_profile_image_url', dtlms_recursive_sanitize_text_field ( $_POST['dtlms_user_profile_image_url'] ) );
	} else {
		delete_user_meta( $user_id, 'dtlms_user_profile_image_url' );
	}
	if(isset($_POST['user-tempalte-id']) && $_POST['user-tempalte-id'] != '') {
		update_user_meta( $user_id,'user-tempalte-id', dtlms_recursive_sanitize_text_field($_POST['user-tempalte-id']) );
	}
	if(isset($_POST['user-education']) && $_POST['user-education'] != '') {
		update_user_meta( $user_id,'user-education', dtlms_recursive_sanitize_text_field($_POST['user-education']) );
	}
	if(isset($_POST['user-experience']) && $_POST['user-experience'] != '') {
		update_user_meta( $user_id,'user-experience', dtlms_recursive_sanitize_text_field($_POST['user-experience']) );
	}
}

?>