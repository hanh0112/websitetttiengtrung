<?php

if( !class_exists('DTLMSCertificatesPostType') ) {

	class DTLMSCertificatesPostType {

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

			add_action ( 'init', array ( $this, 'dtlms_init' ) );
			add_action ( 'admin_init', array ( $this, 'dtlms_admin_init' ) );
			add_filter ( 'template_include', array ( $this, 'dtlms_template_include' ) );

			add_filter ( 'dtlms_core_cpt_metabox_tabs', array ( $this, 'dtlms_core_cpt_metabox_tabs_update' ), 5, 1 );
			add_action ( 'dtlms_addorupdate_course_module', array ( $this, 'dtlms_addorupdate_course_certificate_module' ), 10, 2 );

			add_filter ( 'dtlms_class_cpt_metabox_tabs', array ( $this, 'dtlms_class_cpt_metabox_tabs_update' ), 5, 1 );
			add_action ( 'dtlms_addorupdate_class_module', array ( $this, 'dtlms_addorupdate_class_certificate_module' ), 10, 2 );

		}

		function dtlms_init() {
			$this->createPostType();
		}

		function createPostType() {

			$labels = array (
					'name'               => esc_html__('Certificates', 'dtlms'),
					'all_items'          => esc_html__('All Certificates', 'dtlms'),
					'singular_name'      => esc_html__('Certificate', 'dtlms'),
					'add_new'            => esc_html__('Add New', 'dtlms'),
					'add_new_item'       => esc_html__('Add New Certificate', 'dtlms'),
					'edit_item'          => esc_html__('Edit Certificate', 'dtlms'),
					'new_item'           => esc_html__('New Certificate', 'dtlms'),
					'view_item'          => esc_html__('View Certificate', 'dtlms'),
					'search_items'       => esc_html__('Search Certificates', 'dtlms'),
					'not_found'          => esc_html__('No Certificates found', 'dtlms'),
					'not_found_in_trash' => esc_html__('No Certificates found in Trash', 'dtlms'),
					'parent_item_colon'  => esc_html__('Parent Certificate: ', 'dtlms'),
					'menu_name'          => esc_html__('Certificates', 'dtlms' )
			);

			$args = array (
					'labels'              => $labels,
					'hierarchical'        => true,
					'description'         => 'This is custom post type certificates',
					'supports'            => array (
							'title',
							'editor',
							'author',
					),

					'public'              => true,
					'show_ui'             => true,
					'show_in_menu'        => false,
					'show_in_nav_menus'   => false,
					'publicly_queryable'  => true,
					'exclude_from_search' => false,
					'has_archive'         => true,
					'query_var'           => true,
					'can_export'          => true,
					'capability_type'     => 'post'
			);

			register_post_type ( 'dtlms_certificates', $args );

		}

		function dtlms_admin_init() {
			add_action ( 'add_meta_boxes', array ( $this, 'dtlms_add_certificate_default_metabox' ) );
		}

		function dtlms_add_certificate_default_metabox() {
			add_meta_box ( 'dtlms-certificate-default-metabox', esc_html__('Certificate Options', 'dtlms'), array ( $this, 'dtlms_certificate_default_metabox' ), 'dtlms_certificates', 'normal', 'default' );
		}

		function dtlms_certificate_default_metabox() {
			include_once DTLMS_CERTIFICATE_PLUGIN_PATH . 'cpt/metaboxes/default-metabox.php';
		}

		function dtlms_template_include($template) {
			if (is_singular( 'dtlms_certificates' )) {
				$template = DTLMS_CERTIFICATE_PLUGIN_PATH . 'cpt/templates/single-dtlms_certificates.php';
			}
			return $template;
		}


		/**
		 * Core CPT - Metabox Update
		 */

		function dtlms_core_cpt_metabox_tabs_update($tabs) {

			$tabs['certificate'] = array (
				'label' => esc_html__('Certificate', 'dtlms'),
				'icon'  => 'far fa-eye',
				'path'  => DTLMS_CERTIFICATE_PLUGIN_PATH . 'cpt/metaboxes/course-certificate.php'
			);

			return $tabs;

		}


		/**
		 * Core CPT - Add / Update Course Certificate Module
		 */

		function dtlms_addorupdate_course_certificate_module($data, $course_id) {

			if( isset( $data['enable-certificate'] ) && $data['enable-certificate'] != '') {
				update_post_meta ( $course_id, 'enable-certificate', dtlms_recursive_sanitize_text_field( $data['enable-certificate'] ) );
			} else {
				delete_post_meta ( $course_id, 'enable-certificate' );
			}

			if( isset( $data['enable-certificate'] ) && $data['enable-certificate'] == 'true') {
				if( isset( $data['certificate-percentage'] ) && $data['certificate-percentage'] != '') {
					update_post_meta ( $course_id, 'certificate-percentage', dtlms_recursive_sanitize_text_field( $data['certificate-percentage'] ) );
				} else {
					update_post_meta ( $course_id, 'certificate-percentage', 100 );
				}
			} else {
				delete_post_meta ( $course_id, 'certificate-percentage' );
			}

			if( isset( $data['certificate-template'] ) && $data['certificate-template'] != '') {
				update_post_meta ( $course_id, 'certificate-template', dtlms_recursive_sanitize_text_field( $data['certificate-template'] ) );
			} else {
				delete_post_meta ( $course_id, 'certificate-template' );
			}

		}


		/**
		 * Class CPT - Metabox Update
		 */

		function dtlms_class_cpt_metabox_tabs_update($tabs) {

			$tabs['certificate'] = array (
				'label'   => esc_html__('Certificate', 'dtlms'),
				'icon'    => 'far fa-eye',
				'path'    => DTLMS_CERTIFICATE_PLUGIN_PATH . 'cpt/metaboxes/class-certificate.php'
			);

			return $tabs;

		}


		/**
		 * Class CPT - Add / Update Course Certificate Module
		 */

		function dtlms_addorupdate_class_certificate_module($data, $class_id) {

			if( isset( $data['enable-certificate'] ) && $data['enable-certificate'] != '') {
				update_post_meta ( $class_id, 'enable-certificate', dtlms_recursive_sanitize_text_field( $data['enable-certificate'] ) );
			} else {
				delete_post_meta ( $class_id, 'enable-certificate' );
			}

			if( isset( $data['enable-certificate'] ) && $data['enable-certificate'] == 'true') {
				if( isset( $data['certificate-percentage'] ) && $data['certificate-percentage'] != '') {
					update_post_meta ( $class_id, 'certificate-percentage', dtlms_recursive_sanitize_text_field( $data['certificate-percentage'] ) );
				} else {
					update_post_meta ( $class_id, 'certificate-percentage', 100 );
				}
			} else {
				delete_post_meta ( $class_id, 'certificate-percentage' );
			}

			if( isset( $data['certificate-template'] ) && $data['certificate-template'] != '') {
				update_post_meta ( $class_id, 'certificate-template', dtlms_recursive_sanitize_text_field( $data['certificate-template'] ) );
			} else {
				delete_post_meta ( $class_id, 'certificate-template' );
			}

		}

	}

	DTLMSCertificatesPostType::instance();

}
?>