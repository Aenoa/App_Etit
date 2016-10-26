<?php
session_start();

    if(empty($_SESSION['username']))
    {
        header('location: index.php');
    }
	
    $err = "";
    if(isset($_POST['new_mdp']) && isset($_POST['new_mdp2']))
    {
        $cryptedNew = sha1(filter_input(INPUT_POST, 'new_mdp', FILTER_SANITIZE_STRING));
        if($_POST['new_mdp'] == $_POST['new_mdp2'])
        {
            $pdo = new PDO("mysql:host=localhost;dbname=appetit", "appetit", "appetit_helha_pwd");
            $registration = $pdo->prepare("UPDATE comptes SET cpt_password=:passwd WHERE cpt_compte=:username");
            $registration->bindParam(':passwd', $cryptedNew);
            $registration->bindParam(":username", $_SESSION['username']);
            if($registration->execute())
            {
                // ok mis a jour
                $err = "<div id='warning'>SUCCES !</div>";
            }
            else
            {
                $err = "<div id='warning'>ERREUR MISE A JOUR</div>";
            }
        }
        else
        {
            $err = "<div id='warning'>MOT DE PASSE DIFFERENTS</div>";
        }
    }
    
?>  
<html>
	<head>
	<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="design.css" />
        <script type="text/javascript" src="jquery.js"></script>
        
        <title>Modifciation mot de passe</title>
	</head>
	<body>
	<p id="connect" >
		<font color="green">Connecté</font>
		<BR>Solde : <?php echo $_SESSION['argent']; ?>€
	</p>
    <form action="modificationMotDePasse.php" method="post">
	<h4>Changement du mot de passe</h4>
    <?php echo $err; ?>
    <!---
	<p id="holdMdp"><span class='spaced'>Ancien mot de passe:</span>
	<input type="text" id="ancienMdp" placeholder="Ancien mot de passe" maxlength="25" name="hold_mdp" /></p> --->
	<p id="newMdp"><span class='spaced'>Nouveau mot de passe:</span>
	<input type="text" id="nouvMdp" placeholder="Nouveau mot de passe" maxlength="25" name="new_mdp" /></p>
<!--	<center><font color="red">Nouveau mot de passe incompatible</font></center>  -->
	<p id="newMdp2"><span class='spaced'>Retapez votre nouveau mot de passe:</span>
	<input type="text" id="nouvMdp2" placeholder="Nouveau mot de passe" maxlength="25" name="new_mdp2" /></p>
<!--	<center><font color="red">Nouveau mot de passe incompatible</font></center>  -->
	
	<br>
	<br>
	
	<center><input type="submit" value="Sauvegarder" class="button" id="suivant" /></center>
    </form>
	<br>
	<br>
	<center><button class="button" id="Annuler1" onclick="document.location.href='./GestionCompte.php';">Annuler</button></center>
	
	<footer>
		<img src="logo.png" id="logo"/>
	</footer>
	
	</body>
</html>