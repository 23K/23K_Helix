<?php
/*======================================================================================

	23K DARWIN Extension
	Widget - Recent Posts

	----------------

	CHANGE LOG

	11.28.12	NEW: Created extension

=======================================================================================*/

add_action( 'widgets_init', 'helix_recent_widget' );
function helix_recent_widget() {
	register_widget( 'Recent_Widget' );
}


class Recent_Widget extends WP_Widget {

	function Recent_Widget() {
		$widget_ops = array( 'classname' => 'recent-widget', 'description' => __('A widget that displays a set number of recent posts.', 'recent-widget') );
		
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'recent-widget' );
		
		$this->WP_Widget( 'recent-widget', __('Helix Recent Posts', 'recent-widget'), $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance ) {
		extract( $args );
		
		$title = apply_filters('widget_title', $instance['title'] );
		$num_posts = $instance['num_posts'];
		
		echo $before_widget;
		
		if ( $title )
			echo $before_title . $title . $after_title;
			
			// find posts to exclude - those whose expiration date has passed and don't have alternate content specified
			$today = date('Y-m-d');
			$exclude_posts = array();
			$exclude = new WP_Query(array( 'post_type' => 'post', 'meta_query' => array(
				array('key' => 'rna_post_expiration_date', 'value' => $today, 'compare' => '<='),
				array('key' => 'rna_post_expiration_alt_content', 'value' => '', 'compare' => 'NOT EXISTS'),
				) ));
			if ( $exclude->have_posts() ) : while ( $exclude->have_posts() ) : $exclude->the_post();
				$exclude_posts[] = get_the_ID();
			endwhile; endif;
			
			helixpublish('preview-related', 1, array('numberposts' => $num_posts, 'orderby' => 'date', 'orderby' => 'DSC', 'post__not_in' => $exclude_posts));
		
		echo $after_widget;
	}
	
	 
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['num_posts'] = strip_tags( $new_instance['num_posts'] );

		return $instance;
	}

	
	function form( $instance ) {
		$defaults = array();
		$instance = wp_parse_args( (array) $instance, $defaults );

		echo '<p>
			<label for="' . $this->get_field_id( 'title' ) . '">'; _e('Title:', 'recent-widget'); echo '</label>
			<input id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" value="' . $instance['title'] . '" style="width: 100%;" class="widefat" />
		</p>
		<p>
			<label for="' . $this->get_field_id( 'num_posts' ) . '">'; _e('Number of Posts:', 'recent-widget'); echo '</label>
			<input id="' . $this->get_field_id( 'num_posts' ) . '" name="' . $this->get_field_name( 'num_posts' ) . '" value="' . $instance['num_posts'] . '" style="width: 100%;" class="widefat" />
		</p>';
	}
	
}

/*====================================================================================*/

?>
