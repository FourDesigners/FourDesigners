
function getLocation() { // è stato selezionato GPS, rilevamento con geolocalizzazione e passaggio diretto dei parameti alla funzione che li mostra in mappa
    document.getElementById("gps").value = "true"; //Servirà dopo per capire che è stato usato il GPS
    document.getElementById("manuale").value = "false";
    $("#cercaForm").hide("slow");
    $("#loadGPS").show("slow"); //mostra la gif del radar
    if (navigator.geolocation) { //verifica che il GPS sia supportato
        setTimeout(function () {
            navigator.geolocation.getCurrentPosition(showPosition, positionError, {enableHighAccuracy: true}); //funzione che rileva le coordinate
        }, 2000);
    } else {
        rispostaErr("debugElement", "La geolocalizzazione non è supportata per questo dispositivo", 4);
    }
}
function positionError(string) { //visualizza eventuali errori del GPS
    $("#loadGPS").hide("slow");
    rispostaErr("debugElement", "Attenzione il GPS potrebbe non essere attivo!", 4);
}
function showPosition(position) {  //funzione per mostrare a mappa la posizione trovata tramite geolocalizzazione
    if (lat == null) { //se lat non è avvalorato significa che il GPS è disattivato
        rispostaErr("debugElement", "Attenzione, GPS non attivo!", 4);
    } else {
        $("#loadGPS").hide("slow");
        $("#tasto").show("slow"); //mostra il tasto di conferma posizione
        lat.value = position.coords.latitude; //avvalora i campi latitudine e longitudine
        lng.value = position.coords.longitude;
        var coord = {lat: position.coords.latitude, lng: position.coords.longitude}; //crea l'oggetto da passare all'api di google per ottenere l'indirizzo
        x.innerHTML = "";
        geocodifica({'location': coord}, salvaInfo); //passa l'oggetto con le coordinate e la funzione che deve elaborare il risultato
    }
}

function getAdress() { //mostra il form per la ricerca manuale
    $("#cercaForm").show("slow");
}

function findLocation() {//è stato scelto l'inserimento dell'indirizzo manuale, funzione perla ricerca della posizione inserita a mano
    x.innerHTML = "";
    if (document.getElementById("findCitta").value === "" || document.getElementById("findIndirizzo").value === "" || document.getElementById("findCivico").value === "") {
        rispostaErr("upCerca", "Inserisci tutti i campi per poter effettuare la ricerca", 4); //controllo che tutti i campi siano riempiti
    } else {
        document.getElementById("upCerca").innerHTML = ""; //pulisce eventuali stampe di errore precedenti
        //genera un indirizzo completo da mandare a google per ottenere le coordinate
        var address = document.getElementById("findCitta").value + " " + document.getElementById("findIndirizzo").value + " " + document.getElementById("findCivico").value;

        $("#cercaForm").hide("slow");//chiude il form di ricerca
        document.getElementById("gps").value = "false";
        document.getElementById("manuale").value = "true"; //Servirà dopo per capire che è stato usato l'inserimento manuale
        geocodifica({'address': address}, salvaInfo); //passa l'oggetto con le coordinate e la funzione che deve elaborare il risultato
    }
}


function salvaInfo(results) { //funzione che riceve il risultato dall'api di google, riempie il form della segnalazione, e mostra l'indirizzo ricavato
    var myPoint = results[0].geometry.location; //contiene le coordinate dell'indirizzo elaborato

    mostraMappa(myPoint, myPoint, 15, document.getElementById("mappa")); //funzione che costruisce e mostra la mappa
    var indirizzo = ottieniIndirizzo(results[0].formatted_address, x); //funzione che elabora l'indirizzo ricevuto e lo formatta correttamente
    if (document.getElementById("manuale").value == "true") { //se è stata usata la ricerca manuale riempi i campi lat e long dai dati elaborati da google, altrimenti lascia quelli ottenuti direttamente dal GPS
        lat.value = results[0].geometry.location.lat();
        lng.value = results[0].geometry.location.lng();
    }
    document.getElementById("chekIndirizzo").innerHTML = indirizzo[1] + ", " + indirizzo[0]; //mostra l'indirizzo ottenuto

    indir.value = indirizzo[0]; //avvalora i campi del form
    citta.value = indirizzo[1];
    nazione.value = indirizzo[2];
    $("#tasto").show("slow"); //mostra il tasto di conferma posizione
}

