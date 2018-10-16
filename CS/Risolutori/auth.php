<?php
ini_set('display_errors', 0);//disabilita l'output degli errori php
ini_set('display_startup_errors', 0);

if(!isset($_SESSION))
{
    session_start();
}
require_once ("../common/connessione.php");

$sruolo = 'SESS_RUOLO';
$semail = 'SESS_EMAIL';

if (! isset($_SESSION[$sruolo]) || trim($_SESSION[$sruolo]) == '') {
    if (isset($_COOKIE['rememberme'])) {
        // Se non è loggato ed è presente il coockie, decripta il coockie e logga l'utente
        $cipher = "AES-256-ECB";
        $ENCkey = ':h+RML."tgY1T"V@93PU`"uyQl2S"Y*`*?mtdK7*7Lr8,*R,|Wi*l{$:>hH-&M';
        
        $implode = openssl_decrypt(base64_decode($_COOKIE['rememberme']), $cipher, $ENCkey);
        $lista = explode('|', $implode);
        
        $query = "select * from Risolutore where email='" . $lista[1] . "'";
        $result = mysqli_query($conn, $query);
        $righe = mysqli_num_rows($result);
        $riga = mysqli_fetch_array($result);
        
        if ($righe > 0) {
            $_SESSION[$sruolo] = $riga['account'];
            $_SESSION[$semail] = $riga['email'];
            $_SESSION['SESS_DESCRIZIONE'] = $riga['descrizione'];
            $_SESSION['SESS_CITTA'] = $riga['citta'];
            header("location: ./");
            exit();
        }
    }
    header("location: login.php");
    exit();
}
define("USERNAME", $_SESSION[$semail]);
define("EMAILS", $_SESSION[$semail]);
$ruolo = $_SESSION[$sruolo];
$citta = $_SESSION['SESS_CITTA'];


?>