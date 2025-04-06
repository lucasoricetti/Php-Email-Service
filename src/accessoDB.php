<?php

//connessione a DB

function connect(){
    $db="my_msqtshopnonufficiale";//Da Modificare per il proprio DB
    $conn=mysqli_connect("localhost","","msqtshopnonufficiale",$db);
    return $conn;
}

//====================================================
//login

function dbGetUtente($username,$passw){
    $conn=connect();
    $query="select * from AccountMail where IndirizzoMail='$username' and Password='$passw'";
    $ris=mysqli_query($conn,$query);
    mysqli_close($conn);
    if(mysqli_num_rows($ris)==0) {
        $IndirizzoMail=-1;//utente non trovato
    }
    else {
        $riga=mysqli_fetch_array($ris);
        $IndirizzoMail= $riga['IndirizzoMail'];
    }
    return $IndirizzoMail;
}

//====================================================
//Registrazione

function primaMail($IndirizzoMail, $Data) {
	$conn=connect();
    $sql = "INSERT INTO Messaggio (ID_Messaggio, Mittente, Oggetto, Body, Data) 
    		VALUES (0, '$IndirizzoMail', 'PRIMAMAIL', '', '$Data')";
    mysqli_query($conn, $sql);
    mysqli_close($conn);
}

function dbCreateUtente($username,$passw,$cpassw){
    $conn=connect();
    $select="select * from AccountMail where IndirizzoMail='$username'";
    $ris=mysqli_query($conn,$select);
    if(mysqli_num_rows($ris)>0) {
    	$creazione=-1;//utente non creato perchè lo username esiste gia
    }
    else {
        if ($passw != $cpassw) {
            $creazione=0;//utente non creato perche le due password non corrispondono
        }
        else{
        	$creazione=1;//utente creato
            $insert = "INSERT INTO AccountMail (IndirizzoMail, Password) VALUES ('$username', '$passw')";
            mysqli_query($conn,$insert);
            mysqli_close($conn);
        }
    }
    return $creazione;
}

//====================================================
//Posta in Arrivo

function getMessaggiRicevuti($IndirizzoMail) {
	$conn=connect();
	// Esecuzione della query
	$sql = "SELECT Destinatario.Importante, Messaggio.Mittente, Messaggio.Oggetto, Messaggio.Body, Messaggio.Data 
			FROM Destinatario inner JOIN Messaggio ON Destinatario.id_messaggio = Messaggio.ID_Messaggio AND Destinatario.mittente = Messaggio.Mittente
			WHERE (Destinatario.indirizzomail LIKE '$IndirizzoMail')
            ORDER BY Messaggio.ID_Messaggio DESC";
	$result = mysqli_query($conn, $sql);
    mysqli_close($conn);
	$messaggiRicevuti = [];
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			array_push($messaggiRicevuti, [
            	"Importante" => $row["Importante"],
        		"Mittente" => $row["Mittente"],
        		"Oggetto" => $row["Oggetto"],
                "Body" => $row["Body"],
                "Data" => $row["Data"]
    		]);
        }
	return $messaggiRicevuti;
	}
return null;		
}

//====================================================
//Visualizza Importanti

function getMessaggiImportanti($IndirizzoMail) {
	$conn=connect();
	// Esecuzione della query
	$sql = "SELECT Destinatario.Importante, Messaggio.Mittente, Messaggio.Oggetto, Messaggio.Body, Messaggio.Data 
			FROM Destinatario inner JOIN Messaggio ON Destinatario.id_messaggio = Messaggio.ID_Messaggio AND Destinatario.mittente = Messaggio.Mittente
			WHERE (Destinatario.indirizzomail LIKE '$IndirizzoMail') AND (Destinatario.Importante LIKE '1')
            ORDER BY Messaggio.ID_Messaggio DESC";
	$result = mysqli_query($conn, $sql);
    mysqli_close($conn);
	$messaggiImportanti = [];
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			array_push($messaggiImportanti, [
            	"Importante" => $row["Importante"],
        		"Mittente" => $row["Mittente"],
        		"Oggetto" => $row["Oggetto"],
                "Body" => $row["Body"],
                "Data" => $row["Data"]
    		]);
        }
	return $messaggiImportanti;
	}
return null;		
}

//====================================================
//Visualizza Inviati

function getMessaggiInviati($IndirizzoMail) {
	$conn=connect();
	// Esecuzione della query
	$sql = "SELECT Destinatario.indirizzomail, Messaggio.Oggetto, Messaggio.Body, Messaggio.Data 
			FROM Destinatario inner JOIN Messaggio ON Destinatario.id_messaggio = Messaggio.ID_Messaggio AND Destinatario.mittente = Messaggio.Mittente
			WHERE (Messaggio.Mittente LIKE '$IndirizzoMail')
            ORDER BY Messaggio.ID_Messaggio DESC";
	$result = mysqli_query($conn, $sql);
    mysqli_close($conn);
	$messaggiInviati = [];
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			array_push($messaggiInviati, [
        		"Destinatario" => $row["indirizzomail"],
        		"Oggetto" => $row["Oggetto"],
                "Body" => $row["Body"],
                "Data" => $row["Data"]
    		]);
        }
	return $messaggiInviati;
	}
return null;		
}

//====================================================
//Invio E-Mail

function getNuovoID_Messaggio($IndirizzoMail) {
	$conn=connect();
    $sql = "SELECT MAX(ID_Messaggio) as max_valore FROM Messaggio WHERE Messaggio.Mittente = '$IndirizzoMail'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
	$max_valore = $row['max_valore'];
    // Aggiungi 1 al valore massimo per ottenere il prossimo numero libero
	$prossimo_libero = $max_valore + 1;
    mysqli_close($conn);
    return $prossimo_libero;
}

function inviaMessaggio($ID_Messaggio, $IndirizzoMail, $Oggetto, $Body, $Data, $Destinatario) {
	$conn=connect();
    $query = "SELECT IndirizzoMail FROM AccountMail WHERE (IndirizzoMail LIKE '$Destinatario')";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
    	$sql1 = "INSERT INTO Messaggio (ID_Messaggio, Mittente, Oggetto, Body, Data) 
    			VALUES ($ID_Messaggio, '$IndirizzoMail', '$Oggetto', '$Body', '$Data')";
    	$sql2 = "INSERT INTO Destinatario (Importante, id_messaggio, mittente, indirizzomail) 
    			VALUES ('0', $ID_Messaggio, '$IndirizzoMail', '$Destinatario')";
    	mysqli_query($conn, $sql1);
    	mysqli_query($conn, $sql2);
		mysqli_close($conn);
        return "Email Spedita";
    } else {
    	return "Impossibile Spedire perchè non esiste questo Ind Mail";
    }
}

function getAllUtenti($IndirizzoMail) {
    $conn = connect();
    $query = "SELECT IndirizzoMail FROM AccountMail WHERE (IndirizzoMail != '$IndirizzoMail')";
    $result = mysqli_query($conn, $query);
    mysqli_close($conn);
    $utenti = [];
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $utenti[] = $row["IndirizzoMail"];
        }
    }
    return $utenti;
}
?>