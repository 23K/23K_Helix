<?php
/*======================================================================================
		23K DARWIN
		Loop: Preview - Testimomial
=======================================================================================*/

global $dna_config, $dna;


echo '<div class="testimonial-box">
	<p class="testimonial">' . str_replace('&raquo;', '', str_replace('Read More', '', get_the_excerpt())) . '</p>
	<p class="testimonial-author">&mdash; ' . get_the_title() . '</p>
</div>';


/*=====================================================*/

?>