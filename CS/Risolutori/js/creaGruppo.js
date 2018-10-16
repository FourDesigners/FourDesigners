function creagruppo() {
	var email = document.getElementById('emailgruppo').value;
	var descrizione = document.getElementById('descrizionegruppo').value;
	var select = document.getElementById('tipologia');
	var tipologia = select.options[select.selectedIndex].value;
	var password = document.getElementById('passwordgruppo').value;
	var cpassword = document.getElementById('cpasswordgruppo').value;
	var filtro = /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/; 

	//effettuo i controlli formali e una volta superati procedo con l'elaborazione
	if (!filtro.test(email)) {
		rispostaErr("risultato", "Attenzione, indirizzo email non valido", 4);
	} else {
		if(password == "") {
			rispostaErr("risultato", "Attenzione, password vuota", 4);
		} else {
			if(password != cpassword) {
				rispostaErr("risultato", "Attenzione, le due password non coincidono", 4);
			} else {
				var gruppo = {"email": email, "descrizione": descrizione, "tipologia": tipologia, "password": password};
				chiamataAjax(JSON.stringify(gruppo), "ajax/creaGruppo.php", "application/x-www-form-urlencoded", confermacreagruppo);
			}
		}
	}
} 

function confermacreagruppo(risultato){
    if(risultato=="ok"){
        rispostaPos("risultato", "Account creato!", 0);
        setTimeout(function () {
            window.location.href = 'creaGruppo.php';
        }, 2000);
    }
    else{
        rispostaErr("risultato", "Attenzione, l'email inserita<br>è già registrata", 6);
    }
	
}

invioSubmit('emailgruppo','btnCrea');
invioSubmit('descrizionegruppo','btnCrea');
invioSubmit('tipologia','btnCrea');
invioSubmit('passwordgruppo','btnCrea');
invioSubmit('cpasswordgruppo','btnCrea');
