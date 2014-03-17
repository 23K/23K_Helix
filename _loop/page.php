<?php
/*=======================================================
		23K DARWIN 
		Content Loop: Page
=======================================================*/

global $dna_config, $dna, $post;

$leadout_page = get_post_meta($post->ID, 'rna_leadout_page', true);
$leadout_title = get_post_meta($post->ID, 'rna_leadout_title', true);
$leadout_copy = get_post_meta($post->ID, 'rna_leadout_copy', true);


if (have_posts()) : while (have_posts()) : the_post();

/*======================================
		Page Content
======================================*/
	
	the_content();
	
	if ( $leadout_page ) {
		if ( $leadout_title ) $title = $leadout_title;
		else $title = get_the_title($leadout_page);
		
		if ( $leadout_copy ) $copy = wpautop($leadout_copy);
		else $copy = '';
		
		echo do_shortcode('[leadout cta="Continue to <br /><strong>' . $title . '</strong>" link="' . get_permalink($leadout_page) . '"]' . $copy . '[/leadout]');
	}
	


/*====================================================================================*/

endwhile; else:endif; 


?>