<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if (! class_exists ( 'LiviPlusFooterPostType' ) ) {

	class LiviPlusFooterPostType {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

		function __construct() {

			add_action ( 'init', array( $this, 'livi_register_cpt' ) );
			add_filter ( 'template_include', array ( $this, 'livi_template_include' ) );
		}

		function livi_register_cpt() {

			$labels = array (
				'name'				 => __( 'Footers', 'livi-plus' ),
				'singular_name'		 => __( 'Footer', 'livi-plus' ),
				'menu_name'			 => __( 'Footers', 'livi-plus' ),
				'add_new'			 => __( 'Add Footer', 'livi-plus' ),
				'add_new_item'		 => __( 'Add New Footer', 'livi-plus' ),
				'edit'				 => __( 'Edit Footer', 'livi-plus' ),
				'edit_item'			 => __( 'Edit Footer', 'livi-plus' ),
				'new_item'			 => __( 'New Footer', 'livi-plus' ),
				'view'				 => __( 'View Footer', 'livi-plus' ),
				'view_item' 		 => __( 'View Footer', 'livi-plus' ),
				'search_items' 		 => __( 'Search Footers', 'livi-plus' ),
				'not_found' 		 => __( 'No Footers found', 'livi-plus' ),
				'not_found_in_trash' => __( 'No Footers found in Trash', 'livi-plus' ),
			);

			$args = array (
				'labels' 				=> $labels,
				'public' 				=> true,
				'exclude_from_search'	=> true,
				'show_in_nav_menus' 	=> false,
				'show_in_rest' 			=> true,
				'menu_position'			=> 26,
				'menu_icon' 			=> 'dashicons-editor-insertmore',
				'hierarchical' 			=> false,
				'supports' 				=> array ( 'title', 'editor', 'revisions' ),
			);

			register_post_type ( 'wdt_footers', $args );
		}

		function livi_template_include($template) {
			if ( is_singular( 'wdt_footers' ) ) {
				if ( ! file_exists ( get_stylesheet_directory () . '/single-wdt_footers.php' ) ) {
					$template = LIVI_PLUS_DIR_PATH . 'post-types/templates/single-wdt_footers.php';
				}
			}

			return $template;
		}
	}
}

LiviPlusFooterPostType::instance();