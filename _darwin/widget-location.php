<?php
/*======================================================================================

	23K DARWIN Extension
	Widget - Location

	----------------

	CHANGE LOG

	11.26.12	NEW: Created extension
	01.17.13	UPD: Added customization options

=======================================================================================*/

add_action( 'widgets_init', 'helix_location_widget' );
function helix_location_widget() {
	register_widget( 'Location_Widget' );
}


class Location_Widget extends WP_Widget {

	function Location_Widget() {
		$widget_ops = array( 'classname' => 'loc-widget', 'description' => __('A widget that displays member location info in the sidebar.', 'loc-widget') );
		
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'loc-widget' );
		
		$this->WP_Widget( 'loc-widget', __('Helix Location', 'loc-widget'), $widget_ops, $control_ops );
	}
	
	function widget( $args, $instance ) {
		extract( $args );
		
		global $post;
		
		echo $before_widget;
		
		$offset = $instance['loc'] - 1;
		$loc_query = new WP_Query( array( 'post_type' => 'locations', 'post_status' => 'publish', 'orderby' => 'menu_order', 'order' => 'ASC', 'posts_per_page' =>' 1', 'offset' => $offset ) );
			while ( $loc_query->have_posts() ) : $loc_query->the_post();
				
				$rna_locations_street = get_post_meta( $post->ID, 'rna_locations_street', true );
				$rna_locations_city = get_post_meta( $post->ID, 'rna_locations_city', true );
				$rna_locations_state = get_post_meta( $post->ID, 'rna_locations_state', true );
				$rna_locations_zip = get_post_meta( $post->ID, 'rna_locations_zip', true );
				$rna_locations_phone = get_post_meta( $post->ID, 'rna_locations_phone', true );
				$rna_locations_phone2 = get_post_meta( $post->ID, 'rna_locations_phone2', true );
				
				if ( $instance['loc-img'] != '1' ) {
					if ( has_post_thumbnail() ) {
						$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'sidebar-feature' );
						echo '<div class="location-image">
							<img src="' . $thumb['0'] . '" />
						</div>';
					}
				}
				
				echo $before_title;
				if ( $instance['loc-link'] != '1' ) {
					echo '<a href="' . get_permalink($post->ID) . '">';
				}
				the_title();
				if ( $instance['loc-link'] != '1' ) {
					echo '</a>';
				}
				echo $after_title;
				
				if ( has_excerpt() ) {
					echo '<p>' . str_replace('&raquo;', '', str_replace('Read More', '', get_the_excerpt())) . '</p>';
				}
				
				if ( $instance['loc-add'] != '1' ) {
					if ( $rna_locations_street ) {
						echo '<p class="address first">' . $rna_locations_street . '</p>';
					}
					if ( $rna_locations_city ) {
						echo '<p class="address">' . $rna_locations_city . ', ' . $rna_locations_state . ' ' . $rna_locations_zip . '</p>';
					}
				}
				
				if ( $instance['loc-directions'] != '1' ) {
					if ( $rna_locations_city ) {
						if ( $rna_locations_street ) {
							$add1 = str_replace(' ', '+', $rna_locations_street);
						} else {
							$add1 = '';
						}
						
						$city = str_replace(' ', '+', $rna_locations_city);
						$state = str_replace(' ' ,'+', $rna_locations_state);
						$zip = str_replace(' ' ,'+', $rna_locations_zip);
						
						if ( $rna_locations_state ) {
							if ( $rna_locations_zip ) {
								$add2 = $city . '+' . $state . '+' . $zip;
							} else {
								$add2 = $city . '+' . $state;
							}
						} else {
							$add2 = $city;
						}
						
						echo '<p class="directions"><a href="https://maps.google.com/maps?q=' . $add1 . '+' . $add2 . '&hl=en" target="_blank">Get Directions</a></p>';
					}
				}
				
				if ( $instance['loc-phone'] != '1' ) {
					if ( $rna_locations_phone ) {
						echo '<p class="phone first">' . $rna_locations_phone . '</p>';
					}
					if ( $rna_locations_phone2 ) {
						echo '<p class="phone">' . $rna_locations_phone2 . '</p>';
					}
				}
				
			endwhile;
		
		echo $after_widget;
	}
	
	 
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		
		$instance['loc'] = strip_tags( $new_instance['loc'] );
		$instance['loc-img'] = $new_instance['loc-img'];
		$instance['loc-add'] = $new_instance['loc-add'];
		$instance['loc-directions'] = $new_instance['loc-directions'];
		$instance['loc-phone'] = $new_instance['loc-phone'];
		$instance['loc-link'] = $new_instance['loc-link'];
		return $instance;
	}

	
	function form( $instance ) {
		$defaults = array();
		$instance = wp_parse_args( (array) $instance, $defaults );
		
		$loc = esc_attr( $instance['loc'] );
		
		echo '<p>
			<label for="' . $this->get_field_id('loc') . '"><strong>Location:</strong></label>
			<select name="' . $this->get_field_name('loc') . '" id="' . $this->get_field_id('loc') . '" class="widefat" style="margin-top: 5px;">';
			
			$location_opts = array();
			
			$loc_query = new WP_Query( array( 'post_type' => 'locations', 'post_status' => 'publish', 'orderby' => 'menu_order', 'order' => 'ASC' ) );
			while ( $loc_query->have_posts() ) : $loc_query->the_post();
				$location_opts[] = get_the_title();
			endwhile;
			
			$count = '0';
			foreach ($location_opts as $location_opt) {
				$count++;
				echo '<option value="' . $count . '" id="' . $count . '"';
					if ( $loc == $count ) {
						echo ' selected="selected"';
					}
					echo '>' . $location_opt . '</option>';
			}
		echo '</select>
		</p>
		<p style="margin-top: 20px;"><strong>Customization Options:</strong></p>
		<p>
			<input id="' . $this->get_field_id('loc-img') . '" name="' . $this->get_field_name('loc-img') . '" type="checkbox" value="1" '; checked( $instance['loc-img'], '1'); echo '/>
			<label for="' . $this->get_field_id('loc-img') . '">Hide featured image</label>
		</p>
		<p>
			<input id="' . $this->get_field_id('loc-add') . '" name="' . $this->get_field_name('loc-add') . '" type="checkbox" value="1" '; checked( $instance['loc-add'], '1'); echo '/>
			<label for="' . $this->get_field_id('loc-add') . '">Hide address</label>
		</p>
		<p>
			<input id="' . $this->get_field_id('loc-directions') . '" name="' . $this->get_field_name('loc-directions') . '" type="checkbox" value="1" '; checked( $instance['loc-directions'], '1'); echo '/>
			<label for="' . $this->get_field_id('loc-directions') . '">Hide directions link</label>
		</p>
		<p>
			<input id="' . $this->get_field_id('loc-phone') . '" name="' . $this->get_field_name('loc-phone') . '" type="checkbox" value="1" '; checked( $instance['loc-phone'], '1'); echo '/>
			<label for="' . $this->get_field_id('loc-phone') . '">Hide phone number</label>
		</p>
		<p>
			<input id="' . $this->get_field_id('loc-link') . '" name="' . $this->get_field_name('loc-link') . '" type="checkbox" value="1" '; checked( $instance['loc-link'], '1'); echo '/>
			<label for="' . $this->get_field_id('loc-link') . '">Don\'t link location name to location page</label>
		</p>';
	}
	
}

/*====================================================================================*/

?>
