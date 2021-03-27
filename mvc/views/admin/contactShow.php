<?php

    echo "<h1>Contato</h1>
          <label>" . dateFormat($contact["datetime"]) . "</label><br>
          <label>" . $contact["name"] . "</label><br>
          <label>" . telFormat($contact["tel"]) . "</label><br>
          <label>" . $contact["email"] . "</label><br>
          <label>" . $contact["subject"] . "</label><br>
          <label>" . nl2br($contact["message"]) . "</label><br>";

?>