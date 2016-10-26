<?php
session_start();

    if(empty($_SESSION['username']))
    {
        header('location: index.php');
    }
     
    $err = "";
    if(isset($_POST['newLogin']) && isset($_POST['newLogin2']))
    {
        if($_POST['newLogin'] == $_POST['newLogin2'])
        {
            $pdo = new PDO("mysql:host=localhost;dbname=appetit", "appetit", "appetit_helha_pwd");
            $registration = $pdo->prepare("UPDATE comptes SET cpt_compte=:usernameNew WHERE cpt_compte=:username");
            $registration->bindParam(":usernameNew", $_POST['newLogin2']);
            $registration->bindParam(":username", $_SESSION['username']);
            if($registration->execute())
            {
                // ok mis a jour
                $err = "<div id='warning'>SUCCES !</div>";
            }
            else
            {
                $err = "<div id='warning'>ERREUR MISE A JOUR - COMPTE AVEC MEME NOM DEJA EXISTANT ?</div>";
            }
        }
        else
        {
            $err = "<div id='warning'>COMPTES DIFFERENTS</div>";
        }
    }
?> 
<html>
	<head>
	<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="design.css" />
        <script type="text/javascript" src="jquery.js"></script>
        
        <title>Modification du login</title>
	</head>
	<body>
	<p id="connect" >
		<font color="green">Connecté</font>
		<BR>Solde : <?php echo $_SESSION['argent']; ?>€
	</p>
    <?php echo $err; ?>
	<h4>Modification du login de l'utilisateur</h4>
    <form action="modificationLogin.php" method="post">
	<!-- <p id="oldLogin"><span class='spaced'>Ancien login(helha):</span>
	<input type="text" id="oldLogin" placeholder="Ancien login" maxlength="25" name="login" /></p> -->
<!--	<center><font color="red">Login incorrect</font></center>  -->
	<p id="newLogin"><span class='spaced'>Nouveau login:</span>
	<input type="text" id="newLogin" placeholder="Nouveau login" maxlength="25" name="newLogin" /></p>
<!--	<center><font color="red">Login incompatible</font></center>  -->
	<p id="newLogin2"><span class='spaced'>Retapez votre nouveau login:</span>
	<input type="text" id="newLogin2" placeholder="Nouveau login" maxlength="25" name="newLogin2" /></p>
<!--	<center><font color="red">Login incompatible</font></center>  -->
	
	<br>
	<br>
	
	<center><input type="submit" class="button" id="suivant" value="Sauvegarder" /></center>
    </form>
	<br>
	<br>
	<center><button class="button" id="Annuler1" onclick="document.location.href='./GestionCompte.php';">Annuler</button></center>
	
	<footer>
		<img src="logo.png" id="logo"/>
	</footer>
	
	</body>
</html>