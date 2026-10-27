<?php
use LiviElementor\Widgets\LiviElementorWidgetBase;
use Elementor\Controls_Manager;
use Elementor\Utils;

class Elementor_Post_Date extends LiviElementorWidgetBase {

    public function get_name() {
        return 'wdt-post-date';
    }

    public function get_title() {
        return esc_html__('Post - Date', 'livi-pro');
    }

    protected function register_controls() {

        $this->start_controls_section( 'wdt_section_general', array(
            'label' => esc_html__( 'General', 'livi-pro'),
        ) );

            $this->add_control( 'style', array(
                'type'    => Controls_Manager::SELECT,
				'label'   => esc_html__('Style', 'livi-pro'),
                'default' => '',
                'options' => array(
                    ''  => esc_html__('Default', 'livi-pro'),
                    'meta-elements-space'		 => esc_html__('Space', 'livi-pro'),
                    'meta-elements-boxed'  		 => esc_html__('Boxed', 'livi-pro'),
                    'meta-elements-boxed-curvy'  => esc_html__('Curvy', 'livi-pro'),
                    'meta-elements-boxed-round'  => esc_html__('Round', 'livi-pro'),
					'meta-elements-filled'  	 => esc_html__('Filled', 'livi-pro'),
					'meta-elements-filled-curvy' => esc_html__('Filled Curvy', 'livi-pro'),
					'meta-elements-filled-round' => esc_html__('Filled Round', 'livi-pro'),
                ),
            ) );

            $this->add_control( 'el_class', array(
                'type'        => Controls_Manager::TEXT,
                'label'       => esc_html__('Extra class name', 'livi-pro'),
                'description' => esc_html__('Style particular element differently - add a class name and refer to it in custom CSS', 'livi-pro')
            ) );

        $this->end_controls_section();

    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        extract($settings);

		$out = '';

        global $post;
        $post_id =  $post->ID;

        $Post_Style = livi_get_single_post_style( $post_id );

        $template_args['post_ID'] = $post_id;
        $template_args['post_Style'] = $Post_Style;

		$out .= '<div class="entry-date-wrapper '.$style.' '.$el_class.'">';
            $out .= livi_get_template_part( 'post', 'templates/'.$Post_Style.'/parts/date', '', $template_args );
		$out .= '</div>';

		echo $out;
	}

}