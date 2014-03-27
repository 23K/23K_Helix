<?php

/*======================================================================================
	23K Helix
	Shortcodes
======================================================================================*/

// Leadout tab
function helix_leadout($params, $content = null) {
	extract(shortcode_atts(array(
		'cta' => '',
		'link' => ''
	), $params));
	
	$output = '<div class="leadout">
		<a href="' . $link . '"><div class="tab"><div class="pre-tab"></div><h4>' . $cta . '</h4></div></a>
		<div class="description">
		'. $content . '
		</div>
		<div class="clear"></div>
	</div>';
	
	return $output;
}
add_shortcode('leadout','helix_leadout');


// Post divider
function helix_postdivider($params, $content = null) {
	return '<div class="divider post"></div>';
}
add_shortcode('postdivider','helix_postdivider');


// Show preview of 1 gallery
function helix_gallery_preview($params, $content = null) {
	extract(shortcode_atts(array(
		'slug' => '',
		'title' => '',
		'type' => '',
		'speed' => '2500'
	), $params));
	
	global $post;
	
	$term = get_term_by('slug', $slug, 'gallery');
	
	if ( $title == '' ) $the_title = 'From our ' . $term->name . ' Gallery';
	else $the_title = $title;
	
	if ( $type == 'sliding' ) {
		$sliding_class = ' sliding';
		$number = '-1';
	} else {
		$sliding_class = '';
		$number = '3';
	}
	
	$output = '<div class="from-gallery ' . $sliding_class . '">
		<h4>' . $the_title . '</h4>';
	
	if ( $type == 'sliding' ) {
		$output .= '<div class="sliding-container">';
	}
	
	$query = new WP_Query(array( 'numberposts' => $number, 'post_type' => 'photo-gallery', 'gallery' => $term->slug ) );
	$i = 0;
	if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
		$i++;
		
		if ( has_post_thumbnail ) {
			$thumb = get_the_post_thumbnail($post->ID, 'from-gallery-page');
			
			$output .= '<div class="gallery-preview preview-' . $i . '"><a href="/gallery/' . $slug . '">' . $thumb . '</a></div>';
		}
	endwhile; endif;
	
	$output .= '<div class="clear"></div>';
	
	if ( $type == 'sliding' ) {
		$output .= '</div><a href="/gallery/' . $slug . '"><div class="sliding-top"></div></a>';
	}
	
	$output .= '<a href="/gallery/' . $slug . '/" class="btn btn-large">Browse Gallery</a>
	</div>
	<script> start_gallery_preview_slide(' . $speed . '); </script>';
	
	return $output;
}
add_shortcode('gallery_preview', 'helix_gallery_preview');


