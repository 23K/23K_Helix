<?php
/*======================================================================================

	23K DARWIN Extension
	Widget - Gallery

	----------------

	CHANGE LOG

	11.28.12	NEW: Created extension

=======================================================================================*/

add_action( 'widgets_init', 'helix_gallery_widget' );
function helix_gallery_widget() {
	register_widget( 'Gallery_Widget' );
}


class Gallery_Widget extends WP_Widget {

	function Gallery_Widget() {
		$widget_ops = array( 'classname' => 'gallery-widget', 'description' => __('A widget that displays a gallery photo and links to the gallery.', 'gallery-widget') );
		
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'gallery-widget' );
		
		$this->WP_Widget( 'gallery-widget', __('Helix Gallery Preview', 'gallery-widget'), $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance ) {
		extract( $args );
		
		$img = $instance['img'];
		if ( ! $img ) {
			$args = array( 'posts_per_page' => '1', 'post_type' => 'photo-gallery', 'orderby' => 'rand' );
			$galquery = new WP_Query($args);
			if ( $galquery->have_posts() ) {
				while ($galquery->have_posts()) : $galquery->the_post();
					$img = $post->ID;
				endwhile;
			}
		}
		$the_img = wp_get_attachment_image_src( get_post_thumbnail_id( $img ), 'from-gallery');
		
		$headline = $instance['headline'];
		if ( ! $headline ) {
			$the_headline = 'Browse our Gallery';
		} else {
			$the_headline = $headline;
		}
		
		$desc = $instance['desc'];
		if ( ! $desc ) {
			$the_desc = 'Get inspired by award winning examples of our custom work.';
		} else {
			$the_desc = $desc;
		}
		
		
		echo $before_widget;
		
		echo '<a href="/gallery/showcase/">
			<img src="' . $the_img[0] . '" width="230" />'
			
			. $before_title . $the_headline . $after_title
			.	'<p>' . $the_desc . '</p>
		</a>';
		
		echo $after_widget;
	}
	
	 
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		$instance['img'] = strip_tags( $new_instance['img'] );
		$instance['headline'] = strip_tags( $new_instance['headline'] );
		$instance['desc'] = strip_tags( $new_instance['desc'] );
		
		return $instance;
	}

	
	function form( $instance ) {
		$defaults = array();
		$instance = wp_parse_args( (array) $instance, $defaults );
		
		$img = esc_attr( $instance['img'] );
		$headline = esc_attr( $instance['headline'] );
		$desc = esc_attr( $instance['desc'] );
		
		
		echo '<p>
			<label for="' . $this->get_field_id( 'img' ) . '">'; _e('Gallery Photo ID:', 'gallery-widget'); echo '</label>
			<input id="' . $this->get_field_id('img') . '" name="' . $this->get_field_name('img') . '" value="' . $instance['img'] . '" type="text" style="width: 100%;" class="widefat" />
		</p>
		<p>Enter a specific gallery photo ID to display. If no ID is entered, a random photo will be shown.</p>
		<p>
			<label for="' . $this->get_field_id( 'headline' ) . '">'; _e('Headline:', 'gallery-widget'); echo '</label>
			<input id="' . $this->get_field_id('headline') . '" name="' . $this->get_field_name('headline') . '" value="' . $instance['headline'] . '" type="text" style="width: 100%;" class="widefat" />
		</p>
		<p>Optional; default is "Browse our Gallery".</p>
		<p>
			<label for="' . $this->get_field_id( 'desc' ) . '">'; _e('Description:', 'gallery-widget'); echo '</label>
			<textarea id="' . $this->get_field_id('desc') . '" name="' . $this->get_field_name('desc') . '" rows="2" cols="20" style="width: 100%;" class="widefat">' . $instance['desc'] . '</textarea>
		</p>
		<p>Optional; default is "Get inspired by award winning examples of our custom work."</p>';
	}
	
}

/*====================================================================================*/

?>
