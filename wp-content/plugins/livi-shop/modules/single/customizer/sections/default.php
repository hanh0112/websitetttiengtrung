<?php

/**
 * Listing Customizer - Product Single - Default Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Livi_Shop_Customizer_Single_Default' ) ) {

    class Livi_Shop_Customizer_Single_Default {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            add_filter( 'livi_woo_single_page_settings', array( $this, 'single_page_settings' ), 10, 1 );
            add_action( 'customize_register', array( $this, 'register' ), 40);
            add_action( 'livi_hook_content_before', array( $this, 'woo_handle_product_breadcrumb' ), 10);

        }

        function single_page_settings( $settings ) {

            $product_disable_breadcrumb                 = livi_customizer_settings('wdt-single-product-disable-breadcrumb' );
            $settings['product_disable_breadcrumb']     = $product_disable_breadcrumb;

            $product_title_breadcrumb                 = livi_customizer_settings('wdt-single-product-title-breadcrumb' );
            $settings['product_title_breadcrumb']     = $product_title_breadcrumb;

            return $settings;

        }

        function register( $wp_customize ) {

            /**
            * Option : Disable Breadcrumb
            */
                $wp_customize->add_setting(
                    LIVI_CUSTOMISER_VAL . '[wdt-single-product-disable-breadcrumb]', array(
                        'type' => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Livi_Customize_Control_Switch(
                        $wp_customize, LIVI_CUSTOMISER_VAL . '[wdt-single-product-disable-breadcrumb]', array(
                            'type'    => 'wdt-switch',
                            'label'   => esc_html__( 'Disable Breadcrumb', 'livi-shop'),
                            'section' => 'woocommerce-single-page-default-section',
                            'choices' => array(
                                'on'  => esc_attr__( 'Yes', 'livi-shop' ),
                                'off' => esc_attr__( 'No', 'livi-shop' )
                            )
                        )
                    )
                );

            /**
            * Option : Show Title in Breadcrumb
            */
                $wp_customize->add_setting(
                    LIVI_CUSTOMISER_VAL . '[wdt-single-product-title-breadcrumb]', array(
                        'type' => 'option',
                    )
                );

                $wp_customize->add_control(
                    new Livi_Customize_Control_Switch(
                        $wp_customize, LIVI_CUSTOMISER_VAL . '[wdt-single-product-title-breadcrumb]', array(
                            'type'    => 'wdt-switch',
                            'label'   => esc_html__( 'Product Title in Breadcrumb', 'livi-shop'),
                            'section' => 'woocommerce-single-page-default-section',
                            'choices' => array(
                                'on'  => esc_attr__( 'Yes', 'livi-shop' ),
                                'off' => esc_attr__( 'No', 'livi-shop' )
                            ),
                            'description'   => esc_html__('If you like to show title in breadcrumb section.', 'livi-shop')
                        )
                    )
                );

        }

        function woo_handle_product_breadcrumb() {

            if(is_product() && livi_customizer_settings('wdt-single-product-disable-breadcrumb' )) {
                remove_action('livi_breadcrumb', 'livi_breadcrumb_template');
            }

        }

    }

}


if( !function_exists('livi_shop_customizer_single_default') ) {
	function livi_shop_customizer_single_default() {
		return Livi_Shop_Customizer_Single_Default::instance();
	}
}

livi_shop_customizer_single_default();