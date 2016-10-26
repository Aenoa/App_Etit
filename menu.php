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
        
        <title>Menu</title>
	</head>
	<body>
	<p id="connect" >
		<font color="green">Connecté</font>
		<BR>Solde : <?php echo $_SESSION['argent']; ?>€
	</p>
	<h4>Menu de l'application</h4>
        <menu id="menuDeb">
            <ul id="menuChoix">
                <li><a href="GestionCompte.php">Mon compte</a></li>
                <li><a href="commande.php">Nouvelle commande</a></li>
                <li><a href="historiqueCommande.php">Historique des commandes</a></li>
                <br>
                <li><a href="clean_session.php">Déconnexion</a></li>
            </ul>
        </menu>
		
		<footer>
			<img src="logo.png" id="logo"/>
		</footer>
		
	</body>
</html>