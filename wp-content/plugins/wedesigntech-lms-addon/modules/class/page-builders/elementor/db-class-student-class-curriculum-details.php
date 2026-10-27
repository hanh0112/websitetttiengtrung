<?php
namespace DTElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTLMSDbClassStudentClassCurriculumDetails extends Widget_Base {

	public function get_categories() {
		return [ 'dtlms-dashboard-widgets' ];
	}

	public function get_name() {
		return 'dtlms-widget-dashboard-student-class-curriculum-details';
	}

	public function get_title() {
        $class_singular_label = apply_filters( 'class_label', 'singular' );
		return sprintf( esc_html__( 'Student %1$s Curriculum Details', 'dtlms' ), $class_singular_label );
	}

	public function get_style_depends() {
		return array ();
	}

	public function get_script_depends() {
		return array ();
	}

	protected function render() {
		echo do_shortcode('[dtlms_student_class_curriculum_details/]');
    }
}