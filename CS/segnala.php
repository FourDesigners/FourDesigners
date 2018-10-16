<?php
include_once 'common/lastActivity.php';
?>
<!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="multipart/form-data;charset=ISO-8859-1">
        <meta name="viewport" content="width=device-width, maximum-scale=1">
        <title>Effettua segnalazione</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBAv-Vel-BCGxjYFGcdSNFT_SVY6kocnbk&language=it" type="text/javascript"></script>        
        <script src="js/segnala.js" type="text/javascript"></script>
        <script src="common/commonJavascript.js" type="text/javascript"></script>
        <script src="common/autocompletamento.js" type="text/javascript"></script>
        <script src="common/elencoComuni.js"></script>
        <link rel="icon" href="favicon.ico">

    </head>
    <body class="segnala">
        <div class="corpo">
            <?php include("menu.php") ?>
            <div id="parte1"> <!-- primo riquadro per la raccolta della posizione, verra nascosto quando si confermerï¿½ la posizione rilevata -->

                <h1>Effettua segnalazione</h1>
                <p>Seleziona la modalità  di rilevamento posizione per effettuare la segnalazione: </p>
                <p id="debugElement" style="color:red"></p> <!-- elemento di debug -->
                <div class="tastiPos">    
                    <button class="btn-fullBlue" onclick="getAdress()" value="false" id="manuale">MANUALE</button>                    
                    <button class="btn-fullBlue" onclick="getLocation()" value="false" id="gps">GPS</button>   
                    <button class="btn-green conf" onclick="controlloCoincidenti()" id="tasto" style="display:none;">CONFERMA POSIZIONE</button>
                </div>

                <div id="cercaForm" style="display:none;"> <!-- form per la ricerca manuale della posizione -->
                    <form class="form"> 
                        <label class="autocomplete">Città:  
                            <input autocomplete="off" id="findCitta" type="text" required>
                        </label>
                        <label >Indirizzo:  
                            <input id="findIndirizzo" type="text">
                        </label>
                        <label >Civico: 
                            <input id="findCivico" type="number">
                        </label>
                        <button class="btn-fullBlue" type="button" id="cercaIndirizzo" onclick="findLocation()">Cerca</button>
                    </form>
                </div>
                <p id="upCerca"></p> <!-- mostrerï¿½ errore se non sono compilati tutti i campi -->
                <p id="chekIndirizzo"></p>

                <div id="loadGPS" style="display:none;">
                    <h3>Acquisizione GPS</h3>
                    <img src="img/radar.gif" alt="radar">
                </div>
                <div class="mappa" id="mappa"></div><!--contenitore mappa-->
            </div>

            <div class="container-fluid" id="parteDuplicati" style="display: none;">                
                <h1 >Segnalazioni in zona</h1> 
                <p>Controlla se la segnalazione che vuoi effettuare è gia inserita tra quelle elencate.</p>

                <button class="btn-green" type="button" id="creaNuova" onclick="secondStep()">CREA NUOVA SEGNALAZIONE</button>
                <p id="duplic"></p>
                <div class="contTabella">
                    <table id="tabella">
                        <thead>
                            <tr>
                                <td>TITOLO</td><td>TIPOLOGIA</td><td>FOTO</td><td></td>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    <div id="myModal" class="modal" onclick="closeModal()">
                        <span class="close" >&times;</span>
                        <img class="modal-content" id="img01">
                        <div id="caption"></div>
                    </div>
                </div>
                <div id="sD" style="display: none"></div>



                <br>
                <button style="margin-bottom: 30px;" class="btn-fullBlue" type="button" onClick="indietro()">Annulla</button>

            </div>

            <div id="parte2" style="display:none;"> <!-- seconda parte della pagina, si attiva dopo il click di conferma posizione -->

                <h1>Completamento dati</h1> 
                <p>Hai quasi finito.<br>Inserisci gli ultimi dati per poter inviare la segnalazione.</p>
                <p id="zz"></p>        

                <!-- form per il completamento dei dati della segnalazione -->
                <div id="formSegnalazione">
                    <form class="form" id="formSegn"> 
                        <label style="display:none" >Lat Lng Naz:  
                            <input class="col-sm-8" id="lat" type="number"  name="latitudine" readonly>
                            <input  id="long" type="number" name="longitudine" readonly>                   
                            <input id="nazione" type="text" name="nazione" readonly>
                        </label>

                        <label >Indirizzo: 
                            <input id="indir" type="text" name="indirizzo" readonly style="background-color: #cccccc">
                        </label>
                        <label  >Città:
                            <input  id="citta" type="text" name="citta" readonly style="background-color: #cccccc">
                        </label>


                        <label  id="campoTitolo" >Titolo:
                            <input id="titolo" type="text" name="titolo" required>
                        </label>
                        <label id="campoDescrizione" class="control-label" style="align-self: flex-start">Descrizione (opzionale): </label>
                        <textarea id="descrizione" name="descrizione" rows="5"></textarea>
                    </form>
                    <form>
                        <div id="sezMedia">
                            <p id="campoFoto"></p>
                            <div class="sezMedia">
                                Allega Foto (minimo 1):<br>
                                <div class="popup" onclick="myPopup()"><ins>Come allegare più foto?</ins>
                                    <span class="popuptext" id="myPopup">Tieni premuto su una foto nella galleria per attivare la selezione multipla.</span>
                                </div>
                                <input id="foto1" type="file" name="pic1" accept="image/*" required multiple="multiple">

                            </div>

                            <div class="sezMedia">
                                Allega un video (opzionale): 
                                <input id="video" type="file" name="video" accept="video/*" >
                            </div>
                        </div>


                        <div class="tabcontent">
                            <label >Tipologia segnalazione:
                                <select id="tipologia" name="tipologia">
                                    <option value='0'></option>
                                    <option value='Acqua'>Acqua</option>
                                    <option value='Altro'>Altro</option>
                                    <option value='Luce'>Luce</option>
                                    <option value='Spazzatura'>Spazzatura</option>
                                    <option value='Urbano'>Urbano</option>
                                </select>
                            </label>
                            <label class="labRadio">
                                Priorità: <br>     
                                <input type="radio" name="priorita" value=1 required checked="checked"><b style="color:green">Bassa    </b>
                                <input type="radio" name="priorita" value=2 required><b style="color: orange">Media    </b>
                                <input type="radio" name="priorita" value=3 required><b style="color:red">Alta    </b>
                            </label> 
                        </div>
                        <p id="formMessage" style="color:red; text-height: 10px"></p>       
                    </form>
                    <button class="btn-fullBlue" type="button" onClick="indietro()">Annulla</button>
                    <button class="btn-green" type="button" onclick="invia()">Invia</button>

                </div>

            </div>
            <div id="divCaricamento" style="display:none">
                <h3>Caricamento Segnalazione in corso</h3>
                <img src="img/loading.gif">
                <p>Attendi...</p>
            </div>
            <div id="parte4" style="display:none">
                <p id="mesP4" style="margin-top: 30px;" ></p>
                <h2 id="successo" style="margin-top: 30px;" ></h2>
                <h4 id="codice" style="margin-top: 30px;" ></h4>
                <a id="caricata" style="display: none; margin-top: 30px;"><button class="btn-fullBlue" type="button" >VISUALIZZA</button></a>
                <p id="partecipa" style="display:none; margin-top: 60px;" >Ti informiamo che <font size='5'><b>il comune</b></font> per cui hai effettuato la segnalazione <font size='5'><b>non utilizza CivicSense</b></font>.<br>
                    Verrà comunque recapitata una email con la tua segnalazione.</p>
            </div>



        </div>
        <?php include("footer.php") ?>
        <script>

            $(document).ready(function () {
                attivaMenu("segnala");
            });

            var x = document.getElementById("debugElement"); // posizione per scrivere eventuali errori            
            var indirizzo = null;
            var lat = document.getElementById("lat");
            var lng = document.getElementById("long");
            var titolo = document.getElementById("titolo");
            var indir = document.getElementById("indir");
            var desc = document.getElementById("descrizione");
            var citta = document.getElementById("citta");
            var nazione = document.getElementById("nazione");
            var foto1 = document.getElementById("foto1");
            var foto2 = document.getElementById("foto2");
            var foto3 = document.getElementById("foto3");
            var video = document.getElementById("video");


            var fM = document.getElementById("formMessage");
            var p4 = document.getElementById("mesP4");

            invioSubmit("findCitta", "cercaIndirizzo");
            invioSubmit("findIndirizzo", "cercaIndirizzo");
            invioSubmit("findCivico", "cercaIndirizzo");
            autocomplete(document.getElementById("findCitta"), elencoComuni);
        </script>
    </body>
</html>