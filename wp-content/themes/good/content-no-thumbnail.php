					<article <?php post_class('boxed group'); ?>>					
						<div class="meta">
							<span class="comment-count">
									<?php comments_popup_link( __( 'No Comment', 'good' ), __( '1 Comment', 'good' ), __( '% Comments', 'good' ) ); ?>
							</span>

							<?php 
							$format_prefix = '%2$s';
							$date = sprintf( '<span class="date"><time class="entry-date" datetime="%1$s">%2$s</time></span>',
								esc_attr( get_the_date( 'c' ) ),
								esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date() ) )
							);
							echo $date; 
							?>
						</div>
						<h4 class="no-heading-style">
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
						</h4>
					</article>