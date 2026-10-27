<?php
namespace DTElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTLMSDbStudentCertificates extends Widget_Base {

	public function get_categories() {
		return [ 'dtlms-dashboard-widgets' ];
	}

	public function get_name() {
		return 'dtlms-widget-dashboard-student-certificates';
	}

	public function get_title() {
		return esc_html__( 'Student Certificates', 'dtlms' );
	}

	public function get_style_depends() {
		return array ();
	}

	public function get_script_depends() {
		return array ();
	}

    protected function _register_controls() {
		$dtlms_cpt_items = apply_filters( 'dtlms_cpt_items', array () );
		$dtlms_cpt_items = array_keys($dtlms_cpt_items);

		$item_type_opts = array ();
		if(in_array('classes', $dtlms_cpt_items)) {
			$class_singular_label = apply_filters( 'class_label', 'singular' );
			$item_type_opts = array_merge ( $item_type_opts, array ( 'class' => sprintf( esc_html__( '%1$s', 'dtlms' ), $class_singular_label ) ) );
		}

		$this->start_controls_section( 'default-dashboard-student-certificates-section', array(
			'label' => esc_html__( 'General', 'dtlms' ),
		) );
			$this->add_control( 'item-type', array(
				'label'   => esc_html__( 'Item Type', 'dtlms' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array_merge(
					array ( 'all'    => esc_html__('All', 'dtlms') ),
					array ( 'course' => esc_html__('Course', 'dtlms') ),
					$item_type_opts
				),
				'description' => esc_html__( 'Choose item type to display its corresponding student achieved certificates.', 'dtlms' ),
				'default'     => 'course',
			) );
			if(in_array('classes', $dtlms_cpt_items)) {
				$this->add_control( 'include-registration-class', array(
					'label'   => sprintf( esc_html__( 'Include Registration %1$s', 'dtlms' ), $class_singular_label ),
					'type'    => Controls_Manager::SELECT,
					'options' => array(
						'false' => esc_html__('False', 'dtlms'),
						'true'  => esc_html__('True', 'dtlms'),
					),
					'description' => sprintf( esc_html__( 'If you wish to include registration %1$s choose "True".', 'dtlms' ), strtolower($class_singular_label) ),
					'default'     => 'false',
					'condition'   => array( 'item-type' => 'class' )
				) );
			}
		$this->end_controls_section();
    }

	protected function render() {
		$settings   = $this->get_settings();
		$attributes = dtlms_elementor_instance()->dtlms_parse_shortcode_attrs( $settings );
		echo do_shortcode('[dtlms_student_certificates '.$attributes.' /]');
	}
}