function modifica(id) {
	var select = document.getElementById('stato');
	var stato = select.options[select.selectedIndex].value;
	
	select = document.getElementById('tipologia');
	var tipologia = select.options[select.selectedIndex].value;
	
	var commento = document.getElementById("commentoEnte").value;
	
	if (stato!='Pending' && tipologia!='Altro') {
		valorizzaRisposta("demo", "Non e' possibile assegnare e modificare lo stato", 4);
	} else {
		var nuovo = {"id": id, "stato": stato, "tipologia": tipologia, "commento": commento};
		chiamataAjax(JSON.stringify(nuovo), "ajax/modificaSegnalazione.php", "", confermaModifica);
	}
}