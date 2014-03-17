<?php
/*======================================================================================
	
	23K DARWIN Extension
	Post Type - Locations
		
	----------------

	CHANGE LOG
	
	12.31.12	NEW:	Created this file
	01.09.13	UPD:	Added AJAX sorting
						UPD:	Removed priority metabox and quick edit

=======================================================================================*/

add_action('init', 'register_helix_ptype_locations', 1);

function register_helix_ptype_locations() {
 	$labels = array(
		'name'						=> _x('Locations', 'post type general name'),
		'menu_name'				=> _x('Locations',''),
		'singular_name'		=> _x('Location', 'post type singular name'),
		'add_new' 				=> _x('Add New', 'Location'),
		'add_new_item' 		=> __('Add New Location'),
		'edit_item' 			=> __('Edit Location'),
		'new_item' 				=> __('New Location'),
		'view_item' 			=> __('View Location'),
		'search_items' 		=> __('Search Locations'),
		'not_found' 			=> __('No matching Location was found.'),
		'parent' 					=> 'locations',
		'not_found_in_trash' => __('No Locations have been deleted.')
	);
	$args = array(
		'labels' 					=> $labels,
		'public' 					=> true,
		'hierarchical' 		=> true,
		'has_archive' 		=> true,
		'menu_position' 	=> 5,
		'query_var' 			=> true,
		'rewrite' 				=> array('slug' => 'locations'),
		'supports' 				=> array('title', 'editor', 'excerpt', 'thumbnail'),
		'description'			=> 'View %SITENAME% locations, addresses, and contact information',
		'menu_icon'				=> 'dashicons-location'
	);
	register_post_type( 'locations', $args );
}


add_action('admin_init', 'flush_rewrite_rules');


/*======================================================================================
		Metabox - Location Options
=======================================================================================*/

// Field Array
$prefix = 'rna_locations_';
$dxwp_metabox_fields_locations = array(
	array(
		'label' => 'Street Address',
		'desc' => '',
		'id' => $prefix . 'street',
		'type' => 'text'
	),
	array(
		'label'	=> 'City',
		'desc'	=> '',
		'id'	=> $prefix . 'city',
		'type'	=> 'text'
	),
	array(
		'label'	=> 'State',
		'desc'	=> '',
		'id'	=> $prefix . 'state',
		'type'	=> 'text'
	),
	array(
		'label' => 'Zip',
		'desc' => '',
		'id' => $prefix . 'zip',
		'type' => 'text'
	),
	array(
		'label'	=> 'Phone',
		'desc'	=> '',
		'id'	=> $prefix . 'phone',
		'type'	=> 'text'
	),
	array(
		'label' => 'Phone 2',
		'desc' => '',
		'id' => $prefix . 'phone2',
		'type' => 'text'
	),
	array(
		'label' => 'Email',
		'desc' => '',
		'id' => $prefix . 'email',
		'type' => 'text'
	),
);


/*=================================================================
		
		METABOX CONFIG
		All array options must be set.
		
===================================================================*/

$dxwp_metabox_data_locations = array(
	'id'				=>	'locations',											// Master unique metabox ID
	'title'			=>	'Location Details',								// Title as displayed in WP
	'callback'	=>	'dxwp_metabox_show_locations',		// Required _show_ callback
	'posttypes'	=>	'locations',											// Bind metabox to post types, ex: post, page
	'context'		=>	'normal',
	'priority'	=>	'high'
);


/*=================================================================
		Unique Metabox Handler Functions
===================================================================*/

// Create Metabox
function dxwp_metabox_create_locations() {
	dxwp_metabox_handler('locations');	
}

// Generate Form Fields
function dxwp_metabox_show_locations() {
	dxwp_metabox_processor('locations');
}

// Create jQuery Script
function dxwp_metabox_scripts_locations() {
	dxwp_metabox_scripts('locations');
}

// Save Content
function dxwp_metabox_save_locations($post_id) {
	dxwp_metabox_save($post_id,'locations');
}

add_action('add_meta_boxes','dxwp_metabox_create_locations');
add_action('admin_head','dxwp_metabox_scripts_locations');
add_action('save_post','dxwp_metabox_save_locations');


/*======================================================================================
		Adjust WPEditor Columns
======================================================================================*/

function helix_locations_columns($events_columns) {
	$new_columns = array(
		'cb' 						=> __(''),
		'title' 				=> __('Title'),
		'date' 					=> __('Posted'),
	);
	return $new_columns;
}
add_filter('manage_edit-locations_columns', 'helix_locations_columns');


/*======================================================================================
		Enable drag and drop locations sorting
=======================================================================================*/

/*=================================================================
		Add admin menu page
===================================================================*/

function helix_locations_sort() {
	add_submenu_page('edit.php?post_type=locations', 'Sort Locations', 'Change Location Order', 'edit_posts', basename(__FILE__), 'helix_sort_locations');
}
add_action('admin_menu', 'helix_locations_sort');


function helix_sort_locations() {
	
	echo '<div class="wrap">
		<h3 id="loc-title">Sort Locations <img src="' . get_bloginfo('url') . '/wp-admin/images/loading.gif" id="loading-animation" /></h3>';
		
		$locs = new WP_Query('post_type=locations&posts_per_page=-1&orderby=menu_order&order=ASC');
	
		echo '<ul id="locations-list">';
			while ( $locs->have_posts() ) : $locs->the_post();
				echo '<li id="' . get_the_id() . '">' . get_the_title() . '</li>';
			endwhile;
		echo '</ul>';
	
	echo '</div>';
}


/*=================================================================
		Add CSS & JS
===================================================================*/

function helix_locations_sort_styles() {
	global $pagenow;
	$pages = array('edit.php');
	
	if ( in_array($pagenow, $pages)) {
		echo '<style type="text/css">
			h3#bb-title { line-height: 30px; }
			ul#locations-list { margin-top: 20px; }
			ul#locations-list li { width: 50%; padding: 10px;	
				font-weight: bold;
				background: #f0f0f0;
				filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=\'#f7f7f7\', endColorstr=\'#e7e7e7\');
				background: -webkit-gradient(linear, left top, left bottom, from(#f7f7f7), to(#e7e7e7));
				background: -moz-linear-gradient(top,  #f7f7f7,  #e7e7e7);
				border: 1px solid #ddd; cursor: move;
				-moz-border-radius: 10px; -webkit-border-radius: 10px; border-radius: 10px; }
			img#loading-animation, p#submit-bb { display: none; }
		</style>';
	}
}
add_action('admin_print_styles', 'helix_locations_sort_styles');


function helix_locations_sort_scripts() {
	global $pagenow;
	$pages = array('edit.php');
	
	if ( in_array($pagenow, $pages)) {
		wp_enqueue_script('helix_locations', get_bloginfo('url') . '/wp-content/plugins/23K_Helix/_js/helix-sort.js');
	}
}
add_action('admin_print_scripts', 'helix_locations_sort_scripts');


/*=================================================================
		Save order of locations
===================================================================*/

function helix_locations_save_order() {
	global $wpdb;
	
	$order = explode(',', $_POST['order']);
	$counter = 0;
	
	foreach ($order as $locations_id) {
		$wpdb->update( $wpdb->posts, array('menu_order' => $counter), array('ID' => $locations_id) );
		$counter++;
	}
	die(1);
}
add_action('wp_ajax_locations_sort', 'helix_locations_save_order');


?>