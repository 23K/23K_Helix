<?php
/*======================================================================================
		23K DARWIN
		Post Preview - Horizontal Format
=======================================================================================*/

global $dna_config, $dna, $post;


/*======================================
		Post Content
======================================*/

echo '<article class="post">';
		if ( get_dna('show_archive_date_tab') ) {
			echo '<div class="date-tab">
				<p>' . get_the_date('n/j') . '</p>
			</div>';
		}
		
		echo '<div class="row">
			<div class="span4">';
			
			if ( has_post_thumbnail() ) {
				dxlink_the_post_thumbnail('div','blog-thumbnail','blog-thumbnail');
			}
			
			echo '</div>
			
			<div class="span4">';
			
				if ( get_dna('show_archive_category') ) {
					$category = get_the_category();
					
					if ( $category[0] ) {
						$blogcat = get_term_by('name', 'Blogs and Reviews', 'category');
						$blogcat_id = $blogcat->term_id;
						
						if ( cat_is_ancestor_of($blogcat_id, $category[0]) ) {
							echo '<a href="' . get_category_link($category[0]->term_id ) . '" class="category">' . $category[0]->cat_name . '</a>';
						} else {
							echo '<a href="' . get_category_link($category[1]->term_id ) . '" class="category">' . $category[1]->cat_name . '</a>';
						}
					}
				}
				
				dxlink_get_the_title('', 'h2');
				
				if ( get_dna('show_archive_date') || get_dna('show_archive_author') ) {
					echo '<p class="date-posted">Posted';
					if ( get_dna('show_archive_date') ) {
						echo ' on: ' . get_the_date('n-j-Y');
					}
					if ( get_dna('show_archive_author') ) {
						echo ' by ' . get_the_author();
					}
					echo '</p>';
				}
				
				the_excerpt();
			echo '</div>
		</div>';
	
echo '</article>';

dxlayout_divider(15);


/*=====================================================*/

?>