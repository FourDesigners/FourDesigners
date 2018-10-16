function valutaCDT(id) {//cerca la segnalazione
	if (document.readyState) {
		$('#tabella').hide("slow");
		document.getElementById("segnalazione").style = "display:none";
		document.getElementById("divComm").style = "display:none";
		$("#sezioneMappa").hide("slow");

		var segnal = {"id": id};
		chiamataAjax(JSON.stringify(segnal), "../php/ricerca.php", "application/json", visualizza)
	}
}

function visualizza(segnal) {//visualizza la segnalazione
	valorizzaRisposta("messaggio", "", 0);
	if (segnal == "0") {
		valorizzaRisposta("messaggio", "Nessun risultato", 0);
	} else {
		var segnalazione = JSON.parse(segnal);
		valorizzaRisposta("tipologiaT", "<font size='5'>" + segnalazione.tipologia + "</font>", 0);
		
		commonVisualizza(segnalazione, "../");

        var comm = {"op": "ottieni", "id": segnalazione.id}; //oggetto per ottenere i commenti
		$('#sezCommenti').empty();
		chiamataAjax(JSON.stringify(comm), "ajax/commenti.php", "application/json", popolaCommenti);
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
	valorizzaRisposta("risultatiRicerca", "", 0);
    if (segnal != "0") { //se sono state ricevute segnalazioni
		var segnalazione = JSON.parse(segnal);
        if (segnalazione.id) { //se il risultato della ricerca � una sigola segnalazione
            inserisciElementoDett(segnalazione); //inserisce la segnalazione in una riga della tabella
		} else {
            for (var i in segnalazione) { //inserisce ogni segnalazione in una riga della tabella
            		inserisciElementoDett(segnalazione[i]);
			}
		}
		$("#tabella").fadeIn("slow");
	} else {
		valorizzaRisposta("risultatiRicerca", "Nessun risultato", 0);
	}
}

//funzioni che pemettono il funzionamento dello slider delle foto
showSlides(slideIndex);


function risComment(result) { //se il commento � stato inserito correttamente lo aggiunge alla sezione commento
	if (result == "ok") {
		var comm = {"op": "ottieni", "id": document.getElementById("cdtSegn").value};
		$('#sezCommenti').empty();
		valorizzaRisposta("invComm", "", 0);
		chiamataAjax(JSON.stringify(comm), "ajax/commenti.php", "application/json", popolaCommenti);
	}
}

function confermaModifica(risultato) {
	rispostaPos("demo", risultato, 4);
        
}

function parametri() {
	$('#tabella tbody').empty();
	$('#segnalazione').hide("slow");
	$("#tabella").hide("slow");
	
	var radios = document.getElementsByName('ordina');
	var ordina = "";
	for (var i = 0, length = radios.length; i < length; i++)
	{
		if (radios[i].checked)
		{
			ordina = radios[i].value;
		}
	}

	var ricerca = {
			"id": "",
			"citta": document.getElementById("citta").value,
			"priorita": document.getElementById('priorita').value,
			"stato": document.getElementById('stato').value,
			"data": document.getElementById('data').value,
			"tipologia": document.getElementById('tipologia').value,
			"ordina": ordina
	};
	chiamataAjax(JSON.stringify(ricerca), "../php/ricerca.php", "application/json", popolaTabella);
}