<?php
/*======================================================================================
		23K DARWIN
		Archive Loop - Gallery Photos
=======================================================================================*/

global $dna_config, $dna;


echo '<div class="menu-gallery-nav-container">
	<ul id="gallery-menu" class="menu clearfix">';
		$galleries = get_terms('gallery', array(
			'fields' => 'all',
			'hide_empty' => 1,
			'orderby' => 'count',
			'order' => 'DESC'
		));
		
		foreach ($galleries as $gallery) {
			if ( single_cat_title('', false) == $gallery->name ) {
				$current = ' current-menu-item';
			} else {
				$current = '';
			}
			
			if ( $gallery->parent == '0' ) {
				echo '<li class="menu-item gallery-parent' . $current . '"><a href="/gallery/' . $gallery->slug . '/">' . $gallery->name . '</a></li>';
			} else {
				$parentcat = get_term_by('id', $gallery->parent, 'gallery');
				$parentslug = $parentcat->slug;
				echo '<li class="menu-item' . $current . '"><a href="/gallery/' . $gallery->slug . '/">' . $gallery->name . '</a></li>';
			}
		}
	echo '</ul>
</div>';


/*======================================
		Archive Content
======================================*/

echo '<ul id="post-photo-gallery">';

	
if (have_posts()) : while (have_posts()) : the_post();

/*=====================================================*/

echo '<li>';
	
		if ( has_post_thumbnail()) {
			if ( get_dna('gallery_single') == 'full-info' ) {
				echo '<a href="' . get_permalink($post->ID) . '" rel="gallery" class="galleries" data-fancybox-width="980" data-fancybox-height="630">';
					the_post_thumbnail('gallery-thumbnail');
					echo '<div class="gallery-hover"></div>
				</a>';
			} else {
				$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
			
				echo '<a href="' . $large_image_url[0] . '" rel="gallery" title="' . get_the_content() . '" class="fancy-img">';
					the_post_thumbnail('gallery-thumbnail');
					echo '<div class="gallery-hover"></div>
				</a>';
			}
		}

echo '</li>';

/*=====================================================*/
endwhile; else:endif; 

dxclear();
echo '</ul>';



global $wp_query;  
$total_pages = $wp_query->max_num_pages;  

if ($total_pages > 1) {  
	$current_page = max(1, get_query_var('paged'));  
		
	echo '<div id="pagination-wrapper">
		<div id="pagination"><p>';
			echo paginate_links(array(
				'base' => get_pagenum_link(1) . '%_%',
				'format' => 'page/%#%',
				'current' => $current_page,
				'total' => $total_pages,
				'prev_next' => false,
			));	
		echo '</div></p>
	</div>';
}

	
?>