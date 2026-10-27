<?php

/**
 * Customizer - Product Single Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Livi_Shop_Customizer_Single' ) ) {

    class Livi_Shop_Customizer_Single {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            // Load Sections
                $this->load_sections();

        }

        /*
        Load Sections
        */

            function load_sections() {

                foreach( glob( LIVI_SHOP_MODULE_PATH. 'single/customizer/sections/*.php' ) as $module ) {
                    include_once $module;
                }

            }


    }

}


if( !function_exists('livi_shop_customizer_single') ) {
	function livi_shop_customizer_single() {
		return Livi_Shop_Customizer_Single::instance();
	}
}

livi_shop_customizer_single();