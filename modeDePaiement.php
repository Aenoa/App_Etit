<?php
session_start();

    if(empty($_SESSION['username']))
    {
        header('location: index.php');
    }
    
?> 
  
<html>
	<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="design.css" />
        <script type="text/javascript" src="jquery.js"></script>
        
        <title>Mode de paiement</title>
    </head> 
	
	<body>
	<p id="connect" >
		<font color="green">Connecté</font>
		<BR>Solde : <?php echo $_SESSION['argent']; ?>€
	</p>
	<h4> Veuillez sélectionner votre mode de paiement</h4>
    <form method="post" action="confirmationCommande.php">
        <fieldset style='width:40%;'>
            <legend align="center">Moyens de paiements</legend>
            <div id="listechoix">
                <input type="checkbox" id="paieun" value="1" selected /><label for="paieun"> Solde du compte </label> </br></br>
                <input type="checkbox" id="paiedeux" value="2" disabled /> <label for="paiedeux"> Paypal </label> </br></br>
                <input type="checkbox" id="paietrois"value="3" disabled /> <label for="paietrois"> Carte bancaire </label> </br>
            </div>
        </fieldset>
	
        <br>
        <br>
        <input type="text" name="orderCampus" style="display: none;" value="<?php echo $_POST['orderCampus']; ?>" />
        <input type="text" name="helha"       style="display: none;" value="<?php echo $_SESSION['helha'] . " " . $_SESSION['nom'] . " " . $_SESSION['prenom']; ?>" />
        <input type="text" name="orderType"   style="display: none;" value="<?php echo $_POST['orderType']; ?>" />
        <input type="text" name="orderSauce"  style="display: none;" value="<?php echo $_POST['orderSauce']; ?>" />
        <input type="text" name="orderCrud"   style="display: none;" value="<?php echo $_POST['orderCrud']; ?>" />
        <center><input type="submit" class="button" id="suivant" value="Confirmer commande" /></center>
    </form>
	<br>
	<br>
	<center><button class="button" onclick="document.location.href='./menu.php';" id="Annuler1">Annuler</button></center>
	
	<footer>
		<img src="logo.png" id="logo"/>
	</footer>
	
	</body>
</html>