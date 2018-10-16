<?php 
ini_set('display_errors', 0);//disabilita l'output degli errori php
ini_set('display_startup_errors', 0);

if(!isset($_SESSION)){
    session_start();
}
require_once ("../../common/connessione.php");

function getTableRicerca($query) {//genera la tabella contenente le segnalazioni estratte dalla query in input
    $conn = $GLOBALS['conn'];
    $ruolo = $_SESSION['SESS_RUOLO'];
        
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);
    $colonna = "</td><td>";

    $ret = "<table border='1'><tr><td>ID</td><td>Data segnalazione</td><td>Data chiusura</td><td>Titolo</td><td>Indirizzo</td><td>Priorità</td><td>Stato</td><td>Tipologia</td><td>Commento</td><td></td></tr>";
    while ($row) {
        switch ($row['priorita']) {
            case 1:
                $priorita = "Bassa";
                break;
            case 2:
                $priorita = "Media";
                break;
            case 3:
                $priorita = "Alta";
                break;
            default:
                break;
        }
        if ($row['dataFine'] == null) {
            $dataFine = "null";
        } else {
            $dataFine = $row['dataFine'];
        }
        $comm=convert($row['commentoEnte']);
        $ret .= "<tr><td>" . $row['id'] . $colonna . $row['dataInizio'] . $colonna . $dataFine . $colonna . $row['titolo'] . $colonna . $row['indirizzo'] . $colonna . $priorita . $colonna . $row['stato'] . $colonna . $row['tipologia'] . $colonna . $comm . $colonna;
        $ret .= "<button class=\"btn-blue\" width=20 height=20 onclick=\"modifica('" . $ruolo . "','" . $row['id'] . "')\">APRI</button></td></tr>";
        $row = mysqli_fetch_array($result);
    }
    return $ret = $ret . "</table>";
}

function convert($content) { 
    if(!mb_check_encoding($content, 'UTF-8') 
        OR !($content === mb_convert_encoding(mb_convert_encoding($content, 'UTF-32', 'UTF-8' ), 'UTF-8', 'UTF-32'))) { 

        $content = mb_convert_encoding($content, 'UTF-8'); 

        if (mb_check_encoding($content, 'UTF-8')) { 
            // log('Converted to UTF-8'); 
        } else { 
            // log('Could not converted to UTF-8'); 
        } 
    } 
    return $content; 
} 
?>