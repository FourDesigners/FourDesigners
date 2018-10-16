<?php
include_once 'common/lastActivity.php';
?>
<!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="multipart/form-data;charset=ISO-8859-1" />
        <meta name="viewport" content="width=device-width, maximum-scale=1">
        <title>Cerca segnalazione</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
        <script src="js/ricerca.js" type="text/javascript"></script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBAv-Vel-BCGxjYFGcdSNFT_SVY6kocnbk&language=it" type="text/javascript"></script>
        <script src="common/commonJavascript.js" type="text/javascript"></script>
        <script src="common/autocompletamento.js" type="text/javascript"></script>
        <script src="common/elencoComuni.js"></script>
        <link rel="icon" href="favicon.ico">
    </head>
    <body class="ricerca" >
        <div class="corpo">
            <?php include("menu.php") ?>
            <div class="contenitoreTab" >
                <div class="tab">
                    <button id="tabCDTBtn" class="tablinks active" onclick="apriTab('tabCDT')">Cerca Segnalazione</button>
                    <button id="tabGeneraleBtn" class="tablinks" onclick="apriTab('tabGenerale')">Ricerca generale</button>
                    <button id="tabMappaBtn" class="tablinks" onclick="apriTab('tabMappa')">Modalità Mappa</button>
                </div>

                <div id="tabCDT" class="tabcontentRicerca">
                    <label class="control-label">Inserisci codice di segnalazione:
                        <input  id="CDT" type="number"  name="CDT">
                        <br>
                        <button id="btnCDT" class="btn-fullBlue" onclick="valutaCDT('0')">Cerca</button>
                    </label>
                    <p id="checkSingola"></p>
                </div>
                <div id="tabGenerale" class="tabcontentRicerca" style="display: none;">
                    <?php if ($aut) { ?>
                        <label class="control-label autocomplete" >Città:                          
                            <input  autocomplete="off" id="citta" type="text"> 
                        </label>
                        <br>
                        <label class="control-label">Priorità:
                            <select name=priorita id="priorita">
                                <option value='0'>Tutte</option>
                                <option value='1' style='color:green'>Bassa</option>
                                <option value='2' style='color:orange'>Media</option>
                                <option value='3' style='color:red'>Alta</option>
                            </select>
                        </label>
                        <label class="control-label">Stato:
                            <select name=stato id="stato">
                                <option value='0'>Tutti</option>
                                <option value='Discarded'>Discarded</option>
                                <option value='Pending'>Pending</option>
                                <option value='In progress'>In progress</option>
                                <option value='Solved'> Solved</option>
                                <option value='Closed'>Closed</option>
                            </select>
                        </label>
                        <br>
                        <label class="control-label">Periodo:
                            <select name=data id="data">
                                <option value='0'>Tutti</option>
                                <option value='1 month'>Ultimo mese</option>
                                <option value='3 months'>Ultimi 3 mesi</option>
                                <option value='6 month'>Ultimi 6 mesi</option>
                                <option value='1 year'>Ultimo anno</option>                                
                            </select>
                        </label>
                        <label class="control-label">Tipologia:
                            <select name=tipologia id="tipologia">
                                <option value='0'>Tutte</option>
                                <option value='Acqua'>Acqua</option>
                                <option value='Altro'>Altro</option>
                                <option value='Luce'>Luce</option>
                                <option value='Spazzatura'>Spazzatura</option>
                                <option value='Urbano'>Urbano</option>
                            </select>
                        </label>
                        <label class="control-label">Ordina per:  
                            <select name=ordina id="ordina">
                                <option value="id" >Data</option>
                                <option value="priorita" >Priorità</option>
                                <option value="stato" >Stato</option>
                            </select>
                        </label>
                        <br>
                        <button id="btnGenerica" class="btn-fullBlue" onclick="parametri()">Cerca</button>
                        <p id="risultatiRicerca"></p>
                    <?php } else { ?>
                        <p><a href="accesso.php"> Registrati o effettua il login</a> per poter utilizzare la ricerca generale</p>
                    <?php } ?>
                </div>
                <div id="tabMappa" class="tabcontentRicerca" style="display:none">
                    <?php if ($aut) { ?>                    
                        <label class="control-label autocomplete">Inserire città:
                            <input  autocomplete="off" id="cittaMappa" type="text"  name="CDT">
                        </label>
                        <br>
                        <label class="control-label">Priorità:
                            <select name=priorita id="prioritaMappa">
                                <option value='0'>Tutte</option>
                                <option value='1' style='color:green'>BASSA</option>
                                <option value='2' style='color:orange'>MEDIA</option>
                                <option value='3' style='color:red'>ALTA</option>
                            </select>
                        </label>                        
                        <label class="control-label">Stato:
                            <select name=stato id="statoMappa">
                                <option value='0'>Tutti</option>                                
                                <option value='Pending'>Pending</option>
                                <option value='In progress'>In progress</option>
                            </select>
                        </label>
                        <br>
                        <label class="control-label">Periodo:
                            <select name=data id="dataMappa">
                                <option value='0'>Tutti</option>
                                <option value='1 month'>Ultimo mese</option>
                                <option value='3 months'>Ultimi 3 mesi</option>
                                <option value='6 month'>Ultimi 6 mesi</option>
                                <option value='1 year'>Ultimo anno</option>                                
                            </select>
                        </label>
                        <label class="control-label">Tipologia:
                            <select name=tipologia id="tipologiaMappa">
                                <option value='0'>Tutte</option>
                                <option value='Acqua'>Acqua</option>
                                <option value='Altro'>Altro</option>
                                <option value='Luce'>Luce</option>
                                <option value='Spazzatura'>Spazzatura</option>
                                <option value='Urbano'>Urbano</option>
                            </select>
                        </label>
                        <br>
                        <button id="btnModMappa" class="btn-fullBlue" onclick="attivaMappa()">Cerca</button>
                        <p id="checkMappa"></p>

                    <?php } else { ?>
                        <p><a href="accesso.php"> Registrati o effettua il login</a> per poter utilizzare la modalità mappa</p>
                    <?php } ?>
                </div>


            </div>



            <div class="contTabella" id="tabellaDiv" style="display:none;">
                <table id="tabella">                
                    <thead>
                        <tr>
                            <td>TITOLO</td><td>INDIRIZZO</td><td>PRIORITA</td><td>STATO</td><td>TIPOLOGIA</td><td></td>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </div>
            <div id="segnalazione" class="row seconda" style="display: none">

                <div class="col-md-6" >
                    <div class="stella">
                        <?php if ($aut) { ?>
                            <img id="prefT" src="" style="width:35px">
                            <button class="btn-orange" id="pref" onclick="preferiti()"></button>
                        <?php }
                        ?>
                    </div>

                    <table id="tabellaSegn">
                        <tr><td>Codice</td><td><p id="cdtSegn"></p></td></tr>
                        <tr><td>Titolo</td><td><p id="titolo"></p></td></tr>                        
                        <tr><td>Data</td><td><p id="dataT"></p></td></tr>
                        <tr><td>Località</td><td><p id="localita"></p></td></tr>
                        <tr><td>Indirizzo</td><td><p id="indirizzo"></p></td></tr>
                        <tr><td>Priorità</td><td><p id="prioritaT"></p></td></tr>
                        <tr><td>Stato</td><td><p id="statoT"></p></td></tr>
                        <tr><td>Commento risolutore</td><td><p id="commR"></p></td></tr>
                        <tr><td>Descrizione</td><td><p id="descrizione"></p></td></tr>
                    </table> 


                </div>

                <div  class="col-md-6 destra" >
                    <button class="btn-fullBlue" id="btnMostra">Mostra su mappa</button>
                    <div id="singolaMappaDiv" style="display: none;">
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


                </div>

            </div>
            <div id="divComm" class="row divCommenti" style="display: none">

                <div class="col-md-6">
                    <p> Commenti: </p>
                    <div class="commenti" id="sezCommenti" ></div>

                </div>
                <?php if ($aut) { ?>
                    <div class="col-md-6 aggCommento" id="aggComm">
                        <div class="aggC">
                            <p>Aggiungi un commento:</p>

                            <textarea id="invComm" name="invComm" rows="5"></textarea>

                            <button id="btnInvComm" class="btn-fullBlue" onclick="inviaCommento()">Invia</button>
                            <p id="debugComm"></p>
                        </div>
                    </div>
                <?php }
                ?>
            </div>

            <?php if ($aut) { ?>
                <div id="sezioneMappa" style=" display: none; ">
                    <p class="legenda">Nella modalità mappa non vengono visualizzate le segnalazioni scartate o chiuse.</p><br>
                    <div class="row legenda">                    
                        <div class="col-sm-3" ><p>Legenda:</p></div>
                        <div class="col-sm-3" ><img src="https://maps.google.com/mapfiles/ms/icons/green-dot.png" >Priorità bassa</div>
                        <div class="col-sm-3" ><img src="https://maps.google.com/mapfiles/ms/icons/yellow-dot.png" >Priorità media</div>
                        <div class="col-sm-3" ><img src="https://maps.google.com/mapfiles/ms/icons/red-dot.png" >Priorità alta</div>
                    </div>
                    <div class="d-flex justify-content-center" > <!-- contenitore della mappa -->

                        <div class="mappa" id="mappa"></div>
                    </div>

                </div>
            <?php }
            ?>





        </div>
        <?php include("footer.php") ?>

        <script>
<?php
if (isset($_GET["x"])) {
    $cdt = $_GET["x"];
    echo 'document.getElementById("CDT").value =' . $cdt . ';';
    echo 'valutaCDT("0");';
}
?>
            $(document).ready(function () {
                attivaMenu("cerca");
            });
            invioSubmit("CDT", "btnCDT");
            invioSubmit("citta", "btnGenerica");
            invioSubmit("cittaMappa", "btnModMappa");
<?php if ($aut) { ?>
                autocomplete(document.getElementById("citta"), elencoComuni);
                autocomplete(document.getElementById("cittaMappa"), elencoComuni);
<?php } ?>
        </script>
    </body>
</html>
