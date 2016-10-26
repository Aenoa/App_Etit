<?php
	ob_start();
	session_start();
	
	spl_autoload_extensions('.php');
	spl_autoload_register();
	
	if( !empty($_SESSION['username']))
	{
		switch($_SESSION['level'])
		{
			case 9:
				header("location: manager.php");
				break;
			default:
				header("location: commande.php");
				break;
		}
	}
	
	$notificationsLogin = "";
	$notificationsRegister = "";
	
	if( !is_null(\classes\DataHandler::obtainPOST("login_account")) 
	&&	!is_null(\classes\DataHandler::obtainPOST("login_password")))
	{
		try
		{
			$username = filter_input(INPUT_POST, 'login_account',  FILTER_SANITIZE_STRING);
			$password = sha1(filter_input(INPUT_POST, 'login_password', FILTER_SANITIZE_STRING));
            
            //$pdo = \classes\singletonPDO::getInstance();
            $pdo = new \PDO("mysql:host=localhost;dbname=appetit", "appetit", "appetit_helha_pwd");
			$requete = $pdo->prepare("SELECT * FROM comptes WHERE compte=:compte");
			$requete->bindParam(':compte', $username);
			
			if($requete->execute())
			{
				if($requete->rowCount() > 0)
				{
					$resultat = $requete->fetch(\PDO::FETCH_OBJ);
					if($resultat->password == $password)
					{
						$_SESSION['username'] = $resultat->compte;
						$_SESSION['password'] = $resultat->password;
						$_SESSION['level'] = $resultat->level;
						$_SESSION['argent'] = $resultat->argent;
						header("location: index.php");
					}
					else
					{
						$notificationsLogin .= "<div id='warning'>Le mot de passe entré est incorrect.</div>";
					}
				}
				else
				{
					$notificationsLogin .= "<div id='warning'>Le compte entré n'existe pas en base de données.</div>";
				}
			}
			else
			{
				$notificationsLogin .= "<div id='warning'>Une erreur à eu lieu lors de la connexion à la base de donnée</div>";
			}
		}
		catch(\PDOException $e)
		{
			$notificationsLogin = "<div id='fatalError'>ERREUR LORS DU TRAITEMENT EN BASE DE DONNÉES: <br />".$e->getMessage()."</div>";
		}
	}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="design.css" />
        <script type="text/javascript" src="jquery.js"></script>
        
        <title>app_etit :: accueil</title>
    </head>
    <body>
		<header></header>
		
        
		<section id="formLogin">
            <h1>Connexion</h1>
            
            <div id="loginNotifications">
                <?php echo $notificationsLogin; ?>
            </div>
			<form action="index.php" method="post" id="loginForm">
				<label for="username">Nom d'utilisateur:</label><br />
				<input type="text" id="username" placeholder="nom de compte" maxlength="25" name="login_account" /><br />
                
				<label for="password">Mot de Passe</label><br />
				<input type="password" id="password" maxlength="25" name="login_password" /><br />
				
                <input type="submit" name="loginConfirm" value="Se connecter" /><br />
			</form>
            
            <button class="switch" id="showRegisterForm">Pas encore inscrit ? Créer un compte ici</button>
		</section>
        
        <section id="formRegister">
            <button class="switch" id="showLoginForm">Déjà inscrit ? Connectez vous ici</button>
            
            <h1>Inscription</h1>
            
            <div id="registerNotifications">
                <?php echo $notificationsRegister; ?>
            </div>
            
			<form action="index.php" method="post" id="registerForm">
                <label for="registerUsername">Nom d'utilisateur:</label><br />
				<input type="text" id="registerUsername" placeholder="nom de compte" maxlength="25" name="registerUsername" /><br />
				
                <label for="registerPassword">Mot de passe:</label><br />
				<input type="text" id="registerPassword" placeholder="nom de compte" maxlength="105" name="registerPassword" /><br />
				
                <label for="registerPasswordConfirm">Ré-entrez le mot de passe:</label><br />
				<input type="text" id="registerPasswordConfirm" placeholder="nom de compte" maxlength="105" name="registerPasswordConfirm" /><br />
				
                <label for="registerAddress">Adresse e-mail:</label><br />
				<input type="text" id="registerAddress" placeholder="nom de compte" maxlength="225" name="registerAddress" /><br />
				
                <label for="registerAddressConfirm">ré-entrez l'adresse e-mail:</label><br />
				<input type="text" id="registerAddressConfirm" placeholder="nom de compte" maxlength="225" name="registerAddressConfirm" /><br />
                
                <label for="registerFirstName">Votre prénom: </label><br />
				<input type="text" id="registerFirstName" placeholder="nom de compte" maxlength="105" name="registerFirstName" /><br />
				
                <label for="registerLastName">Votre nom de famille:</label><br />
				<input type="text" id="registerLastName" placeholder="nom de compte" maxlength="105" name="registerLastName" /><br />
                
                <input type="submit" name="registerConfirm" value="Créer un nouveau compte" />
            </form>
        </section>
        
        
		<script>
            $(".switch").click(function()
            {
                $("section#formLogin").slideToggle("normal", function() 
                {
                  $("#formRegister").slideToggle("normal");  
                });
                //
            });
        </script>
    </body>
</html>

<?php
ob_end_flush();
