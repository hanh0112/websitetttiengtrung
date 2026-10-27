<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>

<?php
if( ! post_password_required() && ( comments_open() || get_comments_number() ) ) { ?>
	<!-- Entry Comment -->
	<div class="entry-comments"><?php
		echo '<div class="wdt-comments-wrapper"><i class="wdticon-comment"> </i>';
			comments_popup_link(); 
		echo '</div>';?>
	</div><!-- Entry Comment --><?php
}
?>