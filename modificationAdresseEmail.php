<?php
session_start();

    if(empty($_SESSION['username']))
    {
        header('location: index.php');
    }
    
    $err = "";
    if(isset($_POST['new_email']) && isset($_POST['new_email2']))
    {
        if($_POST['new_email'] == $_POST['new_email2'])
        {
            $pdo = new PDO("mysql:host=localhost;dbname=appetit", "appetit", "appetit_helha_pwd");
            $registration = $pdo->prepare("UPDATE comptes SET cpt_email=:email WHERE cpt_compte=:username");
            $registration->bindParam(":email", $_POST['new_email']);
            $registration->bindParam(":username", $_SESSION['username']);
            if($registration->execute())
            {
                // ok mis a jour
                $err = "<div id='warning'>SUCCES !</div>";
                $_SESSION['email'] = $_POST['new_email'];
            }
            else
            {
                $err = "<div id='warning'>ERREUR MISE A JOUR - COMPTE AVEC MEME MAIL DEJA EXISTANT ?</div>";
            }
        }
        else
        {
            $err = "<div id='warning'>MAILS DIFFERENTS</div>";
        }
    }
?> 
<html>
	<head>
	<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="design.css" />
        <script type="text/javascript" src="jquery.js"></script>
        
        <title>Modification adresse e-mail</title>
	</head>
	<body>
	<p id="connect" >
		<font color="green">Connecté</font>
		<BR>Solde : <?php echo $_SESSION['argent']; ?>€
	</p>
    <?php echo $err; ?>
	<h4>Changement de l'adresse e-mail</h4>
    <form action="modificationAdresseEmail.php" method="post">
	<!--<p id="holdEmail"><span class='spaced'>Ancienne adresse e-mail:</span>
	<input type="text" id="ancienEmail" placeholder="Ancienne adresse" maxlength="25" name="hold_email" /></p> --->
<!--	<center><font color="red">Adresse introuvable</font></center>  -->
	<p id="newEmail"><span class='spaced'>Nouvelle adresse e-mail:</span>
	<input type="text" id="nouvEmail" placeholder="Nouvelle adresse" maxlength="25" name="new_email" /></p>
<!--	<center><font color="red">Nouvelle adresse incompatible</font></center>  -->
	<p id="newEmail2"><span class='spaced'>Retapez votre nouvelle adresse e-mail:</span>
	<input type="text" id="nouvEmail2" placeholder="Nouvelle adresse" maxlength="25" name="new_email2" /></p>
<!--	<center><font color="red">Nouvelle adresse incompatible</font></center>  -->
	
	<br>
	<br>
	
    <center><input type="submit" class="button" id="suivant" onclick="#" value="Sauvegarder" /></center>
    </form>
	<br>
	<br>
	<center><button class="button" id="Annuler1" onclick="document.location.href='./GestionCompte.php';">Annuler</button></center>
	
	<footer>
		<img src="logo.png" id="logo"/>
	</footer>
	
	</body>
</html>