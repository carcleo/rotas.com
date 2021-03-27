$('.prlx').each(function() {
	
    var obj = $(this);
	
    obj.css('background-position', '50% 0');
    obj.css('background-attachment', 'fixed');
    
	$(window).scroll(function() {
		
		var offset = obj.offset();
		var yPos = -($(window).scrollTop() - offset.top) / 10;
		var bgpos = obj.css('background-position-x') + ' ' + yPos + 'px';
		obj.css('background-position', bgpos);
		
	});
	
});