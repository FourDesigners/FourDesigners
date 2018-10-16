<?php

ini_set('display_errors', 0); //disabilita l'output degli errori php
ini_set('display_startup_errors', 0);

session_start();
require_once ("../../common/connessione.php");

$json = file_get_contents('php://input');
$obj = json_decode($json, true);

$stato = $obj['stato'];
$id = $obj['id'];

$doveId = "' where id=" . $id;

if ($stato != null) {//aggiorna lo stato
    $query = "update Segnalazione set stato='" . $stato . $doveId;
    $result = mysqli_query($conn, $query);
    if ($stato == "Solved" || $stato == "Closed") {
        $query = "update Segnalazione set dataFine='" . date("Y-m-d") . $doveId;
    } else {
        $query = "update Segnalazione set dataFine=null" . $doveId;
    }
    $result = mysqli_query($conn, $query);
}

if ($obj['tipologia'] != null) {//aggiorna la tipologia
    $query = "update Segnalazione set tipologia='" . $obj['tipologia'] . $doveId;
    $result = mysqli_query($conn, $query);
}
$query = "update Segnalazione set commentoEnte='" . $obj['commento'] . $doveId;
$result = mysqli_query($conn, $query);
echo "Modifica effettuata";
?>
