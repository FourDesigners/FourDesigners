<?php

include_once '../common/connessione.php';
include_once '../common/lastActivity.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $json = file_get_contents('php://input');
    $obj = json_decode($json);

    $where = "";
    $ordina = "";
    $t = time();
    $today = date("Y-m-d", $t);
    $date = date_create($today);
    $param = "";
    $dataW = "";
    $strPrimo = "primo";
    $strSecondo = "secondo";
    $strTerzo = "terzo";

    function create($param, $data) { //prende il parametro data ricevuto in stringa e restituisce la data in formato "date"
        date_sub($data, date_interval_create_from_date_string($param));
        return date_format($data, "Y-m-d");
    }


    if ($obj->op == "eff") {
        //firts piechart
        $sqlE = " SELECT stato as parametro, count(*) as numero FROM Segnalazione WHERE emailS='" . EMAILS . "' GROUP BY stato";
        $resultE = $conn->query($sqlE);
        $outpE = $resultE->fetch_all(MYSQLI_ASSOC);
        $numE = $resultE->num_rows;

        //firts piechart
        $sqlE2 = " SELECT tipologia as parametro, count(*) as numero FROM Segnalazione WHERE emailS='" . EMAILS . "' GROUP BY tipologia";
        $resultE2 = $conn->query($sqlE2);
        $outpE2 = $resultE2->fetch_all(MYSQLI_ASSOC);
        $numE2 = $resultE2->num_rows;

        //firts piechart
        $sqlE3 = " SELECT priorita as parametro, count(*) as numero FROM Segnalazione WHERE emailS='" . EMAILS . "' GROUP BY priorita";
        $resultE3 = $conn->query($sqlE3);
        $outpE3 = $resultE3->fetch_all(MYSQLI_ASSOC);
        $numE3 = $resultE3->num_rows;

        $myObjE = array($strPrimo => $outpE, $strSecondo => $outpE2, $strTerzo => $outpE3);

        if ($numE >= 1) {
            echo json_encode($myObjE);
        } else {
            echo "0";
        }
    } else if ($obj->op == "seg") {

        $sqlS = " SELECT stato as parametro, count(*) as numero FROM Segnalazione WHERE id IN (SELECT id FROM Interessamenti where email='" . EMAILS . "') GROUP BY stato";
        $resultS = $conn->query($sqlS);
        $outpS = $resultS->fetch_all(MYSQLI_ASSOC);
        $numS = $resultS->num_rows;

        $sqlS2 = " SELECT tipologia as parametro, count(*) as numero FROM Segnalazione WHERE id IN (SELECT id FROM Interessamenti where email='" . EMAILS . "') GROUP BY tipologia";
        $resultS2 = $conn->query($sqlS2);
        $outpS2 = $resultS2->fetch_all(MYSQLI_ASSOC);
        $numS2 = $resultS2->num_rows;

        $sqlS3 = " SELECT priorita as parametro, count(*) as numero FROM Segnalazione WHERE id IN (SELECT id FROM Interessamenti where email='" . EMAILS . "') GROUP BY priorita";
        $resultS3 = $conn->query($sqlS3);
        $outpS3 = $resultS3->fetch_all(MYSQLI_ASSOC);
        $numS3 = $resultS3->num_rows;

        $myObjS = array($strPrimo => $outpS, $strSecondo => $outpS2, $strTerzo => $outpS3);

        if ($numS >= 1) {
            echo json_encode($myObjS);
        } else {
            echo "0";
        }
    } else if ($obj->op == "citta") {

        $where ="";
        $verifica = "SELECT statistiche from Risolutore where citta = '" . $obj->citta . "' and account = 2";
        $risultato = $conn->query($verifica);
        $riga = $risultato->fetch_array(MYSQLI_ASSOC);
        if($obj->aut != 'ente' && $riga["statistiche"] == "no"  )
        {
         echo 'NOT';
        }
        else if($obj->aut !='ente' && $riga["statistiche"] != "si" )
        {
          echo 'NOTCIVIC';
        }
        else{
          if ($obj->data != "0") {
               $dataW = create($obj->data, $date);
               $where = " dataInizio >='" . $dataW . "'";
           }

           if ($where != "") {
               $where = $where . " AND";
           }

             $sql = " SELECT stato as parametro, count(*) as numero FROM Segnalazione where" . $where."  citta = '" . $obj->citta . "' GROUP BY stato ";
             $result = $conn->query($sql);
             $outpcitta = $result->fetch_all(MYSQLI_ASSOC);
             $num = $result->num_rows;

             $sql2 = " SELECT tipologia as parametro, count(*) as numero FROM Segnalazione where ". $where."   citta = '" . $obj->citta . "' GROUP BY tipologia ";
             $result2 = $conn->query($sql2);
             $outp2citta = $result2->fetch_all(MYSQLI_ASSOC);

             $sql3 = " SELECT priorita as parametro, count(*) as numero FROM Segnalazione where". $where." citta = '" . $obj->citta . "' GROUP BY priorita";
             $result3 = $conn->query($sql3);
             $outp3citta = $result3->fetch_all(MYSQLI_ASSOC);

             $myObj = array($strPrimo => $outpcitta, $strSecondo => $outp2citta, $strTerzo => $outp3citta);


             if ($num >= 1) {
                 echo json_encode($myObj);
             } else {
                 echo "0";
             }
        }

    } else {
        echo 'ERRORE';
    }
}

$conn->close();
?>
