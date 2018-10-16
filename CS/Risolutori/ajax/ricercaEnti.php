<?php
ini_set('display_errors', 0);//disabilita l'output degli errori php
ini_set('display_startup_errors', 0);

session_start();
require_once ("../../common/connessione.php");

$json = file_get_contents('php://input');
$obj = json_decode($json, true);

$query = "select email, citta, telefono, attivo from Risolutore where account=2 and citta like '%" .$obj['citta']. "%'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);
if($row) {//se ci sono degli enti fornisce l'elenco permettendo l'attivazione/disattivazione
	?>
	<table border="1" id="tabella">
	<tr><td>Citta'</td><td>Email</td><td>Telefono</td><td></td></tr>
	<?php
	while($row) {
	    $email = $row['email'];
		if($row['attivo']) {
			$button = "<button class=\"btn-red\" onclick=\"modifica(0, '".$email."')\">DISATTIVA</button>";
		}else {
			$button = "<button class=\"btn-minGreen\" onclick=\"modifica(1, '".$email."')\">ATTIVA</button>";
		}
		echo "<tr><td>".$row['citta']."</td><td>".$email."</td><td>".$row['telefono']."</td><td id='".$email."' >".$button."</td></tr>";
		$row = mysqli_fetch_array($result);
	}
	echo "</table>";
}else {
	echo "";
}
?>