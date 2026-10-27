<?php

if (!class_exists ( 'DTLMSRegisterBadgeModule' )) {

	class DTLMSRegisterBadgeModule extends DTLMSCore {

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

			$this->dtlms_define_constants( 'DTLMS_BADGE_PLUGIN_PATH', DTLMS_PLUGIN_PATH . 'modules/badge/' );
			$this->dtlms_define_constants( 'DTLMS_BADGE_PLUGIN_URL', DTLMS_PLUGIN_URL . 'modules/badge/' );
			$this->dtlms_define_constants( 'DTLMS_CLASS_SINGULAR_LABEL', '' );
			$this->dtlms_define_constants( 'DTLMS_CLASS_PLURAL_LABEL', '' );

			add_action ( 'wp_enqueue_scripts', array ( $this, 'dtlms_enqueue_scripts' ), 130 );

			add_filter ( 'dtlms_core_cpt_metabox_tabs', array ( $this, 'dtlms_core_cpt_metabox_tabs_update' ), 5, 1 );
			add_action ( 'dtlms_addorupdate_course_module', array ( $this, 'dtlms_addorupdate_course_badge_module' ), 10, 2 );

			add_filter ( 'dtlms_class_cpt_metabox_tabs', array ( $this, 'dtlms_class_cpt_metabox_tabs_update' ), 5, 1 );
			add_action ( 'dtlms_addorupdate_class_module', array ( $this, 'dtlms_addorupdate_class_badge_module' ), 10, 2 );

			require_once DTLMS_BADGE_PLUGIN_PATH . 'settings/settings.php';
			require_once DTLMS_BADGE_PLUGIN_PATH . 'shortcodes.php';

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

			wp_register_style ( 'dtlms-badge-frontend', DTLMS_BADGE_PLUGIN_URL . 'assets/badge-frontend.css', array ( 'dtlms-frontend' ) );

		}

		function dtlms_enqueue_registered_files() {

			wp_enqueue_style ( 'dtlms-badge-frontend' );

		}




		/**
		 * Core CPT - Metabox Update
		 */

		function dtlms_core_cpt_metabox_tabs_update($tabs) {

			$tabs['badge'] = array (
				'label' => esc_html__('Badge', 'dtlms'),
				'icon'  => 'far fa-eye',
				'path'  => DTLMS_BADGE_PLUGIN_PATH . 'metaboxes/course-badge.php'
			);

			return $tabs;

		}


		/**
		 * Core CPT - Add / Update Course Badge Module
		 */

		function dtlms_addorupdate_course_badge_module($data, $course_id) {

			if( isset( $data['enable-badge'] ) && $data['enable-badge'] != '') {
				update_post_meta ( $course_id, 'enable-badge', dtlms_recursive_sanitize_text_field( $data['enable-badge'] ) );
			} else {
				delete_post_meta ( $course_id, 'enable-badge' );
			}

			if( isset( $data['enable-badge'] ) && $data['enable-badge'] == 'true') {
				if( isset( $data['badge-percentage'] ) && $data['badge-percentage'] != '') {
					update_post_meta ( $course_id, 'badge-percentage', dtlms_recursive_sanitize_text_field( $data['badge-percentage'] ) );
				} else {
					update_post_meta ( $course_id, 'badge-percentage', 100 );
				}
			} else {
				delete_post_meta ( $course_id, 'badge-percentage' );
			}

			if( isset( $data['badge-image-url'] ) && $data['badge-image-url'] != '') {
				update_post_meta ( $course_id, 'badge-image-url', dtlms_recursive_sanitize_text_field( $data['badge-image-url'] ) );
			} else {
				delete_post_meta ( $course_id, 'badge-image-url' );
			}

			if( isset( $data['badge-image-id'] ) && $data['badge-image-id'] != '') {
				update_post_meta ( $course_id, 'badge-image-id', dtlms_recursive_sanitize_text_field( $data['badge-image-id'] ) );
			} else {
				delete_post_meta ( $course_id, 'badge-image-id' );
			}

		}


		/**
		 * Class CPT - Metabox Update
		 */

		function dtlms_class_cpt_metabox_tabs_update($tabs) {

			$tabs['badge'] = array (
				'label'   => esc_html__('Badge', 'dtlms'),
				'icon'    => 'far fa-eye',
				'path'    => DTLMS_BADGE_PLUGIN_PATH . 'metaboxes/class-badge.php'
			);

			return $tabs;

		}


		/**
		 * Class CPT - Add / Update Course Badge Module
		 */

		function dtlms_addorupdate_class_badge_module($data, $class_id) {

			if( isset( $data['enable-badge'] ) && $data['enable-badge'] != '') {
				update_post_meta ( $class_id, 'enable-badge', dtlms_recursive_sanitize_text_field( $data['enable-badge'] ) );
			} else {
				delete_post_meta ( $class_id, 'enable-badge' );
			}

			if( isset( $data['enable-badge'] ) && $data['enable-badge'] == 'true') {
				if( isset( $data['badge-percentage'] ) && $data['badge-percentage'] != '') {
					update_post_meta ( $class_id, 'badge-percentage', dtlms_recursive_sanitize_text_field( $data['badge-percentage'] ) );
				} else {
					update_post_meta ( $class_id, 'badge-percentage', 100 );
				}
			} else {
				delete_post_meta ( $class_id, 'badge-percentage' );
			}

			if( isset( $data['badge-image-url'] ) && $data['badge-image-url'] != '') {
				update_post_meta ( $class_id, 'badge-image-url', dtlms_recursive_sanitize_text_field( $data['badge-image-url'] ) );
			} else {
				delete_post_meta ( $class_id, 'badge-image-url' );
			}

			if( isset( $data['badge-image-id'] ) && $data['badge-image-id'] != '') {
				update_post_meta ( $class_id, 'badge-image-id', dtlms_recursive_sanitize_text_field( $data['badge-image-id'] ) );
			} else {
				delete_post_meta ( $class_id, 'badge-image-id' );
			}

		}


	}

}

if( !function_exists('dtlmsBadgeModule') ) {
	function dtlmsBadgeModule() {
		return DTLMSRegisterBadgeModule::instance();
	}
}

dtlmsBadgeModule();

?>