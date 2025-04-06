<?php

header("Content-Type: application/json; charset=UTF-8");
require("accessoDB.php");
$IndirizzoMail=$_POST['IndirizzoMail'];
$ris = getMessaggiImportanti($IndirizzoMail);
$messaggiSpeciali = ['messaggiSpeciali'=>$ris];
echo json_encode($messaggiSpeciali);//codifico in Json il valore e lo ritorno alla richiesta http
?>