<?php
/*======================================================================================

	23K HELIX
	Plugin Control Panel and Options Additions

=======================================================================================*/

// options to add to the beginning of the $options array
function optionsframework_more_options() {
	
	global $options;
	
	$options_pages = array();
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
    $options_pages[$page->ID] = $page->post_title;
	}
	
	
/*======================================================================================
	MASTHEAD
======================================================================================*/
/*	
$options[] = array( "name" => "Masthead",
	"type" => "heading" );

$options[] = array( "title" => "Masthead Logo",
	"id" => "masthead_logo",
	"std" => "",
	"type" => "text" );

$options[] = array( "name" => "Show/Hide",
	"desc" => "Check to show or hide features in the header.",
	"type" => "info" );

$options[] = array( "name" => "Show Search Icon",
	"desc" => "Show search icon that provides search area when hovered.",
	"id" => "show_masthead_search",
	"std" => "",
	"type" => "checkbox" );

$options[] = array( "name" => "Show Share Icon",
	"desc" => "Show share icon that provides social network sharing options when hovered.",
	"id" => "show_masthead_share",
	"std" => "",
	"type" => "checkbox" );
*/

/*======================================================================================
	PAGES
======================================================================================*/
/*
$options[] = array( "name" => "Pages",
	"type" => "heading" );

$options[] = array( "name" => "Show/Hide",
	"desc" => "Check to show or hide features on pages.",
	"type" => "info" );
	
$options[] = array( "name" => "Hide Breadcrumbs",
	"desc" => "Check if you don't want to show page breadcrumbs",
	"id" => "hide_breadcrumbs",
	"std" => "",
	"type" => "checkbox" );

$options[] = array( "name" => "Show Sharebar in Tab",
	"desc" => "Show sharebar instead of page link in tab at top of page.",
	"id" => "show_sharebar",
	"std" => "",
	"type" => "checkbox" );

$options[] = array( "name" => "Page Teaser",
	"desc" => "A short descriptive overview or excerpt shown at the top of the page.",
	"type" => "info" );

$options[] = array( "name" => "Default Teaser",
	"id" => "default_teaser",
	"desc" => "Enter a default teaser line to be used throughout the site on pages where another teaser isn't supplied.",
	"std" => "",
	"type" => "text" );

$options[] = array( "name" => "Hide Teasers",
	"desc" => "Check if you don't want to display teasers",
	"id" => "hide_teaser",
	"std" => "",
	"type" => "checkbox" );
*/

/*======================================================================================
	POSTS
======================================================================================*/
/*
$options[] = array( "name" => "Posts",
	"type" => "heading" );

$options[] = array( "name" => "Page Title",
	"id" => "page_title",
	"std" => "",
	"type" => "select",
	"options" => array(
		'title' => 'Post title',
		'category' => 'Category name and description') );

$options[] = array( "name" => "Show/Hide",
	"desc" => "Check to show or hide features on posts.",
	"type" => "info" );

$options[] = array( "name" => "Show Date",
	"id" => "show_post_date",
	"desc" => "Show date posted",
	"std" => "",
	"type" => "checkbox" );

$options[] = array( "name" => "Show Author",
	"id" => "show_post_author",
	"desc" => "Show author of post",
	"std" => "",
	"type" => "checkbox" );

$options[] = array( "name" => "Show Sharebar",
	"id" => "show_post_sharebar",
	"desc" => "Show social network sharebar on posts",
	"std" => "",
	"type" => "checkbox" );

$options[] = array( "name" => "Show Comments",
	"desc" => "Allow Faceboook comments on posts.",
	"id" => "show_comments",
	"std" => "",
	"type" => "checkbox" );

$options[] = array( "name" => "Show Related Topics",
	"desc" => "Display tags for current post",
	"id" => "show_tags",
	"std" => "",
	"type" => "checkbox" );

$options[] = array( "name" => "Show Related Posts",
	"desc" => "Display previews of three related posts.",
	"id" => "show_related",
	"std" => "",
	"type" => "checkbox");

$options[] = array( "name" => "Page Tab",
	"desc" => "Choose either a page to link to, or to display a sharebar in the tab at the top of the post. Select nothing to show neither.",
	"type" => "info" );

$options[] = array( "name" => "Show Page in Tab",
	"id" => "show_page_post",
	"std" => "",
	"type" => "select",
	"options" => array(
		'title' => 'Post title',
		'category' => 'Category name and description') );

$options[] = array( "name" => "Tab Page Name",
	"desc" => "Enter name to display if other than the normal page name.",
	"id" => "show_page_post_name",
	"std" => "",
	"type" => "text" );

$options[] = array( "name" => "Show Sharebar in Tab",
	"desc" => "Show sharebar instead of page link in tab at top of post.",
	"id" => "show_sharebar_post",
	"std" => "",
	"type" => "checkbox" );
*/

