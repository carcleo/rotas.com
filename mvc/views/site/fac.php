<script>
  function abrir(campo) {
	  $('#'+campo+ ' div').css('display','block');
  }
  function fechar(campo) {
	  $('#'+campo+ ' div').css('display','none');
  }
</script>

<h2>Dúvidas Frequentes</h1>

<ul class="duvidasFrequentes">

  <li id="d1">
     <img src="<?php echo assets("imgs/checked.png"); ?>" onClick="abrir($(this).parent().attr('id'))" />
     Dúvida 1
     <div>
        <img class="btnFechar" src="<?php echo assets("imgs/btn-close.png"); ?>" onClick="fechar($(this).parent().parent().attr('id'))" /><br />
     Tirando a Dúvida 1
     </div>
  </li>

  <li id="d2">
     <img src="<?php echo assets("imgs/checked.png"); ?>" onClick="abrir($(this).parent().attr('id'))" />
     Dúvida 2
     <div>
        <img class="btnFechar" src="<?php echo assets("imgs/btn-close.png"); ?>" onClick="fechar($(this).parent().parent().attr('id'))" /><br />
     Tirando a Dúvida 2
     </div>
  </li>