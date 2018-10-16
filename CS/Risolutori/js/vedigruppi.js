function modifica() {
	var select = document.getElementById('acqua');
	var acqua = select.options[select.selectedIndex].value;
	
	select = document.getElementById('luce');
	var luce = select.options[select.selectedIndex].value;
	
	select = document.getElementById('spazzatura');
	var spazzatura = select.options[select.selectedIndex].value;
	
	select = document.getElementById('urbano');
	var urbano = select.options[select.selectedIndex].value;
	
	var obj = {"acqua": acqua, "luce": luce, "spazzatura": spazzatura, "urbano": urbano};
	chiamataAjax(JSON.stringify(obj), "ajax/modificaGruppi.php", "application/x-www-form-urlencoded", confermaModifica);

}

function confermaModifica(risultato) {
	rispostaPos("demo", risultato, 6);
}