/*======================================================================================
	ARCHIVES
======================================================================================*/
/*
$options[] = array( "name" => "Post Archives",
	"type" => "heading" );

$options[] = array( "name" => "Show/Hide",
	"desc" => "Check to show or hide features on post archives.",
	"type" => "info" );
	
$options[] = array( "name" => "Show Date Tab",
	"id" => "show_archive_date_tab",
	"desc" => "Show date tab in archives",
	"std" => "",
	"type" => "checkbox" );

$options[] = array( "name" => "Show Date",
	"id" => "show_archive_date",
	"desc" => "Show date in archive post previews",
	"std" => "",
	"type" => "checkbox" );

$options[] = array( "name" => "Show Author",
	"id" => "show_archive_author",
	"desc" => "Show author in archive post previews",
	"std" => "",
	"type" => "checkbox" );

$options[] = array( "name" => "Show Category",
	"id" => "show_archive_category",
	"desc" => "Show category in archive post previews",
	"std" => "",
	"type" => "checkbox" );

$options[] = array( "name" => "Page Tab",
	"desc" => "Choose either a page to link to, or to display a sharebar in the tab at the top of the page. Select nothing to show neither.",
	"type" => "info" );

$options[] = array( "name" => "Show Page in Tab",
	"id" => "show_page_archive",
	"std" => "",
	"type" => "select",
	"options" => $options_pages );

$options[] = array( "name" => "Show Sharebar in Tab",
	"desc" => "Show sharebar instead of page link in tab at top of page.",
	"id" => "show_sharebar_archive",
	"std" => "",
	"type" => "checkbox" );

$options[] = array( "name" => "Blog Leadout",
	"desc" => "Add information to be shown on leadout tab at the bottom of blog posts and archive.",
	"type" => "info" );

$options[] = array( "name" => "Show Blog Leadout",
	"id" => "show_blog_leadout",
	"desc" => "Show leadout tab (if checked, enter leadout details below)",
	"std" => "",
	"type" => "checkbox" );

$options[] = array( "name" => "Headline",
	"id" => "blog_leadout_headline",
	"desc" => "Optional headline shown above leadout tab.",
	"std" => "",
	"type" => "text" );

$options[] = array( "name" => "CTA",
	"id" => "blog_leadout_cta",
	"desc" => "CTA shown before page name; for example. \"Continue to\" or \"Click here to.\"",
	"std" => "",
	"type" => "text" );

$options[] = array( "name" => "Page to Link To",
	"id" => "blog_leadout_link",
	"std" => "",
	"type" => "select",
	"options" => $options_pages );

$options[] = array( "name" => "Page Name",
	"id" => "blog_leadout_title",
	"desc" => "The page name to be shown on the leadout tab if other than the page's title.",
	"std" => "",
	"type" => "text" );

$options[] = array( "name" => "Copy",
	"id" => "blog_leadout_copy",
	"desc" => "Optional copy to be shown beside the leadout tab.",
	"std" => "",
	"type" => "textarea" );
*/

/*======================================================================================
	SYNDICATION
======================================================================================*/

