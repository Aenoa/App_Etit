<?php
session_start();

    if(empty($_SESSION['username']))
    {
        header('location: index.php');
    }
    
     $sdw_data = array();
     
    try
    {
        $pdo = new PDO("mysql:host=localhost;dbname=appetit", "appetit", "appetit_helha_pwd"); 
        //-----------
         if(isset($_POST['suivant']) && isset($_POST['sdw']))
        {
            // mise à jour des sandwich
            foreach($_POST['sdw'] as $key => $data)
            {
                $req = $pdo->prepare("UPDATE commandes SET cmd_isMade = 1 WHERE cmd_id =:id");
                $req->bindParam(':id', $key);
                if($req->execute())
                {
                    // ok
                }
                else
                {
                    // failed
                }
            }
        }
        
        
        $reqQte = $pdo->prepare("SELECT commandes.*, sandwichs.*, comptes.*, sauces.*, etablissements.* "
            . "FROM commandes "
            . "INNER JOIN sandwichs ON sandwichs.sdw_id = commandes.cmd_sandwich "
            . "INNER JOIN comptes ON comptes.cpt_compte = commandes.cmd_user "
            . "INNER JOIN sauces ON sauces.sauce_id = commandes.cmd_sauce "
            . "INNER JOIN etablissements ON etablissements.etb_id = commandes.cmd_etablissement "
            . "WHERE commandes.cmd_isMade=0 AND commandes.cmd_date <= CURDATE()");
        
        if($reqQte->execute())
        {
            while(($res = $reqQte->fetch(PDO::FETCH_OBJ)) != null)
            {
                $sdw_data[] = array(
                    'owner' => $res->cmd_user . " (".$res->cpt_nom." ".$res->cpt_prenom." -".$res->cpt_helha.") @ " . $res->etb_nom,
                    'sdw_id' => $res->cmd_id,
                    'sdw_info' => $res->sdw_nom . "; crudités: ". ($res->cmd_crudites == 1 ? "oui" : "non") . "; sauce: " . $res->sauce_name
                );
            }
        }
        else
        {
            die("erreur fatale au chargement des commandes");
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
        <link rel="stylesheet" type="text/css" href="design.css" />
        <title>app_etit :: Gestion des commandes</title>
		
    </head>
    <body>
		<p id="connect" >
			<font color="green">Connecté</font>
			<BR>~ Admin
		</p>
		
		<div id="titre">
			<p><h4>Gestion des commandes</h4></p>
		</div>
		<br>
		<br>
        <form action="manager.php" method="post">
		<table width="100%" id="recap">
			<tr>
				<th colspan="3">Commandes en attente de production</th>
			</tr>
			<tr>
				<th>Nom</th>
				<th>Sandwich</th>
				<th>Etat</th>
			</tr>
            
            <?php foreach($sdw_data as $k) { ?>
			<tr>
				<td><?php echo $k['owner']; ?></td>
				<td><?php echo $k['sdw_info']; ?></td>
                <td> <INPUT type="checkbox" name="sdw[<?php echo $k['sdw_id']; ?>]" id="sdw-<?php echo $k['sdw_id']; ?>" /> <label for="sdw-<?php echo $k['sdw_id']; ?>">Confirmer la fabrication</label></td>
			</tr>
            <?php } ?>
            
		</table>
        <BR>
        <BR>
		<BR>
		<center><input type="submit" class="button" name="suivant" id="suivant" /></center>
		<BR>
        </form>
		<center><button class="button" onclick="document.location.href='./GestionAdmin.php';" id="suivant">Retour à l'accueil</button></center>
		
		<footer>
			<img src="logo.png" id="logo"/>
		</footer>
		
    </body>
</html>
