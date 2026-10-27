<?php
namespace DTElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTLMSDbClassDetails extends Widget_Base {

	public function get_categories() {
		return [ 'dtlms-dashboard-widgets' ];
	}

	public function get_name() {
		return 'dtlms-widget-dashboard-class-details';
	}

	public function get_title() {

		$class_singular_label = apply_filters( 'class_label', 'singular' );
		return sprintf( esc_html__( '%1$s Details', 'dtlms' ), $class_singular_label );
	}

	public function get_style_depends() {
		return array ();
	}

	public function get_script_depends() {
		return array ();
	}

    protected function _register_controls() {

		$instructor_label = apply_filters( 'instructor_label', 'singular' );

		$this->start_controls_section( 'default-dashboard-class-details-section', array(
			'label' => esc_html__( 'General', 'dtlms' ),
		) );
			$this->add_control( 'enable-instructor-filter', array(
				'label'       => sprintf(esc_html__('Enable %s Filter', 'dtlms'), $instructor_label),
				'type'        => Controls_Manager::SELECT,
				'label_block' => true,
				'options'     => array(
					'false' => esc_html__('False', 'dtlms'),
					'true'  => esc_html__('True', 'dtlms'),
				),
				'description' => sprintf(esc_html__('If you wish you can enable %s filter option. This option is applicable only for administrator.', 'dtlms'), $instructor_label),
			) );
		$this->end_controls_section();
	}

	protected function render() {
		$settings   = $this->get_settings();
		$attributes = dtlms_elementor_instance()->dtlms_parse_shortcode_attrs( $settings );
		echo do_shortcode('[dtlms_class_details '.$attributes.' /]');
    }
}