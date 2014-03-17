<?php
/*======================================================================================
		23K DARWIN
		Single Post: Default
=======================================================================================*/

global $dna;

$tablink_info = get_page(get_dna('show_page_post'));
$tablink_parent = $tablink_info->post_parent;
if ( ! $tablink_parent == '0' ) {
	$tablink_parent_info = get_page($tablink_parent);
	$tablink_parent_link = $tablink_parent_info->post_name;
}

$posttype = get_post_type();


get_header(); 
	helixpublish_header($dna['masthead'], '', 'false');
	
/*======================================
		Single Post Content Loop
======================================*/

dxlayout_wrapper('main', $dna['bootstrap']);
	
	// Title Area
	echo '<div id="page-title">
		<div id="header"></div>
		<div class="content">';
		
			if ( get_dna('show_sharebar_post') ) {
				echo '<div class="title-tab">';
					if ( ! file_exists(HELIX_THEME . '/_includes/socialbar.php') ) {
					include(HELIX_PATH . '/_includes/socialbar.php');
				} else {
					include(HELIX_THEME . '/_includes/socialbar.php');
				}
				echo '</div>';
			} else if ( get_dna('show_page_post') ) {
				echo '<div class="title-tab">
				<a href="/';
					if ( ! $tablink_parent == '0' ) {
						echo $tablink_parent_link . '/';
					}
					echo $tablink_info->post_name . '/">';
						if ( get_dna('show_page_post_name') ) {
							echo get_dna('show_page_post_name');
						} else {
							echo $tablink_info->post_title;
						}
				echo '</a>
			</div>';
			}
		
			if ( ! get_dna('hide_breadcrumbs') ) {
				dxlayout_breadcrumbs();
			}
			
			if ( $posttype == 'locations' ) {
				echo '<h1>' . get_the_title() . '</h1>';
				
				$excerpt = get_the_excerpt();
				$excerpt = str_replace('&raquo;', '', str_replace('Read More', '', get_the_excerpt()));
				if ( substr($excerpt, 0, 100) != $excerpt ) {
					$excerpt = substr($excerpt, 0, 100) . '...';
				}
				
				echo '<p class="teaser">' . $excerpt . '</p>';
			} else if ( get_dna('page_title') == 'title' ) {
				echo '<h1>' . get_the_title() . '</h1>';
			} else {
				echo '<h1>';
					$category = get_the_category();
					echo $category[0]->cat_name . 
				'</h1>
				<p class="teaser">' . $category[0]->description . '</p>';
			}
			
		echo '</div>
	</div>';

	// Content
	helixpublish_article($dna['layout'], $dna['layout-pos']);

	// Sidebar
	dxpublish_aside($dna['sidebar'], $dna['sidebar-pos']);

dxlayout_wrapper_end('main');


/*======================================
		Footer
======================================*/

	helixpublish_footer($dna['footer'], '', 'false');
get_footer();


?>