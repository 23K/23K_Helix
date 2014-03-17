<?php
/*======================================================================================
	
	23K DARWIN Extension
	Post Type - Gallery Photo
		
	----------------

	CHANGE LOG
	
	07.19.12	NEW:	Created this file

=======================================================================================*/


add_action('init', 'register_darwin_ptype_photo_gallery', 1);

function register_darwin_ptype_photo_gallery() {
 	$labels = array(
		'name'						=> _x('Photo Gallery', 'post type general name'),
		'menu_name'				=> _x('Gallery Photos',''),
		'singular_name'		=> _x('Photo', 'post type singular name'),
		'add_new' 				=> _x('Add New', 'Photo'),
		'add_new_item' 		=> __('Add New Photo'),
		'edit_item' 			=> __('Edit Photo'),
		'new_item' 				=> __('New Photo'),
		'view_item' 			=> __('View Photos'),
		'search_items' 		=> __('Search Photos'),
		'not_found' 			=> __('No matching Photo was found.'),
		'parent' 					=> 'photo-gallery',
		'not_found_in_trash' => __('No Photos have been deleted.')
	);
	$args = array(
		'labels' 					=> $labels,
		'public' 					=> true,
		'hierarchical' 		=> true,
		'has_archive' 		=> true,
		'menu_position' 	=> 5,
		'query_var' 			=> true,
		'rewrite' 				=> array('slug' => 'photo-gallery'),
		'supports' 				=> array('title', 'editor', 'thumbnail', 'excerpt'),
		'menu_icon'			=> 'dashicons-images-alt'
	);
	register_post_type( 'photo-gallery', $args );
}


add_action('admin_init', 'flush_rewrite_rules');


add_action('init', 'register_darwin_taxonomy_gallery', 1);

function register_darwin_taxonomy_gallery() {
	$labels = array(
		'name' => _x( 'Galleries', 'taxonomy general name' ),
    'singular_name' => _x( 'Gallery', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Galleries' ),
    'popular_items' => __( 'Popular Galleries' ),
    'all_items' => __( 'All Galleries' ),
    'parent_item' => __( 'Parent Gallery' ),
    'parent_item_colon' => __( 'Parent Gallery:' ),
    'edit_item' => __( 'Edit Gallery' ),
    'update_item' => __( 'Update Gallery' ),
    'add_new_item' => __( 'Add New Gallery' ),
    'new_item_name' => __( 'New Gallery Name' ),
  );
  register_taxonomy('gallery',array('photo-gallery'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'gallery' ),
  ));
}


function photo_gallery_columns($photo_gallery_columns) {
	$new_columns = array(
		'cb' 							=> __(''),
		'title' 					=> __('Title'),
		'featured_image'	=> __('Photo'),
		'gallery_cat'			=> __('Gallery'),
		'date' 						=> __('Date'),
	);
	return $new_columns;
}
add_filter('manage_edit-photo-gallery_columns', 'photo_gallery_columns');

// Add the Custom Column data
function manage_photo_gallery_posts_custom_column($column_name,$post_id) {
	switch($column_name) {
		case 'featured_image' :
			if( function_exists('the_post_thumbnail') ) {
				echo the_post_thumbnail( 'admin-list-thumb' );
			}
		break;
		case 'gallery_cat' : echo get_the_term_list( $post->ID, 'gallery', '', ', ', '' );
		break;
	}
}
add_filter('manage_photo-gallery_posts_custom_column', 'manage_photo_gallery_posts_custom_column', 10, 2);


?>