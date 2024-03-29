<?php
/**
 *
 * show page navigation numbers
 *
 * @package WordPress
 * @subpackage quanquan
 * @since quanquan 1.0
 */
?>
<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if (  $wp_query->max_num_pages > 1 ) : ?>
				<div id="nav-below" class="navigation">
					<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'quanquan' ) ); ?></div>
					<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'quanquan' ) ); ?></div>
				</div><!-- #nav-below -->
<?php endif; ?>