<h1>Contatos</h1>
<?php

if (is_null($contacts)) {

    echo "Sem contatos pra mostrar";

} else {
    
    echo "<ul>";

    foreach($contacts as $contact) {
        echo "<li>" . $contact["name"] . "</li>
              <li> <label>" . telFormat($contact["tel"]) . "</label><br>
              <li>" . $contact["email"] . "</li>
              <li><a href='" . route("admin.contact.show", [ $contact["id"] ]) . "'><img class='btn-list' src='" . assets("imgs/eye.jpg") . "'></a></li>
              <li>
                <form action='" . route("admin.contact.delete") . "' method='POST'>
                    <input type='hidden' name='method' value='DELETE'>
                    <input type='hidden' name='id' value='" . $contact["id"] . "'>
                    <input type='submit' value='' class='btn-list btn-delete'>
                </form>
               </li>";
    }

    echo "</ul>";

}
?>