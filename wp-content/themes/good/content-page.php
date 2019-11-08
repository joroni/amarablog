<?php
/**
 * @package fancythemes
 * @since fancythemes 1.0
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('boxed group'); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
		

		<?php if (has_post_thumbnail()): ?>
            <p class="post-image">
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="home-thumb boxed" >
				<?php the_post_thumbnail('large'); ?>
				</a>
			</p>
        <?php endif; ?>
	</header><!-- .entry-header -->

	<div class="entry-content boxed">
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'good' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->
    

</article><!-- #post-<?php the_ID(); ?> -->
