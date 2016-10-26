<?php
session_start();

    if(empty($_SESSION['username']))
    {
        header('location: index.php');
    }
	 
    if(isset($_POST['nom']) || isset($_POST['prenom']) || isset($_POST['login']))
    {
        $pdo = new PDO("mysql:host=localhost;dbname=appetit", "appetit", "appetit_helha_pwd");
        $registration = $pdo->prepare("UPDATE comptes SET cpt_nom=:nom, cpt_prenom=:prenom, cpt_helha=:helha WHERE cpt_compte=:username");
        $registration->bindParam(':username', $_SESSION['username']);
        $registration->bindParam(':nom', $_POST['nom']);
        $registration->bindParam(':prenom', $_POST['prenom']);
        $registration->bindParam(':helha', $_POST['login']);
        if($registration->execute())
        {
            // ok mis a jour
            
            $_SESSION['prenom'] = $_POST['prenom'];
            $_SESSION['nom'] = $_POST['nom'];
            $_SESSION['helha'] = $_POST['login'];
        }
    }
?>   
<html>
	<head>
	<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="design.css" />
        <script type="text/javascript" src="jquery.js"></script>
        
        <title>Modification utilisateur</title>
	</head>
	<body>
	<p id="connect" >
		<font color="green">Connecté</font>
		<BR>Solde : <?php echo $_SESSION['argent']; ?>€
	</p>
    <form action="modificationUtilisateur.php" method="post">
	<h4>Modification des données de l'utilisateur</h4>
	<p id="nom"><span class='spaced'>Nom de l'utilisateur:</span>
	<input type="text" id="nom" value="<?php echo $_SESSION['nom']; ?>" placeholder="Nom" maxlength="25" name="nom" /></p>
	<p id="prenom"><span class='spaced'>Prenom de l'utilisateur:</span>
	<input type="text" id="prenom" value="<?php echo $_SESSION['prenom']; ?>" placeholder="Prenom" maxlength="25" name="prenom" /></p>
	<p id="login"><span class='spaced'>Entrez votre login(helha):</span>
	<input type="text" id="login" value="<?php echo $_SESSION['helha']; ?>" placeholder="Helha de l'utilisateur" maxlength="25" name="login" /></p>
	
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