<?php

/**
 * WooCommerce - Single - Module - Ajax Cart - Customizer Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Livi_Shop_Customizer_Single_Ajax_Cart' ) ) {

    class Livi_Shop_Customizer_Single_Ajax_Cart {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            add_filter( 'livi_woo_single_page_settings', array( $this, 'single_page_settings' ), 10, 1 );
            add_action( 'customize_register', array( $this, 'register' ), 15);

        }

        function single_page_settings( $settings ) {

            $product_enable_ajax_addtocart             = livi_customizer_settings('wdt-single-product-enable-ajax-addtocart' );
            $settings['product_enable_ajax_addtocart'] = $product_enable_ajax_addtocart;

            return $settings;

        }

        function register( $wp_customize ) {

            /**
            * Option : Enable Ajax Add To Cart
            */
                $wp_customize->add_setting(
                    LIVI_CUSTOMISER_VAL . '[wdt-single-product-enable-ajax-addtocart]', array(
                        'type' => 'option'
                    )
                );

                $wp_customize->add_control(
                    new Livi_Customize_Control_Switch(
                        $wp_customize, LIVI_CUSTOMISER_VAL . '[wdt-single-product-enable-ajax-addtocart]', array(
                            'type'    => 'wdt-switch',
                            'label'   => esc_html__( 'Enable Ajax Add To Cart', 'livi-pro'),
                            'section' => 'woocommerce-single-page-default-section',
                            'choices' => array(
                                'on'  => esc_attr__( 'Yes', 'livi-pro' ),
                                'off' => esc_attr__( 'No', 'livi-pro' )
                            )
                        )
                    )
                );

        }

    }

}


if( !function_exists('livi_shop_customizer_single_ajax_cart') ) {
	function livi_shop_customizer_single_ajax_cart() {
		return Livi_Shop_Customizer_Single_Ajax_Cart::instance();
	}
}

livi_shop_customizer_single_ajax_cart();