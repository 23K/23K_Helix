<?php
/*======================================================================================

	23K DARWIN Extension
	Metabox - Post Expiration

=======================================================================================*/

/*======================================================================================
		Metabox - Post Expiration
=======================================================================================*/

// Field Array
$prefix = 'rna_post_expiration_'; 
$dxwp_metabox_fields_post_expiration = array(
	array(
		'label' => 'Post expires',
		'desc' => '',
		'id' => $prefix . 'date',
		'type' => 'date'
	),
	array(
		'label' => 'Show alternate content?',
		'desc' => 'Check to provide alternate content to show after the expiration date has passed.',
		'id' => $prefix . 'show_alt',
		'type' => 'checkbox'
	),
	array(
		'label' => 'Alternate content',
		'desc' => '',
		'id' => $prefix . 'alt_content',
		'type' => 'visualeditor'
	),
);


/*=================================================================
		
		METABOX CONFIG
		All array options must be set.
		
===================================================================*/

$dxwp_metabox_data_post_expiration = array(
	'id'				=>	'post_expiration',										// Master unique metabox ID
	'title'			=>	'Post Expiration',										// Title as displayed in WP
	'callback'	=>	'dxwp_metabox_show_post_expiration',	// Required _show_ callback
	'posttypes'	=>	'post',																// Bind metabox to post types, ex: post, page
	'context'		=>	'normal',
	'priority'	=>	'high'
);


/*=================================================================
		Unique Metabox Handler Functions
===================================================================*/

// Create Metabox
function dxwp_metabox_create_post_expiration() {
	dxwp_metabox_handler('post_expiration');	
}

// Generate Form Fields
function dxwp_metabox_show_post_expiration() {
	dxwp_metabox_processor('post_expiration');
}

// Create jQuery Script
function dxwp_metabox_scripts_post_expiration() {
	dxwp_metabox_scripts('post_expiration');
}

// Save Content
function dxwp_metabox_save_post_expiration($post_id) {
	dxwp_metabox_save($post_id, 'post_expiration');
}

add_action('add_meta_boxes','dxwp_metabox_create_post_expiration');
add_action('admin_head','dxwp_metabox_scripts_post_expiration');
add_action('save_post','dxwp_metabox_save_post_expiration');


/*====================================================================================*/

?>