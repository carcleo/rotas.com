<h1>Cadastrar Administrador</h1>
<?php echo response(); echo missingFields();  ?>

<form action="<?php echo route("admin.store");?>" method="POST">

    <?php echo encrypt(); ?> 
    <input type="hidden" name="datetime" value="<?php echo (new DateTime())->format("Y-m-d H:m:s"); ?>">

    <select name="privilege" id="privilege" required>
        <option value="Super">Super Administrador</option>
        <option value="Comum">Administrador Comun</option>
    </select> <br>    
    <input type="text" name="name" id="name"  placeholder="Nome" required value="<?php echo field("name"); ?>"><br>
    <input type="text" name="login" id="login"  placeholder="Login"  maxlength="8" required value="<?php echo field("login"); ?>"><br>
    <input type="password" name="password" id="password"  placeholder="Senha"  maxlength="8" required value="<?php echo field("password"); ?>"><br>
    <select name="bloq" id="bloq" required>
        <option value="Não">Não</option>
        <option value="Sim">Sim</option>
    </select> <br>
    
    <input type="submit" value="Cadastrar">

</form>