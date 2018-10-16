<?php

ini_set('display_errors', 0); //disabilita l'output degli errori php
ini_set('display_startup_errors', 0);

session_start();
require_once ("../../common/connessione.php");
require_once ("ricercaCommon.php");

$json = file_get_contents('php://input');
$obj = json_decode($json, true);

$dataInizio = $obj['dataInizio'];
$priorita = $obj['priorita'];
$stato = $obj['stato'];
$titolo = $obj['titolo'];

//preparazione della query per creare la tabella
$query = "select gruppo from Associazione where citta like '" . trim($_SESSION['SESS_CITTA']) . "' and tipologia like '" . $_SESSION['SESS_TIPO'] . "'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);
if ($row['gruppo'] == $_SESSION['SESS_EMAIL']) {
    $query = "select * from Segnalazione where citta like '" . trim($_SESSION['SESS_CITTA']) . "' and tipologia like '" . $_SESSION['SESS_TIPO'] . "'";
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
}
?>