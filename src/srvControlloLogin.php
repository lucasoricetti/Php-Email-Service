<?php

header("Content-Type: application/json; charset=UTF-8");
require("accessoDB.php");
$username=$_POST['user'];
$passw=$_POST['pass'];
$result=dbGetUtente($username,$passw);
$IndirizzoUtente = ['IndirizzoMail'=>$result];
echo json_encode($IndirizzoUtente);//codifico in Json il valore e lo ritorno alla richiesta http

?>