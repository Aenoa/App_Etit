<?php
session_start();

    if(empty($_SESSION['username']))
    {
        header('location: index.php');
    }
    
    $pdo = new PDO("mysql:host=localhost;dbname=appetit", "appetit", "appetit_helha_pwd");
	$listeEcoles = "";
    $listeSandwich = "";
    $listeSauces = "";
    $erreur = "";
    
    $reqEcole = $pdo->prepare("SELECT * FROM etablissements");
    $reqSandwich = $pdo->prepare("SELECT * FROM sandwichs");
    $reqSauces = $pdo->prepare("SELECT * FROM sauces");
    
    if($reqEcole->execute())
    {
        while($reqResult1 = $reqEcole->fetch(PDO::FETCH_OBJ))
        {
            $listeEcoles .= "<option value='".$reqResult1->etb_id."'>".$reqResult1->etb_nom."</option>\n";
        } 
    }
    else
    {
        $erreur = "Problème lors de la requete SQL 1.\n";
    }
    
    if($reqSandwich->execute())
    {
        while($reqResult2 = $reqSandwich->fetch(PDO::FETCH_OBJ))
        {
            $listeSandwich .= "<option value='".$reqResult2->sdw_id."'>".$reqResult2->sdw_nom."</option>\n";
        }
    }
    else
    {
        $erreur = "Problème lors de la requete SQL 2.\n";
    }
    
    if($reqSauces->execute())
    {
        while($reqResult3 = $reqSauces->fetch(PDO::FETCH_OBJ))
        {
            $listeSauces .= "<option value='".$reqResult3->sauce_id."'>".$reqResult3->sauce_name."</option>\n";
        }
    }
    else
    {
        $erreur = "Problème lors de la requete SQL 3.\n";
    }
?>

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="design.css" />
        <title>app_etit :: commande de sandwichs</title>
    </head>
    <body>
	<p id="connect" >
		<font color="green">Connecté</font>
		<BR>Solde : <?php echo $_SESSION['argent']; ?>€
	</p>
                
        <form action="RecapitulatifCommande.php" method="post" id="formOrderSandwich">
        <section id="commandesOrder"> 
            <?php echo $erreur; ?>
            <h1>Commander un sandwich</h1>
                
                <label for="orderCampus">Campus à livrer:</label><br />
                <select id="orderCampus" name="orderCampus">
                    <?php echo $listeEcoles; ?>
                </select><br />
                
                <label for="orderType">Type de sandwich: </label><br />
                <select id="orderType" name="orderType">
                    <?php echo $listeSandwich; ?>
                </select><br />
				
				<label for="orderType">Crudités: </label><br/>
				<select id="orderType" name="orderCrud">
                        <option value="1" selected>Avec</option>
                        <option value="0">Sans</option>
                </select><br />
				
				<label for="orderType">Sauces: </label><br/>
				<select id="orderType" name="orderSauce">
                        <?php echo $listeSauces; ?>
                </select><br />
        </section>
            <br />
            <center><input type="submit" class="button" id="suivant" value="Confirmer" /></center>
        </form>
	  <br />
	  <br />
	  <center><button class="button" id="Annuler1" onclick="document.location.href='./menu.php';">Retour à l'accueil</button></center>
	  
	 <footer>
		<img src="logo.png" id="logo"/>
	</footer>
	  
    </body>
</html>


