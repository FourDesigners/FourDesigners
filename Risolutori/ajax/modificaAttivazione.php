<?php
ini_set('display_errors', 0);//disabilita l'output degli errori php
ini_set('display_startup_errors', 0);
session_start();
require_once('../../common/connessione.php');

$json = file_get_contents('php://input');
$obj = json_decode($json, true);

$query = "update Risolutore set attivo=".$obj['stato']." where email='".$obj['email']."'";
$result = mysqli_query($conn, $query);
?>