<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if (! class_exists ( 'LiviPlusHeaderPostType' ) ) {

	class LiviPlusHeaderPostType {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

		function __construct() {

			add_action ( 'init', array( $this, 'livi_register_cpt' ), 5 );
			add_filter ( 'template_include', array ( $this, 'livi_template_include' ) );
		}

		function livi_register_cpt() {

			$labels = array (
				'name'				 => __( 'Headers', 'livi-plus' ),
				'singular_name'		 => __( 'Header', 'livi-plus' ),
				'menu_name'			 => __( 'Headers', 'livi-plus' ),
				'add_new'			 => __( 'Add Header', 'livi-plus' ),
				'add_new_item'		 => __( 'Add New Header', 'livi-plus' ),
				'edit'				 => __( 'Edit Header', 'livi-plus' ),
				'edit_item'			 => __( 'Edit Header', 'livi-plus' ),
				'new_item'			 => __( 'New Header', 'livi-plus' ),
				'view'				 => __( 'View Header', 'livi-plus' ),
				'view_item' 		 => __( 'View Header', 'livi-plus' ),
				'search_items' 		 => __( 'Search Headers', 'livi-plus' ),
				'not_found' 		 => __( 'No Headers found', 'livi-plus' ),
				'not_found_in_trash' => __( 'No Headers found in Trash', 'livi-plus' ),
			);

			$args = array (
				'labels' 				=> $labels,
				'public' 				=> true,
				'exclude_from_search'	=> true,
				'show_in_nav_menus' 	=> false,
				'show_in_rest' 			=> true,
				'menu_position'			=> 25,
				'menu_icon' 			=> 'dashicons-heading',
				'hierarchical' 			=> false,
				'supports' 				=> array ( 'title', 'editor', 'revisions' ),
			);

			register_post_type ( 'wdt_headers', $args );
		}

		function livi_template_include($template) {
			if ( is_singular( 'wdt_headers' ) ) {
				if ( ! file_exists ( get_stylesheet_directory () . '/single-wdt_headers.php' ) ) {
					$template = LIVI_PLUS_DIR_PATH . 'post-types/templates/single-wdt_headers.php';
				}
			}

			return $template;
		}
	}
}

LiviPlusHeaderPostType::instance();