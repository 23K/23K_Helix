<?php
/*=======================================================
		23K DARWIN
		Post Archive Template
=======================================================*/

global $dna;

$tablink_info = get_page(get_dna('show_page_archive'));
$tablink_parent = $tablink_info->post_parent;
if ( ! $tablink_parent == '0' ) {
	$tablink_parent_info = get_page($tablink_parent);
	$tablink_parent_link = $tablink_parent_info->post_name;
}


get_header();


/*======================================
		Setup
======================================*/
	
	// Masthead
	helixpublish_header($dna['masthead'], '', 'false');
	
	// Check the trapdoor
	dxlayout_trapdoor_exit('900', '630', 'openEffect	:	\'elastic\', closeEffect	:	\'elastic\', type : \'iframe\', autoSize : false, width: \'900\', height: \'630\',
		scrolling : \'no\', padding : \'0\'');
	

/*======================================
		Archive Content Loop
======================================*/

dxlayout_wrapper('main', $dna['bootstrap']);
	
	// Title Area
	echo '<div id="page-title">
	
		<div id="header"></div>';
		
		if ( is_post_type_archive() || is_tax() ) {
			echo '<div class="title-tab">';
				if ( ! file_exists(HELIX_THEME . '/_includes/socialbar.php') ) {
					include(HELIX_PATH . '/_includes/socialbar.php');
				} else {
					include(HELIX_THEME . '/_includes/socialbar.php');
				}
			echo '</div>';
		} else {
			if ( get_dna('show_sharebar_archive') ) {
				echo '<div class="title-tab">';
					if ( ! file_exists(HELIX_THEME . '/_includes/socialbar.php') ) {
						include(HELIX_PATH . '/_includes/socialbar.php');
					} else {
						include(HELIX_THEME . '/_includes/socialbar.php');
					}
				echo '</div>';
			} else if ( get_dna('show_page_archive') ) {
				echo '<div class="title-tab">
					<a href="/';
						if ( ! $tablink_parent == '0' ) {
							echo $tablink_parent_link . '/';
						}
						echo $tablink_info->post_name . '/">' . $tablink_info->post_title . 
					'</a>
				</div>';
			}
		}
		
		echo '<div class="content">';
		
			if ( ! get_dna('hide_breadcrumbs') ) {
			 dxlayout_breadcrumbs();
			}
			
			echo '<h1>';
				if ( is_post_type_archive() ) {
					post_type_archive_title();
				} else if ( is_date() ) {
					echo get_the_time('F');
				} else if ( is_tag() ) {
					echo 'Articles tagged: ' . single_cat_title('', false);
				} else {
					echo single_cat_title('', false);
				}
			echo '</h1>
			
			<p class="teaser">';
				if ( is_post_type_archive() ) {
					echo get_dna('default_teaser');
				} else if ( is_date() ) {
					echo 'Posts from ' . get_the_time('F') . ' ' . get_the_time('Y');
				} else {
					echo category_description();
				}
			echo '</p>
			
		</div>
	</div>';

	helixpublish_override($dna['archive'], $dna['archive-content-pos']); 
	
	dxpublish_aside($dna['archive-sidebar'], $dna['archive-sidebar-pos']);

dxlayout_wrapper_end('main');


/*======================================
		Footer
======================================*/

	helixpublish_footer($dna['footer'], '', 'false');
get_footer(); 

?>