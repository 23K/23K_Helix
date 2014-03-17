<?php

/*======================================================================================
	23K Helix
	Syndication Functions
======================================================================================*/

/*======================================================================================
	Get syndicated vendor pages from selected vendors
======================================================================================*/

function helix_syndicate_vendor_pages() {
	if ( $vendors = get_dna('vendors_subscribed') ) {
		foreach( $vendors as $vendor => $on ) :
			if ( $on == 1 ) {
				// get this author's feed
				$synd_feed = 'http://source.23kdarwin.com/author/' . $vendor . '/feed';
				
				include_once(ABSPATH . WPINC . '/feed.php');
				
				// fetch feed immediately
				add_filter('wp_feed_cache_transient_lifetime', 'return_1');
				$feed = fetch_feed($synd_feed);
				remove_filter('wp_feed_cache_transient_lifetime', 'return_1');
				
				// if no error, get feed items
				if ( ! is_wp_error($feed) ) {
					$rss_items = $feed->get_items();
					
					foreach ( $rss_items as $item ) :
						// get whole html content of link
						$page_content = file_get_contents( $item->get_link() );
						
						// get html for article#vendor-page
						$dom = new DOMDocument;
						libxml_use_internal_errors(true);
						$dom->loadHTML($page_content);
						$vendorpage = $dom->getElementById('vendor-page');
						
						$vendorpage_content = '';
						foreach($vendorpage->childNodes as $node) :
							$vendorpage_content .= $dom->saveXML($node, LIBXML_NOEMPTYTAG);
						endforeach;
						libxml_clear_errors();
						
						// get id if vendor page already exists
						$vendorpage_id = '';
						
						$vendor_query = new WP_Query('post_type=page&meta_key=rna_vendor&meta_value=' . $vendor);
						if ($vendor_query->have_posts()) : while ($vendor_query->have_posts()) : $vendor_query->the_post();
							$vendorpage_id = get_the_ID();
						endwhile; endif;
						
						// add vendor page if new or update it if it's changed
						if ( ! check_post_exists($item->get_title(), $vendorpage_content) ) {
							$new_vendorpage = array(
								'ID' => $vendorpage_id,
								'post_type' => 'page',
								'post_author' => '1',
								'post_status' => 'publish',
								'post_date' => $item->get_date('Y-m-d H:i:s'),
								'post_content' => $vendorpage_content,
								'post_title' => $item->get_title()
							);
							
							$vendorpage_id = wp_insert_post($new_vendorpage, $wp_error);
							
							// set it to use fullwidth template and record vendor name
							update_post_meta($vendorpage_id, '_wp_page_template', 'page-fullwidth.php');
							update_post_meta($vendorpage_id, 'rna_vendor', $vendor);
						}
						
						// set/update optimized title and description
						$helix_seo_title = $item->get_item_tags('http://helix.23kdarwin.com/helix.html/', 'seo_title');
						$helix_seo_title = $helix_seo_title[0]['data'];
						update_post_meta($vendorpage_id, 'rna_seo_title', $helix_seo_title);
						
						$helix_seo_description = $item->get_item_tags('http://helix.23kdarwin.com/helix.html/', 'seo_description');
						$helix_seo_description = $helix_seo_description[0]['data'];
						update_post_meta($vendorpage_id, 'rna_seo_description', $helix_seo_description);
						
						// set/update page billboard, title, teaser
						$helix_billboard = $item->get_item_tags('http://helix.23kdarwin.com/helix.html/', 'billboard');
						$helix_billboard = $helix_billboard[0]['data'];
						update_post_meta($vendorpage_id, 'rna_page_details_billboard', $helix_billboard);
						
						$helix_title = $item->get_item_tags('http://helix.23kdarwin.com/helix.html/', 'title');
						$helix_title = $helix_title[0]['data'];
						update_post_meta($vendorpage_id, 'rna_page_details_title', $helix_title);
						
						$helix_teaser = $item->get_item_tags('http://helix.23kdarwin.com/helix.html/', 'teaser');
						$helix_teaser = $helix_teaser[0]['data'];
						update_post_meta($vendorpage_id, 'rna_page_details_teaser', $helix_teaser);
						
						
						// get featured image url if available, upload and use as our featured image
						if ( $enclosure = $item->get_enclosure() ) {
							$featured = $enclosure->get_link();
							
							$featured_src = '';
							if ( has_post_thumbnail($page_id) ) {
								$featured_src = wp_get_attachment_image_src( get_post_thumbnail_id($page_id), 'full' );
								$featured_src = $featured_src[0];
							}
							
							// only upload featured image if not already there or if it has changed
							if ( substr(strrchr($featured, '/'), 1) != substr(strrchr($featured_src, '/'), 1) ) {
								$upload_dir = wp_upload_dir();
								$image_data = file_get_contents($featured);
								$filename = basename($featured);
								if(wp_mkdir_p($upload_dir['path']))
									$file = $upload_dir['path'] . '/' . $filename;
								else
									$file = $upload_dir['basedir'] . '/' . $filename;
								file_put_contents($file, $image_data);
								
								$wp_filetype = wp_check_filetype($filename, null );
								$attachment = array(
									'post_mime_type' => $wp_filetype['type'],
									'post_title' => sanitize_file_name($filename),
									'post_content' => '',
									'post_status' => 'inherit'
								);
								$attach_id = wp_insert_attachment( $attachment, $file, $page_id );
								require_once(ABSPATH . 'wp-admin/includes/image.php');
								$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
								wp_update_attachment_metadata( $attach_id, $attach_data );
								
								set_post_thumbnail( $page_id, $attach_id );
							}
						}
						
					endforeach;
				}
			}
		endforeach;
	}
	
	// delete vendor page if member is no longer subscribed
	$vendorpage_query = new WP_Query('post_type=page&meta_key=rna_vendor');
	if ( $vendorpage_query->have_posts() ) : while ( $vendorpage_query->have_posts() ) : $vendorpage_query->the_post();
		$this_id = get_the_ID();
		
		if ( $vendors = get_dna('vendors_subscribed') ) {
			foreach( $vendors as $vendor => $on ) :
				if ( $on == 0 ) {
					$rna_vendor = get_post_meta($this_id, 'rna_vendor', true);
					
					if ( $rna_vendor  == $vendor ) {
						wp_delete_post($this_id, true);
					}
				}
			endforeach;
		}
	endwhile; endif;
}
add_action('init', 'helix_syndicate_vendor_pages');


