<?php

session_start();
require("accessoDB.php");
$username=$_POST['user'];
$passw=$_POST['passw'];
$IndirizzoMail=dbGetUtente($username,$passw);
if($IndirizzoMail==-1){
    header('location: pagLoginRegistrati.html');//utente non trovato
}
else {
    $_SESSION['usrLogged']=$IndirizzoMail;
    header('location: Home.php');
}

?>