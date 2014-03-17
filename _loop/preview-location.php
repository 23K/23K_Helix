<?php
/*======================================================================================
		23K DARWIN
		Post Preview - Location
=======================================================================================*/

global $dna_config, $dna, $post;


/*======================================
		Post Content
======================================*/

echo '<article class="post">
	<div class="row">
		<div class="span4">';
		
			if ( has_post_thumbnail() ) {
				dxlink_the_post_thumbnail('div','blog-thumbnail','blog-thumbnail');
			}
			
		echo '</div>
			
		<div class="span4">';
			
			dxlink_get_the_title('', 'h2');
			
			echo str_replace('Read More', 'Location Info', get_the_excerpt());
			
		echo '</div>
	</div>
</article>';

dxlayout_divider(15);


/*=====================================================*/

?>