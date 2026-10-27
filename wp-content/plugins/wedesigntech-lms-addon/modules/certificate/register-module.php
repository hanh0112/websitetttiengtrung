<?php

if (!class_exists ( 'DTLMSRegisterCertificateModule' )) {

	class DTLMSRegisterCertificateModule extends DTLMSCore {

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

			$this->dtlms_define_constants( 'DTLMS_CERTIFICATE_PLUGIN_PATH', DTLMS_PLUGIN_PATH . 'modules/certificate/' );
			$this->dtlms_define_constants( 'DTLMS_CERTIFICATE_PLUGIN_URL', DTLMS_PLUGIN_URL . 'modules/certificate/' );
			$this->dtlms_define_constants( 'DTLMS_CLASS_SINGULAR_LABEL', '' );
			$this->dtlms_define_constants( 'DTLMS_CLASS_PLURAL_LABEL', '' );

			add_action ( 'init', array ( $this, 'dtlms_init' ) );

			add_action ( 'admin_enqueue_scripts', array ( $this, 'dtlms_admin_enqueue_scripts' ), 110 );
			add_action ( 'wp_enqueue_scripts', array ( $this, 'dtlms_enqueue_scripts' ), 130 );

			add_filter ( 'dtlms_admin_menu_and_order', array ( $this, 'dtlms_admin_menu_and_order_update'  ), 40 );

			require_once DTLMS_CERTIFICATE_PLUGIN_PATH . 'cpt/post-type.php';
			require_once DTLMS_CERTIFICATE_PLUGIN_PATH . 'shortcodes.php';
			require_once DTLMS_CERTIFICATE_PLUGIN_PATH . 'settings/settings.php';
			require_once DTLMS_CERTIFICATE_PLUGIN_PATH . 'utils.php';

		}


		/**
		 * On Init
		 */

		function dtlms_init() {
			if( class_exists( 'Vc_Manager' ) ) {
				add_action( 'vc_load_default_templates_action', array ( $this, 'dtlms_vc_certificate_template' ) );
			}
		}


		/**
		 * Backend Enqueue Scripts
		 */

		function dtlms_admin_enqueue_scripts() {

			$this->dtlms_register_dependent_files();

			$current_screen = get_current_screen();

			if($current_screen->id == 'dtlms_certificates') {

				// CSS

				wp_enqueue_style ( 'fontawesome' );
				wp_enqueue_style ( 'material-icon' );
				wp_enqueue_style ( 'icon-moon' );
				wp_enqueue_style ( 'chosen' );
				wp_enqueue_style ( 'dtlms-backend' );
				wp_enqueue_style ( 'dtlms-common' );
				wp_enqueue_style ( 'dtlms-misc' );


				// JS

				wp_enqueue_script ( 'chosen' );

				wp_enqueue_script ( 'dtlms-common' );
				wp_enqueue_script ( 'dtlms-backend' );

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

			// CSS

			wp_register_style ( 'dtlms-certificate-frontend', DTLMS_CERTIFICATE_PLUGIN_URL . 'assets/certificate-frontend.css', array ( 'dtlms-frontend' ) );


			// JS

			wp_register_script ( 'dtlms-certificate-common', DTLMS_CERTIFICATE_PLUGIN_URL . 'assets/common.js', array ('jquery', 'dtlms-common'), false, true );
			wp_localize_script ( 'dtlms-certificate-common', 'lmscertificatecommonobject', array (
				'pluginPath'   => DTLMS_CERTIFICATE_PLUGIN_URL,
				'printerTitle' => esc_html__('Certificate Printer', 'dtlms')
			));

		}

		function dtlms_enqueue_registered_files() {

			wp_enqueue_style ( 'dtlms-certificate-frontend' );

			wp_enqueue_script ( 'dtlms-certificate-common' );

		}

		/**
		 * Custom Admin Menu & Order Update
		 */

		function dtlms_admin_menu_and_order_update() {
			add_submenu_page( 'dtlms', esc_html__( 'All Certificates', 'dtlms' ), esc_html__( 'All Certificates', 'dtlms' ), 'edit_posts', 'edit.php?post_type=dtlms_certificates' );
		}


		/**
		 * Visual Composer Certificate Default Template
		 */

		function dtlms_vc_certificate_template() {

		    $data               = array ();
		    $data['name']       = esc_html__( 'DT LMS - Certificate Template', 'dtlms' );
			$data['content']    = <<<CONTENT
		        [vc_row][vc_column][dtlms_certificate logo1="13845" logo2="13463" heading="Certificate of Achievement" subheading="This certification is proudly presented for honorable achievement to" footer_logo="14310" signature="13759"]Aenean et volutpat dui, a vulputate orci. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.[/dtlms_certificate][/vc_column][/vc_row]
CONTENT;

    		vc_add_default_templates( $data );

		}

	}

}

if( !function_exists('dtlmsCertificateModule') ) {
	function dtlmsCertificateModule() {
		return DTLMSRegisterCertificateModule::instance();
	}
}

dtlmsCertificateModule();

?>