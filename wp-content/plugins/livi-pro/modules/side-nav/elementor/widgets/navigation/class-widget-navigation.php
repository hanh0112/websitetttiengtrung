<?php
use LiviElementor\Widgets\LiviElementorWidgetBase;
use Elementor\Controls_Manager;
use Elementor\Utils;

class Elementor_Side_Nav_Navigation extends LiviElementorWidgetBase {

    public function get_name() {
        return 'wdt-side-nav-navigation';
    }

    public function get_title() {
        return esc_html__('Side Nav - Navigation', 'livi-pro');
    }

    protected function register_controls() {

        $this->start_controls_section( 'wdt_section_general', array(
            'label' => esc_html__( 'General', 'livi-pro'),
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

		$output = '';

        global $post;
        $page_id =  $post->ID;

        $args   = array('child_of' => $page_id,'title_li' => '','sort_order'=> 'ASC','sort_column' => 'menu_order');
        $parent = wp_get_post_parent_id( $page_id );

        if( $parent ) {
            $args = array('child_of' => $parent,'title_li' => '','sort_order'=> 'ASC','sort_column' => 'menu_order');
        }

        $pages = get_pages( $args );
        $page_ids = array();

        foreach($pages as $page) {
            $page_ids[] = $page->ID;
        }

        $key = array_search ($page_id, $page_ids);
        $prev_page_key = $this->get_previous_key_array($page_ids, $key);
        $prev_page_id = isset($page_ids[$prev_page_key]) ? $page_ids[$prev_page_key] : -1;
        $next_page_key = $this->get_next_key_array($page_ids, $key);
        $next_page_id = isset($page_ids[$next_page_key]) ? $page_ids[$next_page_key] : -1;

        $output .= '<div class="wdt-sidenav-navigation-container '.esc_attr( $el_class ).'">';

            if($prev_page_id >= 0) {

                $output .= '<div class="wdt-sidenav-navigation-prev-wrapper">';
                    if(has_post_thumbnail($prev_page_id)) {
                        $url = get_the_post_thumbnail_url($prev_page_id, 'full');
                        $output .= '<a href="'.get_permalink($prev_page_id).'" style="background-image:url('.esc_url($url).');" class="wdt-sidenav-navigation-prev-bgimg"></a>';
                    }
                    $output .= '<div class="wdt-sidenav-navigation-title-wrapper">';
                        $output .= '<p><a href="'.get_permalink($prev_page_id).'" title="'.esc_attr(get_the_title($prev_page_id)).'">'.esc_html__('Previous Page','livi-pro').'</a></p>';
                        $output .= '<span class="prev-icon"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 50 50" xml:space="preserve"><g><g><g><path d="M1,25L26,4.5l5.2,6.4L14.1,25l17.1,14.1L26,45.5L1,25z"></path></g></g></g><g><g><g><path d="M43.8,45.5L18.8,25l25-20.5l5.2,6.4L31.8,25L49,39.1L43.8,45.5z"></path></g></g></g></svg></span>';
                        $output .= '<h3><a href="'.get_permalink($prev_page_id).'" title="'.esc_attr(get_the_title($prev_page_id)).'">';
                            if(get_the_title($prev_page_id)) {
                                $output .= (get_the_title($prev_page_id));
                            } else {
                                $output .= esc_html__('Previous Page', 'livi-pro');
                            }
                        $output .= '</a></h3>';
                    $output .= '</div>';
                $output .= '</div>';

            } else {

                $output .= '<div class="wdt-sidenav-navigation-prev-wrapper no-post">';
                    $output .= '<a href="#" style="background-image:url('.esc_url(LIVI_ROOT_URI.'/assets/images/no-post.jpg').');" class="wdt-sidenav-navigation-prev-bgimg"></a>';
                    $output .= '<div class="wdt-sidenav-navigation-title-wrapper">';
                        $output .= '<span class="prev-icon"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 50 50" xml:space="preserve"><g><g><g><path d="M1,25L26,4.5l5.2,6.4L14.1,25l17.1,14.1L26,45.5L1,25z"></path></g></g></g><g><g><g><path d="M43.8,45.5L18.8,25l25-20.5l5.2,6.4L31.8,25L49,39.1L43.8,45.5z"></path></g></g></g></svg></span>';
                        $output .= '<h3>'.esc_html__('No previous page to show!', 'livi-pro').'</h3>';
                    $output .= '</div>';
                $output .= '</div>';

            }

            if($next_page_id >= 0) {

                $output .= '<div class="wdt-sidenav-navigation-next-wrapper">';
                    if(has_post_thumbnail($next_page_id)) {
                        $url = get_the_post_thumbnail_url($next_page_id, 'full');
                        $output .= '<a href="'.get_permalink($next_page_id).'" style="background-image:url('.esc_url($url).')" class="wdt-sidenav-navigation-next-bgimg"></a>';
                    }
                    $output .= '<div class="wdt-sidenav-navigation-title-wrapper">';
                        $output .= '<p><a href="'.get_permalink($next_page_id).'" title="'.esc_attr(get_the_title($next_page_id)).'">'.esc_html__('Next Page','livi-pro').'</a></p>';
                        $output .= '<span class="prev-icon"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 50 50" xml:space="preserve"><g><g><g><path d="M1,25L26,4.5l5.2,6.4L14.1,25l17.1,14.1L26,45.5L1,25z"></path></g></g></g><g><g><g><path d="M43.8,45.5L18.8,25l25-20.5l5.2,6.4L31.8,25L49,39.1L43.8,45.5z"></path></g></g></g></svg></span>';
                        $output .= '<h3><a href="'.get_permalink($next_page_id).'" title="'.esc_attr(get_the_title($next_page_id)).'">';
                            if(get_the_title($next_page_id)) {
                                $output .= (get_the_title($next_page_id));
                            } else {
                                $output .= esc_html__('Next Page', 'livi-pro');
                            }
                        $output .= '</a></h3>';
                    $output .= '</div>';
                $output .= '</div>';

            } else {

                $output .= '<div class="wdt-sidenav-navigation-next-wrapper no-post">';
                    $output .= '<a href="#" style="background-image:url('.esc_url(LIVI_ROOT_URI.'/assets/images/no-post.jpg').');"  class="wdt-sidenav-navigation-next-bgimg"></a>';
                    $output .= '<div class="wdt-sidenav-navigation-title-wrapper">';
                        $output .= '<span class="prev-icon"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 50 50" xml:space="preserve"><g><g><g><path d="M1,25L26,4.5l5.2,6.4L14.1,25l17.1,14.1L26,45.5L1,25z"></path></g></g></g><g><g><g><path d="M43.8,45.5L18.8,25l25-20.5l5.2,6.4L31.8,25L49,39.1L43.8,45.5z"></path></g></g></g></svg></span>';
                        $output .= '<h3>'.esc_html__('No next page to show!', 'livi-pro').'</h3>';
                    $output .= '</div>';
                $output .= '</div>';

            }

        $output .= '</div>';

		echo $output;

	}

    protected function get_next_key_array($array, $key) {
        $nextKey = -1;
        $keys = array_keys($array);
        $position = array_search($key, $keys);
        if (isset($keys[$position + 1])) {
            $nextKey = $keys[$position + 1];
        }
        return $nextKey;
    }

    protected function get_previous_key_array($array, $key) {
        $previousKey = -1;
        $keys = array_keys($array);
        $position = array_search($key, $keys);
        if (isset($keys[$position - 1])) {
            $previousKey = $keys[$position - 1];
        }
        return $previousKey;
    }

}