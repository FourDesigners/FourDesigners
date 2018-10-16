<?php
include_once 'common/lastActivity.php';
?>
<!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="multipart/form-data;charset=ISO-8859-1" />
        <meta name="viewport" content="width=device-width, maximum-scale=1">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js"></script>
        <script src="js/segnalazioniSeguite.js" type="text/javascript"></script>
        <script src="common/commonJavascript.js" type="text/javascript"></script>
        <link rel="icon" href="favicon.ico">
    </head>
    <body class="preferiti">
        <div class='corpo'>

            <?php include("menu.php") ?>
            <h1> Segnalazioni preferite</h1>
            <p id='risultati'></p>

            <?php if ($aut) { ?>
                <div class="contTabella" id="divPrimaT" style=" display:none;">
                    <table id="primaTabella" border="1" >
                        <p style="color:green; font-size: xx-large"><b>Novità</b></p>
                        <thead>
                            <tr>
                                <td>TITOLO</td><td>CITTA'</td><td>INDIRIZZO</td><td>PRIORITA</td><td>STATO</td><td>TIPOLOGIA</td><td></td><td></td>

                            </tr>

                        </thead>
                        <tbody className ="tbody1">
                        </tbody >
                    </table>
                </div>
                <div class="contTabella" id="divSecT" style="display:none">
                    <table id="tabella" border="1" >
                        <thead>
                            <tr>
                                <td>TITOLO</td><td>CITTA'</td><td>INDIRIZZO</td><td>PRIORITA</td><td>STATO</td><td>TIPOLOGIA</td><td></td><td></td>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            <?php } else { ?>
                <p><a href="accesso.php"> Registrati o effettua il login</a> per avere la tua pagina delle segnalazioni preferite</p>
            <?php } ?>

        </div>
        <?php include("footer.php") ?>
        <script>
            $(document).ready(function () {
                attivaMenu("segSeguite");
            });

<?php if ($aut) { ?>
                getPreferiti();
<?php } ?>

        </script>

    </body>
</html>
