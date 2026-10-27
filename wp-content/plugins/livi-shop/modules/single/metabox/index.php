<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Livi_Shop_Single_Metabox_Options' ) ) {
    class Livi_Shop_Single_Metabox_Options {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'livi_shop_product_custom_settings', array( $this, 'livi_shop_product_custom_settings' ), 20 );
        }

        function livi_shop_product_custom_settings( $options ) {

			$product_options = array(

				# Product New Label
					array(
						'id'         => 'product-new-label',
						'type'       => 'switcher',
						'title'      => esc_html__('Add "New" label', 'livi-shop'),
					),

					array(
						'id'         => 'product-notes',
						'type'       => 'textarea',
						'title'      => esc_html__('Product Notes', 'livi-shop')
					)

			);

			$options = array_merge( $options, $product_options );

			return $options;

        }

    }
}

Livi_Shop_Single_Metabox_Options::instance();