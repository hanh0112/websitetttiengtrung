<?php

/**
 * WooCommerce - Single - Module - 360 Viewer
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Livi_Shop_Single_Module_360_Viewer' ) ) {

    class Livi_Shop_Single_Module_360_Viewer {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            // Load Modules
                $this->load_modules();

        }

        /*
        Module Paths
        */

            function module_dir_path() {

                if( livi_is_file_in_theme( __FILE__ ) ) {
                    return LIVI_MODULE_DIR . '/woocommerce/single/modules/360-viewer/';
                } else {
                    return trailingslashit( plugin_dir_path( __FILE__ ) );
                }

            }

            function module_dir_url() {

                if( livi_is_file_in_theme( __FILE__ ) ) {
                    return LIVI_MODULE_URI . '/woocommerce/single/modules/360-viewer/';
                } else {
                    return trailingslashit( plugin_dir_url( __FILE__ ) );
                }

            }

        /*
        Load Modules
        */

            function load_modules() {

                // If Theme-Plugin is activated

                    if( function_exists( 'livi_pro' ) ) {

                        // Metabox
                            include_once $this->module_dir_path() . 'metabox/index.php';

                        // Customizer
                            include_once $this->module_dir_path() . 'customizer/index.php';

                        // Elementor
                            include_once $this->module_dir_path() . 'elementor/index.php';

                    }

                // Includes
                    include_once $this->module_dir_path() . 'includes/index.php';

            }

    }

}

if( !function_exists('livi_shop_single_module_360_viewer') ) {
	function livi_shop_single_module_360_viewer() {
		return Livi_Shop_Single_Module_360_Viewer::instance();
	}
}

livi_shop_single_module_360_viewer();