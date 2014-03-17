<?php
/*======================================================================================

	23K DARWIN Extension
	Metabox - Page Details

	----------------

	CHANGE LOG

	11.21.12	NEW: Created extension

=======================================================================================*/

/*======================================================================================
		Metabox - Page Details
=======================================================================================*/

// Field Array
$prefix = 'rna_page_details_'; 
$dxwp_metabox_fields_page_details = array(
	array(
		'id' 		=> 'Add Billboard Image',
		'type'	=> 'subhead'
	),
	array(
		'label'	=> 'Billboard Image',
		'desc'	=> 'Upload an image to be used as this page\'s billboard.',
		'id'	=> $prefix . 'billboard',
		'type'	=> 'image'
	),
	array(
		'id' 		=> 'Add Page Header Information',
		'type'	=> 'subhead'
	),
	array(
		'label'	=> 'Page Title',
		'desc'	=> 'Enter a title you want displayed on this page if different than the page title.',
		'id'	=> $prefix . 'title',
		'type'	=> 'text'
	),
	array(
		'label'	=> 'Page Teaser',
		'desc'	=> 'Enter a description for this page, to be displayed under the page title.',
		'id'	=> $prefix . 'teaser',
		'type'	=> 'textarea'
	),
	array(
		'label'	=> 'Tab Link',
		'desc'	=> 'Choose an existing page to link to in the tab link area above the page teaser.',
		'id'	=> $prefix . 'tab_link',
		'type'	=> 'post_list',
		'post_type' => array('page', 'locations')
	),
	array(
		'label' => 'Tab Link Name',
		'desc' => 'Enter a name to display on the tab link if other than the page\'s name.',
		'id' => $prefix . 'tab_link_name',
		'type' => 'text'
	),
);


/*=================================================================
		
		METABOX CONFIG
		All array options must be set.
		
===================================================================*/

$dxwp_metabox_data_page_details = array(
	'id'				=>	'page_details',										// Master unique metabox ID
	'title'			=>	'Page Details',										// Title as displayed in WP
	'callback'	=>	'dxwp_metabox_show_page_details',	// Required _show_ callback
	'posttypes'	=>	'page',															// Bind metabox to post types, ex: post, page
	'context'		=>	'normal',
	'priority'	=>	'high'
);


/*=================================================================
		Unique Metabox Handler Functions
===================================================================*/

// Create Metabox
function dxwp_metabox_create_page_details() {
	dxwp_metabox_handler('page_details');	
}

// Generate Form Fields
function dxwp_metabox_show_page_details() {
	dxwp_metabox_processor('page_details');
}

// Create jQuery Script
function dxwp_metabox_scripts_page_details() {
	dxwp_metabox_scripts('page_details');
}

// Save Content
function dxwp_metabox_save_page_details($post_id) {
	dxwp_metabox_save($post_id,'page_details');
}

add_action('add_meta_boxes','dxwp_metabox_create_page_details');
add_action('admin_head','dxwp_metabox_scripts_page_details');
add_action('save_post','dxwp_metabox_save_page_details');


/*====================================================================================*/

?>
