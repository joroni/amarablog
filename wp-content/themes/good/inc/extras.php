<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package good
 * @since good 1.00
 */

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @since good 1.00
 */
function fancythemes_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'fancythemes_page_menu_args' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @since fancythemes 1.00
 */
function fancythemes_body_classes( $classes ) {
	global $post;
	
	$classes[] = fancythemes_get_option('layout_text_align') ? 'center-aligned' : '';
	$classes[] = fancythemes_get_option('sticky_navigation') ? 'sticky-navigation' : '';

	// Adds a class of group-blog to blogs with more than 1 published author
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'fancythemes_body_classes' );

/**
 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
 *
 * @since fancythemes 1.00
 */
function fancythemes_enhanced_image_navigation( $url, $id ) {
	if ( ! is_attachment() && ! wp_attachment_is_image( $id ) )
		return $url;

	$image = get_post( $id );
	if ( ! empty( $image->post_parent ) && $image->post_parent != $id )
		$url .= '#main';

	return $url;
}
add_filter( 'attachment_link', 'fancythemes_enhanced_image_navigation', 10, 2 );

/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @since fancythemes 1.00
 */
function fancythemes_wp_title( $title, $sep ) {
	global $page, $paged;

	if ( is_feed() )
		return $title;

	// Add the blog name
	$title .= get_bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $sep $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $sep " . sprintf( __( 'Page %s', 'good' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'fancythemes_wp_title', 10, 2 );

/**
 * Set the excerpt length.
 *
 * @since good 1.00
 */
function fancythemes_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'fancythemes_excerpt_length', 999 );

/**
 * Fix the excerpt more text
 *
 * @since fancythemes 1.00
 */
function fancythemes_excerpt_more($more) {
	global $post;
	return '...';
}
add_filter('excerpt_more', 'fancythemes_excerpt_more');


/*
 * Manage font to load based on the customizer setting
 *
 */
function fancythemes_load_font(){

	$websafe_lib = array(

			'Arial__400,700',
			'Arial_Black__400,700',
			'Book_Antiqua__400,700',
			'Comic_Sans_MS__400,700',
			'Courier_New__400,700',
			'Geneva__400,700',
			'Georgia__400,700',
			'Helvetica__400,700',
			'Impact__400,700',
			'Lucida_Console__400,700',
			'Lucida_Grande__400,700',
			'Lucida_Sans_Unicode__400,700',
			'Monaco__400,700',
			'New_York__400,700',
			'Palatino_Lynotype__400,700',
			'Tahoma__400,700',
			'Times_New_Roman__400,700',
			'Trebuchet_MS__400,700',
			'Verdana__400,700',

		);

	$default_font = array(
			'body_font' => 'Lora__400,400italic,700,700italic',
			'heading_font' => 'Source_Sans_Pro__400',
			'menu_font' => 'Lora__400,400italic,700,700italic',
			'meta_font' => 'Lora__400,400italic,700,700italic',
			'widget_title_font' => 'Source_Sans_Pro__400',
		);

	$added = array();

	foreach ( $default_font as $section => $default ){

		if ( !( $font_to_load = get_theme_mod($section) ) ){
			$font_to_load = $default;
		}

		if ( !in_array( $font_to_load, $websafe_lib ) && !in_array( $font_to_load, $added ) ) {
			$added[] = $font_to_load;
			$font_to_load = str_replace( '__', ':', $font_to_load );
			$font_id = substr( $font_to_load, 0, strpos( $font_to_load, ':') );
			$font_to_load = str_replace( '_', '+', $font_to_load );
			$font_url = 'http://fonts.googleapis.com/css?family=' . $font_to_load;
			wp_enqueue_style( $font_id , $font_url );
		}
	}

}
add_action( 'wp_enqueue_scripts', 'fancythemes_load_font' );

/*
 * Apply font to css based on the customizer setting
 *
 */
function fancythemes_apply_fonts() {

	$echo = '';
	if ( $font_to_load = get_theme_mod('body_font') ) {
		$echo .= 'body, .no-heading-style, input[type=text], input[type=email], input[type=password], textarea {';
		$echo .= 'font-family : "' . str_replace( '_', ' ', substr( $font_to_load, 0, strpos( $font_to_load, '__') ) ) . '"; ';
		$echo .= '}';
	}

	if ( $font_to_load = get_theme_mod('heading_font') ) {
		$echo .= 'h1, .h1, h2, .h2, h3, .h3, h4, .h4, h5, .h5, h6, .h6 {';
		$echo .= 'font-family : "' . str_replace( '_', ' ', substr( $font_to_load, 0, strpos( $font_to_load, '__') ) ) . '"; ';
		$echo .= '}';
	}

	if ( $font_to_load = get_theme_mod('menu_font') ) {
		$echo .= '.secondary-navigation > div > ul > li > a, .section-title, #reply-title, .widget-title, button, html input[type="button"], input[type="reset"], input[type="submit"] {';
		$echo .= 'font-family : "' . str_replace( '_', ' ', substr( $font_to_load, 0, strpos( $font_to_load, '__') ) ) . '"; ';
		$echo .= '}';
	}

	if ( $echo ) {
		echo '<style id="apply-webfont">' . $echo . '</style>';
	}

}
add_action( 'wp_head', 'fancythemes_apply_fonts' );

/**
 * Remove first gallery shortcode if found in post
 *
 * @since fancythemes 1.00
 */
function fancythemes_remove_first_gallery($content){
	global $post;
	$pattern = get_shortcode_regex();
    preg_match('/'.$pattern.'/s', $post->post_content, $matches);
	if (isset($matches[0])){
		$content = str_replace( $matches[0], '', $content );
	}
	return $content;
}

