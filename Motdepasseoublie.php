<?php
session_start();

    if(!empty($_SESSION['username']))
    {
        header('location: index.php');
    } 
    
    include('password_generator.php');
    $err = "";
    
    if(isset($_POST['mdpOubli_mail']))
    {
        $pdo = new PDO("mysql:host=localhost;dbname=appetit", "appetit", "appetit_helha_pwd");
        $req = $pdo->prepare("SELECT * FROM comptes WHERE cpt_email = :mail LIMIT 0,1");
        $req->bindParam(':mail', $_POST['mdpOubli_mail']);
        if($req->execute())
        {
            if($req->rowCount())
            {
                $password = randomizePassword();
                $newPassword = sha1($password);
                
                $req = $pdo->prepare("UPDATE comptes SET cpt_password = :pass WHERE cpt_email = :mail");
                $req->bindParam(':mail', $_POST['mdpOubli_mail']);
                $req->bindParam(':pass', $newPassword);
                if($req->execute())
                {
                    if(mail($_POST['mdpOubli_mail'], "NOUVEAU MAIL", "votre nouveau mdp est " . $password ." --- L'admin APPETIT"))
                    {
                        $err = "UN NOUVEAU MDP VOUS A ETE ENVOYE.";
                    }
                    else
                    {
                        $err = "ERREUR LORS DE L'ENVOI DU MAIL. VOTRE MDP EST " . $password;
                    }
                }
                else
                {
                    $err = "ERREUR LORS DE LA MODIFICATION DU MDP";
                }
            }
            else
            {
                $err = "AUCUN COMPTE N'EXISTE AVEC CE MAIL";
            }
        }
        else
        {
            $err = "ERREUR SQL ---- ABANDON DE LA REQUETE";
        }
        
    }
?>

<html>
    <head>
        <meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="design.css" />
        <script type="text/javascript" src="jquery.js"></script>
        
        <title>Envoi d'email</title>
    </head>
	<body>
		<h3>Mot de passe oublié?</h3>
		 <center> Veuillez insérer votre adresse e-mail pour réinitialiser votre mot de passe :</center>
		 <section id="formMdp_mail">
			<form action="Motdepasseoublie.php" method="post" id="mdp_mail">
				</BR><input type="text" id="mdpmail"  maxlength="25" name="mdpOubli_mail" /><br /></BR>
				<center><button class="button" id="Envoi">Envoyer</button></BR></BR></BR></center>
			</form>
			<center><button class="button" onclick="javascript:document.location.href='./index.php';" id="Annuler">Annuler</button><BR></center>
		 </section>
		 <center style="color:red;"><?php echo $err; ?></center>
		 
		 <footer>
			<img src="logo.png" id="logo"/>
		</footer>
		 
	</body>
</html>