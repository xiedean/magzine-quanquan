<?php
/**
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage quanquan
 * @since quanquan 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * Used to set the width of images and content. Should be equal to the width the theme
 * is designed for, generally via the style.css stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640;

/** Tell WordPress to run quanquan_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'quanquan_setup' );

if ( ! function_exists( 'quanquan_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override quanquan_setup() in a child theme, add your own quanquan_setup to your child theme's
 * functions.php file.
 *
 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
 * @uses register_nav_menus() To add support for navigation menus.
 * @uses add_custom_background() To add support for a custom background.
 * @uses add_editor_style() To style the visual editor.
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_custom_image_header() To add support for a custom header.
 * @uses register_default_headers() To register the default custom header images provided with the theme.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Twenty Ten 1.0
 */
function quanquan_setup() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'twentyten', TEMPLATEPATH . '/languages' );

	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'quanquan' ),
	) );


}
endif;

$post_used = '';
function get_featured_posts()
{ 
	global $wpdb,$post_used;
	$posts = array();
	$categories = get_categories();
	foreach($categories as $cate) {
		if($post_used) { 
			$term = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->term_relationships WHERE term_taxonomy_id = '$cate->term_id' AND object_id NOT IN ($post_used) ORDER BY object_id DESC"));
			$post_used .= ','.$term->object_id;
		} else  {
			$term = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->term_relationships WHERE term_taxonomy_id = '$cate->term_id' ORDER BY object_id DESC"));
			
			$post_used = $term->object_id;
		}
		//echo $term->object_id."<br/>";
		$posts[] = get_post($term->object_id);

	}

	return $posts;
}

function get_left_posts() 
{
	global $post_used;
	return get_posts(array('exclude'=>$post_used));
}