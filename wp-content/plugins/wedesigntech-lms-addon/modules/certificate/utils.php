<?php

// Generate certifciate

if(!function_exists('dtlms_generate_certificate_content')) {
    function dtlms_generate_certificate_content() {

        $certificate_id = dtlms_recursive_sanitize_text_field($_REQUEST['certificate_id']);
        $course_id = dtlms_recursive_sanitize_text_field($_REQUEST['course_id']);
        $grade_id = dtlms_recursive_sanitize_text_field($_REQUEST['grade_id']);
        $user_id = dtlms_recursive_sanitize_text_field($_REQUEST['user_id']);

        if(class_exists( '\Elementor\Plugin' ) && \Elementor\Plugin::$instance->db->is_built_with_elementor($certificate_id)) {

            $content = \Elementor\Plugin::$instance->frontend->get_builder_content( $certificate_id );
            $output = '<div id="dtlmsPrintContent" class="dtlms-print-content">'.$content.'</div>';

        } else {

            if( defined( 'DOING_AJAX' ) && DOING_AJAX && class_exists('WPBMap') && method_exists('WPBMap', 'addAllMappedShortcodes') ) {
                WPBMap::addAllMappedShortcodes();
            }

            $content = apply_filters('the_content', get_post_field('post_content', $certificate_id));
            $output = '<div id="dtlmsPrintContent" class="dtlms-print-content">'.$content.'</div>';

        }

        echo dtlms_html_output($output);

        die();

    }
    add_action( 'wp_ajax_dtlms_generate_certificate_content', 'dtlms_generate_certificate_content' );
    add_action( 'wp_ajax_nopriv_dtlms_generate_certificate_content', 'dtlms_generate_certificate_content' );
}

?>