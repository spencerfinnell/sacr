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
	 * Create Connections
	 */
	require( get_template_directory() . '/inc/p2p.php' );

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
	add_image_size( 'hero', 940, 430, true );
	add_image_size( 'timeline', 440, 275, true );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'sacr' ),
	) );
}
endif; // sacr_setup
add_action( 'after_setup_theme', 'sacr_setup' );

/**
 * Enqueue scripts and styles
 */
function sacr_scripts() {
	wp_enqueue_style( 'sacr-fonts', 'http://fonts.googleapis.com/css?family=Kreon:300,400,700|Varela+Round' );
	wp_enqueue_style( 'sacr-style', get_template_directory_uri() . '/css/style.css', array( 'sacr-fonts' ), time() );

	/** all */
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'sacr-typekit', 'http://use.typekit.net/cbu3qat.js' );
	
	/** home */
	if ( is_front_page() ) {
		wp_enqueue_script( 'backstretch', get_template_directory_uri() . '/js/vendor/jquery.backstretch.min.js' );
		wp_enqueue_script( 'jcarousellite', get_template_directory_uri() . '/js/vendor/responsiveslides.min.js' );
	}
	
	/** map */
	if ( is_page( sacr_get_theme_option( 'map' ) ) ) {
		wp_enqueue_script( 'google-maps', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false' );
		wp_enqueue_script( 'gmaps', get_template_directory_uri() . '/js/vendor/jquery.ui.map.min.js' );
		wp_enqueue_script( 'fancybox', get_template_directory_uri() . '/js/vendor/jquery.fancybox.pack.js' );
	}

	/** timeline */
	if ( is_post_type_archive( 'time_period' ) )
		wp_enqueue_script( 'jquery-masonry' );

	/** posts */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/** all */
	wp_enqueue_script( 'sacr-script', get_template_directory_uri() . '/js/sacr.js', array( 'jquery' ), 20130220 );

	$args = array(
		'is_home'       => is_front_page(),
		'is_map'        => is_page( sacr_get_theme_option( 'map' ) ),
		'is_timeline'   => is_post_type_archive( 'time_period' ),
		'map_url'       => get_permalink( sacr_get_theme_option( 'map' ) ),
		'pin'           => get_template_directory_uri() . '/images/display/pin-'
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
				<cite class="fn"><?php comment_author_link(); ?></cite>
			</div><!-- .comment-author -->

			<header class="comment-meta">
				<?php
					printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						sprintf( _x( '%1$s at %2$s', '1: date, 2: time', 'twentythirteen' ), get_comment_date(), get_comment_time() )
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