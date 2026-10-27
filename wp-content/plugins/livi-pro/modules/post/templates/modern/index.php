<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( !class_exists( 'LiviProPostModern' ) ) {
    class LiviProPostModern {

        private static $_instance = null;

        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        function __construct() {
            add_filter( 'livi_post_styles', array( $this, 'add_post_styles_option' ) );
            add_action( 'livi_hook_container_before', array( $this, 'add_post_hook_container_before' ) );
        }

        function add_post_styles_option( $options ) {
            $options['modern'] = esc_html__('Modern', 'livi-pro');
            return $options;
        }

        function add_post_hook_container_before() {

            if(is_singular('post')) {

                $post_id = get_the_ID();

                $post_meta = get_post_meta( $post_id, '_livi_post_settings', TRUE );
                $post_meta = is_array( $post_meta ) ? $post_meta  : array();
                $post_style = !empty( $post_meta['single_post_style'] ) ? $post_meta['single_post_style'] : '';

                if($post_style != 'modern') {
                    return;
                }

                $template_args['post_ID'] = $post_id;
                $template_args['post_Style'] = $post_style;
                $template_args = array_merge( $template_args, livi_single_post_params() );

                ob_start();
                echo '<div class="post-modern">';
                    echo '<div class="post-single-image">';
                        livi_template_part( 'post', 'templates/'.$post_style.'/parts/image', '', $template_args );
                    echo '</div>';
                    ?>
                    <div class="entry-post-navigation"><?php
                        if( ! is_attachment() ) :
                            $prev_post = get_previous_post();
                            if( !empty( $prev_post ) ):	?>

                                <div class="post-prev-link"><?php
                                    if( has_post_thumbnail( $prev_post->ID ) ):
                                        $entry_bg = '';
                                        $url = get_the_post_thumbnail_url( $prev_post->ID, 'full' );
                                        $entry_bg = "style=background-image:url(".$url.")"; ?>

                                        <a href="<?php echo get_permalink( $prev_post->ID ); ?>" <?php echo esc_attr($entry_bg);?> class="prev-post-bgimg"></a><?php
                                    endif; ?>

                                    <div class="nav-title-wrap">
                                        <span class="prev-icon"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 50 50" xml:space="preserve"><g><g><g><path d="M1,25L26,4.5l5.2,6.4L14.1,25l17.1,14.1L26,45.5L1,25z"></path></g></g></g><g><g><g><path d="M43.8,45.5L18.8,25l25-20.5l5.2,6.4L31.8,25L49,39.1L43.8,45.5z"></path></g></g></g></svg></span>
                                        <p><a href="<?php echo get_permalink( $prev_post->ID ); ?>" title="<?php echo esc_attr($prev_post->post_title); ?>"><?php esc_html_e('Prev','livi-pro'); ?></a></p>
                                        <h3><a href="<?php echo get_permalink( $prev_post->ID ); ?>" title="<?php echo esc_attr($prev_post->post_title); ?>"><?php
                                            if( get_the_title( $prev_post->ID ) == '') {
                                                echo esc_html__('Previous Post', 'livi-pro');
                                            } else {
                                                livi_html_output($prev_post->post_title);
                                            } ?></a>
                                        </h3>
                                    </div>

                                </div>
                                <?php
                            else: ?>
                                <div class="post-prev-link no-post">
                                    <a href="#" style="background-image:url(<?php echo esc_url(LIVI_ROOT_URI.'/assets/images/no-post.jpg') ?>);" class="prev-post-bgimg"></a>
                                    <div class="nav-title-wrap">
                                    <!-- <span class="prev-icon"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 50 50" xml:space="preserve"><g><g><g><path d="M1,25L26,4.5l5.2,6.4L14.1,25l17.1,14.1L26,45.5L1,25z"></path></g></g></g><g><g><g><path d="M43.8,45.5L18.8,25l25-20.5l5.2,6.4L31.8,25L49,39.1L43.8,45.5z"></path></g></g></g></svg></span> -->
                                        <h3><?php echo esc_html__('No previous story to show!', 'livi-pro'); ?></h3>
                                    </div>
                                </div>
                                <?php
                            endif;

                            $next_post = get_next_post();
                            if( !empty( $next_post ) ):	?>
                                <div class="post-next-link"><?php

                                    if( has_post_thumbnail( $next_post->ID ) ):
                                        $entry_bg = '';
                                        $url = get_the_post_thumbnail_url( $next_post->ID, 'full' );
                                        $entry_bg = "style=background-image:url(".$url.")"; ?>

                                        <a href="<?php echo get_permalink( $next_post->ID ); ?>" <?php echo esc_attr($entry_bg);?> class="next-post-bgimg"></a><?php
                                    endif; ?>

                                    <div class="nav-title-wrap">
                                    <span class="next-post"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 50 50" xml:space="preserve"><g><g><g><g><path d="M48.8,25L24,4.6L18.9,11l17,14l-17,14l5.1,6.4L48.8,25z"></path></g></g></g><g><g><g><path d="M6.4,45.4L31.1,25L6.4,4.6L1.2,11l17,14l-17,14L6.4,45.4z"></path></g></g></g></g></svg></span>
                                        <p><a href="<?php echo get_permalink( $next_post->ID ); ?>" title="<?php echo esc_attr($next_post->post_title); ?>"><?php esc_html_e('Next','livi-pro'); ?></a></p>
                                        <h3><a href="<?php echo get_permalink( $next_post->ID ); ?>" title="<?php echo esc_attr($next_post->post_title); ?>"><?php
                                            if(get_the_title( $next_post->ID ) == '') {
                                                echo esc_html__('Next Post', 'livi-pro');
                                            } else {
                                                livi_html_output($next_post->post_title);
                                            } ?></a>
                                        </h3>
                                    </div>

                                </div>
                                <?php
                            else: ?>
                                <div class="post-next-link no-post">
                                    <a href="#" style="background-image:url(<?php echo esc_url(LIVI_ROOT_URI.'/assets/images/no-post.jpg') ?>);" class="next-post-bgimg"></a>
                                    <div class="nav-title-wrap">
                                    <!-- <span class="next-post"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 50 50" xml:space="preserve"><g><g><g><g><path d="M48.8,25L24,4.6L18.9,11l17,14l-17,14l5.1,6.4L48.8,25z"></path></g></g></g><g><g><g><path d="M6.4,45.4L31.1,25L6.4,4.6L1.2,11l17,14l-17,14L6.4,45.4z"></path></g></g></g></g></svg></span> -->
                                        <h3><?php echo esc_html__('No next story to show!', 'livi-pro'); ?></h3>
                                    </div>
                                </div>
                                <?php
                            endif;
                        endif; ?>
                    </div>
                    <?php
                echo '</div>';
                echo ob_get_clean();

            }

        }
    }
}

LiviProPostModern::instance();