<?php
session_start();
if ($_SESSION['usrLogged'] == NULL) {
	header('location: pagLoginRegistrati.html');
	return;
}

// Memorizza l'Id dell'user in una variabile.
$IndirizzoMail = $_SESSION['usrLogged'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Invio Email</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			margin: 0;
			padding: 0;
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
		.container {
			display: flex;
			width: 100%;
			height: 100vh;
		}

		.sidebar {
			width: 240px;
			background-color: #f1f1f1;
			padding: 20px;
			border-right: 2px solid #4AD395;
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

		form {
			margin-top: 20px;
		}

		label {
			display: block;
			margin-bottom: 5px;
			color: #333;
		}

		input[type="text"],
		textarea {
			width: 70%;
			padding: 8px;
			border: 1px solid #ccc;
			border-radius: 4px;
		}

		ul {
			list-style-type: none;
			padding: 0;
		}

		ul li {
			margin-bottom: 5px;
			cursor: pointer;
		}

		ul li:hover {
			background-color: #f5f5f5;
		}

		.submit-button {
			margin-top: 10px;
			padding: 8px 16px;
			background-color: #4AD395;
			border: none;
			color: #fff;
			cursor: pointer;
			border-radius: 4px;
			font-size: 14px;
		}

		.submit-button:hover {
			background-color: #45c78a;
		}

		.search-bar {
			margin-bottom: 10px;
		}

		.search-input {
			width: 100%;
			padding: 8px;
			border: 1px solid #ccc;
			border-radius: 4px;
		}

		.checkbox-item {
			display: flex;
			align-items: center;
            width: fit-content;
		}

		.checkbox-item input[type="checkbox"] {
			margin-right: 5px;
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
			<h2>Invio Email</h2>
			<form method="post" action="pagInvioMessaggi.php">
				<label for="oggetto">Oggetto:</label>
				<input type="text" name="oggetto"><br>
				<br><label for="body">Corpo del messaggio:</label>
				<textarea name="body"></textarea><br>
				<br><label>Seleziona i destinatari:</label>
				<div class="search-bar">
					<input type="text" id="search" class="search-input" placeholder="Cerca destinatario...">
				</div>
				<ul id="destinatari-list">
					<?php
					require('accessoDB.php');
					$utenti = getAllUtenti($IndirizzoMail); // Funzione per ottenere tutti gli utenti registrati
					foreach ($utenti as $utente) {
						echo '<li class="checkbox-item"><input type="checkbox" name="destinatari[]" value="'.$utente.'">'.$utente.'</li>';
					}
					?>
				</ul>
				<input type="hidden" name="destinatari" id="destinatari" value="">
				<input type="submit" value="Invia" class="submit-button">
			</form>
			<script>
				const destinatariList = document.getElementById('destinatari-list');
				const destinatariItems = destinatariList.getElementsByClassName('checkbox-item');
				const searchInput = document.getElementById('search');

				// Aggiunge l'evento keyup all'input di ricerca
				searchInput.addEventListener('keyup', function() {
					const filter = searchInput.value.toLowerCase();

					// Filtra i destinatari in base alla ricerca
					Array.from(destinatariItems).forEach(function(item) {
						const destinatario = item.innerText.toLowerCase();
						if (destinatario.includes(filter)) {
							item.style.display = 'flex';
						} else {
							item.style.display = 'none';
						}
					});
				});

				document.querySelector('form').addEventListener('submit', function() {
					const destinatariSelezionati = Array.from(destinatariList.querySelectorAll('input[type="checkbox"]:checked')).map(function(checkbox) {
						return checkbox.value;
					});
					document.getElementById('destinatari').value = destinatariSelezionati.join(',');
				});
			</script>
		</div>
	</div>
</body>
</html>
