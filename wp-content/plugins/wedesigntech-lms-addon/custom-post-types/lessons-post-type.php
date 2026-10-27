<?php

if( !class_exists('DTLMSLessonsPostType') ) {

	class DTLMSLessonsPostType {

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

		}

		function dtlms_init() {

			$this->createPostType();
			add_action ( 'save_post', array ( $this, 'dtlms_save_post_meta' ) );

			add_filter ( 'dtlms_cpt_items', array ( $this, 'dtlms_cpt_items_update'  ), 10, 3 );
			add_filter ( 'dtlms_admin_menu_and_order', array ( $this, 'dtlms_admin_menu_and_order_update'  ), 15 );

		}

		function createPostType() {

			$labels = array (
						'name'               => esc_html__('Lessons', 'dtlms'),
						'all_items'          => esc_html__('All Lessons', 'dtlms'),
						'singular_name'      => esc_html__('Lesson', 'dtlms'),
						'add_new'            => esc_html__('Add New', 'dtlms'),
						'add_new_item'       => esc_html__('Add New Lesson', 'dtlms'),
						'edit_item'          => esc_html__('Edit Lesson', 'dtlms'),
						'new_item'           => esc_html__('New Lesson', 'dtlms'),
						'view_item'          => esc_html__('View Lesson', 'dtlms'),
						'search_items'       => esc_html__('Search Lessons', 'dtlms'),
						'not_found'          => esc_html__('No Lessons found', 'dtlms'),
						'not_found_in_trash' => esc_html__('No Lessons found in Trash', 'dtlms'),
						'parent_item_colon'  => esc_html__('Parent Lesson: ', 'dtlms'),
						'menu_name'          => esc_html__('Lessons', 'dtlms' )
					);

			$args = array (
						'labels'              => $labels,
						'hierarchical'        => true,
						'description'         => 'This is custom post type lessons',
						'supports'            => array (
								'title',
								'editor',
								'excerpt',
								'author',
								'page-attributes',
								'thumbnail'
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

			register_post_type ( 'dtlms_lessons', $args );

			register_taxonomy ( 'lesson_complexity', array (
				'dtlms_lessons'
					), array (
							'hierarchical' => true,
							'labels' => array (
								'name' 					=> esc_html__( 'Lesson Categories','dtlms' ),
								'singular_name' 		=> esc_html__( 'Lesson Category','dtlms' ),
								'search_items'			=> esc_html__( 'Search Lesson Categories', 'dtlms' ),
								'popular_items'			=> esc_html__( 'Popular Lesson Categories', 'dtlms' ),
								'all_items'				=> esc_html__( 'All Lesson Categories', 'dtlms' ),
								'parent_item'			=> esc_html__( 'Parent Lesson Category', 'dtlms' ),
								'parent_item_colon'		=> esc_html__( 'Parent Lesson Category', 'dtlms' ),
								'edit_item'				=> esc_html__( 'Edit Lesson Category', 'dtlms' ),
								'update_item'			=> esc_html__( 'Update Lesson Category', 'dtlms' ),
								'add_new_item'			=> esc_html__( 'Add New Lesson Category', 'dtlms' ),
								'new_item_name'			=> esc_html__( 'New Lesson Category', 'dtlms' ),
								'add_or_remove_items'	=> esc_html__( 'Add or remove', 'dtlms' ),
								'choose_from_most_used'	=> esc_html__( 'Choose from most used', 'dtlms' ),
								'menu_name'				=> esc_html__( 'Lesson Categories','dtlms' ),
							),
							'show_admin_column' => true,
							'rewrite' => array ( 'slug' =>'', 'hierarchical' => true, 'with_front' => false ),
							'query_var' => true
					)
				);

		}

		function dtlms_save_post_meta($post_id) {

			if( key_exists ( '_inline_edit', $_POST )) :
				if ( wp_verify_nonce($_POST['_inline_edit'], 'inlineeditnonce')) return;
			endif;

			if( key_exists( 'dtlms_lessons_meta_nonce', $_POST ) ) :
				if ( ! wp_verify_nonce( $_POST['dtlms_lessons_meta_nonce'], 'dtlms_lessons_nonce') ) return;
			endif;

			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

			if (!current_user_can('edit_post', $post_id)) :
				return;
			endif;

			if ( (key_exists('post_type', $_POST)) && ('dtlms_lessons' == $_POST['post_type']) ) :

				if( isset( $_POST ['free-lesson'] ) && $_POST ['free-lesson'] != '' ) {
					update_post_meta ( $post_id, 'free-lesson', dtlms_recursive_sanitize_text_field( $_POST ['free-lesson'] ) );
				} else {
					delete_post_meta ( $post_id, 'free-lesson' );
				}

				if( isset( $_POST ['lesson-curriculum'] ) && !empty($_POST ['lesson-curriculum'])) {
					update_post_meta ( $post_id, 'lesson-curriculum', array_unique ( dtlms_recursive_sanitize_text_field($_POST ['lesson-curriculum']) ) );
				} else {
					delete_post_meta ( $post_id, 'lesson-curriculum' );
				}

				if( isset( $_POST ['duration'] ) && $_POST ['duration'] != '') {
					update_post_meta ( $post_id, 'duration', dtlms_recursive_sanitize_text_field( $_POST ['duration'] ) );
				} else {
					delete_post_meta ( $post_id, 'duration' );
				}

				if( isset( $_POST ['duration-parameter'] ) && $_POST ['duration-parameter'] != '') {
					update_post_meta ( $post_id, 'duration-parameter', dtlms_recursive_sanitize_text_field( $_POST ['duration-parameter'] ) );
				} else {
					delete_post_meta ( $post_id, 'duration-parameter' );
				}

				if( isset( $_POST ['teacher'] ) && $_POST ['teacher'] != '') {
					update_post_meta ( $post_id, 'teacher', array_filter ( dtlms_recursive_sanitize_text_field($_POST ['teacher']) ) );
				} else {
					delete_post_meta ( $post_id, 'teacher' );
				}

				if( isset( $_POST ['lesson-maximum-mark'] ) && $_POST ['lesson-maximum-mark'] != '' ) {
					update_post_meta ( $post_id, 'lesson-maximum-mark', dtlms_recursive_sanitize_text_field( $_POST ['lesson-maximum-mark'] ) );
				} else {
					delete_post_meta ( $post_id, 'lesson-maximum-mark' );
				}

				if( isset( $_POST ['lesson-pass-percentage'] ) && $_POST ['lesson-pass-percentage'] != '' ) {
					update_post_meta ( $post_id, 'lesson-pass-percentage', dtlms_recursive_sanitize_text_field( $_POST ['lesson-pass-percentage'] ) );
				} else {
					delete_post_meta ( $post_id, 'lesson-pass-percentage' );
				}

				if( isset( $_POST ['lesson-video'] ) && $_POST ['lesson-video'] != '') {
					update_post_meta ( $post_id, 'lesson-video', dtlms_recursive_sanitize_text_field( $_POST ['lesson-video'] ) );
				} else {
					delete_post_meta ( $post_id, 'lesson-video' );
				}

			endif;

		}

		function dtlms_cpt_items_update($cpts) {
			$cpts['lessons'] = esc_html__('Lessons', 'dtlms');
			return $cpts;
		}

		function dtlms_admin_menu_and_order_update() {
			add_submenu_page( 'dtlms', esc_html__( 'All Lessons', 'dtlms' ), esc_html__( 'All Lessons', 'dtlms' ), 'edit_posts', 'edit.php?post_type=dtlms_lessons' );
		}

		function dtlms_admin_init() {
			add_action ( 'add_meta_boxes', array ( $this, 'dtlms_add_lesson_default_metabox' ) );
			add_action ( 'add_meta_boxes', array ( $this, 'dtlms_add_lesson_featured_video_metabox' ) );
		}

		function dtlms_add_lesson_default_metabox() {
			add_meta_box ( 'dtlms-lesson-default-metabox', esc_html__('Lesson Options', 'dtlms'), array ( $this, 'dtlms_lesson_default_metabox' ), 'dtlms_lessons', 'normal', 'default' );
		}

		function dtlms_add_lesson_featured_video_metabox() {
			add_meta_box ( 'dtlms-lesson-featured-video-metabox', esc_html__('Featured Video', 'dtlms'), array ( $this, 'dtlms_lesson_featured_video_metabox' ), 'dtlms_lessons', 'side', 'low' );
		}

		function dtlms_lesson_default_metabox() {
			include_once DTLMS_PLUGIN_PATH . 'custom-post-types/metaboxes/lesson-default-metabox.php';
		}

		function dtlms_lesson_featured_video_metabox() {
			include_once DTLMS_PLUGIN_PATH . 'custom-post-types/metaboxes/lesson-featured-video-metabox.php';
		}

		function dtlms_template_include($template) {

			if (is_singular( 'dtlms_lessons' )) {
				$template = DTLMS_PLUGIN_PATH . 'custom-post-types/templates/single-dtlms_lessons.php';
			} elseif( is_post_type_archive('dtlms_lessons') ) {
				$template = DTLMS_PLUGIN_PATH . 'custom-post-types/templates/archive-dtlms_lessons.php';
			}

			return $template;

		}

	}

	DTLMSLessonsPostType::instance();

}

?>