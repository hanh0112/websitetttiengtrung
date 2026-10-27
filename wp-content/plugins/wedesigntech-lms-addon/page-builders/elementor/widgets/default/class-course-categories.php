<?php
namespace DTElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTLMSDfCourseCategories extends Widget_Base {

	public function get_categories() {
		return [ 'dtlms-default-widgets' ];
	}

	public function get_name() {
		return 'dtlms-widget-default-course-categories';
	}

	public function get_title() {
		return esc_html__( 'Course Categories', 'dtlms' );
	}

	public function get_style_depends() {
		return array ();
	}

	public function get_script_depends() {
		return array ();
	}

    protected function _register_controls() {
		$this->start_controls_section( 'default-course-categories-section', array(
			'label' => esc_html__( 'General', 'dtlms' ),
		) );
			$this->add_control( 'type', array(
				'label'   => esc_html__( 'Type', 'dtlms' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'type1'  => esc_html__('Type 1', 'dtlms'),
					'type2'  => esc_html__('Type 2', 'dtlms'),
					'type3'  => esc_html__('Type 3', 'dtlms'),
					'type4'  => esc_html__('Type 4', 'dtlms'),
					'type5'  => esc_html__('Type 5', 'dtlms'),
					'type6'  => esc_html__('Type 6', 'dtlms'),
					'type7'  => esc_html__('Type 7', 'dtlms'),
					'type8'  => esc_html__('Type 8', 'dtlms'),
					'type9'  => esc_html__('Type 9', 'dtlms'),
					'type10' => esc_html__('Type 10', 'dtlms'),
				),
				'description' => esc_html__( 'Choose type of course category to display.', 'dtlms' ),
				'default'     => '',
			) );
			$this->add_control( 'columns', array(
				'label'   => esc_html__( 'Columns', 'dtlms' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					1 => esc_html__('I Column', 'dtlms'),
					2 => esc_html__('II Columns', 'dtlms'),
					3 => esc_html__('III Columns', 'dtlms'),
					4 => esc_html__('IV Columns', 'dtlms'),
				),
				'description' => esc_html__( 'Number of columns you like to display your course categories.', 'dtlms' ),
				'default'     => '',
			) );
			$this->add_control( 'category_count', array(
				'label'   => esc_html__( 'Category count', 'dtlms' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					2 => esc_html__('2', 'dtlms'),
					3 => esc_html__('3', 'dtlms'),
					4 => esc_html__('4', 'dtlms'),
					5 => esc_html__('5', 'dtlms'),
					6 => esc_html__('6', 'dtlms'),
					7 => esc_html__('7', 'dtlms'),
					8 => esc_html__('8', 'dtlms'),
					9 => esc_html__('9', 'dtlms'),
					10 => esc_html__('10', 'dtlms')
				),
				'description' => esc_html__( 'Number of categories you like to display.', 'dtlms' ),
				'default'     => '',
			) );
			$this->add_control( 'include', array(
				'label'       => esc_html__( 'Include', 'dtlms' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'List of category ids separated by commas.', 'dtlms' ),
				'default'     => ''
			) );
			$this->add_control( 'use-icon-image', array(
				'label'   => esc_html__( 'Use Icon Image', 'dtlms' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'false' => esc_html__('False', 'dtlms'),
					'true'  => esc_html__('True', 'dtlms'),
				),
				'description' => esc_html__( 'If you wish you can use icon image instead of icon.', 'dtlms' ),
				'default'     => '',
			) );
			$this->add_control( 'class', array(
				'label'   => esc_html__( 'Class', 'dtlms' ),
				'type'    => Controls_Manager::TEXT,
				'description' => esc_html__( 'If you wish you can add additional class name here.', 'dtlms' ),
				'default' => ''
			) );
		$this->end_controls_section();
	}

	protected function render() {
		$settings   = $this->get_settings();
		$attributes = dtlms_elementor_instance()->dtlms_parse_shortcode_attrs( $settings );
		echo do_shortcode('[dtlms_course_categories '.$attributes.' /]');
    }

}