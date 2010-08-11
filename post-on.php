<?php
/**
 *
 * show date and comments' number
 *
 * @package WordPress
 * @subpackage quanquan
 * @since quanquan 1.0
 */
?>
			<span class="featuredDate"><?php echo get_the_date();?></span>
			<span class="featuredComment"><a href="<?php echo get_permalink($post->ID); ?>#respond" title="<?php __('Leave a comment','quanquan'); ?>" rel="bookmark"><?php echo $post->comment_count;?></a></span>
			<div class="clr"></div>

