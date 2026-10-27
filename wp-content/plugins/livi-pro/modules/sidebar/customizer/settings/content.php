<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'LiviProWidgetContentSettings' ) ) {
    class LiviProWidgetContentSettings {

        private static $_instance = null;
        private $settings         = null;
        private $selector         = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            $this->selector = apply_filters( 'livi_widget_content_selector', array( '.secondary-sidebar .widget' ) );
            $this->settings = livi_customizer_settings('widget_content_typo');

            add_filter( 'livi_pro_customizer_default', array( $this, 'default' ) );
            add_action( 'customize_register', array( $this, 'register' ), 15);

            add_filter( 'livi_google_fonts_list', array( $this, 'fonts_list' ) );
            add_filter( 'livi_add_inline_style', array( $this, 'base_style' ) );
            add_filter( 'livi_add_tablet_landscape_inline_style', array( $this, 'tablet_landscape_style' ) );
            add_filter( 'livi_add_tablet_portrait_inline_style', array( $this, 'tablet_portrait' ) );
            add_filter( 'livi_add_mobile_res_inline_style', array( $this, 'mobile_style' ) );
        }

        function default( $option ) {
            $option['widget_content_color']         = '';
            $option['widget_content_a_color']       = '';
            $option['widget_content_a_hover_color'] = '';
            $option['widget_content_typo']          = array();
            return $option;
        }

        function register( $wp_customize ){

            /**
             * Option : Content Color
             */
            $wp_customize->add_setting(
                LIVI_CUSTOMISER_VAL . '[widget_content_color]', array(
                    'type'    => 'option',
                )
            );

            $wp_customize->add_control(
                new Livi_Customize_Control_Color(
                    $wp_customize, LIVI_CUSTOMISER_VAL . '[widget_content_color]', array(
                        'section' => 'site-widgets-content-style-section',
                        'label'   => esc_html__( 'Content Color', 'livi-pro' ),
                    )
                )
            );

            /**
             * Option : Content Anchor Color
             */
            $wp_customize->add_setting(
                LIVI_CUSTOMISER_VAL . '[widget_content_a_color]', array(
                    'type'    => 'option',
                )
            );

            $wp_customize->add_control(
                new Livi_Customize_Control_Color(
                    $wp_customize, LIVI_CUSTOMISER_VAL . '[widget_content_a_color]', array(
                        'section' => 'site-widgets-content-style-section',
                        'label'   => esc_html__( 'Content Link Color', 'livi-pro' ),
                    )
                )
            );

            /**
             * Option : Content Anchor Hover Color
             */
            $wp_customize->add_setting(
                LIVI_CUSTOMISER_VAL . '[widget_content_a_hover_color]', array(
                    'type'    => 'option',
                )
            );

            $wp_customize->add_control(
                new Livi_Customize_Control_Color(
                    $wp_customize, LIVI_CUSTOMISER_VAL . '[widget_content_a_hover_color]', array(
                        'section' => 'site-widgets-content-style-section',
                        'label'   => esc_html__( 'Content Link Hover Color', 'livi-pro' ),
                    )
                )
            );

            /**
             * Option :Content Typo
             */
            $wp_customize->add_setting(
                LIVI_CUSTOMISER_VAL . '[widget_content_typo]', array(
                    'type' => 'option',
                )
            );

            $wp_customize->add_control(
                new Livi_Customize_Control_Typography(
                    $wp_customize, LIVI_CUSTOMISER_VAL . '[widget_content_typo]', array(
                        'type'    => 'wdt-typography',
                        'section' => 'site-widgets-content-style-section',
                        'label'   => esc_html__( 'Content Typography', 'livi-pro'),
                    )
                )
            );

        }

        function fonts_list( $fonts ) {
            return livi_customizer_frontend_font( $this->settings, $fonts );
        }

        function base_style( $style ) {
            $css   = '';
            $color = livi_customizer_settings('widget_content_color');

            $css .= livi_customizer_typography_settings( $this->settings );
            $css .= livi_customizer_color_settings( $color );

            $css = livi_customizer_dynamic_style( $this->selector, $css );

            $a_color = livi_customizer_settings('widget_content_a_color');
            $a_color = livi_customizer_color_settings( $a_color );
            if(!empty( $a_color ) ) {
                $css .= livi_customizer_dynamic_style( '.secondary-sidebar .widget a, .secondary-sidebar .widget ul li a', $a_color );
            }

            $a_h_color = livi_customizer_settings('widget_content_a_hover_color');
            $a_h_color = livi_customizer_color_settings( $a_h_color );
            if(!empty( $a_h_color ) ) {
                $css .= livi_customizer_dynamic_style( '.secondary-sidebar .widget a:hover, .secondary-sidebar .widget ul li a:hover', $a_h_color );
            }

            return $style.$css;
        }

        function tablet_landscape_style( $style ) {
            $css = livi_customizer_responsive_typography_settings( $this->settings, 'tablet-ls' );
            $css = livi_customizer_dynamic_style( $this->selector, $css );

            return $style.$css;
        }

        function tablet_portrait( $style ) {
            $css = livi_customizer_responsive_typography_settings( $this->settings, 'tablet' );
            $css = livi_customizer_dynamic_style( $this->selector, $css );

            return $style.$css;
        }

        function mobile_style( $style ) {
            $css = livi_customizer_responsive_typography_settings( $this->settings, 'mobile' );
            $css = livi_customizer_dynamic_style( $this->selector, $css );

            return $style.$css;
        }
    }
}

LiviProWidgetContentSettings::instance();