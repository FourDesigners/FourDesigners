<?php
ini_set('display_errors', 0);//disabilita l'output degli errori php
ini_set('display_startup_errors', 0);

session_start();
require_once ("../../common/connessione.php");

$json = file_get_contents('php://input');
$obj = json_decode($json, true);

$pwd = md5($obj['vpassword']);
$query = "select * from Risolutore where email='" . $_SESSION['SESS_EMAIL'] . "' and enterKey='" . $pwd . "'";
$result = mysqli_query($conn, $query);
$righe = mysqli_num_rows($result);

if ($righe > 0) {//se le credenziali sono corrette aggiorna la password
    $pwd = md5($obj['npassword']);
    $query = "update Risolutore set enterKey='" . $pwd . "' where email='" . $_SESSION['SESS_EMAIL'] . "'";
    $result = mysqli_query($conn, $query);
    echo "ok";
} else {
    echo "err";
}
?>