<?php
/**
 * good functions and definitions
 *
 * @package good
 * @since good 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since good 1.0
 */
if ( ! isset( $content_width ) )
	$content_width = 900; /* pixels */
	
/**
 * Set global variabel for theme ooptions.
 *
 * @since good 1.0
 */
$theme_options = get_option('good_option');


$default_color_options = array();
/*
 * Load Jetpack compatibility file.
 */
require( get_template_directory() . '/inc/jetpack.php' );

if ( ! function_exists( 'fancythemes_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since fancythemes 1.0
 */
function fancythemes_setup() {
	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on good, use a find and replace
	 * to change 'good' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'good', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );
    add_theme_support('title-tag');
    
    /**
	 * Enable support for Custom Logo
	 */
    add_theme_support( 'custom-logo', array(
       'height'      => 90,
       'width'       => 127,
       'flex-width' => true,
    ) );
    
	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	add_image_size('good-thumb-450', 450, 1000, false );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'good' ),
		'secondary' => __( 'Secondary Menu', 'good' ),
		'footer' => __( 'Footer Menu', 'good' ),
	) );

	/**
	 * Enable support for Post Formats
	 */
	add_theme_support( 'post-formats', array( 'video' ) );
}
endif; // good_setup
add_action( 'after_setup_theme', 'fancythemes_setup' );

/**
 * Custom template tags for this theme.
 */
require( get_template_directory() . '/inc/template-tags.php' );

/**
 * Custom form template tags for this theme.
 */
require( get_template_directory() . '/inc/form-template-tags.php' );

/**
 * Custom functions that act independently of the theme templates
 */
require( get_template_directory() . '/inc/extras.php' );

/**
 * Customizer additions
 */
require( get_template_directory() . '/inc/customizer-simple.php' );
require( get_template_directory() . '/inc/customizer.php' );


/**
 * Custom metaboxes for post or page
 */
require( get_template_directory() . '/inc/custom-metaboxes.php' );


require( get_template_directory() . '/inc/export-import-setting.php' );

/**
 * Custom Widgets
 */
require( get_template_directory() . '/inc/widgets/flickr.php' );
require( get_template_directory() . '/inc/widgets/recent_comments.php' );
require( get_template_directory() . '/inc/widgets/recent_posts.php' );

/**
 * Setup the WordPress core custom background feature.
 *
 * Use add_theme_support to register support for WordPress 3.4+
 * as well as provide backward compatibility for WordPress 3.3
 * using feature detection of wp_get_theme() which was introduced
 * in WordPress 3.4.
 *
 * @todo Remove the 3.3 support when WordPress 3.6 is released.
 *
 * Hooks into the after_setup_theme action.
 */
function fancythemes_register_custom_background() {
	$args = array(
		'default-color' => 'eeeeee',
		'default-image' => '',//get_template_directory_uri() . '/img/background-pattern.png',
	);

	$args = apply_filters( 'fancythemes_custom_background_args', $args );

	if ( function_exists( 'wp_get_theme' ) ) {
		add_theme_support( 'custom-background', $args );
	} else {
		define( 'BACKGROUND_COLOR', $args['default-color'] );
		if ( ! empty( $args['default-image'] ) )
			define( 'BACKGROUND_IMAGE', $args['default-image'] );
		add_theme_support('custom-background',$args['default-image']);
	}
}
add_action( 'after_setup_theme', 'fancythemes_register_custom_background' );

/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since fancythemes 1.0
 */
function fancythemes_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar', 'good' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget boxed %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h5 class="widget-title"><span>',
		'after_title' => '</span></h5>',
		'widget_id' =>'%1$s',
		'widget_position' => 'sidebar',
	) );

	register_sidebar( array(
		'name' => __( 'Homepage Content', 'good' ),
		'id' => 'homepage-content-widgets',
		'before_widget' => '<div id="%1$s" class="widget .homepage-widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h5 class="widget-title"><span>',
		'after_title' => '</span></h5>',
		'widget_id' =>'%1$s',
		'widget_position' => 'main-content',
	) );

	register_sidebar( array(
		'name' => __( 'Header Ad', 'good' ),
		'id' => 'header-ad',
		'before_widget' => '<div id="%1$s" class="widget .homepage-widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h5 class="widget-title"><span>',
		'after_title' => '</span></h5>',
		'widget_id' =>'%1$s',
		'widget_position' => 'main-content',
	) );
	
	
	$page_args = array(	'post_type' => 'page',
						'meta_key' => '_wp_page_template',
						'meta_value' => 'widgetized-page.php',
					);
	$list_pages = get_posts($page_args);
	//print_r($list_pages);
	foreach( $list_pages as $w_page ){
		register_sidebar( array(
			'name' => $w_page->post_title,
			'id' => $w_page->post_name,
			'before_widget' => '<div id="%1$s" class="widget homepage-widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widget-title"><span>',
			'after_title' => '</span></h4>',
			'widget_id' =>'%1$s',
		) );
	}

}
add_action( 'widgets_init', 'fancythemes_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function fancythemes_scripts() {
	wp_enqueue_style( 'good-style', get_stylesheet_uri() );
	
	wp_enqueue_script('jquery');
	wp_enqueue_script( 'good', get_template_directory_uri() . '/js/good.js', array( 'jquery' ), '20120206', true );
	wp_enqueue_script( 'imagesloaded', get_template_directory_uri() . '/js/jquery.imagesloaded.min.js', array( 'jquery' ), '20120206', true );
	wp_enqueue_script( 'flexslider', get_template_directory_uri() . '/js/jquery.flexslider.min.js', array( 'jquery' ), '20120206', true );
	wp_enqueue_script( 'fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', array( 'jquery' ), '20120206', true );
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'fancythemes_scripts', 20 );

/**
 * Implement the Custom Header feature
 */
//require( get_template_directory() . '/inc/custom-header.php' );


/**
 * Get theme option set by customizer
 */
function fancythemes_get_option($optname){

	return get_theme_mod($optname);

}

/************* COMMENT LAYOUT *********************/
		
// Comment Layout
function fancythemes_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?>>
		<article id="comment-<?php comment_ID(); ?>" class="clearfix">
			<header class="comment-author vcard">
				<?php echo get_avatar($comment,$size='45',$default='<path_to_url>' ); ?>
				<?php printf(__('<cite class="fn">%s</cite>', 'good'), get_comment_author_link()) ?>
				<p class="meta"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s', 'good'), get_comment_date(get_option('date_format')). ' ' .  get_comment_time(get_option('time_format'))) ?></a>, <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?></p>
				<?php edit_comment_link(__('(Edit)', 'good'),'  ','') ?>
			</header>
			<?php if ($comment->comment_approved == '0') : ?>
       			<div class="help">
          			<p><?php _e('Your comment is awaiting moderation.', 'good') ?></p>
          		</div>
			<?php endif; ?>
			<section class="comment_content clearfix">
				<?php comment_text() ?>
			</section>
		</article>
    <!-- </li> is added by wordpress automatically -->
<?php
}

/************* Custom Logo *********************/
/**
 * Displays the optional custom logo.
 *
 * Does nothing if the custom logo is not available.
 *
 * @since Good 1.0
 */
function good_custom_logo() {
    if ( has_custom_logo() ) {
        the_custom_logo();
    }
    else { ?>
        <h2 class="site-title h1"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h2>
        <p class="site-description"><?php bloginfo( 'description' ); ?></p>
        <?php
    }
}
?>