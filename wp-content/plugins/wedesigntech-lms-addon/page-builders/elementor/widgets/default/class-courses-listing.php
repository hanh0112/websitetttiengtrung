<?php
namespace DTElementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class DTLMSDfCoursesListing extends Widget_Base {

	public function get_categories() {
		return [ 'dtlms-default-widgets' ];
	}

	public function get_name() {
		return 'dtlms-widget-default-courses-listing';
	}

	public function get_title() {
		return esc_html__( 'Courses Listing', 'dtlms' );
	}

	public function get_style_depends() {
		return array ();
	}

	public function get_script_depends() {
		return array ();
	}

    protected function _register_controls() {

		$instructor_label = apply_filters( 'instructor_label', 'singular' );
		$dtlms_pages_list = array ();
		$dtlms_pages_list[''] = esc_html__('Default - Ajax Output', 'dtlms');
		$pages = get_pages();
		foreach ( $pages as $page ) {
			$dtlms_pages_list[ $page->ID] = $page->post_title;
		}

		$this->start_controls_section( 'default-course-listing-section', array(
			'label' => esc_html__( 'General', 'dtlms' ),
		) );
			$this->add_control( 'disable-all-filters', array(
				'label'       => esc_html__( 'Disable All Filter Options', 'dtlms' ),
				'type'        => Controls_Manager::SELECT,
				'label_block' => true,
				'options'     => array(
					'false' => esc_html__('False', 'dtlms'),
					'true'  => esc_html__('True', 'dtlms'),
				),
				'description' => esc_html__( 'If you wish you can disable all filter options and only course content will be displayed.', 'dtlms' ),
				'default'     => 'false',
			) );
			$this->add_control( 'enable-search-filter', array(
				'label'       => esc_html__( 'Enable Search Filter', 'dtlms' ),
				'type'        => Controls_Manager::SELECT,
				'label_block' => true,
				'options'     => array(
					'false' => esc_html__('False', 'dtlms'),
					'true'  => esc_html__('True', 'dtlms'),
				),
				'description' => esc_html__( 'If you wish you can enable search filter option.', 'dtlms' ),
				'default'     => 'false',
				'condition'   => array( 'disable-all-filters' => 'false' )
			) );
			$this->add_control( 'enable-display-filter', array(
				'label'       => esc_html__( 'Enable Display Filter', 'dtlms' ),
				'type'        => Controls_Manager::SELECT,
				'label_block' => true,
				'options'     => array(
					'false' => esc_html__('False', 'dtlms'),
					'true'  => esc_html__('True', 'dtlms'),
				),
				'description' => esc_html__( 'If you wish you can enable display filter option.', 'dtlms' ),
				'default'     => 'false',
				'condition'   => array( 'disable-all-filters' => 'false' )
			) );
			$this->add_control( 'enable-orderby-filter', array(
				'label'       => esc_html__( 'Enable Order By Filter', 'dtlms' ),
				'type'        => Controls_Manager::SELECT,
				'label_block' => true,
				'options'     => array(
					'false' => esc_html__('False', 'dtlms'),
					'true'  => esc_html__('True', 'dtlms'),
				),
				'description' => esc_html__( 'If you wish you can enable orderby filter option.', 'dtlms' ),
				'default'     => 'false',
				'condition'   => array( 'disable-all-filters' => 'false' )
			) );
			$this->add_control( 'enable-category-filter', array(
				'label'       => esc_html__( 'Enable Category Filter', 'dtlms' ),
				'type'        => Controls_Manager::SELECT,
				'label_block' => true,
				'options'     => array(
					'false' => esc_html__('False', 'dtlms'),
					'true'  => esc_html__('True', 'dtlms'),
				),
				'description' => esc_html__( 'If you wish you can enable category filter option.', 'dtlms' ),
				'default'     => 'false',
				'condition'   => array( 'disable-all-filters' => 'false' )
			) );
			$this->add_control( 'enable-instructor-filter', array(
				'label'       => sprintf(esc_html__('Enable %s Filter', 'dtlms'), $instructor_label),
				'type'        => Controls_Manager::SELECT,
				'label_block' => true,
				'options'     => array(
					'false' => esc_html__('False', 'dtlms'),
					'true'  => esc_html__('True', 'dtlms'),
				),
				'description' => esc_html__( 'If you wish you can enable instructor filter option.', 'dtlms' ),
				'default'     => 'false',
				'condition'   => array( 'disable-all-filters' => 'false' )
			) );
			$this->add_control( 'enable-cost-filter', array(
				'label'       => esc_html__( 'Enable Cost Filter', 'dtlms' ),
				'type'        => Controls_Manager::SELECT,
				'label_block' => true,
				'options'     => array(
					'false' => esc_html__('False', 'dtlms'),
					'true'  => esc_html__('True', 'dtlms'),
				),
				'description' => esc_html__( 'If you wish you can enable cost filter option.', 'dtlms' ),
				'default'     => 'false',
				'condition'   => array( 'disable-all-filters' => 'false' )
			) );
			$this->add_control( 'enable-date-filter', array(
				'label'       => esc_html__( 'Enable Date Filter', 'dtlms' ),
				'type'        => Controls_Manager::SELECT,
				'label_block' => true,
				'options'     => array(
					'false' => esc_html__('False', 'dtlms'),
					'true'  => esc_html__('True', 'dtlms'),
				),
				'description' => esc_html__( 'If you wish you can enable date filter option.', 'dtlms' ),
				'default'     => 'false',
				'condition'   => array( 'disable-all-filters' => 'false' )
			) );
			$this->add_control( 'listing-output-page', array(
				'label'       => esc_html__( 'Listing Output Page', 'dtlms' ),
				'type'        => Controls_Manager::SELECT,
				'label_block' => true,
				'options'     => $dtlms_pages_list,
				'description' => esc_html__( 'If you choose a page here course search result will be outputed in that page. For that you have to add this course listing shortcode again in that page.', 'dtlms' ),
			) );
			$this->add_control( 'default-filter', array(
				'label'       => esc_html__( 'Default Filter', 'dtlms' ),
				'type'        => Controls_Manager::SELECT,
				'label_block' => true,
				'options'     => array(
					''                      => esc_html__('None', 'dtlms'),
					'upcoming-courses'      => esc_html__('Upcoming Courses', 'dtlms'),
					'recent-courses'        => esc_html__('Recent Courses', 'dtlms'),
					'highest-rated-courses' => esc_html__('Highest Rated Courses', 'dtlms'),
					'most-membered-courses' => esc_html__('Most Membered Courses', 'dtlms'),
					'paid-courses'          => esc_html__('Paid Courses', 'dtlms'),
					'free-courses'          => esc_html__('Free Courses', 'dtlms'),
				),
				'condition'   => array( 'disable-all-filters' => 'true' ),
				'default'     => '',
				'description' => esc_html__( 'Choose default filter you like to apply in courses listing. This option is not applicable if "Default - Ajax Output" is not chosen in "Listing Output Page".', 'dtlms' ),
			) );
			$this->add_control( 'course-item-ids', array(
				'label'       => esc_html__('Course Item Ids','dtlms'),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter course item ids separated by comma to display from. This option is not applicable if "Default - Ajax Output" is not chosen in "Listing Output Page".', 'dtlms' ),
				'condition'   => array( 'disable-all-filters' => 'true' ),
			) );
			$this->add_control( 'course-category-ids', array(
				'label'       => esc_html__('Course Category Ids','dtlms'),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Enter course category separated by comma to display from. This option is not applicable if "Default - Ajax Output" is not chosen in "Listing Output Page".', 'dtlms' ),
				'condition'   => array( 'disable-all-filters' => 'true' ),
			) );
			$this->add_control( 'instructor-ids', array(
				'label'       => sprintf(esc_html__('%s Ids', 'dtlms'), $instructor_label),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'description' => sprintf(esc_html__('Enter %s ids separated by comma to display from. This option is not applicable if "Default - Ajax Output" is not chosen in "Listing Output Page".', 'dtlms'), $instructor_label),
				'condition'   => array( 'disable-all-filters' => 'true' ),
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
				'description' => esc_html__( 'If you like to apply isotope for your courses listing, choose "True". This option is not applicable if "Default - Ajax Output" is not chosen in "Listing Output Page". "Apply Isotope" won\'t work along with "Carousel".', 'dtlms' ),
			) );
			$this->add_control( 'enable-category-isotope-filter', array(
				'label'       => esc_html__( 'Enable Category Isotope Filter', 'dtlms' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'false' => esc_html__('False', 'dtlms'),
					'true'  => esc_html__('True', 'dtlms'),
				),
				'default'     => 'false',
				'description' => esc_html__( 'You can enable category isotope filter for your course listing. This option is not applicable if "Default - Ajax Output" is not chosen in "Listing Output Page".', 'dtlms' ),
			) );
			$this->add_control( 'show-author-details', array(
				'label'       => esc_html__( 'Show Author Details', 'dtlms' ),
				'type'        => Controls_Manager::SELECT,
				'label_block' => true,
				'options'     => array(
					'false' => esc_html__('False', 'dtlms'),
					'true'  => esc_html__('True', 'dtlms'),
				),
				'default'     => 'false',
				'description' => esc_html__( 'If you like to show author details along with course. This option is not applicable if "Default - Ajax Output" is not chosen in "Listing Output Page".', 'dtlms' ),
			) );
			$this->add_control( 'default-display-type', array(
				'label'       => esc_html__( 'Display Type', 'dtlms' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'grid' => esc_html__('Grid', 'dtlms'),
					'list' => esc_html__('List', 'dtlms'),
				),
				'default'     => 'grid',
				'description' => esc_html__( 'Choose display type for your courses listing. This option is not applicable if "Default - Ajax Output" is not chosen in "Listing Output Page".', 'dtlms' ),
			) );
			$this->add_control( 'post-per-page', array(
				'label'       => esc_html__('Post Per Page', 'dtlms'),
				'label_block' => true,
				'type'        => Controls_Manager::TEXT,
				'description' => esc_html__( 'Number of posts to show. This option is not applicable if "Default - Ajax Output" is not chosen in "Listing Output Page".', 'dtlms' ),
				'default'     => '',
			) );
			$this->add_control( 'columns', array(
				'label'       => esc_html__( 'Columns', 'dtlms' ),
				'type'        => Controls_Manager::SELECT,
				'label_block' => true,
				'options'     => array(
					1 => esc_html__('I Column', 'dtlms'),
					2 => esc_html__('II Columns', 'dtlms'),
					3 => esc_html__('III Columns', 'dtlms'),
					4 => esc_html__('IV Columns', 'dtlms'),
				),
				'default' => 1,
				'description' => esc_html__( 'Number of columns you like to display your courses. III Columns option will work only if "Enable Fullwidth" is set to "True". Also III Columns option is applicable for "Grid View" only when all filters are disabled. This option is not applicable if "Default - Ajax Output" is not chosen in "Listing Output Page".', 'dtlms' ),
				'condition'   => array( 'default-display-type' => 'grid' ),
			) );
			$this->add_control( 'enable-fullwidth', array(
				'label'       => esc_html__( 'Enable Fullwidth', 'dtlms' ),
				'type'        => Controls_Manager::SELECT,
				'label_block' => true,
				'options'     => array(
					'false' => esc_html__('False', 'dtlms'),
					'true'  => esc_html__('True', 'dtlms'),
				),
				'default'     => 'false',
				'description' => esc_html__( 'If you wish you can enable fullwidth for your course listings. This option is not applicable if "Default - Ajax Output" is not chosen in "Listing Output Page".', 'dtlms' ),
			) );
			$this->add_control( 'type', array(
				'label'       => esc_html__( 'Type', 'dtlms' ),
				'type'        => Controls_Manager::SELECT,
				'label_block' => true,
				'options'     => array(
					'type1' => esc_html__('Type 1', 'dtlms'),
					'type2'  => esc_html__('Type 2', 'dtlms'),
					'type3'  => esc_html__('Type 3', 'dtlms'),
					'type4'  => esc_html__('Type 4', 'dtlms'),
					'type5'  => esc_html__('Type 5', 'dtlms'),
					'type6'  => esc_html__('Type 6', 'dtlms'),
					'type7'  => esc_html__('Type 7', 'dtlms'),
					'type8'  => esc_html__('Type 8', 'dtlms'),
					'type9'  => esc_html__('Type 9', 'dtlms')
				),
				'description' => esc_html__( 'Choose any of the available design types.', 'dtlms' ),
				'default' => 'type1'
			) );
			$this->add_control( 'show-description', array(
				'label'       => esc_html__( 'Show Description', 'dtlms' ),
				'type'        => Controls_Manager::SELECT,
				'label_block' => true,
				'options'     => array(
					''     => esc_html__('False', 'dtlms'),
					'true' => esc_html__('True', 'dtlms'),
				),
				'description' => esc_html__( 'If you like to show description along with the post.', 'dtlms' ),
				'default'     => ''
			) );
			$this->add_control( 'show-pagination', array(
				'label'       => esc_html__( 'Show Pagination', 'dtlms' ),
				'type'        => Controls_Manager::SELECT,
				'label_block' => true,
				'options'     => array(
					''     => esc_html__('False', 'dtlms'),
					'true' => esc_html__('True', 'dtlms'),
				),
				'description' => esc_html__( 'If you like to show pagination for course listings enable this.', 'dtlms' ),
				'default'     => ''
			) );
			$this->add_control( 'class', array(
				'label'       => esc_html__( 'Class', 'dtlms' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'description' => esc_html__( 'If you wish you can add additional class name here.', 'dtlms' ),
				'default'     => ''
			) );
			// Excerpt length
			$this->add_control( 'excerpt_length', array(
				'label'       => esc_html__( 'Excerpt length', 'dtlms' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'description' => esc_html__( 'Give the excerpt length here', 'dtlms' ),
				'default'     => ''
			) );
		$this->end_controls_section();

		$this->start_controls_section( 'default-course-listing-carousel-section', array(
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
			$this->add_control( 'carousel-effect', array(
				'label'       => esc_html__( 'Effect', 'dtlms' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					''     => esc_html__('Default', 'dtlms'),
					'fade' => esc_html__('Fade', 'dtlms'),
				),
				'description' => esc_html__( 'Choose effect for your carousel. Slides Per View has to be 1 for Fade effect.', 'dtlms' ),
				'default'     => '',
				'condition'   => array( 'enable-carousel' => 'true' ),

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
				'default'     => '',
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
				'default'     => '',
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
		echo do_shortcode('[dtlms_courses_listing '.$attributes.' /]');
    }

}