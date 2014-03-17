<?php
/*=======================================================
		23K DARWIN
		Loop: Footer
=======================================================*/

global $dna_config, $dna;


/*======================================
		Footer Widgets
======================================*/

dxlayout_wrapper('footer-main');
	
	dxlayout_footer_widgets($dna_config['footer_widgets']);
	
dxlayout_wrapper_end('footer-main');


/*======================================
		Footer Toolbar
======================================*/

dxlayout_wrapper('footer-toolbar');

	if ( get_dna('show_footer_nav') ) {
		wp_nav_menu(array( 'theme_location' => 'darwin_menu_footer_navigation','menu_class' => 'menu', 
												 'menu_id' => 'footer-menu', 'container' => 'false' ));
	}
	
	if ( get_dna('footer_copyright') ) {
		echo '<p>' . get_dna('footer_copyright') . '</p>';
	}

dxlayout_wrapper_end('footer-toolbar');

 
?>