var inf = false; //variabile che serve per chiudere i popup della mappa in automatico quando si clicca su un altro segnalino
function mostraMappa(myPoint, myCenter, zoom, mapPos) {//passa i parametri per mostrare la mappa nell'elemento mapPos
    var options = {zoom: zoom, center: myCenter}; //opzioni da passare all'api per settare il centro mappa e lo zoom
    var map = new google.maps.Map(mapPos, options); //mostra la mappa sulla posizione trovata con le opzioni inserite
    //controlla se myPoint ï¿½ una segnalazione o se ï¿½ una semplice posizione da mostrare in mappa
    if (myPoint instanceof Array || !isNaN(myPoint.priorita)) { //se ï¿½ un array di segnalazioni alla fai i passaggi per mostrare le segnalazioni in modalitï¿½ mappa
        var marker;
        var LatLng;
        var content
        var infowindow;
        if (!isNaN(myPoint.priorita)) { //serve per riconoscere la segnalazione singola e porta in un array di un solo elemento per avere un processo unico
            var temp = myPoint;
            myPoint = [];
            myPoint[0] = temp;
        }
        for (var i in myPoint) {//cicla su tutte le segnalazioni
            if (myPoint[i].stato == "Pending" || myPoint[i].stato == "In progress") { // la modalitï¿½ mappa mostra solo le segnalazioni in stato Pending o In progress
                LatLng = new google.maps.LatLng(myPoint[i].latitudine, myPoint[i].longitudine); //crea loggetto coordinate accettate dall'api
                marker = new google.maps.Marker({position: LatLng, map: map, title: 'Segnalazione:' + myPoint[i].id}); //crea il segnalino

                switch (parseInt(myPoint[i].priorita)) { //camba il colore del segnalino a seconda della prioritï¿½
                    case 1:
                        marker.setIcon('http://maps.google.com/mapfiles/ms/icons/green-dot.png');
                        break;
                    case 2:
                        marker.setIcon('http://maps.google.com/mapfiles/ms/icons/yellow-dot.png');
                        break;
                    case 3:
                        marker.setIcon('http://maps.google.com/mapfiles/ms/icons/red-dot.png');
                        break;
                }
                infowindow = new google.maps.InfoWindow({//crea il popup per quando si clicca sul segnalino
                    content: ""
                });
                // costruisce il contenuto del popup
                content = "<h6>" + myPoint[i].titolo + "</h3>"
                content += "<p>Stato: " + myPoint[i].stato + "<br>"
                content += "Tipologia: " + myPoint[i].tipologia + "<br>"
                content += "<button onclick='valutaCDT(" + myPoint[i].id + ")'>Apri</button></p>"; //tasto per aprire nel dettaglio la segnalazione

                google.maps.event.addListener(marker, 'click', (function (marker, content, infowindow) { //funzione che permette l'apertura del popup, avvalorandone il contenuto e gestendone l'apertura
                    return function () {
                        if (inf) {
                            inf.close();
                        }
                        infowindow.setContent(content);
                        infowindow.open(map, marker);
                        inf = infowindow;

                    };
                })(marker, content, infowindow));
            }
        }
    } else { // se si tratta di una semplice posizione mostra soo il segnalino sulla mappa
        marker = new google.maps.Marker({position: myPoint, map: map});
        marker.setIcon('http://maps.google.com/mapfiles/ms/icons/blue-dot.png');
    }
}

function ottieniIndirizzo(stringa, pos) {//viene fornita la stringa comleta dell'indirizzo, piï¿½ la  posizione di un elemento per eventuali messaggi di errori
    var indStr = stringa.split(',');
    var lunghezza = Object.keys(indStr).length; //calcola la lunghezza dei paramentri
    var indirizzo = ["", ""];
    var localita = "";
    switch (lunghezza) { //gli indirizzi possono essere in vari formati
        //con questo switch acquisisco sempre la cittï¿½ a prescindere dal formato
        case 2:
            indirizzo[0] = "";
            localita = indStr[0].split(' ');
            indirizzo[1] = localita[0];
            indirizzo[2] = indStr[1];
            break;
        case 3:
            indirizzo[0] = indStr[0];
            localita = indStr[1].split(' ');
            indirizzo[1] = localita[2];
            indirizzo[2] = indStr[2];
            break;
        case 4:
            indirizzo[0] = indStr[0] + ", n" + indStr[1];
            localita = indStr[2].split(' ');
            indirizzo[1] = localita[2];
            indirizzo[2] = indStr[3];
            break;
        case 5:
            indirizzo[0] = indStr[1] + ", n" + indStr[2];
            localita = indStr[3].split(' ');
            indirizzo[1] = localita[2];
            indirizzo[2] = indStr[4];
            break;
        default:
            indirizzo = "C'ï¿½ stato un errore";
    }
    return indirizzo;
}

