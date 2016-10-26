<?php
session_start();

    if(empty($_SESSION['username']) || $_SESSION['level'] < 9)
    {
        header('location: index.php');
    }
     
    try{
    
    $pdo = new PDO("mysql:host=localhost;dbname=appetit", "appetit", "appetit_helha_pwd");
    
    if(isset($_POST['suivant']))
    {
        // mise à jour des sandwich
        foreach($_POST['quota'] as $key => $data)
        {
            $req = $pdo->prepare("UPDATE sandwichs SET sdw_quota = :quota WHERE sdw_id=:id");
            $req->bindParam(':quota', $data);
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
    
    // chargement des quotas
    $reqSandwich = $pdo->prepare("SELECT * FROM sandwichs");
    $sdw_data = array();
    
    if($reqSandwich->execute())
    {
        while($reqResult = $reqSandwich->fetch(PDO::FETCH_OBJ))
        {
            $reqQte = $pdo->prepare("SELECT count(*) as today FROM commandes WHERE cmd_sandwich=:id AND cmd_date=:date");
            $reqQte->bindValue(':date', date("Y-m-d 00:00:00"));
            $reqQte->bindParam(':id', $reqResult->sdw_id);
            if($reqQte->execute())
            {
                $res = $reqQte->fetch(PDO::FETCH_OBJ);
                $daily = $res->today;
            }
            else
            {
                $daily = "Inconnu";
            }
            
            $sdw_data[] = array(
              'name' => $reqResult->sdw_nom,
              'id' => $reqResult->sdw_id,
              'desc' => $reqResult->sdw_description,
              'crudites' => $reqResult->sdw_accept_crudites,
              'prix_base' => $reqResult->sdw_base_price,
              'prix_crudites' => $reqResult->sdw_crudites_price,
              'quota' => $reqResult->sdw_quota,
              'today' => $daily
            );
        }
    }
    else
    {
        $erreur = "Problème lors de la requete SQL 2.\n";
    }
    
    }catch(PDOException $e){ die($e->getMessage());}
?>

<html>

	<head>
        <title>Changement des sandwichs</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="design.css" />
		<script type="text/javascript" src="jquery.js"></script>
	</head>
	
	<body>
		<p id="connect" >
			<font color="green">Connecté</font>
			<BR><?php echo $_SESSION['username']; ?>
		</p>
		<div id="titre">
			<h4>Veuillez cocher les sandwichs encore disponible </h4>
		</div>
		<br>
		<br>
		
        <form action="SandwichDispo.php" method="POST">
		<table id="sanddisp">
			<tr>
				<th>Sandwichs</th>
				<th>Quotas journaliers</th>
			</tr>
            <?php foreach($sdw_data as $k) { ?>
			<tr>
                <td><?php echo $k['name']; ?></td>
				<td><input type="number" placeholder="" value="<?php echo $k['quota']; ?>" name="quota[<?php echo $k['id']; ?>]" /> (déjà commandé: <?php echo $k['today']; ?>)</td>
			</tr>
            <?php } ?>
		</table>
		
	<div id="bouton">
		<BR>
		<BR>
        <center>
            <input type="submit" name="suivant" class="button" id="suivant" value="Enregistrer" />
        </center>
		<BR>
		<BR>
		<center><button class="button" onclick="document.location.href='GestionAdmin.php';" id="retour">Retour à l'accueil</button></center>
	</div>
	</form>
        
	<footer>
		<img src="logo.png" id="logo"/>
	</footer>

	</body>
	
</html>



