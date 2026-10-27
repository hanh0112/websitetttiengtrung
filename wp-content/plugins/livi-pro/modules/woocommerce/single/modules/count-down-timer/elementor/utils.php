<?php

/*
* Update Summary - Options Filter
*/

if( ! function_exists( 'livi_shop_woo_single_summary_options_clivi_render' ) ) {
	function livi_shop_woo_single_summary_options_clivi_render( $options ) {

		$options['countdown'] = esc_html__('Summary Count Down', 'livi-pro');
		return $options;

	}
	add_filter( 'livi_shop_woo_single_summary_options', 'livi_shop_woo_single_summary_options_clivi_render', 10, 1 );

}

/*
* Update Summary - Styles Filter
*/

if( ! function_exists( 'livi_shop_woo_single_summary_styles_clivi_render' ) ) {
	function livi_shop_woo_single_summary_styles_clivi_render( $styles ) {

		array_push( $styles, 'wdt-shop-coundown-timer' );
		return $styles;

	}
	add_filter( 'livi_shop_woo_single_summary_styles', 'livi_shop_woo_single_summary_styles_clivi_render', 10, 1 );

}

/*
* Update Summary - Scripts Filter
*/

if( ! function_exists( 'livi_shop_woo_single_summary_scripts_clivi_render' ) ) {
	function livi_shop_woo_single_summary_scripts_clivi_render( $scripts ) {

		array_push( $scripts, 'jquery-downcount' );
		array_push( $scripts, 'wdt-shop-coundown-timer' );
		return $scripts;

	}
	add_filter( 'livi_shop_woo_single_summary_scripts', 'livi_shop_woo_single_summary_scripts_clivi_render', 10, 1 );

}