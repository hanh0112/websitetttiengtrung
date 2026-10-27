<?php
add_action( 'vc_before_init', 'dtlms_student_badges_vc_map' );

function dtlms_student_badges_vc_map() {

	$dtlms_cpt_items = apply_filters( 'dtlms_cpt_items', array () );
	$dtlms_cpt_items = array_keys($dtlms_cpt_items);

	$item_type_opts = $class_opts = array ();
	if(in_array('classes', $dtlms_cpt_items)) {
		$class_singular_label = apply_filters( 'class_label', 'singular' );
		$item_type_opts = array_merge ( $item_type_opts, array ( sprintf( esc_html__( '%1$s', 'dtlms' ), $class_singular_label ) => 'class' ) );

		$class_opts = array( array(
			'type' => 'dropdown',
			'heading' => sprintf( esc_html__( 'Include Registration %1$s', 'dtlms' ), $class_singular_label ),
			'param_name' => 'include-registration-class',
			'value' => array(
				esc_html__('False', 'dtlms') => 'false',
				esc_html__('True', 'dtlms') => 'true',
			),
			'description' => sprintf( esc_html__( 'If you wish to include registration %1$s choose "True".', 'dtlms' ), strtolower($class_singular_label) ),
			'std' => '',
			'dependency' => array( 'element' => 'item-type', 'value' => 'class')
		) );

	}

	$params_options = array( array(
		'type' => 'dropdown',
		'heading' => esc_html__('Item Type', 'dtlms'),
		'param_name' => 'item-type',
		'value' => array_merge (
			array ( esc_html__('All', 'dtlms') => '' ),
			array ( esc_html__('Course', 'dtlms') => 'course' ),
			$item_type_opts
		),
		'description' => esc_html__( 'Choose item type to display its corresponding student achieved badges.', 'dtlms' ),
		'admin_label' => true,
		'std' => 'course'
	) );

	vc_map( array(
		"name" => esc_html__( 'Student Badges', 'dtlms' ),
		"base" => "dtlms_student_badges",
		"icon" => "dtlms_student_badges",
		"category" => DTLMS_PB_MODULE_DASHBOARD_TITLE,
		'description' => esc_html__('To display student achieved badges.', 'dtlms'),
		"params" => array_merge (

			// Item Type
			$params_options,

			// Include Registration Class
			$class_opts

		)
	) );

}
?>