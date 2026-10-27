<?php
/**
 * Plugin Name:	Livi Shop
 * Description: Adds shop features for Livi Theme.
 * Version: 1.0.0
 * Author: the WeDesignTech team
 * Author URI: https://wedesignthemes.com/
 * Text Domain: livi-shop
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * The main class that initiates and runs the plugin.
 */
final class Livi_Shop {

	/**
	 * Instance variable
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Constructor
	 */
	public function __construct() {

		add_action( 'init', array( $this, 'livi_shop_i18n' ) );
		add_filter( 'livi_required_plugins_list', array( $this, 'upadate_required_plugins_list' ) );
		add_action( 'plugins_loaded', array( $this, 'livi_shop_plugins_loaded' ) );

	}

	/**
	 * Load Textdomain
	 */
		public function livi_shop_i18n() {

			load_plugin_textdomain( 'livi-shop', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
		}

	/**
	 * Update required plugins list
	 */
		function upadate_required_plugins_list($plugins_list) {

            $required_plugins = array(
                array(
                    'name'				=> 'WooCommerce',
                    'slug'				=> 'woocommerce',
                    'required'			=> true,
                    'force_activation'	=> false,
                )
            );
            $new_plugins_list = array_merge($plugins_list, $required_plugins);

            return $new_plugins_list;

        }

	/**
	 * Initialize the plugin
	 */
		public function livi_shop_plugins_loaded() {

			// Check for WooCommerce plugin
				if( !function_exists( 'is_woocommerce' ) ) {
					add_action( 'admin_notices', array( $this, 'livi_shop_woo_plugin_req' ) );
					return;
				}

			// Check for Livi Theme plugin
				if( !function_exists( 'livi_pro' ) ) {
					add_action( 'admin_notices', array( $this, 'livi_shop_dttheme_plugin_req' ) );
					return;
				}

			// Setup Constants
				$this->livi_shop_setup_constants();

			// Load Modules & Helper
				$this->livi_shop_load_modules();
                $this->load_helper();

			// Locate Module Files
				add_filter( 'livi_woo_pro_locate_file',  array( $this, 'livi_woo_pro_shop_locate_file' ), 10, 2 );

			// Load WooCommerce Template Files
				add_filter( 'woocommerce_locate_template',  array( $this, 'livi_shop_woocommerce_locate_template' ), 30, 3 );

		}


	/**
	 * Admin notice
	 * Warning when the site doesn't have WooCommerce plugin.
	 */
		public function livi_shop_woo_plugin_req() {

			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}

			$message = sprintf(
				/* translators: 1: Plugin name 2: Required plugin name */
				esc_html__( '"%1$s" requires "%2$s" plugin to be installed and activated.', 'livi-shop' ),
				'<strong>' . esc_html__( 'Livi Shop', 'livi-shop' ) . '</strong>',
				'<strong>' . esc_html__( 'WooCommerce - excelling eCommerce', 'livi-shop' ) . '</strong>'
			);

			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
		}

	/**
	 * Admin notice
	 * Warning when the site doesn't have Livi Theme plugin.
	 */
		public function livi_shop_dttheme_plugin_req() {

			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}

			$message = sprintf(
				/* translators: 1: Plugin name 2: Required plugin name */
				esc_html__( '"%1$s" requires "%2$s" plugin to be installed and activated.', 'livi-shop' ),
				'<strong>' . esc_html__( 'Livi Shop', 'livi-shop' ) . '</strong>',
				'<strong>' . esc_html__( 'Livi Pro', 'livi-shop' ) . '</strong>'
			);

			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
		}

	/**
	 * Define constant if not already set.
	 */
		public function livi_shop_define_constants( $name, $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}

	/**
	 * Configure Constants
	 */
		public function livi_shop_setup_constants() {

			$this->livi_shop_define_constants( 'LIVI_SHOP_VERSION', '1.0' );
			$this->livi_shop_define_constants( 'LIVI_SHOP_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
			$this->livi_shop_define_constants( 'LIVI_SHOP_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );
			$this->livi_shop_define_constants( 'LIVI_SHOP_NAME', esc_html__('Livi Shop', 'livi-shop') );

			$this->livi_shop_define_constants( 'LIVI_SHOP_MODULE_PATH', trailingslashit( LIVI_SHOP_PATH . 'modules' ) );
			$this->livi_shop_define_constants( 'LIVI_SHOP_MODULE_URL', trailingslashit( LIVI_SHOP_URL . 'modules' ) );

		}

	/**
	 * Load Modules
	 */
		public function livi_shop_load_modules() {

			foreach( glob( LIVI_SHOP_MODULE_PATH. '*/index.php' ) as $module ) {
				include_once $module;
			}

		}

	/**
	 * Locate Module Files
	 */
		public function livi_woo_pro_shop_locate_file( $file_path, $module ) {

			$file_path = LIVI_SHOP_PATH . 'modules/' . $module .'.php';

			$located_file_path = false;
			if ( $file_path && file_exists( $file_path ) ) {
				$located_file_path = $file_path;
			}

			return $located_file_path;

		}

	/**
	 * Override WooCommerce default template files
	 */
		public function livi_shop_woocommerce_locate_template( $template, $template_name, $template_path ) {

			global $woocommerce;

			$_template = $template;

			if ( ! $template_path ) $template_path = $woocommerce->template_url;

			$plugin_path  = LIVI_SHOP_PATH . 'templates/';

			// Look within passed path within the theme - this is priority
			$template = locate_template(
				array(
					$template_path . $template_name,
					$template_name
				)
			);

			// Modification: Get the template from this plugin, if it exists
			if ( ! $template && file_exists( $plugin_path . $template_name ) )
			$template = $plugin_path . $template_name;

			// Use default template
			if ( ! $template )
			$template = $_template;

			// Return what we found
			return $template;

		}

	/**
	 * Load helper
	 */
        function load_helper() {
            require_once LIVI_SHOP_PATH . 'functions.php';
        }

}

if( !function_exists('livi_shop_instance') ) {
	function livi_shop_instance() {
		return Livi_Shop::instance();
	}
}

livi_shop_instance();