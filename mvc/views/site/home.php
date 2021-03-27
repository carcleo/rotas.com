<div class="slider">
   
   <div class="container">
   
	   <label>Pausado</label>
		
	   <button id="back"><</button>
	   
	   <ul> 
		
		  <li>
			<span>Descrição 1</span>
       		<img src='<?php echo assets('imgs/slider/1.jpg'); ?>'>
		  </li> 
		
		  <li>
			<span>Descrição 2</span>
        	<img src='<?php echo assets('imgs/slider/2.jpg'); ?>'>
		  </li> 
		
		  <li>
			<span>Descrição 3</span>
        	<img src='<?php echo assets('imgs/slider/3.jpeg'); ?>'>
		  </li> 
		
		  <li>
			<span>Descrição 4</span>
     	    <img src='<?php echo assets('imgs/slider/4.jpeg'); ?>'>
		  </li> 
		
		  <li>
			<span>Descrição 5</span>
      	    <img src='<?php echo assets('imgs/slider/5.png'); ?>'>
		  </li> 
		  
	   </ul>
	   
	   <button id="front">></button>
   
   </div>
   
	
</div>

<div id="detalhes" class="prlx"></div>

<div id="contato" class="prlx"></div>

<script>

	function isScrolledIntoView(elem){
		var docViewTop = $(window).scrollTop();
		var docViewBottom = docViewTop + $(window).height();
		var elemTop = $(elem).offset().top;		
		var elemBottom = elemTop + $(elem).height();

		return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
	}

	$(window).on('scroll', function(){
		
		if(isScrolledIntoView('div#promo > div.texto')){
			console.log("aqui");
			$('div#promo > div.texto').addClass('leftToRight');
		} else {
			console.log("NÃO");
			$('div#promo > div.texto').removeClass('leftToRight');
		}
	});

</script>