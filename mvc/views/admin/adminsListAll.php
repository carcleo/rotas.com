<h1>Administradores</h1>
<?php

    if (is_null($admins)) {

        echo "<h1 class='erro'>Sem Adminsitradores pra mostrar</h1>";

    } else {
        
        echo "<div>";
        
        foreach($admins as $admin) {       
        
                $imgBlockDesbloq = $admin["bloq"] === "Sim"
                                   ? assets("imgs/desbloq.png")
                                   : assets("imgs/bloq.png"); 
            
                echo "<ul>
                        <li>" . $admin["name"] . "</li>
                        <li><button 
                                class='bloq btn-list' 
                                data-bloq= '" . route("admin.bloq",[$admin["id"]]) . "'
                                id='" . $admin["id"] . "'
                                style='background: url(" . $imgBlockDesbloq . "); background-size: cover;'>
                            </button>
                        </li>
                        <li><a href='" . route("admin.edit",[ $admin["id"] ]) . "'>Editar</a></li>
                        <li>
                                <form action='" . route("admin.delete") . "' method='POST'>
                                    <input type='hidden' name='method' value='DELETE'>
                                    <input type='hidden' name='id' value='" . $admin["id"] . "'>
                                    <input type='submit' value='' class='btn-list btn-delete'>
                                </form>
                        </li>
                    </ul>";
        }

        echo "</div>";

    }
?>