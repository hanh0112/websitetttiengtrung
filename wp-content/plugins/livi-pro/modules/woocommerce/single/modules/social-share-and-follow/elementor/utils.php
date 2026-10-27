<?php

/*
* Update Summary Options Filter
*/

if( ! function_exists( 'livi_shop_woo_single_summary_options_ssf_render' ) ) {
	function livi_shop_woo_single_summary_options_ssf_render( $options ) {

		$options['share_follow'] = esc_html__('Summary Share / Follow', 'livi-pro');
		return $options;

	}
	add_filter( 'livi_shop_woo_single_summary_options', 'livi_shop_woo_single_summary_options_ssf_render', 10, 1 );

}


/*
* Update Summary - Styles Filter
*/

if( ! function_exists( 'livi_shop_woo_single_summary_styles_ssf_render' ) ) {
	function livi_shop_woo_single_summary_styles_ssf_render( $styles ) {

		array_push( $styles, 'wdt-shop-social-share-and-follow' );
		return $styles;

	}
	add_filter( 'livi_shop_woo_single_summary_styles', 'livi_shop_woo_single_summary_styles_ssf_render', 10, 1 );

}
