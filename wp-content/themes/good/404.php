<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package fancythemes
 * @since fancythemes 1.0
 */

get_header(); ?>

		<div id="primary" class="content-area boxed">

			
			
				<div class="site-content group posts-block columns-view">

					<?php get_template_part( 'no', 'results' ); ?>

				</div><!-- #content .site-content -->

		</div><!-- #primary .content-area -->

<?php

get_sidebar();
get_footer(); 

?>