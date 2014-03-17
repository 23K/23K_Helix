<?php
/*======================================================================================
		23K DARWIN
		Loop: Location Archive
=======================================================================================*/

global $dna_config, $dna;

$leadout_link = get_page(get_dna('blog_leadout_link'));
if ( get_dna('blog_leadout_title') ) {
	$leadout_title = get_dna('blog_leadout_title');
} else {
	$leadout_title = $leadout_link->post_title;
}
	
	
/*======================================
		Archive Content
======================================*/

// Repeat the Preview Loop
if (have_posts()) : while (have_posts()) : the_post();
	if ( ! file_exists(HELIX_THEME . '/_loop/preview-location.php') ) {
		include(HELIX_PATH . '/_loop/preview-location.php');
	} else {
		include(HELIX_THEME . '/_loop/preview-location.php');
	}
endwhile; else:endif;


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