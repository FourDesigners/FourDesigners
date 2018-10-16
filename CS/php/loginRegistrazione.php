<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);

include_once '../common/connessione.php';
include_once '../common/lastActivity.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $json = file_get_contents('php://input');
    $obj = json_decode($json, true);
    $eM="email";
    

    if ($obj["op"] == "login") {
        $pass = mysqli_real_escape_string($conn, $obj['passwordL']);
        $email = mysqli_real_escape_string($conn, $obj['emailL']);
        $pwd = md5($pass);

//query ricerca
        $sqlcmd = "SELECT * from Segnalatore where email='" . $email . "' AND enterKey='" . $pwd . "'";

//risultato query
        $risultato = mysqli_query($conn, $sqlcmd, MYSQLI_STORE_RESULT);
        if (!$risultato) {
            echo "Errore nell'accesso: " . mysql_errno($conn);
        } else {
            $numero = mysqli_num_rows($risultato);
            $riga = mysqli_fetch_array($risultato);
            $outp = "";

            if ($numero == 0) {
                echo "Errore : Password o email errate";
            } else {
                //sessione
                $_SESSION['username'] = $riga['nickname'];
                $_SESSION[$eM] = $email;
                $_SESSION['LAST_ACTIVITY'] = time();
                
                //se l'utente ha deciso di rimanere connesso, si effettua il salvataggio del cookie criptato
                if ($obj['checkboxL'] == 1) {
                    $implode = "$riga[email]|$riga[nickname]";
                    $days = 30; //n° giorni di conservazione della connessione
                    $cipher = "AES-256-ECB"; //algoritmo di cifrtura
                    $ENCkey = ':h+RML."tgY1T"V@93PU`"uyQl2S"Y*`*?mtdK7*7Lr8,*R,|Wi*l{$:>hH-&M'; //chiave privata di cifratura
                    $value = base64_encode(openssl_encrypt($implode, $cipher, $ENCkey)); //cifratura e codifica in base64
                    setcookie("remembermeuser", $value, time() + ($days * 24 * 60 * 60 * 1000), '/'); //salvataggio cookie
                }


                echo "ok";
            }
        }
    } else if ($obj["op"] == "registra") {
        $pwd = md5($obj['password']);
//query inserimento
        $toinsert = "INSERT INTO Segnalatore (email, enterKey ,nickname) VALUES ('" . $obj[$eM] . "','" . $pwd . "','" . $obj['nickname'] . "')";

        $result = mysqli_query($conn, $toinsert);
        $outp = "";


        if (!$result) {

            $sql = "SElECT * INTO Segnalatore where email='" . $obj[$eM] . "'";

            $result2 = mysqli_query($conn, $sql);


            if (!$result2) {
                echo "Email già registrata";
            } else {
                echo "Registrazione fallita";
                die();
            }
        } else {
            echo "ok";
        }
    } else if ($obj["op"] == "modificaP") {
        $pwd = md5($obj['password']);
        $query = "select * from Segnalatore where email='" . EMAILS . "' and enterKey='" . $pwd . "'";
        $result = mysqli_query($conn, $query);
        $righe = mysqli_num_rows($result);
        $newPwd = md5($obj['nuovaP']);
        if ($righe > 0) {
            $newPwd = md5($obj['nuovaP']);
            $query = "update Segnalatore set enterKey='" . $newPwd . "' where email='" . EMAILS . "'";
            $result = mysqli_query($conn, $query);
            echo "ok";
        } else {
            echo "Credenziali non valide ";
        }
    }
}
?>
