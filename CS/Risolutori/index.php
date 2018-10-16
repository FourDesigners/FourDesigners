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
        <title>Home - Risolutori</title>
        <meta http-equiv="Content-Type" content="multipart/form-data;charset=ISO-8859-1" />
        <meta name="viewport" content="width=device-width, maximum-scale=1">
        <link rel="stylesheet"  href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
        <script src="../common/commonJavascript.js" type="text/javascript"></script>
        <link rel="icon" href="favicon.ico">
        <script src="./js/index.js" type="text/javascript"></script>
        <script src="../common/autocompletamento.js" type="text/javascript"></script>
        <script src="../common/elencoComuni.js"></script>

    </head>
    <body class='accesso risolutor'>
        <div class="corpo">
            <?php include("menu.php") ?>
            <div class="contenitore">
                <?php
                switch ($ruolo) {
                    case 1:
                        include('fragment/index_admin.fragment.php');
                        break;
                    case 2:
                        include('fragment/index_ente.fragment.php');
                        break;
                    case 3:
                        include('fragment/index_gruppo.fragment.php');
                        break;
                    default:
                }
                ?>
            </div>
        </div>

        <?php include("footer.php") ?>
    </body>
</html>
