<?php

/*======================================================================================
	23K Helix
	Publish Functions
======================================================================================*/

/*======================================================================================
	helixpublish
		Same as dxPublish, but looks for loop in theme first
		If not present, loads default loop from plugin
=======================================================================================*/

function helixpublish($loop, $number='0', $category='0', $ul_id='', $li_id='', $ul_class='', $li_class='', 
									 $before_ul='', $before_ul_end='', $after_ul='', $after_ul_end='') {		
global $post, $dna_config;

if ($dna_config['debug']=='true') {
	$debug_layout_data = '<div id="'.$loop.'-data" class="dxdebug-data dxdebug-layout-data review1">Darwin Loop: <strong>'.$loop.'</strong></div>';
}
else { $debug_layout_data = ''; }

// If category is set to 'no_wrap', the loop occurs without a container
	if ($number == 'prime') {
	
		// Debug mode displays loop identification!
		if (isset($_GET['loops'])||isset($_GET['debug'])) {
			echo $debug_layout_data;
		}
		
		// Load the loop template
		echo $debug_layout_data;
		if ( ! file_exists(HELIX_THEME . '/_loop/' . $loop . '.php') ) {
			 include( HELIX_PATH . '/_loop/' . $loop . '.php');
		} else {
			include( HELIX_THEME . '/_loop/' . $loop . '.php' );
		}
		echo dxclear('return');
		wp_reset_query();
	}
	
	// If category contains a number (category ID)...
	else if (is_numeric($category)) {
		$args = array(
			'numberposts' => $number,
			'category' => $category
		);
		$postlist = get_posts ( $args );
		$counter = 0;
		
		if ($ul_id == '') { $ul_id = $loop; }
		if ($li_id != '') { $li_id = $li_id; }
		else { $li_id = $ul_id; }
			
		echo $before_ul.'<ul id="'.$ul_id.'" class="publish '.$ul_class.'">'.$debug_layout_data.''.$after_ul, $after_ul_end;

		foreach($postlist as $post) {
			setup_postdata($post); $counter++;
			echo '<li id="'.$li_id.'-'.$counter.'" class="'.dxget_the_slug().' '.$li_class;
				if ($counter == '1') { echo ' active'; }
					echo '">';
					
				if ( ! file_exists(HELIX_THEME . '/_loop/' . $loop . '.php') ) {
					include ( HELIX_PATH . '/_loop/' . $loop . '.php' );
				} else {
					include( HELIX_THEME . '/_loop/' . $loop . '.php' );
				}
			echo '</li>';
		}
		echo dxclear('return').'</ul>'.$before_ul_end.dxclear('return');
		wp_reset_query();
	}	

	// If category is set, Publish creates a list and runs a query
	else if ($number != '0') {
		$args = $category;
		$postlist = get_posts ( $args );
		$counter = 0;
		
		if ($ul_id == '') { $ul_id = $loop; }
		if ($li_id != '') { $li_id = $li_id; }
		else { $li_id = $ul_id; }
			
		echo $before_ul.'<ul id="'.$ul_id.'" class="publish '.$ul_class.'">'.$debug_layout_data.''.$after_ul, $after_ul_end;

		foreach($postlist as $post) {
			setup_postdata($post); $counter++;
			echo '<li id="'.$li_id.'-'.$counter.'" class="'.dxget_the_slug().' '.$li_class;
				if ($counter == '1') { echo ' active'; }
					echo '">';
				
				if ( ! file_exists(HELIX_THEME . '/_loop/' . $loop . '.php') ) {
					include ( HELIX_PATH . '/_loop/' . $loop . '.php' );
				} else {
					include( HELIX_THEME . '/_loop/' . $loop . '.php' );
				}
			echo '</li>';
		}
		echo dxclear('return').'</ul>'.$before_ul_end.dxclear('return');
		wp_reset_query();
	}

	// Since no category is set, Publish creates a single div
	else if ($number == '0') {
		echo '<div id="'.$loop.'" class="content '.$ul_class.'">';
		
		// Debug mode displays loop identification!
		if (isset($_GET['loops'])||isset($_GET['debug'])) {
			echo $debug_layout_data;
		}
		
		// Load the loop template
		if ( ! file_exists(HELIX_THEME . '/_loop/' . $loop . '.php') ) {
			 include( HELIX_PATH . '/_loop/' . $loop . '.php' );
		} else {
			include( HELIX_THEME . '/_loop/' . $loop . '.php' );
		}
		echo dxclear('return').'</div>';
		wp_reset_query();
	}	
}


