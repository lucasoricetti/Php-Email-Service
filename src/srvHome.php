<?php

header("Content-Type: application/json; charset=UTF-8");
require("accessoDB.php");
$IndirizzoMail=$_POST['IndirizzoMail'];
$ris = getMessaggiRicevuti($IndirizzoMail);
$messaggiRicevuti = ['messaggiRicevuti'=>$ris];
echo json_encode($messaggiRicevuti);//codifico in Json il valore e lo ritorno alla richiesta http
?>