function geocodifica(elemento, funzione) //interroga l'API di Google per la geocodifica, ottiene indirizzo se si inviano coordinate, ottiene coordinate se si invia un indirizzo
{
    var geocoder = new google.maps.Geocoder;
    var infowindow = new google.maps.InfoWindow;
    geocodeLatLng(geocoder, infowindow);

    function geocodeLatLng(geocoder, infowindow) {
        geocoder.geocode(elemento, function (results, status) {
            if (status === 'OK') {
                if (results[0]) {//se ï¿½ arrivato fin qui ha trovato le coordinate
                    funzione(results);
                } else {
                    x.innerHTML = "Nessun indirizzo trovato";
                }
            } else {
                x.innerHTML = 'Geocodifica fallita: ';
            }
        });
    }
}

function chiamataAjax(parametro, paginaPhp, contentType, funzione) { //chiamata ajax standard
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            funzione(this.responseText);
        }
    };
    xmlhttp.open("POST", paginaPhp, true);
    if (contentType != "") {
        xmlhttp.setRequestHeader("Content-type", contentType);
    }
    xmlhttp.send(parametro);

}

function calcolaPriorita(string, pos) {
    if (string == "1") {
        pos.innerHTML = "<b style='color: green'>BASSA</b>";

    } else if (string == "2") {

        pos.innerHTML = "<b style='color: orange'>MEDIA</b>";

    } else if (string == "3") {

        pos.innerHTML = "<b style='color: red'>ALTA</b>";
    }
}

function attivaMenu(id) { //colora l'icona della pagina attualmente visualizzata nel menu a inizio pagina
    var elem = document.getElementById(id);
    elem.setAttribute("class", "nav-item attivo");
}

/*
 * Serve per valorizzare un div in modo permanente o temporaneo
 * Parametri:
 * - id: id del div dove inserire il testo
 * - valore: testo da inserire all'interno del div
 * - secondi: secondi prima di svuotare il div. 0 Se il contenuto non deve essere azzerato
 */
function valorizzaRisposta(id, valore, secondi) {
    var element = document.getElementById(id);
    if (element != null) {
        element.innerHTML = valore;
        if (secondi > 0) {
            var msretain = secondi * 1000;
            setTimeout(function () {
                element.innerHTML = ''
            }, msretain);
        }
    }
}

function rispostaErr(id, valore, secondi) {
    var element = document.getElementById(id);
    if (element != null) {
        element.innerHTML = valore;
        element.style = "color:red; font-weight:bold";
        if (secondi > 0) {
            var msretain = secondi * 1000;
            setTimeout(function () {
                element.innerHTML = ''
            }, msretain);
        }
    }
}

function rispostaPos(id, valore, secondi) {
    var element = document.getElementById(id);
    if (element != null) {
        element.innerHTML = valore;
        element.style = "color:green; font-weight:bold";
        if (secondi > 0) {
            var msretain = secondi * 1000;
            setTimeout(function () {
                element.innerHTML = ''
            }, msretain);
        }
    }
}

function drawCitta(city) //disegna i grafici della cittÃ  selezionata
{
    google.charts.setOnLoadCallback(function () {
        drawchart('stato', 'numero', city.primo, 'Le segnalazioni della citta selezionata per stato', 'piechartC1')
    });
    google.charts.setOnLoadCallback(function () {
        drawchart('tipologia', 'numero', city.secondo, 'Le segnalazioni della citta selezionata per tipologia', 'piechartC2')
    });

    var obpriorita = [//associa la prioritÃ  al numero corrispondente
        {"parametro": 'Bassa', "numero": city.terzo[0].numero},
        {"parametro": 'Media', "numero": city.terzo[1].numero},
        {"parametro": 'Alta', "numero": city.terzo[2].numero}];

    google.charts.setOnLoadCallback(function () {
        drawchart('priorità ', 'numero', obpriorita, 'Le segnalazioni della citta selezionata per priorità', 'piechartC3')
    });
    //punta la visuale all'elemento indicato
    setTimeout(function () {
        document.getElementById("piechartC1").scrollIntoView();
    }, 800);

}

