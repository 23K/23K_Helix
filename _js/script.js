$(document).ready(function() {
	
	$('a.galleries').fancybox({
		openEffect	:	'elastic',
		closeEffect	:	'elastic',
		type : 'iframe',
		autoSize : false,
		beforeLoad : function() {
			this.width = parseInt(this.element.data('fancybox-width'));
			this.height = parseInt(this.element.data('fancybox-height'));
		},
		scrolling : 'no',
		padding : '0'
	});
	
	$('a.fancy-img').fancybox({
		openEffect	:	'elastic',
		closeEffect	:	'elastic',
		type : 'image',
		autoDimensions : true,
		helpers : {
			title: null
		},
		scrolling : 'no',
		padding : '0'
	});
	
	
	search_hover();
	share_hover();
	gallery_hover();
	scroll_top();
	
});



function search_hover() {
	var searchTimer;
	
	$('div#masthead-search').hover(function() {
		$('div#search').show();
		clearTimeout(searchTimer);
	}, function() {
		searchTimer = setTimeout(function() {
			$('div#search').hide();
		}, 600);
	});
}


function share_hover() {
	var shareTimer;
	
	$('div#masthead-share').hover(function() {
		$('div#share').show();
		clearTimeout(shareTimer);
	}, function() {
		shareTimer = setTimeout(function() {
			$('div#share').hide();
		}, 600);
	});
}


function gallery_hover() {
	$('ul#post-photo-gallery li').hover(function() {
		$(this).find('div.gallery-hover').show();
	}, function() {
		$(this).find('div.gallery-hover').hide();
	});
}


function scroll_top() {
	$('div.divider.top a').click(function() {
		$('html, body').animate({scrollTop: 0}, 300);
		
		return false;
	});
}


function start_gallery_preview_slide(speed) {
	$(document).ready(function() {
		var i = 0;
		var preview = $('div.sliding-container div.gallery-preview');
		var fullwidth = preview.width() + parseInt(preview.css('margin-right')) + parseInt(preview.css('margin-left')) + parseInt(preview.css('padding-right')) + parseInt(preview.css('padding-left')) + parseInt(preview.css('border-left-width')) + parseInt(preview.css('border-right-width'));
		
		if ( ! speed ) speed = 2500;
		
		preview.each(function() {
			$(this).css('left', i);
			
			i += fullwidth;
			
			gallery_preview_slide($(this), speed);
		});
	});
}


function gallery_preview_slide($this, speed) {
	var preview = $('div.sliding-container div.gallery-preview');
	var fullwidth = preview.width() + parseInt(preview.css('margin-right')) + parseInt(preview.css('margin-left')) + parseInt(preview.css('padding-right')) + parseInt(preview.css('padding-left')) + parseInt(preview.css('border-left-width')) + parseInt(preview.css('border-right-width'));
	
	var left = parseInt($this.css('left'));
	var temp = -1 * fullwidth;
	
	if ( left < temp ) {
		left = $('div.sliding-container').width();
		
		$this.css('left', left);
	}
	
	$this.animate({ left: '-=' + fullwidth }, speed, 'linear', function() {
		gallery_preview_slide($(this), speed);
	});
}