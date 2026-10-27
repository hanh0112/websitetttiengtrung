<?php
/**
 * Listing Options - Image Effect
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Livi_Woo_Listing_Option_Content_Button_Element_button' ) ) {

    class Livi_Woo_Listing_Option_Content_Button_Element_button extends Livi_Woo_Listing_Option_Core {

        private static $_instance = null;

        public $option_slug;

        public $option_name;

        public $option_type;

        public $option_default_value;

        public $option_value_prefix;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {

            $this->option_slug          = 'product-content-buttonelement-button';
            $this->option_name          = esc_html__('Button Element - Button', 'livi');
            $this->option_type          = array ( 'html', 'value-css' );
            $this->option_default_value = '';
            $this->option_value_prefix  = '';

            $this->render_backend();
        }

        /**
         * Backend Render
         */
        function render_backend() {
            add_filter( 'livi_woo_custom_product_template_content_options', array( $this, 'woo_custom_product_template_content_options'), 30, 1 );
        }

        /**
         * Custom Product Templates - Options
         */
        function woo_custom_product_template_content_options( $template_options ) {

            array_push( $template_options, $this->setting_args() );

            return $template_options;
        }

        /**
         * Settings Group
         */
        function setting_group() {
            return 'content';
        }

        /**
         * Setting Args
         */
        function setting_args() {
            $settings            =  array ();
            $settings['id']      =  $this->option_slug;
            $settings['type']    =  'select';
            $settings['title']   =  $this->option_name;
            $settings['options'] =  array (
                ''                   => esc_html__('None', 'livi'),
                'cart'               => esc_html__('Cart', 'livi'),
                'cart-with-quantity' => esc_html__('Cart With Quantity', 'livi'),
                'wishlist'           => esc_html__('Wishlist', 'livi'),
                'compare'            => esc_html__('Compare', 'livi'),
                'quickview'          => esc_html__('Quick View', 'livi')
            );
            $settings['default']    =  $this->option_default_value;

            return $settings;
        }
    }

}

if( !function_exists('livi_woo_listing_option_content_buttonelement_button') ) {
	function livi_woo_listing_option_content_buttonelement_button() {
		return Livi_Woo_Listing_Option_Content_Button_Element_button::instance();
	}
}

livi_woo_listing_option_content_buttonelement_button();