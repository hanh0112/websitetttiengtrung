<?php

/**
 * Listing Framework Hook Settings
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Livi_Woo_Listing_Fw_Archive_Hook_Settings' ) ) {

    class Livi_Woo_Listing_Fw_Archive_Hook_Settings {

        private static $_instance = null;

        private $shop_custom_options = array ();

        function __construct($shop_custom_options) {

            $this->shop_custom_options = $shop_custom_options;

            remove_action( 'livi_hook_sections_before', array (livi_woo_listing_fw_hooks_settings(), 'woo_hook_sections_before'), 10 );
            remove_action( 'livi_hook_sections_after', array (livi_woo_listing_fw_hooks_settings(), 'woo_hook_sections_after'), 10 );
            remove_action( 'livi_woo_before_products_loop', array (livi_woo_listing_fw_hooks_settings(), 'woo_before_products_loop'), 15 );
            remove_action( 'livi_woo_after_products_loop', array (livi_woo_listing_fw_hooks_settings(), 'woo_after_products_loop'), 5 );

            add_action( 'livi_hook_sections_before', array ( $this, 'woo_hook_sections_before' ), 10 );
            add_action( 'livi_hook_sections_after', array ( $this, 'woo_hook_sections_after' ), 10 );
            add_action( 'livi_woo_before_products_loop', array ( $this, 'woo_before_products_loop' ), 15 );
            add_action( 'livi_woo_after_products_loop', array ( $this, 'woo_after_products_loop' ), 5 );

        }


        function woo_hook_sections_before() {

            $output = '';

            if(is_shop()) {
                if(isset($this->shop_custom_options['product-hook-page-top']) && !empty($this->shop_custom_options['product-hook-page-top'])) {
                    $frontend = Elementor\Frontend::instance();
                    $output .= $frontend->get_builder_content( $this->shop_custom_options['product-hook-page-top'], true );
                }
            }

            echo livi_html_output($output);

        }

        function woo_hook_sections_after() {

            $output = '';

            if(is_shop()) {
                if(isset($this->shop_custom_options['product-hook-page-bottom']) && !empty($this->shop_custom_options['product-hook-page-bottom'])) {
                    $frontend = Elementor\Frontend::instance();
                    $output .= $frontend->get_builder_content( $this->shop_custom_options['product-hook-page-bottom'], true );
                }
            }

            echo livi_html_output($output);

        }

        function woo_before_products_loop() {

            $output = '';

            if(is_shop()) {
                if(isset($this->shop_custom_options['product-hook-content-top']) && !empty($this->shop_custom_options['product-hook-content-top'])) {
                    $frontend = Elementor\Frontend::instance();
                    $output .= $frontend->get_builder_content( $this->shop_custom_options['product-hook-content-top'], true );
                }
            }

            echo livi_html_output($output);

        }

        function woo_after_products_loop() {

            $output = '';

            if(is_shop()) {
                if(isset($this->shop_custom_options['product-hook-content-bottom']) && !empty($this->shop_custom_options['product-hook-content-bottom'])) {
                    $frontend = Elementor\Frontend::instance();
                    $output .= $frontend->get_builder_content( $this->shop_custom_options['product-hook-content-bottom'], true );
                }
            }

            echo livi_html_output($output);

        }


    }

}