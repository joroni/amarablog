<?php
/**
 * The Template for displaying all single posts.
 *
 * @package fancythemes
 * @since fancythemes 1.0
 */

get_header(); ?>

		
		<div id="primary" class="content-area boxed">

			<?php dynamic_sidebar('header-ad'); ?>
		
			<?php fancythemes_breadcrumb(); ?>
			
			<div class="site-content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
			
				<?php $format = get_post_format(); ?>
			
				<?php get_template_part( 'content-page', $format ); ?>

                <h5 class="widget-title archive-title"><span><?php _e('Last 30 Posts', 'good'); ?></span></h5>
                <ul>
                <?php
                $r = new WP_Query(array('showposts' => 30,'post_status' => 'publish', 'ignore_sticky_posts' => 1));
                while ($r->have_posts()) : $r->the_post();
                ?>
                    <li>
                        <a href="<?php the_permalink() ?>"><?php the_title() ?></a>
                    </li>
                <?php 
                endwhile;
                ?>
                </ul>
                <h5 class="widget-title archive-title"><span><?php _e('Archives by Month:', 'good'); ?></span></h5>
                <ul>
                    <?php wp_get_archives('type=monthly'); ?>
                </ul>
				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() )
						comments_template( '', true );
				?>

			<?php endwhile; // end of the loop. ?>

			</div><!-- #content .site-content -->
			
		</div><!-- #primary .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>