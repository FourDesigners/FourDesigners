<?php
ini_set('display_errors', 0);//disabilita l'output degli errori php
ini_set('display_startup_errors', 0);
session_start();
require_once ("../../common/connessione.php");

$json = file_get_contents('php://input');
$obj = json_decode($json, true);

$query = "select * from Risolutore where email like '" . trim($obj[email]) . "'";
$result = mysqli_query($conn, $query);
$righe = mysqli_num_rows($result);

if ($righe == 0) {//se l'account non è presente continua
    $query = "select * from Risolutore where citta like '" . trim($obj[citta]) . "' and account=2";
    $result = mysqli_query($conn, $query);
    $righe = mysqli_num_rows($result);
    if ($righe == 0) {//se il comune non è presente prosegue con l'inserimento
        $pwd = md5(trim($obj[password]));
        $query = "insert into Risolutore (email, enterKey, citta, account) values ('" . trim($obj[email]) . "', '" . $pwd . "', '" . trim($obj[citta]) . "', 2)";
        $result = mysqli_query($conn, $query);
        echo "ok";
    } else {
        echo "Esiste già un comune per " . trim($obj[citta]);
    }
} else {
    echo "account";
}
?>