function return_1($seconds) {
	return 1;
}

function return_3600($seconds) {
	return 3600;
}


/*======================================================================================
	Get selected syndicated blog posts from the source
======================================================================================*/

function helix_syndicate_blog_posts() {
	if ( get_dna('source_author') ) {
		// check every half-hour
		if ( ! get_transient('helix-syndicate-selected-posts') ) {
			// get this author's feed
			$synd_feed = 'http://source.23kdarwin.com/feed/?taxonomy=reblog-user&term=' . get_dna('source_author');
			
			include_once(ABSPATH . WPINC . '/feed.php');
			
			// fetch feed every five minutes
			add_filter('wp_feed_cache_transient_lifetime', 'return_300');
			$feed = fetch_feed($synd_feed);
			remove_filter('wp_feed_cache_transient_lifetime', 'return_300');
			
			// if no error, get feed items
			if ( ! is_wp_error($feed) ) {
				$rss_items = $feed->get_items();
				
				foreach ( $rss_items as $item ) :
					// get id if post already exists
					$post_id = '';
					
					$synd_post_query = new WP_Query('post_type=post&meta_key=rna_syndicated_guid&meta_value=' . $item->get_id());
					if ($synd_post_query->have_posts()) : while ($synd_post_query->have_posts()) : $synd_post_query->the_post();
						$post_id = get_the_ID();
					endwhile; endif;
					
					// check if post exists with this title, content, and date
					// if not, create new post
					if ( ! check_post_exists($item->get_title(), $item->get_content(), $date) ) {
						$link = $item->get_link();
					
						// remove read more and html tags from description for excerpt
						$description = $item->get_description();
						$excerpt = str_replace('Read More&#160;&#187;', '', strip_tags($description));
						
						// add to categories set on source blog
						$categories = array();
						$cats = $item->get_categories();
						
						if ( is_array($cats) ) {
							foreach ( $cats as $cat ) :
								$add_cat = get_cat_ID($cat->get_label());
								$categories[] = $add_cat;
							endforeach;
						}
						
						$tags = $item->get_item_tags('http://helix.23kdarwin.com/helix.html/', 'tag');
						$tag_array = array();
						foreach ( $tags as $tag ) :
							$tag_array[] = $tag['data'];
						endforeach;
						
						$new_post = array(
							'ID' => $post_id,
							'post_author' => '1',
							'post_category' => $categories,
							'post_status' => 'publish',
							'post_content' => $item->get_content(),
							'post_date' => $item->get_date('Y-m-d H:i:s'),
							'post_excerpt' => $excerpt,
							'post_name' => basename($link),
							'post_title' => $item->get_title(),
							'tags_input' => $tag_array
						);
						
						$post_id = wp_insert_post($new_post, $wp_error);
						
						// set guid meta
						update_post_meta($post_id, 'rna_syndicated_guid', $item->get_id());
					}
					
					// set/update optimized title and description
					$seo_title = $item->get_item_tags('http://helix.23kdarwin.com/helix.html/', 'seo_title');
					$seo_title = $seo_title[0]['data'];
					update_post_meta($post_id, 'rna_seo_title', $seo_title);
					
					$seo_description = $item->get_item_tags('http://helix.23kdarwin.com/helix.html/', 'seo_description');
					$seo_description = $seo_description[0]['data'];
					update_post_meta($post_id, 'rna_seo_description', $seo_description);
					
					
					// get featured image url if available, upload and use as our featured image
					if ( $enclosure = $item->get_enclosure() ) {
						$featured = $enclosure->get_link();
						
						$featured_src = '';
						if ( has_post_thumbnail($post_id) ) {
							$featured_src = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'full' );
							$featured_src = $featured_src[0];
						}
						
						// only upload featured image if not already there or if it has changed
						if ( substr(strrchr($featured, '/'), 1) != substr(strrchr($featured_src, '/'), 1) ) {
							$upload_dir = wp_upload_dir();
							$image_data = file_get_contents($featured);
							$filename = basename($featured);
							if(wp_mkdir_p($upload_dir['path']))
								$file = $upload_dir['path'] . '/' . $filename;
							else
								$file = $upload_dir['basedir'] . '/' . $filename;
							file_put_contents($file, $image_data);
							
							$wp_filetype = wp_check_filetype($filename, null );
							$attachment = array(
								'post_mime_type' => $wp_filetype['type'],
								'post_title' => sanitize_file_name($filename),
								'post_content' => '',
								'post_status' => 'inherit'
							);
							$attach_id = wp_insert_attachment( $attachment, $file, $post_id );
							require_once(ABSPATH . 'wp-admin/includes/image.php');
							$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
							wp_update_attachment_metadata( $attach_id, $attach_data );
							
							set_post_thumbnail( $post_id, $attach_id );
						}
					}
				endforeach;
			}
			set_transient('helix-syndicate-selected-posts', 'true', 30 * MINUTE_IN_SECONDS);
		}
	}
}
add_action('init', 'helix_syndicate_blog_posts');


?>