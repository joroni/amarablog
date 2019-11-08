<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package fancythemes
 * @since fancythemes 1.0
 */

if ( ! function_exists( 'fancythemes_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 *
 * @since fancythemes 1.0
 */
function fancythemes_content_nav( $nav_id ) {
	global $wp_query, $post;

	// Don't print empty markup on single pages if there's nowhere to navigate.
	if ( is_single() ) {
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous )
			return;
	}

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
		return;

	$nav_class = 'site-navigation paging-navigation';
	if ( is_single() )
		$nav_class = 'site-navigation post-navigation';

	?>
	<nav role="navigation" id="<?php echo esc_attr( $nav_id ); ?>" class="<?php echo $nav_class; ?>">
		<h1 class="assistive-text"><?php _e( 'Post navigation', 'good' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>

		<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'good' ) . '</span> %title' ); ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'good' ) . '</span>' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) : ?>
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'good' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'good' ) ); ?></div>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo esc_html( $nav_id ); ?> -->
	<?php
}
endif; // fancythemes_content_nav

if ( ! function_exists( 'fancythemes_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since fancythemes 1.0
 */
function fancythemes_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'good' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'good' ), ' ' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer>
				<div class="comment-author vcard">
					<?php echo get_avatar( $comment, 40 ); ?>
					<?php printf( __( '%s <span class="says">says:</span>', 'good' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
				</div><!-- .comment-author .vcard -->
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php _e( 'Your comment is awaiting moderation.', 'good' ); ?></em>
					<br />
				<?php endif; ?>

				<div class="comment-meta commentmetadata">
					<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time datetime="<?php comment_time( 'c' ); ?>">
					<?php
						/* translators: 1: date, 2: time */
						printf( __( '%1$s at %2$s', 'good' ), get_comment_date(), get_comment_time() ); ?>
					</time></a>, 
					<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
					<?php edit_comment_link( __( '(Edit)', 'good' ), ' ' );
					?>
				</div><!-- .comment-meta .commentmetadata -->
			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif; // ends check for fancythemes_comment()

if ( ! function_exists( 'fancythemes_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @since fancythemes 1.0
 */
function fancythemes_posted_on() {
	printf( __( '<time class="entry-date" datetime="%3$s">%4$s</time>', 'good' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category
 *
 * @since fancythemes 1.0
 */
function fancythemes_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so fancythemes_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so fancythemes_categorized_blog should return false
		return false;
	}
}

/**
 * Flush out the transients used in fancythemes_categorized_blog
 *
 * @since fancythemes 1.0
 */
function fancythemes_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'fancythemes_category_transient_flusher' );
add_action( 'save_post', 'fancythemes_category_transient_flusher' );

/**
 * Get related post, with the same category
 *
 * @since fancythemes 1.0
 */
function fancythemes_related_posts() {
	global $post;
	$tags = wp_get_post_tags($post->ID);
	$category = get_the_category($post->ID);
	$cat_id = $category[0]->cat_ID;
	$args = array(
		'category' => $cat_id,
		'posts_per_page' => 3, /* you can change this to show more */
		'post__not_in' => array($post->ID)
	);
		$recent = new WP_Query($args);
		$total_post = $recent->post_count;
		if ( ! $recent->have_posts() ) return 0;	?>

					<div class="site-content group posts-block three-columns">
						<?php 
						while($recent->have_posts()) : $recent->the_post();
							get_template_part( 'content', 'three-columns' ); 
						endwhile;

						wp_reset_query(); 
						?>
					</div>
					
		<?php
	wp_reset_query();
}

/**
 * Convert the gallery shortcode to flexslider
 *
 * @since fancythemes 1.0
 */
function fancythemes_image_gallery_post($size = 'full', $id = '') {

	global $post;

	$pattern = get_shortcode_regex();
    preg_match('/'.$pattern.'/s', $post->post_content, $matches);
	if ( isset($matches[2]) && is_array($matches) && $matches[2] == 'gallery') {
		if ( $shortcode_arg = shortcode_parse_atts($matches[3]) ){
			if ( isset($shortcode_arg['ids']) ){
				$args = array( 'post_type' => 'attachment', 
							'post__in' => explode(',', $shortcode_arg['ids']), 
							'orderby' => 'menu_order', 
							'order' => 'ASC' );
			}
		}
	}
	
	if($images = get_posts($args)) {
		if ($id) $divid = ' id="' . $id . '" ';
		?>
		<div <?php echo $divid ?> class="flexslider">
		<ul class="slides">
		<?php
		$i=1;
		$total_slide = count($images);
		foreach($images as $image) {
		?>
			<li>
				<?php echo wp_get_attachment_image($image->ID,$size); ?>
				<p class="gallery-caption"><?php echo $image->post_excerpt; ?></p>
				<p class="gallery-slide-desc"><span><?php echo  $i . __(' of ', 'good') . $total_slide; ?></span></p>
				</li>
		<?php
			$i++;
		} ?>
		</ul>
		</div>
	<?php
		$slides_html = 1;
	}else{
		$slides_html = 0;
	}
	return $slide_html;
}

/**
 * Get all featured image from portfolio post type to flexslider
 *
 * @since fancythemes 1.0
 */
function fancythemes_image_posts( $args = '', $size = 'full', $id = '') {
	if($images = get_posts($args)) {
		if ($id) $divid = ' id="' . $id . '" ';
		?>
		<div<?php echo $divid; ?> class="flexslider">
		<ul class="slides">
		<?php
		$i=1;
		$total_slide = count($images);
		foreach($images as $image) {
			//print_r($image);
		?>
			<li>
			<?php echo get_the_post_thumbnail($image->ID, $size); ?>
				<div class="gallery-caption">
					<?php 
						//if ( $image->post_type == 'portfolio'){
						the_taxonomies('post='.$image->ID.'&before=<div class="entry-meta">&after=</div>&sep=, &template=<span class="hide">%s:</span> %l');
						//}
                    ?>
                	<a href="<?php echo get_permalink($image->ID); ?>" class="slide-title" ><?php echo $image->post_title;  ?></a>
                 </div>
				<p class="gallery-slide-desc"><span><?php echo  $i . __(' of ', 'good') . $total_slide; ?></span></p>
			</li>
		<?php
			$i++;
		}
		?>
		</ul>
		</div>
	<?php
		$slides_html = 1;
	}else{
		$slides_html = 0;
	}
	return $slides_html;
}


/**
 * Featured Posts
 *
 * @since fancythemes 1.0
 */
function fancythemes_featured_posts( $args = 0 ){

	//global $theme_options;
	if ( isset($args['posts_per_page'])){
		$paged = ( get_query_var( 'posts_widget_page' ) ) ? get_query_var( 'posts_widget_page' ) : 1;
		$args['paged'] = $paged;
	}
	//echo get_query_var( 'paged' );

	$recent = new WP_Query($args);
	if ( isset($args['display_view']) ) $display_view = $args['display_view']; else $display_view = 'columns-view';
	$total_post = $recent->post_count;
	if ( ! $recent->have_posts() ) return 0;	?>

				<div class="site-content group posts-block two-columns <?php echo $display_view; ?>">
					<?php 
					while($recent->have_posts()) : $recent->the_post();?>
						<?php get_template_part( 'content', get_post_format() ); ?>
					<?php 
					endwhile;
					if ( $args['pagination'] == 'more' ) {
						$currpage = $paged;
						$max_pages = $recent->max_num_pages;
						if (  ($max_pages > $currpage) && ( $max_pages > 1 ) ){
							echo '<nav class="page-navigation load-more">';
							echo '<a href="'. esc_url(add_query_arg( 'posts_widget_page', $currpage + 1 )) .'">';
							echo __('More Posts', 'good');
							echo '</a>';
							echo '</nav>';
						}					
					}
					wp_reset_query(); 
					?>
				</div>
<?php

}


/**
 * Featured Posts 2
 *
 * @since fancythemes 1.0
 */
function fancythemes_featured_posts_2( $args = 0 ){

	//global $theme_options; 
	
	$recent = new WP_Query($args);
	$total_post = $recent->post_count;
	if ( ! $recent->have_posts() ) return 0;	?>
			<?php if ($recent->have_posts()) : $recent->the_post(); ?>
				<div class="site-content group posts-block feature-view boxed">
					<article id="post-<?php the_ID(); ?>" <?php post_class('boxed group'); ?>>
					
						<?php if (has_post_thumbnail()): ?>
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="home-thumb boxed" >	
							<?php the_post_thumbnail('thumb-482'); ?>
						</a>
						<?php endif; ?>
						<div class="post-detail">
							<header>
								<h2 class="entry-title">
									<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
								</h2>
							</header>
							<section class="post-content">
								<?php the_excerpt(); ?>
							</section>
							<footer>
								<?php 
								$format_prefix = '%2$s';
								$date = sprintf( '<span class="date"><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a></span>',
									esc_url( get_permalink() ),
									esc_attr( sprintf( __( 'Permalink to %s', 'good' ), the_title_attribute( 'echo=0' ) ) ),
									esc_attr( get_the_date( 'c' ) ),
									esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date() ) )
								);
								?>
								<p class="meta">
									<a class="author-avatar" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo get_avatar( get_the_author_meta( 'ID' ), 20 ); ?></a>
									<?php echo $date; ?>
								</p>
							</footer>
						</div>
					</article>
				<?php endif; ?>
					<ul class="more-posts">
					<?php while($recent->have_posts()) : $recent->the_post();?>
					<li class="boxed">
						<?php 
						$format_prefix = '%2$s';
						$date = sprintf( '<span class="date"><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a></span>',
							esc_url( get_permalink() ),
							esc_attr( sprintf( __( 'Permalink to %s', 'good' ), the_title_attribute( 'echo=0' ) ) ),
							esc_attr( get_the_date( 'c' ) ),
							esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date() ) )
						);
						?>
						<div class="meta"><?php echo $date; ?></div>
						<h3 class="entry-title no-heading-style">
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
						</h3>
					</li>
					<?php endwhile;wp_reset_query(); ?>
					</ul>
				</div>
<?php

}

/**
 * Featured Posts Grid
 *
 * @since fancythemes 1.0
 */
function fancythemes_featured_posts_grid( $args = 0 ){

	if ( isset($args['posts_per_page'])){
		$paged = ( get_query_var( 'posts_widget_page' ) ) ? get_query_var( 'posts_widget_page' ) : 1;
		$args['paged'] = $paged;
	}
	
	$recent = new WP_Query($args);
	$total_post = $recent->post_count;
	if ( isset($args['display_view']) ){
		$display_view = $args['display_view'];
	}else{
		$display_view = 'grid-view';
	}
	$display_flag = 'grid-posts';
	if ( $display_view != 'grid-view'){
		$display_flag = 'more-posts';
	}
	if ( ! $recent->have_posts() ) return 0;	?>
				<div class="site-content posts-block <?php echo $display_view; ?>">
					<ul class="<?php echo $display_flag; ?> group">
						<?php while($recent->have_posts()) : $recent->the_post();?>
						<li class="boxed group post">
							<?php if (has_post_thumbnail()): ?>
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="home-thumb boxed" >	
								<?php the_post_thumbnail('thumb-180'); ?>
							</a>
							<?php endif; ?>
							<?php 
							$format_prefix = '%2$s';
							$date = sprintf( '<span class="date"><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a></span>',
								esc_url( get_permalink() ),
								esc_attr( sprintf( __( 'Permalink to %s', 'good' ), the_title_attribute( 'echo=0' ) ) ),
								esc_attr( get_the_date( 'c' ) ),
								esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date() ) )
							);
							?>
							<div class="meta"><?php echo $date; ?></div>
							<h4 class="entry-title boxed <?php if ($display_flag == 'more-posts') echo 'no-heading-style'; ?>">
								<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
							</h4>
						</li>
					<?php 
					endwhile;
					if ( $args['pagination'] == 'more' ) {
						$currpage = $paged;
						$max_pages = $recent->max_num_pages;
						if (  ($max_pages > $currpage) && ( $max_pages > 1 ) ){
							echo '<nav class="page-navigation load-more">';
							echo '<a href="'. esc_url(add_query_arg( 'posts_widget_page', $currpage + 1 )) .'">';
							echo __('More Posts', 'good');
							echo '</a>';
							echo '</nav>';
						}					
					}
					wp_reset_query(); 
					?>
					</ul>
				</div>
