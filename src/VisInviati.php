<?php
session_start();
if ($_SESSION['usrLogged'] == NULL) {
	header('location: pagLoginRegistrati.html'); 
    return;
}

//Memorizza l'Id dell'user in una variabile.
$IndirizzoMail = $_SESSION['usrLogged'];

// Eseguo la query per ottenere i dati dal database
require('accessoDB.php');
$messaggiInviati = getMessaggiInviati($IndirizzoMail);
?>


<html>
<head>
	<title>Inviati</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			display: flex;
			margin: 0;
			padding: 0;
		}

		.container {
			display: flex;
			width: 100%;
			height: 100vh;
		}

		.sidebar {
			width: 240px;
			background-color: #f1f1f1;
			padding: 20px;
            border-right:2px solid #4AD395;
		}
		.utente-name{
        	margin-left: 24%;
            margin-top: -2%;
            font-weight: bold;
        }

		.icona{
        	width: 50%;
            margin-left: 25%;
        }

		.content {
			flex: 1;
			padding: 20px;
		}

		h2 {
			color: #4AD395;
			margin-bottom: 20px;
            text-decoration: underline;
		}

		.options-list {
			list-style-type: none;
			padding: 0;
			margin: 0;
		}

		.option {
			margin-bottom: 10px;
		}

		.option a {
			display: block;
			color: #333;
			text-decoration: none;
			padding: 5px;
		}

		.option a:hover {
			background-color: #ddd;
		}

		table {
			border-collapse: collapse;
			width: 100%;
		}

		th, td {
			text-align: left;
			padding: 8px;
			border-bottom: 1px solid #4AD395;
		}

		tr:hover {
			background-color: #f5f5f5;
		}

		a {
			margin-right: 10px;
			color: #333;
			text-decoration: none;
		}

		.logout-link {
			margin-top: 20px;
			display: block;
		}

		.compose-link {
			margin-bottom: 10px;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="sidebar">
        <img src="immagini/7136522.png" class="icona">
				<?php
              echo "<p class='utente-name'>$IndirizzoMail</p>";
              ?>
			<h2>Opzioni</h2>
			<ul class="options-list">
				<li class="option"><a href="InvioMessaggi.php">Scrivi</a></li>
				<li class="option"><a href="Home.php">Posta in Arrivo</a></li>
				<li class="option"><a href="VisInviati.php">Inviati</a></li>
				<li class="option"><a href="VisSpeciali.php">Speciali</a></li>
				<li class="option"><a href="Logout.php" class="logout-link">Logout</a></li>
			</ul>
		</div>
		<div class="content">
			<h2>Inviati</h2>
			<table>
				<tr>
					<th>Destinatario</th>
					<th>Oggetto</th>
					<th>Body</th>
					<th>Data</th>
				</tr>
				<?php foreach ($messaggiInviati as $messaggio): ?>
					<tr>
						<td><?= $messaggio['Destinatario'] ?></td>
						<td><?= $messaggio['Oggetto'] ?></td>
						<td><?= $messaggio['Body'] ?></td>
						<td><?= $messaggio['Data'] ?></td>
                        </tr>
                  <?php endforeach; ?>
                  </table>
                  </div>
                  </div>

</body>
</html>
