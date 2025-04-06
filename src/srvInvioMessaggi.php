<?php

header("Content-Type: application/json; charset=UTF-8");
require("accessoDB.php");
$CurrentDate = date("Y-m-d");//prendo la data nel formato YYYY-MM-DD
$IndirizzoMail = $_POST['IndirizzoMail'];
$ID_Messaggio = getNuovoID_Messaggio($IndirizzoMail);
$Oggetto=$_POST['Oggetto'];
$Destinatario=$_POST['Destinatario'];
$Body=$_POST['Body'];
$ris = inviaMessaggio($ID_Messaggio, $IndirizzoMail, $Oggetto, $Body, $CurrentDate, $Destinatario);
$messaggioInviato = ['messaggioInviato'=>$ris];
echo json_encode($messaggioInviato);//codifico in Json il valore e lo ritorno alla richiesta http

?>