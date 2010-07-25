<?php
/**
 * The Sidebar containing the primary and secondary widget areas.
 *
 * @package WordPress
 * @subpackage Quanquan
 * @since Quanquan 1.0
 */
?>

		<div id="primary" class="widget-area" role="complementary">
			<ul class="xoxo">

<?php
	/* When we call the dynamic_sidebar() function, it'll spit out
	 * the widgets for that widget area. If it instead returns false,
	 * then the sidebar simply doesn't exist, so we'll hard-code in
	 * some default sidebar stuff just in case.
	 */
	if ( ! dynamic_sidebar( 'primary-widget-area' ) ) : ?>
			<li class="widget-container">
				<h2><?php echo __('Search');?></h2>
				<div class="line"></div>
			</li>
			<li id="search" class="widget-container widget_search">
				<?php get_search_form(); ?>
			</li>

			<li id="archives" class="widget-container">
				<h2 class="widget-title"><?php _e( 'Links', 'quanquan' ); ?></h2>
				<div class="line"></div>
				<ul>
					
					<?php quanquan_get_links(); ?>
				</ul>
			</li>
			
			<li id="meta" class="widget-container">
				<h2 class="widget-title"><?php _e( 'Categoroies', 'quanquan' ); ?></h2>
				<div class="line"></div>
				<ul>
					<?php wp_list_categories(array('title_li'=>'','depth'=>0)); ?>
				</ul>
			</li>

		<?php endif; // end primary widget area ?>
			</ul>
		</div><!-- #primary .widget-area -->

<?php
	// A second sidebar for widgets, just because.
	if ( is_active_sidebar( 'secondary-widget-area' ) ) : ?>

		<div id="secondary" class="widget-area" role="complementary">
			<ul class="xoxo">
				<?php dynamic_sidebar( 'secondary-widget-area' ); ?>
			</ul>
		</div><!-- #secondary .widget-area -->

<?php endif; ?>
