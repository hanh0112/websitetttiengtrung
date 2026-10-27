<?php

// General Settings

if(!function_exists('dtlms_general_settings_update')) {
    function dtlms_general_settings_update($tabs) {

        $class_title_singular = apply_filters( 'class_label', 'singular' );

        $tabs['general_class'] = array (
			'label'          =>  $class_title_singular,
			'callback'       => 'dtlms_get_class_settings_content'
		);

        return $tabs;

    }
    add_filter ( 'dtlms_general_settings', 'dtlms_general_settings_update', 5, 1 );
}

if(!function_exists('dtlms_get_class_settings_content')) {
    function dtlms_get_class_settings_content() {

        $instructor_singular_label = apply_filters( 'instructor_label', 'singular' );

        $class_singular_label = apply_filters( 'class_label', 'singular' );
        $class_plural_label = apply_filters( 'class_label', 'plural' );

        $output = '';

        $output .= '<form name="formOptionSettings" class="formOptionSettings" method="post">';

            $output .= '<div class="dtlms-settings-options-holder">';
                $output .= '<div class="dtlms-column dtlms-one-fifth first">';
                    $output .= '<label>'.sprintf( esc_html__( '%1$s Singular Label', 'dtlms' ), $class_singular_label ).'</label>';
                $output .= '</div>';
                $output .= '<div class="dtlms-column dtlms-four-fifth">';
                    $output .= '<input id="class-title-singular" name="dtlms[class][class-title-singular]" type="text" value="'.$class_singular_label.'" />';
                    $output .= '<p class="dtlms-note">'.esc_html__('You can replace the "Class" label as per your requirement.', 'dtlms').'</p>';
                $output .= '</div>';
            $output .= '</div>';

            $output .= '<div class="dtlms-settings-options-holder">';
                $output .= '<div class="dtlms-column dtlms-one-fifth first">';
                    $output .= '<label>'.sprintf( esc_html__( '%1$s Plural Label', 'dtlms' ), $class_plural_label ).'</label>';
                $output .= '</div>';
                $output .= '<div class="dtlms-column dtlms-four-fifth">';
                    $output .= '<input id="class-title-plural" name="dtlms[class][class-title-plural]" type="text" value="'.$class_plural_label.'" />';
                    $output .= '<p class="dtlms-note">'.esc_html__('You can replace the "Classes" label as per your requirement.', 'dtlms').'</p>';
                $output .= '</div>';
            $output .= '</div>';

            $output .= '<div class="dtlms-settings-options-holder">';
                $output .= '<div class="dtlms-column dtlms-one-fifth first">';
                    $output .= '<label>'.sprintf( esc_html__( 'Enable Count Down Timer - %1$s Start Date', 'dtlms' ), $class_singular_label ).'</label>';
                $output .= '</div>';
                $output .= '<div class="dtlms-column dtlms-four-fifth">';
                    $checked = ( 'true' ==  dtlms_option('class','enable-countdown-timer-class-startdate') ) ? ' checked="checked"' : '';
                    $switchclass = ( 'true' ==  dtlms_option('class','enable-countdown-timer-class-startdate') ) ? 'checkbox-switch-on' :'checkbox-switch-off';
                    $output .= '<div data-for="enable-countdown-timer-class-startdate" class="dtlms-checkbox-switch '.$switchclass.'"></div>';
                    $output .= '<input id="enable-countdown-timer-class-startdate" class="hidden" type="checkbox" name="dtlms[class][enable-countdown-timer-class-startdate]" value="true" '.$checked.' />';
                    $output .= '<p class="dtlms-note">'.sprintf( esc_html__( 'If you like to enable count down timer for %1$s start date.', 'dtlms' ), strtolower($class_singular_label) ).'</p>';
                $output .= '</div>';
            $output .= '</div>';

            $output .= '<div class="dtlms-settings-options-holder">';
                $output .= '<div class="dtlms-column dtlms-one-fifth first">';
                    $output .= '<label>'.sprintf( esc_html__( 'Enable Contact %1$s Options In %2$s Page', 'dtlms' ), $instructor_singular_label, $class_singular_label ).'</label>';
                $output .= '</div>';
                $output .= '<div class="dtlms-column dtlms-four-fifth">';
                    $checked = ( 'true' ==  dtlms_option('class','contact-instructor-in-classpage') ) ? ' checked="checked"' : '';
                    $switchclass = ( 'true' ==  dtlms_option('class','contact-instructor-in-classpage') ) ? 'checkbox-switch-on' :'checkbox-switch-off';
                    $output .= '<div data-for="contact-instructor-in-classpage" class="dtlms-checkbox-switch '.$switchclass.'"></div>';
                    $output .= '<input id="contact-instructor-in-classpage" class="hidden" type="checkbox" name="dtlms[class][contact-instructor-in-classpage]" value="true" '.$checked.' />';
                    $output .= '<p class="dtlms-note">'.sprintf( esc_html__( 'It allows student to send private message and email to %1$s', 'dtlms' ), $instructor_singular_label ).'</p>';
                $output .= '</div>';
            $output .= '</div>';

            $output .= '<div class="dtlms-settings-options-holder">';
                $output .= '<div class="dtlms-column dtlms-one-fifth first">';
                    $output .= '<label>'.sprintf( esc_html__( '%1$s Registration - Without Login', 'dtlms' ), $class_singular_label ).'</label>';
                $output .= '</div>';
                $output .= '<div class="dtlms-column dtlms-four-fifth">';
                    $checked = ( 'true' ==  dtlms_option('class','class-registration-without-login') ) ? ' checked="checked"' : '';
                    $switchclass = ( 'true' ==  dtlms_option('class','class-registration-without-login') ) ? 'checkbox-switch-on' :'checkbox-switch-off';
                    $output .= '<div data-for="class-registration-without-login" class="dtlms-checkbox-switch '.$switchclass.'"></div>';
                    $output .= '<input id="class-registration-without-login" class="hidden" type="checkbox" name="dtlms[class][class-registration-without-login]" value="true" '.$checked.' />';
                    $output .= '<p class="dtlms-note">'.sprintf( esc_html__( 'Allow user to apply for onsite %1$s without loggin in..', 'dtlms' ), $class_singular_label ).'</p>';
                $output .= '</div>';
            $output .= '</div>';

            $output .= '<div class="dtlms-settings-options-holder">';
                $output .= '<div class="dtlms-column dtlms-one-fifth first">';
                    $output .= '<label>'.sprintf( esc_html__( 'Include %1$s In Commission', 'dtlms' ), $class_singular_label ).'</label>';
                $output .= '</div>';
                $output .= '<div class="dtlms-column dtlms-four-fifth">';
                    $checked = ( 'true' ==  dtlms_option('class','include-class-in-commission') ) ? ' checked="checked"' : '';
                    $switchclass = ( 'true' ==  dtlms_option('class','include-class-in-commission') ) ? 'checkbox-switch-on' :'checkbox-switch-off';
                    $output .= '<div data-for="include-class-in-commission" class="dtlms-checkbox-switch '.$switchclass.'"></div>';
                    $output .= '<input id="include-class-in-commission" class="hidden" type="checkbox" name="dtlms[class][include-class-in-commission]" value="true" '.$checked.' />';
                    $output .= '<p class="dtlms-note">'.sprintf( esc_html__( 'If you like to include %1$s in commission settings choose "Yes"', 'dtlms' ), $class_plural_label ).'</p>';
                $output .= '</div>';
            $output .= '</div>';


            $output .= '<div class="dtlms-option-settings-response-holder"></div>';

            $output .= '<a href="#" class="dtlms-button dtlms-save-options-settings small" data-settings="class">'.esc_html__('Save Settings', 'dtlms').'</a>';

        $output .= '</form>';

        return $output;

    }
}


