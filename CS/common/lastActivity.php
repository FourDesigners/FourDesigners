<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
if(!isset($_SESSION)){
    session_start();
}

require_once ("connessione.php");

$aut = false;
$strEmail = "email";
if (isset($_SESSION[$strEmail])) {
    if (time() - $_SESSION["LAST_ACTIVITY"] > 3600) {
        session_destroy();
        session_unset();
    } else {
        $aut = true;
    }
} else {
    //se non � presente la sessione, verifico il cookie
    if (isset($_COOKIE['remembermeuser'])) {
        // Se non è loggato ed è presente il coockie, decripta il coockie e logga l'utente
        $cipher = "AES-256-ECB";
        $ENCkey = ':h+RML."tgY1T"V@93PU`"uyQl2S"Y*`*?mtdK7*7Lr8,*R,|Wi*l{$:>hH-&M';
        
        $implode = openssl_decrypt(base64_decode($_COOKIE['remembermeuser']), $cipher, $ENCkey);
        $lista = explode('|', $implode);
        
        $query = "select * from Segnalatore where email='" . $lista[0] . "'";
        $result = mysqli_query($conn, $query);
        $righe = mysqli_num_rows($result);
        $riga = mysqli_fetch_array($result);
        
        if ($righe > 0) {
            $_SESSION['username'] = $riga['nickname'];
            $_SESSION[$strEmail] = $lista[0];
            $aut = true;
        }
    }   
}

if ($aut) {
    define("USERNAME", $_SESSION['username']);
    define("EMAILS", $_SESSION[$strEmail]);
    // update last activity time stamp
    $_SESSION['LAST_ACTIVITY'] = time();
}
?>
