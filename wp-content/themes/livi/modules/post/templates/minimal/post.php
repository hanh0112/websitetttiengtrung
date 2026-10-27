<?php
	$template_args['post_ID'] = $ID;
	$template_args['post_Style'] = $Post_Style;
	$template_args = array_merge( $template_args, livi_single_post_params() ); ?>

    <?php livi_template_part( 'post', 'templates/'.$Post_Style.'/parts/image', '', $template_args ); ?>

    <!-- Post Meta -->
    <div class="post-meta wdt-dark-bg">

    	<!-- Meta Left -->
    	<div class="meta-taxonomy-item">
             <?php livi_template_part( 'post', 'templates/'.$Post_Style.'/parts/date', '', $template_args ); ?>
    	</div><!-- Meta Left -->

		<!-- Meta Right -->
        <div class="meta-posted-item">
        </div><!-- Meta Right -->

    </div><!-- Post Meta -->

    <!-- Post Dynamic -->
    <?php echo apply_filters( 'livi_single_post_dynamic_template_part', livi_get_template_part( 'post', 'templates/'.$Post_Style.'/parts/dynamic', '', $template_args ) ); ?><!-- Post Dynamic -->