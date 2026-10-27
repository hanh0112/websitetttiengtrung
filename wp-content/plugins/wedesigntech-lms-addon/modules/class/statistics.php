<?php

if(!function_exists('dtlms_statistics_update')) {
    function dtlms_statistics_update($tabs) {

        $current_user = wp_get_current_user();
        $current_user_id = $current_user->ID;

        if ( in_array( 'administrator', (array) $current_user->roles ) ) {

            $tabs['classes'] =  array (
                'label'    => sprintf( esc_html__( '%1$s', 'dtlms' ), DTLMS_CLASS_PLURAL_LABEL ),
                'callback' => 'dtlms_statistics_classes_content'
            );

         } else if ( in_array( 'instructor', (array) $current_user->roles ) ) {

            require_once DTLMS_PLUGIN_PATH . 'statistics/statistics-instructor.php';

            $tabs['myclasses'] = array (
                'label'      => sprintf( esc_html__( '%1$s', 'dtlms' ), DTLMS_CLASS_PLURAL_LABEL ),
                'callback'   => 'dtlms_statistics_myclasses_content'
            );

        }

        return $tabs;

    }
    add_filter ( 'dtlms_statistics', 'dtlms_statistics_update', 5, 1 );
}

if(!function_exists('dtlms_statistics_classes_content')) {
    function dtlms_statistics_classes_content() {
        echo do_shortcode('[dtlms_class_details enable-instructor-filter="true" /]');
    }
}

if(!function_exists('dtlms_statistics_myclasses_content')) {
    function dtlms_statistics_myclasses_content() {
        echo do_shortcode('[dtlms_class_details enable-instructor-filter="false" /]');
    }
}

