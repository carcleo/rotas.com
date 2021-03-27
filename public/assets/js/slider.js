$(document).ready(function(){
	  
	container = $("div.slider div.container");
	containerWidth = $(container).width();
	ul = $("div.slider div.container ul");
	left = 0;
	lis = $("div.slider div.container ul li");
	label = $(container).find("label");
	back = $(container).find("button#back");
	front = $(container).find("button#front");	

	back.on("click", function() {
				
		label.css("opacity", 0);
				
		//ul.addClass("ulToLeft").removeClass("ulToRight");

		left += containerWidth;
		
		if ( Math.round(left) >= containerWidth ) {
		   left = ( ( lis.length - 1 ) * -containerWidth ) + container.offset().left;
		}
		
		ul.offset({left:Math.round(left)});	
		
	})

	front.on("click", function() {
		
		label.css("opacity", 0);
				
		//ul.addClass("ulToRight").removeClass("ulToLeft");
		
		left -= containerWidth;
		
		if ( Math.round(left) <= -((lis.length - 1) * containerWidth) ) {
		   left = container.offset().left;
		}
		
		ul.offset({left:Math.round(left)});
		
	})

	front.trigger( "click" );

	function intervalo () {
		front.trigger( "click" );
	}

	var interval = setInterval(intervalo,4000);

	$(container).on("mouseover", function(){
		clearInterval(interval);
		label.css("opacity", 1);
	}).mouseout(function(){	
		label.css("opacity", 0);
		interval = setInterval(intervalo,4000);
	});
	
	
})