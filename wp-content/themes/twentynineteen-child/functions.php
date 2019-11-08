<?php
/**
 * Twenty Nineteen functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */

/**
 * Twenty Nineteen only works in WordPress 4.7 or later.
 */

 /**
  *  WpApiFeaturedImage
  *
  *  Adds featured images to the products endpoint
  *  using register_rest_field hook.
  *
  *  @version   1.0
  *  @author    stephen scaff
  */

  add_action( 'wp_enqueue_scripts', 'casaamara_enqueue_styles' );
  function casaamara_enqueue_styles() {
      wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
  }
  
/* 
  
function my_theme_enqueue_styles() {
 
    $parent_style = 'parent-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.
 
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
} */

//my_theme_enqueue_styles();

function get_all_posts( $data, $post, $context ) {
    return [
        'id'        => $data->data['id'],
        'date'      => $data->data['date'],
        'date_gmt'  => $data->data['date_gmt'],
        'modified'  => $data->data['modified'],
        'title'     => $data->data['title']['rendered'],
        'content'   => $data->data['content']['rendered'],
        'featured_img'   => $data->data['featured_img']['rendered'],
        'excerpt'   => $data->data['excerpt']['rendered'],
        'category'  => get_the_category_by_ID( $data->data['categories'][0] ),
        'link'      => $data->data['link'],


    ];
}
add_filter( 'rest_prepare_post', 'get_all_posts', 10, 3 );


add_filter('manage_posts_columns', 'add_thumbnail_column', 5);
 
function add_thumbnail_column($columns){
  $columns['new_post_thumb'] = __('Featured Image');
  return $columns;
}
 
//add_action('manage_posts_custom_column', 'display_thumbnail_column', 5, 2);
 
function display_thumbnail_column($column_name, $post_id){
  switch($column_name){
    case 'new_post_thumb':
      $post_thumbnail_id = get_post_thumbnail_id($post_id);
      if ($post_thumbnail_id) {
        $post_thumbnail_img = wp_get_attachment_image_src( $post_thumbnail_id, 'thumbnail' );
        echo '<img width="180" src="' . $post_thumbnail_img[0] . '" />';
      }
      break;
  }
}