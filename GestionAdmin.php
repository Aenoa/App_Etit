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
        <title>app_etit</title>
    </head>
    <body>
	<p id="connect" >
		<font color="green">Connecté</font>
		<BR>~ Admin
	</p>
	
	<br>

	<section id="formLogin">
	<h1>Gestion </h1>
	<!--	<button class="switch" id="showRegisterForm" onclick="document.location.href='./AjouterArgent.php';" id="suivant">Ajouter de l'argent au compte</button> -->
		<button class="switch" id="showRegisterForm" onclick="document.location.href='./manager.php';" id="suivant">Gerer les commandes</button>
		<button class="switch" id="showRegisterForm" onclick="document.location.href='./SandwichDispo.php';" id="suivant">Gerer les sandwichs</button>
		<br>
		<br>
	</section>
	<BR>
	<BR>
	<center><button class="button" onclick="document.location.href='./clean_session.php';" id="suivant">Déconnexion</button></center>
	
	<footer>
		<img src="logo.png" id="logo"/>
	</footer>
		
    </body>
</html>


