<?php

if (!class_exists ( 'DTLMSRegisterQuizModule' )) {

	class DTLMSRegisterQuizModule extends DTLMSCore {

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

			$this->dtlms_define_constants( 'DTLMS_QUIZ_PLUGIN_PATH', DTLMS_PLUGIN_PATH . 'modules/quiz/' );
			$this->dtlms_define_constants( 'DTLMS_QUIZ_PLUGIN_URL', DTLMS_PLUGIN_URL . 'modules/quiz/' );

			add_action ( 'admin_enqueue_scripts', array ( $this, 'dtlms_admin_enqueue_scripts' ), 110 );
			add_action ( 'wp_enqueue_scripts', array ( $this, 'dtlms_enqueue_scripts' ), 130 );

			add_filter ( 'dtlms_admin_menu_and_order', array ( $this, 'dtlms_admin_menu_and_order_update'  ), 20 );
			add_filter ( 'dtlms_course_curriculums', array ( $this, 'dtlms_course_curriculums_update'  ), 10, 1 );

			add_filter ( 'dtlms_settings', array ( $this, 'dtlms_settings_update' ), 5, 1 );

			require_once DTLMS_QUIZ_PLUGIN_PATH . 'cpt/quizzes-post-type.php';
			require_once DTLMS_QUIZ_PLUGIN_PATH . 'cpt/questions-post-type.php';
			require_once DTLMS_QUIZ_PLUGIN_PATH . 'settings/settings-utils.php';
			require_once DTLMS_QUIZ_PLUGIN_PATH . 'utils.php';

		}


		/**
		 * Backend Enqueue Scripts
		 */

		function dtlms_admin_enqueue_scripts() {

			$this->dtlms_register_dependent_files();

			$current_screen = get_current_screen();

			if($current_screen->id == 'dtlms_quizzes' || $current_screen->id == 'dtlms_questions' || $current_screen->id == 'edit-question_category') {

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
				wp_enqueue_script ( 'dtlms-quiz-backend' );

			}

			if($current_screen->id == 'dtlms_gradings' || $current_screen->id == 'lms_page_dtlms-settings-options') {

				// JS

				wp_enqueue_script ( 'dtlms-quiz-backend' );

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

			wp_register_style ( 'dtlms-quiz-frontend', DTLMS_QUIZ_PLUGIN_URL . 'assets/quiz-frontend.css', array ( 'dtlms-frontend' ) );


			// JS

			wp_register_script ( 'dtlms-quiz-backend', DTLMS_QUIZ_PLUGIN_URL . 'assets/backend.js', array ('jquery', 'dtlms-backend'), false, true );
			wp_localize_script ( 'dtlms-quiz-backend', 'lmsquizbackendobject', array (
				'noResult'          => esc_html__('No Results Found!', 'dtlms'),
				'importUploadTitle' => esc_html__('Upload / Select CSV Files', 'dtlms'),
				'importInsertFile'  => esc_html__('Insert File', 'dtlms'),
				'invalidFile'       => esc_html__('No file chosen!', 'dtlms'),
				'resetGrade'        => esc_html__('Gradings have been resetted successfully', 'dtlms'),
			));

			$quiztimer_foreground_color = dtlms_skin_option('quiztimer-foreground-color');
			$quiztimer_background_color = dtlms_skin_option('quiztimer-background-color');

			wp_register_script ( 'dtlms-quiz-frontend', DTLMS_QUIZ_PLUGIN_URL . 'assets/frontend.js', array ('jquery', 'dtlms-frontend'), false, true );
			wp_localize_script ( 'dtlms-quiz-frontend', 'lmsquizfrontendobject', array (
				'quizTimerForegroundColor' => $quiztimer_foreground_color,
				'quizTimerBackgroundColor' => $quiztimer_background_color,
				'quizTimeout'              => esc_html__('Timeout!', 'dtlms'),
				'onRefresh'                => esc_html__('Refreshing this quiz page will mark this session as completed.', 'dtlms')
			));

		}

		function dtlms_enqueue_registered_files() {

			wp_enqueue_style ( 'dtlms-quiz-frontend' );

			wp_enqueue_script ( 'dtlms-quiz-frontend' );

		}

		/**
		 * Custom Admin Menu & Order Update
		 */

		function dtlms_admin_menu_and_order_update() {
			add_submenu_page( 'dtlms', esc_html__( 'All Quizzes', 'dtlms' ), esc_html__( 'All Quizzes', 'dtlms' ), 'edit_posts', 'edit.php?post_type=dtlms_quizzes' );
			add_submenu_page( 'dtlms', esc_html__( 'All Questions', 'dtlms' ), esc_html__( 'All Questions', 'dtlms' ), 'edit_posts', 'edit.php?post_type=dtlms_questions' );
		}

		function dtlms_course_curriculums_update($curriculums) {

			$curriculums['dtlms_quizzes'] = array (
				'singular_slug'        => 'quiz',
				'plural_slug'          => 'quizzes',
				'singular_label'       => esc_html__('Quiz', 'dtlms'),
				'plural_label'         => esc_html__('Quizzes', 'dtlms'),
				'post_type'            => 'dtlms_quizzes',
				'grading_metabox_path' => DTLMS_QUIZ_PLUGIN_PATH . 'cpt/metaboxes/grading.php'
			);

			return $curriculums;

		}


		/**
		 * Update Quiz & Questions Import Settings
		 */

		function dtlms_settings_update($tabs) {

			$tabs['import'] = array (
				'label' => esc_html__('Import', 'dtlms'),
				'path'  => DTLMS_QUIZ_PLUGIN_PATH . 'settings/settings.php'
			);

			return $tabs;

		}

	}

}

if( !function_exists('dtlmsQuizModule') ) {
	function dtlmsQuizModule() {
		return DTLMSRegisterQuizModule::instance();
	}
}

dtlmsQuizModule();

?>