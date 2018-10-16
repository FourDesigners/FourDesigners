function apriTab(tab) {
    if (!$('#' + tab).is(':visible')) {
        $("#login").hide("slow");
        $("#create").hide("slow");
        $("#recupera").hide("slow");
        $("#" + tab).show("slow");
        document.getElementById("loginBtn").className = "tablinks";
        document.getElementById("createBtn").className = "tablinks";
        document.getElementById("recuperaBtn").className = "tablinks";
        document.getElementById(tab + "Btn").classList.add('active');
        document.getElementById("check").innerHTML = "";
        document.getElementById("err").innerHTML = "";
    }
}


function login() {

    var emailL = document.getElementById('emailL').value;
    var passwordL = document.getElementById('passwordL').value;

    var checkboxValue = 0;
    if (document.getElementById("checkboxL").checked) {
        checkboxValue = 1;
    }

    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (!re.test(emailL)) {
         rispostaErr("err", "Email non valida", 4);
        return false;
    }
    if (passwordL == "" || emailL == "") {
        rispostaErr("err", "Compila tutti i campi", 4);
        return false;
    } else {

        var accountLogin = {
            "op": "login",
            "emailL": document.getElementById("emailL").value,
            "passwordL": document.getElementById("passwordL").value,
            "checkboxL": checkboxValue
        };

        chiamataAjax(JSON.stringify(accountLogin), "php/loginRegistrazione.php", "application/json", confermaLogin);
    }
}

function confermaLogin(risultato) {
    document.getElementById("err").innerHTML = "";

    if (risultato != "ok") {
        rispostaErr("err", risultato, 4);
    } else {
        rispostaPos("check", "Loggato!", 4);
        setTimeout(function () {
            window.location.href = 'segnalazioniSeguite.php';
        }, 1000);
    }
}


function registra() {
    var confirm_password = document.getElementById("conpas").value;
    var password = document.getElementById("password").value;
    var email = document.getElementById('email').value;
    var nickname = document.getElementById("nickname").value;
    document.getElementById("err").scrollIntoView();
    //pattern
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (!re.test(email)) {
        rispostaErr("err", "Email non valida", 4);
        return false;
    }
    if (password == "" || confirm_password == "" || email == "" || nickname == ""){
        rispostaErr("err", "Compila tutti i campi", 4);
        return false;
    } else if (password !== confirm_password){
        rispostaErr("err", "Le due password non corrispondono", 4);
        return false;
    } else {
        var account = {
            "op": "registra",
            "email": document.getElementById("email").value,
            "nickname": document.getElementById("nickname").value,
            "password": document.getElementById("password").value
        };

        chiamataAjax(JSON.stringify(account), "php/loginRegistrazione.php", "application/json", confermaRegistrazione);
    }
}

function confermaRegistrazione(risultato) {

    document.getElementById("err").innerHTML = "";
    if (risultato != "ok") {
        rispostaErr("err", risultato, 4);
    } else {
        rispostaPos("err", "Account registrato!", 4);
        setTimeout(function () {
            window.location.reload()
        }, 1000);
    }
}

function modificaP() {
    var passA = document.getElementById("passwordA").value;
    var nuovaP = document.getElementById("nuovaP").value;
    var confermaP = document.getElementById('confermaP').value;

    if (passA == "" || nuovaP == "" || confermaP == "") {
        rispostaErr("err", "Compila tutti i campi!", 4);
        return false;
    } else if (nuovaP !== confermaP) {
        rispostaErr("err", "La passwod di conferma<br>non corrisponde", 4);
        return false;
    } else {
        var account = {
            "op": "modificaP",
            "password": passA,
            "nuovaP": nuovaP
        };
        chiamataAjax(JSON.stringify(account), "php/loginRegistrazione.php", "application/json", confermaModifica);
    }
}
function confermaModifica(risultato) {
    document.getElementById("err").innerHTML = "";
    if (risultato != "ok") {
        rispostaErr("err", risultato, 4);
    } else {
        rispostaPos("check", "Modifica password<br>effettuata!", 4);
        setTimeout(function () {
            window.location.reload()
        }, 2000);
    }
}
function recuperaP() {
    document.getElementById("check").innerHTML = "";
    var email = document.getElementById('emailRecuper').value;
    var filtro = /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/;
    if (!filtro.test(email)) {
        rispostaErr("err", "Attenzione, indirizzo email non valido", 4);
        return false;
    }
    document.getElementById("err").innerHTML = "";
    $("#loader").show();
    var recuper = {"email": email};
    chiamataAjax(JSON.stringify(recuper), "php/recuperapwdSegn.php", "application/json", confRec)
}
function confRec(result) {
    $("#loader").hide();
    if (result == "ok") {
        rispostaPos("check", "Email Inviata", 4);
    } else {
        rispostaErr("check", result, 4);
    }
}