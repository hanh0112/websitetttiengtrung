<?php

/*
 * Product Buy Now
 */

if ( ! function_exists( 'livi_shop_products_buy_now' ) ) {

	function livi_shop_products_buy_now() {

		if(is_product()) {

			$settings = livi_woo_single_core()->woo_default_settings();
			extract($settings);

			$product_template = livi_shop_woo_product_single_template_option();

			if( $product_template == 'woo-default' ) {

				if(!$product_buy_now) {
					return;
				}

			}

		}

		echo '<div class="product-buy-now">';
			echo '<a href="#" class="button quick_buy_now_button" >'.esc_html__('Buy Now', 'livi-pro').'</a>';
		echo '</div>';

	}

	add_action( 'woocommerce_single_product_summary', 'livi_shop_products_buy_now', 38 );

}