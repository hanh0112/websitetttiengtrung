<?php

if( ! function_exists('livi_event_breadcrumb_title') ) {
    function livi_event_breadcrumb_title($title) {
        if( get_post_type() == 'tribe_events' && is_single()) {
            $etitle = esc_html__( 'Event Detail', 'livi' );
            return '<h1>'.$etitle.'</h1>';
        } else {
            return $title;
        }
    }

    add_filter( 'livi_breadcrumb_title', 'livi_event_breadcrumb_title', 20, 1 );
}

?>