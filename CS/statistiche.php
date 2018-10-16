<?php
include_once 'common/lastActivity.php';
?>
<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="multipart/form-data;charset=ISO-8859-1" />
    <meta name="viewport" content="width=device-width, maximum-scale=1">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <script src="https://www.gstatic.com/charts/loader.js?key=AIzaSyBAv-Vel-BCGxjYFGcdSNFT_SVY6kocnbk&language=it" type="text/javascript"></script>
    <script src="js/statistiche.js" type="text/javascript"></script>
    <script src="common/commonJavascript.js" type="text/javascript"></script>
    <script src="common/autocompletamento.js" type="text/javascript"></script>
    <script src="common/elencoComuni.js"></script>
    <link rel="icon" href="favicon.ico">

</head>
<body class="statistiche">
    <div class="corpo">
        <?php include("menu.php") ?>
        <h1>Statistiche</h1>
        <?php if ($aut) { ?>

            <div class="contenitoreTab">
                <div class="tab">
                    <button id="cittaBtn" class="tablinks active" onclick="apriTab('citta')">Segnalazioni città</button>
                    <button id="effettuateBtn" class="tablinks" onclick="apriTab('effettuate')" >Segnalazioni effettuate</button>
                    <button id="seguiteBtn" class="tablinks" onclick="apriTab('seguite')">Segnalazioni seguite</button>
                </div>

                <div id='citta' class="tabcontent" style="display: block;">
                    <label class="control-label autocomplete">Inserisci Città :
                        <input autocomplete="off" id="cittac" type="text">
                    </label>
                    <label class="control-label">Periodo:
                        <select name=data id="data">
                            <option value='0'>Tutti</option>
                            <option value='6 month'>Ultimi 6 mesi</option>
                            <option value='1 year'>Ultimo anno</option>
                        </select>
                    </label>
                    <button class="btn-fullBlue" type="button" id="valoriCitta" onclick="valueCitta()">Cerca</button>
                    <p id="risposta" style="display: none" >  </p>
                    <div id="secondaRiga" style="display: none;">
                        <h1>Informazioni </h1>
                        <p id="nome">  </p>
                        <img id="immagine"> </img>
                        <p id="email">  </p>
                        <p id="descrizione"> </p>
                        <p id="telefono">  </p>
                        <p id="sito">  </p>
                    </div>
                </div>

                <div id="terzaRiga" style="display: none; width:80%">
                    <p id="charts" > </p>
                    <div id="conChart" style="display: none;">
                        <div class="chart" id="piechartC1"></div>
                        <div class="chart" id="piechartC2"></div>
                        <div class="chart" id="piechartC3"></div>
                    </div>
                </div>
                <div id="effettuate" style="display: none; width:80%">
                    <p id="rispostaE" > </p>
                    <div id="conChartE" style="display: none;">
                        <div  class="chart" id="piechartE1"></div>
                        <div class="chart" id="piechartE2"></div>
                        <div class="chart" id="piechartE3"></div>
                    </div>
                </div>
                <div id="seguite" style="display: none; width:80%">
                    <p id="rispostaS"> </p>
                    <div id="conChartS" style="display: none;">
                        <div class="chart" id="piechartS1"></div>
                        <div class="chart" id="piechartS2"></div>
                        <div class="chart" id="piechartS3"></div>
                    </div>
                </div>


            </div>
        <?php } else { ?>
            <p> <a href="accesso.php"> Registrati o effettua il login</a> per poter visualizzare le statistiche</p>
        <?php } ?>
    </div>

    <?php include("footer.php") ?>



    <script type="text/javascript">
        $(document).ready(function () {
            attivaMenu("statistiche");
        });

        invioSubmit("cittac", "valoriCitta");
        autocomplete(document.getElementById("cittac"), elencoComuni);
    </script>

</body>
</html>