function drawchart(stringa, numero, oggetto, descrizione, div)
{
    var campo1, campo2;
    var totale = 0;
    var id;
    var colori = ['#1aa52a', '#e8da17', '#dd3218', '#1e1eea', '#9e16dd'];
    var data = new google.visualization.DataTable();
    data.addColumn('string', stringa);//parametro
    data.addColumn('number', numero);//occorrenze
    data.addColumn({type: 'string', role: 'style'}); // colori

    for (var j in oggetto)
    {
        id = Number(oggetto[j].numero);
        totale += id;
    }
//calcola il totale delle occorrenze per calcolare le percentuali
    for (var i in oggetto) {
        campo1 = oggetto[i].parametro + " " + ((oggetto[i].numero / totale) * 100).toFixed(1) + "%";
        campo2 = Number(oggetto[i].numero);
        if (oggetto[i].parametro == '1')
            data.addRow(['Bassa', campo2, colori[0]]);
        else if (oggetto[i].parametro == '2')
            data.addRow(['Media', campo2, colori[1]]);
        else if (oggetto[i].parametro == '3')
            data.addRow(['Alta', campo2, colori[2]]);
        else
            data.addRow([campo1, campo2, colori[i]]);
    }

// Aggiunge il titolo e setta la grandezza e la larghezza
    var options = {
        width: '100%',
        height: '100%',
        legend: {position: 'none', maxLines: 1},
        bar: {groupWidth: '65%'},
        isStacked: true,
        hAxis: {gridlines: {color: '#000000', count: 10}},
        vAxis: {gridlines: {count: 4}},
        title: descrizione,
        titleTextStyle: {
            fontSize: 13,
        },

    };

// crea i grafici nel div
    var chart = new google.visualization.ColumnChart(document.getElementById(div));
//mostra i grafici dopo 8 milli secondi per garantire il completo caricamento
    setTimeout(function () {
        chart.draw(data, options);
    }, 800);
//adatta i grafici in base alla dimensione della finestra
    $(window).resize(function () {
        chart.draw(data, options);
    });
}

function invioSubmit(idTextBox, idButton) {
    $("#" + idTextBox).keyup(function (event) {
        if (event.keyCode === 13) {
            $("#" + idButton).click();
        }
    });
}

function myPopup() { //popup che appare quando si clicca su comune non partecipante
    var popup = document.getElementById("myPopup");
    popup.classList.toggle("show");
}

function popolaCommenti(result) {
    var sezCom = document.getElementById("sezCommenti");
    var comm = "";
    var pComm = "";

    if (result == "0") {
        comm = document.createElement("div");
        comm.style = "border: 1px solid black;";
        pComm = document.createElement("p");
        pComm.innerHTML = "Nessun commento";
        pComm.style = 'text-align: justify; padding:10px';
        comm.appendChild(pComm);
        sezCom.appendChild(comm);
    } else {
        var commenti = JSON.parse(result);
        for (var i in commenti) {
            comm = document.createElement("div");
            comm.style = "border: 1px solid black;";
            pComm = document.createElement("p");
            pComm.innerHTML = commenti[i].testo;
            pComm.style = 'text-align: justify; padding:10px';
            comm.appendChild(pComm);
            var aComm = document.createElement("p");
            aComm.innerHTML = "By " + commenti[i].nickname + "<br>(" + commenti[i].dataD + ")";
            aComm.style = 'text-align: right; padding-right: 20px; font-family: italic';
            comm.appendChild(aComm);
            sezCom.appendChild(comm);
        }
    }
}

var slideIndex = 0; //serve per il modal delle foto

function plusSlides(n) {
    showSlides(slideIndex += n);
}

function currentSlide(n) {
    showSlides(slideIndex = n);
}

function showSlides(n) {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    var dots = document.getElementsByClassName("dot");
    if (n > slides.length) {
        slideIndex = 1;
    }
    if (n < 1) {
        slideIndex = slides.length;
    }
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    if (slides[slideIndex - 1]) {
        slides[slideIndex - 1].style.display = "block";
        dots[slideIndex - 1].className += " active";
    }
}

