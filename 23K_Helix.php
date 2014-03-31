<?php

/*
Plugin Name: 23K Helix
Version: 1.3.033
Description: A robust website platform for use with the 23K Darwin adaptive framework.
Author: 23K Studios
Author URI: http://23K.com
GitHub Plugin URI: https://github.com/23K/23K_Helix
GitHub Branch: master
GitHub Access Token: daab5f89440c111bd641722bcf96654246c4c5e7
GitHub Timeout: 0.1
*/


/*====================================================================================*/

define('HELIX_PATH',	WP_PLUGIN_DIR . '/' . basename(dirname(__FILE__)));
define('HELIX_URI', plugin_dir_url(__FILE__));
define('HELIX_THEME', get_stylesheet_directory());
define('DARWIN_URI', get_bloginfo('template_url'));
define('DARWIN_PATH', get_theme_root() . '/23K_Darwin');

global $darwin, $dna_config;


// CPT
require_once(HELIX_PATH . '/_darwin/cpt-gallery-photo.php');
require_once(HELIX_PATH . '/_darwin/cpt-locations.php');


// Metaboxes
require_once(HELIX_PATH . '/_darwin/metabox-page-details.php');
require_once(HELIX_PATH . '/_darwin/metabox-post-expiration.php');


// Widgets
require_once(HELIX_PATH . '/_darwin/widget-location.php');
require_once(HELIX_PATH . '/_darwin/widget-header-location.php');
require_once(HELIX_PATH . '/_darwin/widget-recent-posts.php');
require_once(HELIX_PATH . '/_darwin/widget-gallery.php');
require_once(HELIX_PATH . '/_darwin/widget-member.php');


// Functions
require_once(HELIX_PATH . '/_functions/shortcodes.php');
require_once(HELIX_PATH . '/_functions/publish.php');
require_once(HELIX_PATH . '/_functions/tinymce.php');
require_once(HELIX_PATH . '/_functions/expiration.php');

$opts =  get_option('darwin_dna');
if ( $opts['syndication_on'] ) {
	require_once(HELIX_PATH . '/_functions/campaign-hq.php');
	require_once(HELIX_PATH . '/_functions/syndication.php');
}


// Options
require_once(HELIX_PATH . '/_darwin/helix-options.php');


/*======================================================================================
		LOAD PAGE TEMPLATES
		Force content to load in the plugin page templates
======================================================================================*/

function dxp_helix_setup_pagetemplates() {
	global $dna_config, $wp;
	
	// sitemap
	if ( is_page('sitemap') ) {
		if ( ! file_exists(HELIX_THEME . '/page-sitemap.php') ) {
			include (HELIX_PATH . '/page-sitemap.php');
			die();
		}
	}
	
	// page with default or sidebar template
	else if ( is_page() && ( ! is_page_template() || is_page_template('page-sidebar.php')) ) {
		if ( ! file_exists(HELIX_THEME . '/page-sidebar.php') ) {
			include (HELIX_PATH . '/page-sidebar.php');
			die();
		}
	}
	
	// page fullwidth template
	else if ( is_page() && is_page_template('page-fullwidth.php') ) {
		if ( ! file_exists(HELIX_THEME . '/page-fullwidth.php') ) {
			include (HELIX_PATH . '/page-fullwidth.php');
			die();
		}
	}
	
	// lp page template
	else if ( is_page() && is_page_template('page-lp.php') ) {
		if ( ! file_exists(HELIX_THEME . '/page-lp.php') ) {
			include (HELIX_PATH . '/page-lp.php');
			die();
		}
	}
	
	// frontpage
	else if (is_home() ) {
		if ( ! file_exists(HELIX_THEME . '/index.php') ) {
			include (HELIX_PATH . '/index.php');
			die();
		}
	}
	
	// search
	else if ( is_search() ) {
		if ( ! file_exists(HELIX_THEME . '/search.php') ) {
			include (HELIX_PATH . '/search.php');
			die();
		}
	}
	
	// gallery photos
	else if ( $wp->query_vars['post_type'] == 'photo-gallery' ) {
		if ( ! file_exists(HELIX_THEME . '/single-photo-gallery.php') ) {
			include (HELIX_PATH . '/single-photo-gallery.php');
			die();
		}
	}
	
	// post
	else if ( is_single() ) {
		if ( ! file_exists(HELIX_THEME . '/single.php') ) {
			include (HELIX_PATH . '/single.php');
			die();
		}
	}
	
	// archive
	else if ( is_archive() ) {
		if ( ! file_exists(HELIX_THEME . '/archive.php') ) {
			include (HELIX_PATH . '/archive.php');
			die();
		}
	}
	
	// 404
	else if ( is_404() ) {
		if ( ! file_exists(HELIX_THEME . '/404.php') ) {
			include (HELIX_PATH . '/404.php');
			die();
		}
	}
	
}
add_action('template_redirect', 'dxp_helix_setup_pagetemplates');


