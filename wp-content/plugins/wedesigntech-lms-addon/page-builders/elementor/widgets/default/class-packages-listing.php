<?php
namespace DTElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTLMSDfPackagesListing extends Widget_Base {

	public function get_categories() {
		return [ 'dtlms-default-widgets' ];
	}

	public function get_name() {
		return 'dtlms-widget-default-packages-listing';
	}

	public function get_title() {
		return esc_html__( 'Packages Listing', 'dtlms' );
	}

	public function get_style_depends() {
		return array ();
	}

	public function get_script_depends() {
		return array ();
	}

    protected function _register_controls() {
		$this->start_controls_section( 'default-package-listing-section', array(
			'label' => esc_html__( 'General', 'dtlms' ),
		) );
			$this->add_control( 'display-type', array(
				'label'       => esc_html__( 'Display Type', 'dtlms' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'grid' => esc_html__('Grid', 'dtlms'),
					'list' => esc_html__('List', 'dtlms'),
				),
				'description' => esc_html__( 'Choose display type for your packages listing.', 'dtlms' ),
				'default'     => 'grid',
			) );
			$this->add_control( 'post-per-page', array(
				'label'       => esc_html__('Post Per Page', 'dtlms'),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Number of posts to show.', 'dtlms' ),
				'default'     => -1,
			) );
			$this->add_control( 'columns', array(
				'label'       => esc_html__( 'Columns', 'dtlms' ),
				'type'        => Controls_Manager::SELECT,
				'label_block' => true,
				'options'     => array(
					1 => esc_html__('I Column', 'dtlms'),
					2 => esc_html__('II Columns', 'dtlms'),
					3 => esc_html__('III Columns', 'dtlms'),
				),
				'default'     => 1,
				'description' => esc_html__( 'Number of columns you like to display your packages.', 'dtlms' ),
			) );
			$this->add_control( 'apply-isotope', array(
				'label'       => esc_html__( 'Apply Isotope', 'dtlms' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtlms'),
					'true'  => esc_html__('True', 'dtlms'),
				),
				'default'     => 'false',
				'description' => esc_html__( 'If you like to apply isotope for your packages listing, choose "True".', 'dtlms' ),
			) );
			$this->add_control( 'type', array(
				'label'       => esc_html__( 'Type', 'dtlms' ),
				'type'        => Controls_Manager::SELECT,
				'label_block' => true,
				'options'     => array(
					'type1' => esc_html__('Type 1', 'dtlms'),
					'type2' => esc_html__('Type 2', 'dtlms'),
					'type3' => esc_html__('Type 3', 'dtlms'),
				),
				'description' => esc_html__( 'Choose any of the available design types.', 'dtlms' ),
				'default'     => 'type1'
			) );
			$this->add_control( 'package-item-ids', array(
				'label'       => esc_html__('Package Item Ids', 'dtlms'),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter package item ids separated by comma to display from.', 'dtlms' ),
			) );
		$this->end_controls_section();

		$this->start_controls_section( 'default-package-listing-carousel-section', array(
			'label'     => esc_html__( 'Carousel', 'dtlms' ),
			'condition' => array( 'apply-isotope' => 'false' ),
		) );
			$this->add_control( 'enable-carousel', array(
				'label'       => esc_html__( 'Enable Carousel', 'dtlms' ),
				'type'        => Controls_Manager::SELECT,
				'label_block' => true,
				'options'     => array(
					''     => esc_html__('False', 'dtlms'),
					'true' => esc_html__('True', 'dtlms'),
				),
				'description' => esc_html__( 'If you wish you can enable carousel for course listings. This option is not applicable if "Default - Ajax Output" is not chosen in "Listing Output Page". "Carousel" won\'t work along with "Apply Isotope".', 'dtlms' ),
				'default'     => '',
				'condition'   => array( 'apply-isotope' => 'false' ),
			) );
			$this->add_control( 'carousel-autoplay', array(
				'label'       => esc_html__( 'Auto Play', 'dtlms' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Delay between transitions ( in ms, ex. 1000 ). Leave empty if you don\'t want to auto play.', 'dtlms' ),
				'condition'   => array( 'enable-carousel' => 'true' ),
				'default'     => ''
			) );
			$this->add_control( 'carousel-slidesperview', array(
				'label'   => esc_html__( 'Slides Per View', 'dtlms' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					1 => 1,
					2 => 2,
					3 => 3,
				),
				'description' => esc_html__( 'Number slides of to show in view port. If display type is "List", 2 & 3 option in "Slides Per View" won\'t work.', 'dtlms' ),
				'default'     => 2,
				'condition'   => array( 'enable-carousel' => 'true' ),
			) );
			$this->add_control( 'carousel-loopmode', array(
				'label'   => esc_html__( 'Enable Loop Mode', 'dtlms' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'false' => esc_html__('False', 'dtlms'),
					'true'  => esc_html__('True', 'dtlms'),
				),
				'description' => esc_html__( 'If you wish you can enable continous loop mode for your carousel.', 'dtlms' ),
				'default'     => 'false',
				'condition'   => array( 'enable-carousel' => 'true' ),
			) );
			$this->add_control( 'carousel-mousewheelcontrol', array(
				'label'   => esc_html__( 'Enable Mousewheel Control', 'dtlms' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'false' => esc_html__('False', 'dtlms'),
					'true'  => esc_html__('True', 'dtlms'),
				),
				'description' => esc_html__( 'If you wish you can enable mouse wheel control for your carousel.', 'dtlms' ),
				'default'     => 'false',
				'condition'   => array( 'enable-carousel' => 'true' ),
			) );
			$this->add_control( 'carousel-bulletpagination', array(
				'label'   => esc_html__( 'Enable Bullet Pagination', 'dtlms' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'false' => esc_html__('False', 'dtlms'),
					'true'  => esc_html__('True', 'dtlms'),
				),
				'description' => esc_html__( 'To enable bullet pagination.', 'dtlms' ),
				'default'     => 'false',
				'condition'   => array( 'enable-carousel' => 'true' ),
			) );
			$this->add_control( 'carousel-arrowpagination', array(
				'label'   => esc_html__( 'Enable Arrow Pagination', 'dtlms' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'false' => esc_html__('False', 'dtlms'),
					'true'  => esc_html__('True', 'dtlms'),
				),
				'description' => esc_html__( 'To enable arrow pagination.', 'dtlms' ),
				'default'     => 'false',
				'condition'   => array( 'enable-carousel' => 'true' ),
			) );
			$this->add_control( 'carousel-spacebetween', array(
				'label'       => esc_html__( 'Space Between Sliders', 'dtlms' ),
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Space between sliders can be given here.', 'dtlms' ),
				'condition'   => array( 'enable-carousel' => 'true' ),
				'default'     => 0
			) );
		$this->end_controls_section();
	}

	protected function render() {
		$settings   = $this->get_settings();
		$settings['module_id'] = $this->get_id();
		$attributes = dtlms_elementor_instance()->dtlms_parse_shortcode_attrs( $settings );

		echo do_shortcode('[dtlms_packages_listing '.$attributes.' /]');
    }
}