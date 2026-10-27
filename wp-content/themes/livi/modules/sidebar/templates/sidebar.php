<?php
$sidebar_class   = livi_get_secondary_classes();
$active_sidebars = livi_get_active_sidebars();

if( $sidebar_class == 'content-full-width' || $sidebar_class == '' ) {
    return;
}

if( empty( $active_sidebars ) ) {
    return;
}?>
<!-- Secondary -->
<section id="secondary" class="<?php echo esc_attr( $sidebar_class ); ?>"><div class="wdt-sidebar-wrapper"><?php
    do_action( 'livi_before_single_sidebar_wrap' );

    get_sidebar();

    do_action( 'livi_after_single_sidebar_wrap' );?>
</div></section><!-- Secondary End -->