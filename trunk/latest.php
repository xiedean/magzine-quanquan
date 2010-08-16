<?php
/**
 * The latest posts template.
 *
 * @package WordPress
 * @subpackage Quanquan
 * @since Quanquan 1.0
 */
?>

<div id="partLeft">
	<h2><?php echo __('LATEST POST','quanquan');?></h2>
	<div class="line"></div>
<?php 
$postFeatured = get_left_posts();
if(single_cat_title('',false)){
	$postFeatured = the_post();
	var_dump($postFeatured);die();
}

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
			<?php get_template_part('post-on','index')?>
		</div>
		<div class="description"><?php echo utf8substr($p->post_content); ?></div>
		<div class="moreLink"><a href="<?php echo get_permalink($id); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'quanquan' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php echo __('Continue Reading...','quanquan'); ?></a></div>
	</div>
<?php 	
	$num++;
endforeach;
?>
<?php 
if(single_cat_title('',false)):
	get_template_part('page-navigation','index');
endif;
?>

</div>
<div id="partRight">
	<?php get_sidebar(); ?>
</div>

