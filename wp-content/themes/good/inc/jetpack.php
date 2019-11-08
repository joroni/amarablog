<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package: fancythemes
 */

/**
 * Add theme support for Infinite Scroll.
 * See: http://jetpack.me/support/infinite-scroll/
 */
function fancythemes_infinite_scroll_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'content',
		'footer'    => 'page',
	) );
}
add_action( 'after_setup_theme', 'fancythemes_infinite_scroll_setup' );
