jQuery(document).ready(function($) {
	var bbList = $('#billboards-list');
			
	bbList.sortable({
		update: function(event, ui) {
			$('#loading-animation').show();
			
			opts = {
				url: ajaxurl,
				type: 'POST',
				async: true,
				cache: false,
				dataType: 'json',
				data:{
					action: 'billboards_sort',
					order: bbList.sortable('toArray').toString()
				},
				success: function(response) {
					$('#loading-animation').hide();
					return; 
				},
				error: function(xhr,textStatus,e) { 
					alert('There was an error saving the updates');
					$('#loading-animation').hide();
					return; 
				}
			};
			$.ajax(opts);
		}
	});
	
	var locList = $('#locations-list');
			
	locList.sortable({
		update: function(event, ui) {
			$('#loading-animation').show();
			
			opts = {
				url: ajaxurl,
				type: 'POST',
				async: true,
				cache: false,
				dataType: 'json',
				data:{
					action: 'locations_sort',
					order: locList.sortable('toArray').toString()
				},
				success: function(response) {
					$('#loading-animation').hide();
					return; 
				},
				error: function(xhr,textStatus,e) { 
					alert('There was an error saving the updates');
					$('#loading-animation').hide();
					return; 
				}
			};
			$.ajax(opts);
		}
	});
});