google.charts.load('current', {'packages': ['corechart']});

function valueCitta() {
        var citta = {
          "op": "citta",
          "aut": 'ente',
          "citta" : ente,
            "data": document.getElementById('data').value
        };
        chiamataAjax(JSON.stringify(citta), "../php/calcolaStatistica.php", "application/json", visualizzaEnte);
}


function visualizzaEnte(param)
{
  if (param == "NOT")  {
      rispostaErr('risposta', "Statistiche non disponibili per questa città", 0);
  }
    else if (param == "0")  {
      rispostaErr('risposta', "Non sono ancora state effettuate<br>segnalazioni in questa città", 0);
  }
    else if (param == "NOTCIVIC")  {
      rispostaErr('risposta', "Questa città  non utilizza l'applicativo Civic Sense", 0);

  } else {

      var city = JSON.parse(param);
      drawCitta(city);
       $("#riga").show("slow");
    }


}