/*======================================================================================
	helixPublish Override
=======================================================================================*/

function helixpublish_override($looplayout, $content_class='') {
	global $post, $dna;
	
	if ( get_post_meta($post->ID, 'rna_loop_'.$looplayout, true) ) {
		$custom_loop = get_post_meta($post->ID, 'rna_loop_'.$looplayout, true);		
		helixpublish($custom_loop);
	}
	else if ( $content_class == 'prime') { helixpublish($looplayout, 'prime'); }
	else { helixpublish($looplayout, '0', '', '', '', $content_class); }
}


/*======================================================================================
	helixPublish Section
		Produce lists of posts in a contained section
=======================================================================================*/

function helixpublish_section($loop, $number='0', $category='', $ul_id='', $li_id='', $ul_class='', $li_class='', 
									 $before_ul='', $before_ul_end='', $after_ul='', $after_ul_end='') {		
global $post;
global $dna_config;


	// If category contains a number (category ID)...
	
	if (is_numeric($category)) {
	
		$args = array(
			'numberposts' => $number,
			'category' => $category
		);

		$postlist = get_posts ( $args );
		$counter = 0;
		
		// Prepare special class / ID assignments
		if ($ul_id == '') { 
			$section_id = $loop;
			$ul_id = $loop.'-list'; 
			$section_id = $loop;
		}
		if ($li_id != '') { 
			$li_id = $li_id.'-'; 
		}
		else { 
			$li_id = $ul_id.'-item-';
		}
			
		echo '<section id="'.$section_id.'" class="published">'.$before_ul.'<ul id="'.$ul_id.'" class="publish '.$ul_class.'">'.$after_ul, $after_ul_end;

		foreach($postlist as $post) {
			setup_postdata($post); $counter++;
			echo '<li id="'.$li_id.'-'.$counter.'" class="media '.dxget_the_slug().' '.$li_class;
				if ($counter == '1') { echo ' active'; }
					echo '">';
				if ( ! file_exists(HELIX_THEME . '/_loop/' . $loop . '.php') ) {
					include( HELIX_PATH . '/_loop/'.$loop.'.php' );
				} else {
					include( HELIX_THEME . '/_loop/' . $loop . '.php' );
				}
			echo '</li>';
		}
		echo dxclear('return').'</ul>'.$before_ul_end.dxclear('return').'</section>'.dxclear('return');
		wp_reset_query();
	}	

// If category is set, Publish creates a list and runs a querry
	else if ($number != '0') {
		
		// Prepare special class / ID assignments
		if ($ul_id == '') { 
			$section_id = $loop;
			$ul_id = $loop.'-list'; 
			$section_id = $loop;
		}
		if ($li_id != '') { 
			$li_id = $li_id.'-'; 
		}
		else { 
			$li_id = $ul_id.'-item-';
		}
			
		echo '<section id="'.$section_id.'" class="published">'.$before_ul.'<ul id="'.$ul_id.'" class="publish '.$ul_class.'">'.$after_ul, $after_ul_end;

		foreach($postlist as $post) {
			setup_postdata($post); $counter++;
			echo '<li id="'.$li_id.'-'.$counter.'" class="'.dxget_the_slug().' '.$li_class;
				if ($counter == '1') { echo ' active'; }
					echo '">';
				if ( ! file_exists(HELIX_THEME . '/_loop/' . $loop . '.php') ) {
					include( HELIX_PATH . '/_loop/'.$loop.'.php' );
				} else {
					include( HELIX_THEME . '/_loop/' . $loop . '.php' );
				}
			echo '</li>';
		}
		echo dxclear('return').'</ul>'.$before_ul_end.dxclear('return').'</section>'.dxclear('return');
		wp_reset_query();
	}
}


