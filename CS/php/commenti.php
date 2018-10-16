<?php
include_once '../common/connessione.php';
include_once '../common/lastActivity.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $json = file_get_contents('php://input');
    $commento = json_decode($json);


    if ($commento->op == "ottieni") {
        $query = "select nickname, testo, dataD from Commento NATURAL JOIN Segnalatore where id=" . $commento->id. " order by dataD";
        $result = $conn->query($query);
        $num = $result->num_rows;
        $outp = array();
        $outp = $result->fetch_all(MYSQLI_ASSOC);
        if ($num > 0) {            
            echo json_encode($outp);
        }
        else{ 
            echo "0";            
        }

    } else if ($commento->op == "salva") {
        $sql = 'INSERT INTO Commento (email, testo, id) VALUES '
                . '("' . EMAILS . '", "'
                . $commento->testo . '", '
                . $commento->id . ")";

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
