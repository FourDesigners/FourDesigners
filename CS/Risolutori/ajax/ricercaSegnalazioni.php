<?php

ini_set('display_errors', 0); //disabilita l'output degli errori php
ini_set('display_startup_errors', 0);

session_start();
require_once ("../../common/connessione.php");
require_once ("ricercaCommon.php");

$json = file_get_contents('php://input');
$obj = json_decode($json, true);

$ruolo = $_SESSION['SESS_RUOLO'];

$titolo = $obj['titolo'];
$dataInizio = $obj['dataInizio'];
$priorita = $obj['priorita'];
$stato = $obj['stato'];
$tipologia = $obj['tipologia'];

//preparazione della query per creare la tabella
$query = "select * from Segnalazione where citta like '" . trim($_SESSION['SESS_CITTA']) . "'";
if ($titolo != null) {
    $query .= " and titolo like '%" . $titolo . "%'";
}
if ($dataInizio != null) {
    $query .= " and dataInizio>='" . $dataInizio . "'";
}

if ($priorita != "null") {
    if ($priorita == "Bassa") {
        $p = 1;
    } else if ($priorita == "Media") {
        $p = 2;
    } else {
        $p = 3;
    }
    $query .= " and priorita=" . $p;
}

if ($stato != "null") {
    $query .= " and stato='" . $stato . "'";
}

if ($tipologia != "null") {
    $query .= " and tipologia='" . $tipologia . "'";
}

$query .= " order by dataInizio desc";
$result = $conn->query($query);
$num = $result->num_rows;
$outp = array();
$outp = $result->fetch_all(MYSQLI_ASSOC);

if ($num >= 1) {
    echo json_encode($outp);
} else {
    echo "0";
}
?>