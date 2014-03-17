<?php
/*======================================================================================
	
	23K HELIX
	WordPress TinyMCE Adjustments

=======================================================================================*/

function helix_tinymce_adjustments() {
   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
     return;
   }
	 
   if ( get_user_option('rich_editing') == 'true' ) {
     add_filter('mce_external_plugins', 'helix_tinymce_plugins');
		 add_filter('mce_buttons_2', 'helix_tinymce_buttons_row2', 2);
   }
}
add_action('init', 'helix_tinymce_adjustments');


// Add buttons in second row
function helix_tinymce_buttons_row2($buttons) {
	$buttons[] = 'helix';
	
	return $buttons;
}


// Load custom TinyMCE plugins
function helix_tinymce_plugins($plugin_array) {
	$mce_plugins = plugins_url() . '/23K_Helix/_functions/_tinymce/';
	
	$plugin_array['helix'] = $mce_plugins . 'helix.js';
	 
   return $plugin_array;
}


?>