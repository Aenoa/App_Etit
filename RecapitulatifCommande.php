<?php
session_start();

    if(empty($_SESSION['username']))
    {
        header('location: index.php');
    }
     
    $pdo = new PDO("mysql:host=localhost;dbname=appetit", "appetit", "appetit_helha_pwd"); 
    
    //---------------------sauce
    $reqSauces = $pdo->prepare("SELECT * FROM sauces WHERE sauce_id=:id");
    $reqSauces->bindParam(':id', $_POST['orderSauce']);
    
    if($reqSauces->execute())
    {
        $reqfsauce = $reqSauces->fetch(PDO::FETCH_OBJ);
        $sauce = $reqfsauce->sauce_name; 
    }
    //-----------------------sandwich
    $reqSdw = $pdo->prepare("SELECT * FROM sandwichs WHERE sdw_id=:id");
    $reqSdw->bindParam(':id', $_POST['orderType']);
    
    if($reqSdw->execute())
    {
        $reqSdwf = $reqSdw->fetch(PDO::FETCH_OBJ);
        $sandwich = $reqSdwf->sdw_nom; 
    }
    //----------------------ecole
    $reqec = $pdo->prepare("SELECT * FROM etablissements WHERE etb_id=:id");
    $reqec->bindParam(':id', $_POST['orderCampus']);
    
    if($reqec->execute())
    {
        $reqecf = $reqec->fetch(PDO::FETCH_OBJ);
        $ecole = $reqecf->etb_nom; 
    }
?> 
 
<html>
    <head>
        <meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="design.css" />
        <script type="text/javascript" src="jquery.js"></script>
        
        <title>Recap Commande</title>
    </head>
	<body>
	<p id="connect" >
		<font color="green">Connecté</font>
		<BR>Solde : <?php echo $_SESSION['argent']; ?>€
	</p>
    <form action="modeDePaiement.php" method="post">
		<table id="recap">
			<tr>
				<th colspan="2">Récapitulatif de votre Commande</th>
			</tr>
			<tr>
				<td>Ecole de livraison :</td>
				<td><input type="text" style="display: none;" value="<?php echo $_POST['orderCampus']; ?>" name="orderCampus" /><?php echo $ecole; ?></td>
			</tr>
			<tr>
				<td>Elève :</td>
				<td><input type="text" style="display: none;"  value="<?php echo $_SESSION['helha'] . " " . $_SESSION['nom'] . " " . $_SESSION['prenom']; ?>" name="helha" />
                    <?php echo $_SESSION['helha'] . " " . $_SESSION['nom'] . " " . $_SESSION['prenom']; ?></td>
			</tr>
			<tr>
				<td>Sandwich :</td>
				<td><input type="text" style="display: none;" value="<?php echo $_POST['orderType']; ?>" name="orderType" /><?php echo $sandwich; ?></td>
			</tr>
			<tr>
				<td>Sauce :</td>
				<td><input type="text" style="display: none;" value="<?php echo $_POST['orderSauce']; ?>" name="orderSauce" /><?php echo $sauce; ?></td>
			</tr>
			<tr>
				<td>Crudité :</td>
				<td><input type="text" style="display: none;" value="<?php echo $_POST['orderCrud']; ?>" name="orderCrud" /><?php echo $_POST['orderCrud']; ?> (0 = non, 1 = oui)</td>
			</tr>
		</table>
		
		<br>
		<br>
		<center>
			 <!---<button class="button"onclick="document.location.href='./commande.php';" id="recommander">Commander un autre sandwich</button>--->
             <input type="submit" class="button" value="Choix du paiement" id="choixPaiement" /></button>
		 </center>
    </form>
		 <br>
		 <br>
		 <center><button class="button" onclick="document.location.href='./menu.php';" id="Annuler1">Annuler</button></center>
		 
		<footer>
			<img src="logo.png" id="logo"/>
		</footer>
		 
	</body>
</html>