<?php
session_start();
require_once("../common/connessione.php");
$ente = $_SESSION['SESS_EMAIL'];
$telefono = $_POST['telefono'];
$descrizione= $_POST['descrizione'];
$sito = $_POST['sito'];
$statistiche = $_POST['statistiche'];

$target_dir = "./foto/";
$img = $_FILES["immagine"];
$immagine = $img["name"];
$where = "where email='".$ente."'";
if($immagine != "") {
	$nome = str_replace(substr($immagine, 0, strrpos($immagine, ".")), $_SESSION['SESS_CITTA'], $immagine);
	$target_file = $target_dir . $nome;
	echo $target_file;
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

	// Check if image file is a actual image or fake image
	$ext = ["jpeg", "jpg", "png", "gif"];
	if(!in_array($imageFileType, $ext)) {
		die("File is not a photo");
	}
	
	if(isset($img)) {
		$check = $img["size"];
		if($check !== false) {
			$uploadOk = 1;
		} else {
			die("File is not an image.");
			$uploadOk = 0;
		}
	}
	
	$query = "select immagine from Risolutore where email='".$_SESSION['SESS_EMAIL']."'";
	$result = mysqli_query($conn, $query);
	$riga = mysqli_fetch_array($result);
	if($riga['immagine'] != 'null') {
		unlink("./foto/".$riga['immagine']);
	}
	
	// Check file size
	if ($img["size"] > 50000000) {
		die("Sorry, your file is too large.");
		$uploadOk = 0;
	}

	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		die("Sorry, your file was not uploaded.");
	// if everything is ok, try to upload file
	} else {
		if (!move_uploaded_file($img["tmp_name"], $target_file)) {
			echo $_FILES['immagine']['tmp_name'];
			die("Sorry, there was an error uploading your file.");
		}
		$query = "update Risolutore set immagine='".$nome."' ".$where;
		$result = mysqli_query($conn, $query);
	}

}



if($telefono != "") {
    $query = "update Risolutore set telefono='".$telefono."' ".$where;
	$result = mysqli_query($conn, $query);
}

if($descrizione != "") {
    $query = "update Risolutore set descrizione='".$descrizione."' ".$where;
	$result = mysqli_query($conn, $query);
}

if($sito != "") {
    $query = "update Risolutore set sito='".$sito."' ".$where;
	$result = mysqli_query($conn, $query);
}

$query = "update Risolutore set statistiche='".$statistiche."' ".$where;
$result = mysqli_query($conn, $query);
header('location: vediInformazioni.php');
?>