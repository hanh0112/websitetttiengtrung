<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'LiviAiimageWidget' ) ) {
    class LiviAiimageWidget {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_action( 'elementor/widgets/register', array( $this, 'register_widgets' ) );
        }

        function register_widgets( $widgets_manager ) {
            require LIVI_PRO_DIR_PATH. 'modules/ai-image/elementor/widgets/ai-image/class-widget-ai-image.php';
            $widgets_manager->register( new \Elementor_Ai_Image() );
        }
    }
}

LiviAiimageWidget::instance();