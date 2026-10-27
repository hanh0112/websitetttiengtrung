<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'LiviProSiteBlog' ) ) {
    class LiviProSiteBlog extends LiviPlusSiteBlog {

        private static $_instance = null;
        public $element_position = array();

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            $this->load_widgets();
            add_action( 'livi_after_main_css', array( $this, 'enqueue_css_assets' ), 20 );
            add_filter('blog_post_grid_list_style_update', array( $this, 'blog_post_grid_list_style_update' ));
            add_filter('blog_post_cover_style_update', array( $this, 'blog_post_cover_style_update' ));
        }

        function enqueue_css_assets() {
            wp_enqueue_style( 'livi-pro-blog', LIVI_PRO_DIR_URL . 'modules/blog/assets/css/blog.css', false, LIVI_PRO_VERSION, 'all');

            $post_style = livi_get_archive_post_style();
            $file_path = LIVI_PRO_DIR_PATH . 'modules/blog/templates/'.esc_attr($post_style).'/assets/css/blog-archive-'.esc_attr($post_style).'.css';
            if ( file_exists( $file_path ) ) {
                wp_enqueue_style( 'wdt-blog-archive-'.esc_attr($post_style), LIVI_PRO_DIR_URL . 'modules/blog/templates/'.esc_attr($post_style).'/assets/css/blog-archive-'.esc_attr($post_style).'.css', false, LIVI_PRO_VERSION, 'all');
            }

        }

        function load_widgets() {
            add_action( 'widgets_init', array( $this, 'register_widgets_init' ) );
        }

        function register_widgets_init() {
            include_once LIVI_PRO_DIR_PATH.'modules/blog/widget/widget-recent-posts.php';
            register_widget('Livi_Widget_Recent_Posts');
        }

        function blog_post_grid_list_style_update($list) {

            $pro_list = array (
                'wdt-simple'        => esc_html__('Simple', 'livi-pro'),
                'wdt-overlap'       => esc_html__('Overlap', 'livi-pro'),
                'wdt-thumb-overlap' => esc_html__('Thumb Overlap', 'livi-pro'),
                'wdt-minimal'       => esc_html__('Minimal', 'livi-pro'),
                'wdt-fancy-box'     => esc_html__('Fancy Box', 'livi-pro'),
                'wdt-bordered'      => esc_html__('Bordered', 'livi-pro'),
                'wdt-magnificent'   => esc_html__('Magnificent', 'livi-pro')
            );

            return array_merge( $list, $pro_list );

        }

        function blog_post_cover_style_update($list) {

            $pro_list = array ();
            return array_merge( $list, $pro_list );

        }

    }
}

LiviProSiteBlog::instance();

if( !class_exists( 'LiviProSiteRelatedBlog' ) ) {
    class LiviProSiteRelatedBlog extends LiviProSiteBlog {
        function __construct() {}
    }
}