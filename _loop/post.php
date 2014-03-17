<?php
/*======================================================================================
		23K DARWIN
		Loop: Post
=======================================================================================*/

global $dna_config, $dna;

$leadout_link = get_page(get_dna('blog_leadout_link'));
if ( get_dna('blog_leadout_title') ) {
	$leadout_title = get_dna('blog_leadout_title');
} else {
	$leadout_title = $leadout_link->post_title;
}

$post_expiration = get_post_meta($post->ID, 'rna_post_expiration_date', true);
$alt_content = get_post_meta($post->ID, 'rna_post_expiration_alt_content', true);


if (have_posts()) : while (have_posts()) : the_post();

/*======================================
		Post Content
======================================*/

	// Page Title
	if ( get_dna('page_title') == 'category' ) {
		echo '<h2 class="blog-header">' . get_the_title() . '</h2>';
	}
	
	if ( get_dna('show_post_date') || get_dna('show_post_author') ) {
		echo '<p class="date-posted">Posted';
		if ( get_dna('show_post_date') ) {
			echo ' on: ' . get_the_date('n-j-Y');
		}
		if ( get_dna('show_post_author') ) {
			echo ' by ' . get_the_author();
		}
		echo '</p>';
	}
	
	// Content
	if ( ! $post_expiration ) {
		the_content();
	} else if ( $post_expiration <= date('Y-m-d') ) {
		if ( $alt_content ) {
			echo wpautop(do_shortcode($alt_content));
		}
	} else {
		the_content();
	}
	
	
	if ( get_dna('show_post_sharebar') ) {
		dxclear('', '50');
		
		if ( ! file_exists(HELIX_THEME . '/_includes/socialbar.php') ) {
			include(HELIX_PATH . '/_includes/socialbar.php');
		} else {
			include(HELIX_THEME . '/_includes/socialbar.php');
		}
	}
	
	
	// Comments
	if ( get_dna('show_comments') ) {
		echo '<div class="divider post"></div>
		<h4>Start a Conversation</h4>';
		
		comments_template();
	}
	
	
	// Tags
	if ( get_dna('show_tags') ) {
		echo '<div class="divider post"></div>
		<h4>Related Topics</h4>';
		the_tags('', ' • ', '<br />');
		dxclear('', '15');
	}
	
	
	// Related Posts
	if ( get_dna('show_related') ) {
		echo '<div class="divider post"></div>';
		$cats = get_the_category($post->ID);
		if ($cats) {
			echo '<h4>Related Posts</h4>';
			$cat = $cats[1]->term_id;
			$args = array( 'cat' => $cat, 'post__not_in' => array($post->ID), 'showposts' => 3, 'caller_get_posts' => 1 );
			$my_query = new WP_Query($args);
			if ( $my_query->have_posts() ) {
				while ($my_query->have_posts()) : $my_query->the_post();
					if ( ! file_exists(HELIX_THEME . '/_loop/preview-related.php') ) {
						include(HELIX_PATH . '/_loop/preview-related.php');
					} else {
						include(HELIX_THEME . '/_loop/preview-related.php');
					}
				endwhile;
			}
		}
	}
	
	
	// Leadout
	if ( get_dna('show_blog_leadout') ) {
		echo '<div class="divider post"></div>';
		
		if ( get_dna('blog_leadout_headline') ) {
			echo '<h3>' . get_dna('blog_leadout_headline') . '</h3>';
		}
		echo '<div class="leadout">
			<a href="/' . $leadout_link->post_name . '/">
				<div class="tab">
					<h4>' . get_dna('blog_leadout_cta') . '<br />
						<strong>' . $leadout_title . '</strong></h4>
				</div>
			</a>';
			if ( get_dna('blog_leadout_copy') ) {
				echo '<p>' . get_dna('blog_leadout_copy') . '</p>';
			}
		echo '</div>';
		dxclear('', '30');
	}
	

/*=====================================================*/
endwhile; else:endif; 

?>