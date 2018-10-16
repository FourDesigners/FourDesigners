<?php
include_once 'common/lastActivity.php';
?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <title>Accesso</title>
        <meta http-equiv="Content-Type" content="multipart/form-data;charset=ISO-8859-1" />
        <meta name="viewport" content="width=device-width, maximum-scale=1">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
        <script src="common/commonJavascript.js" type="text/javascript"></script>
        <script src="js/accesso.js" type="text/javascript"></script>
        <link rel="icon" href="favicon.ico">

    </head>
    <body class='accesso'>
        <div class="corpo" >
            <?php include("menu.php") ?>
            <?php if ($aut) { ?>
                <div class="contenitoreTab">
                    <div class="tab">
                        <button class="tablinks active" onclick="apriTab('login')">Modifica Password</button>
                    </div>
                    <div id="modificaPassword" class="tabcontent">
                        <label>Password attuale:                         
                            <input type="password" id="passwordA" name="passwordA">
                        </label>
                        <label>Nuova Password: 
                            <input type="password" id="nuovaP" name="nuovaP">
                        </label>
                        <label>Conferma Password: 
                            <input type="password" id="confermaP" name="confermaP">
                        </label>
                        
                        <input id="btnModPass" type="button" value="Modifica" class="btn-fullBlue" onclick="modificaP()">
                        <p id="err" style="color:red"></p>
                        <h5 id="check" style="color:green"></h5>
                    </div>                    
                </div>
            <?php } else {
                ?>
                <h3>Accesso</h3>
                <div class="contenitoreTab">
                    <div class="tab">
                        <button id="loginBtn" class="tablinks active" onclick="apriTab('login')" >Login</button>
                        <button id="createBtn" class="tablinks" onclick="apriTab('create')">Crea Account</button>
                        <button id="recuperaBtn" class="tablinks" onclick="apriTab('recupera')">Genera Nuova Password</button>
                    </div>
                    <div id="login" class="tabcontent">
                        <label>Email:                         
                            <input type="text" id="emailL" name="emailL">
                        </label>
                        <label>Password: 
                            <input type="password" id="passwordL" name="passwordL">
                        </label>
                        <label class="ricordami">Resta collegato: 
                            <input class="mb-0" type="checkbox" name="checkboxL" id="checkboxL" value="1">
                        </label>
                        
                        <input id="btnLogin" type="button" value="Login" class="btn-fullBlue" onclick="login()">

                        <a href="#" onClick="apriTab('recupera')">Password dimenticata?</a>
                    </div>
                    
                    <div id="create" class="tabcontent " style="display: none;">
                        <h2 >Registrazione</h2>
                        <label>Email: 
                            <input type="text" id="email" name="email" >
                        </label>
                        <label>
                            Nickname: 
                            <input type="text" id="nickname" name="nickname" >
                        </label>
                        <label>Password: 
                            <input type="password" id="password" name="password">
                        </label>
                        <label>Conferma password: 
                            <input type="password"  id="conpas" name="conpas">                    
                        </label>
                        
                        <input id="btnRegistra" type="button" value="Registrati" class="btn-fullBlue" onclick="registra()">
                        
                    </div>
                    <div id="recupera" class="tabcontent" style="display: none;">
                        <p>Inserisci la tua mail a cui verrà inviata una nuova password.</p>
                        <label>Email:                         
                            <input type="text" id="emailRecuper" name="emailRecupero">
                        </label>
                        
                        <input id="btnRecuperaP" type="button" value="Recupera" class="btn-fullBlue" onclick="recuperaP()">
                        <div class="gifLoad" id="loader">
                            <img src="img/load.gif">
                        </div> 
                    </div>
                    <p id="err" style="color:red"></p>
                    <h5 id="check" style="color:green"></h5>
                </div>
            <?php } ?>
        </div>
        <?php include("footer.php") ?>
        <script>
        $(document).ready(function () {
                attivaMenu("accedi");
            });
            
        invioSubmit("emailL", "btnLogin");
        invioSubmit("passwordL", "btnLogin");
        invioSubmit("emailRecuper", "btnRecuperaP");
        invioSubmit("passwordA", "btnModPass");
        invioSubmit("nuovaP", "btnModPass");
        invioSubmit("confermaP", "btnModPass");
        invioSubmit("email", "btnRegistra");
        invioSubmit("nickname", "btnRegistra");
        invioSubmit("password", "btnRegistra");
        invioSubmit("conpas", "btnRegistra");


        </script>
    </body>
</html>
