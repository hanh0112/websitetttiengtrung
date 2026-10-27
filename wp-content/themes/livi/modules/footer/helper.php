<?php
add_action( 'livi_after_main_css', 'footer_style' );
function footer_style() {
    wp_enqueue_style( 'livi-footer', get_theme_file_uri('/modules/footer/assets/css/footer.css'), false, LIVI_THEME_VERSION, 'all');
}

add_action( 'livi_footer', 'footer_content' );
function footer_content() {
    livi_template_part( 'content', 'content', 'footer' );
}