function singolaMappa(lat, lng) { //funzione per mostrare la posizione di una sgnalazione visualizzata in dettaglio su mappa
    var LatLng = new google.maps.LatLng(lat, lng);
    $("#singolaMappaDiv").show("slow");
    document.getElementById("btnMostra").style = "display:none";
    mostraMappa(LatLng, LatLng, 15, document.getElementById("singolaMappa"));
}

function nascondiMappa() {
    $("#singolaMappaDiv").hide("slow");
    $("#btnMostra").show("slow");
}

function commonVisualizza(segnalazione, baseImg) { //funzione che contiene le azioni comuni per visualizzare le segnalazioni
    valorizzaRisposta("titolo", "<font size='5'>" + segnalazione.titolo + "</font>", 0);
    valorizzaRisposta("cdtSegn", "<font size='5'>" + segnalazione.id + "</font>", 0);
    document.getElementById("cdtSegn").value = segnalazione.id;
    valorizzaRisposta("dataT", "<font size='5'>" + segnalazione.dataInizio + "</font>", 0);

    var testoLocalita = "<font size='5'>" + segnalazione.citta + "</font>";

    if (!segnalazione.comune) { //controlla se il comune non ï¿½ registrato e in tal caso genera il popup comune non registrato
        var testoPop = "Questo comune<br><b>non utilizza CivicSense</b>.<br>Tuttavia ha comunque ricevuto un email con le informazioni relative alla segnalazione";
        testoLocalita += ' <div class="popup" onclick="myPopup()"><ins>(Comune non partecipante)</ins><span class="popuptext" id="myPopup">' + testoPop + '</span></div>';
    }
    valorizzaRisposta("localita", testoLocalita, 0);
    valorizzaRisposta("indirizzo", "<font size='5'>" + segnalazione.indirizzo + "</font>", 0);
    calcolaPriorita(segnalazione.priorita, document.getElementById("prioritaT"));
    valorizzaRisposta("statoT", "<font size='5'>" + segnalazione.stato + "</font>", 0);
    document.getElementById("btnMostra").setAttribute("onClick", "singolaMappa(" + segnalazione.latitudine + ", " + segnalazione.longitudine + ")");
    if (document.getElementById("commentoEnte")) {
        document.getElementById("commentoEnte").value = segnalazione.commentoEnte;
    }
    $('#sezFoto').empty(); //cancella eventuali foto di una vecchia segnalazione
    $("#divVideo").hide("slow"); //serve chiudere il div video nel caso prima si sia visualizzata una segnalazione con un video e quella visualizzata dopo non lo ha
    var n = 1;
    $('#mioSlide').empty();//cancella eventuali foto di una vecchia segnalazione dallo slider
    $('#dotDiv').empty(); //cancella i dot dello slider
    for (var i in segnalazione.url) { //cicla sui media della segnalazione
        if (!segnalazione.url[i].includes(".mp4")) { //se non si trata di un video
            var divSlide = document.createElement("div");
            divSlide.setAttribute("class", "mySlides fade"); //da la classe slide al div
            n++; //serve per contare il numero di foto

            var foto = document.createElement("img");
            foto.src = baseImg + segnalazione.url[i];
            foto.id = "f" + n;
            foto.setAttribute("onClick", "mostraModal('f" + n + "')"); //funzione per ingrandire la foto
            foto.style = "width: auto; height: auto; opacity:1;  max-height: 200px; max-width: 100%;";
            divSlide.appendChild(foto);

            document.getElementById("mioSlide").appendChild(divSlide);

            var myDot = document.createElement("span");
            myDot.setAttribute("class", "dot");
            myDot.setAttribute("onClick", "currentSlide(" + i + ")");
            document.getElementById("dotDiv").appendChild(myDot);

        } else { //se il media ï¿½ un video mettilo nel div video
            $("#divVideo").show("slow");
            document.getElementById("sezVideo").src = baseImg + segnalazione.url[i];
            document.getElementById("divVideo").load();
        }
    }
    if (n > 2) { //se c'ï¿½ piï¿½ di una foto, mostra i tasti dello slide e ne costruisce il funzionamento
        var btnL = document.createElement("button");
        btnL.setAttribute("onClick", "plusSlides(-1)");
        btnL.setAttribute("style", "Position:absolute; Top:50%; transform: translateX(-150%); left:0");
        btnL.innerHTML = "&#10094;"; //codice del tasto
        document.getElementById("mioSlide").appendChild(btnL);
        var btnR = document.createElement("button");
        btnR.setAttribute("onClick", "plusSlides(1)");
        btnR.setAttribute("style", "Position:absolute; Top:50%; transform: translateX(+150%); right:0");
        btnR.innerHTML = "&#10095;";//codice del tasto
        document.getElementById("mioSlide").appendChild(btnR);
    }

    showSlides(0);//attiva lo slide foto (funzione piï¿½ sotto)

    var descrizione = "";
    if (segnalazione.descrizione == "") {
        descrizione = "Nessuna descrizione";
    } else {//correttore accentate
        var testo = correttoreComenti(segnalazione.descrizione);
        descrizione = testo;
    }
    valorizzaRisposta("descrizione", descrizione, 0);
    $("#segnalazione").fadeIn("slow");
    $("#divComm").fadeIn("slow");
}

