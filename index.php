<?php
include_once 'common/lastActivity.php';
?>
<!doctype html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, maximum-scale=1">
        <title>IndexCivicSense</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
        <script src="common/commonJavascript.js" type="text/javascript"></script>
        <link rel="icon" href="favicon.ico">
    </head>
    <body class="index">
        <div class="container-fluid">
            <div class='acc'>
                <a class="btn-fullBlue" href="#" onClick="location.href = 'civicSense.php'"> Scopri di più </a>
                <?php if (!$aut) { ?>
                    <a class="btn-fullBlue" href="accesso.php" style="margin-left: 10px;" >Accedi</a>
                <?php } ?>
            </div>
            <div class="row prima">        
                <img style="max-width: 100%; width: 300px; height: auto;" src="img/CS.png" alt="LogoCivic" />  
            </div>

            <div class="row seconda">
                <div class="col-md-6 " > <!--SEGNALA-->
                    <a href="segnala.php"><img class="icona" src="img/segnala2.png" alt="OminoMegafono" /></a>
                    <a class="btn-fullBlue" href="#" onClick="location.href = 'segnala.php'">Effettua segnalazione</a>

                </div>

                <div class="col-md-6" > <!--SEGNALA-->
                    <a href="ricercaSegnalazione.php"><img class="icona" src="img/controlla.png" alt="OminoLente" /></a>
                    <a class="btn-fullBlue" href="#" onClick="location.href = 'ricercaSegnalazione.php'">Cerca segnalazioni</a>

                </div>
            </div>
        </div>

    </body>
</html>
