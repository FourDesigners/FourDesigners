function verificaInfo() {
	var telefono = document.getElementById("telefono").value;
	var sito = document.getElementById("sito").value;
	
	if (telefono.length==10) {
		for(var i = 0; i<10; i++) {
			if(telefono[i]<"0" || telefono[i]>"9") {
				rispostaErr("risultato", "Recapito telefonico non valido", 4);
				return false;
			}
		}
		
		if (sito.indexOf(".")<=-1 && sito!="") {
			rispostaErr("risultato", "URL sito non valido", 4);
			return false;
		}
	}else {
		if(telefono.length!=0) {
			rispostaErr("risultato", "Recapito telefonico non valido", 4);
			return false;
		}
	}
	rispostaPos("risultato", "", 6);
	return true;
}

invioSubmit('telefono','infoSubmit');
invioSubmit('descrizione','infoSubmit');
invioSubmit('sito','infoSubmit');