<?php
/**
 * St. Augustine Civil Rights Library functions and definitions
 *
 * @package St. Augustine Civil Rights Library
 * @since St. Augustine Civil Rights Library 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since St. Augustine Civil Rights Library 1.0
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

if ( ! function_exists( 'sacr_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since St. Augustine Civil Rights Library 1.0
 */
function sacr_setup() {
	global $sacr_options;

	/**
	 * Theme Options
	 */
	require( get_template_directory() . '/inc/theme-options.php' );
	$sacr_options = new SACR_Options;

	/**
	 * Custom functions that act independently of the theme templates
	 */
	require( get_template_directory() . '/inc/extras.php' );

	/**
	 * Register Post Types
	 */
	require( get_template_directory() . '/inc/post-types.php' );

	/**
	 * Modules
	 */
	$modules = array(
		'map'      => array( 'map.php', 'rewrite.php' ),
		'timeline' => array( 'timeline.php', 'rewrite.php' ),
		'people'   => array( 'people.php' ),
		'features' => array( 'features.php' )
	);

	foreach ( $modules as $module => $files ) {
		foreach ( $files as $file ) {
			require( get_template_directory() . '/inc/' . $module . '/'  . $file );
		}
	}

	/**
	 * Admin
	 */
	if ( is_admin() ) {
		require_once( get_template_directory() . '/inc/admin/general.php' );

		foreach ( $modules as $key => $files ) {
			require_once( get_template_directory() . '/inc/' . $key . '/admin.php' );
		}
	}

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on St. Augustine Civil Rights Library, use a find and replace
	 * to change 'sacr' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'sacr', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 280, 280, true );
	add_image_size( 'hero', 1100, 430, true );
	add_image_size( 'timeline', 440, 275, true );
	add_image_size( 'biography', 273, 9999 );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'sacr' ),
		'people'  => 'People',
		'places'  => 'Places',
		'events'  => 'Events'
	) );

	add_filter( 'the_excerpt', 'do_shortcode' );
}
endif; // sacr_setup
add_action( 'after_setup_theme', 'sacr_setup' );

/**
 * Enqueue scripts and styles
 */
function sacr_scripts() {
	wp_enqueue_style( 'sacr-fonts', 'http://fonts.googleapis.com/css?family=Kreon:300,400,700|Varela+Round' );
	wp_enqueue_style( 'sacr-style', get_template_directory_uri() . '/css/style.css', array( 'sacr-fonts' ), time() );

	wp_enqueue_script( 'google-maps', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false' );
	wp_enqueue_script( 'sacr-typekit', 'http://use.typekit.net/cbu3qat.js' );
	wp_enqueue_script( 'sacr-script', get_template_directory_uri() . '/js/app.min.js', array( 'jquery', 'jquery-masonry' ), 20140131 );

	$args = array(
		'is_home'       => is_front_page(),
		'is_map'        => is_post_type_archive( 'map_point' ),
		'is_timeline'   => is_post_type_archive( 'time_period' ),
		'is_person'     => is_singular( 'person' ),
		'map_url'       => get_post_type_archive_link( 'map_point' )
	);

	wp_localize_script( 'sacr-script', 'SACRL10n', $args );
}
add_action( 'wp_enqueue_scripts', 'sacr_scripts' );

/**
 * Typekit Inilne
 */
function sacr_typekit() {
	if ( ! wp_script_is( 'sacr-typekit', 'done' ) )
		return;
?>
	<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
<?php
}
add_action( 'wp_head', 'sacr_typekit' );

function sacr_unregister_widgets() {
	unregister_widget( 'WP_Widget_Pages' );
	unregister_widget( 'WP_Widget_Calendar' );
	unregister_widget( 'WP_Widget_Archives' );
	unregister_widget( 'WP_Widget_Links' );
	unregister_widget( 'WP_Widget_Categories' );
	unregister_widget( 'WP_Widget_Recent_Posts' );
	unregister_widget( 'WP_Widget_Search' );
	unregister_widget( 'WP_Widget_Tag_Cloud' );
	unregister_widget( 'WP_Nav_Menu_Widget' );
}
add_action( 'widgets_init', 'sacr_unregister_widgets' );

if ( ! function_exists( 'sacr_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments
 * template simply create your own twentythirteen_comment(), and that function
 * will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Twenty Thirteen 1.0
 *
 * @param object $comment Comment to display.
 * @param array $args Optional args.
 * @param int $depth Depth of comment.
 * @return void
 */

function sacr_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
		<p><?php _e( 'Pingback:', 'twentythirteen' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'twentythirteen' ), '<span class="ping-meta"><span class="edit-link">', '</span></span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
	?>
	<li id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
			<div class="comment-author vcard">
				<?php echo get_avatar( $comment, 74 ); ?>
			</div><!-- .comment-author -->

			<header class="comment-meta">
				<?php
					printf( '<cite class="fn">%4$s</cite> on <a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						sprintf( _x( '%1$s at %2$s', '1: date, 2: time', 'twentythirteen' ), get_comment_date(), get_comment_time() ),
						get_comment_author_link( $comment->comment_ID )
					);
					edit_comment_link( __( 'Edit', 'twentythirteen' ), '<span class="edit-link">', '<span>' );
				?>
			</header><!-- .comment-meta -->

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'twentythirteen' ); ?></p>
			<?php endif; ?>

			<div class="comment-content">
				<?php comment_text(); ?>
			</div><!-- .comment-content -->

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'twentythirteen' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // End comment_type check.
}
endif;

function sacr_item_meta( $key, $post_id = null ) {
	global $post;

	if ( is_null( $post_id ) && is_object( $post ) )
		$post_id = $post->ID;

	$meta = get_post_meta( $post_id, $key, true );

	if ( $meta )
		return apply_filters( 'sacr_meta_' . $key, $meta );

	return false;
}

function sacr_item_year( $taxonomy = 'map_point-year', $post_id = null ) {
	return sacr_item_single_term( $taxonomy, $post_id );
}

function sacr_item_single_term( $taxonomy, $post_id = null ) {
	global $post;

	if ( is_null( $post_id ) && is_object( $post ) )
		$post_id = $post->ID;

	$terms = get_the_terms( $post_id, $taxonomy );
	$_term = '';

	if ( ! $terms )
		return 0;

	foreach ( $terms as $term ) {
		$_term = $term->slug;
		continue;
	}

	return $_term;
}

function sacr_page_after_research() {
	global $post;

	get_template_part( 'content-further-research', $post->post_name );
}
add_action( 'sacr_page_after', 'sacr_page_after_research', 30 );