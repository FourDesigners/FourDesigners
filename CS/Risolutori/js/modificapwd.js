function modifica() {//modifica la password
	var vpassword = document.getElementById('vpassword').value;
	var npassword = document.getElementById('npassword').value;
	var cnpassword = document.getElementById('cnpassword').value;
	
	if((vpassword=="") || (npassword=="")) {
		rispostaErr("demo", "Attenzione, password vuota", 4);
	} else {
		if(vpassword == npassword) {
			rispostaErr("demo", "Attenzione, la nuova password non e' diversa", 4);
		} else {
			if(npassword != cnpassword) {
				rispostaErr("demo", "Attenzione, confermare la nuova password", 4);
			} else {
				var account = {"vpassword": vpassword, "npassword": npassword};
				chiamataAjax(JSON.stringify(account), "ajax/modificapwd.php", "application/x-www-form-urlencoded", confermamodifica);
			}
		}
	}
}

function confermamodifica(risultato) {
    if(risultato=="err"){
        rispostaErr("demo", "Credenziali non valide", 8);
    }
    else{
        rispostaPos("demo", "Password modificata con successo", 4);
        setTimeout(function () {
			window.location.href = './';
		}, 2000);
    }
	
}