<?php
/**
 * Simple Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Simple_Theme
 */

if ( ! function_exists( 'simple_theme_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function simple_theme_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Simple Theme, use a find and replace
	 * to change 'simple-theme' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'simple-theme', get_template_directory() . '/languages' );

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
		'menu-1' => esc_html__( 'Primary', 'simple-theme' ),
		'social' => esc_html__( 'Social Menu', 'simple-theme'),
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



	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Add theme support for custom logos
	add_theme_support('custom-logo', array (
			'width' => 90,
			'height' => 90,
			'flex-width' => true,
		));

}
endif;
add_action( 'after_setup_theme', 'simple_theme_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function simple_theme_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'simple_theme_content_width', 640 );
}
add_action( 'after_setup_theme', 'simple_theme_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function simple_theme_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'simple-theme' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'simple-theme' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'simple_theme_widgets_init' );

// Pre connect for google fonts

function simple_theme_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'simple-theme', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'simple_theme_resource_hints', 10, 2 );

/**
 * Enqueue scripts and styles.
 */
function simple_theme_scripts() {
	//Enqueque Google fonts
	wp_enqueue_style('simple-theme-google-fonts', 'https://fonts.googleapis.com/css?family=Open+Sans:400,700|Ubuntu:400,700');

	//Enqueque Fontawesome
	wp_enqueue_script('simple-theme-fontawesome', 'https://use.fontawesome.com/dd8acc7905.js');

	wp_enqueue_style( 'simple-theme-style', get_stylesheet_uri() );

	wp_enqueue_script( 'simple-theme-navigation', get_template_directory_uri() . '/js/navigation.js', array('jquery'), '20151215', true );

	wp_enqueue_script( 'simple-theme-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'simple_theme_scripts' );


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
