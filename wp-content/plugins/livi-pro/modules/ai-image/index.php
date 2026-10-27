<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'LiviAiimage' ) ) {
    class LiviAiimage {

        private static $_instance = null;
        private $global_layout    = '';
        private $global_sidebar   = '';

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {

            $this->load_module();
            $this->frontend();
        }


        function load_module() {
            include_once LIVI_PRO_DIR_PATH.'modules/ai-image/elementor/index.php';
            add_filter( 'theme_page_templates', array( $this, 'add_ai_image_template' ) );
        }

        function add_ai_image_template( $templates ) {
            $templates = array_merge( $templates, array( 'tpl-bmi-calculator.php' => esc_html__('AI Image generator', 'livi-pro' ) ) );
            return $templates;
        }

        function frontend() {
            add_action( 'livi_after_main_css', array( $this, 'enqueue_assets' ) );
        }

        function enqueue_assets() {

            $page_template = $this->get_page_template();
            wp_enqueue_style( 'style-ai-image', LIVI_PRO_DIR_URL . 'modules/ai-image/assets/css/style.css', false, LIVI_PRO_VERSION, 'all' );
            wp_enqueue_script( 'ai-image-js', LIVI_PRO_DIR_URL . 'modules/ai-image/assets/js/classes.js', LIVI_PRO_VERSION, true );

            // wp_enqueue_script( 'aiimageobject', 'aiimageurl', array( 'jquery' ),true );
    
                $data = array(
                'aiimageurl' => LIVI_PRO_DIR_URL . 'modules/ai-image/assets/images',
                );
                
            // wp_localize_script( 'aiimageobject', 'aiimagepath', $data );
        }

        function get_page_template() {
            if( is_singular('page') ) {
                return get_post_meta( get_the_ID(), '_wp_page_template', true );
            }
        }
    }
}

LiviAiimage::instance();