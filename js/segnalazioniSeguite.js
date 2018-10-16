function getPreferiti() {
    var segnal = {"op": "get"};
    chiamataAjax(JSON.stringify(segnal), "php/preferiti.php", "application/json", creaTabella);
}

function creaTabella(risultato) {
//    document.getElementById("risultati").innerHTML=risultato;
    var obj=JSON.parse(risultato);
    var cont = false;
    if (obj != "") {
        $("#divSecT").show("slow");
        
        for (var i in obj) {
            if (obj[i].dataVisto < obj[i].dataModifica)
            {
                inserisciElemento(obj[i], "primaTabella", "tbody1");
                cont=true;
            } else {
                inserisciElemento(obj[i], "tabella", "tbody");
            }
            
        }
        if (cont)
            $("#divPrimaT").show("slow");


    } else {
        $("#divSecT").hide("slow");
        $("#divPrimaT").hide("slow");
        rispostaErr("risultati", "Non hai segnalazioni preferite", 4);
    }

}

function inserisciElemento(segnalazione, tabella, campo)
{
    var tableRef = document.getElementById(tabella).getElementsByTagName('tbody')[0];
    // Insert a row in the table at the last row
    var row = tableRef.insertRow(tableRef.rows.length);
    row.id =tabella+"_id_"+segnalazione.id;
    
    var cell1 = row.insertCell(0);
    cell1.innerHTML = segnalazione.titolo;
    var cell2 = row.insertCell(1);
    cell2.innerHTML = segnalazione.citta;
    var cell3 = row.insertCell(2);
    cell3.innerHTML = segnalazione.indirizzo;
    var cell4 = row.insertCell(3);
    calcolaPriorita(segnalazione.priorita, cell4);
    var cell5 = row.insertCell(4);
    cell5.innerHTML = segnalazione.stato;
    var cell6 = row.insertCell(5);
    cell6.innerHTML = segnalazione.tipologia;
    var cell7 = row.insertCell(6);
    var a = document.createElement('a');
    a.href = "ricercaSegnalazione.php?x=" + segnalazione.id;
    var btn = document.createElement("BUTTON");
    btn.setAttribute("class", "btn-blue");
    var t = document.createTextNode("APRI");
    btn.appendChild(t);
    a.appendChild(btn);
    cell7.appendChild(a);

    var cell8 = row.insertCell(7);
    var button = document.createElement('a');
    button.onclick = function () {
        removePref(segnalazione.id, tabella);
    };
    var btn2 = document.createElement("BUTTON");
    btn2.setAttribute("class", "btn-blue");
    var text = document.createTextNode("NON SEGUIRE");
    btn2.appendChild(text);
    button.appendChild(btn2);
    cell8.appendChild(button);

}

var remRow;
function removePref(segnalazione, tabella) {
    remRow="#"+tabella+"_id_"+segnalazione;
    var op = "remove";
    var segnal = {
        "id": segnalazione,
        "op": op
    };
    chiamataAjax(JSON.stringify(segnal), "php/preferiti.php", "application/json", risultato);
}


function risultato(string){
    if (string == ""){
        $(remRow).hide("slow");
        
    } else {
        document.getElementById("risultati").innerHTML = "Errore nell'operazione";
    }
}




