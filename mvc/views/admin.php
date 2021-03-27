<html>
    <head>

        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title><?php echo title() . ' Administração'; ?></title>

        <link type="image/x-png" rel="shortcut icon" href="<?php echo assets("imgs/favicon.ico"); ?>">
        
        <link type="text/css" rel="stylesheet" href="<?php echo  assets("css/resset.css");?>">
        <link type="text/css" rel="stylesheet" href="<?php echo  assets("css/menu.css");?>">     
        <link type="text/css" rel="stylesheet" href="<?php echo  assets("css/root.css");?>">     

        <?php if ( isset($css) ) echo $css; ?>

        <script src='<?php echo  assets("js/jquery.js");?>'></script>
        <script src='<?php echo  assets("js/midiArea.js");?>'></script>

    </head>

    <body>

        <?php echo $menuAdmin; ?>

        <section class="main">

            <?php loadView($viewName, $viewData); ?>

        </section>
        
        <div class='loading'>
            <img src='<?php echo assets("/imgs/loading.gif"); ?>'>
        </div>	

        <?php if ( isset($js) ) echo $js; ?>

    </body>

<html>