function showError(error) { //funzione per mostrare eventuali erori nell'uso dell'api della mappa
    switch (error.code) {
        case error.PERMISSION_DENIED:
            x.innerHTML = "User denied the request for Geolocation."
            break;
        case error.POSITION_UNAVAILABLE:
            x.innerHTML = "Location information is unavailable."
            break;
        case error.TIMEOUT:
            x.innerHTML = "The request to get user location timed out."
            break;
        case error.UNKNOWN_ERROR:
            x.innerHTML = "An unknown error occurred."
            break;
    }
}

function controlloCoincidenti() {//funzione per le segnalazioni nelle vicinanze
    if (indir.value == "") {
        rispostaErr("upCerca", "Attenzione, la ricerca cha hai effettuato non ha prodotto un indirizzo non valido, controlla i parametri inseriti.", 4);
    } else {
        if (nazione.value != " Italia") {
            rispostaErr("upCerca", "Attenzione, CivicSense funziona solo in Italia!", 4);
        } else {
            $("#parte1").hide("slow");
            var posizione = {
                "lat": lat.value,
                "lng": lng.value
            };
            var dbParam = JSON.stringify(posizione); //costruisce l'oggetto contenente le coordinate

            chiamataAjax(dbParam, "php/stessaPosizione.php", "application/json", mostraCoincidenti); //chiamata ajax alla pagina che controlla se ci sono segnalazioni vicine
        }
    }
}

function mostraCoincidenti(risultato) { //funzione che mostra, se sono state trovate, le segnalazioni vicine
    if (risultato === "0") {
        secondStep(); //salta questo passaggio se non sono state trovate segnalazioni
    } else {
        $('#sD').empty();
        $('#tabella tbody').empty();
        $("#parteDuplicati").show("slow");
        popolaTabella(JSON.parse(risultato)); //popola la tabella delle segnalazioni vicine
    }
}

function popolaTabella(segnalazione) { //funzione che popola la tabella delle segnalazioni vicine
    var tableRef = document.getElementById('tabella').getElementsByTagName('tbody')[0]; //punta al contenuto della tabella
    for (var i in segnalazione) {
        // inserisce una nuova riga nela tabela
        var row = tableRef.insertRow(tableRef.rows.length);

        var cell0 = row.insertCell(0);
        cell0.innerHTML = segnalazione[i].titolo;

        var macroBlocco = document.getElementById("sD");//serve per il modal dell'anteprima delle foto
        var foto = document.createElement("img");
        foto.src = segnalazione[i].url;
        foto.style = "height:100px; width:auto";
        foto.id = "f" + i; //assegna un id alla foto in modo che possa essere aperta
        macroBlocco.appendChild(foto);

        var cell1 = row.insertCell(1);
        cell1.innerHTML = segnalazione[i].tipologia;

        var cell2 = row.insertCell(2);
        var btn = document.createElement("button");
        var t = document.createTextNode("Anteprima");
        btn.appendChild(t);
        btn.setAttribute("onClick", "mostraModal('f" + i + "')"); //associa il tasto anteprima alla funzione che apre l'anteprima con argomento l'id della foto
        btn.setAttribute("class", "btn-blue");
        cell2.appendChild(btn);

        var cell3 = row.insertCell(3);
        var a = document.createElement('a');
        a.href = "ricercaSegnalazione.php?x=" + segnalazione[i].id; //link alla pagina che visualizzerà la segnalazione nel dettaglio
        var btn1 = document.createElement("BUTTON");
        var t1 = document.createTextNode("APRI");
        btn1.appendChild(t1);
        btn1.setAttribute("class", "btn-blue");
        a.appendChild(btn1);
        cell3.appendChild(a);
    }
}

function mostraModal(idFoto) { //funzione che mostra l'anteprima
    var modal = document.getElementById('myModal');
    var img = document.getElementById(idFoto);
    var modalImg = document.getElementById("img01");
    var captionText = document.getElementById("caption");
    modal.style.display = "block";
    modalImg.src = img.src;
    captionText.innerHTML = "Anteprima foto";
}
function closeModal() { //chiude l'anteprima
    $("#myModal").hide("slow");
}
function secondStep() { //disattiva il blocco delle segnalazioni vicine per attivare il form della segnalazione
    if (document.getElementById("lat").value === null || document.getElementById("long").value === null) {
        rispostaErr("debugElement", "Non hai ancora rilevato la posizione!", 4);
    } else {
        x.innerHTML = "";
        $("#parteDuplicati").hide("slow");
        $("#parte2").show("slow");
        fM.innerHTML = "";
    }
}


function indietro() { //ritorna indietro alla sezione del'inserimento posizione
    $("#parteDuplicati").hide("slow");
    $("#parte2").hide("slow");
    $("#parte1").show("slow");
    document.getElementById("tasto").style = "display:none";
    document.getElementById("cercaForm").style = "display:none";
    document.getElementById("gps").style = "display:block";
    document.getElementById("manuale").style = "display:block";
    document.getElementById("upCerca").innerHTML = "";
    document.getElementById("formSegn").reset();
}

