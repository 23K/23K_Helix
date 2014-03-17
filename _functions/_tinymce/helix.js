(function() {
	tinymce.create('tinymce.plugins.helix', {
		init : function(ed, url) {
			ed.addCommand('mcehelix', function() {
				ed.windowManager.open({
					file : url + '/helix-popup.html',
					width : 500 + ed.getLang('helix.delta_width', 0),
					height : 460 + ed.getLang('helix.delta_height', 0),
					inline : 1
				}, {
					plugin_url : url
				});
			});
			ed.addButton('helix', {
				title : 'Helix Shortcodes',
				cmd: 'mcehelix',
				image : url + '/_img/helix-btn.png',
			});
		},
		createControl : function(n, cm) {
			return null;
    },
  });
  tinymce.PluginManager.add('helix', tinymce.plugins.helix);
})();