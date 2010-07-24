

<div id="partLeft">
	<h2><?php echo __('LATEST POST');?></h2>
	<div class="line"></div>
<?php 
$postFeatured = get_left_posts();
$num = 0;
foreach($postFeatured as $p) :
	$post = $p;
	$id = $p->ID; 
	$first = $num%4 ? "":"First";
?>
	<div id="post-<?php echo $id;?>" class="latestPost<?php echo $first;?>">
		<?php get_the_post_thumbnail($id)?>
		<div class="thumbnailGroup">
			<div class="thumbnail"><?php echo get_the_post_thumbnail($id,'thumbnail'); ?></div>
			<div class="latestTitle">
				<div class="latestTitleLayer">
					<a href="<?php echo get_permalink($id); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'quanquan' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php echo get_the_title($id); ?></a>
				</div>
			</div>
		</div>
		<div class="latestMeta">
			<span class="latestDate"><?php echo get_the_date();?></span>
			<span class="latestComment"><a href="<?php echo get_permalink($id); ?>#respond" title="<?php __('Leave a comment'); ?>" rel="bookmark"><?php echo $p->comment_count;?></a></span>
			<div class="clr"></div>
		</div>
		<div class="description"><?php echo utf8substr($p->post_content); ?></div>
		<div class="moreLink"><a href="<?php echo get_permalink($id); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'quanquan' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php echo __('Continue Reading...'); ?></a></div>
	</div>
<?php 	
	$num++;
endforeach;
?>
</div>
<div id="partRight">
	<?php get_sidebar(); ?>
</div>

