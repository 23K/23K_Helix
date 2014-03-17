<?php
/*======================================================================================
		23K DARWIN
		Loop: Masthead
=======================================================================================*/

global $dna_config, $dna;


/*======================================
		Masthead Toolbar
======================================*/

dxlayout_wrapper('masthead-toolbar');

	dynamic_sidebar('sidebar_masthead');
	
	if ( get_dna('show_masthead_share') ) {
		echo '<div id="masthead-share">
			<div id="share-link"></div>
			<div id="share">
				<span>Share: </span>';
				if ( ! file_exists(HELIX_THEME . '/_includes/socialbar.php') ) {
					include(HELIX_PATH . '/_includes/socialbar.php');
				} else {
					include(HELIX_THEME . '/_includes/socialbar.php');
				}
			echo '</div>
		</div>';
	}
	
	if ( get_dna('show_masthead_search') ) {
		echo '<div id="masthead-search">
			<div id="search-link"></div>
			<div id="search">';
				get_search_form();
			echo '</div>
		</div>';
	}

dxlayout_wrapper_end('masthead-toolbar');


/*======================================
		Masthead Content
======================================*/

dxlayout_wrapper('masthead-main');

	$site_url = home_url();
	$site_name = get_bloginfo('name');
	
	// Masthead Logo
	echo '<a id="masthead-logo" href="' . $site_url . '" title="' . $site_name . '">' . $site_name . '</a>';
	
	// Masthead message
	if ( get_dna('masthead_message') ) {
		echo '<div id="masthead-message"><p>' . get_dna('masthead_message') . '</p></div>';
	}
	
	// Primary Navigation
	echo '<div id="masthead-navigation">';
		wp_nav_menu(array( 'theme_location' => 'darwin_menu_masthead_navigation','menu_class' => 'menu', 
											 'menu_id' => 'masthead-menu', 'container' => 'false' ));
	echo '</div>';

dxlayout_wrapper_end('masthead');


/*====================================*/

?>