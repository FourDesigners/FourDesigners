<?php
session_start();
require_once ("../common/connessione.php");
require_once ("auth.php");

$ruolo = $_SESSION['SESS_RUOLO'];
$citta = $_SESSION['SESS_CITTA'];
?>
<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="multipart/form-data;charset=ISO-8859-1" />
    <meta name="viewport" content="width=device-width, maximum-scale=1">
    <link rel="stylesheet" href="../css/style.css">
    <script src="../common/commonJavascript.js" type="text/javascript"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <script src="https://www.gstatic.com/charts/loader.js?key=AIzaSyBAv-Vel-BCGxjYFGcdSNFT_SVY6kocnbk&language=it" type="text/javascript"></script>
    <script src="../Risolutori/js/statisticheEnte.js" type="text/javascript"></script>
    <link rel="icon" href="favicon.ico">

</head>
<body class=" risolutor">
    <div class="corpo">
        <?php include("menu.php") ?>
        <?php if ($_SESSION[$sruolo] == 2) { ?>

            <div class="contenitoreTab">
                <div class="tab">
                    <button class="tablinks active"> STATISTICHE</button>
                </div>

                <div id='citta' class="tabcontent">
                    <p > Seleziona un periodo</p>
                    <label class="control-label">Periodo:
                        <select name=data id="data">
                            <option value='0'>Tutti</option>
                            <option value='6 month'>Ultimi 6 mesi</option>
                            <option value='1 year'>Ultimo anno</option>
                        </select>
                        <button class="btn-fullBlue" type="button" onclick="valueCitta()">Cerca</button>
                    </label>
                    <p id="risposta" > </p>
                </div>
            </div>
            <div id="riga" style="display:none;">
                <div class="chart" id="piechartC1"></div>
                <div class="chart" id="piechartC2"></div>
                <div class="chart" id="piechartC3"></div>
            </div>
        <?php } else { ?>
            <h2>
                Non hai i permessi per visualizzare questa pagina
            </h2>
        <?php } ?>
    </div>
    <?php include("footer.php") ?>
    <script>
        var ente = "<?php echo $citta; ?> ";

    </script>
</body>

</html>