<?php

}



/**
 * Page Navigation
 *
 * @since fancythemes 1.0
 */
function fancythemes_pagenavi( $the_query = ''){
	global $theme_options;
	if ( $the_query ) $wp_query = $the_query;
	else global $wp_query;
	$show_number = 2;
	$total = $wp_query->max_num_pages;

	if ( $total > 1 )  {
		if ( !$current_page = get_query_var('paged') )
			$current_page = 1;

		if ( !get_option('permalink_structure' ) ){
			$format = '&paged=%#%';
			if ( is_home() ) $format = '?paged=%#%';
		}else
			$format = '/page/%#%/';

		if ( is_search() ){
			$format = '&paged=%#%';
		}

		echo '<nav class="page-navigation">';
		$paginate =  paginate_links(array(
			'base' => untrailingslashit(get_pagenum_link(1)) . '%_%',
			'format' => $format,
			'current' => $current_page,
			'total' => $total,
			'show_all' => true,
			'type' => 'array',
			'prev_text' => __('Prev', 'good'),
			'next_text' => __('Next', 'good'),
		));
		$fi = 0;
		$prev = '';
		$first = '';
		$left_dot = '';
		if ( strpos( $paginate[0], 'prev' ) !== false ){
			$fi = 1;
			$prev = '<li>' . $paginate[0] . '</li>';
			if ( ($current_page - $show_number ) > 1 ){
				$fi = $current_page - $show_number;
				$first = '<li>' . preg_replace('/>[^>]*[^<]</', '>First<', $paginate[1]) . '</li>';
				$left_dot = '<li><span>...</span></li>';
			}
		}
		$la = count($paginate) - 1;
		$next = '';
		$last = '';
		$right_dot = '';
		if ( strpos( $paginate[count($paginate) - 1], 'next' ) !== false ){
			$la = count($paginate) - 2;
			$next = '<li>' . $paginate[count($paginate) - 1] . '</li>';
			if ( ($current_page + $show_number ) < $total ){
				$la = $current_page + $show_number;
				$last = '<li>' . preg_replace('/>[^>]*[^<]</', '>Last<', $paginate[count($paginate) - 2]) . '</li>';
				$right_dot = '<li><span>...</span></li>';
			}
		}
		
		//echo '<span class="page-of">'. __('Page', 'good') . ' ' . $current_page . __(' of ', 'good') . $total . '</span>';
		echo '<ul class="page_navi clearfix">';
		echo $first . $left_dot;
		echo $prev;
		for ( $i = $fi; $i <= $la; $i++ ){
			echo '<li>' . $paginate[$i] .'</li>';
		}
		echo $right_dot . $last;
		echo $next;
		echo '</ul>';
		echo '</nav>';
	}else{
		echo '<nav class="page-navigation">';
		echo '</nav>';
	}
}
	
