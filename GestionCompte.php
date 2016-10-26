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
        
        <title>Gestion de compte</title>
	</head>
	<body>
	<p id="connect" >
		<font color="green">Connecté</font>
		<BR>Solde : <?php echo $_SESSION['argent']; ?>€
	</p>
	<h4> Gestion du compte</h4>
        <menu id="menuGestCompte">
            <ul id="menuCompte">
                <li><a href="modificationUtilisateur.php">Modifier utilisateur</a></li>
				<li><a href="modificationLogin.php">Modifier login</a></li>
                <li><a href="modificationMotDePasse.php">Modifier mot de passe</a></li>
                <li><a href="modificationAdresseEmail.php">Modifier adresse e-mail</a></li>
		 <li><a href="alarme.php">Modifier l'alarme</a></li>
            </ul>
        </menu>
		<BR>
		<center><button class="button" onclick="document.location.href='./menu.php';" id="Annuler1">Retour à l'accueil</button></center>
		<BR>
		<BR>
		
		<footer>
			<img src="logo.png" id="logo"/>
		</footer>
		
	</body>
</html>