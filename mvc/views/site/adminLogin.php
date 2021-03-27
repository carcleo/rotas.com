<section id="adminLogin" class="midiArea">
    
    <h1>Login Administrador</h1>

    <?php echo response(); echo missingFields();  ?>

    <form action="<?php echo route("admin.logon");?>" method="POST">

        <?php echo encrypt(); ?>
        
        <input type="text" name="login" placeholder="Usuário">
    
        <input type="password" name="password" placeholder="Senha">
    
        <input type="submit" value="Entrar">

    </form>

    <div>
        <label>Não tem conta ainda?</label>
        <label>Contate o Super Administrador!
    </div>

</section>