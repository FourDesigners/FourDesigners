<?php
include_once 'common/lastActivity.php';
include_once '../common/connessione.php';
$comune = "select citta from Risolutore where account=2 AND attivo=true";
$result = $conn->query($comune);
$num = $result->num_rows;
$ente = array();
$ente = $result->fetch_all(MYSQLI_ASSOC);
?>
<!doctype html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, maximum-scale=1">
        <title>Cos'è CivicSense</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
        <script src="common/commonJavascript.js" type="text/javascript"></script>
        <link rel="icon" href="favicon.ico">
    </head>
    <body class='cose'>

        <div class='corpo'>

            <?php include("menu.php") ?>

            <div class="row prima">
                <div class="col-sm-6">
                    
                        <img style="height: auto; max-width: 100%; width: 350px;" src="img/CS.png" alt="CivicLogo">
                   

                </div>

                <div class="col-sm-6">
                    <h3>Cos'è Civic Sense?</h3>
                    <p>Civic Sense è un'applicazione con l'obiettivo di creare un canale di comunicazione tra erogatori di servizi o enti pubblici 
                        e individui che usufruiscono di tali servizi.<br> 
                        Permette di segnalare guasti, problemi, malfunzionamenti e, in generale, eventi rilevanti che comportano un disagio per il cittadino. 
                        Si potranno quindi ricevere informazioni circa l'avanzamento della risoluzione di quanto segnalato.<br>
                        L'idea nasce come progetto universitario degli studenti della facoltà di informatica 
                        dell'Università degli Studi di Bari nel 2018.
                    </p>
                </div>
            </div>
            <div class="row seconda">

                <div class="col-sm-6"> 
                    <h3>COME FUNZIONA?<br></h3>
                    <p>Grazie a Civic Sense ogni cittadino può effettuare segnalazioni dei problemi riscontrati nella sua città in maniera semplicissima.<br>
                        È possible segnalare senza alcun bisogno di registrazione selezionando <b>"SEGNALA!"</b> dalla pagina iniziale o dal menù.<br>
                        A segnalazione effettuata verrà fornito un <b>Codice Segnalazione</b> grazie al quale sarà possibile controllare 
                        lo stato di avanzamento dei lavori selezionando <b>"CERCA SEGNALAZIONI"</b> dal menù e inserendo il Codice Segnalazione .<br>
                        I cittadini che scelgono di registrarsi, potranno aggiungere commenti alle segnalazioni presenti nel sistema,
                        effettuare ricerche sulle segnalazioni 
                        e disporranno di una sezione personale in cui raccogliere le segnalazioni di maggiore interesse, 
                        senza necessità di ricordarsi alcun Codice Segnalazione.
                        Gli utenti registrati potranno controllare le segnalazioni presenti in una determinata città attraverso la Modalità mappa!
                    </p>
                </div>

                <div class="col-sm-6">
                    <img src="img/work3.jpg" alt="civicBlackboard">
                </div>  
            </div>
            <div class="row terza" id="elencoComuni" style="width: fit-content;  display: block; margin-left: 20px; margin-right: 10px;"> 
                <h4>
                    Ecco i comuni già iscritti a Civic Sense:<br>
                </h4>
                <p id="comuni" style="text-align: left; overflow-y: auto; max-height: 300px; "></p>
            </div>



            <div class="row terza" style="border-top: 1px solid black">


                <h2 style="margin-top: 20px">TEAM DI SVILUPPO<br>4CITIZENS</h2>
                <div class="row">
                    <div class="col-sm-3">
                        <img src="img/Castellano.jpg" alt="Graziano Castellano">
                        <h3>Castellano<br>Graziano</h3>
                    </div>
                    <div class="col-sm-3">
                        <img src="img/Di Pierro.jpg" alt="Davide Di Pierro">
                        <h3>Di Pierro<br>Davide</h3>
                    </div>
                    <div class="col-sm-3">
                        <img src="img/Lisco.jpg" alt="Federica Lisco">
                        <h3>Lisco<br>Federica</h3>
                    </div>
                    <div class="col-sm-3">
                        <img src="img/Lovecchio.jpg" alt="Francesco Lovecchio">
                        <h3>Lovecchio<br>Francesco</h3>
                    </div>
                </div>
            </div>

        </div>

        <?php include("footer.php") ?>
        <script>
            $(document).ready(function () {
                attivaMenu("civicSense");

                var enti = <?php echo json_encode($ente); ?>;
                for (var i in enti) {
                    document.getElementById("comuni").innerHTML += "Comune di " + enti[i].citta + "<br>"
                }
            });



        </script>

    </body>
</html>