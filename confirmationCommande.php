<?php
session_start();

    if(empty($_SESSION['username']))
    {
        header('location: index.php');
    }
     
    $etat = "";
    try
    {
        $pdo = new PDO("mysql:host=localhost;dbname=appetit", "appetit", "appetit_helha_pwd"); 
        $requete = $pdo->prepare("SELECT count( commandes.cmd_sandwich ) AS current, "
                . "sandwichs.sdw_quota AS total, sandwichs.sdw_base_price AS pbase, "
                . "sandwichs.sdw_crudites_price AS pcrudites, "
                . "(sandwichs.sdw_crudites_price + sandwichs.sdw_base_price) as total "
                . "FROM commandes INNER JOIN sandwichs ON sandwichs.sdw_id = commandes.cmd_sandwich "
                . "WHERE cmd_sandwich = :sdw AND cmd_date LIKE :date");
        $requete->bindParam(':sdw', $_POST['orderType']);
        $requete->bindValue(':date', date('Y-m-d').'%');

        if($requete->execute())
        {
            $fetched = $requete->fetch(PDO::FETCH_OBJ);
            if($fetched->current < $fetched->total)
            {
                // valide, sauvegarde
                $rqs = $pdo->prepare("SELECT sauce_price FROM sauce WHERE sauce_id=:sauce");
                $rqs->bindParam(':sauce', $_POST['orderSauce']);
                if($rqs->execute())
                {
                    $saucef = $rqs->fetch(PDO::FETCH_OBJ);
                    $sauce = $saucef->sauce_price;
                }
                else
                {
                    $sauce = 0.00;
                }

                $total = $sauce + $fetched->pbase + ($_POST['orderCrud'] ? $fetched->pcrudites : 0.00);

                if($total > $_SESSION['argent'])
                {
                    header('location: erreurCommande.php');
                }
                else
                {
                    $insertion = $pdo->prepare("INSERT INTO commandes "
                            . "(cmd_id, cmd_user, cmd_etablissement, cmd_sandwich, cmd_crudites, cmd_sauce, cmd_total, cmd_isPaid, cmd_isMade, cmd_isTaken, cmd_date) "
                            . "VALUES (NULL, :user, :ecole, :sandwich, :crudites, :sauce, :total, 1, 0, 0, CURRENT_DATE())");
                    $insertion->bindParam(':user', $_SESSION['username']);
                    $insertion->bindParam(':ecole', $_POST['orderCampus']);
                    $insertion->bindParam(':sandwich', $_POST['orderType']);
                    $insertion->bindParam(':crudites', $_POST['orderCrud']);
                    $insertion->bindParam(':sauce', $_POST['orderSauce']);
                    $insertion->bindParam(':total', $total);

                    if($insertion->execute())
                    {
                        $newArgent = $_SESSION['argent'] - $total;

                        $upargent = $pdo->prepare("UPDATE comptes SET cpt_argent = :argent WHERE cpt_compte = :user");
                        $upargent->bindParam(':user', $_SESSION['username']);
                        $upargent->bindValue(':argent', $newArgent);
                        if($upargent->execute())
                        {
                            $_SESSION['argent'] = $newArgent;
                            $etat = "Commande terminée !";
                        }
                        else
                        {
                            $etat = "commande terminée, mais erreur retrait argent!";
                        }
                    }
                    else
                    {
                        header('location: erreurCommande.php');
                    }
                }
            }
            else
            {
                header('location: erreurCommande.php');
            }
        }
    } 
    catch (PDOException $ex) 
    {
        die($ex->getMessage());
    }
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Confirmation</title>
		<link rel="stylesheet" href="design.css">
		<script language="javascript" type="text/javascript">
		var compte=3;
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
	
	</header>
	<div id="texte">
			<p><h4>
				<?php echo $etat; ?> <br>
				Vous serez redirigé dans <span id="compt"></span>.
			</h4></p>
	</div>
	<meta http-equiv="refresh" content="3 ; url=menu.php">
	
	<footer>
		<img src="logo.png" id="logo"/>
	</footer>
	
	</body>



</html>