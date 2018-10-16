<?php
ini_set('display_errors', 0);//disabilita l'output degli errori php
ini_set('display_startup_errors', 0);
session_start();
require_once '../../common/connessione.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $json = file_get_contents('php://input');
    $commento = json_decode($json);
    
    if ($commento->op == "ottieni") {//metodo per ottenere i commenti di una segnalazione
        $query = "select nickname, testo, dataD from Commento NATURAL JOIN Segnalatore where id=" . $commento->id . " order by dataD";
        $result = $conn->query($query);
        $num = $result->num_rows;
        $outp = array();
        $outp = $result->fetch_all(MYSQLI_ASSOC);
        if ($num > 0) {
            echo json_encode($outp);
        } else {
            echo "0";
        }
    } else if ($commento->op == "salva") {//metodo per salvare un commento
        $sql = 'INSERT INTO Commento (email, testo, id) VALUES ' . '("' . $_SESSION['email'] . '", "' . $commento->testo . '", ' . $commento->id . ")";
        
        $query = mysqli_query($conn, $sql);
        
        if ($query) {
            echo "ok";
        } else {
            echo "Erore nell'aggiunta del commento";
        }
    }
}
$conn->close();
?>
