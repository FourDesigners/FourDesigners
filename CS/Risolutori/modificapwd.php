<?php
session_start();
require_once ("../common/connessione.php");
require_once ("auth.php");

$campoFine = 'dataFine';
$colonna = "</td><td>";
?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <title>Modifica Password - Risolutori</title>
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
    <body class='accesso risolutor'>
        <div class="corpo">
            <?php include("menu.php") ?>
            <div class="contenitore">            
                <?php if ($_SESSION[$sruolo] == 2 || $_SESSION[$sruolo] == 3) { ?>
                    <div class="contenitoreTab">
                        <div class="tab">
                            <button class="tablinks active">MODIFICA PASSWORD</button>                    
                        </div>
                        <div id="login" class="tabcontent">     
                            <label>Vecchia password: 
                                <input type="password" id="vpassword" name="vpassword">
                            </label>
                            <label>Nuova password: 
                                <input type="password"  name="npassword" id="npassword">
                            </label>

                            <label>Conferma nuova password: 
                                <input type="password" name="cnpassword" id="cnpassword">
                            </label>


                            <input id="btnModifica" class="btn-fullBlue" type="button" value="Modifica" onclick="modifica()"> 
                            <p id="demo"></p>
                        </div>
                    </div>
                <?php } else { ?>
                <h2>
                    Non hai i permessi per visualizzare questa pagina
                </h2>
                <?php } ?>
            </div>
        </div>


        <?php include("footer.php") ?>
        <script src="./js/modificapwd.js" type="text/javascript"></script>
        <script>
                            invioSubmit("CDT", "btnCDT");
                            invioSubmit("vpassword", "btnModifica");
                            invioSubmit("npassword", "btnModifica");
                            invioSubmit("cnpassword", "btnModifica");
        </script>

    </body>
</html>
