					<article <?php post_class('boxed group'); ?>>
					
						<?php if (has_post_thumbnail()): ?>
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="home-thumb boxed" >	
							<?php the_post_thumbnail('good-thumb-450'); ?>
						</a>
						<?php endif; ?>
						<div class="post-detail">
							<h4 class="entry-title">
								<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
							</h4>
							<div class="meta">
								<?php 
								$format_prefix = '%2$s';
								$date = sprintf( '<span class="date"><time class="entry-date" datetime="%1$s">%2$s</time></span>',
									esc_attr( get_the_date( 'c' ) ),
									esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date() ) )
								);
								echo $date; 
								?>
							</div>
						</div>
					</article>