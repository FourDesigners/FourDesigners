<?php
ini_set('display_errors', 0);//disabilita l'output degli errori php
ini_set('display_startup_errors', 0);
session_start();
require_once ('../../common/connessione.php');

$json = file_get_contents('php://input');
$obj = json_decode($json, true);

$query = "select * from Risolutore where email like '" . $obj['email'] . "'";
$result = mysqli_query($conn, $query);
$righe = mysqli_num_rows($result);

if ($righe == 0) {//se l'account non è stato usato lo inserisce
    $pwd = md5($obj['password']);
    $query = "insert into Risolutore (email, descrizione, citta, tipologia, enterKey, account) values ('" . $obj['email'] . "', '" . $obj['descrizione'] . "', '" . $_SESSION['SESS_CITTA'] . "', '" . $obj['tipologia'] . "', '" . $pwd . "', 3)";
    $result = mysqli_query($conn, $query);
    echo "ok";
} else {
    echo "err";
}

?>