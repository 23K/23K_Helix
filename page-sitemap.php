<?php
/* Template Name: Sitemap */
/*=====================================================*/

global $dna, $post;

$rna_page_details_billboard = get_post_meta( $post->ID, 'rna_page_details_billboard', true );
$billboard = wp_get_attachment_image_src( $rna_page_details_billboard, 'page-billboard' );
$billboard_long = wp_get_attachment_image_src( $rna_page_details_billboard, 'page-billboard-long' );
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


/*====================================*/

get_header(); 
	helixpublish_header($dna['masthead'], '', 'false');


/*======================================
		Page Billboard
======================================*/

// old helix billboard
if ( ! $dna_config['helix_release'] || $dna_config['helix_release'] <= 1.3 ) {
	if ( $rna_page_details_billboard ) {
		echo '<div id="page-billboard">
			<img src="' . $bb . '" />
		</div>';
	} else {
		echo '<style> div#main.wrapper { margin-top: 20px; } </style>';
	}
// helix 1.4+ billboard
} else {
	if ( $rna_page_details_billboard ) {
		dxlayout_wrapper('page-billboard', $dna['bootstrap']);
			echo '<img src="' . $bb . '" />';
		dxlayout_wrapper_end('page-billboard');
	} else {
		echo '<style> div#main.wrapper { margin-top: 20px; } </style>';
	}
}


/*======================================
		Page Content Loop
======================================*/

dxlayout_wrapper('main', $dna['bootstrap']);

	// Title Area
	echo '<div id="page-title">
		<div class="content">';
			
			if ( ! get_dna('hide_breadcrumbs') ) {
				dxlayout_breadcrumbs();
			}
			
			echo '<h1>' . $title . '</h1>';
			
			if ( ! get_dna('hide_teaser') ) {
				if ( $rna_page_details_teaser ) {
					echo '<p class="teaser">' . $rna_page_details_teaser . '</p>';
				} else {
					echo '<p class="teaser">' . get_dna('default_teaser') . '</p>';
				}
			}
		echo '</div>
	</div>';
	

	// Content
	echo '<article id="sitemap" class="content span12">
		<div class="column half one_half">
			<h2>Pages</h2>';
			
			$exclude = "'" . $post->ID . ", 1405, " . get_dna('frontpage_content') . "'";
			$args = array( 'exclude' => $exclude, 'show_home' => true );
			wp_page_menu($args);
			
			echo '</ul>
		</div>
		
		
		<div class="column half one_half last">';
		
		$galposts = get_posts('post_type=photo-gallery');
		if ( $galposts ) {
			echo '
				<h2>Galleries</h2>
				<ul>';
					$terms = get_terms('gallery', 'orderby=name');
					foreach ( $terms as $term ) {
						echo '<li><a href="/gallery/' . $term->slug . '/">' . $term->name . '</a></li>';
					}
				echo '</ul>';
			}
			
			if ( ! get_dna('no_posts') || get_dna('no_posts') != 1 ) {
				echo '<h2>Blog</h2>
				<ul>';
					$args3 = array( 'title_li' => '' );
					wp_list_categories($args3);
				echo '</ul>';
			}
			
			$locposts = get_posts('post_type=locations');
			if ( $locposts ) {
				echo '<h2>Locations</h2>
				<ul>';
					$args2 = array( 'post_type' => 'locations', 'sort_column' => 'menu_order', 'title_li' => '' );
					wp_list_pages($args2);
				echo '</ul>';
			}
		echo '</div>
		
	</article>';

dxlayout_wrapper_end('main');


/*======================================
		Footer
======================================*/

	helixpublish_footer($dna['footer'], '', 'false');
get_footer(); 


?>