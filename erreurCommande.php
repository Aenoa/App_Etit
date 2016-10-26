<?php
session_start();

    if(empty($_SESSION['username']))
    {
        header('location: index.php');
    }
    
?>

<!DOCTYPE html>
<html>
	<head>
		<title>impossible de continuer votre commande.</title>
		<link rel="stylesheet" href="design.css">
		
		
		<script language="javascript" type="text/javascript">
		var compte=4;
		function decompte()
		{
				if(compte <= 1) {
				pluriel = "";
				} else {
				pluriel = "s";
				}
			document.getElementById("compt").innerHTML = compte + " seconde" + pluriel;
			compte--;
				if(compte == 0 || compte < 0) {
				compte = 0;
				
				}
		}
		setInterval('decompte()',1000);
		</script>
	
		
	</head>
	<body onload="decompte();">
	<p id="connect" >
		<font color="green">Connecté</font>
		<BR>Solde : <?php echo $_SESSION['argent']; ?>€
	</p>
	<header>
		impossible de continuer votre commande.
	</header>
	<div id="texte">
			<p> <h4>
				Nous ne sommes pas en mesure de prendre en charge votre commande.<br>
				Veuillez nous excuser pour ce désagrément.<br>
				Vous allez être redirigé vers le menu dans<span id="compt"></span>.
			</h4></p>
	</div>
	<meta http-equiv="refresh" content="4 ; url=menu.php">
	
	<footer>
		<img src="logo.png" id="logo"/>
	</footer>
	
	</body>



</html>