if(!function_exists('dtlms_load_instructorwise_classes')) {
    function dtlms_load_instructorwise_classes() {

        $output = '';

        if($instructor_dashboard_id > 0) {
            $instructor_id = $instructor_dashboard_id;
        } else {
            $instructor_id = isset($_REQUEST['instructor_id']) ? dtlms_recursive_sanitize_text_field($_REQUEST['instructor_id']) : -1;
        }

        // Pagination script Start
        $ajax_call = (isset($_REQUEST['ajax_call']) && $_REQUEST['ajax_call'] == true) ? true : false;
        $current_page = isset($_REQUEST['current_page']) ? dtlms_recursive_sanitize_text_field($_REQUEST['current_page']) : 1;
        $offset = isset($_REQUEST['offset']) ? dtlms_recursive_sanitize_text_field($_REQUEST['offset']) : 0;
        $backend_postperpage = (dtlms_option('general','backend-postperpage') != '') ? dtlms_recursive_sanitize_text_field(dtlms_option('general','backend-postperpage')) : 10;
        $post_per_page = isset($_REQUEST['post_per_page']) ? dtlms_recursive_sanitize_text_field($_REQUEST['post_per_page']) : $backend_postperpage;

        if($dashboard_function_call != '') {
            $function_call = $dashboard_function_call;
        } else {
            $function_call = (isset($_REQUEST['function_call']) && $_REQUEST['function_call'] != '') ? dtlms_recursive_sanitize_text_field($_REQUEST['function_call']) : '';
        }

        if($dashboard_output_div != '') {
            $output_div = $dashboard_output_div;
        } else {
            $output_div = (isset($_REQUEST['output_div']) && $_REQUEST['output_div'] != '') ? dtlms_recursive_sanitize_text_field($_REQUEST['output_div']) : '';
        }
        // Pagination script End

        $class_singular_label = apply_filters( 'class_label', 'singular' );

        $args = array (
                    'offset' => $offset,
                    'paged' => $current_page,
                    'posts_per_page' => $post_per_page,
                    'post_type'=> 'dtlms_classes'
                );
        if($instructor_id > 0) {
            $args['author'] = $instructor_id;
        }

        $classes = get_posts( $args );

        $output .= '<div class="dtlms-custom-table-wrapper">';

            $output .= '<table border="0" cellpadding="0" cellspacing="0" class="dtlms-custom-table">
                            <thead>
                                <tr>
                                    <th>'.esc_html__('#', 'dtlms').'</th>
                                    <th>'.sprintf( esc_html__( '%1$s', 'dtlms' ), $class_singular_label ).'</th>
                                    <th>'.esc_html__('Courses Included', 'dtlms').'</th>
                                    <th>'.esc_html__('# Students', 'dtlms').'</th>
                                </tr>
                            </thead>
                            <tbody class="dtlms-custom-dashboard-table">';

            if(is_array($classes) && !empty($classes)) {

                $i = $offset+1;
                foreach ( $classes as $class ) {
                    setup_postdata( $class );

                    $class_id = $class->ID;
                    $class_title = get_the_title($class_id);
                    $author_id = $class->post_author;

                    $courses_included = get_post_meta($class_id, 'dtlms-class-courses', true);
                    $courses_included_html = '';
                    if(is_array($courses_included) && !empty($courses_included)) {
                        $courses_included_html .= '<ul>';
                        foreach($courses_included as $course_included) {
                            $courses_included_html .= '<li><a href="'.get_permalink($course_included).'">'.get_the_title($course_included).'</a></li>';
                        }
                        $courses_included_html .= '</ul>';
                    }


                    $purchased_users = get_post_meta($class_id, 'purchased_users', true);
                    $purchased_users = (is_array($purchased_users) && !empty($purchased_users)) ? $purchased_users : array ();

                    $purchased_users_html = '';
                    if(is_array($purchased_users) && !empty($purchased_users)) {
                        $purchased_users_html .= '<div class="dtlms-subscriber-tooltip"><i class="fas fa-eye"></i>';
                        $purchased_users_html .= '<div class="dtlms-subscription-detail-holder"><ul>';
                        foreach($purchased_users as $purchased_user) {
                            $purchased_users_html .= '<li><a href="#" class="dtlms-button filled small" data-classid="'.$class_id.'" data-userid="'.$purchased_user.'">'.get_the_author_meta('display_name', $purchased_user).'</a></li>';
                        }
                        $purchased_users_html .= '</ul></div></div>';
                    }

                    $output .= '<tr>
                                    <td>'.$i.'</td>
                                    <td>'.$class_title.'</td>
                                    <td>'.$courses_included_html.'</td>
                                    <td><p class="dtlms-statistics-count"><span>'.count($purchased_users).'</span></p>'.$purchased_users_html.'</td>
                                </tr>';

                    $i++;
                }

            } else {

                $output .= '<tr>
                                <td colspan="4">'.esc_html__('No records found!', 'dtlms').'</td>
                            </tr>';

            }

            $output .= '</tbody></table>';

        $output .= '</div>';

        wp_reset_postdata();


        // Pagination script Start
        $total_post_args = array (
                        'posts_per_page' => -1,
                        'post_type'=> 'dtlms_classes'
                    );
        if($instructor_id > 0) {
            $total_post_args['author'] = $instructor_id;
        }
        $total_post_classes = get_posts( $total_post_args );
        wp_reset_postdata();

        $classes_post_count = count($total_post_classes);
        $max_num_pages = ceil($classes_post_count / $post_per_page);

        $item_ids['instructor_id'] = $instructor_id;

        $output .= dtlms_ajax_pagination($max_num_pages, $current_page, $function_call, $output_div, $item_ids);
        // Pagination script End


        if($ajax_call) {

            echo dtlms_html_output($output);
            die();

        } else {

            return $output;

        }

    }
    add_action( 'wp_ajax_dtlms_load_instructorwise_classes', 'dtlms_load_instructorwise_classes' );
    add_action( 'wp_ajax_nopriv_dtlms_load_instructorwise_classes', 'dtlms_load_instructorwise_classes' );
}

?>