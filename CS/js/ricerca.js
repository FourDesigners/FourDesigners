function apriTab(tab) {
    if (!$('#' + tab).is(':visible')) {
        valorizzaRisposta("checkSingola", "", 0);
        $("#tabCDT").hide("slow");
        $("#divComm").hide("slow");
        $("#tabGenerale").hide("slow");
        $("#tabMappa").hide("slow");
        $("#" + tab).show("slow");

        $("#tabellaDiv").hide("slow");
        $("#segnalazione").hide("slow");
        $("#sezioneMappa").hide("slow");
        document.getElementById("tabCDTBtn").className = "tablinks";
        document.getElementById("tabGeneraleBtn").className = "tablinks";
        document.getElementById("tabMappaBtn").className = "tablinks";
        document.getElementById(tab + "Btn").classList.add('active');
        if (tab == "tabCDT" && document.getElementById("cdtSegn").value) {
            $("#segnalazione").show("slow");
            $("#divComm").show("slow");
        }
        if (tab == "tabMappa") {
            $("#sezioneMappa").show("slow");
        }
        if (tab == "tabGenerale" && document.getElementById('tabella').getElementsByTagName('tbody')[0].rows.length > 0) {
            $("#tabellaDiv").show("slow");
        }
    }
}





function valutaCDT(param) { //prende il CS inserito nel form e lo manda alla pagina che lo elabora
    if (document.readyState && (document.getElementById("CDT").value != document.getElementById("cdtSegn").value || !$('#segnalazione').is(':visible'))) {
        //non effettua la ricerca se il CS cercato ï¿½ quello della segnalazione attualmente visualizzata, a meno che il div sia invisibile
        $("#segnalazione").hide("slow");
        $("#divComm").hide("slow");
        nascondiMappa();
        if (param != "0") {
            document.getElementById("CDT").value = param;
        }
        if (document.getElementById("CDT").value != "") {
            var segnal = {"id": document.getElementById("CDT").value};
            chiamataAjax(JSON.stringify(segnal), "php/ricerca.php", "application/json", visualizza)
        }
    }
}

function parametri() { //prende i parametri della ricerca generica e costruisce l'oggetto con i parametri da mandare alla pagina che cerca le segnalazioni
    $('#tabella tbody').empty(); //svuota la tabella se giï¿½ esistente
    $('#segnalazione').hide("slow");
    $("#tabellaDiv").hide("slow");
    if(document.getElementById("citta").value==""){
        rispostaErr("risultatiRicerca", "Riempire il campo città!", 0);
    }else{
    var ricerca = {
        "id": "",
        "citta": document.getElementById("citta").value,
        "priorita": document.getElementById('priorita').value,
        "stato": document.getElementById('stato').value,
        "data": document.getElementById('data').value,
        "tipologia": document.getElementById('tipologia').value,
        "ordina": document.getElementById('ordina').value
    };
    chiamataAjax(JSON.stringify(ricerca), "php/ricerca.php", "application/json", popolaTabella);
    }
}

function visualizza(segnal) { //riceve la segnalazione singola e la visualizza nel dettaglio
    valorizzaRisposta("checkSingola", "", 0);
    apriTab("tabCDT")
    if (segnal == "0") {
        rispostaErr("checkSingola", "Nessun risultato", 4);
    } else {
        var segnalazione = JSON.parse(segnal);
        if (segnalazione.commentoEnte) {
            document.getElementById("commR").innerHTML = segnalazione.commentoEnte;
        } else {
            document.getElementById("commR").innerHTML = "Nessuno";
        }

        commonVisualizza(segnalazione, "");

        if (document.getElementById("userS")) { //se il segnalatore ï¿½ autenticato controlla i suoi preferiti per impostare il tasto dei preferiti
            checkPreferiti(segnalazione.id);
        }
        var comm = {"op": "ottieni", "id": segnalazione.id}; //oggetto per ottenere i commenti
        $('#sezCommenti').empty();
        chiamataAjax(JSON.stringify(comm), "php/commenti.php", "application/json", popolaCommenti);
    }
}
function mostraModal(idFoto) { // funzione che mostra a tutto schermo la foto cliccata
    var modal = document.getElementById('sezModal');
    var img = document.getElementById(idFoto);
    var modalImg = document.getElementById("img01");
    var captionText = document.getElementById("caption");
    modal.style.display = "block";
    modalImg.src = img.src;
    captionText.innerHTML = "Anteprima foto";
}

function closeModal() { //chiude la foto mostrata a tutto schermo
    var modal = document.getElementById('sezModal');
    modal.style.display = "none";
}

