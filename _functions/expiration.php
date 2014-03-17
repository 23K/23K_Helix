<?php

/*======================================================================================
	23K Helix
	Expiration Functions
======================================================================================*/

function helix_expiration_posts_request($sql, $query) {
	global $wpdb;
	
	if ( $query->is_category() && $query->is_main_query() ) {
		$today = date('Y-m-d');
		
		$sql = 'SELECT * FROM ' . $wpdb->posts . ' LEFT JOIN ' . $wpdb->postmeta . ' AS date ON date.post_id = ID 
		AND date.meta_key = "rna_post_expiration_date" AND date.meta_value <= "' . $today . '" 
		LEFT JOIN ' . $wpdb->postmeta . ' AS alt_content ON alt_content.post_id=ID AND alt_content.meta_key = "rna_post_expiration_alt_content" 
		WHERE (date.meta_value IS NOT NULL AND alt_content.meta_value IS NOT NULL) 
		OR date.meta_value IS NULL
		AND post_type = "post" AND post_status = "publish"
		ORDER BY ID DESC';
	}
		
	return $sql;
}
add_filter('posts_request', 'helix_expiration_posts_request', 10, 2);


?>