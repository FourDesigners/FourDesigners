function apriTab(tab) {//apre il tab in input
    if (!$('#' + tab).is(':visible')) {
        $("#login").hide("slow");
        $("#recupera").hide("slow");
        $("#" + tab).show("slow");
        document.getElementById("loginBtn").className = "tablinks";
        document.getElementById("recuperaBtn").className = "tablinks";
        document.getElementById(tab + "Btn").classList.add('active');
    }
}

function login() {//effettua il login
    var emailL = document.getElementById('emailL').value;
    var passwordL = document.getElementById('passwordL').value;
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    if (!re.test(emailL)) {
        rispostaErr("risultato", "Email non valida", 4);

        return false;
    }

    if (passwordL == "" || emailL == "")
    {
        rispostaErr("risultato", "Compila tutti i campi", 4);
        return false;
    }

    var checkboxValue = 0;
    if (document.getElementById("checkbox").checked) {
        checkboxValue = 1;
    }

    var accountLogin = {
        "email": emailL,
        "password": passwordL,
        "checkbox": checkboxValue
    };

    chiamataAjax(JSON.stringify(accountLogin), "ajax/login.php", "application/x-www-form-urlencoded", confermaLogin);

}

function confermaLogin(risultato) {//azioni al seguito della risposta
    valorizzaRisposta("risultato", "", 0);

    if (risultato != "ok") {
        rispostaErr("risultato", risultato, 4);
    } else {
        rispostaPos("check", "Loggato!", 0);
        setTimeout(function () {
            window.location.href = './';
        }, 1000);
    }
}


function recupera() {//recupera la password
    var emailR = document.getElementById('emailR').value;
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    if (!re.test(emailR)) {
        rispostaErr("risultatoR", "Email non valida", 4);
        return false;
    }

    if (emailR == "")
    {
        rispostaErr("risultatoR", "Compila tutti i campi", 4);
        return false;
    }

    var accountLogin = {
        "email": emailR
    };
    $("#loader").show();
    chiamataAjax(JSON.stringify(accountLogin), "ajax/recuperapwd.php", "application/x-www-form-urlencoded", confermaRecupera);

}

function confermaRecupera(risultato) {//azioni dopo il recupero psw
    valorizzaRisposta("risultatoR", "", 0);
    $("#loader").hide();
    if (risultato != "ok") {
        rispostaErr("risultatoR", risultato, 4);
    } else {
        rispostaPos("checkR", "La nuova password<br>è stata inviata per email.", 4);
    }
}

invioSubmit('emailL', 'btnLogin');
invioSubmit('passwordL', 'btnLogin');
invioSubmit('emailR', 'btnRecupera');
