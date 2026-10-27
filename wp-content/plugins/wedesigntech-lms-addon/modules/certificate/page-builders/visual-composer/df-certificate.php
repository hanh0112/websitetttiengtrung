<?php
add_action( 'vc_before_init', 'dtlms_certificate_vc_map' );

function dtlms_certificate_vc_map() {

	vc_map( array(
		"name" => esc_html__( 'Certificate', 'dtlms' ),
		"base" => "dtlms_certificate",
		"icon" => "dtlms_certificate",
		"category" => DTLMS_PB_MODULE_DEFAULT_TITLE,
		"params" => array(

			// Heading
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Heading', 'dtlms' ),
				'param_name' => 'heading',
			),

			// Sub Heading
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Sub Heading', 'dtlms' ),
				'param_name' => 'subheading',
			),

			// Footer Logo
			array(
				'type' => 'attach_image',
				'heading' => esc_html__('Footer Logo','dtlms'),
				'param_name' => 'footer_logo',
			),

			// Signature
			array(
				'type' => 'attach_image',
				'heading' => esc_html__('Signature','dtlms'),
				'param_name' => 'signature',
			),

			// Content
			array(
				'type' => 'textarea',
				'heading' => esc_html__('Content','dtlms'),
				'param_name' => 'content',
			),

		)
	) );

}
?>