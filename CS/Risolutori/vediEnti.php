<?php
session_start();
require_once ("../common/connessione.php");
require_once ("auth.php");

$query = "select email, citta, telefono, attivo from Risolutore where account = 2";
$result = mysqli_query($conn, $query);
$riga = mysqli_fetch_array($result);
?>
<html>
    <head>
        <title>Enti</title>
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

    <body class=" risolutor">
        <div class="corpo">
            <?php include("menu.php") ?>
            <?php if ($_SESSION[$sruolo]==1) { ?>
                <?php
                if ($riga != null) {
                    ?>
                    <div class="contenitoreTab">
                        <div class="tab">
                            <button class="tablinks active">Filtra per comune</button>                    
                        </div>
                        <div id="login" class="tabcontent">
                            <label>
                                Comune: 
                                <input class="mt-2 mb-2" type="text" id="citta" onkeyup="ricerca()">
                            </label>

                        </div>
                    </div>

                    <div class="contTabella">
                        <table border=1 id="tabella" class="mb-0">
                            <tr><td>Città</td><td>Email</td><td>Telefono</td><td></td></tr>

                            <?php
                            while ($riga) {
                                $email = $riga['email'];
                                if ($riga['attivo']) {
                                    $button = "<button class=\"btn-red\" onclick=\"modifica(0, '" . $email . "')\">DISATTIVA</button>";
                                } else {
                                    $button = "<button class=\"btn-minGreen\" onclick=\"modifica(1, '" . $email . "')\">ATTIVA</button>";
                                }
                                echo "<tr><td>" . $riga['citta'] . "</td><td>" . $email . "</td><td>" . $riga['telefono'] . "</td><td style='width:120px;' id='" . $email . "'>" . $button . "</td></tr>";
                                $riga = mysqli_fetch_array($result);
                            }
                            ?>
                        </table>
                    </div>

                <?php } else { ?>
                    <h4 class="mt-3">
                        <?php
                        echo "Non ci sono enti";
                    }
                    ?>
                </h4>
                <p id="demo"></p>
            <?php } else { ?>
                <h2>
                    Non hai i permessi per visualizzare questa pagina
                </h2>
            <?php } ?>
        </div>
        <?php include("footer.php") ?>
        <script src="./js/vediEnti.js" type="text/javascript"></script>
    </body>

</html>