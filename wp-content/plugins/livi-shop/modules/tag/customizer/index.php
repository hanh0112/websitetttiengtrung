<?php

/**
 * Listing Customizer - Tag Settings
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'Livi_Shop_Listing_Customizer_Tag' ) ) {

    class Livi_Shop_Listing_Customizer_Tag {

        private static $_instance = null;

        public static function instance() {

            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;

        }

        function __construct() {

            add_filter( 'livi_woo_tag_page_default_settings', array( $this, 'tag_page_default_settings' ), 10, 1 );
            add_action( 'customize_register', array( $this, 'register' ), 40);
            add_action( 'livi_hook_content_before', array( $this, 'woo_handle_product_breadcrumb' ), 10);

        }

        function tag_page_default_settings( $settings ) {

            $disable_breadcrumb             = livi_customizer_settings('wdt-woo-tag-page-disable-breadcrumb' );
            $settings['disable_breadcrumb'] = $disable_breadcrumb;

            $show_sorter_on_header              = livi_customizer_settings('wdt-woo-tag-page-show-sorter-on-header' );
            $settings['show_sorter_on_header']  = $show_sorter_on_header;

            $sorter_header_elements             = livi_customizer_settings('wdt-woo-tag-page-sorter-header-elements' );
            $settings['sorter_header_elements'] = (is_array($sorter_header_elements) && !empty($sorter_header_elements) ) ? $sorter_header_elements : array ();

            $show_sorter_on_footer              = livi_customizer_settings('wdt-woo-tag-page-show-sorter-on-footer' );
            $settings['show_sorter_on_footer']  = $show_sorter_on_footer;

            $sorter_footer_elements             = livi_customizer_settings('wdt-woo-tag-page-sorter-footer-elements' );
            $settings['sorter_footer_elements'] = (is_array($sorter_footer_elements) && !empty($sorter_footer_elements) ) ? $sorter_footer_elements : array ();

            return $settings;

        }

        function register( $wp_customize ) {

                /**
                * Option : Disable Breadcrumb
                */
                    $wp_customize->add_setting(
                        LIVI_CUSTOMISER_VAL . '[wdt-woo-tag-page-disable-breadcrumb]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new Livi_Customize_Control_Switch(
                            $wp_customize, LIVI_CUSTOMISER_VAL . '[wdt-woo-tag-page-disable-breadcrumb]', array(
                                'type'    => 'wdt-switch',
                                'label'   => esc_html__( 'Disable Breadcrumb', 'livi-shop'),
                                'section' => 'woocommerce-tag-page-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'livi-shop' ),
                                    'off' => esc_attr__( 'No', 'livi-shop' )
                                )
                            )
                        )
                    );

                /**
                 * Option : Show Sorter On Header
                 */
                    $wp_customize->add_setting(
                        LIVI_CUSTOMISER_VAL . '[wdt-woo-tag-page-show-sorter-on-header]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new Livi_Customize_Control_Switch(
                            $wp_customize, LIVI_CUSTOMISER_VAL . '[wdt-woo-tag-page-show-sorter-on-header]', array(
                                'type'    => 'wdt-switch',
                                'label'   => esc_html__( 'Show Sorter On Header', 'livi-shop'),
                                'section' => 'woocommerce-tag-page-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'livi-shop' ),
                                    'off' => esc_attr__( 'No', 'livi-shop' )
                                )
                            )
                        )
                    );

                /**
                 * Option : Sorter Header Elements
                 */
                    $wp_customize->add_setting(
                        LIVI_CUSTOMISER_VAL . '[wdt-woo-tag-page-sorter-header-elements]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control( new Livi_Customize_Control_Sortable(
                        $wp_customize, LIVI_CUSTOMISER_VAL . '[wdt-woo-tag-page-sorter-header-elements]', array(
                            'type' => 'wdt-sortable',
                            'label' => esc_html__( 'Sorter Header Elements', 'livi-shop'),
                            'section' => 'woocommerce-tag-page-section',
                            'choices' => apply_filters( 'livi_tag_header_sorter_elements', array(
                                'filter'               => esc_html__( 'Filter - OrderBy', 'livi-shop' ),
                                'filters_widget_area'  => esc_html__( 'Filters - Widget Area', 'livi-shop' ),
                                'result_count'         => esc_html__( 'Result Count', 'livi-shop' ),
                                'pagination'           => esc_html__( 'Pagination', 'livi-shop' ),
                                'display_mode'         => esc_html__( 'Display Mode', 'livi-shop' ),
                                'display_mode_options' => esc_html__( 'Display Mode Options', 'livi-shop' )
                            )),
                        )
                    ));

                /**
                 * Option : Show Sorter On Footer
                 */
                    $wp_customize->add_setting(
                        LIVI_CUSTOMISER_VAL . '[wdt-woo-tag-page-show-sorter-on-footer]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control(
                        new Livi_Customize_Control_Switch(
                            $wp_customize, LIVI_CUSTOMISER_VAL . '[wdt-woo-tag-page-show-sorter-on-footer]', array(
                                'type'    => 'wdt-switch',
                                'label'   => esc_html__( 'Show Sorter On Footer', 'livi-shop'),
                                'section' => 'woocommerce-tag-page-section',
                                'choices' => array(
                                    'on'  => esc_attr__( 'Yes', 'livi-shop' ),
                                    'off' => esc_attr__( 'No', 'livi-shop' )
                                )
                            )
                        )
                    );

                /**
                 * Option : Sorter Footer Elements
                 */
                    $wp_customize->add_setting(
                        LIVI_CUSTOMISER_VAL . '[wdt-woo-tag-page-sorter-footer-elements]', array(
                            'type' => 'option',
                        )
                    );

                    $wp_customize->add_control( new Livi_Customize_Control_Sortable(
                        $wp_customize, LIVI_CUSTOMISER_VAL . '[wdt-woo-tag-page-sorter-footer-elements]', array(
                            'type' => 'wdt-sortable',
                            'label' => esc_html__( 'Sorter Footer Elements', 'livi-shop'),
                            'section' => 'woocommerce-tag-page-section',
                            'choices' => apply_filters( 'livi_tag_footer_sorter_elements', array(
                                'filter'               => esc_html__( 'Filter', 'livi-shop' ),
                                'result_count'         => esc_html__( 'Result Count', 'livi-shop' ),
                                'pagination'           => esc_html__( 'Pagination', 'livi-shop' ),
                                'display_mode'         => esc_html__( 'Display Mode', 'livi-shop' ),
                                'display_mode_options' => esc_html__( 'Display Mode Options', 'livi-shop' )
                            )),
                        )
                    ));

        }

        function woo_handle_product_breadcrumb() {

            if(is_product_tag() && livi_customizer_settings('wdt-woo-tag-page-disable-breadcrumb' )) {
                remove_action('livi_breadcrumb', 'livi_breadcrumb_template');
            }

        }

    }

}


if( !function_exists('livi_shop_listing_customizer_tag') ) {
	function livi_shop_listing_customizer_tag() {
		return Livi_Shop_Listing_Customizer_Tag::instance();
	}
}

livi_shop_listing_customizer_tag();