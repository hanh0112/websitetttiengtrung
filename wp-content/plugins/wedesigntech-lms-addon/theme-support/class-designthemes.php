<?php

if( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'DTLmsDesignThemes' ) ) {

	class DTLmsDesignThemes {

		function __construct() {

			add_action( 'dtlms_before_main_content', array( $this, 'dtlms_default_before_main_content' ), 10 );
			add_action( 'dtlms_after_main_content', array( $this, 'dtlms_default_after_main_content' ), 10 );

		}

		function dtlms_default_body_class( $classes ) {

			return $classes;

		}

		function dtlms_default_before_main_content() {

			echo '<div class="dtlms-container">';
				echo '<section id="primary" class="content-full-width">';

		}

		function dtlms_default_after_main_content() {

				echo '</section>';
			echo '</div>';

		}


	}

	new DTLmsDesignThemes();

}

?>