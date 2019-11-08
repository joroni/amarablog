<?php
// www.fancythemes.com

class WP_Widget_Recent_Posts_fancythemes extends WP_Widget {
	function __construct() {
        parent::__construct(
        // Base ID of your widget
        'recent_posts_fancythemes', 

        // Widget name will appear in UI
        __('fancythemes - Recent Posts', 'good'), 

        // Widget description
        array( 'description' => __('fancythemes - Recent Posts', 'good'), ) 
        );
    }

	/** @see WP_Widget::widget */
	public function widget($args, $instance) {		
		extract( $args );
		$default = array ('widget_title'=>__('Recent Posts','good'), 'cats'=>'', 'cat'=>'', 'quantity'=>1, 'exclude'=>'', 'order'=>'date', 'display'=>'type-2', 'excerpt'=>'display', 'not_in'=>'' );
		$instance = wp_parse_args($instance, $default);
		$widget_title = apply_filters('widget_title', $instance['widget_title']);
		$cats = $instance['cats'];
		$tags = $instance['tags'];
		$quantity = $instance['quantity'];
		$exclude = $instance['exclude'];
		$order = $instance['order'];
		$display = $instance['display'];
		$excerpt = $instance['excerpt'];
		$not_in = $instance['not_in'];
		$time = $instance['time'];
		$pagination = $instance['pagination'];
		
		if (is_array($cats)) $cats = implode(",", $cats);
		if (is_array($tags)) $tags = implode(",", $tags);
		// DISPALY WIDGET
		echo $before_widget;
		//if(!empty($instance['widget_title'])){ echo $before_title . $widget_title . $after_title; }

		if(!empty($instance['widget_title'])){
			echo $before_title . $widget_title . $after_title; 
		}else{
			echo '<hr class="no-title">';
		} 

		$q = $quantity;
		$i = 0;
		$args = array(	'cat' => $cats,
						'tag_slug__in' => $tags,
						'orderby'=>$order, 
						'post_status' => 'publish', 
						'ignore_sticky_posts' => 1,
						'post__not_in' => $not_in,
						'pagination' => $pagination);
						
		$args['posts_per_page'] = $quantity;
		
		$today = getdate();				
		if ( $time == '2' ){
			$args['year'] =  $today["year"];
			$args['monthnum'] =  $today["mon"];
			$args['day'] =  $today["mday"];
		}
		if ( $time == '3' ){
			$args['date_query'] = Array('year' => $today["year"], 'week' => date('W') );
		}
		if ( $time == '4' ){
			$args['year'] =  $today["year"];
			$args['monthnum'] =  $today["mon"];
		}

		//global $theme_options;
		if ( isset($args['posts_per_page'])){
			$paged = ( get_query_var( 'posts_widget_page' ) ) ? get_query_var( 'posts_widget_page' ) : 1;
			$args['paged'] = $paged;
		}
		//echo $paged;
		//echo get_query_var( 'posts_widget_page' );

		$recent = new WP_Query($args);
		
		if ( $widget_position !== 'sidebar')
			$display_view = !empty($display) ? $display : 'two-columns';
		else
			$display_view = '';
		
		$total_post = $recent->post_count;
		if ( ! $recent->have_posts() ) return 0;	?>
					<div class="site-content group posts-block <?php echo $display_view; ?> <?php echo 'sort-' . $order; ?>">
						<?php 
						while($recent->have_posts()) : $recent->the_post();
							if ( $widget_position == 'sidebar'){
								get_template_part( 'content', 'no-thumbnail' );
							}else{
								get_template_part( 'content', $display_view );
							}
						endwhile;

						wp_reset_query(); 
						?>
					</div>
					
		<?php

		if ( $args['pagination'] == 'more' ) {
			$currpage = $paged;
			$max_pages = $recent->max_num_pages;
			if (  ($max_pages > $currpage) && ( $max_pages > 1 ) ){
				echo '<nav class="page-navigation load-more">';
				echo '<a href="'. add_query_arg( 'posts_widget_page', $currpage + 1 ) .'">';
				echo __('Load More', 'good');
				echo '</a>';
				echo '</nav>';
			}					
		}
				
		echo $after_widget;
	}

	/** @see WP_Widget::update */
	public function update($new_instance, $old_instance) {				
		$instance = $old_instance;
		$instance['widget_title'] = strip_tags($new_instance['widget_title']);
		$instance['cats'] = $new_instance['cats'];
		$instance['tags'] = $new_instance['tags'];
		$instance['quantity'] = strip_tags($new_instance['quantity']);
		$instance['exclude'] = strip_tags($new_instance['exclude']);
		$instance['order'] = strip_tags($new_instance['order']);
		$instance['time'] = strip_tags($new_instance['time']);
		$instance['pagination'] = $new_instance['pagination'];
		$instance['display'] = strip_tags($new_instance['display']);
			
		$default = array ('widget_title'=>__('Recent Posts','good'), 'cats'=>'', 'cat'=>'', 'quantity'=>1, 'exclude'=>'', 'order'=>'date', 'display'=>'type-2');

		return $instance;
	}

