<?php
/*=======================================================
		23K HELIX
		404 Error Page
=======================================================*/

global $dna;


get_header(); 
	helixpublish_header($dna['masthead'], '', 'false');


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
			
			echo '<h1>404</h1>
			<p class="teaser">Sorry, the page you requested could not be found.</p>';
		echo '</div>
	</div>';
	

	// Content
	echo '<article id="sitemap" class="content span12">
		<div class="row">
			<div class="span5 offset1">
				<h2>Pages</h2>';
				
				$exclude = "'" . $post->ID . ", 1405, " . get_dna('frontpage_content') . "'";
				$args = array( 'exclude' => $exclude, 'show_home' => true );
				wp_page_menu($args);
				
				echo '</ul>
			</div>
			
			
			<div class="span6">';
			
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
				
				echo '<h2>Blog</h2>
				<ul>';
					$args3 = array( 'title_li' => '' );
					wp_list_categories($args3);
				echo '</ul>';
				
				$locposts = get_posts('post_type=locations');
				if ( $locposts ) {
					echo '<h2>Locations</h2>
					<ul>';
						$args2 = array( 'post_type' => 'locations', 'sort_column' => 'menu_order', 'title_li' => '' );
						wp_list_pages($args2);
					echo '</ul>';
				}
			echo '</div>
		</div>
	</article>';

dxlayout_wrapper_end('main');	
	

/*======================================
		Footer
======================================*/

	helixpublish_footer($dna['footer']);
get_footer(); 


?>	