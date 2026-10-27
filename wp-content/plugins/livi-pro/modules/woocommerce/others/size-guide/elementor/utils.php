<?php

/*
* Update Summary - Options Filter
*/

if( ! function_exists( 'livi_shop_woo_single_summary_button_options_sg_render' ) ) {
	function livi_shop_woo_single_summary_button_options_sg_render( $options ) {

		$options['sizeguide'] = esc_html__('Button Size Guide', 'livi-pro');
		return $options;

	}
	add_filter( 'livi_shop_woo_single_summary_button_options', 'livi_shop_woo_single_summary_button_options_sg_render', 10, 1 );

}

/*
* Update Summary - Styles Filter
*/

if( ! function_exists( 'livi_shop_woo_single_summary_styles_sg_render' ) ) {
	function livi_shop_woo_single_summary_styles_sg_render( $styles ) {

		array_push( $styles, 'swiper' );
		array_push( $styles, 'wdt-shop-size-guide' );
		return $styles;

	}
	add_filter( 'livi_shop_woo_single_summary_styles', 'livi_shop_woo_single_summary_styles_sg_render', 10, 1 );

}

/*
* Update Summary - Scripts Filter
*/

if( ! function_exists( 'livi_shop_woo_single_summary_scripts_sg_render' ) ) {
	function livi_shop_woo_single_summary_scripts_sg_render( $scripts ) {

		array_push( $scripts, 'jquery-swiper' );
		array_push( $scripts, 'wdt-shop-size-guide' );
		return $scripts;

	}
	add_filter( 'livi_shop_woo_single_summary_scripts', 'livi_shop_woo_single_summary_scripts_sg_render', 10, 1 );

}