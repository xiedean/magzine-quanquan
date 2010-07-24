


	<h2><?php echo __('FEATURED');?></h2>
	<div class="line"></div>
<?php 
$postFeatured = get_featured_posts();
$num = 0;
foreach($postFeatured as $p) :
	$post = $p;
	$id = $p->ID; 
	$first = $num ? "":"First";
?>
	<div id="post-<?php echo $id;?>" class="featuredPost<?php echo $first;?>">
		<?php get_the_post_thumbnail($id)?>
		<div class="thumbnail"><?php echo get_the_post_thumbnail($id,'featured-post-thumbnail'); ?></div>
		<div class="featuredTitle"><a href="<?php echo get_permalink($id); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'quanquan' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php echo get_the_title($id); ?></a></div>
		<div class="featuredMeta">
			<span class="featuredDate"><?php echo get_the_date();?></span>
			<span class="featuredComment"><a href="<?php echo get_permalink($id); ?>#respond" title="<?php __('Leave a comment'); ?>" rel="bookmark"><?php echo $p->comment_count;?></a></span>
			<div class="clr"></div>
		</div>
		<div class="description"><?php echo utf8substr($p->post_content); ?></div>
		<div class="moreLink"><a href="<?php echo get_permalink($id); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'quanquan' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php echo __('Continue Reading...'); ?></a></div>
	</div>
<?php 	
	$num++;
endforeach;
?>

