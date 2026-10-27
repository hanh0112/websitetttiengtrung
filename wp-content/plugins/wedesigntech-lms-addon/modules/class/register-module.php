<?php

if (!class_exists ( 'DTLMSRegisterClassModule' )) {

	class DTLMSRegisterClassModule extends DTLMSCore {

		private $module_name;
		private $module_url;

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

		function __construct() {

			$this->dtlms_define_constants( 'DTLMS_CLASS_PLUGIN_PATH', DTLMS_PLUGIN_PATH . 'modules/class/' );
			$this->dtlms_define_constants( 'DTLMS_CLASS_PLUGIN_URL', DTLMS_PLUGIN_URL . 'modules/class/' );
			$this->dtlms_define_constants( 'DTLMS_CLASS_SINGULAR_LABEL', apply_filters( 'class_label', 'singular' ) );
			$this->dtlms_define_constants( 'DTLMS_CLASS_PLURAL_LABEL', apply_filters( 'class_label', 'plural' ) );


			add_filter ( 'dtlms_woo_purchase_cpt', array ( $this, 'dtlms_woo_purchase_cpt_update' ), 20, 1 );
			add_action ( 'admin_enqueue_scripts', array ( $this, 'dtlms_admin_enqueue_scripts' ), 110 );
			add_action ( 'wp_enqueue_scripts', array ( $this, 'dtlms_enqueue_scripts' ), 130 );

			add_filter ( 'dtlms_admin_menu_and_order', array ( $this, 'dtlms_admin_menu_and_order_update_mainmenu'  ), 10 );
			add_filter ( 'dtlms_admin_menu_and_order', array ( $this, 'dtlms_admin_menu_and_order_update_regmenu'  ), 50 );

			require_once DTLMS_CLASS_PLUGIN_PATH . 'cpt/post-type.php';

			require_once DTLMS_CLASS_PLUGIN_PATH . 'utils.php';
			require_once DTLMS_CLASS_PLUGIN_PATH . 'utils-common.php';
			require_once DTLMS_CLASS_PLUGIN_PATH . 'utils-items.php';
			require_once DTLMS_CLASS_PLUGIN_PATH . 'class-registrations.php';
			require_once DTLMS_CLASS_PLUGIN_PATH . 'settings/settings.php';
			require_once DTLMS_CLASS_PLUGIN_PATH . 'shortcodes.php';
			require_once DTLMS_CLASS_PLUGIN_PATH . 'statistics.php';
			require_once DTLMS_CLASS_PLUGIN_PATH . 'utils-woocommerce.php';

		}


		/**
		 * Backend Enqueue Scripts
		 */

		function dtlms_admin_enqueue_scripts() {

			$this->dtlms_register_dependent_files();

			$current_screen = get_current_screen();

			if($current_screen->id == 'dtlms_classes') {

				// CSS

				wp_enqueue_style ( 'jquery-ui' );
				wp_enqueue_style ( 'fontawesome' );
				wp_enqueue_style ( 'material-icon' );
				wp_enqueue_style ( 'icon-moon' );
				wp_enqueue_style ( 'chosen' );
				wp_enqueue_style ( 'dtlms-backend' );
				wp_enqueue_style ( 'dtlms-common' );
				wp_enqueue_style ( 'dtlms-misc' );


				// JS

				wp_enqueue_script ( 'jquery-ui-datepicker' );
				wp_enqueue_script ( 'dtlms-timepicker' );
				wp_enqueue_script ( 'chosen' );

				wp_enqueue_script ( 'dtlms-tabs' );
				wp_enqueue_script ( 'dtlms-common' );
				wp_enqueue_script ( 'dtlms-class-backend' );
				wp_enqueue_script ( 'dtlms-google-map' );

			}

			if($current_screen->id == 'lms_page_dtlms-statistics-options') {
				wp_enqueue_script ( 'dtlms-class-common' );
			}

			if($current_screen->id == 'lms_page_dtlms-settings-options' || $current_screen->id == 'lms_page_dtlms-classregistrations-options') {
				wp_enqueue_script ( 'dtlms-class-backend' );
			}

		}


		/**
		 * Frontend Enqueue Scripts
		 */

		function dtlms_enqueue_scripts() {

			$this->dtlms_register_dependent_files();
			$this->dtlms_enqueue_registered_files();

		}

		function dtlms_register_dependent_files() {

			wp_register_style ( 'dtlms-class-frontend', DTLMS_CLASS_PLUGIN_URL . 'assets/class-frontend.css', array ( 'dtlms-frontend' ) );


			wp_register_script ( 'dtlms-class-common', DTLMS_CLASS_PLUGIN_URL . 'assets/common.js', array ('jquery', 'dtlms-common'), false, true );

			wp_register_script ( 'dtlms-class-backend', DTLMS_CLASS_PLUGIN_URL . 'assets/backend.js', array ('jquery', 'dtlms-backend'), false, true );
			wp_localize_script ( 'dtlms-class-backend', 'lmsclassbackendobject', array (
				'locationAlert1'      => esc_html__('To get GPS location please fill address.', 'dtlms'),
				'locationAlert2'      => esc_html__('Please add latitude and longitude', 'dtlms')
			));

			wp_register_script ( 'dtlms-class-frontend', DTLMS_CLASS_PLUGIN_URL . 'assets/frontend.js', array ('jquery', 'dtlms-frontend'), false, true );
			wp_localize_script ( 'dtlms-class-frontend', 'lmsclassfrontendobject', array (
				'registrationSuccess' => esc_html__('You have successfully registered with our class!', 'dtlms')
			));

		}

		function dtlms_enqueue_registered_files() {

			wp_enqueue_style ( 'dtlms-class-frontend' );

			wp_enqueue_script ( 'dtlms-google-map' );
			wp_enqueue_script ( 'dtlms-class-common' );
			wp_enqueue_script ( 'dtlms-class-frontend' );

		}


		/**
		 * WooCommerce CPT Update
		 */

		function dtlms_woo_purchase_cpt_update($cpt) {
			array_push($cpt, 'dtlms_classes');
			return $cpt;
		}


		/**
		 * Custom Admin Menu & Order Update
		 */

		function dtlms_admin_menu_and_order_update_mainmenu() {
			add_submenu_page( 'dtlms', sprintf( esc_html__('All %1$s', 'dtlms'), DTLMS_CLASS_PLURAL_LABEL ), sprintf( esc_html__('All %1$s', 'dtlms'), DTLMS_CLASS_PLURAL_LABEL ), 'edit_posts', 'edit.php?post_type=dtlms_classes' );
		}

		function dtlms_admin_menu_and_order_update_regmenu() {
			add_submenu_page( 'dtlms', sprintf( esc_html__( '%1$s Registrations', 'dtlms' ), DTLMS_CLASS_SINGULAR_LABEL ), sprintf( esc_html__( '%1$s Registrations', 'dtlms' ), DTLMS_CLASS_SINGULAR_LABEL ), 'manage_options', 'dtlms-classregistrations-options', 'dtlms_classregistrations_options' );
		}

	}

}

if( !function_exists('dtlmsClassModule') ) {
	function dtlmsClassModule() {
		return DTLMSRegisterClassModule::instance();
	}
}

dtlmsClassModule();

?>