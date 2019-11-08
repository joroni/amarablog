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

get_header(); 

?>

		<div id="primary" class="content-area boxed">

			
			<div class="block-wrapper">

				<?php dynamic_sidebar('header-ad'); ?>
			
				<?php dynamic_sidebar('homepage-content-widgets'); ?>
			
				<?php if ( !fancythemes_get_option('recent_posts_hide') ): ?>

				<div class="site-content group posts-block two-columns">

					<?php

					if ( have_posts() ) :

						while ( have_posts() ) : the_post();
						
							/* Include the Post-Format-specific template for the content.
							 * If you want to overload this in a child theme then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							get_template_part( 'content', get_post_format() );
						

						endwhile;
					
					else :

						get_template_part( 'no-results', 'index' );

					endif; 

					?>

				</div><!-- #content .site-content -->
				<?php fancythemes_pagenavi(); ?>
				<?php endif; ?>
			</div>

		</div><!-- #primary .content-area -->

<?php

get_sidebar();
get_footer(); 

?>