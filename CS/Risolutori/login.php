<!DOCTYPE html>
<html lang="it">

    <head>
        <title>Accesso Risolutori</title>
        <meta http-equiv="Content-Type"
              content="multipart/form-data;charset=ISO-8859-1" />
        <meta name="viewport" content="width=device-width, maximum-scale=1">
        <link rel="stylesheet"
              href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/style.css">
        <script
        src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script
        src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
        <script
        src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
        <script src="../common/commonJavascript.js" type="text/javascript"></script>
        <link rel="icon" href="favicon.ico">

    </head>
    <body class='accesso risolutor'>
        <div class="corpo">
            <?php include("menu.php") ?>
            <h3>Accesso</h3>
            <div class="contenitoreTab">
                <div class="tab">
                    <button id="loginBtn" class="tablinks active"
                            onclick="apriTab('login')">Login</button>
                    <button id="recuperaBtn" class="tablinks"
                            onclick="apriTab('recupera')">Genera Nuova Password</button>
                </div>
                <div id="login" class="tabcontent">
                    <label>Email:
                        <input class="mb-0" type="text" id="emailL" name="emailL">
                    </label>
                    <label>Password:
                        <input class="mb-0" type="password" id="passwordL" name="passwordL">
                    </label>
                    <label class="ricordami">Resta collegato:
                        <input class="mb-0" type="checkbox" name="checkbox" id="checkbox" value="1">
                    </label>
                    <p id="risultato" style="color: red"></p>
                    <input id="btnLogin" type="button" value="Login" class="btn-fullBlue"
                           onclick="login()"> <a href="#" onClick="apriTab('recupera')">Password dimenticata?</a>
                </div>
                <h5 id="check" style="color: green"></h5>
                <div id="recupera" class="tabcontent" style="display: none;">
                    <p>Inserisci l'email registrata a cui verrà inviata una nuova password.</p>
                    <label> Email: 
                        <input type="text" id="emailR" name="emailR">
                    </label>
                    <div class="gifLoad" id="loader">
                            <img src="../img/load.gif">
                        </div> 
                    <p id="risultatoR" style="color: red"></p>
                    <input id="btnRecupera" type="button" value="Recupera" class="btn-fullBlue"
                           onclick="recupera()">
                    <h5 id="checkR" style="color: green"></h5>
                </div>
            </div>
        </div>

        <?php include("footer.php") ?>
        <script src="./js/login.js" type="text/javascript"></script>
    </body>
</html>
