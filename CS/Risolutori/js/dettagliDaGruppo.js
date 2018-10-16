function modifica(id) {
	var select = document.getElementById('stato');
	var stato = select.options[select.selectedIndex].value;
	var commento = document.getElementById("commento").value;
	var nuovo = {"id": id, "stato": stato, "tipologia": "null", "commento": commento};
	chiamataAjax(JSON.stringify(nuovo), "ajax/modificaSegnalazione.php", "application/x-www-form-urlencoded", confermaModifica);
}

function rimanda(id) {
	window.location.href = "rimandaSegnalazione.php?id=" + id
}