function correttoreComenti(testo) {
    testo = testo.replace(/u00e0/g, "à");
    testo = testo.replace(/u00e8/g, "è");
    testo = testo.replace(/u00ec/g, "ì");
    testo = testo.replace(/u00e9/g, "ò");
    testo = testo.replace(/u00f9/g, "ù");
    testo = testo.replace(/u00f2/g, "é");
    return testo;
}


function inserisciElementoDett(segnalazione) { //inserisce la segnalazione in una riga della tabella
    var tableRef = document.getElementById('tabella').getElementsByTagName('tbody')[0]; //punta al contenuto della tabella
    // Insert a row in the table at the last row
    var row = tableRef.insertRow(tableRef.rows.length);//punta all'ultima riga della tabella


    var cell1 = row.insertCell(0);
    cell1.innerHTML = segnalazione.titolo;

    var cell2 = row.insertCell(1);
    cell2.innerHTML = segnalazione.indirizzo;
    var cell3 = row.insertCell(2);
    calcolaPriorita(segnalazione.priorita, cell3);

    var cell4 = row.insertCell(3);
    cell4.innerHTML = segnalazione.stato;
    var cell5 = row.insertCell(4);
    cell5.innerHTML = segnalazione.tipologia;
    var cell6 = row.insertCell(5);

    var btn = document.createElement("BUTTON");
    var t = document.createTextNode("Apri");
    btn.appendChild(t);
    btn.setAttribute("class", "btn-blue");
    btn.setAttribute("onClick", "valutaCDT(" + segnalazione.id + ")");
    cell6.appendChild(btn);

}

function tabRisolutori(segnalazione, ruolo) { //inserisce la segnalazione in una riga della tabella
    var tableRef = document.getElementById('tabella').getElementsByTagName('tbody')[0]; //punta al contenuto della tabella
    // Insert a row in the table at the last row
    var row = tableRef.insertRow(tableRef.rows.length);//punta all'ultima riga della tabella


    var cell1 = row.insertCell(0);
    cell1.innerHTML = segnalazione.id;
    
    var cell2 = row.insertCell(1);
    cell2.innerHTML = segnalazione.dataInizio;
    
    var cell3 = row.insertCell(2);
    cell3.innerHTML = segnalazione.dataFine;
    
    var cell4 = row.insertCell(3);
    cell4.innerHTML = segnalazione.titolo;

    var cell5 = row.insertCell(4);
    cell5.innerHTML = segnalazione.indirizzo;
    
    var cell6 = row.insertCell(5);
    calcolaPriorita(segnalazione.priorita, cell6);

    var cell7 = row.insertCell(6);
    cell7.innerHTML = segnalazione.stato;
    
    var cell8 = row.insertCell(7);
    cell8.innerHTML = segnalazione.tipologia;
    
    var cell9 = row.insertCell(8);
    cell9.innerHTML = segnalazione.commentoEnte;
    
    var cell10 = row.insertCell(9);
    var btn = document.createElement("BUTTON");
    var t = document.createTextNode("Apri");
    btn.appendChild(t);
    btn.setAttribute("class", "btn-blue");
    btn.setAttribute("onClick", "modifica('"+ruolo+"', '" + segnalazione.id + "')");
    cell10.appendChild(btn);

}