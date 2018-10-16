<?php
ini_set('display_errors', 0);//disabilita l'output degli errori php
ini_set('display_startup_errors', 0);
session_start();
require_once('../../common/connessione.php');

$json = file_get_contents('php://input');
$obj = json_decode($json, true);


modify('Acqua');
modify('Luce');
modify('Spazzatura');
modify('Urbano');

echo "Modifiche completate";

/*
 * Modifica il gruppo per la tipologia di segnalazione passata in input
 */
function modify($gruppo) {
    $conn = $GLOBALS['conn'];
    $obj = $GLOBALS['obj'];
    
    $citta = $_SESSION['SESS_CITTA'];
    $delete = "delete from Associazione where citta ='".$citta;
    $insert = "insert into Associazione (citta, gruppo, tipologia) values ('".$citta;
    
    $low = strtolower($gruppo);
    $query = $delete."' and Tipologia='".$gruppo."'";
    mysqli_query($conn, $query);
    if($obj[$low] != 'null') {
        $query = $insert."', '".$obj[$low]."', '".$gruppo."')";
        mysqli_query($conn, $query);
    }
}
?>