<?php
session_start();
require_once ("../common/connessione.php");
require_once ("auth.php");

$ruolo = $_SESSION['SESS_RUOLO'];
$citta = $_SESSION['SESS_CITTA'];
?>
<!DOCTYPE html>
<html lang="it">

    <head>
        <title>Crea Gruppo - Risolutori</title>
        <meta http-equiv="Content-Type"
              content="multipart/form-data;charset=ISO-8859-1" />
        <meta name="viewport" content="width=device-width, maximum-scale=1">
        <link rel="stylesheet"
              href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/style.css">
        <script
        src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script
        src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
        <script
        src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
        <script src="../common/commonJavascript.js" type="text/javascript"></script>
        <link rel="icon" href="favicon.ico">

    </head>
    <body class="risolutor">
        <div class="corpo">
            <?php include("menu.php") ?>
            <?php if ($_SESSION[$sruolo] == 2) { ?>
                <div class="contenitoreTab">
                    <div class="tab ">                    
                        <button class="tablinks active">CREA GRUPPO</button>
                    </div>
                    <div class="tabcontent">
                        <label>Email gruppo: 
                            <input type="text" placeholder="Email" id="emailgruppo" name="emailgruppo">
                        </label>
                        <label>Descrizione gruppo: 
                            <input type="text" maxlength="20" placeholder="Descrizione" id="descrizionegruppo" name="descrizionegruppo">
                        </label>
                        <label>Tipologia: 
                            <select id="tipologia">
                                <option value='Acqua'>Acqua</option>
                                <option value='Luce'>Luce</option>
                                <option value='Spazzatura'>Spazzatura</option>
                                <option value='Urbano'>Urbano</option>
                            </select>
                        </label>
                        <label>Password:
                            <input type="password" placeholder="Password"
                                   name="passwordgruppo" id="passwordgruppo">
                        </label>
                        <label>Conferma password: 
                            <input type="password" placeholder="Conferma password"
                                   name="cpasswordgruppo" id="cpasswordgruppo">
                        </label>

                        <input id="btnCrea" class="btn-green" type="button" value="Conferma" onclick="creagruppo()"> 


                        <p id="risultato"></p>


                    </div>
                </div>
            <?php } else { ?>
                <h2>
                    Non hai i permessi per visualizzare questa pagina
                </h2>
            <?php } ?>
        </div>

        <?php include("footer.php") ?>
        <script src="./js/creaGruppo.js" type="text/javascript"></script>
    </body>
</html>
