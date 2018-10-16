// Load google charts
google.charts.load('current', {'packages': ['corechart']});

function apriTab(tab) {

    if (!$('#' + tab).is(':visible')) {
        $("#citta").hide("slow");
        $("#effettuate").hide("slow");
        $("#terzaRiga").hide("slow");
        $("#seguite").hide("slow");
        $("#" + tab).show("slow");
        if (tab == "citta")
            $("#terzaRiga").show("slow");
        if (tab == "effettuate") {
            var sEff = {"op": "eff"};
            chiamataAjax(JSON.stringify(sEff), "php/calcolaStatistica.php", "application/json", segnEff);
        }
        if (tab == "seguite") {
            var sSeg = {"op": "seg"};
            chiamataAjax(JSON.stringify(sSeg), "php/calcolaStatistica.php", "application/json", segnSegu);
        }
        document.getElementById("cittaBtn").className = "tablinks";
        document.getElementById("effettuateBtn").className = "tablinks";
        document.getElementById("seguiteBtn").className = "tablinks";
        document.getElementById(tab + "Btn").classList.add('active');
    }
}


function segnEff(risultato) {   //funzione che crea i grafici sulle segnalazioni effettuate

    var effet = JSON.parse(risultato);
    if (effet == 0) {
        document.getElementById('rispostaE').innerHTML = "Non hai effettuato segnalazioni ";
        $("#conChartE").hide("slow");
    } else {
        $("#conChartE").show("slow");
        google.charts.setOnLoadCallback(function () {
            drawchart('stato', 'numero', effet.primo, 'Le tue segnalazioni per stato', 'piechartE1')
        });
        google.charts.setOnLoadCallback(function () {
            drawchart('tipologia', 'numero', effet.secondo, 'Le tue segnalazioni per tipologia', 'piechartE2')
        });

        google.charts.setOnLoadCallback(function () {
            drawchart('priorit‡†', 'numero', effet.terzo, 'Le tue segnalazioni  per priorit‡†', 'piechartE3')
        });

    }

}


function segnSegu(risultato) {//funzione che crea i grafici sulle segnalazioni seguite

    var seguite = JSON.parse(risultato);
    if (seguite == 0) {
        document.getElementById('rispostaS').innerHTML = "Non hai segnalazioni preferite";
        $("#conChartS").hide("slow");
    } else {
        $("#conChartS").show("slow");
        google.charts.setOnLoadCallback(function () {
            drawchart('stato', 'numero', seguite.primo, 'Le tue segnalazioni seguite selezionate per stato', 'piechartS1')
        });
        google.charts.setOnLoadCallback(function () {
            drawchart('tipologia', 'numero', seguite.secondo, 'Le tue segnalazioni seguite selezionate per tipologia', 'piechartS2')
        });

        google.charts.setOnLoadCallback(function () {
            drawchart('priorit‡†', 'numero', seguite.terzo, 'Le tue segnalazioni selezionate per priorit‡†', 'piechartS3')
        });

    }
}

function valueCitta() {

    if (document.getElementById("cittac").value != "") {
        var citta = {
            "op": "citta",
            "citta": document.getElementById("cittac").value,
            "data": document.getElementById('data').value
        }; // oggetto JSON che contiene i parametri di ricerca delle segnalazioni di una citta
        document.getElementById("conChart").style = "display:none";
        chiamataAjax(JSON.stringify(citta), "php/calcolaStatistica.php", "application/json", visualizza);
        chiamataAjax(JSON.stringify(citta), "php/informazioni.php", "application/json", info);
    } else {
        document.getElementById("risposta").innerHTML = "Inserisci una citt‡";
        $("#risposta").show("fast");
    }
}


function info(value) // mostra le informazioni sulla citta ricercata
{
    if (value != "0") {
        $("#risposta").hide("slow");
        var citta = JSON.parse(value);
        document.getElementById("nome").innerHTML = "Citt‡†: " + citta.citta;
        if (citta.descrizione == null)
            document.getElementById("descrizione").innerHTML = "";
        else
            document.getElementById("descrizione").innerHTML = "Descrizione: " + citta.descrizione;
        document.getElementById("email").innerHTML = "Email: " + citta.email;


        if (citta.immagine == null)
            document.getElementById("immagine").style = "display:none";
        else
        {
            var foto = document.getElementById("immagine");
            foto.src = "Risolutori/foto/" + citta.immagine;
            foto.style = "display:block; width: auto; height: auto; opacity:1;  max-height:300px; max-width: 100%; border:0; margin:auto";

        }
        if (citta.telefono == null)
            document.getElementById("telefono").innerHTML = "";
        else
            document.getElementById("telefono").innerHTML = "Telefono: " + citta.telefono;

        if (citta.sito == null)
            document.getElementById("sito").innerHTML = "";
        else
            document.getElementById("sito").innerHTML = "Sito: <a href='http://" + citta.sito + "'>" + citta.sito + "</a>";

    } else {
        document.getElementById("nome").innerHTML = "Errore";
    }
}
function visualizza(param) //visualizza i diagrammi sulle segnalazioni della citt√† ricercate
{
    document.getElementById('charts').innerHTML = "";
    if (param == "NOT")
    {
        $("#risposta").hide("slow");
        $("#secondaRiga").show("slow");
        $("#terzaRiga").show("slow");
        document.getElementById('charts').innerHTML = "Statistiche non disponibili per questa citt‡†";
    } else if (param == "0")
    {
        $("#risposta").hide("slow");
        $("#secondaRiga").show("slow");
        $("#terzaRiga").show("slow");
        document.getElementById('charts').innerHTML = "Non ci sono segnalazioni su questa citt‡†";
    } else if (param == "NOTCIVIC")
    {
        $("#risposta").hide("slow");
        document.getElementById('risposta').innerHTML = "Questa citt‡† non utilizza l'applicativo Civic Sense";
        $("#risposta").show("slow");
        $("#secondaRiga").hide("slow");
        $("#terzaRiga").hide("slow");
    } else {
        document.getElementById("conChart").style = "display:block";
        $("#risposta").hide("slow");
        $("#secondaRiga").show("slow");
        $("#terzaRiga").show("slow");
        var city = JSON.parse(param);
        drawCitta(city); //disegno dei grafici della citt√†
    }
}
