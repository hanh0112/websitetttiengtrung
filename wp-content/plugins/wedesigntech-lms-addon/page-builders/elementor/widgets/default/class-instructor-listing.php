<?php
namespace DTElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTLMSDfInstructorListing extends Widget_Base {

	public function get_categories() {
		return [ 'dtlms-default-widgets' ];
	}

	public function get_name() {
		return 'dtlms-widget-default-instructor-listing';
	}

	public function get_title() {
		$instructor_plural_label = apply_filters( 'instructor_label', 'plural' );

		return sprintf(esc_html__('%s List', 'dtlms'), $instructor_plural_label);
	}

	public function get_style_depends() {
		return array ();
	}

	public function get_script_depends() {
		return array ();
	}

    protected function _register_controls() {

		$instructor_label        = apply_filters( 'instructor_label', 'singular' );
		$instructor_plural_label = apply_filters( 'instructor_label', 'plural' );

		$this->start_controls_section( 'default-instructor-listing-section', array(
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
				'default'     => 'type1',
			) );
			$this->add_control( 'image-types', array(
				'label'   => esc_html__( 'Image Types', 'dtlms' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					''                    => esc_html__('Default', 'dtlms'),
					'with-border'         => esc_html__('Default With Border', 'dtlms'),
					'rounded'             => esc_html__('Rounded', 'dtlms'),
					'rounded-with-border' => esc_html__('Rounded With Border', 'dtlms'),
				),
				'description' => sprintf(esc_html__('Choose %s image type here.', 'dtlms'), $instructor_plural_label),
				'default'     => '',
			) );
			$this->add_control( 'social-icon-types', array(
				'label'   => esc_html__( 'Social Icon Types', 'dtlms' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'default' => esc_html__('Default', 'dtlms'),
					'vibrant' => esc_html__('Vibrant', 'dtlms'),
					'with-bg' => esc_html__('With Background', 'dtlms'),
				),
				'description' => esc_html__('Choose social icon types here.', 'dtlms'),
				'default'     => 'default',
			) );
			$this->add_control( 'columns', array(
				'label'   => esc_html__( 'Columns', 'dtlms' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'' => esc_html__('None', 'dtlms'),
					1  => esc_html__('I Column', 'dtlms'),
					2  => esc_html__('II Columns', 'dtlms'),
					3  => esc_html__('III Columns', 'dtlms'),
					4  => esc_html__('IV Columns', 'dtlms'),
					5  => esc_html__('V Columns', 'dtlms'),
					6  => esc_html__('VI Columns', 'dtlms'),
				),
				'description' => sprintf(esc_html__('Number of columns you like to display your %s.', 'dtlms'), $instructor_label),
				'default'     => '',
			) );
			$this->add_control( 'include', array(
				'label'       => esc_html__( 'Include', 'dtlms' ),
				'type'        => Controls_Manager::TEXT,
				'description' => sprintf(esc_html__('List of %s ids separated by comma.', 'dtlms'), $instructor_label),
			) );
			$this->add_control( 'number', array(
				'label'       => esc_html__( 'Number Of Users', 'dtlms' ),
				'type'        => Controls_Manager::TEXT,
				'description' => sprintf(esc_html__('Number of %s to display.', 'dtlms'), $instructor_label),
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
		echo do_shortcode('[dtlms_instructor_list '.$attributes.' /]');
    }

}