/*======================================================================================
	helixPublish Article
		Produce specified content using a loop layout in an article defined by the page's traits
=======================================================================================*/

function helixpublish_article($loop, $content_class='') {		
global $post;
global $dna_config;

	echo '<article id="'.$loop.'" class="content '.$content_class.'">';
	#locate_template( '_loop/'.$loop.'.php', '1');
	if ( ! file_exists(HELIX_THEME . '/_loop/' . $loop . '.php') ) {
		include( HELIX_PATH . '/_loop/' . $loop . '.php' );
	} else {
		include( HELIX_THEME . '/_loop/' . $loop . '.php' );
	}
	echo dxclear('return').'</article>';
	wp_reset_query();
}


/*======================================================================================
	helixPublish Header
		Produce specified content using a loop layout in a header defined by the page's traits
=======================================================================================*/

function helixpublish_header($loop, $content_class='', $nowrap='') {		
global $post;
global $dna_config;

	// Output Header.wrapper > Container
	if ($nowrap == '') {
			echo '<header id="'.$loop.'" class="wrapper"><div class="container '.$content_class.'">';
				#locate_template( '_loop/'.$loop.'.php', '1');
				if ( ! file_exists(HELIX_THEME . '/_loop/' . $loop . '.php') ) {
					include( HELIX_PATH . '/_loop/' . $loop . '.php');
				} else {
					include( HELIX_THEME . '/_loop/' . $loop . '.php' );
				}
			echo '<div class="clear"></div></div>
			<div class="clear"></div>
			</header>';
			wp_reset_query();			
	}
	
	// Output Header , no wrapper / container
	if ($nowrap != '') {
		echo '<header id="'.$loop.'" class="'.$content_class.'">';
			#locate_template( '_loop/'.$loop.'.php', '1');
			if ( ! file_exists(HELIX_THEME . '/_loop/' . $loop . '.php') ) {
				include( HELIX_PATH . '/_loop/' . $loop . '.php');
			} else {
				include( HELIX_THEME . '/_loop/' . $loop . '.php' );
			}
		echo dxclear('return').'</header>';
		wp_reset_query();
	}
}


/*======================================================================================
	helixPublish Footer
		Produce specified content using a loop layout in a footer defined by the page's traits
=======================================================================================*/

function helixpublish_footer($loop, $content_class='', $nowrap='') {		
global $post;
global $dna_config;

	if ($nowrap == '') {
		echo '<footer id="'.$loop.'" class="wrapper '.$content_class.'"><div class="container">';
			#locate_template( '_loop/'.$loop.'.php', '1');
			if ( ! file_exists( HELIX_THEME . '/_loop/' . $loop . '.php') ) {
				include( HELIX_PATH . '/_loop/' . $loop . '.php' );
			} else {
				include( HELIX_THEME . '/_loop/' . $loop . '.php' );
			}
		echo dxclear('return').'</div></footer>';
		wp_reset_query();
	}
	if ($nowrap != '') {
		echo '<footer id="'.$loop.'" class="'.$content_class.'">';
			#locate_template( '_loop/'.$loop.'.php', '1');
			if ( ! file_exists( HELIX_THEME . '/_loop/' . $loop . '.php') ) {
				include( HELIX_PATH . '/_loop/' . $loop . '.php' );
			} else {
				include( HELIX_THEME . '/_loop/' . $loop . '.php' );
			}
		echo dxclear('return').'</footer>';
		wp_reset_query();
	}
}


?>