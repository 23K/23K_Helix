<?php
/* Template Name: LP */
/*=====================================================*/

global $dna, $post;

$rna_page_details_billboard = get_post_meta( $post->ID, 'rna_page_details_billboard', true );
$rna_page_details_billboard = get_post_meta( $post->ID, 'rna_page_details_billboard', true );
if ( is_numeric($rna_page_details_billboard) ) {
	$billboard = wp_get_attachment_image_src( $rna_page_details_billboard, 'page-billboard' );
	$bb = $billboard[0];
} else {
	$bb = $rna_page_details_billboard;
}

$rna_page_details_title = get_post_meta( $post->ID, 'rna_page_details_title', true );
if ($rna_page_details_title) {
	$title = $rna_page_details_title;
} else {
	$title = get_the_title();
}

$rna_page_details_teaser = get_post_meta( $post->ID, 'rna_page_details_teaser', true );

$rna_page_details_tab_link = get_post_meta( $post->ID, 'rna_page_details_tab_link', true );
$tablink_info = get_page($rna_page_details_tab_link);
$tablink_parent = $tablink_info->post_parent;
if ( ! $tablink_parent == '0' ) {
	$tablink_parent_info = get_page($tablink_parent);
	$tablink_parent_link = $tablink_parent_info->post_name;
}

$rna_page_details_tab_link_name = get_post_meta( $post->ID, 'rna_page_details_tab_link_name', true );

$posttype = get_post_type();


/*====================================*/

get_header();
	helixpublish_header($dna['masthead'], '', 'false');


// Billboard
if ( $rna_page_details_billboard ) {
	echo '<div id="page-billboard">
		<img src="' . $bb . '" />
	</div>';
} else {
	echo '<style> div#main.wrapper { margin-top: 20px; } </style>';
}


/*======================================
		Page Content Loop
======================================*/

dxlayout_wrapper('main', $dna['bootstrap']);

	// Content
	helixpublish_article($dna['layout'], 'span12'); 

dxlayout_wrapper_end('main');


/*======================================
		Footer
======================================*/

	helixpublish_footer($dna['footer'], '', 'false');
get_footer(); 


?>