// Show preview of multiple galleries (2-4 galleries on frontpage)
function helix_galleries_preview($params, $content = null) {
	extract(shortcode_atts(array(
		'gallery_one' => '',
		'gallery_two' => '',
		'gallery_three' => '',
		'gallery_four' => '',
		'title' => 'From our Gallery Showcase'
	), $params));
	
	global $post;
	
	$output = '<div class="from-gallery">
		<h4>' . $title . '</h4>
		<div class="row">';
		
		$spansize = 'span6';
		if ( ! $gallery_three == '' ) $spansize = 'span4';
		if ( ! $gallery_four == '' ) $spansize = 'span3';
		
		if ( $gallery_one ) {
			$term = get_term_by('slug', $gallery_one, 'gallery');
			$query = new WP_Query(array('numberposts' => 1, 'post_type' => 'photo-gallery', 'gallery' => $term->slug) );
			
			if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
				$thumb_id = get_post_thumbnail_id($post->ID);
				$thumb_src = wp_get_attachment_image_src($thumb_id, 'from-gallery');
				
				$output .= '<div class="' . $spansize . '">
					<div class="from-gallery-img"><a href="/gallery/' . $term->slug . '/"><img src="' . $thumb_src[0] . '" title="' . $term->name . '" class="from-gallery" /></a></div>
					<div class="from-gallery-title"><a href="/gallery/' . $term->slug . '/"><strong>' . $term->name . ' (' . $term->count . ')</strong></a></div>
				</div>';
			endwhile; endif;
		}
		
		if ( $gallery_two ) {
			$term = get_term_by('slug', $gallery_two, 'gallery');
			$query = new WP_Query(array('numberposts' => 1, 'post_type' => 'photo-gallery', 'gallery' => $term->slug) );
			
			if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
				$thumb_id = get_post_thumbnail_id($post->ID);
				$thumb_src = wp_get_attachment_image_src($thumb_id, 'from-gallery');
				
				$output .= '<div class="' . $spansize . '">
					<div class="from-gallery-img"><a href="/gallery/' . $term->slug . '/"><img src="' . $thumb_src[0] . '" title="' . $term->name . '" class="from-gallery" /></a></div>
					<div class="from-gallery-title"><a href="/gallery/' . $term->slug . '/"><strong>' . $term->name . ' (' . $term->count . ')</strong></a></div>
				</div>';
			endwhile; endif;
		}
		
		if ( $gallery_three ) {
			$term = get_term_by('slug', $gallery_three, 'gallery');
			$query = new WP_Query(array('numberposts' => 1, 'post_type' => 'photo-gallery', 'gallery' => $term->slug) );
			
			if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
				$thumb_id = get_post_thumbnail_id($post->ID);
				$thumb_src = wp_get_attachment_image_src($thumb_id, 'from-gallery');
				
				$output .= '<div class="' . $spansize . '">
					<div class="from-gallery-img"><a href="/gallery/' . $term->slug . '/"><img src="' . $thumb_src[0] . '" title="' . $term->name . '" class="from-gallery" /></a></div>
					<div class="from-gallery-title"><a href="/gallery/' . $term->slug . '/"><strong>' . $term->name . ' (' . $term->count . ')</strong></a></div>
				</div>';
			endwhile; endif;
		}
		
		if ( $gallery_four ) {
			$term = get_term_by('slug', $gallery_four, 'gallery');
			$query = new WP_Query(array('numberposts' => 1, 'post_type' => 'photo-gallery', 'gallery' => $term->slug) );
			
			if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post();
				$thumb_id = get_post_thumbnail_id($post->ID);
				$thumb_src = wp_get_attachment_image_src($thumb_id, 'from-gallery');
				
				$output .= '<div class="' . $spansize . '">
					<div class="from-gallery-img"><a href="/gallery/' . $term->slug . '/"><img src="' . $thumb_src[0] . '" title="' . $term->name . '" class="from-gallery" /></a></div>
					<div class="from-gallery-title"><a href="/gallery/' . $term->slug . '/"><strong>' . $term->name . ' (' . $term->count . ')</strong></a></div>
				</div>';
			endwhile; endif;
		}
		
		$output .= '</div></div>';
		
		return $output;
}
add_shortcode('galleries_preview', 'helix_galleries_preview');


// Featured post
function helix_featured_post($params, $content = null) {
	extract(shortcode_atts(array(
		'id' => '',
		'fullwidth' => ''
	), $params));
	
	$category = get_the_category($id);
	
	if ( $fullwidth || is_front_page() ) {
		$spansize = 'span6';
		$thumbsize = 'featured-thumbnail';
	} else {
		$spansize = 'span4';
		$thumbsize = 'sidebar-feature';
	}
	
	$output = '<div class="featured-post">
		<div class="row">
			<div class="' . $spansize . '">
				<div class="featured-thumbnail"><a href="' . get_permalink($id) . '" class="post-thumbnail-link" title="' . get_the_title($id) . '">' . get_the_post_thumbnail($id, $thumbsize) . '</a></div>
			</div>
			<div class="' . $spansize . '">
				<span class="byline">Posted ' . get_the_time('m/d/Y', $id) . ' in <a href="' . get_category_link($category[1]->term_id ) . '" class="category">' . $category[1]->cat_name . '</a></span>
				<h2><a href="' . get_permalink($id) . '">' . get_the_title($id) . '</a></h2>
				<div class="divider post"></div>';

				$post = get_post($id);
				$excerpt = ( $post->post_excerpt ) ? $post->post_excerpt : substr($post->post_content, 0, 200);
				$output .= $excerpt;
			
			$output .='<a href="' . get_permalink($id) . '"><strong>Read More</strong></a>
			</div>
		</div>
	<div class="clear"></div></div>';

	return $output;
}
add_shortcode('featured_post', 'helix_featured_post');


// Google map
function helix_google_map($params, $content = null) {
	extract(shortcode_atts(array(
		'width' => '425',
		'height' => '350',
		'address' => ''
	), $params));
	
	$add = str_replace(' ', '+', $address);
	
	return '<iframe width="' . $width . '" height="' . $height . '" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=' . $add . '&&amp;ie=UTF8&amp;hq=&amp;hnear=' . $add . '&amp;t=m&amp;z=14&amp;iwloc=A&amp;output=embed"></iframe>';
}
add_shortcode('google_map', 'helix_google_map');

?>