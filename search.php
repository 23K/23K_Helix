<?php
/*=======================================================
		23K HELIX
		Search Results Page
=======================================================*/

global $dna, $post, $wp_query;

$frontpage = get_dna('frontpage_content');


get_header();
	helixpublish_header($dna['masthead'], '', 'false');


/*======================================
		CONTENT LOOP
======================================*/

dxlayout_wrapper('main', $dna['bootstrap']);

	// Title Area
	echo '<div id="page-title">
		<div id="header"></div>
		
		<div class="content">';
			
			if ( ! get_dna('hide_breadcrumbs') ) {
				dxlayout_breadcrumbs();
			}
			
			echo '<h1>Search results for: ' . get_search_query() . '</h1>';
			
			if ( ! get_dna('hide_teaser') ) {
				echo '<p class="teaser">' . get_dna('default_teaser') . '</p>';
			}
		echo '</div>
	</div>';
	
	echo '<div id="search-results" class="content span8">
		<p><strong>Your search for ' . get_search_query() . ' returned ' . $wp_query->found_posts . ' posts in ' . timer_stop() . ' seconds.</strong></p>';
		dxclear('', '30');
		
		if (have_posts()) : while (have_posts()) : the_post(); if ($post->ID == $frontpage) continue;
			dxlink_the_title('', 'h3');
			the_excerpt();
			echo '<div class="post divider"></div>';
		endwhile; else: endif;
	
	dxclear();
	echo '</div>';
	
	// Sidebar
	dxpublish_aside($dna['sidebar'], $dna['sidebar-pos']);

dxlayout_wrapper_end('main');


/*======================================
		FOOTER
======================================*/

	helixpublish_footer($dna['footer'], '', 'false');
get_footer(); 

?>