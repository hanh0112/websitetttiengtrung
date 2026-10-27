<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Livi_Shop_Metabox_Single_CT' ) ) {
    class Livi_Shop_Metabox_Single_CT {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'livi_shop_product_custom_settings', array( $this, 'livi_shop_product_custom_settings' ), 10 );
        }

        function livi_shop_product_custom_settings( $options ) {

			$elementor_template_args = array (
				'numberposts' => -1,
				'post_type'   => 'elementor_library',
				'fields'      => 'ids'
			);

			$elementor_templates_arr = get_posts ($elementor_template_args);

			$elementor_templates = array ( '' => esc_html__('None', 'livi-pro'), 'custom-description' => esc_html__('Custom Description', 'livi-pro') );
			foreach($elementor_templates_arr as $elementor_template) {
				$elementor_templates[$elementor_template] = get_the_title($elementor_template);
			}

			$product_options = array (

				array (
					'id'      => 'product-template',
					'type'    => 'select',
					'title'   => esc_html__('Product Template', 'livi-pro'),
					'class'   => 'chosen',
					'options' => array(
						'admin-option'    => esc_html__( 'Admin Option', 'livi-pro' ),
						'woo-default'     => esc_html__( 'WooCommerce Default', 'livi-pro' ),
						'custom-template' => esc_html__( 'Custom Template', 'livi-pro' )
					),
					'default'    => 'admin-option',
					'info'       => esc_html__('Don\'t use product shortcodes in content area when "WooCommerce Default" template is chosen.', 'livi-pro'),
					'attributes' => array( 'data-depend-id' => 'product-template' )
				),

				array(
					'id'         => 'description',
					'type'       => 'select',
					'title'      => esc_html__('Description', 'livi-pro'),
					'options'    => $elementor_templates,
					'info'       => esc_html__('Choose "Elementor Templates" here to use for "Description", if you choose "Custom Description" option you can provide your own content below. This content will be used when "Custom Template" is chosen in "Product Template" option.', 'livi-pro'),
					'attributes' => array( 'data-depend-id' => 'description' ),
					'dependency' => array( 'product-template', '==', 'custom-template' )
				),

				array(
					'id'         => 'custom-description',
					'type'       => 'textarea',
					'title'      => esc_html__('Custom Description', 'livi-pro'),
					'dependency' => array( 'description', '==', 'custom-description' )
				)

			);

			$options = array_merge( $options, $product_options );

			return $options;

		}

    }
}

Livi_Shop_Metabox_Single_CT::instance();