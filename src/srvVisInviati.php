<?php

header("Content-Type: application/json; charset=UTF-8");
require("accessoDB.php");
$IndirizzoMail=$_POST['IndirizzoMail'];
$ris = getMessaggiInviati($IndirizzoMail);
$messaggiInviati = ['messaggiInviati'=>$ris];
echo json_encode($messaggiInviati);//codifico in Json il valore e lo ritorno alla richiesta http
?>