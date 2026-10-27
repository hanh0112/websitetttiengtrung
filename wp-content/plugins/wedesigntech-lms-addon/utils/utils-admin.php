<?php

if( !function_exists( 'dtlms_adminpanel_image_preview' ) ){
	function dtlms_adminpanel_image_preview($src) {

		$default = DTLMS_PLUGIN_URL.'assets/images/backend/no-image.jpg';
		$src = !empty($src) ? $src : $default;

		$output = '';

		$output .= '<div class="dtlms-image-preview-holder">';
			$output .= '<a href="#" class="dtlms-image-preview" onclick="return false;">
							<img src="'.DTLMS_PLUGIN_URL.'assets/images/backend/image-preview.png" alt="'.esc_html__('Image Preview', 'dtlms').'" title="'.esc_html__('Image Preview', 'dtlms').'" />';
							$output .= '<div class="dtlms-image-preview-tooltip">';
								$output .= '<img src="'.$src.'" data-default="'.$default.'"  alt="'.esc_html__('Image Preview Tooltip', 'dtlms').'" title="'.esc_html__('Image Preview Tooltip', 'dtlms').'" />';
							$output .= '</div>';
			$output .= '</a>';
		$output .= '</div>';

		return $output;

	}
}

function dtlms_user_profile_picture_field($user_id) {


	$output = '';

	$dtlms_user_profile_image_url = get_the_author_meta( 'dtlms_user_profile_image_url' , $user_id ,100);
	$dtlms_user_profile_image     = get_the_author_meta( 'dtlms_user_profile_image' , $user_id );

	$output .= '<div class="dtlms-upload-media-items-container">';
	$output .= '<input name="dtlms_user_profile_image_url" type="text" value="'.$dtlms_user_profile_image_url.'" placeholder="'.esc_html__('Image', 'dtlms').'" class="uploadfieldurl regular-text" readonly />';
	$output .= '<input name="dtlms_user_profile_image" value="'.$dtlms_user_profile_image.'" type="hidden" placeholder="'.esc_html__('Image', 'dtlms').'" class="uploadfieldid" readonly />';
	$output .= '<input type="button" value="'.esc_html__('Upload', 'dtlms').'" class="dtlms-upload-media-item-button show-image-holder" />';
	$output .= '<input type="button" value="'.esc_html__('Remove', 'dtlms').'" class="dtlms-upload-media-item-reset" />';
	$output .= dtlms_adminpanel_image_preview($dtlms_user_profile_image_url);
	$output .= '</div>';

	return $output;

}

?>