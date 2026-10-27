<?php
/** Product single template option **/

if( ! function_exists( 'livi_shop_woo_product_single_custom_template_option' ) ) {

	function livi_shop_woo_product_single_custom_template_option() {

		global $post;

		$settings = get_post_meta( $post->ID, '_custom_settings', true );
		$product_template = (isset($settings['product-template']) && $settings['product-template'] != '') ? $settings['product-template'] : 'admin-option';

		if($product_template == 'admin-option') {
			$settings = livi_woo_single_core()->woo_default_settings();
			extract($settings);
			$product_template = (isset($product_default_template) && $product_default_template != '') ? $product_default_template : 'woo-default';
		}

		return $product_template;

	}

}


/** Product single template **/

if( ! function_exists( 'livi_shop_woo_product_single_template' ) ) {

	function livi_shop_woo_product_single_template( $single_template ) {

		if (is_singular( 'product' )) {

			$product_template = livi_shop_woo_product_single_custom_template_option();

			if( $product_template == 'custom-template' ) {
				$single_template = livi_shop_single_module_custom_template()->module_dir_path() . 'templates/custom-template.php';
			}

		}

		return $single_template;

	}

	add_filter('template_include', 'livi_shop_woo_product_single_template', 100);

}