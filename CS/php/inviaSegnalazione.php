<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);

include_once '../common/connessione.php';
include_once '../common/lastActivity.php';
include_once '../Risolutori/mail/mail.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $json = $_POST["segnalazione"];
    $imgFile = [];
    $tmp_dir = [];
    $imgSize = [];

    $segnalazione = json_decode($json);
    $fileUp = $_FILES['fileToUpload'];
    $count = count($fileUp['name']);
    for ($i = 0; $i < $count; $i++) { //crea 3 array con le informazioni sui media caricati
        $imgFile[$i] = $fileUp['name'][$i]; //nome del media
        $tmp_dir[$i] = $fileUp['tmp_name'][$i]; //posizione temporanea sul server
        $imgSize[$i] = $fileUp['size'][$i]; //dimensione del file
    }

    if (isset($_FILES["video"])) { //se è stato caricato anche un video ne salva i dati
        $fileVideo=$_FILES["video"];
        $imgFile[$count] = $fileVideo['name'];
        $tmp_dir[$count] = $fileVideo['tmp_name'];
        $imgSize[$count] = $fileVideo['size'];
        $count++;
        if ($fileVideo['error'] > 0) {
            echo 'ERRORE DURANTE IL CARICAMENTO DEI MEDIA';
            die();
        }
    }

    if (empty($imgFile)) {
        echo "IL CAMPO FOTO DEVE OBBLIGATORIAMENTE CONTENERE UNA FOTO";
        die();
    } else {
        $dimensione = false;
        for ($i = 0; $i < $count; $i++) {
            if ($imgSize[$i] > 20000000) {
                $dimensione = true;
                break;
            }
        }

        if ($dimensione) {
            echo "ERRORE, UNO DEI FILE CHE STAI TENTANDO DI CARICARE E' TROPPO GRANDE";
            die();
        } else {
            $upload_dir = '../foto/'; // path in cui salvare le foto
            $valid_extensions = ['jpeg', 'jpg', 'png', 'gif', 'mp4']; // estensioni valide
            $validExt = true;
            for ($i = 0; $i < $count; $i++) {
                $imgExt[$i] = strtolower(pathinfo($imgFile[$i], PATHINFO_EXTENSION));
                if (!in_array($imgExt[$i], $valid_extensions)) { //controlla che tutti i media abbiano estensione valida
                    $validExt = false;
                    break;
                }
            }

            if ($validExt) { //se tutto risulta corretto, carica la segnalazione nel db
                $emailS = "";
                if (isset($_SESSION['email'])) {
                    $emailS = "'" . $_SESSION['email'] . "'";
                } else {
                    $emailS = "NULL";
                }

                $sql = 'INSERT INTO Segnalazione (latitudine, longitudine, titolo, citta, indirizzo, descrizione, priorita, tipologia, dataInizio, emailS) VALUES '
                        . '(' . $segnalazione->lat . ', '
                        . $segnalazione->lng . ', "'
                        . $segnalazione->titolo . '", "'
                        . $segnalazione->citta . '", "'
                        . $segnalazione->indirizzo . '", '
                        . json_encode($segnalazione->descrizione) . ', '
                        . $segnalazione->priorita . ', "'
                        . $segnalazione->tipologia . '", "'
                        . date("Y/m/d") . '", '
                        . $emailS . ')';

                $query = mysqli_query($conn, $sql);
                $last_id = $conn->insert_id;

                if ($query) { //se l'inserimento è andato a buon fine, carica i media
                    for ($i = 0; $i < $count; $i++) { //per ogni media
                        $userpic[$i] = $last_id . "-" . $i . "." . $imgExt[$i]; //genera il nome del media: "idSengalazione"+"-"+"numeroMedia"+"estensione"

                        move_uploaded_file($tmp_dir[$i], $upload_dir . $userpic[$i]); //caricamento della foto sul server
                        $absFoto = "foto/" . $userpic[$i]; //salva il path della foto per inserirlo nel DB

                        $sql1 = "INSERT INTO Foto (url, id) VALUES('" . $absFoto . "', " . $last_id . ")"; //salvataggio del media neldb
                        $conn->query($sql1);
                    }

                    $comune = "select * from Risolutore where citta like '" . $segnalazione->citta . "' AND account=2"; //controllo se il comune è registrato
                    $result3 = $conn->query($comune);
                    $num3 = $result3->num_rows;                    
                    $ente = $result3->fetch_all(MYSQLI_ASSOC);                    

                    if ($num3 == 1 && $ente[0]["attivo"]) { //controllo se ha trovato un account di livello 1(comune) e se questo è attivo
                        $partecipa = "si";
                    } else {
                        $partecipa = "no";
                        if($emailComune = mailOfCity($segnalazione->citta)){ //altrimenti invia l'email con la segnalazione
                            $oggetto = "[CivicSense] Nuova segnalazione da un suo cittadino";
                            $testo = "Salve, <br>le comunichiamo che un suo cittadino ha inserito una segnalazione per il suo comune.<br> Per poter gestire le segnalazioni contatti lo staff di <a href=\"https://www.civicsense.it\">civicsense.it</a>.<br>Per visualizzare la segnalazione <a href=\"https://www.civicsense.it/ricercaSegnalazione.php?x=" . $last_id . "\">clicca qui</a>.<br><br>Saluti<br>Lo Staff";
                            inviaMail($emailComune, $emailComune, $oggetto, $testo);
                        }
                    }
                    $ris=array('id' => $last_id, 'comune'=>$partecipa);  //genera ll'oggetto da inviare come risposta
                    
        
                    echo json_encode($ris);
                } else {
                    echo "ERRORRE DURANTE L'INSERIMENTO....<br>".$sql;
                }
            } else {
                echo "Attenzione stai tentando di allegare qualcosa che non è una foto o un video!";
            }
        }
    }
} else {
    echo "ERRORE NEL SALVATAGGIO DELLA SEGNALAZIONE";
}
$conn->close();
?>