	/** @see WP_Widget::form */
	public function form($instance) {				
		$default = array ('widget_title'=>__('Recent Posts','good'), 'title'=>'', 'cats'=>'', 'tags'=>'', 'quantity'=>1, 'exclude'=>'', 'order'=>'date', 'display'=>'type-2', 'pagination'=> '');
		$instance = wp_parse_args( $instance, $default );
		$title = $instance['title'];
		$widget_title = $instance['widget_title'];
		$cats = $instance['cats'];
		$tags = $instance['tags'];
		$quantity = $instance['quantity'];
		$exclude = $instance['exclude'];
		$order = $instance['order'];
		$display = $instance['display'];
		$pagination = $instance['pagination'];
		?>
		<input style="display:none;" type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
		<p>
			<?php _e('Widget title : ', 'good'); ?>
			<input class="widefat" type="text" name="<?php echo $this->get_field_name('widget_title'); ?>" value="<?php echo $widget_title; ?>" />
		</p>
		<p>
			<?php _e('Category filter :', 'good'); ?>
			<select name="<?php echo $this->get_field_name('cats'); ?>[]" class="widefat" multiple="multiple">
				<?php
				$of_categories = array();
				$of_categories_obj = get_categories();
				foreach ($of_categories_obj as $of_cat) {
				?>
				<option value="<?php echo $of_cat->cat_ID; ?>" <?php if ( is_array($cats) && in_array( $of_cat->cat_ID, $cats ) ) echo 'selected'; ?>><?php echo $of_cat->cat_name; ?></option>
				<?php 
				}
				?>
			</select>
        </p>
		<p>
			<?php _e('Tags filter :', 'good'); ?>
			<select name="<?php echo $this->get_field_name('tags'); ?>[]" class="widefat" multiple>
				<?php
				$of_categories = array();  
				$of_tags_obj = get_tags();
				foreach ($of_tags_obj as $of_tag) {
				?>
				<option value="<?php echo $of_tag->slug; ?>" <?php if ( is_array($tags) && in_array( $of_tag->slug, $tags ) ) echo 'selected'; ?>><?php echo $of_tag->name; ?></option>
				<?php 
				}
				?>
			</select>
        </p>
		<!-- <p>
			<?php _e('Time filter :', 'good'); ?><br/>
			<input type="radio" name="<?php echo $this->get_field_name('time'); ?>" id="<?php echo $this->get_field_name('time'); ?>1" value="1" <?php checked($time, '1', true); ?> />
			<label for="<?php echo $this->get_field_name('time'); ?>1"><?php _e('All', 'good'); ?></label><br/> 
			<input type="radio" name="<?php echo $this->get_field_name('time'); ?>" id="<?php echo $this->get_field_name('time'); ?>2" value="2" <?php checked($time, '2', true); ?> />
			<label for="<?php echo $this->get_field_name('time'); ?>2"><?php _e('Today', 'good'); ?></label><br/> 
			<input type="radio" name="<?php echo $this->get_field_name('time'); ?>" id="<?php echo $this->get_field_name('time'); ?>3" value="3" <?php checked($time, '3', true); ?> />
			<label for="<?php echo $this->get_field_name('time'); ?>3"><?php _e('This week', 'good'); ?></label><br/> 
			<input type="radio" name="<?php echo $this->get_field_name('time'); ?>" id="<?php echo $this->get_field_name('time'); ?>4" value="4" <?php checked($time, '4', true); ?> />
			<label for="<?php echo $this->get_field_name('time'); ?>4"><?php _e('This month', 'good'); ?></label> 
		</p>-->
		<p>
			<?php _e('Number of posts :', 'good'); ?>
			<select name="<?php echo $this->get_field_name('quantity'); ?>">
				<option value="1" <?php selected($quantity, '1', true); ?> >1</option>
				<option value="2" <?php selected($quantity, '2', true); ?> >2</option>
				<option value="3" <?php selected($quantity, '3', true); ?> >3</option>
				<option value="4" <?php selected($quantity, '4', true); ?> >4</option>
				<option value="5" <?php selected($quantity, '5', true); ?> >5</option>
				<option value="6" <?php selected($quantity, '6', true); ?> >6</option>
				<option value="7" <?php selected($quantity, '7', true); ?> >7</option>
				<option value="8" <?php selected($quantity, '8', true); ?> >8</option>
				<option value="9" <?php selected($quantity, '9', true); ?> >9</option>
				<option value="10" <?php selected($quantity, '10', true); ?> >10</option>
				<option value="11" <?php selected($quantity, '11', true); ?> >11</option>
				<option value="12" <?php selected($quantity, '12', true); ?> >12</option>
				<option value="13" <?php selected($quantity, '13', true); ?> >13</option>
				<option value="14" <?php selected($quantity, '14', true); ?> >14</option>
				<option value="15" <?php selected($quantity, '15', true); ?> >15</option>
			</select><br>
		</p>
		<p>
			<input type="checkbox" name="<?php echo $this->get_field_name('pagination'); ?>" id="<?php echo $this->get_field_name('pagination'); ?>" value="more" <?php checked($pagination, 'more', true); ?> />
			<label for="<?php echo $this->get_field_name('pagination'); ?>" ><?php _e('Load more button', 'good'); ?></label><br>
		</p>
		<p>
			<?php _e('Order posts by:','good'); ?>
			<select name="<?php echo $this->get_field_name('order'); ?>">
				<option value="date" <?php selected($order, 'date', true); ?>>date</option>
				<option value="rand" <?php selected($order, 'rand', true); ?>>random</option>
                <option value="comment_count" <?php selected($order, 'comment_count', true); ?>>popular</option>
			</select>
		</p>
        <p>
			<?php _e('Display type:', 'good'); ?>
			<select name="<?php echo $this->get_field_name('display'); ?>">
				<option value="two-columns" <?php selected($display, 'two-columns', true); ?>>Two columns</option>
				<option value="three-columns" <?php selected($display, 'three-columns', true); ?>>Three columns</option>
				<option value="small-thumbnail" <?php selected($display, 'small-thumbnail', true); ?>>Two columns with small thumbnail </option>
			</select>
		</p>
		<?php 
	}

} // class FooWidget

add_action('widgets_init', create_function('', 'return register_widget("WP_Widget_Recent_Posts_fancythemes");'));

?>