/*
$options[] = array( "name" => "Syndication",
	"type" => "heading" );

$options[] = array( "name" => "Source Author",
	"desc" => "Your author name on The Source.",
	"id" => "source_author",
	"std" => "",
	"type" => "text" );
*/
/*
$options[] = array( "name" => "Feed URL",
	"desc" => "Example: http://sitename.com/feed",
	"id" => "syndication_feed",
	"std" => "",
	"type" => "text" );

$options[] = array( "name" => "Time Between Checks",
	"id" => "syndication_time",
	"std" => "",
	"type" => "select",
	"options" => array(
		"1" => "1 hour",
		"3" => "3 hours",
		"6" => "6 hours",
		"12" => "12 hours",
		"24" => "1 day",
		"48" => "2 days",
		"72" => "3 days",
		"168" => "1 week") );

$options[] = array( "name" => "Add to Category",
	"id" => "syndication_category",
	"std" => "",
	"type" => "tax_select",
	"tax" => "category" );

$options[] = array( "name" => "Maintain Categories",
	"desc" => "Select yes if you want to add posts to the categories they were in on the source blog. Note: categories must already exist on your blog.",
	"id" => "syndication_categories",
	"std" => "",
	"type" => "radio",
	"options" => array( 
		"yes" => "Yes",
		"no" => "No") );
*/


/*======================================================================================
	PHOTO GALLERY / LOCATIONS
======================================================================================*/
/*
$options[] = array( "name" => "Gallery / Locations",
	"type" => "heading" );

$options[] = array( "title" => "Gallery Photos",
	"id" => "gallery_single",
	"std" => "",
	"type" => "select",
	"options" => array(
		'photo' => 'Show just the photo with caption',
		'full-info' => 'Show the photo post with full description and gallery info') );

$options[] = array( "title" => "Locations Layout",
	"id" => "locations_thumb",
	"std" => "",
	"type" => "select",
	"options" => $options_locations = array(
		'half' => 'Show half-width photo beside location info',
		'full' => 'Show fullsize photo with location info beneath'
	) );
*/

/*======================================================================================
	FOOTER
======================================================================================*/
/*
$options[] = array( "name" => "Footer",
	"type" => "heading");

$options[] = array( "name" => "Show Footer Navigation",
	"id" => "show_footer_nav",
	"desc" => "Show footer navigation menu in footer toolbar.",
	"std" => "",
	"type" => "checkbox" );
*/

/*======================================================================================
	SYNDICATION
======================================================================================*/
/*
$options[] = array( "name" => "Syndication",
	"type" => "heading",
	"superadmin" => true );

$options[] = array( "name" => "Syndication",
	"desc" => "Syndication features - BETA.",
	"type" => "info" );

$options[] = array( "name" => "Turn On Syndication",
	"desc" => "Turn on source post syndication, vendor pages, and campaign landing pages.",
	"id" => "syndication_on",
	"type" => "checkbox" );

$options[] = array( "title" => "Vendor Subscriptions",
	"desc" => "Check the vendors whose content you want to show on your site.",
	"id" => "vendors_subscribed",
	"std" => "",
	"type" => "multicheck",
	"options" => array(
		"crestron" => "Crestron",
		"lutron" => "Lutron",
		"integra" => "Integra" ) );

$options[] = array( "title" => "Source Author",
	"desc" => "Your author name on The Source, to bring in posts you selected to reblog.",
	"id" => "source_author",
	"std" => "",
	"type" => "text" );

$options[] = array( "title" => "Campaign HQ Author",
	"id" => "source_author_name",
	"std" => "",
	"type" => "text",
	"desc" => "Your author name in Campaign Headquarters, to bring in campaign landing pages." );
*/
}