function popolaTabella(segnal) { //riceve le segnalazioni della ricerca generica e popola la tabella
    apriTab("tabGenerale");
    valorizzaRisposta("risultatiRicerca", "", 0);
    if (segnal != "0") { //se sono state ricevute segnalazioni
        var segnalazione = JSON.parse(segnal);
        if (segnalazione.id) { //se il risultato della ricerca ï¿½ una sigola segnalazione
            inserisciElementoDett(segnalazione); //inserisce la segnalazione in una riga della tabella
        } else {
            for (var i in segnalazione) { //inserisce ogni segnalazione in una riga della tabella
                inserisciElementoDett(segnalazione[i]);
            }
        }
        $("#tabellaDiv").fadeIn("slow");
        document.getElementById("tabellaDiv").scrollIntoView(); //centra la pagina sulla tabella

    } else {
        rispostaErr("risultatiRicerca", "Nessun risultato", 4);
    }
}

function checkPreferiti(id) { //funzione per avvalorare il tasto dei preferiti
    var segnal = {"id": id, "op": "check"};
    chiamataAjax(JSON.stringify(segnal), "php/preferiti.php", "application/json", setButton);
}

function setButton(pref) { //ottiene la risposta se la segnalazione visualizzata ï¿½ tra i preferiti o meno e setta il tasto
    document.getElementById("pref").style = "display:none";
    if (pref) {
        document.getElementById("pref").innerHTML = "Non seguire ";
        document.getElementById("pref").setAttribute("onClick", "preferiti('remove')");
        $("#prefT").attr("src", "img/fullStar.png");
    } else {
        document.getElementById("pref").innerHTML = "Segui segnalazione ";
        document.getElementById("pref").setAttribute("onClick", "preferiti('follow')");
        $("#prefT").attr("src", "img/emptyStar.png");
    }
    $("#pref").show("slow");

}


function preferiti(op) { //si attiva quando viene cliccato il tasto dei preferiti, op contiene l'informazione se ï¿½ da aggiungere o rimuovere
    var segnal = {"id": document.getElementById("CDT").value, "op": op};
    chiamataAjax(JSON.stringify(segnal), "php/preferiti.php", "application/json", setButton);


}

var myCity = ""; //servono per settare la modalitï¿½ mappa
var myCenter;
function attivaMappa() {
    if (document.getElementById("cittaMappa").value == "") {
        rispostaErr("checkMappa", "Riempi il campo città", 4);
    } else {
        myCity = document.getElementById("cittaMappa").value; //preleva la cittï¿½ dal form
        geocodifica({'address': myCity}, puntaMappa); //invia la cittï¿½ all'api di google per ottenere le coordinate e passa tutto a punta mappa
    }
}

function puntaMappa(results) {
    myCenter = results[0].geometry.location; //avvalora myCenter che contiene le coordinate della cittï¿½

    var ricerca = {//oggetto per effettuare la ricerca sulle segnalazioni
        "id": "", //necessario alla pagina che effettua la ricerca
        "citta": myCity,
        "priorita": document.getElementById('prioritaMappa').value,
        "stato": document.getElementById('statoMappa').value,
        "data": document.getElementById('dataMappa').value,
        "tipologia": document.getElementById('tipologiaMappa').value,
        "ordina": "id"
    };

    chiamataAjax(JSON.stringify(ricerca), "php/ricerca.php", "application/json", popolaMappa)
}

function popolaMappa(segnal) { //riceve le segnalazioni e le mette passa alla gunzione che le mette su mappa
    if (segnal != "0") {
        document.getElementById("checkMappa").innerHTML = "";

        $("#sezioneMappa").show("slow");
        document.getElementById("sezioneMappa").scrollIntoView(); //centra lo schermo sulla mappa
        var segnalazione = JSON.parse(segnal);
        mostraMappa(segnalazione, myCenter, 13, document.getElementById("mappa"));
    } else {
        rispostaErr("checkMappa", "Non ci sono segnalazioni in questa città", 4);
        
        $("#sezioneMappa").hide("slow");
    }

}




function inviaCommento() { //funzione per salvare un commento
    if (document.getElementById("invComm").value != "") { //se il campo testo ï¿½ vuoto non effettua il salvataggio
        var commento = {"op": "salva", //oggetto da passare per salvare il commento
            "id": document.getElementById("cdtSegn").value,
            "testo": document.getElementById("invComm").value};
        document.getElementById("invComm").value = "";
        chiamataAjax(JSON.stringify(commento), "php/commenti.php", "", risComment);
    }
}

function risComment(result) { //se il commento ï¿½ stato inserito correttamente lo aggiunge alla sezione commento
    if (result == "ok") {
        var comm = {"op": "ottieni", "id": document.getElementById("cdtSegn").value};
        $('#sezCommenti').empty();
        valorizzaRisposta("invComm", "", 0);
        chiamataAjax(JSON.stringify(comm), "php/commenti.php", "application/json", popolaCommenti);
    }
}