<?php
/*======================================================================================

	23K DARWIN Extension
	Widget - Sidebar Location

	----------------

	CHANGE LOG

	11.26.12	NEW: Created extension
	01.17.13	UPD: Added customization options

=======================================================================================*/

add_action( 'widgets_init', 'helix_header_locations_widget' );
function helix_header_locations_widget() {
	register_widget( 'Header_Locations_Widget' );
}


class Header_Locations_Widget extends WP_Widget {

	function Header_Locations_Widget() {
		$widget_ops = array( 'classname' => 'header-loc-widget', 'description' => __('A widget that displays member contact info in the masthead toolbar.', 'header-loc-widget') );
		
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'header-loc-widget' );
		
		$this->WP_Widget( 'header-loc-widget', __('Helix Header Locations', 'header-loc-widget'), $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance ) {
		extract( $args );

		echo $before_widget;

		echo '<p class="masthead-locations">';
			$locnum = 0;
			$locs_query = new WP_Query( array( 'post_type' => 'locations', 'post_status' => 'publish', 'orderby' => 'menu_order', 'order' => 'ASC' ) );
		while ( $locs_query->have_posts() ) : $locs_query->the_post();
			global $post;
			$locnum++;
			$rna_locations_phone = get_post_meta( $post->ID, 'rna_locations_phone', true );
			
			if ( $instance[$locnum] == '1' ) {
				echo '<span class="location-info">';
				
				if ( $instance['loc-link'] != '1' ) {
					dxlink_the_title();
				} else {
					the_title();
				}
				
				if ( $instance['loc-phone'] != '1' ) {
					if ( $rna_locations_phone ) {
						echo ': ' . $rna_locations_phone;
					}
				}
				
				echo '</span>';
			}
		
		endwhile;
		
		echo '</p>';
		
		echo $after_widget;
	}
	
	 
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		$locs_query = new WP_Query( array( 'post_type' => 'locations', 'post_status' => 'publish', 'orderby' => 'menu_order', 'order' => 'ASC' ) );
		$locnum = 0;
		while ( $locs_query->have_posts() ) : $locs_query->the_post();
			
			global $post;
			$locnum++;

			$instance[$locnum] = $new_instance[$locnum];
		
		endwhile;
		
		$instance['loc-link'] = $new_instance['loc-link'];
		$instance['loc-phone'] = $new_instance['loc-phone'];
		
		return $instance;
	}

	
	function form( $instance ) {
		$defaults = array();
		$instance = wp_parse_args( (array) $instance, $defaults );
		
		echo '<p><strong>Show Locations:</strong></p>';
		
		$locs_query = new WP_Query( array( 'post_type' => 'locations', 'post_status' => 'publish', 'orderby' => 'menu_order', 'order' => 'ASC' ) );
		$locnum = 0;
		while ( $locs_query->have_posts() ) : $locs_query->the_post();
			
			global $post;
			$locnum++;
			
			echo '<p>
				<input id="' . $this->get_field_id($locnum) . '" name="' . $this->get_field_name($locnum) . '" type="checkbox" value="1" '; checked( $instance[$locnum], '1'); echo '/>
				<label for="' . $this->get_field_id($locnum) . '">' . get_the_title() . '</label>
			</p>';
			
		endwhile;
		echo '<p style="margin-top: 25px;"><strong>Customization Options:</strong></p>
		<p>
			<input id="' . $this->get_field_id('loc-link') . '" name="' . $this->get_field_name('loc-link') . '" type="checkbox" value="1" '; checked( $instance['loc-link'], '1'); echo '/>
			<label for="' . $this->get_field_id('loc-link') . '">Don\'t link location name to location page</label>
		</p>
		<p>
			<input id="' . $this->get_field_id('loc-phone') . '" name="' . $this->get_field_name('loc-phone') . '" type="checkbox" value="1" '; checked( $instance['loc-phone'], '1'); echo '/>
			<label for="' . $this->get_field_id('loc-phone') . '">Don\'t show phone number</label>
		</p>';
	}
}

/*====================================================================================*/

?>
