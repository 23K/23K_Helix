<?php
/*======================================================================================
		23K DARWIN
		Single Post: Photo Gallery
=======================================================================================*/

global $dna, $post;

get_header();


dxlayout_trapdoor('/gallery/showcase/');


/*======================================
		Video Content
======================================*/

dxlayout_wrapper('gallery-single', $dna['bootstrap']);

if (have_posts()) : while (have_posts()) : the_post(); 

	if ( has_post_thumbnail() ) {
		echo '<div id="gallery-img-wrapper">';
			the_post_thumbnail('gallery-full');
		echo '</div>';
	}
	
	echo '<div class="row">
		<div class="span3">
			<p class="category">';
				$args = array('orderby' => 'term_order', 'order' => 'ASC', 'fields' => 'all');
				$gallery_terms = wp_get_object_terms($post->ID, 'gallery', $args);
				echo $gallery_terms[0]->name;
			echo '</p>
			<p class="title">' . get_the_title() . '</p>
		</div>
		<div class="span9">
			<p>' . get_the_content() . '</p>';
			if ( ! file_exists(HELIX_THEME . '/_includes/socialbar.php') ) {
					include(HELIX_PATH . '/_includes/socialbar.php');
				} else {
					include(HELIX_THEME . '/_includes/socialbar.php');
				}
		echo '</div>
	</div>';


endwhile; else: endif;

dxlayout_wrapper_end('gallery-single');

	
/*======================================
		Footer
======================================*/

get_footer(); 

?>