<?php
// www.fancythemes.com

class WP_Widget_Recent_Comments_fancythemes extends WP_Widget {
	function __construct() {
        parent::__construct(
        // Base ID of your widget
        'recent_comments_fancythemes', 

        // Widget name will appear in UI
        __('fancythemes - Recent Comments', 'good'), 

        // Widget description
        array( 'description' => __('fancythemes - Recent Comments', 'good'), ) 
        );
    }

	/** @see WP_Widget::widget */
	public function widget($args, $instance) {		
		extract( $args );
		$default = 	array('widget_title'=>__('Latest Comments', 'good'), 'quantity'=>'5' );
		$instance = wp_parse_args($instance, $default);			
		$widget_title = apply_filters('widget_title', $instance['widget_title']);
		$quantity = $instance['quantity'];
		// DISPLAY WIDGET
		echo $before_widget;
		?>
		<?php if(!empty($instance['widget_title'])){ echo $before_title . $widget_title . $after_title; } ?>
		<div class="small-thumb-view" >
			<?php
				$q = $quantity;
				$i = 0;
				$recent_comments = get_comments( array(
					'number'    => $quantity,
					'status'    => 'approve'
				) );
				$size = 55;
//print_r($recent_comments);
				foreach ( $recent_comments as $comment ){
					$grav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $comment->comment_author_email ) ) ) . "?s=" . $size;
				?>
				<article class="post" >
					<div class="meta"> <?php _e('By', 'good'); ?> <a href="<?php echo get_permalink($comment->comment_post_ID).'#comment-'.$comment->comment_ID; ?>" class="comment_link"><?php echo $comment->comment_author; ?></a> </div>
					<h4 class="entry-title no-heading-style"><a href="<?php echo get_permalink($comment->comment_post_ID ).'#comment-'.$comment->comment_ID;  ?>"><?php echo trim_words(get_comment_excerpt($comment->comment_ID), 10); ?></a></h4>					
				</article>
				<?php
				}
				?>

		</div>	
		<?php
		echo $after_widget;
	}

	/** @see WP_Widget::update */
	public function update($new_instance, $old_instance) {				
		$instance = $old_instance;
		$instance['widget_title'] = strip_tags($new_instance['widget_title']);
		$instance['quantity'] = strip_tags($new_instance['quantity']);

		return $instance;
	}

	/** @see WP_Widget::form */
	public function form($instance) {		
		$default = 	array('widget_title'=>__('Latest Comments', 'good'), 'quantity'=>'5' );
		$instance = wp_parse_args($instance, $default);			
		$widget_title = $instance['widget_title'];
		$quantity = $instance['quantity'];
		?>
		<p>
			Widget title:
			<input class="widefat" type="text" name="<?php echo $this->get_field_name('widget_title'); ?>" value="<?php echo $widget_title; ?>" />
		</p>
		<p>
			Posts:
			<input class="widefat" type="text" name="<?php echo $this->get_field_name('quantity'); ?>" value="<?php echo $quantity; ?>" />
		</p>
		<?php 
	}

} // class FooWidget

add_action('widgets_init', create_function('', 'return register_widget("WP_Widget_Recent_Comments_fancythemes");'));

?>