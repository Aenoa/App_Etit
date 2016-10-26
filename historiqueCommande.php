<?php
session_start();

    if(empty($_SESSION['username']))
    {
        header('location: index.php');
    }
    
    $listeCommandes = "";
    
     try
    {
        $pdo = new PDO("mysql:host=localhost;dbname=appetit", "appetit", "appetit_helha_pwd"); 
        $requete = $pdo->prepare("SELECT commandes.cmd_date as date, etablissements.etb_nom as nom, commandes.cmd_isMade as made, commandes.cmd_isPaid as paid, commandes.cmd_isTaken as taken FROM commandes INNER JOIN etablissements ON etablissements.etb_id = commandes.cmd_etablissement WHERE cmd_user = :user");
        $requete->bindParam(':user', $_SESSION['username']);
        
        if($requete->execute())
        {
            while(($fet = $requete->fetch(PDO::FETCH_OBJ)) != null)
            {
                $listeCommandes .= "<tr>"
                        . "<td>".$fet->date."</td>"
                        . "<td>".$fet->nom."</td>"
                        . "<td>payé: ".($fet->paid  == 1 ? "oui":"non")."<br />fabriqué: ".($fet->made  == 1 ? "oui":"non")."<br />récupéré: ".($fet->taken == 1 ? "oui":"non")."</td></tr>";
            }
        }
    }
    catch(PDOException $e)
    {
        die($e->getMessage());
    }
    
?> 
<html>
	<head>
        <meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="design.css" />
        <script type="text/javascript" src="jquery.js"></script>
        
        <title>Historique commande</title>
    </head>
	<body>
		<p id="connect" >
			<font color="green">Connecté</font>
			<BR>Solde : <?php echo $_SESSION['argent']; ?>€
		</p>
		<table width="100%" id="historique">
            <tr>
                <th colspan="3">Historique des commandes</th>
            </tr>
        
            <tr>
                <th>Date et heure</th>
                <th>Etablissement</th>
                <th>Etat de la commande</th>
            </tr>
            <?php echo $listeCommandes; ?>
		</table>
		<BR>
		<BR>
		 <center><button class="button" id="Annuler1" onclick="document.location.href='./menu.php';">Retour à l'accueil</button></center>
		 
		 <footer>
			<img src="logo.png" id="logo"/>
		</footer>
		 
	</body>
</html>