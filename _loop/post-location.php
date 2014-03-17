<?php
/*======================================================================================
		23K DARWIN
		Loop: Post - Location
=======================================================================================*/

global $dna_config, $dna;

$rna_locations_street = get_post_meta($post->ID, 'rna_locations_street', true);
$rna_locations_city = get_post_meta($post->ID, 'rna_locations_city', true);
$rna_locations_state = get_post_meta($post->ID, 'rna_locations_state', true);
$rna_locations_zip = get_post_meta($post->ID, 'rna_locations_zip', true);
$rna_locations_phone = get_post_meta($post->ID, 'rna_locations_phone', true);
$rna_locations_phone2 = get_post_meta($post->ID, 'rna_locations_phone2', true);
$rna_locations_email = get_post_meta($post->ID, 'rna_locations_email', true);

if ( $rna_locations_street ) {
	$add1 = str_replace(' ', '+', $rna_locations_street);
} else {
	$add1 = '';
}

$city = str_replace(' ', '+', $rna_locations_city);
$state = str_replace(' ' ,'+', $rna_locations_state);
$zip = str_replace(' ' ,'+', $rna_locations_zip);

if ( $rna_locations_state ) {
	if ( $rna_locations_zip ) {
		$add2 = $city . '+' . $state . '+' . $zip;
	} else {
		$add2 = $city . '+' . $state;
	}
} else {
	$add2 = $city;
}


if (have_posts()) : while (have_posts()) : the_post();

/*======================================
		Post Content
======================================*/
	
	// Content
	
	if ( get_dna('locations_thumb') == 'half' ) {
		echo '<div class="row">
			<div class="span4">';
				if ( has_post_thumbnail() ) {
					the_post_thumbnail('blog-thumbnail');
				}
			echo '</div>
			
			<div class="span4">';
				if ( $rna_locations_street || $rna_locations_city ) {
					echo '<p><strong>Address:</strong><br />' . 
						$rna_locations_street . '<br />' .
						$rna_locations_city . ', ' . $rna_locations_state . ' ' . $rna_locations_zip . '<br />
						
						<a href="https://maps.google.com/maps?q=' . $add1 . '+' . $add2 . '&hl=en" target="_blank">Get Directions</a></p>';
				}
				
				if ( $rna_locations_phone ) {
					echo '<p><strong>Phone:</strong><br />' . 
						$rna_locations_phone . '<br />' .
						$rna_locations_phone2 . '</p>';
				}
				
				if ( $rna_locations_email ) {
					echo '<p><strong>Email:</strong><br />
						' . $rna_locations_email . '</p>';
				}
			echo '</div>
		</div>';
	} else {
		if ( has_post_thumbnail() ) {
			the_post_thumbnail('blog-full');
		}
		
		dxclear('', '15');
		
		echo '<div class="row">
			<div class="span3">';
				if ( $rna_locations_street || $rna_locations_city ) {
					echo '<p><strong>Address:</strong><br />' . 
						$rna_locations_street . '<br />' .
						$rna_locations_city . ', ' . $rna_locations_state . ' ' . $rna_locations_zip . '<br />
						
						<a href="https://maps.google.com/maps?q=' . $add1 . '+' . $add2 . '&hl=en" target="_blank">Get Directions</a></p>';
				}
			echo '</div>
			
			<div class="span2">';	
				if ( $rna_locations_phone ) {
					echo '<p><strong>Phone:</strong><br />' . 
						$rna_locations_phone . '<br />' .
						$rna_locations_phone2 . '</p>';
				}
			echo '</div>
			
			<div class="span3">';
				if ( $rna_locations_email ) {
					echo '<p><strong>Email:</strong><br />' . 
						$rna_locations_email . '</p>';
				}
			echo '</div>
		</div>';
	}
	
	
	dxclear('', '15');
	
	
	the_content();


/*=====================================================*/
endwhile; else:endif; 

?>