<?php
/**
 * Recommends plugins for use with the theme via the TGMA Script
 *
 * @package Livi WordPress theme
 */

function livi_tgmpa_plugins_register() {

	// Get array of recommended plugins.
	$plugins_list = array(

        array(
            'name'               => esc_html__('Livi Plus', 'livi'),
            'slug'               => 'livi-plus',
            'source'             => LIVI_MODULE_DIR . '/plugins/livi-plus.rar',
            'required'           => true,
            'version'            => '1.0.2',
            'force_activation'   => false,
            'force_deactivation' => false,
        ),
        array(
            'name'               => esc_html__('Livi Pro', 'livi'),
            'slug'               => 'livi-pro',
            'source'             => LIVI_MODULE_DIR . '/plugins/livi-pro.rar',
            'required'           => true,
            'version'            => '1.0.4',
            'force_activation'   => false,
            'force_deactivation' => false,
        ),
        array(
            'name'               => esc_html__('WeDesignTech Elementor Addon', 'livi'),
            'slug'               => 'wedesigntech-elementor-addon',
            'source'             => LIVI_MODULE_DIR . '/plugins/wedesigntech-elementor-addon.rar',
            'required'           => true,
            'version'            => '1.0.4',
            'force_activation'   => false,
            'force_deactivation' => false,
        ),
        array(
            'name'               => esc_html__('WeDesignTech LMS Addon', 'livi'),
            'slug'               => 'wedesigntech-lms-addon',
            'source'             => LIVI_MODULE_DIR . '/plugins/wedesigntech-lms-addon.rar',
            'required'           => true,
            'version'            => '1.0.1',
            'force_activation'   => false,
            'force_deactivation' => false,
        ),
        array(
            'name'               => esc_html__('Livi Shop', 'livi'),
            'slug'               => 'livi-shop',
            'source'             => LIVI_MODULE_DIR . '/plugins/livi-shop.rar',
            'required'           => false,
            'version'            => '1.0.1',
            'force_activation'   => false,
            'force_deactivation' => false,
        ),
        array(
            'name'     => esc_html__('Elementor', 'livi'),
            'slug'     => 'elementor',
            'required' => true,
        ),
        array(
            'name'     => esc_html__('Contact Form 7', 'livi'),
            'slug'     => 'contact-form-7',
            'required' => true,
        ),
        array(
            'name'     => esc_html__('The Events Calendar', 'livi'),
            'slug'     => 'the-events-calendar',
            'required' => true,
        ),
        array(
            'name'     => esc_html__('One Click Demo Import', 'livi'),
            'slug'     => 'one-click-demo-import',
            'required' => true,
        ),
        array(
            'name'     => esc_html__('WooCommerce', 'livi'),
            'slug'     => 'woocommerce',
            'required' => false,
        )
	);

    $plugins = apply_filters('livi_required_plugins_list', $plugins_list);

	// Register notice
	tgmpa( $plugins, array(
		'id'           => 'livi_theme',
		'domain'       => 'livi',
		'menu'         => 'install-required-plugins',
		'has_notices'  => true,
		'is_automatic' => true,
		'dismissable'  => true,
	) );

}
add_action( 'tgmpa_register', 'livi_tgmpa_plugins_register' );