/*======================================================================================
		LOAD CSS AND JS
======================================================================================*/	

function dxp_helix_setup_less() {
	echo '<link rel="stylesheet/less" href="' . HELIX_URI . 'style.less">
	';
}
add_action('dxhook_header_init', 'dxp_helix_setup_less');


function dxp_helix_setup_js() {
	echo '<script src="' . HELIX_URI . '_js/script.js"></script>
	<script> $(document).ready(function() { darwin_navigation_rollover(\'masthead-menu\'); }); </script>
	';
}
add_action('dxhook_header_end', 'dxp_helix_setup_js');


function dxp_helix_setup_admin_js() {
	echo '<script>
		jQuery(document).ready(function($) {
			var showalt = $("#rna_post_expiration_show_alt");
			
			if ( ! showalt.is(":checked") ) {
				$("#rna_post_expiration_alt_content").closest("div.darwin-metabox").hide();
			}
			showalt.change(function() {
				if ( $(this).is(":checked") ) {
					$("#rna_post_expiration_alt_content").closest("div.darwin-metabox").show();
				} else {
					$("#rna_post_expiration_alt_content").closest("div.darwin-metabox").hide();
				}
			});
		});
	</script>';
}
add_action('admin_head', 'dxp_helix_setup_admin_js');


// Add styles for logo based on admin panel settings
function helix_masthead_logo() {
	if ( get_dna('masthead_logo') ) {
		echo '<style> a#masthead-logo { background: url("' . get_dna('masthead_logo') . '") no-repeat 0 0; } </style>';
	}
}
add_action('wp_head', 'helix_masthead_logo');


// Adjust WP Visual Editor to match Theme
// Load style-editor.css from plugin only if it doesn't exist in the child theme
function helix_mce_css($mce_css) {
	if ( ! empty($mce_css) ) {
		$mce_css .= ',';
	}
	
	$mce_css .= plugins_url('style-editor.css', __FILE__);
	
	return $mce_css;
}

function helix_wp_visualeditor_style() {
	if ( file_exists(HELIX_THEME . '/style-editor.css') ) {
		add_editor_style( array('style-editor.css') );
	} else {
		add_filter('mce_css', 'helix_mce_css');
	}
}
add_action('after_setup_theme', 'helix_wp_visualeditor_style');


/*======================================================================================
	CONFIGURE VIEWPORT
	These values control how different useragent device types render the page.
======================================================================================*/
		
$dna_config['viewport'] = array(
	'default'							=>	'width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0',
	'tablet_portrait'			=>	'width=device-width, initial-scale=1',
	'tablet_landscape'		=>	'width=device-width, initial-scale=1',
	'tablet_preferred'		=>	'',
	'tablet_alert'				=>	'http://helix.23kdarwin.com/_img/orientation.jpg',
	'tablet_redirect'			=>	'',
	'mobile_portrait'			=>	'width=device-width, initial-scale=0.32',
	'mobile_landscape'		=>	'width=device-width, initial-scale=0.56',
	'mobile_preferred'		=>	'',
	'mobile_alert'				=>	'http://helix.23kdarwin.com/_img/mobile-viewport.jpg',
	'mobile_redirect'			=>	''
);


/*======================================================================================
	REGISTER WP IMAGE SIZES
	Set up your immediately callable, optimized post image sizes	
======================================================================================*/

// Thumbnail
if (function_exists('add_theme_support')) {
	add_theme_support('post-thumbnails');
	set_post_thumbnail_size( 280, 180, true );
}

// Additional image sizes
if ( function_exists('add_image_size') ) {
	add_image_size( 'blog-thumbnail', 274, 180, true );
	add_image_size( 'preview-thumbnail', 245, 80, true );
	add_image_size( 'admin-list-thumb', 100, 100, true );
	add_image_size( 'page-billboard', 960, 260, true );
	add_image_size( 'gallery-thumbnail', 195, 130, true );
	add_image_size( 'gallery-full', 885, 450, false );
	add_image_size( 'preview-post', 40, 60, true );
	add_image_size( 'blog-full', 620, 250, true );
	add_image_size( 'featured-thumbnail', 385, 245, true );
	add_image_size( 'from-gallery', 205, 150, true );
	add_image_size( 'from-gallery-page', 175, 175, true );
	add_image_size( 'sidebar-feature', 230, 150, true );
}


/*======================================================================================
	Default Helix Menus
======================================================================================*/

function dxwp_menu_register() {
  register_nav_menus(
    array( 
			'darwin_menu_masthead_navigation'		=> __( 'Primary Navigation' ),
			'darwin_menu_footer_navigation'			=> __( 'Footer Navigation' )
		)
  );
}

add_action( 'init', 'dxwp_menu_register' );


/*======================================================================================
	Default Helix Sidebars
======================================================================================*/

register_sidebar( array(
    'id'          	=> 'sidebar_blog',
    'name'        	=> 'Blog Sidebar',
    'description' 	=> 'This sidebar appears on Blog archives.',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widgettitle">',
		'after_title'   => '</h3>'
) );

register_sidebar( array(
    'id'          	=> 'sidebar_blog_post',
    'name'        	=> 'Blog Post Sidebar',
    'description' 	=> 'This sidebar appears on Blog posts.',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widgettitle">',
		'after_title'   => '</h3>'
) );

register_sidebar( array(
    'id'          	=> 'sidebar_masthead',
    'name'        	=> 'Masthead Widget',
    'description' 	=> 'Widgetized area in the header for messages or promotions',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widgettitle">',
		'after_title'   => '</h3>'
) );


/*======================================================================================
		Set posts per page & post order
=======================================================================================*/

function helix_set_query_vars($query) {
	if ( is_front_page() ) {
		if ( $query->query_vars['post_type'] == 'photo-gallery' || $query->is_tax('gallery') ) {
			$query->query_vars['posts_per_page'] = 1;
		}
	} else if ( is_page() ) {
		if ( $query->is_tax('gallery') ) {
			if ( $query->query_vars['numberposts'] == '3' ) {
				$query->query_vars['posts_per_page'] = 3;
			} else {
				$query->query_vars['posts_per_page'] = -1;
			}
		}
	} else {
		if ( $query->is_tax('gallery') ) {
			$query->query_vars['posts_per_page'] = 16;
		}
		
		if ( $query->query_vars['post_type'] == 'locations' ) {
			$query->query_vars['orderby'] = 'menu_order';
			$query->query_vars['order'] = 'ASC';
		}
	}
	
  return $query;
}
if ( ! is_admin() ) { add_filter('pre_get_posts', 'helix_set_query_vars', 10, 1); }


/*======================================================================================
	Customize gravity form post creation
======================================================================================*/

// Set gallery taxonomy terms in drop down fields
function helix_gravityform_gallery_taxonomy($form) {
	$galleries = get_terms('gallery');
	
	$items = array();
	$items[] = array( 'text' => '', 'value' => '' );
	
	foreach ( $galleries as $gallery ) :
		if ( $gallery->slug != 'showcase' ) {
			$items[] = array( 'text' => $gallery->name, 'value' => $gallery->slug );
		}
	endforeach;
	
	foreach ( $form['fields'] as &$field ) :
		if ( $field['id'] == '4' || $field['id'] == '8' || $field['id'] == '14' 
			|| $field['id'] == '19' || $field['id'] == '24' || $field['id'] == '29'
			|| $field['id'] == '34' || $field['id'] == '39' || $field['id'] == '44'
			|| $field['id'] == '49' ) {
				
			$field['choices'] = $items;
		}
	endforeach;
	
	return $form;
}
add_filter('gform_pre_render_3', 'helix_gravityform_gallery_taxonomy');


// create gallery photo posts
function helix_gravityform_publish_photos($form_meta) {
	require_once(ABSPATH . 'wp-admin/includes/file.php');
	require_once(ABSPATH . 'wp-admin/includes/image.php');
	require_once(ABSPATH . 'wp-admin/includes/media.php');
	
	// photo 1
	$args1 = array(
		'post_author' => 1,
		'post_title' => $_POST['input_2'],
		'post_content' => $_POST['input_3'],
		'post_type' => 'photo-gallery',
		'post_status' => 'publish'
	);
	$pid1 = wp_insert_post($args1);
	
	if ( $_FILES['input_1'] && $pid1 > 0 ) {
		$media_id1 = media_handle_upload('input_1', $pid1);
		set_post_thumbnail($pid1, $media_id1);
	}
	
	wp_set_object_terms($pid1, array('showcase', $_POST['input_4']), 'gallery');
	
	// photo 2
	$args2 = array(
		'post_author' => 1,
		'post_title' => $_POST['input_6'],
		'post_content' => $_POST['input_7'],
		'post_type' => 'photo-gallery',
		'post_status' => 'publish'
	);
	$pid2 = wp_insert_post($args2);
	
	if ( $_FILES['input_5'] && $pid2 > 0 ) {
		$media_id2 = media_handle_upload('input_5', $pid2);
		set_post_thumbnail($pid2, $media_id2);
	}
	
	wp_set_object_terms($pid2, array('showcase', $_POST['input_8']), 'gallery');
	
	// photo 3
	$args3 = array(
		'post_author' => 1,
		'post_title' => $_POST['input_10'],
		'post_content' => $_POST['input_13'],
		'post_type' => 'photo-gallery',
		'post_status' => 'publish'
	);
	$pid3 = wp_insert_post($args3);
	
	if ( $_FILES['input_9'] && $pid3 > 0 ) {
		$media_id3 = media_handle_upload('input_9', $pid3);
		set_post_thumbnail($pid3, $media_id3);
	}
	
	wp_set_object_terms($pid3, array('showcase', $_POST['input_14']), 'gallery');
	
	// photo 4
	$args4 = array(
		'post_author' => 1,
		'post_title' => $_POST['input_17'],
		'post_content' => $_POST['input_18'],
		'post_type' => 'photo-gallery',
		'post_status' => 'publish'
	);
	$pid4 = wp_insert_post($args4);
	
	if ( $_FILES['input_16'] && $pid4 > 0 ) {
		$media_id4 = media_handle_upload('input_16', $pid4);
		set_post_thumbnail($pid4, $media_id4);
	}
	
	wp_set_object_terms($pid4, array('showcase', $_POST['input_19']), 'gallery');
	
	// photo 5
	$args5 = array(
		'post_author' => 1,
		'post_title' => $_POST['input_22'],
		'post_content' => $_POST['input_23'],
		'post_type' => 'photo-gallery',
		'post_status' => 'publish'
	);
	$pid5 = wp_insert_post($args5);
	
	if ( $_FILES['input_21'] && $pid5 > 0 ) {
		$media_id5 = media_handle_upload('input_21', $pid5);
		set_post_thumbnail($pid5, $media_id5);
	}
	
	wp_set_object_terms($pid5, array('showcase', $_POST['input_24']), 'gallery');
	
	// photo 6
	$args6 = array(
		'post_author' => 1,
		'post_title' => $_POST['input_27'],
		'post_content' => $_POST['input_28'],
		'post_type' => 'photo-gallery',
		'post_status' => 'publish'
	);
	$pid6 = wp_insert_post($args6);
	
	if ( $_FILES['input_26'] && $pid6 > 0 ) {
		$media_id6 = media_handle_upload('input_26', $pid6);
		set_post_thumbnail($pid6, $media_id6);
	}
	
	wp_set_object_terms($pid6, array('showcase', $_POST['input_29']), 'gallery');
	
	// photo 7
	$args7 = array(
		'post_author' => 1,
		'post_title' => $_POST['input_32'],
		'post_content' => $_POST['input_33'],
		'post_type' => 'photo-gallery',
		'post_status' => 'publish'
	);
	$pid7 = wp_insert_post($args7);
	
	if ( $_FILES['input_31'] && $pid7 > 0 ) {
		$media_id7 = media_handle_upload('input_31', $pid7);
		set_post_thumbnail($pid7, $media_id7);
	}
	
	wp_set_object_terms($pid7, array('showcase', $_POST['input_34']), 'gallery');
	
	// photo 8
	$args8 = array(
		'post_author' => 1,
		'post_title' => $_POST['input_37'],
		'post_content' => $_POST['input_38'],
		'post_type' => 'photo-gallery',
		'post_status' => 'publish'
	);
	$pid8 = wp_insert_post($args8);
	
	if ( $_FILES['input_36'] && $pid8 > 0 ) {
		$media_id8 = media_handle_upload('input_36', $pid8);
		set_post_thumbnail($pid8, $media_id8);
	}
	
	wp_set_object_terms($pid8, array('showcase', $_POST['input_39']), 'gallery');
	
	// photo 9
	$args9 = array(
		'post_author' => 1,
		'post_title' => $_POST['input_42'],
		'post_content' => $_POST['input_43'],
		'post_type' => 'photo-gallery',
		'post_status' => 'publish'
	);
	$pid9 = wp_insert_post($args9);
	
	if ( $_FILES['input_41'] && $pid9 > 0 ) {
		$media_id9 = media_handle_upload('input_41', $pid9);
		set_post_thumbnail($pid9, $media_id9);
	}
	
	wp_set_object_terms($pid9, array('showcase', $_POST['input_44']), 'gallery');
	
	// photo 10
	$args10 = array(
		'post_author' => 1,
		'post_title' => $_POST['input_47'],
		'post_content' => $_POST['input_48'],
		'post_type' => 'photo-gallery',
		'post_status' => 'publish'
	);
	$pid10 = wp_insert_post($args10);
	
	if ( $_FILES['input_46'] && $pid10 > 0 ) {
		$media_id10 = media_handle_upload('input_46', $pid10);
		set_post_thumbnail($pid10, $media_id10);
	}
	
	wp_set_object_terms($pid10, array('showcase', $_POST['input_49']), 'gallery');
}
add_filter('gform_pre_submission_3', 'helix_gravityform_publish_photos');


/*======================================================================================
		Replace excerpt ellipsis
=======================================================================================*/

function helix_excerpt_remove_more($more) {
	return '';
}
add_filter('excerpt_more', 'helix_excerpt_remove_more');


function helix_excerpt_add_link($post_excerpt) {
	global $post;
	
	if ( $post->post_type != 'locations' ) {
		return $post_excerpt . ' <a href="' . get_permalink(get_the_ID())  . '"><strong>Read More&nbsp;&raquo;</strong></a>';
	} else {
		return $post_excerpt;
	}
}
add_filter('wp_trim_excerpt', 'helix_excerpt_add_link');


/*======================================================================================
		Remove p tags from category descriptions
=======================================================================================*/

remove_filter('term_description', 'wpautop');


/*======================================================================================
		Remove tags admin column for posts
=======================================================================================*/

function helix_remove_tag_posts_column($column_headers) {
	unset($column_headers['tags']);
	
	return $column_headers;
}
add_action('manage_posts_columns','helix_remove_tag_posts_column');


/*======================================================================================
	DARWIN DEBUG WIDGETS
	Attach functional widgets to the admin HUD
======================================================================================*/

add_action('dxhook_debug','darwin_debug_console', 2);					// Default Console
add_action('dxhook_debug','darwin_debug_dna', 3);							// Default DNA Inspector
add_action('dxhook_debug','darwin_debug_dna_config', 4);			// Default DNA_CONFIG Inspector


/*======================================================================================
	Rewrite Options Framework Function
		Now looks for options.php in child theme, then in plugin, then in Darwin
=======================================================================================*/

function unhook_optionsframework_init() {
	remove_action('admin_init', 'optionsframework_init');
}
add_action('admin_init', 'unhook_optionsframework_init', 1);


function helix_optionsframework_init() {
	// Include the required files
	require_once(DARWIN_PATH . '/_darwin/wordpress/settings/options-sanitize.php');
	require_once(DARWIN_PATH . '/_darwin/wordpress/settings/options-interface.php');
	require_once(DARWIN_PATH . '/_darwin/wordpress/settings/options-medialibrary-uploader.php');
	
	// Loads the options array from the theme
	if ( file_exists(HELIX_THEME . '/options.php') ) {
		require_once(HELIX_THEME . '/options.php');
	}
	else if (file_exists(HELIX_PATH . '/options.php')) {
		require_once(HELIX_PATH . '/options.php');
	}
	else if ( $optionsfile = locate_template( array('options.php') ) ) {
		require_once($optionsfile);
	}
	else if (file_exists(DARWIN_PATH . '/options.php') ) {
		require_once(DARWIN_PATH . '/options.php');
	}
	
	$optionsframework_settings = get_option('optionsframework');
	
	// Updates the unique option id in the database if it has changed
	optionsframework_option_name();
	
	// Gets the unique id, returning a default if it isn't defined
	if ( isset($optionsframework_settings['id']) ) {
		$option_name = $optionsframework_settings['id'];
	}
	else {
		$option_name = 'optionsframework';
	}
	
	// If the option has no saved data, load the defaults
	if ( ! get_option($option_name) ) {
		optionsframework_setdefaults();
	}
	
	// Registers the settings fields and callback
	register_setting('optionsframework', $option_name, 'optionsframework_validate');
	
}
add_action('admin_init', 'helix_optionsframework_init', 2);


/*====================================================================================*/

?>
