<?php
add_action( 'vc_before_init', 'dtlms_student_undergoing_items_vc_map' );

function dtlms_student_undergoing_items_vc_map() {

	$dtlms_cpt_items = apply_filters( 'dtlms_cpt_items', array () );
	$dtlms_cpt_items = array_keys($dtlms_cpt_items);

	$item_type_opts = array ();
	if(in_array('classes', $dtlms_cpt_items)) {
		$class_singular_label = apply_filters( 'class_label', 'singular' );
		$item_type_opts = array_merge ( $item_type_opts, array ( sprintf( esc_html__( '%1$s', 'dtlms' ), $class_singular_label ) => 'class' ) );
	}

	vc_map( array(
		"name" => esc_html__( 'Student Undergoing Items', 'dtlms' ),
		"base" => "dtlms_student_undergoing_items",
		"icon" => "dtlms_student_undergoing_items",
		"category" => DTLMS_PB_MODULE_DASHBOARD_TITLE,
		'description' => esc_html__('To display student undergoing items.', 'dtlms'),
		"params" => array(

			// Item Title
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Item Title', 'dtlms' ),
				'param_name' => 'item-title',
				'description' => esc_html__( 'If you wish you can change the default item title here.', 'dtlms' ),
			),

			// Item Type
			array(
				'type' => 'dropdown',
				'heading' => esc_html__('Item Type', 'dtlms'),
				'param_name' => 'item-type',
				'value' => array_merge (
					array ( esc_html__('None', 'dtlms') => '' ),
					array ( esc_html__('Course', 'dtlms') => 'course' ),
					$item_type_opts
				),
				'description' => esc_html__( 'Choose item type to display its undergoing list.', 'dtlms' ),
				'admin_label' => true
			),

		)
	) );

}
?>