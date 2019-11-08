<?php
/**
 * The Template for displaying all single posts.
 *
 *
 * Template Name: Widgetized Page
 *
 * @package fancythemes
 * @since fancythemes 1.0
 */

get_header(); ?>

		<div id="primary" class="content-area boxed">

			<?php dynamic_sidebar('header-ad'); ?>
			
			<?php 
			if ( have_posts() ) { 
				the_post();
			}
			?>
			<?php if ( ! dynamic_sidebar( $post->post_name ) ) : ?>
			
			<?php endif; ?>

		</div><!-- #primary .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>