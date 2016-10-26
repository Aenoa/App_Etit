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
		<link rel="stylesheet" type="text/css" href="accueil.css">
		<title>Accueil</title>

		<script src="jquery.js"></script>
		<script type="text/javascript">
			jQuery(document).ready(function($){
			var isLateralNavAnimating = false;
			
			//open/close lateral navigation
			$('.navi-trigger').on('click', function(event){
				event.preventDefault();
				//stop if nav animation is running 
				if( !isLateralNavAnimating ) {
					if($(this).parents('.csstransitions').length > 0 ) isLateralNavAnimating = true; 
					
					$('body').toggleClass('navigation-is-open');
					$('.navigation-wrapper').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(){
						//animation is over
						isLateralNavAnimating = false;
					});
					}
				});
			});
		</script>
	</head>

	<body>
		<div class="main">
			<br>
			<br>
			<br>
			<br>
			<br>
			<br>
			<h1>Bienvenue sur App'étit</h1>
			<br>
			<p><a class="button" href="commande.html">Commander un sandwich</a></p>
		</div>
		<a href="#navi" class="navi-trigger">
			<span class="navi-icon">
				<svg x="0px" y="0px" width="60px" height="60px" viewBox="0 0 60 60"></svg>
			</span>
		</a>

		<!-- Hidden Navi Menu -->
		<div id="navi" class="navi">
			<div class="navigation-wrapper">
				<div class="half-block">
					<h2 id="menu">Menu</h2>

					<nav>
						<ul class="primary-navi">
							<li><a href="GestionCompte.php">Compte</a></li>
							<li><a href="commande.php">Commander</a></li>
							<li><a href="historiqueCommande.php">Historique</a></li>
							<li><a href="#"></a></li>
							<li><a href="clean_session.php">Déconnexion</a></li>
						</ul>
					</nav>
				</div>
			</div>
		</div>
		
		<footer>
			<img src="logo.png" id="logo"/>
		</footer>
		
	</body>

</html>