/**
 * Check if a post have gallery shortcode
 *
 * @since fancythemes 1.00
 */
function fancythemes_have_gallery(){
	global $post;
	$pattern = get_shortcode_regex();
    preg_match('/'.$pattern.'/s', $post->post_content, $matches);
	if (isset($matches[0])){
		$have_gallery = true;
	}else{
		$have_gallery = false;
	}
	return $have_gallery;
}

/**
 * remove some rel
 *
 * @since fancythemes 1.00
 */
//add_filter( 'the_category', 'fancythemes_add_nofollow_cat' );
function fancythemes_add_nofollow_cat( $text) {
	$text = str_replace('rel="category tag"', "", $text);
	return $text;
}

/**
 * Display image caption
 *
 * @since fancythemes 1.00
 */
function fancythemes_img_caption_shortcode_filter($val, $attr, $content = null)
{
    extract(shortcode_atts(array(
        'id'    => '',
        'align' => 'alignnone',
        'width' => '',
        'caption' => ''
    ), $attr));
     
    if ( 1 > (int) $width || empty($caption) )
        return $val;
 
    if ( $id ) $id = 'id="' . esc_attr($id) . '" ';
 
    return '<div ' . $id . 'class="wp-caption ' . esc_attr($align) . '" style="width: ' . (int) $width . 'px">'
    . do_shortcode( $content ) . '<p class="wp-caption-text">' . $caption . '</p></div>';
}
add_filter('img_caption_shortcode', 'fancythemes_img_caption_shortcode_filter',10,3);

/**
 * Adding styling to the editor
 *
 * @since fancythemes 1.00
 */
function fancythemes_add_editor_styles() {
    add_editor_style( 'style-editor.css' );
}
add_action( 'init', 'fancythemes_add_editor_styles' );

add_filter( 'use_default_gallery_style', '__return_false' );


/**
 * adding a class to the ul of menu, this is used in fallback menu
 *
 * @since fancythemes 1.00
 */
function fancythemes_strip_div_menu_page($menu){
	$menu = str_replace('<ul>', '<ul class="group">', $menu );
	return strip_tags($menu, '<ul><li><a><span>');
}

/**
 * Exclude some posts with certain categories from recent posts stream
 *
 * @since fancythemes 1.00
 */
function fancythemes_exclude_categories( $query ){
	global $theme_options;
	if ( $query->is_home() && $query->is_main_query() && fancythemes_get_option('exclude_categories') ) {
		$query->query_vars['category__not_in'] = fancythemes_get_option('exclude_categories');
	}
}
add_action( 'pre_get_posts', 'fancythemes_exclude_categories' );

/*
 * Function trim words
 *
 * @since fancythemes 1.00
 */
function trim_words($words, $num){
	$arr_str = explode(' ', $words);
	$arr_str = array_slice($arr_str, 0, $num );
	return implode(' ', $arr_str);
}

add_filter('query_vars', 'fancythemes_queryvars' );
function fancythemes_queryvars( $qvars ) {
  $qvars[] = 'posts_widget_page';
  return $qvars;
}

/**
 * Get the twitter stream
 *
 * @since fancythemes 1.00
 */
function fancythemes_get_tweets( $options = false ) {
	require( get_template_directory() . '/inc/twitteroauth/twitteroauth.php' );


	$key = fancythemes_get_option('twitter_consumer_key');
	$secret = fancythemes_get_option('twitter_consumer_secret');
	$token = fancythemes_get_option('twitter_access_token');
	$token_secret = fancythemes_get_option('twitter_access_token_secret');
	
	
    $connection = new TwitterOAuth($key, $secret, $token, $token_secret);
    $result = $connection->get('statuses/user_timeline', $options);
    
	if ( is_array($result) && isset($result['errors'][0]) && isset($result['errors'][0]['message'])) {
		$result['error'] = $result['errors'][0]['message'];
	}

	return $result;	  
}

/*
 * Convert the text with URL format into link
 *
 * @since fancythemes 1.00
 */
function fancythemes_autolink($str, $attributes=array()) {
	$attrs = '';
	foreach ($attributes as $attribute => $value) {
		$attrs .= " {$attribute}=\"{$value}\"";
	}

	$str = ' ' . $str;
	$str = preg_replace(
		'`([^"=\'>])((http|https|ftp)://[^\s<]+[^\s<\.)])`i',
		'$1<a href="$2"'.$attrs.'>$2</a>',
		$str
	);
	$str = substr($str, 1);
	
	return $str;
}


/*
 * Function relative time
 *
 * @since fancythemes 1.00
 */
function fancythemes_relative_time($time = false, $limit = 86400, $format = 'g:i A M jS') {
    if (empty($time) || (!is_string($time) && !is_numeric($time))) $time = time();
    elseif (is_string($time)) $time = strtotime($time);

    $now = time();
    $relative = '';

    if ($time === $now) $relative = __('now', 'good');
    elseif ($time > $now) $relative = __('in the future', 'good');
    else {
        $diff = $now - $time;

        /*if ($diff >= $limit) $relative = date($format, $time);
        else*/if ($diff < 60) {
            $relative = __('less than one minute ago', 'good');
        } elseif (($minutes = ceil($diff/60)) < 60) {
            $relative = $minutes.' Minute'.(((int)$minutes === 1) ? '' : 's').' ago';
        } elseif ( $diff < (24*60*60) ){
            $hours = ceil($diff/3600);
            $relative = $hours.' Hour'.(((int)$hours === 1) ? '' : 's').' ago';
        }elseif ( $diff < (48*60*60) ){
            $hours = ceil($diff/3600);
            $relative = __('1 Day ago', 'good');
        }else{
			$relative = ceil($diff / 86400) . ' Days ago';
		}
    }

    return $relative;
}

?>