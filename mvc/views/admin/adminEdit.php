<h1>Editar  Administrador</h1>
<?php echo response(); echo missingFields();  ?>

<form action="<?php echo route("admin.update");?>" method="POST">

    <?php $bloq =  $admin['bloq'] === "bloq" ? "Bloqeado": "Desbloqeado"; ?>

    <?php echo encrypt(); ?> 
    <input type="hidden" name="method" id="method" required value="PUT">
    
    <input type="hidden" name="id" id="id" required value="<?php echo $admin["id"]; ?>">
    <input type="hidden" name="datetime" value="<?php echo $admin["datetime"]; ?>">
    
    <input type="hidden" name="oldLogin" value="<?php echo $admin["login"]; ?>">
    <input type="hidden" name="oldName" value="<?php echo $admin["name"]; ?>">

    <?php        
        $sc = !is_null(field('privilege')) ? field('privilege') : $admin['privilege'];

        if ($privilege==="Super") {         
            echo "
                <select name='privilege' id='privilege' required>
                    <option value='" . $sc . "'>
                                       " . ($sc === "Super" 
                                             ? "Super Administrador" 
                                             : "Administrador Comun" )
                                             .  "</option>
                    <option value='Super'>Super Administrador</option>
                    <option value='Comum'>Administrador Comun</option>
                </select> <br>"; 
        } else {
            echo "<input type='hidden' name='privilege' value='" . $privilege . "'><br>";
            $sc = $sc === "Super" ? "Super Administrador" : "Administrador Comun" ;
            echo "<label>" . $sc. "</label><br>";
        }  
        
    ?>
    
    <input type="text" name="name" id="name"  placeholder="Nome" required value="<?php echo !is_null(field('name')) ? field('name') : $admin['name']; ?>"><br>
    <input type="text" name="login" id="login"  placeholder="Login"  required maxlength="8" value="<?php echo !is_null(field('login')) ? field('login') : $admin['login']; ?>"><br>
    <input type="password" name="password" id="password"  placeholder="Senha" required  maxlength="8" value="<?php echo !is_null(field('password')) ? field('password') : $admin['password']; ?>"><br>
    <select name="bloq" id="bloq" required>
        <option value="<?php echo $admin['bloq']; ?>"><?php echo $bloq; ?></option>
        <option value="Não">Não</option>
        <option value="Sim">Sim</option>
    </select> <br>
    
    <input type="submit" value="Alterar">

</form>