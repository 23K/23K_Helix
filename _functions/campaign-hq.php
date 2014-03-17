<?php

/*======================================================================================
	23K Helix
	Campaign HQ Functions
======================================================================================*/

// create pages with LP content based on author name
function helix_get_lp() {
	$opts =  get_option('darwin_dna');
	if ( $opts['source_author_name'] ) {
		// get this author's feed
		$lp_feed = 'http://email-dev2.23kdarwin.com/author/' . get_dna('source_author_name') . '/feed';
		
		include_once(ABSPATH . WPINC . '/feed.php');
		
		// fetch feed every 5 minutes
		add_filter('wp_feed_cache_transient_lifetime', 'return_300');
		$feed = fetch_feed($lp_feed);
		remove_filter('wp_feed_cache_transient_lifetime', 'return_300');
		
		// if no error, get feed items
		if ( ! is_wp_error($feed) ) {
			$rss_items = $feed->get_items();
			
			foreach ( $rss_items as $item ) :
				$link = $item->get_link();
				
				// set page content
				$page_content = '<iframe src="' . $link . '" width="960" height="750" scrolling="no" style="margin: -20px;"></iframe>';
				
				// if page doesn't already exist, add it
				if ( ! check_post_exists($item->get_title()) ) {
					$new_page = array(
						'post_type' => 'page',
						'post_author' => '1',
						'post_status' => 'publish',
						'post_content' => $page_content,
						'post_excerpt' => '',
						'post_title' => $item->get_title()
					);
					
					$page_id = wp_insert_post($new_page, $wp_error);
					
					// set it to use the lp template
					update_post_meta($page_id, '_wp_page_template', 'page-lp.php');
				}
			endforeach;
		}
	}
}
add_action('init', 'helix_get_lp');


// check if post already exists
if ( ! function_exists('check_post_exists') ) {
	function check_post_exists($title, $content = '', $date = '') {
		global $wpdb;
	
		$post_title = wp_unslash( sanitize_post_field( 'post_title', $title, 0, 'db' ) );
		$post_content = wp_unslash( sanitize_post_field( 'post_content', $content, 0, 'db' ) );
		$post_date = wp_unslash( sanitize_post_field( 'post_date', $date, 0, 'db' ) );
	
		$query = "SELECT ID FROM $wpdb->posts WHERE 1=1";
		$args = array();
	
		if ( ! empty ( $date ) ) {
			$query .= ' AND post_date = %s';
			$args[] = $post_date;
		}
	
		if ( ! empty ( $title ) ) {
			$query .= ' AND post_title = %s';
			$args[] = $post_title;
		}
	
		if ( ! empty ( $content ) ) {
			$query .= 'AND post_content = %s';
			$args[] = $post_content;
		}
	
		if ( ! empty ( $args ) )
			return (int) $wpdb->get_var( $wpdb->prepare($query, $args) );
	}
}


function return_300($seconds) {
	return 300;
}


?>