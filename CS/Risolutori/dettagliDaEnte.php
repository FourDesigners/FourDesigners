<?php
session_start();
require_once ("../common/connessione.php");
require_once ("auth.php");
?>
<!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="multipart/form-data;charset=ISO-8859-1" />
        <meta name="viewport" content="width=device-width, maximum-scale=1">
        <title>Segnalazione CDT</title>
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
        <script src="../common/commonJavascript.js" type="text/javascript"></script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBAv-Vel-BCGxjYFGcdSNFT_SVY6kocnbk&language=it" type="text/javascript"></script>
        <link rel="icon" href="favicon.ico">

    </head>
    <body class="ricerca risolutor">
        <div class="corpo">

            <?php include("menu.php") ?>    
            <?php if ($_SESSION[$sruolo] == 2) { ?>
                <div id="segnalazione" class="row seconda" style="display: none">

                    <div class="col-md-6" >

                        <table id="tabellaSegn">
                            <tr>
                                <td>Titolo</td>
                                <td><p id="titolo"></p></td>
                            </tr>
                            <tr>
                                <td>Codice</td>
                                <td><p id="cdtSegn"></p></td>
                            </tr>
                            <tr>
                                <td>Data</td>
                                <td><p id="dataT"></p></td>
                            </tr>
                            <tr>
                                <td>Località</td>
                                <td><p id="localita"></p></td>
                            </tr>
                            <tr>
                                <td>Indirizzo</td>
                                <td><p id="indirizzo"></p></td>
                            </tr>
                            <tr>
                                <td>Priorità</td>
                                <td><p id="prioritaT"></p></td>
                            </tr>
                            <tr>
                                <td>Stato</td>
                                <td>
                                    <?php
                                    $idGet = $_GET['id'];
                                    $query = "select * from Segnalazione where id=" . $idGet;
                                    $result = mysqli_query($conn, $query);

                                    $row = mysqli_fetch_array($result);
                                    $statoSegnalazione = $row['stato'];
                                    $tipologiaSegnalazione = $row['tipologia'];
                                    $selected = 'selected';
                                    ?>
                                    <select id='stato' style="width: 100%">
                                        <option value='Discarded'
                                                <?= ($statoSegnalazione == 'Discarded') ? $selected : "" ?>>Discarded</option>
                                        <option value='Pending'
                                                <?= ($statoSegnalazione == 'Pending') ? $selected : "" ?>>Pending</option>
                                        <option value='In progress'
                                                <?= ($statoSegnalazione == 'In progress') ? $selected : "" ?>>In
                                            progress</option>
                                        <option value='Solved'
                                                <?= ($statoSegnalazione == 'Solved') ? $selected : "" ?>>Solved</option>
                                        <option value='Closed'
                                                <?= ($statoSegnalazione == 'Closed') ? $selected : "" ?>>Closed</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Descrizione</td>
                                <td><p id="descrizione"></p></td>
                            </tr>
                            <tr>
                                <td>Tipologia</td>
                                <td>
                                    <select id="tipologia" style="width: 100%">
                                        <option value='Altro'
                                                <?= ($tipologiaSegnalazione == 'Altro') ? $selected : "" ?>>Altro</option>
                                        <option value='Acqua'
                                                <?= ($tipologiaSegnalazione == 'Acqua') ? $selected : "" ?>>Acqua</option>
                                        <option value='Luce'
                                                <?= ($tipologiaSegnalazione == 'Luce') ? $selected : "" ?>>Luce</option>
                                        <option value='Spazzatura'
                                                <?= ($tipologiaSegnalazione == 'Spazzatura') ? $selected : "" ?>>Spazzatura</option>
                                        <option value='Urbano'
                                                <?= ($tipologiaSegnalazione == 'Urbano') ? $selected : "" ?>>Urbano</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Commento Risolutori</td>
                                <td>
                                    <input style="width: 100%" type='text' id='commentoEnte' value="">
                                </td>
                            </tr>

                        </table>

                    </div>

                    <div class="col-md-6 destra" style="align-items: center;">
                        <button class="btn-fullBlue" id="btnMostra">Mostra su mappa</button>
                        <div id="singolaMappaDiv" style="display: none; width: 80%">
                            <button class="btn-fullBlue" onclick="nascondiMappa()">Chiudi mappa</button>
                            <div class="d-flex justify-content-center"> <!-- contenitore della mappa -->

                                <div class="mappa" id="singolaMappa"></div>
                            </div>
                        </div>

                        <div class="contenitoreFoto" >

                            <p> 
                                Clicca sull'immagine per ingrandirla
                            </p>
                            <div id="mioSlide" class="slideshow-container" >
                            </div>
                            <div id="dotDiv" style="text-align:center">
                            </div>

                            <div id="sezModal" class="modal" onclick="closeModal()">
                                <span class="close" >&times;</span>
                                <img class="modal-content" id="img01">
                            </div>

                        </div>
                        <div class="contVideo">
                            <video id="divVideo" width="300" height="250" controls style="display:none;" >
                                <source id="sezVideo" type="video/mp4">
                            </video>
                        </div>
                        <button class="btn-green mb-3" type="button" onclick="modifica(<?= $_GET["id"] ?>)">Conferma modifiche</button>
                        <p id="demo"></p>
                    </div>


                </div>
                <div id="divComm" class="row divCommenti" style="display: none">
                    <div class="col-md-6">
                        <p>Commenti:</p>
                        <div class="commenti" id="sezCommenti"></div>
                    </div>
                </div>

            <?php } else { ?>
                <h2>
                    Non hai i permessi per visualizzare questa pagina
                </h2>
            <?php } ?>
        </div>

        <?php include("footer.php") ?>
        <script src="./js/dettagliCommon.js" type="text/javascript"></script>
        <script src="./js/dettagliDaEnte.js" type="text/javascript"></script>
        <script>valutaCDT(<?= $_GET["id"] ?>);
    
        
        </script>
    </body>
</html>
