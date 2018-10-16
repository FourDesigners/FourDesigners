<?php
session_start();
require_once ("../common/connessione.php");
require_once ("auth.php");

$selectFromRisolutore = "select email, descrizione from Risolutore where citta='";
$selectFromAssociazione = "select * from Associazione where citta='";
$citta = $_SESSION['SESS_CITTA'];
$email = 'email';
$descrizione = 'descrizione';
$campoGruppo = 'gruppo';
$optionS = "<option value='";
$optionF = "</option>";
?>
<!DOCTYPE html>
<html lang="it">

    <head>
        <title>Home - Risolutori</title>
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
    <body class='vediGruppi risolutor'>
        <div class="corpo">
            <?php include("menu.php") ?>
            <?php if ($_SESSION[$sruolo] == 2) { ?>
                <div class="contenitoreTab">
                    <div class="tab ">                    
                        <button class="tablinks active"> GRUPPI ASSOCIATI</button>
                    </div>
                    <div id="login" style="width: 100%;">
                        <div class="contTabella" style="margin-top: 30px">
                            <table class="mb-4" border="1">
                                <tr>
                                    <td>Tipologia</td>
                                    <td>Gruppo</td>
                                </tr>
                                <tr>
                                    <td>Acqua</td>
                                    <td>
                                        <?php
                                        $query2 = $selectFromAssociazione . $citta . "' and tipologia='Acqua'";
                                        $result2 = mysqli_query($conn, $query2);
                                        $row2 = mysqli_fetch_array($result2);
                                        if ($row2 != null) {
                                            $gruppo2 = $row2[$campoGruppo];
                                        } else {
                                            $gruppo2 = "no";
                                        }
                                        $selected = "selected";
                                        ?>
                                        <select class="selecRisolutori"  id="acqua">
                                            <option value='null' <?php
                                            if ($gruppo2 == 'no') {
                                                echo $selected;
                                            }
                                            ?>>---</option>
                                                    <?php
                                                    $query = $selectFromRisolutore . $citta . "' and tipologia='Acqua' and account=3";
                                                    $result = mysqli_query($conn, $query);
                                                    $row = mysqli_fetch_array($result);
                                                    while ($row != null) {
                                                        $gruppo = $row[$email];
                                                        if ($gruppo != $gruppo2) {
                                                            echo $optionS . $row[$email] . "' > " . $row[$descrizione] . " --- " . $row[$email] . $optionF;
                                                        } else {
                                                            echo $optionS . $row[$email] . "' " . $selected . " > " . $row[$descrizione] . " --- " . $row[$email] . $optionF;
                                                        }
                                                        $row = mysqli_fetch_array($result);
                                                    }
                                                    ?>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Luce</td>
                                    <td>
                                        <?php
                                        $query3 = $selectFromAssociazione . $citta . "' and tipologia='Luce'";
                                        $result3 = mysqli_query($conn, $query3);
                                        $row3 = mysqli_fetch_array($result3);
                                        if ($row3 != null) {
                                            $gruppo3 = $row3[$campoGruppo];
                                        } else {
                                            $gruppo3 = "no";
                                        }
                                        $selected = "selected";
                                        ?>
                                        <select class="selecRisolutori" id="luce">
                                            <option value='null' <?php
                                            if ($gruppo3 == 'no') {
                                                echo $selected;
                                            }
                                            ?>>---</option>
                                                    <?php
                                                    $query = $selectFromRisolutore . $citta . "' and tipologia='Luce' and account=3";
                                                    $result = mysqli_query($conn, $query);
                                                    $row = mysqli_fetch_array($result);
                                                    while ($row != null) {
                                                        $gruppo = $row[$email];
                                                        if ($gruppo != $gruppo3) {
                                                            echo $optionS . $row[$email] . "' > " . $row[$descrizione] . " --- " . $row[$email] . $optionF;
                                                        } else {
                                                            echo $optionS . $row[$email] . "' " . $selected . " > " . $row[$descrizione] . " --- " . $row[$email] . $optionF;
                                                        }
                                                        $row = mysqli_fetch_array($result);
                                                    }
                                                    ?>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Spazzatura</td>
                                    <td>
                                        <?php
                                        $query4 = $selectFromAssociazione . $citta . "' and tipologia='Spazzatura'";
                                        $result4 = mysqli_query($conn, $query4);
                                        $row4 = mysqli_fetch_array($result4);
                                        if ($row4 != null) {
                                            $gruppo4 = $row4[$campoGruppo];
                                        } else {
                                            $gruppo4 = "no";
                                        }
                                        ?>
                                        <select class="selecRisolutori" id="spazzatura">
                                            <option value='null' <?php
                                            if ($gruppo4 == 'no') {
                                                echo $selected;
                                            }
                                            ?>>---</option>
                                                    <?php
                                                    $query = $selectFromRisolutore . $citta . "' and tipologia='Spazzatura' and account=3";
                                                    $result = mysqli_query($conn, $query);
                                                    $row = mysqli_fetch_array($result);
                                                    while ($row != null) {
                                                        $gruppo = $row[$email];
                                                        if ($gruppo != $gruppo4) {
                                                            echo $optionS . $row[$email] . "' > " . $row[$descrizione] . " --- " . $row[$email] . $optionF;
                                                        } else {
                                                            echo $optionS . $row[$email] . "' " . selected . " > " . $row[$descrizione] . " --- " . $row[$email] . $optionF;
                                                        }
                                                        $row = mysqli_fetch_array($result);
                                                    }
                                                    ?>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Urbano</td>
                                    <td>
                                        <?php
                                        $query5 = $selectFromAssociazione . $citta . "' and tipologia='Urbano'";
                                        $result5 = mysqli_query($conn, $query5);
                                        $row5 = mysqli_fetch_array($result5);
                                        if ($row5 != null) {
                                            $gruppo5 = $row5[$campoGruppo];
                                        } else {
                                            $gruppo5 = "no";
                                        }
                                        ?>
                                        <select class="selecRisolutori" id="urbano">
                                            <option value='null' <?php
                                            if ($gruppo5 == 'no') {
                                                echo $selected;
                                            }
                                            ?>>---</option>
                                                    <?php
                                                    $query = $selectFromRisolutore . $citta . "' and tipologia='Urbano' and account=3";
                                                    $result = mysqli_query($conn, $query);
                                                    $row = mysqli_fetch_array($result);
                                                    while ($row != null) {
                                                        $gruppo = $row[$email];
                                                        if ($gruppo != $gruppo5) {
                                                            echo $optionS . $row[$email] . "' > " . $row[$descrizione] . " --- " . $row[$email] . $optionF;
                                                        } else {
                                                            echo $optionS . $row[$email] . "' " . $selected . " > " . $row[$descrizione] . " --- " . $row[$email] . $optionF;
                                                        }
                                                        $row = mysqli_fetch_array($result);
                                                    }
                                                    ?>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <p id="demo"></p>
                        <button class="btn-green mb-3" type="button" onclick="modifica()">Conferma modifiche</button>


                    </div>
                </div>
            <?php } else { ?>
                <h2>
                    Non hai i permessi per visualizzare questa pagina
                </h2>
            <?php } ?>
        </div>

        <?php include("footer.php") ?>
        <script src="./js/vedigruppi.js" type="text/javascript"></script>
    </body>
</html>
