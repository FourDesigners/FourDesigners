<?php
session_start();
require_once ("../common/connessione.php");
require_once ("auth.php");

$ente = $_SESSION['SESS_EMAIL'];

$checked = 'checked';

$query = "select * from Risolutore where email='" . $ente . "'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);
$img = $row['immagine'];
?>
<!DOCTYPE html>
<html lang="it">

    <head>
        <title>Crea Gruppo - Risolutori</title>
        <meta http-equiv="Content-Type"  content="multipart/form-data;charset=ISO-8859-1" />
        <meta name="viewport" content="width=device-width, maximum-scale=1">
        <link rel="stylesheet"  href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/style.css"><script  src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
        <script src="../common/commonJavascript.js" type="text/javascript"></script>

        <link rel="icon" href="favicon.ico">
    </head>
    <body class='statistiche risolutor'>
        <div class="corpo">
            <?php include("menu.php") ?>
            <?php if ($_SESSION[$sruolo] == 2) { ?>

                <div class="contenitoreTab">
                    <div class="tab">                    
                        <button class="tablinks active">GESTIONE PAGINA INFORMATIVA</button>
                    </div>

                    <div id='citta' style="width: 100%">
                        <form action="modificaInformazioni.php" method="post" onsubmit="return verificaInfo()" enctype="multipart/form-data">
                            <div class="row">
                                <?php if ($img && file_exists("foto/" . $img)): ?>
                                    <div class="col-md-3">
                                        <img style="max-width:300px;max-height:200px;margin-top: 20px;" src="foto/<?= $img ?>" >
                                    </div>
                                    <script>
                                        document.getElementById("sezConferma").style = "margin-left:0px;";
                                    </script>
                                <?php endif; ?>

                                <div class="col-md-5 contTabella" >
                                    <table style="margin-bottom: 0px; margin-top: 30px;">
                                        <tr>
                                            <td>Recapito telefonico</td>
                                            <td><input type="text" id="telefono" name="telefono"
                                                       value=<?php echo $row['telefono'] ?>></td>
                                        </tr>
                                        <tr>
                                            <td>Descrizione</td>
                                            <td><input type="text" id="descrizione" name="descrizione"
                                                       value=<?php echo $row['descrizione'] ?>></td>
                                        </tr>
                                        <tr>
                                            <td>URL sito web</td>
                                            <td><input type="text" id="sito" name="sito"
                                                       value=<?php echo $row['sito'] ?>></td>
                                        </tr>
                                        <tr>
                                            <td>Immagine</td>
                                            <td><input type="file" name="immagine"></td>
                                        </tr>
                                    </table>
                                </div>



                                <div   class="col-md-3 pt-4">
                                    <div id="sezConferma" style="width: fit-content; margin: auto;">
                                        Abilitare le statistiche ? <br> 
                                        <input type="radio" id="statistiche1" name="statistiche" value="si"
                                        <?php
                                        if ($row['statistiche'] == 'si') {
                                            echo $checked;
                                        }
                                        ?>>Consento
                                        <br> <input type="radio" id="statistiche2" name="statistiche"
                                                    value="no"
                                                    <?php
                                                    if ($row['statistiche'] == 'no') {
                                                        echo $checked;
                                                    }
                                                    ?>>Non
                                        consento 
                                    </div>
                                </div>
                            </div>
                            <input id="infoSubmit" class="btn-green" type="submit" value="Conferma modifiche">
                        </form>
                    </div>
                    <br>
                    <p id="risultato"></p>
                </div>
                <br>
            <?php } else { ?>
                <h2>
                    Non hai i permessi per visualizzare questa pagina
                </h2>
            <?php } ?>
        </div>


        <?php include("footer.php") ?>
        <script src="./js/verifica.js" type="text/javascript"></script>
    </body>
</html>

