<?php

function dtlms_settings_commission_content() {

	$output = '';

   	$tabs = array (
				'set_commission' => esc_html__('Set Commission', 'dtlms'),
				'pay_commission' => esc_html__('Pay Commission', 'dtlms'),
    		);

	$current = isset( $_GET['tab'] ) ? $_GET['tab'] : 'set_commission';

    $output .= '<h3 class="dtlms-custom-nav nav-tab-wrapper">';
		foreach( $tabs as $key => $tab ) {
			$class = ( $key == $current ) ? 'nav-tab-active' : '';
			$output .= '<a class="nav-tab '.$class.'" href="?page=dtlms-settings-options&parenttab=commission&tab='.$key.'">'.$tab.'</a>';
		}
    $output .= '</h3>';


    if($current == 'set_commission') {
		$output .= dtlms_get_set_commission_content();
    } else if($current == 'pay_commission') {
		$output .= dtlms_get_pay_commission_content();
    }

    return $output;

}

echo dtlms_settings_commission_content();

?>