					<?php global $slider_post_counter, $slider_post_total; ?>
					<article <?php post_class('boxed group'); ?>>
					
						<?php if (has_post_thumbnail()): ?>
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="home-thumb boxed" >	
							<?php the_post_thumbnail('large'); ?>
						</a>
						<?php endif; ?>
						<div class="post-detail">
							<div class="nav-meta">
								<?php echo 'Featured ' . $slider_post_counter . ' of ' . $slider_post_total; ?>
							</div>
							<h2 class="entry-title">
								<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
							</h2>
							<p class="entry-content">
								<?php echo get_the_excerpt(); ?>
							</p>
							<div class="meta">
								<?php 
								$format_prefix = '%2$s';
								$date = sprintf( '<span class="date"><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a></span>',
									esc_url( get_permalink() ),
									esc_attr( sprintf( __( 'Permalink to %s', 'good' ), the_title_attribute( 'echo=0' ) ) ),
									esc_attr( get_the_date( 'c' ) ),
									esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date() ) )
								);
								echo $date; 
								?>
							</div>
						</div>
					</article>