// Assigning Settings

require_once DTLMS_CLASS_PLUGIN_PATH . 'settings/settings-assigning-utils.php';

if(!function_exists('dtlms_assigning_settings_update')) {
    function dtlms_assigning_settings_update($tabs) {

        $class_title_singular = apply_filters( 'class_label', 'singular' );
        $class_title_plural = apply_filters( 'class_label', 'plural' );

        $tabs['classes_assign_students'] = array (
            'label' => sprintf( esc_html__( '%1$s - Assign students', 'dtlms' ), $class_title_singular ),
            'path'  => DTLMS_CLASS_PLUGIN_PATH . 'settings/settings-assigning-cla-students.php'
        );
        $tabs['classes_assign_classes']  = array (
            'label' => sprintf( esc_html__( '%1$s - Assign %2$s', 'dtlms' ), $class_title_singular, strtolower($class_title_plural) ),
            'path'  => DTLMS_CLASS_PLUGIN_PATH . 'settings/settings-assigning-cla-classes.php'
        );

        return $tabs;

    }
    add_filter ( 'dtlms_assigning_settings', 'dtlms_assigning_settings_update', 5, 1 );
}


// POC Settings

require_once DTLMS_CLASS_PLUGIN_PATH . 'settings/settings-poc-utils.php';

?>