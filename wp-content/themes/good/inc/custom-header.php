<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * You can add an optional custom header image to header.php like so ...

	<?php $header_image = get_header_image();
	if ( ! empty( $header_image ) ) { ?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
			<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />
		</a>
	<?php } // if ( ! empty( $header_image ) ) ?>

 *
 * @package fancythemes
 * @since fancythemes 1.0
 */

/**
 * Setup the WordPress core custom header feature.
 *
 * Use add_theme_support to register support for WordPress 3.4+
 * as well as provide backward compatibility for previous versions.
 * Use feature detection of wp_get_theme() which was introduced
 * in WordPress 3.4.
 *
 * @todo Rework this function to remove WordPress 3.4 support when WordPress 3.6 is released.
 *
 * @uses fancythemes_header_style()
 * @uses fancythemes_admin_header_style()
 * @uses fancythemes_admin_header_image()
 *
 * @package fancythemes
 */
function fancythemes_custom_header_setup() {
	$args = array(
		'default-image'          => '',
		'default-text-color'     => '000',
		'width'                  => 1000,
		'height'                 => 250,
		'flex-height'            => true,
		'wp-head-callback'       => 'fancythemes_header_style',
	);

	$args = apply_filters( 'fancythemes_custom_header_args', $args );

    add_theme_support( 'custom-header', $args );
}
add_action( 'after_setup_theme', 'fancythemes_custom_header_setup' );

if ( ! function_exists( 'fancythemes_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see fancythemes_custom_header_setup().
 *
 * @since fancythemes 1.0
 */
function fancythemes_header_style() {

	// If no custom options for text are set, let's bail
	// get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank') or any hex value
	if ( display_header_text() ) {
		return;
	}
	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
		.site-title,
		.no-heading-style,
		.site-description {
			clip: rect(1px, 1px, 1px, 1px);
            left: 0;
			position: absolute;
		}
	</style>
	<?php
}
endif; // fancythemes_header_style
?>