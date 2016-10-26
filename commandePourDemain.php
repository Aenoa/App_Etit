<?php
session_start();

    if(empty($_SESSION['username']))
    {
        header('location: index.php');
    } 
?>
 
<!DOCTYPE html>
<html>
	<meta name = "viewport" content = "user-scalable=no,initial-scale=1.0,width=device-width" /> 
		<style>
		 
		
		h1{	
			text-align:center;
			text-transform: uppercase;
			color: lightgray;
		}
		
		#titre{
		
		text-align:center;
		
		}
		
		
		a.ref{
		
		text-decoration:none;
		}
		
		
		
			
	
	</style>
	<body>
		<p id="connect" >
			<font color="green">Connecté</font>
			<BR>Solde : <?php echo $_SESSION['argent']; ?>€
		</p>
		
		<div id="titre">
			<p><h1>Les commandes sont terminées pour aujourd'hui. Voulez vous commander pour demain ? </h1></p>
		</div>
		
		<br>
		<br>
		<center><button class="button" id="suivant" onclick="document.location.href='./menu.php';">Commander pour demain</button></center>
		<br>
		<br>
		<center><button class="button" id="suivant" onclick="document.location.href='./menu.php';">Retour à l'accueil</button></center>
		
	
		<HR>
		<footer>
			<p><a href=#><input type="submit" value="Retour à la page d'accueil"/></a></p>
			<img src="logo.png" id="logo"/>
		</footer>
		
			
		
		
		
		
	</body>
	
</html>




























</html>
