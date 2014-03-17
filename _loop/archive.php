<?php
/*======================================================================================
		23K DARWIN
		Loop: Archive
=======================================================================================*/

global $dna_config, $dna, $wpdb;

$leadout_link = get_page(get_dna('blog_leadout_link'));
if ( get_dna('blog_leadout_title') ) {
	$leadout_title = get_dna('blog_leadout_title');
} else {
	$leadout_title = $leadout_link->post_title;
}

// exclude posts where expiration date has passed and no alternate content was provided
$today = date('Y-m-d');
/*$exclude = $wpdb->get_col("SELECT ID FROM wp_posts LEFT JOIN wp_postmeta AS date ON date.post_id = ID 
AND date.meta_key = 'rna_post_expiration_date' AND date.meta_value <= '$today' 
LEFT JOIN wp_postmeta AS alt_content ON alt_content.post_id=ID AND alt_content.meta_key = 'rna_post_expiration_alt_content' 
WHERE wp_posts.post_type = 'post' AND date.meta_value IS NOT NULL AND alt_content.meta_value IS NULL AND post_status = 'publish'
ORDER BY ID");
#$main_query = new WP_Query(array('post__not_in' => $exclude, 'post_type' => 'post'));*/


/*======================================
		Archive Content
======================================*/

#if ($main_query->have_posts()) : while ($main_query->have_posts()) : $main_query->the_post();
if (have_posts()) : while (have_posts()) : the_post();
	if ( ! file_exists(HELIX_THEME . '/_loop/preview-horizontal.php') ) {
		include(HELIX_PATH . '/_loop/preview-horizontal.php');
	} else {
		include(HELIX_THEME . '/_loop/preview-horizontal.php');
	}
endwhile; else:endif;


if ( get_dna('show_blog_leadout') ) {
	if ( get_dna('blog_leadout_headline') ) {
		echo '<h3>' . get_dna('blog_leadout_headline') . '</h3>';
	}
	echo '<div class="leadout">
		<a href="/' . $leadout_link->post_name . '/">
			<div class="tab">
				<h4>' . get_dna('blog_leadout_cta') . '<br />
					<strong>' . $leadout_title . '</strong></h4>
			</div>
		</a>';
		if ( get_dna('blog_leadout_copy') ) {
			echo '<p>' . get_dna('blog_leadout_copy') . '</p>';
		}
	echo '</div>';
	dxclear('', '30');
}


global $wp_query;  
$total_pages = $wp_query->max_num_pages;  

if ($total_pages > 1) {  
	$current_page = max(1, get_query_var('paged'));  
		
	echo '<div id="pagination-wrapper">
		<div id="pagination"><p>';
			echo paginate_links(array(
				'base' => get_pagenum_link(1) . '%_%',
				'format' => 'page/%#%',
				'current' => $current_page,
				'total' => $total_pages,
				'prev_next' => true,
				'prev_text' => '&laquo;',
				'next_text' => '&raquo;'
			));	
		echo '</div></p>
	</div>';
}
	

/*=====================================================*/

?>