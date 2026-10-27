<?php
namespace DTElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTLMSDfCertificateDetails extends Widget_Base {

	public function get_categories() {
		return [ 'dtlms-default-widgets' ];
	}

	public function get_name() {
		return 'dtlms-widget-default-certificate-details';
	}

	public function get_title() {
		return esc_html__( 'Certificate Details', 'dtlms' );
	}

	public function get_style_depends() {
		return array ();
	}

	public function get_script_depends() {
		return array ();
	}

    protected function _register_controls() {
		$class_singular_label = apply_filters( 'class_label', 'singular' );

		$this->start_controls_section( 'default-certificate-details-section', array(
			'label' => esc_html__( 'General', 'dtlms' ),
		) );
			$this->add_control( 'item_type', array(
				'label'   => esc_html__( 'Item Type', 'dtlms' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'student_name'    => esc_html__('Student Name','dtlms'),
					'item_name'       => sprintf( esc_html__( 'Item Name ( %1$s or Course )', 'dtlms' ), $class_singular_label ),
					'student_percent' => esc_html__('Student Percent','dtlms'),
					'date'            => esc_html__('Date','dtlms'),
				),
				'default' => 'student_name',
			) );
		$this->end_controls_section();
	}

	protected function render() {
		$settings   = $this->get_settings();
		$attributes = dtlms_elementor_instance()->dtlms_parse_shortcode_attrs( $settings );
		echo do_shortcode('[dtlms_certificate_details '.$attributes.' /]');
    }

}