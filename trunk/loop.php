<?php
/**
 * The loop that displays posts.
 *
 * The loop displays the posts and the post content.  See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop.php or
 * loop-template.php, where 'template' is the loop context
 * requested by a template. For example, loop-index.php would
 * be used if it exists and we ask for the loop with:
 * <code>get_template_part( 'loop', 'index' );</code>
 *
 * @package WordPress
 * @subpackage quanquan
 * @since quanquan 1.0
 */
?>

<div id="partLeft">
	<h2><?php printf( __( 'Category Archives: %s', 'quanquan' ), '<span>' . single_cat_title( '', false ) . '</span>' );?></h2>
	<div class="line"></div>

<?php /* If there are no posts to display, such as an empty archive page */ ?>
<?php if ( ! have_posts() ) : ?>
	<div id="post-0" class="post error404 not-found">
		<h1 class="entry-title"><?php _e( 'Not Found', 'quanquan' ); ?></h1>
		<div class="entry-content">
			<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'quanquan' ); ?></p>
			<?php get_search_form(); ?>
		</div><!-- .entry-content -->
	</div><!-- #post-0 -->
<?php endif; ?>

<?php
	/* Start the Loop.
	 *
	 * In Twenty Ten we use the same loop in multiple contexts.
	 * It is broken into three main parts: when we're displaying
	 * posts that are in the gallery category, when we're displaying
	 * posts in the asides category, and finally all other posts.
	 *
	 * Additionally, we sometimes check for whether we are on an
	 * archive page, a search page, etc., allowing for small differences
	 * in the loop on each template without actually duplicating
	 * the rest of the loop that is shared.
	 *
	 * Without further ado, the loop:
	 */ ?>
	<div>
<?php 
$num = 0;
while ( have_posts() ) : the_post(); 
	$id = $post->ID; 
	$first = $num%4 ? "":"First";

?>

<?php /* How to display posts in the Gallery category. */ ?>

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
<?php $num++;?>
<?php endwhile; // End the loop. Whew. ?>
	<div class="clr"></div>
	</div>
<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if (  $wp_query->max_num_pages > 1 ) : ?>
				<div id="nav-below" class="navigation">
					<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'quanquan' ) ); ?></div>
					<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'quanquan' ) ); ?></div>
				</div><!-- #nav-below -->
<?php endif; ?>
</div>
<div id="partRight">
	<?php get_sidebar(); ?>
</div>
