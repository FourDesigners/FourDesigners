<?php
ini_set('display_errors', 0);//disabilita l'output degli errori php
ini_set('display_startup_errors', 0);

session_start();
require_once ("../../common/connessione.php");
require_once ("../mail/mail.php");


/*
 * Genera una password casuale
 * Parametri
 * - Lunghezza password
 * - Categorie di caratteri da utilizzare
 *  ฐ alfa_mai (Lettere maiuscole)
 *  ฐ alfa_min (Lettere minuscole)
 *  ฐ numberi (Caratteri numerici)
 *  ฐ simboli (Caratteri speciali)
 */
function generaPassword($length = 8, $args = array())
{
    $maiuscole = 'alfa_mai';
    $minuscole = 'alfa_min';
    $numeri = 'numberi';
    $simboli = 'simboli';
    $psw = '';
    
    $permit = array(); // contiene i gruppi di caratteri permessi
                       
    // se non รจ stato passato alcun argomento, rendo tutti i gruppi disponibili
                       // altrimenti rendo disponibili solo i gruppi abilitati in $args
    
    if (empty($args)) {
        $permit[] = $maiuscole;
        $permit[] = $minuscole;
        $permit[] = $numeri;
        $permit[] = $simboli;
    } else {
        $permit = $args;
    }
    
    $possibleChars = '';
    
    if (in_array($maiuscole, $permit)) {
        $possibleChars .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    }
    
    if (in_array($minuscole, $permit)) {
        $possibleChars .= 'abcdefghijklmnopqrstuvwxyz';
    }
    
    if (in_array($numeri, $permit)) {
        $possibleChars .= '1234567890';
    }
    
    if (in_array($simboli, $permit)) {
        $possibleChars .= '!"ยฃ$%&/()=?\'^@#[]*';
    }
    $i = 0;
    
    while ($i < $length) {
        $psw .= substr($possibleChars, rand(0, strlen($possibleChars) - 1), 1);
        $i ++;
    }
    
    return $psw;
}

$json = file_get_contents('php://input');
$obj = json_decode($json, true);
$query = "select * from Risolutore where email like '" . $obj[email] . "'";
$result = mysqli_query($conn, $query);
$righe = mysqli_num_rows($result);
$riga = mysqli_fetch_array($result);

if ($righe > 0) {
    $password = generaPassword(8, array(
        'alfa_mai',
        'alfa_min',
        'numberi'
    ));//genera la nuova password
    
    $query = "UPDATE Risolutore set enterKey = '" . md5($password) . "' where email like '" . $obj[email] . "'";
    $result = mysqli_query($conn, $query);
    $righe = mysqli_affected_rows($conn);
    if ($righe > 0) {
        $oggetto = "Aggiornamento password";
        $testo = "Salve, le comunichiamo che la sua nuova password per accedere a civic sense &egrave;: " . $password;
        if (inviaMail($obj[email], $obj[email], $oggetto, $testo) == 0) {//invia la mail con la nuova password
            echo "ok";
        } else {
            echo "Errore tecnico durante l'invio della mail";
        }
    } else {
        echo "Errore tecnico, riprovare piรน tardi";
    }
} else {
    echo "Email non esistente";
}
?>