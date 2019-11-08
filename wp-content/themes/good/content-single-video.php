<?php
/**
 * @package fancythemes
 * @since fancythemes 1.0
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('boxed group'); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<div class="single-meta meta group">
			<div class="posted-by boxed">
				<div>
					<?php echo get_avatar( get_the_author_meta( 'ID' ), 40 ); ?>
					<?php _e('By ', 'good'); ?>
					<br>
					<?php the_author_posts_link(); ?>
				</div>
            </div>
			<div class="comment-count boxed">
				<div>
					<?php _e('With ', 'good'); ?>
					<br>
					<?php comments_popup_link( __( 'No Comment', 'good' ), __( '1 Comment', 'good' ), __( '% Comments', 'good' ) ); ?>
				</div>
			</div>
			<div class="share-box boxed">
				<div>
					<?php _e('Ok ', 'good'); ?>
					<br>
					<a href="#"><?php _e('Share this!', 'good'); ?></a>
					<?php
					$url_encoded = urlencode(get_permalink());
					$title_encoded = urlencode(get_the_title());
					$summary_encoded = urlencode(get_the_excerpt());
					$twitter_url = ('https://twitter.com/intent/tweet?text=' . $title_encoded . '&amp;url=' . $url_encoded);
					$facebook_url = ('https://www.facebook.com/sharer/sharer.php?p[url]=' . $url_encoded . '&amp;p[title]=' . $title_encoded . '&amp;p[summary]=' . $summary_encoded . '&amp;u=' . $url_encoded . '&amp;t=' . $title_encoded);
					$linkedin_url = ('http://www.linkedin.com/shareArticle?mini=true&amp;url=' . $url_encoded . '&amp;summary=' . $summary_encoded . '&amp;title=' . $title_encoded);
					$google_plus_url = ('https://plus.google.com/share?url=' . $url_encoded . '&amp;text=' . $title_encoded);
					?>
					<ul id="share-post">
						<li>
							<a href="<?php echo $twitter_url; ?>" target="blank" class="share-twitter" ><?php _e('Twitter', 'good'); ?></a>
						</li>
						<li>
							<a href="<?php echo $facebook_url; ?>" target="blank" class="share-facebook" ><?php _e('Facebook', 'good'); ?></a>
						</li>
						<li>
							<a href="<?php echo $google_plus_url; ?>" target="blank" class="share-google" ><?php _e('Google+', 'good'); ?></a>
						</li>
						<li>
							<a href="<?php echo $linkedin_url; ?>" target="blank" class="share-linkedin" ><?php _e('Linkedin', 'good'); ?></a>
						</li>
					</ul>
				</div>
			</div>
            <?php //edit_post_link( __( 'Edit', 'good' ), '<span class="sep"> &nbsp; | &nbsp; </span><span>', '</span>' ); ?>
		</div><!-- .entry-meta -->

	</header><!-- .entry-header -->

	<div class="entry-content boxed">
		<?php fancythemes_video_post(); ?>
		<?php the_content(); ?>
  		<?php wp_link_pages( array( 'before' => '<p class="page-links">' . __( 'Pages:', 'good' ), 'after' => '</p>', 'separator' => ' &nbsp; ' ) ); ?>
	    <p class="post-tags"><?php the_tags('<span>Tags: </span> ', ', ', ''); ?></p>
	</div><!-- .entry-content -->
    
	<aside class="author-box boxed group">
		<h4 class="widget-title"><span><?php _e('About the author', 'good'); ?></span></h4>
		<?php echo get_avatar( get_the_author_meta( 'ID' ), 80 ); ?>
		<p class="author-description"><?php the_author_posts_link(); ?>, <?php the_author_meta('description'); ?></p>
	</aside>

	<footer class="related-box boxed">
		<h4 class="widget-title"><span><?php _e('Related Posts', 'good'); ?></span></h4>
		<?php fancythemes_related_posts(); ?>
	</footer>


</article><!-- #post-<?php the_ID(); ?> -->
