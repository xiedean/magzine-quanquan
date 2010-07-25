<?php
/**
 * The template for displaying Category Archive pages.
 *
 * @package WordPress
 * @subpackage quanquan
 * @since quanquan 1.0
 */

get_header(); ?>

		<div id="container">
			<div id="categoryContent" role="main">

				
				<?php
					

				/* Run the loop for the category page to output the posts.
				 * If you want to overload this in a child theme then include a file
				 * called loop-category.php and that will be used instead.
				 */
				get_template_part( 'loop', 'category' );
				?>

			</div><!-- #content -->
		</div><!-- #container -->


<?php get_footer(); ?>
