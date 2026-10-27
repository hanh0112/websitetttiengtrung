<?php

/*
* Update Summary - Options Filter
*/

if( ! function_exists( 'livi_shop_woo_single_summary_options_ai_render' ) ) {
	function livi_shop_woo_single_summary_options_ai_render( $options ) {

		$options['additional_info']                   = esc_html__('Summary Additional Info', 'livi-pro');
		$options['additional_info_delivery_period']   = esc_html__('Summary Additional Info - Delivery Period', 'livi-pro');
		$options['additional_info_realtime_visitors'] = esc_html__('Summary Additional Info - Real Time Visitors', 'livi-pro');
		$options['additional_info_shipping_offer']    = esc_html__('Summary Additional Info - Shipping Offer', 'livi-pro');
		$options['additional_info_weight']    		  = esc_html__('Summary Additional Info - Weight', 'livi-pro');
		$options['additional_info_dimensions']        = esc_html__('Summary Additional Info - Dimenstions', 'livi-pro');
		$options['additional_info_color']             = esc_html__('Summary Additional Info - Color', 'livi-pro');
		$options['additional_info_size']              = esc_html__('Summary Additional Info - Size', 'livi-pro');
		return $options;

	}
	add_filter( 'livi_shop_woo_single_summary_options', 'livi_shop_woo_single_summary_options_ai_render', 10, 1 );

}

/*
* Update Summary - Styles Filter
*/

if( ! function_exists( 'livi_shop_woo_single_summary_styles_ai_render' ) ) {
	function livi_shop_woo_single_summary_styles_ai_render( $styles ) {

		array_push( $styles, 'wdt-shop-additional-info' );
		return $styles;

	}
	add_filter( 'livi_shop_woo_single_summary_styles', 'livi_shop_woo_single_summary_styles_ai_render', 10, 1 );

}

/*
* Update Summary - Scripts Filter
*/

if( ! function_exists( 'livi_shop_woo_single_summary_scripts_ai_render' ) ) {
	function livi_shop_woo_single_summary_scripts_ai_render( $scripts ) {

		array_push( $scripts, 'wdt-shop-additional-info' );
		return $scripts;

	}
	add_filter( 'livi_shop_woo_single_summary_scripts', 'livi_shop_woo_single_summary_scripts_ai_render', 10, 1 );

}