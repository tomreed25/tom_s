<?php
/**
 * Tom_s functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Tom_s
 */

if ( ! function_exists( 'tom_s_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function tom_s_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Tom_s, use a find and replace
	 * to change 'tom_s' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'tom_s', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'tom_s' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'tom_s_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'tom_s_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function tom_s_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'tom_s_content_width', 640 );
}
add_action( 'after_setup_theme', 'tom_s_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function tom_s_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'tom_s' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'tom_s' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'tom_s_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function tom_s_scripts() {
	wp_enqueue_style( 'tom_s-style', get_stylesheet_uri() );

	wp_enqueue_script( 'tom_s-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'tom_s-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'tom_s_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Remove Admin Bar from the website.
 */
add_filter( 'show_admin_bar', '__return_false' );

/**
 * Change the Portfolio Pro plugin slug.
 */
add_action('registered_post_type', 'portfolio_override', 10, 2); //Register a function
function portfolio_override($post_type, $args) { //Function to hook into the plugin custom post type
    global $wp_rewrite;
    if ($post_type == 'portfoliopro') { //Old slug

        $args->rewrite['slug'] = 'portfolio'; //New slug 

        if ( $args->has_archive ) { //Check to see if there are any posts
                $archive_slug = $args->has_archive === true ? $args->rewrite['slug'] : $args->has_archive;
                if ( $args->rewrite['with_front'] )
                        $archive_slug = substr( $wp_rewrite->front, 1 ) . $archive_slug;
                else
                        $archive_slug = $wp_rewrite->root . $archive_slug;

                add_rewrite_rule( "{$archive_slug}/?$", "index.php?post_type=$post_type", 'top' ); // Add a rewrite rule
                if ( $args->rewrite['feeds'] && $wp_rewrite->feeds ) {
                        $feeds = '(' . trim( implode( '|', $wp_rewrite->feeds ) ) . ')';
                        add_rewrite_rule( "{$archive_slug}/feed/$feeds/?$", "index.php?post_type=$post_type" . '&feed=$matches[1]', 'top' ); // Next and previous links if needed for page 2/3/4 etc for feeds
                        add_rewrite_rule( "{$archive_slug}/$feeds/?$", "index.php?post_type=$post_type" . '&feed=$matches[1]', 'top' );
                }
                if ( $args->rewrite['pages'] )
                        add_rewrite_rule( "{$archive_slug}/{$wp_rewrite->pagination_base}/([0-9]{1,})/?$", "index.php?post_type=$post_type" . '&paged=$matches[1]', 'top' ); // Rewrite archive pages
        }

        $permastruct_args = $args->rewrite;
        $permastruct_args['feed'] = $permastruct_args['feeds'];
        add_permastruct( $post_type, "{$args->rewrite['slug']}/%$post_type%", $permastruct_args ); // Clearn the rewrites and spit it out in an array
    }
}

/**
 * Remove portfolio link target attribute.
 */
add_action( 'wp_enqueue_scripts', 'remove_target' );
function remove_target() {
    wp_enqueue_script(
        'remove_target', // name of script
        get_template_directory_uri() . '/js/remove_target.js', // location of script file
        array('jquery')
    );
}