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
 * @since quanquan 1.0
 */
function quanquan_setup() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );
	add_image_size( 'featured-post-thumbnail', 300, 215,true );

	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'quanquan', TEMPLATEPATH . '/languages' );

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
	return get_posts(array('exclude'=>$post_used,'numberposts'=>8));
}


function utf8substr($str, $position = null, $length = null) 
{
	if (! $position) {
		$position = 0;
	}
	if (! $length) {
		$length = 70;
	}
	$str = str_replace ( "&nbsp;", "", $str );
	$str = str_replace ( "&ldquo;", "��", $str );
	$str = str_replace ( "&rdquo;", "��", $str );
	$str = str_replace ( "&hellip;", "��", $str );
	$str = strip_tags ( trim ( $str ) );
	$str = trim ( $str );
	$start_position = strlen ( $str );
	$start_byte = 0;
	$end_position = strlen ( $str );
	$count = 0;
	for($i = 0; $i < strlen ( $str ); $i ++) {
		if ($count >= $position && $start_position > $i) {
			$start_position = $i;
			$start_byte = $count;
		}
		if (($count - $start_byte) >= $length) {
			$end_position = $i;
			break;
		}
		$value = ord ( $str [$i] );
		if ($value > 127) {
			//            $count ++;
			if ($value >= 192 && $value <= 223)
				$i ++;
			elseif ($value >= 224 && $value <= 239)
				$i = $i + 2;
			elseif ($value >= 240 && $value <= 247)
				$i = $i + 3;
			else
				die ( 'Not a UTF-8 compatible string' );
		}
		$count ++;
	}
	if($count < $length) {
		$return = substr ( $str, $start_position, $end_position - $start_position );
	}else {
		$return = substr ( $str, $start_position, $end_position - $start_position )."...";
	}	
	return $return;
}

if ( ! function_exists( 'twentyten_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post—date/time and author.
 *
 * @since quanquan 1.0
 */
function twentyten_posted_on() {
	printf( __( '<span class="%1$s">Posted on</span> %2$s <span class="meta-sep">by</span> %3$s', 'quanquan' ),
		'meta-prep meta-prep-author',
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date()
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'quanquan' ), get_the_author() ),
			get_the_author()
		)
	);
}
endif;

if ( ! function_exists( 'twentyten_posted_in' ) ) :
/**
 * Prints HTML with meta information for the current post (category, tags and permalink).
 *
 * @since quanquan 1.0
 */
function twentyten_posted_in() {
	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		$posted_in = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'quanquan' );
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'quanquan' );
	} else {
		$posted_in = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'quanquan' );
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
}
endif;

function quanquan_posted_in() {
	echo get_the_category_list( ' / ' );
}

if ( ! function_exists( 'twentyten_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own twentyten_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since quanquan 1.0
 */
function twentyten_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>">
		<div class="comment-author vcard">
			<?php echo get_avatar( $comment, 40 ); ?>
			<?php printf( __( '%s <span class="says">says:</span>', 'quanquan' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
		</div><!-- .comment-author .vcard -->
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em><?php _e( 'Your comment is awaiting moderation.', 'quanquan' ); ?></em>
			<br />
		<?php endif; ?>

		<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
			<?php
				/* translators: 1: date, 2: time */
				printf( __( '%1$s at %2$s', 'quanquan' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', 'quanquan' ), ' ' );
			?>
		</div><!-- .comment-meta .commentmetadata -->

		<div class="comment-body"><?php comment_text(); ?></div>

		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div><!-- .reply -->
	</div><!-- #comment-##  -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'quanquan' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'quanquan'), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;

/**
 * Gets the links associated with category.
 *
 * @see get_links() for argument information that can be used in $args
 * @since 1.0.1
 * @deprecated 2.1
 * @deprecated Use wp_list_bookmarks()
 * @see wp_list_bookmarks()
 *
 * @param string $args a query string
 * @return null|string
 */
function quanquan_get_links($args = '') {
	_deprecated_function( __FUNCTION__, '0.0', 'wp_list_bookmarks()' );

	if ( strpos( $args, '=' ) === false ) {
		$cat_id = $args;
		$args = add_query_arg( 'category', $cat_id, $args );
	}

	$defaults = array(

		'categorize' => 0,
		'category' => '',
		'echo' => true,
		'limit' => -1,
		'orderby' => 'name',
		'show_description' => true,
		'show_images' => true,
		'show_rating' => false,
		'show_updated' => true,
		'title_li' => '',
	);

	$r = wp_parse_args( $args, $defaults );

	return wp_list_bookmarks($r);
}
