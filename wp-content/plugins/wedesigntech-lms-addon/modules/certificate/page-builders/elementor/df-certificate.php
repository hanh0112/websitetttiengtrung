<?php
namespace DTElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTLMSDfCertificate extends Widget_Base {

	public function get_categories() {
		return [ 'dtlms-default-widgets' ];
	}

	public function get_name() {
		return 'dtlms-widget-default-certificate';
	}

	public function get_title() {
		return esc_html__( 'Certificate', 'dtlms' );
	}

	public function get_style_depends() {
		return array ();
	}

	public function get_script_depends() {
		return array ();
	}

    protected function _register_controls() {
		$this->start_controls_section( 'default-certificate-section', array(
			'label' => esc_html__( 'General', 'dtlms' ),
		) );
			$this->add_control( 'heading', array(
				'label'   => esc_html__( 'Heading', 'dtlms' ),
				'type'    => Controls_Manager::TEXT,
				'default' => ''
			) );
			$this->add_control( 'subheading', array(
				'label'   => esc_html__( 'Sub Heading', 'dtlms' ),
				'type'    => Controls_Manager::TEXT,
				'default' => ''
			) );
			$this->add_control('footer_logo', array(
				'label' => esc_html__( 'Footer Logo', 'dtlms' ),
				'type'  => Controls_Manager::MEDIA,
			) );
			$this->add_control('signature', array(
				'label' => esc_html__( 'Signature', 'dtlms' ),
				'type'  => Controls_Manager::MEDIA,
			) );
			$this->add_control( 'content', array(
				'label'   => esc_html__( 'Content', 'dtlms' ),
				'type'    => Controls_Manager::TEXTAREA,
				'rows'    => 10,
				'default' => ''
			) );
		$this->end_controls_section();
	}

	protected function render() {
		$settings   = $this->get_settings();
		$content     = isset( $settings['content'] ) ? $settings['content'] : '';
		$attributes = dtlms_elementor_instance()->dtlms_parse_shortcode_attrs( $settings );
		echo do_shortcode('[dtlms_certificate '.$attributes.']'.$content.'[/dtlms_certificate]');
    }

}