<?php

if( !function_exists('livi_single_post_params_default') ) {
    function livi_single_post_params_default() {
        $params = array(
            'enable_title'   		 => 0,
            'enable_image_lightbox'  => 0,
            'enable_disqus_comments' => 0,
            'post_disqus_shortname'  => '',
            'post_dynamic_elements'  => array( 'content', 'author_bio', 'comment_box', 'navigation' ),
            'post_commentlist_style' => 'square',
            'select_post_navigation' => 'type3',
        );

        return $params;
    }
}

if( !function_exists('livi_single_post_misc_default') ) {
    function livi_single_post_misc_default() {
        $params = array(
            'enable_related_article'=> 0,
            'rposts_title'   		=> esc_html__('Related Posts', 'livi'),
            'rposts_column'         => 'one-third-column',
            'rposts_count'          => 3,
            'rposts_excerpt'        => 0,
            'rposts_excerpt_length' => 25,
            'rposts_carousel'       => 0,
            'rposts_carousel_nav'   => ''
        );

        return $params;
    }
}

if( !function_exists('livi_single_post_params') ) {
    function livi_single_post_params() {
        $params = livi_single_post_params_default();
        return apply_filters( 'livi_single_post_params', $params );
    }
}

add_action( 'livi_after_main_css', 'post_style' );
function post_style() {
    if( is_singular('post') || is_attachment() ) {
        wp_enqueue_style( 'livi-post', get_theme_file_uri('/modules/post/assets/css/post.css'), false, LIVI_THEME_VERSION, 'all');

        $post_style = livi_get_single_post_style( get_the_ID() );
        if ( file_exists( get_theme_file_path('/modules/post/templates/'.$post_style.'/assets/css/post-'.$post_style.'.css') ) ) {
            wp_enqueue_style( 'livi-post-'.$post_style, get_theme_file_uri('/modules/post/templates/'.$post_style.'/assets/css/post-'.$post_style.'.css'), false, LIVI_THEME_VERSION, 'all');
        }
    }
}

if( !function_exists('livi_get_single_post_style') ) {
	function livi_get_single_post_style( $post_id ) {
		return apply_filters( 'livi_single_post_style', 'minimal', $post_id );
	}
}

if( !function_exists('livi_breadcrumb_template_part') ) {
    function livi_breadcrumb_template_part($args, $post_id) {
        $post_style = livi_get_single_post_style( get_the_ID() );
        if(is_single($post_id) && $post_style == 'simple') {
           return;
        } else{
            echo livi_html_output($args);
        }
    }
    add_filter( 'livi_breadcrumb_get_template_part', 'livi_breadcrumb_template_part', 10, 2 );
}

if( ! function_exists( 'livi_breadcrumb_header_wrapper_classes' )  ) {
	function livi_breadcrumb_header_wrapper_classes($classes) {
        $post_id = get_the_ID();
        $post_style = livi_get_single_post_style( $post_id );
        if(is_single($post_id) && $post_style == 'simple') {
            array_push($classes, 'wdt-no-breadcrumb');
        }
        return $classes;
	}
	add_filter( 'livi_header_wrapper_classes', 'livi_breadcrumb_header_wrapper_classes', 10, 1 );
}

add_action( 'livi_after_main_css', 'livi_single_post_enqueue_css' );
if( !function_exists( 'livi_single_post_enqueue_css' ) ) {
    function livi_single_post_enqueue_css() {

        wp_enqueue_style( 'livi-magnific-popup', get_theme_file_uri('/modules/post/assets/css/magnific-popup.css'), false, LIVI_THEME_VERSION, 'all');
    }
}

add_action( 'livi_before_enqueue_js', 'livi_single_post_enqueue_js' );
if( !function_exists( 'livi_single_post_enqueue_js' ) ) {
    function livi_single_post_enqueue_js() {

        wp_enqueue_script('jquery-magnific-popup', get_theme_file_uri('/modules/post/assets/js/jquery.magnific-popup.js'), array(), false, true);
    }
}

add_filter('post_class', 'livi_single_set_post_class', 10, 3);
if( !function_exists('livi_single_set_post_class') ) {
    function livi_single_set_post_class( $classes, $class, $post_id ) {

        if( is_singular('post') || is_attachment() ) {
        	$classes[] = 'blog-single-entry';
        	$classes[] = 'post-'.livi_get_single_post_style( $post_id );
        }

        return $classes;
    }
}