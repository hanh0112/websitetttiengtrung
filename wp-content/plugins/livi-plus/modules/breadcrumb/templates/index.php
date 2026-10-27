<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'LiviPlusBCTemplate' ) ) {
    class LiviPlusBCTemplate {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            $this->load_frontend();
        }

        function load_frontend() {
            add_filter( 'livi_breadcrumb_params', array( $this, 'register_breadcrumb_params' ) );
            add_filter( 'livi_breadcrumb_get_template_part', array( $this, 'register_template' ), 10, 2 );

            add_action( 'livi_after_main_css', array( $this, 'enqueue_assets' ) );

            add_filter( 'livi_header_wrapper_classes', array( $this, 'register_header_class' ), 20, 1 );
        }

        function register_header_class($classes) {

            $breadcrumb_position = livi_customizer_settings('breadcrumb_position');
            $dark_bg_breadcrumb = livi_customizer_settings('enable_dark_bg_breadcrumb');

            if( is_singular() ) {

                $post_id = get_the_ID();
                $bc_meta = $this->register_meta_params( $post_id );

                if( array_key_exists( 'layout', $bc_meta ) && $bc_meta['layout'] == 'individual-option' ) {
                    $breadcrumb_position = $bc_meta['position'];
                    $dark_bg_breadcrumb = (isset($bc_meta['enable_dark_bg']) && $bc_meta['enable_dark_bg']) ? true : false;
                } else if( array_key_exists( 'layout', $bc_meta ) && $bc_meta['layout'] == 'disable' ) {
                    $dark_bg_breadcrumb = false;
                }

            }

            unset($classes[array_search('header-top-absolute', $classes)]);
            unset($classes[array_search('header-top-relative', $classes)]);
            if(!in_array($breadcrumb_position, $classes)) {
                array_push($classes, $breadcrumb_position);
            }

            if($dark_bg_breadcrumb) {
                if(!in_array('wdt-dark-bg', $classes) && $breadcrumb_position == 'header-top-absolute') {
                    array_push($classes, 'wdt-dark-bg');
                } else if($breadcrumb_position == 'header-top-relative') {
                    unset($classes[array_search('wdt-dark-bg', $classes)]);
                }
            } else {
                unset($classes[array_search('wdt-dark-bg', $classes)]);
            }

            return $classes;

        }

        function enqueue_assets() {
            wp_enqueue_style( 'site-breadcrumb', LIVI_PLUS_DIR_URL . 'modules/breadcrumb/assets/css/breadcrumb.css', LIVI_PLUS_VERSION );
        }

        function base_meta_style( $meta ) {

            $bg_meta = array_key_exists( 'background', $meta ) ? $meta['background'] : array();

            $style = '';
            $bg = array();

            $bg['background-image']      = array_key_exists( 'image' , $bg_meta ) ? $bg_meta['image'] : '';
            $bg['background-repeat']     = array_key_exists( 'repeat' , $bg_meta ) ? $bg_meta['repeat'] : '';
            $bg['background-position']   = array_key_exists( 'position' , $bg_meta ) ? $bg_meta['position'] : '';
            $bg['background-attachment'] = array_key_exists( 'attachment' , $bg_meta ) ? $bg_meta['attachment'] : '';
            $bg['background-size']       = array_key_exists( 'size' , $bg_meta ) ? $bg_meta['size'] : '';
            $bg['background-color']      = array_key_exists( 'color' , $bg_meta ) ? $bg_meta['color'] : '';

            $bg_css         = livi_customizer_bg_settings( $bg );
            $enable_overlay = array_key_exists( 'enable_overlay', $meta ) ? $meta['enable_overlay'] : 0;
            $gradient_color = array_key_exists( 'gradient_color', $meta ) ? $meta['gradient_color'] : '';
            $bg['gradient-background-color'] = isset($gradient_color) ? $gradient_color : '';

            if( !empty( $bg_css ) && empty( $enable_overlay ) ) {

                $style .= livi_customizer_dynamic_style( '.main-title-section-wrapper.overlay-wrapper.dark-bg-breadcrumb > .main-title-section-bg, .main-title-section-wrapper.overlay-wrapper > .main-title-section-bg, .main-title-section-wrapper.dark-bg-breadcrumb > .main-title-section-bg, .main-title-section-wrapper > .main-title-section-bg', $bg_css );

            } elseif( !empty( $enable_overlay ) ) {

                $overlay_color = array_key_exists( 'background-color', $bg ) ? $bg['background-color'] : '';
                $overlay_gradient_color = array_key_exists( 'gradient-background-color', $bg ) ? $bg['gradient-background-color'] : '';
                $bg['background-color'] = '';
                $bg['gradient-background-color'] = '';

                $bg_css = livi_customizer_bg_settings( $bg );

                if( !empty( $bg_css ) ) {
                    $style .= livi_customizer_dynamic_style( '.main-title-section-wrapper.overlay-wrapper.dark-bg-breadcrumb > .main-title-section-bg, .main-title-section-wrapper.overlay-wrapper > .main-title-section-bg, .main-title-section-wrapper.dark-bg-breadcrumb > .main-title-section-bg, .main-title-section-wrapper > .main-title-section-bg', $bg_css );
                }

                if( !empty( $overlay_color ) || !empty( $overlay_gradient_color ) ) {
                    $bg_css = livi_customizer_bg_settings( array( 'background-color' => $overlay_color, 'gradient-background-color' => $overlay_gradient_color, 'breadcrumb_overlay_bg_color' => true ) );
                    $style .= livi_customizer_dynamic_style( '.main-title-section-wrapper.overlay-wrapper.dark-bg-breadcrumb > .main-title-section-bg:after, .main-title-section-wrapper.overlay-wrapper > .main-title-section-bg:after, .main-title-section-wrapper.dark-bg-breadcrumb > .main-title-section-bg:after, .main-title-section-wrapper > .main-title-section-bg:after', $bg_css );
                }

            }

            if( !empty( $style ) ){
                wp_register_style( 'livi-breadcrumb-inline', '', array (), LIVI_PLUS_VERSION, 'all' );
                wp_enqueue_style( 'livi-breadcrumb-inline' );
                wp_add_inline_style( 'livi-breadcrumb-inline', $style );
            }
        }

        function register_breadcrumb_params() {

            $enable_delimiter = livi_customizer_settings( 'change_breadcrumb_delimiter' );
            $delimiter        = livi_customizer_settings( 'breadcrumb_delimiter' );

            $delimiter = ( $enable_delimiter ) ? '<span class="'.esc_attr($delimiter).'"></span>' : '<span class="breadcrumb-default-delimiter"></span>';

            $wrapper_class    = array();
            $enable_darkbg    = livi_customizer_settings( 'enable_dark_bg_breadcrumb' );
            $breadcrumb_style = livi_customizer_settings( 'breadcrumb_style' );

            if( $enable_darkbg ) {
                $wrapper_class[] = 'dark-bg-breadcrumb';
            }

            $wrapper_class[] = $breadcrumb_style;

            $bc_overlay_bg_color = livi_customizer_settings( 'breadcrumb_overlay_bg_color' );
            if($bc_overlay_bg_color) {
                $wrapper_class[] = 'overlay-wrapper';
            }

            $hide_content    = livi_customizer_settings( 'hide_content' );
            if( $hide_content ) {
                $wrapper_class[] = 'hide-content';
            }

            $params = array(
                'home'             => esc_html__( 'Home', 'livi-plus' ),
                'home_link'        => home_url('/'),
                'delimiter'        => $delimiter,
                'wrapper_classes'  => implode( ' ', $wrapper_class )
            );

            return $params;
        }

        function register_meta_params( $post_id ) {

            $post_meta = get_post_meta( $post_id, '_livi_breadcrumb_settings', true );
            $post_meta = is_array( $post_meta ) ? $post_meta : array();

            return $post_meta;
        }

        function register_post_meta_params( $post_id ) {

            $post_meta = get_post_meta( $post_id, '_livi_post_settings', true );
            $post_meta = is_array( $post_meta ) ? $post_meta : array();

            return $post_meta;
        }

        function register_template( $args, $post_id ) {

            $post_meta = $this->register_post_meta_params( $post_id );
            if( isset($post_meta['single_post_style']) && $post_meta['single_post_style'] == 'simple') {
                return;
            }

            $style         = '';

            $template_args = $this->register_breadcrumb_params();
            $bc_meta       = $this->register_meta_params( $post_id );

            if( empty($bc_meta) || ( array_key_exists( 'layout', $bc_meta ) && $bc_meta['layout'] != 'disable' ) ) {

                if( array_key_exists( 'layout', $bc_meta ) && $bc_meta['layout'] == 'individual-option' ) {

                    $wrapper_class    = array();
                    $enable_darkbg    = array_key_exists( 'enable_dark_bg', $bc_meta ) ? $bc_meta['enable_dark_bg'] : '';
                    $breadcrumb_style = livi_customizer_settings( 'breadcrumb_style' );

                    if( $enable_darkbg ) {
                        $wrapper_class[] = 'dark-bg-breadcrumb';
                    }

                    $wrapper_class[] = $breadcrumb_style;

                    if(array_key_exists( 'enable_overlay', $bc_meta ) && $bc_meta['enable_overlay']) {
                        $wrapper_class[] = 'overlay-wrapper';
                    }

                    $hide_content = (array_key_exists( 'hide_content', $bc_meta ) && !empty($bc_meta['hide_content'])) ? true : false;
                    if( $hide_content ) {
                        $wrapper_class[] = 'hide-content';
                    }

                    $template_args['wrapper_classes'] = implode( ' ', $wrapper_class );
                    $this->base_meta_style( $bc_meta );

                } else {
                    $enable_bc = livi_customizer_settings( 'enable_breadcrumb' );
                    if( ! $enable_bc ) {
                        return;
                    }
                }

                $bc_source = livi_customizer_settings( 'breadcrumb_source' );

                switch( $bc_source ):

                    case 'default':
                    default:
                        livi_template_part( 'breadcrumb', 'templates/default/title-content', '', $template_args );
                    break;

                endswitch;
            } else {
                $enable_bc = livi_customizer_settings( 'enable_breadcrumb' );
                if( ! $enable_bc ) {
                    return;
                }
            }

        }

    }
}

LiviPlusBCTemplate::instance();