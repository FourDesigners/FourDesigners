<?php
include_once '../common/connessione.php';
include_once '../common/lastActivity.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $json = file_get_contents('php://input');
    $obj = json_decode($json);
    $latmax = $obj->lat + 0.0003;
    $latmin = $obj->lat - 0.0003;
    $lngmax = $obj->lng + 0.0003;
    $lngmin = $obj->lng - 0.0003;

    $sql = "SELECT * FROM Segnalazione where (latitudine BETWEEN " . $latmin . " AND " . $latmax . ") and (longitudine BETWEEN " . $lngmin . " AND " . $lngmax . ")";


    $result = $conn->query($sql);
    $num = $result->num_rows;
    $outp = array();
    $outp = $result->fetch_all(MYSQLI_ASSOC);
    if ($num > 0) {
        for ($i = 0; $i < $num; $i++) {
            $sqlfoto = "SELECT * FROM Foto where id=" . $outp[$i]["id"];
            $resultfoto = $conn->query($sqlfoto);
            $outp2 = $resultfoto->fetch_all(MYSQLI_ASSOC);
            $numfoto = $resultfoto->num_rows;
            for ($k = 0; $k < $numfoto; $k++) {
                $outp[$i]["url"] = $outp2[$k]["url"];
            }
        }
        echo json_encode($outp);
    } else {
        echo "0";
    }
} else {
    echo 'ERRORE';
}


$conn->close();
?>