// Options to inject within the existing $options array
function optionsframework_inject_options() {
	$options_pages = array();
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
    $options_pages[$page->ID] = $page->post_title;
	}
	
	$extra_options = array();
	
	/*$extra_options[] = array( "name" => "TEST",
		"desc" => "TEST",
		"type" => "info",
		"before" => "footer_logo" );
	
	$extra_options[] = array( "title" => "TEST THIS SHIZIT",
		"desc" => "Please do work",
		"type" => "text",
		"std" => "",
		"before" => "masthead_message" );
	
	$extra_options[] = array( "title" => "Another Test, Again",
		"desc" => "yo",
		"type" => "text",
		"std" => "",
		"after" => "masthead_message" );
	
	$extra_options[] = array( "name" => "Ooh New Tab",
		"type" => "heading",
		"id" => "heading_new",
		"before" => "heading_footer" );
	
	$extra_options[] = array( "title" => "Something",
		"type" => "text",
		"id" => "something_one",
		"after" => "heading_new" );
		
	$extra_options[] = array( "title" => "Something 2",
		"type" => "text",
		"id" => "something_two",
		"after" => "something_one" );
	*/
	
	
	/*======================================================================================
		HEADER
	======================================================================================*/
	
	$extra_options[] = array( "name" => "Header Logo",
		"id" => "masthead_logo",
		"std" => "",
		"type" => "text",
		"after" => "info_header" );
	
	$extra_options[] = array( "name" => "Show/Hide",
		"id" => "info_header_show",
		"desc" => "Check to show or hide features in the header.",
		"type" => "info",
		"after" => "masthead_message" );
	
	$extra_options[] = array( "name" => "Show Search Icon",
		"desc" => "Show search icon that provides search area when hovered.",
		"id" => "show_masthead_search",
		"std" => "",
		"type" => "checkbox",
		"after" => "info_header_show" );
	
	$extra_options[] = array( "name" => "Show Share Icon",
		"desc" => "Show share icon that provides social network sharing options when hovered.",
		"id" => "show_masthead_share",
		"std" => "",
		"type" => "checkbox",
		"after" => "show_masthead_search" );
		
		
	/*======================================================================================
		PAGES
	======================================================================================*/
	
	$extra_options[] = array( "name" => "Pages",
		"id" => "heading_pages",
		"type" => "heading",
		"after" => "show_masthead_share" );
	
	$extra_options[] = array( "name" => "Show/Hide",
		"id" => "info_pages_show",
		"desc" => "Check to show or hide features on pages.",
		"type" => "info",
		"after" => "heading_pages" );
		
	$extra_options[] = array( "name" => "Hide Breadcrumbs",
		"desc" => "Check if you don't want to show page breadcrumbs",
		"id" => "hide_breadcrumbs",
		"std" => "",
		"type" => "checkbox",
		"after" => "info_pages_show" );
	
	$extra_options[] = array( "name" => "Show Sharebar in Tab",
		"desc" => "Show sharebar instead of page link in tab at top of page.",
		"id" => "show_sharebar",
		"std" => "",
		"type" => "checkbox",
		"after" => "hide_breadcrumbs" );
	
	$extra_options[] = array( "name" => "Page Teaser",
		"id" => "info_page_teaser",
		"desc" => "A short descriptive overview or excerpt shown at the top of the page.",
		"type" => "info",
		"after" => "show_sharebar" );
	
	$extra_options[] = array( "name" => "Default Teaser",
		"id" => "default_teaser",
		"desc" => "Enter a default teaser line to be used throughout the site on pages where another teaser isn't supplied.",
		"std" => "",
		"type" => "text",
		"after" => "info_page_teaser" );
	
	$extra_options[] = array( "name" => "Hide Teasers",
		"desc" => "Check if you don't want to display teasers",
		"id" => "hide_teaser",
		"std" => "",
		"type" => "checkbox",
		"after" => "default_teaser" );
		
		
	/*======================================================================================
		POSTS
	======================================================================================*/
	
	$extra_options[] = array( "name" => "Posts",
		"id" => "heading_posts",
		"type" => "heading",
		"after" => "hide_teaser" );
	
	$extra_options[] = array( "name" => "Page Title",
		"id" => "page_title",
		"std" => "",
		"desc" => "Select what appears in the main page title area at the top of the post. If category name and description is selected, the post title will appear in the post content area.",
		"type" => "select",
		"options" => array(
			'title' => 'Post title',
			'category' => 'Category name and description'),
		"after" => "heading_posts" );
	
	$extra_options[] = array( "name" => "Show/Hide",
		"id" => "info_posts_show",
		"desc" => "Check to show or hide features on posts.",
		"type" => "info",
		"after" => "page_title" );
	
	$extra_options[] = array( "name" => "Show Date",
		"id" => "show_post_date",
		"desc" => "Show date posted",
		"std" => "",
		"type" => "checkbox",
		"after" => "info_posts_show" );
	
	$extra_options[] = array( "name" => "Show Author",
		"id" => "show_post_author",
		"desc" => "Show author of post",
		"std" => "",
		"type" => "checkbox",
		"after" => "show_post_date" );
	
	$extra_options[] = array( "name" => "Show Sharebar",
		"id" => "show_post_sharebar",
		"desc" => "Show social network sharebar on posts",
		"std" => "",
		"type" => "checkbox",
		"after" => "show_post_author" );
	
	$extra_options[] = array( "name" => "Show Comments",
		"desc" => "Allow Faceboook comments on posts.",
		"id" => "show_comments",
		"std" => "",
		"type" => "checkbox",
		"after" => "show_post_sharebar" );
	
	$extra_options[] = array( "name" => "Show Related Topics",
		"desc" => "Display tags for current post",
		"id" => "show_tags",
		"std" => "",
		"type" => "checkbox",
		"after" => "show_comments" );
	
	$extra_options[] = array( "name" => "Show Related Posts",
		"desc" => "Display previews of three related posts.",
		"id" => "show_related",
		"std" => "",
		"type" => "checkbox",
		"after" => "show_tags" );
	
	$extra_options[] = array( "name" => "Page Tab",
		"id" => "info_page_tab",
		"desc" => "Choose either a page to link to, or to display a sharebar in the tab at the top of the post. Select nothing to show neither.",
		"type" => "info",
		"after" => "show_related" );
	
	$extra_options[] = array( "name" => "Show Page in Tab",
		"id" => "show_page_post",
		"std" => "",
		"type" => "select",
		"options" => $options_pages,
		"after" => "info_page_tab" );
	
	$extra_options[] = array( "name" => "Tab Page Name",
		"desc" => "Enter name to display if other than the normal page name.",
		"id" => "show_page_post_name",
		"std" => "",
		"type" => "text",
		"after" => "show_page_post" );
	
	$extra_options[] = array( "name" => "Show Sharebar in Tab",
		"desc" => "Show sharebar instead of page link in tab at top of post.",
		"id" => "show_sharebar_post",
		"std" => "",
		"type" => "checkbox",
		"after" => "show_page_post_name" );
	
	
	/*======================================================================================
		ARCHIVES
	======================================================================================*/
	
	$extra_options[] = array( "name" => "Post Archives",
		"id" => "heading_archives",
		"type" => "heading",
		"after" => "show_sharebar_post" );
	
	$extra_options[] = array( "name" => "Show/Hide",
		"id" => "info_archive_show",
		"desc" => "Check to show or hide features on post archives.",
		"type" => "info",
		"after" => "heading_archives" );
		
	$extra_options[] = array( "name" => "Show Date Tab",
		"id" => "show_archive_date_tab",
		"desc" => "Show date tab in archives",
		"std" => "",
		"type" => "checkbox",
		"after" => "info_archive_show" );
	
	$extra_options[] = array( "name" => "Show Date",
		"id" => "show_archive_date",
		"desc" => "Show date in archive post previews",
		"std" => "",
		"type" => "checkbox",
		"after" => "show_archive_date_tab" );
	
	$extra_options[] = array( "name" => "Show Author",
		"id" => "show_archive_author",
		"desc" => "Show author in archive post previews",
		"std" => "",
		"type" => "checkbox",
		"after" => "show_archive_date" );
	
	$extra_options[] = array( "name" => "Show Category",
		"id" => "show_archive_category",
		"desc" => "Show category in archive post previews",
		"std" => "",
		"type" => "checkbox",
		"after" => "show_archive_author" );
	
	$extra_options[] = array( "name" => "Page Tab",
		"id" => "info_archive_page_tab",
		"desc" => "Choose either a page to link to, or to display a sharebar in the tab at the top of the page. Select nothing to show neither.",
		"type" => "info",
		"after" => "show_archive_category" );
	
	$extra_options[] = array( "name" => "Show Page in Tab",
		"id" => "show_page_archive",
		"std" => "",
		"type" => "select",
		"options" => $options_pages,
		"after" => "info_archive_page_tab" );
	
	$extra_options[] = array( "name" => "Show Sharebar in Tab",
		"desc" => "Show sharebar instead of page link in tab at top of page.",
		"id" => "show_sharebar_archive",
		"std" => "",
		"type" => "checkbox",
		"after" => "show_page_archive" );
	
	$extra_options[] = array( "name" => "Blog Leadout",
		"id" => "info_archive_leadout",
		"desc" => "Add information to be shown on leadout tab at the bottom of blog posts and archive.",
		"type" => "info",
		"after" => "show_sharebar_archive" );
	
	$extra_options[] = array( "name" => "Show Blog Leadout",
		"id" => "show_blog_leadout",
		"desc" => "Show leadout tab (if checked, enter leadout details below)",
		"std" => "",
		"type" => "checkbox",
		"after" => "info_archive_leadout" );
	
	$extra_options[] = array( "name" => "Headline",
		"id" => "blog_leadout_headline",
		"desc" => "Optional headline shown above leadout tab.",
		"std" => "",
		"type" => "text",
		"after" => "show_blog_leadout" );
	
	$extra_options[] = array( "name" => "CTA",
		"id" => "blog_leadout_cta",
		"desc" => "CTA shown before page name; for example. \"Continue to\" or \"Click here to.\"",
		"std" => "",
		"type" => "text",
		"after" => "blog_leadout_headline" );
	
	$extra_options[] = array( "name" => "Page to Link To",
		"id" => "blog_leadout_link",
		"std" => "",
		"type" => "select",
		"options" => $options_pages,
		"after" => "blog_leadout_cta" );
	
	$extra_options[] = array( "name" => "Page Name",
		"id" => "blog_leadout_title",
		"desc" => "The page name to be shown on the leadout tab if other than the page's title.",
		"std" => "",
		"type" => "text",
		"after" => "blog_leadout_link" );
	
	$extra_options[] = array( "name" => "Copy",
		"id" => "blog_leadout_copy",
		"desc" => "Optional copy to be shown beside the leadout tab.",
		"std" => "",
		"type" => "textarea",
		"after" => "blog_leadout_title" );
	
	
	/*======================================================================================
		PHOTO GALLERY / LOCATIONS
	======================================================================================*/
	
	$extra_options[] = array( "name" => "Gallery / Locations",
		"id" => "heading_gallery",
		"type" => "heading",
		"after" => "blog_leadout_copy" );
	
	$extra_options[] = array( "title" => "Gallery Photos",
		"id" => "gallery_single",
		"std" => "",
		"type" => "select",
		"options" => array(
			'photo' => 'Show just the photo with caption',
			'full-info' => 'Show the photo post with full description and gallery info'),
		"after" => "heading_gallery" );
	
	$extra_options[] = array( "title" => "Locations Layout",
		"id" => "locations_thumb",
		"std" => "",
		"type" => "select",
		"options" => $options_locations = array(
			'half' => 'Show half-width photo beside location info',
			'full' => 'Show fullsize photo with location info beneath'
		),
		"after" => "gallery_single" );
	
	
	/*======================================================================================
		FOOTER
	======================================================================================*/
	
	$extra_options[] = array( "name" => "Show Footer Navigation",
		"id" => "show_footer_nav",
		"desc" => "Show footer navigation menu in footer toolbar.",
		"std" => "",
		"type" => "checkbox",
		"after" => "heading_footer" );
	
	
	/*======================================================================================
		SYNDICATION
	======================================================================================*/
	
	$extra_options[] = array( "name" => "Syndication",
		"id" => "heading_syndication",
		"type" => "heading",
		"superadmin" => true,
		"after" => "footer_copyright" );

	$extra_options[] = array( "name" => "Syndication",
		"id" => "info_syndication",
		"desc" => "Syndication features - BETA.",
		"type" => "info",
		"after" => "heading_syndication" );
	
	$extra_options[] = array( "name" => "Turn On Syndication",
		"id" => "syndication_on",
		"desc" => "Turn on source post syndication, vendor pages, and campaign landing pages.",
		"type" => "checkbox",
		"after" => "info_syndication" );
	
	$extra_options[] = array( "title" => "Vendor Subscriptions",
		"id" => "vendors_subscribed",
		"desc" => "Check the vendors whose content you want to show on your site.",
		"std" => "",
		"type" => "multicheck",
		"options" => array(
			"crestron" => "Crestron",
			"lutron" => "Lutron",
			"integra" => "Integra" ),
		"after" => "syndication_on" );
	
	$extra_options[] = array( "title" => "Source Author",
		"id" => "source_author",
		"desc" => "Your author name on The Source, to bring in posts you selected to reblog.",
		"std" => "",
		"type" => "text",
		"after" => "vendors_subscribed" );
	
	$extra_options[] = array( "title" => "Campaign HQ Author",
		"id" => "source_author_name",
		"std" => "",
		"type" => "text",
		"desc" => "Your author name in Campaign Headquarters, to bring in campaign landing pages.",
		"after" => "source_author" );
	
	
	return $extra_options;
}