function modifica(stato, email) {//modifica lo stato di un ente
	var bottone = "";
	if(stato == 0) {
		bottone = "<button class=\"btn-minGreen\" onclick=\"modifica(1, '" + email + "')\">ATTIVA</button>";
	}else {
		bottone = "<button class=\"btn-red\" onclick=\"modifica(0, '" + email + "')\">DISATTIVA</button>";
	}
	console.log(bottone);
	valorizzaRisposta(email, bottone, 0);
	var param = {"email": email, "stato": stato};
	chiamataAjax(JSON.stringify(param), "ajax/modificaAttivazione.php", "application/x-www-form-urlencoded", function(){});
}

function ricerca() {
	var citta = document.getElementById("citta").value;
	var param = {"citta": citta};
	chiamataAjax(JSON.stringify(param), "ajax/ricercaEnti.php", "application/x-www-form-urlencoded", confermaRicerca);
}

function confermaRicerca(risultato) {
	valorizzaRisposta("tabella", risultato, 0);
}