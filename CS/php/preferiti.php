<?php
include_once '../common/connessione.php';
include_once '../common/lastActivity.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && $aut) {

    $json = file_get_contents('php://input');
    $obj = json_decode($json);

    if ($obj->op == "get") {
        $sql = " SELECT * FROM Segnalazione inner join Interessamenti on Segnalazione.id = Interessamenti.id where email='" . EMAILS . "'";
        $result = $conn->query($sql);
        $outPre = $result->fetch_all(MYSQLI_ASSOC);
        $num = $result->num_rows; 

 	echo json_encode($outPre);
	}
  else if ($obj->op == "check") {
        $sql = "SELECT * FROM Interessamenti where id=" . $obj->id . " AND email='" . EMAILS . "'";
        $result = $conn->query($sql);
        $num = $result->num_rows;
        $outp = array();
        $outp = $result->fetch_all(MYSQLI_ASSOC);

        $up = "UPDATE Interessamenti SET dataVisto = current_timestamp WHERE id=" . $obj->id . " AND email='" . EMAILS . "'";
        	$risultato = $conn->query($up);

        if ($num == 1) {
            echo true;
        } else {
            echo false;
        }
    } else if ($obj->op == "follow") {
        $sql = 'INSERT INTO Interessamenti(id, email, dataVisto) VALUES (' . $obj->id . ', "' . EMAILS . '", null)';
        $query = mysqli_query($conn, $sql);
        if ($query) {
            echo true;
        }
    } else if ($obj->op == "remove") {
        $sql = 'DELETE FROM Interessamenti WHERE id=' . $obj->id . ' and email="' . EMAILS . '"';
        $query = mysqli_query($conn, $sql);
        if ($query) {
            echo false;
        }
    }
}
$conn->close();
?>
