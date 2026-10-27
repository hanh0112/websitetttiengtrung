<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<!-- Entry Navigation -->
<div class="entry-post-navigation <?php echo esc_attr($select_post_navigation); ?>"><?php
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
				<p><a href="<?php echo get_permalink( $prev_post->ID ); ?>" title="<?php echo esc_attr($prev_post->post_title); ?>"><?php esc_html_e('Previous','livi'); ?></a></p>
				<h3><a href="<?php echo get_permalink( $prev_post->ID ); ?>" title="<?php echo esc_attr($prev_post->post_title); ?>"><?php
					if( get_the_title( $prev_post->ID ) == '') {
						echo esc_html__('Previous Post', 'livi');
					} else {
						echo "$prev_post->post_title";
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
				<h3><?php echo esc_html__('No previous story to show!', 'livi'); ?></h3>
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
				<p><a href="<?php echo get_permalink( $next_post->ID ); ?>" title="<?php echo esc_attr($next_post->post_title); ?>"><?php esc_html_e('Next','livi'); ?></a></p>
				<span class="next-post"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 50 50" xml:space="preserve"><g><g><g><g><path d="M48.8,25L24,4.6L18.9,11l17,14l-17,14l5.1,6.4L48.8,25z"></path></g></g></g><g><g><g><path d="M6.4,45.4L31.1,25L6.4,4.6L1.2,11l17,14l-17,14L6.4,45.4z"></path></g></g></g></g></svg></span>
				<h3><a href="<?php echo get_permalink( $next_post->ID ); ?>" title="<?php echo esc_attr($next_post->post_title); ?>"><?php
					if(get_the_title( $next_post->ID ) == '') {
						echo esc_html__('Next Post', 'livi');
					} else {
						echo "$next_post->post_title";
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
				<h3><?php echo esc_html__('No next story to show!', 'livi'); ?></h3>
			</div>
		</div>
		<?php
	endif; ?>
</div><!-- Entry Navigation -->