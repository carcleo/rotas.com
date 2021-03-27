<div class="contact">
    <h1>Contato</h1>
    <div>
        <div>
            <?php echo response(); echo missingFields(); ?>
            <form action="<?php echo route("contact.store");?>" method="POST">
                
                <?php echo encrypt(); ?>
                <input type="hidden" name="datetime" value="<?php echo date('Y/m/d H:m:s'); ?>">
                
                <input type="text" name="name" id="name"  placeholder="Nome" required value="<?php echo field("name"); ?>">
                <input type="tel" name="tel" id="tel"  placeholder="Telefone" value="<?php echo field("tel"); ?>">
                <input type="email" name="email" id="email"  placeholder="e-mail" required value="<?php echo field("email"); ?>">
                <input type="text" name="subject" id="subject"  placeholder="Assunto" required value="<?php echo field("subject"); ?>">
                <textarea name="message" id="message"  placeholder="Mensagem" required><?php echo nl2br(field("message")); ?></textarea>
                
                <input type="submit" value="Enviar">

            </form>
        </div>

        <div>
            <?php 
                echo "<label>Endereço: Rua 
                    " . $addressSite["rua"] . ", nº: 
                    " . $addressSite["numero"] .  "
                    " . $addressSite["bairro"] . "
                    " . $addressSite["cidade"] . "/
                    " . $addressSite["estado"] . " CEP: 
                    " . zipFormat($addressSite["cep"]);
                echo "Tel e WhatsApp <a 
                                         target='blank' href='https://api.whatsapp.com/send?phone=55" . $tel . "'>
                                           " . telFormat($tel) . "
                                      </a>
                        </label>";
            ?>
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m26!1m12!1m3!1d7442.506632274538!2d-42.36902057582798!3d-21.14231494374782!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m11!3e6!4m3!3m2!1d-21.1400892!2d-42.3582306!4m5!1s0xbcc6fed0fa3d73%3A0xd86681b01384ba13!2srotas.come%20Prensas%20-%20R.%20Irineu%20Felisberto%2C%2024%20-%20Jo%C3%A3o%20XXIII%2C%20Muria%C3%A9%20-%20MG%2C%2036880-000!3m2!1d-21.1441953!2d-42.3710558!5e0!3m2!1spt-BR!2sbr!4v1609243175012!5m2!1spt-BR!2sbr" 
                style="width:95%; height:300px; margin:0 auto;" 
                frameborder="0" 
                style="border:0" 
                allowfullscreen>
            </iframe>
        </div>
    </div>
</div>