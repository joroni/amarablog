<?php

// www.fancythemes.com

class WP_Widget_Flickr_fancythemes extends WP_Widget {
	function __construct() {
        parent::__construct(
        // Base ID of your widget
        'flickr_fancythemes', 

        // Widget name will appear in UI
        __('fancythemes - Flickr', 'good'), 

        // Widget description
        array( 'description' => __('fancythemes - Flickr', 'good'), ) 
        );
    }

	public function widget($args, $instance) {		
		extract( $args );
		$default = array('widget_title'=>__('Latest Pictures','good'), 'id'=> '', 'qty'=>8 );			
		$instance = wp_parse_args($instance, $default);			
		$widget_title = apply_filters('widget_title', $instance['widget_title']);
		$id = $instance['id'];
		$qty = $instance['qty'];
		// WIDGET OUTPUT
		echo $before_widget;
		?>
		<?php if(!empty($widget_title)){ echo $before_title.$widget_title.$after_title ;} ?>
		<div class="flickr_widget group">
		<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $qty; ?>&amp;display=latest&amp;size=s&amp;layout=x&amp;source=user&amp;user=<?php echo $id; ?>"></script>
		</div>
		<p><a rel="nofollow" class="widget-more" href="http://www.flickr.com/photos/<?php echo $id; ?>/"><?php _e('More Photos', 'good'); ?> &rarr;</a></p>
		<?php
		echo $after_widget;		
	}

	public function update($new_instance, $old_instance) {				
		$instance = $old_instance;
		$instance['widget_title'] = strip_tags($new_instance['widget_title']);
		$instance['id'] = $new_instance['id'];
		$instance['qty'] = $new_instance['qty'];

		return $instance;
	}

	public function form($instance) {	
		$default = array('widget_title'=>__('Latest Pictures','good'), 'id'=> '', 'qty'=>8 );			
		$instance = wp_parse_args($instance, $default);			
		$widget_title = $instance['widget_title'];
		$id = $instance['id'];
		$qty = $instance['qty'];
	?>
		<p>
			Widget title:
			<input class="widefat" type="text" name="<?php echo $this->get_field_name('widget_title'); ?>" value="<?php echo $widget_title; ?>" />
		</p>
		<p>
			Enter ID of your flickr account (<a href="<?php esc_url('http://www.idgettr.com','good'); ?>">idGettr</a>) :
			<input class="widefat" type="text" name="<?php echo $this->get_field_name('id'); ?>" value="<?php echo $id; ?>" />
		</p>
		<p>
			Display up to :
            <input class="widefat" type="text" name="<?php echo $this->get_field_name('qty'); ?>" value="<?php echo $qty; ?>" />
			Photos
		</p>

	<?php
	}

}

add_action('widgets_init', create_function('', 'return register_widget("WP_Widget_Flickr_fancythemes");'));
?>