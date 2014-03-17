<?php
/*======================================================================================

	23K DARWIN Extension
	Widget - Member Details

	----------------

	CHANGE LOG

	12.03.12	NEW: Created extension

=======================================================================================*/

add_action( 'widgets_init', 'helix_member_widget' );
function helix_member_widget() {
	register_widget( 'member_widget' );
}


class member_widget extends WP_Widget {

	function member_widget() {
		$widget_ops = array( 'classname' => 'member-widget', 'description' => __('A widget that displays information about the helix member.', 'member-widget') );
		
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'member-widget' );
		
		$this->WP_Widget( 'member-widget', __('Helix Member Details', 'member-widget'), $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance ) {
		extract( $args );
		
		$logo = $instance['logo'];
		$description = apply_filters('widget_textarea', empty( $instance['description'] ) ? '' : $instance['description'], $instance);
		$page1 = $instance['page1'];
		$page1title = $instance['page1title'];
		$page2 = $instance['page2'];
		$page2title = $instance['page2title'];
		$page3 = $instance['page3'];
		$page3title = $instance['page3title'];
		
		
		echo $before_widget;
		
		if ($logo) {
			echo '<img src="' . $logo . '" class="footer-logo" />';
		}
		
		if ($description) {
			echo wpautop($description);
		} 
		
		if ($page1) {
			echo '<a href="' . get_page_link($page1) . '" class="member-link">';
			if ($page1title) {
				echo $page1title;
			} else {
				echo get_the_title($page1);
			}
			echo '</a>';
		}
		
		if ($page2) {
			echo '<a href="' . get_page_link($page2) . '" class="member-link">';
			if ($page2title) {
				echo $page2title;
			} else {
				echo get_the_title($page2);
			}
			echo '</a>';
		}
		
		if ($page3) {
			echo '<a href="' . get_page_link($page3) . '" class="member-link">';
			if ($page3title) {
				echo $page3title;
			} else {
				echo get_the_title($page3);
			}
			echo '</a>';
		}
		
		echo $after_widget;
	}
	
	 
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		$instance['logo'] = strip_tags( $new_instance['logo'] );
		if ( current_user_can('unfiltered_html') ) {
			$instance['description'] =  $new_instance['description'];
		} else {
			$instance['description'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['description']) ) );
		}
		$instance['page1'] = strip_tags( $new_instance['page1'] );
		$instance['page1title'] = strip_tags( $new_instance['page1title'] );
		$instance['page2'] = strip_tags( $new_instance['page2'] );
		$instance['page2title'] = strip_tags( $new_instance['page2title'] );
		$instance['page3'] = strip_tags( $new_instance['page3'] );
		$instance['page3title'] = strip_tags( $new_instance['page3title'] );
		
		return $instance;
	}

	
	function form( $instance ) {
		$defaults = array();
		$instance = wp_parse_args( (array) $instance, $defaults );
		
		$logo = esc_attr( $instance['logo'] );
		$description = esc_attr( $instance['description'] );
		$page1 = esc_attr ( $instance['page1'] );
		$page1title = esc_attr( $instance['page1title'] );
		$page2 = esc_attr ( $instance['page2'] );
		$page2title = esc_attr( $instance['page2title'] );
		$page3 = esc_attr ( $instance['page3'] );
		$page3title = esc_attr( $instance['page3title'] );
		
		
		echo '<p>
			<label for="' . $this->get_field_id( 'logo' ) . '">'; _e('Logo:', 'member-widget'); echo '</label>
			<input id="' . $this->get_field_id('logo') . '" name="' . $this->get_field_name('logo') . '" value="' . $instance['logo'] . '" type="text" style="width: 100%;" class="widefat" />
		</p>
		<p>
			<label for="' . $this->get_field_id( 'description' ) . '">'; _e('Description:', 'member-widget'); echo '</label>
			<textarea id="' . $this->get_field_id('description') . '" name="' . $this->get_field_name('description') . '" rows="5" cols="20" style="width: 100%;" class="widefat">' . $instance['description'] . '</textarea>
		</p>
		<p><strong>Page 1</strong><br />
			<label for="' . $this->get_field_id('page1') . '">'; _e('Select Page:', 'member-widget'); echo '</label>';
			wp_dropdown_pages(array(
				'id' => $this->get_field_id('page1'),
				'name' => $this->get_field_name('page1'),
				'selected' => $instance['page1'],
				'show_option_none' => 'None'
			));
		echo '<br /><label for="' . $this->get_field_id( 'page1title' ) . '">'; _e('Title:', 'member-widget'); echo '</label>
			<input id="' . $this->get_field_id('page1title') . '" name="' . $this->get_field_name('page1title') . '" value="' . $instance['page1title'] . '" type="text" style="width: 100%;" class="widefat" />
		</p>
		<p><strong>Page 2</strong><br />
			<label for="' . $this->get_field_id('page2') . '">'; _e('Select Page:', 'member-widget'); echo '</label>';
			wp_dropdown_pages(array(
				'id' => $this->get_field_id('page2'),
				'name' => $this->get_field_name('page2'),
				'selected' => $instance['page2'],
				'show_option_none' => 'None'
			));
		echo '<br /><label for="' . $this->get_field_id( 'page2title' ) . '">'; _e('Title:', 'member-widget'); echo '</label>
			<input id="' . $this->get_field_id('page2title') . '" name="' . $this->get_field_name('page2title') . '" value="' . $instance['page2title'] . '" type="text" style="width: 100%;" class="widefat" />
		</p>
		<p><strong>Page 3</strong><br />
			<label for="' . $this->get_field_id('page3') . '">'; _e('Select Page:', 'member-widget'); echo '</label>';
			wp_dropdown_pages(array(
				'id' => $this->get_field_id('page3'),
				'name' => $this->get_field_name('page3'),
				'selected' => $instance['page3'],
				'show_option_none' => 'None'
			));
		echo '<br /><label for="' . $this->get_field_id( 'page3title' ) . '">'; _e('Title:', 'member-widget'); echo '</label>
			<input id="' . $this->get_field_id('page3title') . '" name="' . $this->get_field_name('page3title') . '" value="' . $instance['page3title'] . '" type="text" style="width: 100%;" class="widefat" />
		</p>';
			
	}
	
}

/*====================================================================================*/

?>
