<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Livi_Shop_Metabox_Single_Additional_Tabs' ) ) {
    class Livi_Shop_Metabox_Single_Additional_Tabs {

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
					'id'              => 'product-additional-tabs',
					'type'            => 'group',
					'title'           => esc_html__('Additional Tabs', 'livi-pro'),
					'info'            => esc_html__('Click button to add title and description.', 'livi-pro'),
					'button_title'    => esc_html__('Add New Tab', 'livi-pro'),
					'accordion_title' => esc_html__('Adding New Tab Field', 'livi-pro'),
					'fields'          => array (

						array (
							'id'          => 'tab_title',
							'type'        => 'text',
							'title'       => esc_html__('Title', 'livi-pro'),
						),

						array (
							'id'         => 'tab_description',
							'type'       => 'select',
							'title'      => esc_html__('Description', 'livi-pro'),
							'options'    => $elementor_templates,
							'info'       => esc_html__('Choose "Elementor Templates" here to use for "Description", if you choose "Custom Description" option you can provide your own content below.', 'livi-pro'),
							'attributes' => array ( 'data-depend-id' => 'tab_description' )
						),

						array (
							'id'         => 'tab_custom_description',
							'type'       => 'textarea',
							'title'      => esc_html__('Custom Description', 'livi-pro'),
							'dependency' => array ( 'tab_description', '==', 'custom-description' )
						)

					)
				)

			);

			$options = array_merge( $options, $product_options );

			return $options;

		}

    }
}

Livi_Shop_Metabox_Single_Additional_Tabs::instance();