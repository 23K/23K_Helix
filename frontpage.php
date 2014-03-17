<?php
/*=======================================================
		23K DARWIN
		Layout: Frontpage
=======================================================*/

global $dna;

$rna_page_details_tab_link = get_post_meta( get_dna('frontpage_content'), 'rna_page_details_tab_link', true );
$tablink_info = get_page($rna_page_details_tab_link);
$tablink_parent = $tablink_info->post_parent;
if ( ! $tablink_parent == '0' ) {
	$tablink_parent_info = get_page($tablink_parent);
	$tablink_parent_link = $tablink_parent_info->post_name;
}

$frontpage_teaser = get_post_meta( get_dna('frontpage_content'), 'rna_page_details_teaser', true );


get_header(); 
	helixpublish_header($dna['masthead'], '', 'false');
	

/*======================================
		Frontpage Content
======================================*/

dxlayout_wrapper('main', $dna['bootstrap']);

	echo '<div id="frontpage">';
	
		if ($rna_page_details_tab_link) {
			echo '<div class="title-tab">
				<a href="/';
				if ( ! $tablink_parent == '0' ) {
					echo $tablink_parent_link . '/';
				}
				echo $tablink_info->post_name . '/">' . $tablink_info->post_title . '</a>
			</div>';
		}
		
		dxpublish_post_content(get_dna('frontpage_content'), 'frontpage-content', 'article');
	
	echo '</div>';

dxlayout_wrapper_end('main');


/*======================================
		Footer
======================================*/

	helixpublish_footer($dna['footer'], '', 'false');
get_footer();


?>