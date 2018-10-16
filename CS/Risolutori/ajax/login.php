<?php
ini_set('display_errors', 0);//disabilita l'output degli errori php
ini_set('display_startup_errors', 0);

session_start();
require_once ("../../common/connessione.php");

$json = file_get_contents('php://input');
$obj = json_decode($json, true);

$query = "select * from Risolutore where email='" . $obj['email'] . "' and enterKey='" . md5($obj['password']) . "'";
$result = mysqli_query($conn, $query);
$righe = mysqli_num_rows($result);
$riga = mysqli_fetch_array($result);

if ($righe > 0) { //verifica se l'utente e la password sono corretti
	if($riga['attivo'] == 1) {//verifica che l'account sia attivo
		if ($obj['checkbox'] == 1) {//nel caso in cui l'utente voglia rimanere loggato
			$implode = "$riga[account]|$riga[email]|$riga[descrizione]|$riga[citta]";//informazioni da memorizzare
			$days = 30; //durata della connessione in giorni
			$cipher = "AES-256-ECB"; //algoritmo di cifratura
			$ENCkey = ':h+RML."tgY1T"V@93PU`"uyQl2S"Y*`*?mtdK7*7Lr8,*R,|Wi*l{$:>hH-&M'; //chiave di cifratura
			$value = base64_encode(openssl_encrypt($implode, $cipher, $ENCkey)); //cifratura ed encode
			setcookie("rememberme", $value, time() + ($days * 24 * 60 * 60 * 1000), '/'); //salvataggio del cookie
		}
		
		//salvataggio in sessione
		$_SESSION['SESS_RUOLO'] = $riga['account'];
		$_SESSION['SESS_EMAIL'] = $riga['email'];
		$_SESSION['SESS_DESCRIZIONE'] = $riga['descrizione'];
		$_SESSION['SESS_CITTA'] = $riga['citta'];
		if ($riga['tipologia'] != null) {
			$_SESSION['SESS_TIPO'] = $riga['tipologia'];
		}
		echo "ok";
	}else {
		echo "Account non piu' attivo";
	}
} else {
    echo "Credenziali non valide";
}
?>