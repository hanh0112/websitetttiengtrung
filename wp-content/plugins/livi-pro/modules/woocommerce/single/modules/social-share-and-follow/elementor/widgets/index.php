<?php

namespace LiviElementor\Widgets;
use LiviElementor\Widgets\Livi_Shop_Widget_Product_Summary;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;


class Livi_Shop_Widget_Product_Summary_Extend extends Livi_Shop_Widget_Product_Summary {

	function dynamic_register_controls() {

		$this->start_controls_section( 'product_summary_extend_section', array(
			'label' => esc_html__( 'Social Options', 'livi-pro' ),
		) );

			$this->add_control( 'share_follow_type', array(
				'label'   => esc_html__( 'Share / Follow Type', 'livi-pro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'share',
				'options' => array(
					''       => esc_html__('None', 'livi-pro'),
					'share'  => esc_html__('Share', 'livi-pro'),
					'follow' => esc_html__('Follow', 'livi-pro'),
				),
				'description' => esc_html__( 'Choose between Share / Follow you would like to use.', 'livi-pro' ),
			) );

			$this->add_control( 'social_icon_style', array(
				'label'   => esc_html__( 'Social Icon Style', 'livi-pro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					'simple'        => esc_html__( 'Simple', 'livi-pro' ),
					'bgfill'        => esc_html__( 'BG Fill', 'livi-pro' ),
					'brdrfill'      => esc_html__( 'Border Fill', 'livi-pro' ),
					'skin-bgfill'   => esc_html__( 'Skin BG Fill', 'livi-pro' ),
					'skin-brdrfill' => esc_html__( 'Skin Border Fill', 'livi-pro' ),
				),
				'description' => esc_html__( 'This option is applicable for all buttons used in product summary.', 'livi-pro' ),
				'condition'   => array( 'share_follow_type' => array ('share', 'follow') )
			) );

			$this->add_control( 'social_icon_radius', array(
				'label'   => esc_html__( 'Social Icon Radius', 'livi-pro' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					'square'  => esc_html__( 'Square', 'livi-pro' ),
					'rounded' => esc_html__( 'Rounded', 'livi-pro' ),
					'circle'  => esc_html__( 'Circle', 'livi-pro' ),
				),
				'condition'   => array(
					'social_icon_style' => array ('bgfill', 'brdrfill', 'skin-bgfill', 'skin-brdrfill'),
					'share_follow_type' => array ('share', 'follow')
				),
			) );

			$this->add_control( 'social_icon_inline_alignment', array(
				'label'        => esc_html__( 'Social Icon Inline Alignment', 'livi-pro' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'yes', 'livi-pro' ),
				'label_off'    => esc_html__( 'no', 'livi-pro' ),
				'default'      => '',
				'return_value' => 'true',
				'description'  => esc_html__( 'This option is applicable for all buttons used in product summary.', 'livi-pro' ),
				'condition'   => array( 'share_follow_type' => array ('share', 'follow') )
			) );

		$this->end_controls_section();

	}

}