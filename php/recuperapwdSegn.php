<?php
include_once '../common/connessione.php';
include_once '../common/lastActivity.php';
require_once ("../Risolutori/mail/mail.php");
$alfMai = 'alfa_mai';
$alfMin = 'alfa_min';
$numb = 'numberi';

function generaPassword($length = 8, $args = array()) {
    $maiuscole = 'alfa_mai';
    $numeri = 'numberi';
    $minuscole = 'alfa_min';
    $simboli = 'simboli';
    $psw = '';
    
    $permit = array(); // contiene i gruppi di caratteri permessi
    
    // se non Ã¨ stato passato alcun argomento, rendo tutti i gruppi disponibili
    // altrimenti rendo disponibili solo i gruppi abilitati in $args
    
    if (empty($args)) {
        $permit[] = $maiuscole;
        $permit[] = $numeri;
        $permit[] = $minuscole;
        $permit[] = $simboli;
    } else {
        $permit = $args;
    }
    
    $possibleChars = '';
    
    if (in_array($minuscole, $permit)) {
        $possibleChars .= 'abcdefghijklmnopqrstuvwxyz';
    }
    
    if (in_array($numeri, $permit)) {
        $possibleChars .= '1234567890';
    }
    
    if (in_array($maiuscole, $permit)) {
        $possibleChars .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    }
    
    if (in_array($simboli, $permit)) {
        $possibleChars .= '!"Â£$%&/()=?\'^@#[]*';
    }
    $i = 0;
    
    while ($i < $length) {
        $psw .= substr($possibleChars, rand(0, strlen($possibleChars) - 1), 1);
        $i ++;
    }
    
    return $psw;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $json = file_get_contents('php://input');
    $obj = json_decode($json);

    $query = "select * from Segnalatore where email like '" . $obj->email . "'";
    $result = mysqli_query($conn, $query);
    $righe = mysqli_num_rows($result);
    $riga = mysqli_fetch_array($result);

    if ($righe > 0) {
        $enterKey = generaPassword(8, array(
            $alfMai,
            $alfMin,
            $numb
        ));

        $query = "UPDATE Segnalatore set enterKey = '" . md5($enterKey) . "' where email like '" . $obj->email . "'";
        $result = mysqli_query($conn, $query);
        $righe = mysqli_affected_rows($conn);
        if ($righe > 0) {
            $oggetto = "Aggiornamento password";
            $testo = "Salve, le comunichiamo che la sua nuova password per accedere a civic sense è: " . $enterKey;
            if (inviaMail($obj->email, $obj->email, $oggetto, $testo) == 0) {
                echo "ok";
            } else {
                echo "Errore tecnico durante l'invio della mail";
            }
        } else {
            echo "Errore tecnico, riprovare più tardi";
        }
    } else {
        echo "Email non esistente";
    }
}
?>