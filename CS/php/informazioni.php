<?php

include_once '../common/connessione.php';
include_once '../common/lastActivity.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $json = file_get_contents('php://input');
    $obj= json_decode($json);

    $verifica="SELECT email, citta, immagine, telefono, descrizione, sito  from Risolutore where citta = '" .$obj->citta. "' and account = 2";
    $risultato=$conn->query($verifica);
    $riga=$risultato->fetch_array(MYSQLI_ASSOC);
    $num = $risultato->num_rows;

    if ($num >= 1 ) {
        echo json_encode($riga);
    } else {
        echo "0";
    }

} else {
    echo 'ERRORE';
}

  $conn->close();

  ?>
