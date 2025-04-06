<?php

session_start();
$CurrentDate = date("Y-m-d");//prendo la data nel formato YYYY-MM-DD
require("accessoDB.php");
$username=$_POST['user'];
$username.="@pippo.org";
$passw=$_POST['passw'];
$cpassw=$_POST['cpassw'];
$creazione = dbCreateUtente($username,$passw,$cpassw);
if($creazione==1){
	primaMail($username, $CurrentDate);
    header('location: pagLoginRegistrati.html');
}
elseif($creazione==0){
    echo("<script>alert('Le due Password non corrispondono')</script>");
}
else{
    echo("<script>alert('Questo Username non è disponibile')</script>");
}

?>