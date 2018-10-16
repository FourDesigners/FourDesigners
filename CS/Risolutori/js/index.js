/*
 * SESSIONE ADMIN
 */

function creaente() {
    var email = document.getElementById('emailente').value;
    var citta = document.getElementById('cittaente').value;
    var password = document.getElementById('passwordente').value;
    var cpassword = document.getElementById('cpasswordente').value;
    var filtro = /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/;

    //effettuo i controlli formali e procedo con l'elaborazione
    if (!filtro.test(email)) {
        rispostaErr("risultatocreaente", "Attenzione, indirizzo email non valido", 4);
    } else {

        var matches = citta.match(/\d+/g);
        if (matches != null || citta == "") {
            rispostaErr("risultatocreaente", "Attenzione, citta' non valida", 4);
        } else {
            citta = citta[0].toUpperCase() + citta.slice(1);
            document.getElementById('cittaente').value = citta;
            if (!elencoComuni.includes(citta)) {
                rispostaErr("risultatocreaente", "Attenzione,<br>la città inserita<br>non corrisponde a una città italiana", 4);
            } else {
                if (password == "") {
                    rispostaErr("risultatocreaente", "Attenzione, password vuota", 4);
                } else {
                    if (password != cpassword) {
                        rispostaErr("risultatocreaente", "Attenzione, le due password non coincidono", 4);
                    } else {
                        var ente = {"email": email, "citta": citta, "password": password};

                        chiamataAjax(JSON.stringify(ente), "ajax/creaEnte.php", "application/x-www-form-urlencoded", confermaCreaEnte);
                    }
                }
            }
        }
    }
}

function confermaCreaEnte(risultato) {//mostro il risultato dell'elaborazione
    if (risultato == "ok") {
        rispostaPos("risultatocreaente", "Ente creato correttamente!", 4);
        setTimeout(function () {
            window.location.href = '.';
        }, 2000);
    } else if (risultato == "account") {
        rispostaErr("risultatocreaente", "Email già registrata!", 4);
    } else {
        rispostaErr("risultatocreaente", risultato, 4);
    }

}

invioSubmit('emailente', 'btncreaente');
invioSubmit('cittaente', 'btncreaente');
invioSubmit('passwordente', 'btncreaente');
invioSubmit('cpasswordente', 'btncreaente');

/*
 * SESSIONE ENTE
 */

function ricerca() {//ricerca delle segnalazioni per l'ente
    var titolo = document.getElementById("titolo").value;
    var dataInizio = document.getElementById("dataInizio").value;
    var select = document.getElementById("priorita");
    var priorita = select.options[select.selectedIndex].value;
    select = document.getElementById("stato");
    var stato = select.options[select.selectedIndex].value;
    select = document.getElementById("tipologia");
    var tipologia = select.options[select.selectedIndex].value;

    var param = {"titolo": titolo, "dataInizio": dataInizio, "priorita": priorita, "stato": stato, "tipologia": tipologia};
    chiamataAjax(JSON.stringify(param), "ajax/ricercaSegnalazioni.php", "application/x-www-form-urlencoded", confermaRicerca);
}

function confermaRicerca(risultato) {
    if (risultato == "0") {
        rispostaErr("demo", "Non ci sono segnalazioni", 0);
    } else {
        var segnalazione = JSON.parse(risultato);
        if (segnalazione.id) { //se il risultato della ricerca ï¿½ una sigola segnalazione
            tabRisolutori(segnalazione, 2); //inserisce la segnalazione in una riga della tabella
        } else {
            for (var i in segnalazione) { //inserisce ogni segnalazione in una riga della tabella
                tabRisolutori(segnalazione[i], 2);
            }
        }
        
    }
}

/*
 * SESSIONE GRUPPO
 */
function ricercaGruppo() {//ricerca segnalazioni per il gruppo
    var titolo = document.getElementById("titolo").value;
    var dataInizio = document.getElementById("dataInizio").value;
    var select = document.getElementById("priorita");
    var priorita = select.options[select.selectedIndex].value;
    select = document.getElementById("stato");
    var stato = select.options[select.selectedIndex].value;

    var param = {"titolo": titolo, "dataInizio": dataInizio, "priorita": priorita, "stato": stato, "tipologia": "Altro"};
    chiamataAjax(JSON.stringify(param), "ajax/ricercaSegnalazioniGruppo.php", "application/x-www-form-urlencoded", confermaRicercaGruppo);
}
function confermaRicercaGruppo(risultato) {
    if (risultato == "0") {
        rispostaErr("demo", "Non ci sono segnalazioni", 0);
    } else {
        var segnalazione = JSON.parse(risultato);
        if (segnalazione.id) { //se il risultato della ricerca ï¿½ una sigola segnalazione
            tabRisolutori(segnalazione, 3); //inserisce la segnalazione in una riga della tabella
        } else {
            for (var i in segnalazione) { //inserisce ogni segnalazione in una riga della tabella
                tabRisolutori(segnalazione[i], 3);
            }
        }
        
    }
}
/*
 * COMUNE
 */
function modifica(ruolo, id) {
    if (ruolo == 2) {
        window.location.href = "dettagliDaEnte.php?id=" + id;
    } else {
        window.location.href = "dettagliDaGruppo.php?id=" + id;
    }
}
