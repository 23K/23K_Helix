<?php
/*======================================================================================
		23K DARWIN
		Post Preview - Related Post
=======================================================================================*/

global $dna_config, $dna, $post;


/*======================================
		Post Content
======================================*/

echo '<div class="related-post clearfix">
	<a href="' . get_permalink($post->ID) . '" title="' . get_the_title() . '">
		<div class="row">
			<div class="span1">';
				
			if ( has_post_thumbnail() ) {
				the_post_thumbnail('preview-post');
			}
			
			echo '</div>
			
			<div class="span2">';
			
				the_title();
				
				echo '<p class="date">' . get_the_date('m/d/Y') . '</p>
			</div>
		</div>
	</a>
</div>';


/*=====================================================*/

?>

