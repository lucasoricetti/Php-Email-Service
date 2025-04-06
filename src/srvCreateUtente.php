<?php

header("Content-Type: application/json; charset=UTF-8");
$CurrentDate = date("Y-m-d");//prendo la data nel formato YYYY-MM-DD
require("accessoDB.php");
$username=$_POST['user'];
$username.="@pippo.org";
$passw=$_POST['pass'];
$cpassw=$_POST['cpass'];
$result=dbCreateUtente($username,$passw,$cpassw);
if($result==1){
	primaMail($username, $CurrentDate);
}
$creazione = ['creazione'=>$result];
echo json_encode($creazione);//codifico in Json il valore e se vale -1 o 0 vuol dire utente non creato

?>