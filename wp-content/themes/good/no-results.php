<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package fancythemes
 * @since fancythemes 1.0
 */
?>

<article id="post-0" class="post hentry no-results not-found boxed group">
	<header class="entry-header">
		<h1 class="entry-title"><?php _e( 'Nothing Found', 'good' ); ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'good' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

			<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords or browse our archives.', 'good' ); ?></p>

		<?php else : ?>

			<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help or browse our archives.', 'good' ); ?></p>

		<?php endif; ?>
        <p><?php get_search_form(); ?></p>
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

            <h5 class="widget-title"><span><?php _e('Archives by Month:', 'good'); ?></span></h5>
            <ul>
                <?php wp_get_archives('type=monthly'); ?>
            </ul>
	</div><!-- .entry-content -->
</article><!-- #post-0 .post .no-results .not-found -->
