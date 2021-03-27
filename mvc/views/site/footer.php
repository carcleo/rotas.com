<h1>Mapa do Site</h1>

<div>

    <?php echo $ulMenu; ?>

    <ul>
        <li><h2>Site</h2></li>
        <li><a href="<?php echo route("web.home"); ?>">Home</a></li>
        <li><a href="<?php echo route("contact.create"); ?>">Contatos</a></li>
        <li><a href="<?php echo route("home.fac"); ?>">Fac</a></li>
        <li><a href="<?php echo route("home.about"); ?>">Sobre</a></li>
    </ul>


    <ul>
        <li>
            <a href='https://www.facebook.com/rotas.com' target='_blank'>
                <img src='<?php echo assets('imgs/face.png'); ?>'>
            </a>
        </li>      
        <li>
            <a target='blank' href='https://api.whatsapp.com/send?1=pt_BR&phone=5532988225915'>
                <img src='<?php echo assets("imgs/whatsapp.png"); ?>'>
            </a> 
        </li>   
    </ul>   

</div>