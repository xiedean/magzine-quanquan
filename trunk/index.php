
<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query. 
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Quanquan
 * @since quanquan 1.0
 */

get_header(); ?>

		<div id="container">
			<div id="featured">
				<?php get_template_part('featured','index');?>
				<div class="clr"></div>
			</div><!-- #featured -->
			
			<div id="latest">
				<?php get_template_part( 'latest', 'index' );?>
				<div class="clr"></div>
			</div><!-- #latest -->
		</div><!-- #container -->


<?php get_footer(); ?>

