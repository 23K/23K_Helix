(function() {
	tinymce.PluginManager.add('helix', function(editor, url) {
		editor.addButton('helix', {
			title : 'Helix Shortcodes',
			text : '',
			icon : '" style="background-image: url(\'' + url + '/_img/helix-btn.png\');',
			type : 'menubutton',
			menu : [
				{
					text : 'Leadout',
					onclick : function() {
						editor.windowManager.open({
							title : 'Leadout Shortcode',
							width : 490,
							height : 350,
							body : [
								{ type : 'textbox', name : 'thecta', label : 'CTA' },
								{ type : 'textbox', name : 'thelink', label : 'Link' },
								{ type : 'textbox', name : 'thecontent', label : 'Content', 'multiline' : true, minHeight : 75 },
								{ type : 'container', html : '<img src="/wp-content/plugins/23K_Helix/_functions/_tinymce/_img/shortcode-leadout.jpg" width="445" height="112" style="margin-top: 20px;" />' }
							],
							onsubmit : function(e) {
								var output = '[leadout cta="' + e.data.thecta + '" link="' + e.data.thelink + '"]' + e.data.thecontent + '[/leadout]<br />';
								
								editor.insertContent(output);
							}
						})
					}
				},
				{
					text : 'Featured Post',
					onclick : function() {
						editor.windowManager.open({
							title : 'Featured Post Shortcode',
							width : 490,
							height : 280,
							body : [
								{ type : 'textbox', name : 'postid', label : 'Post ID' },
								{ type : 'checkbox', name : 'isfullwidth', label : 'Fullwidth page?' },
								{ type : 'container', html : '<img src="/wp-content/plugins/23K_Helix/_functions/_tinymce/_img/shortcode-featured-post.jpg" width="445" height="145" style="margin-top: 20px;" />' }
							],
							onsubmit : function(e) {
								var output = '[featured_post id="' + e.data.postid + '"';
					
								if ( e.data.isfullwidth == true ) {
									output += ' fullwidth="true"';
								}
								
								output += ']<br />';
								
								editor.insertContent(output);
							}
						})
					}
				},
				{
					text : 'Gallery Preview',
					onclick : function() {
						editor.windowManager.open({
							title : 'Gallery Preview Shortcode',
							width : 490,
							height : 375,
							body : [
								{ type : 'textbox', name : 'slug', label : 'Slug' },
								{ type : 'container', html : '<p style="font-size: 12px;">Find your slug under Gallery Photos > Galleries</p>' },
								{ type : 'textbox', name : 'title', label : 'Title' },
								{ type : 'container', html : '<p style="font-size: 12px;">Optional - default is "From our -Gallery Name- Gallery"</p><img src="/wp-content/plugins/23K_Helix/_functions/_tinymce/_img/shortcode-gallery-preview.jpg" width="334" height="195" style="margin-top: 20px;" />' },
								
							],
							onsubmit : function(e) {
								var output = '[gallery_preview slug="' + e.data.slug + '"';
								
								if ( e.data.title ) {
									output += ' title="' + e.data.title + '"';
								}
								
								output += ']<br />';
								
								editor.insertContent(output);
							}
						})
					}
				},
				{
					text : 'Google Map',
					onclick : function() {
						editor.windowManager.open({
							title : 'Google Map Shortcode',
							width : 490,
							height : 375,
							body : [
								{ type : 'textbox', name : 'address', label : 'Address' },
								{ type : 'textbox', name : 'width', label : 'Width' },
								{ type : 'textbox', name : 'height', label : 'Height' },
								{ type : 'container', html : '<img src="/wp-content/plugins/23K_Helix/_functions/_tinymce/_img/shortcode-map.jpg" width="334" height="195" style="margin-top: 20px;" />' },
								
							],
							onsubmit : function(e) {
								var output = '[google_map address="' + e.data.address + '" width="' + e.data.width + '" height="' + e.data.height + '"]<br />';
								
								editor.insertContent(output);
							}
						})
					}
				},
				{
					text : 'Dividers',
					onclick : function() {
						editor.windowManager.open({
							title : 'Divider Shortcodes',
							width : 490,
							height : 300,
							body : [
								{ type : 'listbox', name : 'type', label : 'Divider Type', values : [
									{ text : 'Plain', value : 'plain' },
									{ text : 'Post divider', value : 'post' },
									{ text : 'Divider with top link', value : 'top' }
								] },
								{ type : 'container', html : '<p style="margin-top: 40px;">Plain</p><div style="width: 100%; position: relative; display: block; clear: both; border-bottom: 1px solid #999; margin: 10px 0 20px 0;"></div><p>Post divider</p><div style="width: 100%; position: relative; display: block; clear: both; height: 8px; margin-bottom: 20px; background: url(\'/wp-content/plugins/23K_Helix/_img/divider-blog.png\') repeat-x 0 0; margin-top: 10px;"></div><p>Divider with top link</p><div style="width: 95%; position: relative; display: block; clear: both; border-bottom: 1px solid #999; margin: 10px 0 20px 0;"><a href="#" style="position: absolute; top: -3px; right: -25px; color: #555; font-size: 11px; font-family: Arial, Helvetica, sans-serif; cursor: pointer;" onclick="return false;"> top ^</a></div><br /><br />' },
							],
							onsubmit : function(e) {
								if ( e.data.type == 'plain' ) {
									var output = '[divider]<br />';
								} else if ( e.data.type == 'post' ) {
									var output = '[postdivider]<br />';
								} else if ( e.data.type == 'top' ) {
									var output = '[divider_top]<br />';
								}
								
								editor.insertContent(output);
							}
						})
					}
				}
			]
		});
	});
})();