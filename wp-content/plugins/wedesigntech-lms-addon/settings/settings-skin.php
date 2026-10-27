<?php

function dtlms_settings_skin_content() {

	$output = '';

	$primary_color              = dtlms_skin_option('primary-color');
	$secondary_color            = dtlms_skin_option('secondary-color');
	$tertiary_color             = dtlms_skin_option('tertiary-color');

	$primary_alternate_color    = dtlms_skin_option('primary-alternate-color');
	$secondary_alternate_color  = dtlms_skin_option('secondary-alternate-color');
	$tertiary_alternate_color   = dtlms_skin_option('tertiary-alternate-color');

	$quiztimer_foreground_color = dtlms_skin_option('quiztimer-foreground-color');
	$quiztimer_background_color = dtlms_skin_option('quiztimer-background-color');

	$dtlms_modules = dtlms_instance()->active_modules;
	$dtlms_modules = (is_array($dtlms_modules) && !empty($dtlms_modules)) ? $dtlms_modules : array ();

	$output .= '<form name="formSkinSettings" class="formSkinSettings" method="post">';

		$output .= '<p class="dtlms-note">'.esc_html__('Following colors will be used as default colors for "DesignThemes LMS Addon".', 'dtlms').'</p>';
		$output .= '<div class="dtlms-clear"></div>';

		$output .= '<div class="dtlms-column dtlms-one-third first">';
			$output .= '<div class="dtlms-settings-options-holder">';
				$output .= '<div class="dtlms-column dtlms-one-fifth first">';
					$output .= '<label>'.esc_html__( 'Primary Color', 'dtlms' ).'</label>';
				$output .= '</div>';
				$output .= '<div class="dtlms-column dtlms-four-fifth">';
		            $output .= '<input name="dtlms-skin-settings[primary-color]" class="dtlms-color-field color-picker" data-alpha-enabled="true" type="text" value="'.$primary_color.'" />';
		            $output .= '<p class="dtlms-note">'.esc_html__('Choose primary color module skin.', 'dtlms').'</p>';
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtlms-column dtlms-one-third">';
			$output .= '<div class="dtlms-settings-options-holder">';
				$output .= '<div class="dtlms-column dtlms-one-fifth first">';
					$output .= '<label>'.esc_html__( 'Secondary Color', 'dtlms' ).'</label>';
				$output .= '</div>';
				$output .= '<div class="dtlms-column dtlms-four-fifth">';
		            $output .= '<input name="dtlms-skin-settings[secondary-color]" class="dtlms-color-field color-picker" data-alpha-enabled="true" type="text" value="'.$secondary_color.'" />';
		            $output .= '<p class="dtlms-note">'.esc_html__('Choose secondary color module skin.', 'dtlms').'</p>';
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtlms-column dtlms-one-third">';
			$output .= '<div class="dtlms-settings-options-holder">';
				$output .= '<div class="dtlms-column dtlms-one-fifth first">';
					$output .= '<label>'.esc_html__( 'Tertiary Color', 'dtlms' ).'</label>';
				$output .= '</div>';
				$output .= '<div class="dtlms-column dtlms-four-fifth">';
		            $output .= '<input name="dtlms-skin-settings[tertiary-color]" class="dtlms-color-field color-picker" data-alpha-enabled="true" type="text" value="'.$tertiary_color.'" />';
		            $output .= '<p class="dtlms-note">'.esc_html__('Choose tertiary color module skin.', 'dtlms').'</p>';
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtlms-hr-invisible"></div>';

		$output .= '<div class="dtlms-column dtlms-one-third first">';
			$output .= '<div class="dtlms-settings-options-holder">';
				$output .= '<div class="dtlms-column dtlms-one-fifth first">';
					$output .= '<label>'.esc_html__( 'Primary Color - Alternate', 'dtlms' ).'</label>';
				$output .= '</div>';
				$output .= '<div class="dtlms-column dtlms-four-fifth">';
		            $output .= '<input name="dtlms-skin-settings[primary-alternate-color]" class="dtlms-color-field color-picker" data-alpha-enabled="true" type="text" value="'.$primary_alternate_color.'" />';
		            $output .= '<p class="dtlms-note">'.esc_html__('Choose primary alternate color module skin.', 'dtlms').'</p>';
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtlms-column dtlms-one-third">';
			$output .= '<div class="dtlms-settings-options-holder">';
				$output .= '<div class="dtlms-column dtlms-one-fifth first">';
					$output .= '<label>'.esc_html__( 'Secondary Color - Alternate', 'dtlms' ).'</label>';
				$output .= '</div>';
				$output .= '<div class="dtlms-column dtlms-four-fifth">';
		            $output .= '<input name="dtlms-skin-settings[secondary-alternate-color]" class="dtlms-color-field color-picker" data-alpha-enabled="true" type="text" value="'.$secondary_alternate_color.'" />';
		            $output .= '<p class="dtlms-note">'.esc_html__('Choose secondary alternate color module skin.', 'dtlms').'</p>';
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtlms-column dtlms-one-third">';
			$output .= '<div class="dtlms-settings-options-holder">';
				$output .= '<div class="dtlms-column dtlms-one-fifth first">';
					$output .= '<label>'.esc_html__( 'Tertiary Color - Alternate', 'dtlms' ).'</label>';
				$output .= '</div>';
				$output .= '<div class="dtlms-column dtlms-four-fifth">';
		            $output .= '<input name="dtlms-skin-settings[tertiary-alternate-color]" class="dtlms-color-field color-picker" data-alpha-enabled="true" type="text" value="'.$tertiary_alternate_color.'" />';
		            $output .= '<p class="dtlms-note">'.esc_html__('Choose tertiary alternate color module skin.', 'dtlms').'</p>';
				$output .= '</div>';
			$output .= '</div>';
		$output .= '</div>';

		$output .= '<div class="dtlms-hr-invisible"></div>';

		if (in_array('quiz', $dtlms_modules)) {

			$output .= '<div class="dtlms-column dtlms-one-third first">';
				$output .= '<div class="dtlms-settings-options-holder">';
					$output .= '<div class="dtlms-column dtlms-one-fifth first">';
						$output .= '<label>'.esc_html__( 'Quiz Timer - Foreground Color', 'dtlms' ).'</label>';
					$output .= '</div>';
					$output .= '<div class="dtlms-column dtlms-four-fifth">';
						$output .= '<input name="dtlms-skin-settings[quiztimer-foreground-color]" class="dtlms-color-field color-picker" data-alpha-enabled="true" type="text" value="'.$quiztimer_foreground_color.'" />';
						$output .= '<p class="dtlms-note">'.esc_html__('Choose quiz timer foreground color.', 'dtlms').'</p>';
					$output .= '</div>';
				$output .= '</div>';
			$output .= '</div>';

			$output .= '<div class="dtlms-column dtlms-one-third">';
				$output .= '<div class="dtlms-settings-options-holder">';
					$output .= '<div class="dtlms-column dtlms-one-fifth first">';
						$output .= '<label>'.esc_html__( 'Quiz Timer - Background Color', 'dtlms' ).'</label>';
					$output .= '</div>';
					$output .= '<div class="dtlms-column dtlms-four-fifth">';
						$output .= '<input name="dtlms-skin-settings[quiztimer-background-color]" class="dtlms-color-field color-picker" data-alpha-enabled="true" type="text" value="'.$quiztimer_background_color.'" />';
						$output .= '<p class="dtlms-note">'.esc_html__('Choose quiz timer background color.', 'dtlms').'</p>';
					$output .= '</div>';
				$output .= '</div>';
			$output .= '</div>';

			$output .= '<div class="dtlms-hr-invisible"></div>';

		}


		$output .= '<div class="dtlms-skin-settings-response-holder"></div>';

		$output .= '<a href="#" class="dtlms-button dtlms-save-skin-settings small">'.esc_html__('Save Settings', 'dtlms').'</a>';

	$output .= '</form>';

    return $output;

}

echo dtlms_settings_skin_content();

?>