/**
 * Breadcrumbs
 *
 * @since fancythemes 1.0
 */
function fancythemes_breadcrumb() {
	if ( !is_front_page() ) {
		echo '<div id="breadcrumbs" > <a href="';
		echo home_url();
		echo '">';
		_e('Home', 'good');
		echo "</a> ";
	}

	if ( (is_category() || is_single()) && !is_attachment() ) {
		$category = get_the_category();
		if (count($category) > 0){
			$ID = $category[0]->cat_ID;
			if ( $ID )	echo get_category_parents($ID, TRUE, ' ', FALSE );
		}
	}

	if(is_single() || is_page()) {
		if ( !is_front_page() ) the_title();
	}
	if(is_tag()){ echo "Tag: ".single_tag_title('',FALSE); }
	if(is_404()){ echo "404 - Page not Found"; }
	if(is_search()){ echo "Search"; }
	if(is_year()){ echo get_the_time('Y'); }
	if(is_month()){ echo get_the_time('F Y'); }
	if (is_author()){ echo __('Posts by ', 'good') . get_the_author(); }

	if ( !is_front_page() ) {
		echo "</div>";	
	}
}

/* get video embed string, attached on featured video on the post writing screen */
function fancythemes_video_post( $post_id = '' ){
	global $post;
	if ( !$post_id ) $post_id = $post->ID;
	$embed = '';
	if ( 'video' == get_post_format($post_id)){
		$video_options = get_post_meta($post_id, '_fancythemes_video_options', true );
		
		$parsed_video_url = parse_url($video_options['video_id']);
		if ( strpos($parsed_video_url['host'],'vimeo.com') !== false ){
			if ( $vimeocolor = fancythemes_get_option('content_link_color')) $vimeocolor = ltrim($vimeocolor,'#');
			else $vimeocolor = '00c0ff';
			
			$embed = '<div class="video-container"><iframe src="http://player.vimeo.com/video'. $parsed_video_url['path'] .'?title=0&amp;byline=0&amp;portrait=0&amp;color='. $vimeocolor .'" ></iframe></div>';
		}elseif( strpos($parsed_video_url['host'],'youtube.com') !== false ){
			$args = wp_parse_args( $parsed_video_url['query'], array('v'=>''));
			$embed = '<div class="video-container"><iframe src="http://www.youtube.com/embed/' . $args['v'] . '?wmode=transparent&amp;autohide=1&amp;egm=0&amp;hd=1&amp;iv_load_policy=3&amp;modestbranding=1&amp;rel=0&amp;showinfo=0&amp;showsearch=0" allowfullscreen></iframe></div>';
		}else{
			$embed = '';
		}
	}else{
		$embed = '';
	}	
	echo $embed;
}

/**
 * Ajax load more tag
 *
 * @since fancythemes 1.0
 */
function fancythemes_loadmore( $query = '' ){
	if ( $query )
		$wp_query = $query;
	else
		global $wp_query;
		
	$currpage = get_query_var('paged');
	$max_pages = $wp_query->max_num_pages;
	if (  ($max_pages > $currpage) && ( $max_pages > 1 ) ){
		echo '<nav class="page-navigation load-more">';
		next_posts_link( __('More Posts', 'good'), $max_pages );
		echo '</nav>';
	}
}

/**
 * Ajax load more for widget
 *
 * @since fancythemes 1.0
 */
function fancythemes_widget_loadmore( $query = '' ){
	if ( $query )
		$wp_query = $query;
	else
		global $wp_query;
		
	$currpage = get_query_var('posts_widget_page');
	$max_pages = $wp_query->max_num_pages;
	if (  ($max_pages > $currpage) && ( $max_pages > 1 ) ){
		echo '<nav class="page-navigation load-more">';
		next_posts_link( __('More Posts', 'good'), $max_pages );
		echo '</nav>';
	}
}


?>