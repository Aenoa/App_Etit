<?php
session_start();

    if(empty($_SESSION['username']))
    {
        header('location: index.php');
    }
    $err = "";
    if(isset($_POST['compte']) && isset($_POST['somme']))
    {
        try
        {
            $pdo = new \PDO("mysql:host=localhost;dbname=appetit", "appetit", "appetit_helha_pwd"); 
			$req = $pdo->prepare("UPDATE comptes SET cpt_argent = (SELECT cpt_argent FROM comptes WHERE cpt_compte=:user LIMIT 1) + :argent WHERE cpt_compte = :user");
            $req->bindParam(':user', $_POST['compte']);
            $req->bindParam(':argent', $_POST['somme']);
            
            if($req->execute())
            {
                $err = "<div id='warning'>SUCCES! Argent ajouté</div>";
            }
            else 
            {
                $err = "<div id='warning'>ERREUR AJOUT ARGENT. argent entré avec un . (point) en séparateur ? bon nom de compte ?</div>";
            }
        } 
        catch (PDOException $e)
        {
            die($e->getMessage());
        }
    }
?> 
 
<!DOCTYPE html>
<html>

	<head>
	
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet"  type="text/css" href="design.css"/>
	</head>
	
	<body>
		<p id="connect" >
			<font color="green">Connecté</font>
			<BR>~ Admin
		</p>
		<div id="titre">
			<p> <h4>Ajouter de l'argent</h4></p>
		</div>
		<br>
		<br>
        <form action="AjouterArgent.php" method="post">
            <section id="formLogin">
                <fieldset>
                    <legend align="center">Informations</legend>
                    <label>compte de l'étudiant : </label></br><input type="text" name="compte"/> </br>
                    <label>Montant (en € ) </label></br><input type="text" name="somme"/> </br>
                </fieldset>
            </section>

            <BR>
            <BR>
            <center><input type="submit" value="ajouter argent" class="button" id="suivant" /></center>
        </form>
		<BR>
		<BR>
		<center><button class="button" onclick="document.location.href='./GestionAdmin.php';" id="suivant">Retour à l'accueil</button></center>

		<footer>
			<img src="logo.png" id="logo"/>
		</footer>

	</body>
	
</html>



