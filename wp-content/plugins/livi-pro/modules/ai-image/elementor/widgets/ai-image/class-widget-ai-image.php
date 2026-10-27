<?php
use LiviElementor\Widgets\LiviElementorWidgetBase;
use Elementor\Controls_Manager;
use Elementor\Utils;

class Elementor_Ai_Image extends LiviElementorWidgetBase {

    public function get_name() {
        return 'wdt-ai-image';
    }

    public function get_title() {
        return esc_html__('Ai Image Generator', 'livi-pro');
    }

    protected function register_controls() {

        $this->start_controls_section( 'wdt_section_general', array(
            'label' => esc_html__( 'General', 'livi-pro'),
        ) );

			$this->add_control( 'image_api_id', array(
				'type'        => Controls_Manager::TEXT,
				'label'       => esc_html__('Enter Image API key', 'livi-pro'),
				'description' => esc_html__('OpenAI API key here', 'livi-pro')
			) );

            $this->add_control( 'imageai_class', array(
                'type'        => Controls_Manager::TEXT,
                'label'       => esc_html__('Extra class name', 'livi-pro'),
                'description' => esc_html__('Style particular element differently - add a class name and refer to it in custom CSS', 'livi-pro')
            ) );

        $this->end_controls_section();

    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        extract($settings);

		$output = '';

        global $post;
        $page_id =  $post->ID;

        $output = '<div class="wdt-image-generator-wrapper  '.$imageai_class.'">';

			$output .= '<div class="wdt-image-generator-container">';
				
				$output .= '<form name="imagegenerate" class="wdt-sc-image-generate-form" id="imagegenerate">';

					$output .= '<div class="wdt-image-generator-input-wrapper">';

                        $output .= '<div class="wdt-image-generator-input-cover">';
								$output .= '<div class="wdt-image-generator-input">';
									$output .= '<input type="text" id="imagekeyname" name="searchimg" placeholder="'.esc_attr('Describe what you want to see', 'livi-pro').'" required="required">';
								$output .= '</div>';
								$output .= '<div class="wdt-submit-btn-wrapper"><input class="wdt-sc-button filed small imagegeneratebtn" type="submit" value="'.esc_attr('Generate', 'livi-pro').'"></div>';
						$output .= '</div>';

						$output .= '<div class="wdt-image-generator-input">';
								$output .= '<select name="imagecount" id="imagecount" required="required">
											<option value="1">'.esc_html('1 images', 'livi-pro').'</option>
											<option value="2">'.esc_html('2 images', 'livi-pro').'</option>
											<option value="3">'.esc_html('3 images', 'livi-pro').'</option>
											<option value="4">'.esc_html('4 images', 'livi-pro').'</option>
										</select>';
						$output .= '</div>';

					$output .= '</div>';

						$output .= '<div class="wdt-image-generator-input wdt-input-tag-wrapper">';
								$output .= '<span class="wdt-igenerator-tag-title">'.esc_html('Popular Tags:', 'livi-pro').'</span>';
								$output .= '<span class="wdt-igenerator-txt">
									<a href="javascript:void(0)" data-igenerator="'.esc_html('Animation', 'livi-pro').'">'.esc_html('Animation', 'livi-pro').'</a>
									<a href="javascript:void(0)" data-igenerator="'.esc_html('Hyper Reality', 'livi-pro').'">'.esc_html('Hyper Reality', 'livi-pro').'</a>
									<a href="javascript:void(0)" data-igenerator="'.esc_html('Fantasy', 'livi-pro').'">'.esc_html('Fantasy', 'livi-pro').'</a>
									<a href="javascript:void(0)" data-igenerator="'.esc_html('Digital Agency', 'livi-pro').'">'.esc_html('Digital Agency', 'livi-pro').'</a>
								</span>';
						$output .= '</div>';
						 
					    $output .= '<div class="wdt-image-generator-input">';
						$output .= '<input type="hidden" name="wdt_image_api_key" value="'.esc_attr($image_api_id).'" />';
					$output .= '</div>';

				$output .= '</form>';

			$output .= '</div>';
			
			$output .= '<div class="wdt-image-generator-result-container">';
				$output .= '<div class="wdt-sc-image-generate-notify"></div>';
			$output .= '</div>';

		$output .= '</div>';

		echo $output;

	}


}