function controlloCaratteri(stringa) { //impedisce l'inserimento dei caratteri "<>" che creano problemi.
    var controllo = false;
    if (stringa.includes("<") || stringa.includes(">")) {
        controllo = true;
    }
    return controllo;
}


function invia() { //funzione che controlla che tutti i campi del form siano riempiti e invia la segnalazione alla pagina che la salva nel db
    fM.innerHTML = "";
    var sel = document.getElementById("tipologia");
    var tip = sel.options[sel.selectedIndex].value; //rileva l'elemento selezionato nel campo tipologia
    if (!titolo.value) {
        fM.innerHTML = "*Inserire un titolo per la segnalazione";
    } else if (controlloCaratteri(titolo.value)) {
        fM.innerHTML = "Errore nel titolo. Hai inserito caratteri non validi.";
    } else if (controlloCaratteri(desc.value)) {
        fM.innerHTML = "Errore nella descrizione. Hai inserito caratteri non validi.";
    } else if (tip == "0") {
        fM.innerHTML = "Selezionare una tipologia!";
    } else if (!validaMedia()) {
        fM.innerHTML += "";
    } else {
        $("#divCaricamento").show("slow");
        $("#parte2").hide("slow");
        $("#parte4").show("slow");
        var radios = document.getElementsByName('priorita');
        var priorita = "";
        for (var i = 0, length = radios.length; i < length; i++) {
            if (radios[i].checked)
            {
                priorita = radios[i].value;
            }
        }
        var segnalazione = {// crea l'oggetto segnalazione da passare alla pagina che la salva
            "lat": lat.value,
            "lng": lng.value,
            "citta": citta.value,
            "indirizzo": indir.value,
            "titolo": titolo.value,
            "descrizione": desc.value,
            "priorita": priorita,
            "tipologia": tip
        };
        var segnData = new FormData(); //serve per creare una variabile che possa contenere sia l'oggetto segnalazione che le foto e video inserite
        segnData.append("segnalazione", JSON.stringify(segnalazione)); //aggiunge l'oggetto segnalazione

        var ins = document.getElementById('foto1').files.length;
        for (var x = 0; x < ins; x++) { //aggiunge tutte le foto caricate
            segnData.append("fileToUpload[]", document.getElementById('foto1').files[x]);
        }
        if (video.files[0]) { //se c'è un video aggiunge anche quello
            segnData.append("video", video.files[0]);
        }
        chiamataAjax(segnData, "php/inviaSegnalazione.php", "", risInvio); //passaggio della variabile contenente il tutto alla pagina che salva la segnalazione
    }
}

function validaMedia() { //funzione che valida i media inseriti
    var validazione = true;
    if (!foto1.files[0]) { //controlla che sia stata  inserita almeno una foto
        fM.innerHTML += "*Devi inserire almeno una foto<br>per poter effettuare la segnalazione";
        validazione = false;
    } else {

        var ins = document.getElementById('foto1').files.length;
        for (var x = 0; x < ins; x++) {
            if (document.getElementById('foto1').files[x].size > 8000000) {
                validazione = false;
            }
        }
        if (!validazione) {
            fM.innerHTML = "Hai inserito una foto troppo grande, e non può essere caricata!";

        } else {
            if (video.files[0]) {
                if (video.files[0].type != "video/mp4") {
                    fM.innerHTML = "Hai inserito un formato video non supportato!";
                    validazione = false;
                }
            }
        }
    }
    return validazione;
}

function risInvio(ris) { //riceve dalla pagina che ha elaborato la segnalazione il risultato dell'inserimento
//  p4.innerHTML=ris;
    var risultato = JSON.parse(ris);
    $("#divCaricamento").hide("slow");
    if (isNaN(risultato.id)) { //se questo campo non è un numero significa che la segnalazione non è stata salvata correttamente e stampa il relativo errore
        p4.innerHTML = risultato;
    } else {

        document.getElementById("successo").innerHTML = "SEGNALAZIONE INVIATA CON SUCCESSO!";
        document.getElementById("codice").innerHTML = "Il codice di tracking è: " + risultato.id;
        document.getElementById("caricata").href = "ricercaSegnalazione.php?x=" + risultato.id;
        document.getElementById("caricata").style = "display:block";
        if (risultato.comune == "no") { //se il comune non è partecipante avvisa il segnalatore
            document.getElementById("partecipa").style = "display:block";
        }
    }

}
