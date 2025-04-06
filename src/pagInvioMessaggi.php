<?php

session_start();
$IndirizzoMail = $_SESSION['usrLogged'];
$CurrentDate = date("Y-m-d");//prendo la data nel formato YYYY-MM-DD
$Destinatari = explode(',', $_POST['destinatari']); // ottengo un array di destinatari separati da virgola
$Oggetto=$_POST['oggetto'];
$Body=$_POST['body'];
require('accessoDB.php');
foreach ($Destinatari as $Destinatario) {
	$ID_Messaggio = getNuovoID_Messaggio($IndirizzoMail);
	inviaMessaggio($ID_Messaggio, $IndirizzoMail, $Oggetto, $Body, $CurrentDate, $Destinatario);
}

header('location: Home.php');

?>