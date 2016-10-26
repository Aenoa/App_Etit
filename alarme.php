<?php
session_start();

    if(empty($_SESSION['username']))
    {
        header('location: index.php');
    }
    
?> 
<html>
	<head>
	<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="design.css" />
        <script type="text/javascript" src="jquery.js"></script>
        
        <title>Modification adresse e-mail</title>
	</head>
	<body>
	<p id="connect" >
		<font color="green">Connecté</font>
		<BR>Solde : <?php echo $_SESSION['argent']; ?>€
	</p>
	<h4>Modifier l'alarme</h4>
	
	<p id="setalarme">
		<input type="number" id="minutes" placeholder="Temps avant" maxlength="25" name="nbminutes" />
		<select id="alarme">
			<option value="Vibreur">Vibreur</option>
			<option value="Sonnerie">Sonnerie</option>
			<option value="Notification">Notification</option>
		</select>
	</p>
	
	<br>
	<br>
	
	<center><button class="button" id="Annuler1" onclick="document.location.href='./GestionCompte.php';">Sauvegarder</button></center>
	<br>
	<br>
	<center><button class="button" id="Annuler1" onclick="document.location.href='./GestionCompte.php';">Annuler</button></center>
	
	<footer>
		<img src="logo.png" id="logo"/>
	</footer>
	
	</body>
</html>