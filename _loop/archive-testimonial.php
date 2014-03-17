<?php
/*======================================================================================
		23K DARWIN
		Loop: Testimonials Archive
=======================================================================================*/

global $dna_config, $dna;
	
	
/*======================================
		Archive Content
======================================*/

// Repeat the Preview Loop
if (have_posts()) : while (have_posts()) : the_post();
	echo '<div class="testimonial-box">
	<p class="testimonial">' . get_the_content() . '</p>
	<p class="testimonial-author">&mdash; ' . get_the_title() . '</p>
</div>';
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