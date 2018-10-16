<?php

include_once '../common/connessione.php';
include_once '../common/lastActivity.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $json = file_get_contents('php://input'); //altro modo per ricevere un oggetto json
    $obj = json_decode($json);

    $where = "";
    $ordina = "";
    $t = time();
    $today = date("Y-m-d", $t);
    $date = date_create($today);
    $param = "";
    $dataW = "";

    function create($param, $data) { //prende il parametro data ricevuto in stringa e restituisce la data in formato "date"
        date_sub($data, date_interval_create_from_date_string($param));
        return date_format($data, "Y-m-d");
    }

    if ($obj->id != "") { //se il campo id è avvalorato si tratta di una ricerca singola per CS ed effettua la ricerca solo su questo
        $where = "id='" . $obj->id . "'";
    } else { //altrimenti imposta i paramentri di ricerca della query
        $ordina = "order by " . $obj->ordina;
        if ($obj->data != "0") {
            $dataW = create($obj->data, $date);
            $where = " dataInizio >='" . $dataW . "'";
        }
        //citta piena
        if ($obj->citta != "") {
            if ($where != "") {
                $where = $where . " AND";
            }
            $where = $where . " citta='" . $obj->citta . "'";
        }
        //priorita pieno
        if ($obj->priorita != "0") {
            if ($where != "") {
                $where = $where . " AND";
            }
            $where = $where . " priorita='" . $obj->priorita . "'";
        }
        //stato pieno
        if ($obj->stato != "0") {
            if ($where != "") {
                $where = $where . " AND";
            }
            $where = $where . " stato='" . $obj->stato . "'";
        }
        //tipologia piena
        if ($obj->tipologia != "0") {
            if ($where != "") {
                $where = $where . " AND";
            }
            $where = $where . " tipologia='" . $obj->tipologia . "'";
        }
    }

    if ($where == "") { //se where è rimasto vuoto è una ricerca totale
        $sql = "SELECT * FROM Segnalazione order by " . $obj->ordina;
    } else {
        $sql = "SELECT * FROM Segnalazione where " . $where . $ordina;
    }

    $result = $conn->query($sql);

    $num = $result->num_rows;
    $outp = array();
    $outp = $result->fetch_all(MYSQLI_ASSOC);
    if ($num == 1) { //se il risultato è una segnalazione singola
        $segnalazione = $outp[0];
        $sql2 = "SELECT * FROM Foto where id=" . $outp[0]["id"]; //cerca i media asociati a tale segnalazione
        $result2 = $conn->query($sql2);
        $outp2 = $result2->fetch_all(MYSQLI_ASSOC);
        $num2 = $result2->num_rows;
        $media = [];
        for ($k = 0; $k < $num2; $k++) { //ogni media trovato lo mette nella variabile media
            $media[$k] = $outp2[$k]["url"];
        }
        $segnalazione["url"] = $media; //inserisce i media nell'oggetto segnalazione da restituire

        $comune = "select * from Risolutore where citta='" . $segnalazione["citta"] . "' AND account=2"; //controlla che il comune è registrato o inattivo
        $result3 = $conn->query($comune);
        $num3 = $result3->num_rows;

        if ($num3 == 1) { //setta il campo comune in base al risultato della ricerca
            $segnalazione["comune"] = TRUE;
        } else {
            $segnalazione["comune"] = FALSE;
        }

        echo json_encode($segnalazione);
    } else
    if ($num > 1) {
        echo json_encode($outp);
    } else {
        echo "0";
    }
} else {
    echo 'ERRORE';
}


$conn->close();
?>
