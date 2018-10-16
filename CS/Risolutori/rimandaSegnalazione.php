<?php
include('../common/connessione.php');
$query = "update Segnalazione set tipologia='Altro', stato='Pending' where id=".$_GET['id'];
$result = mysqli_query($conn, $query);
header('location: ./');
?>