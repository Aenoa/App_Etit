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
				header("location: GestionAdmin.php");
				break;
			default:
				header("location: menu.php");
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
            
            $pdo = new \PDO("mysql:host=localhost;dbname=appetit", "appetit", "appetit_helha_pwd"); 
			$requete = $pdo->prepare("SELECT * FROM comptes WHERE cpt_compte=:compte");
			$requete->bindParam(':compte', $username);
			
			if($requete->execute())
			{
				if($requete->rowCount() > 0)
				{
					$resultat = $requete->fetch(\PDO::FETCH_OBJ);
					if($resultat->cpt_password == $password)
					{
						$_SESSION['username'] = $resultat->cpt_compte;
						$_SESSION['password'] = $resultat->cpt_password;
                        $_SESSION['email'] = $resultat->cpt_email;
						$_SESSION['level'] = $resultat->cpt_level;
						$_SESSION['argent'] = $resultat->cpt_argent;
                        $_SESSION['nom'] = $resultat->cpt_nom;
                        $_SESSION['prenom'] = $resultat->cpt_prenom;
                        $_SESSION['helha'] = $resultat->cpt_helha;
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
    
    // ---- register
    
    if( !is_null(\classes\DataHandler::obtainPOST("registerUsername")) 
	&&	!is_null(\classes\DataHandler::obtainPOST("registerPassword"))
    &&	!is_null(\classes\DataHandler::obtainPOST("registerPasswordConfirm"))
    &&	!is_null(\classes\DataHandler::obtainPOST("registerAddress"))
    &&	!is_null(\classes\DataHandler::obtainPOST("registerAddressConfirm"))
    &&	!is_null(\classes\DataHandler::obtainPOST("registerFirstName"))
    &&	!is_null(\classes\DataHandler::obtainPOST("registerLastName")))
	{
		try
		{
			$username = filter_input(INPUT_POST, 'registerUsername',  FILTER_SANITIZE_STRING);
            $password1 = filter_input(INPUT_POST, 'registerPassword',  FILTER_SANITIZE_STRING);
            $password2 = filter_input(INPUT_POST, 'registerPasswordConfirm',  FILTER_SANITIZE_STRING);
            $email1 = filter_input(INPUT_POST, 'registerAddress',  FILTER_SANITIZE_STRING);
            $email2 = filter_input(INPUT_POST, 'registerAddressConfirm',  FILTER_SANITIZE_STRING);
            $nom = filter_input(INPUT_POST, 'registerFirstName',  FILTER_SANITIZE_STRING);
            $prenom = filter_input(INPUT_POST, 'registerLastName',  FILTER_SANITIZE_STRING);
			$pencrypted = sha1(filter_input(INPUT_POST, $password1, FILTER_SANITIZE_STRING));
            
            $pdo = new \PDO("mysql:host=localhost;dbname=appetit", "appetit", "appetit_helha_pwd");
			$requete = $pdo->prepare("SELECT * FROM comptes WHERE compte=:compte");
			$requete->bindParam(':compte', $username);
			
			if($requete->execute())
			{
				if($requete->rowCount() > 0)
				{
					if($password1 == $password2)
                    {
                        if($email1 == $email2)
                        {
                            $registration = 
                                    $pdo->prepare("INSERT INTO comptes(cpt_compte, cpt_password, cpt_level, "
                                            . "cpt_argent, cpt_email, cpt_nom, cpt_prenom) VALUES (:username, "
                                            . ":password, 1, :email, :nom, :prenom)");
                            $registration->bindParam(':username', $username);
                            $registration->bindParam(':password', $pencrypted);
                            $registration->bindParam(':email', $email1);
                            $registration->bindParam(':nom', $nom);
                            $registration->bindParam(':prenom', $prenom);
                            
                            if($registration->execute())
                            {
                                $notificationsLogin .= "votre compte est désormais actif!";
                                
                            }
                            else
                            {
                                $notificationsLogin .= "<div id='warning'>Une erreur à eu lieu lors de la connexion à la base de donnée</div>";
                            }
                        }
                        else
                        {
                            $notificationsRegister .= "<div id='warning'>L'EMAIL N'ES PAS IDENTIQUE !!</div>";
                        }
                    }
                    else
                    {
                        $notificationsRegister .= "<div id='warning'>LE MOT DE PASSE N'ES PAS IDENTIQUE !!</div>";
                    }
				}
				else
				{
					$notificationsRegister .= "<div id='warning'>UN NOM DE COMPTE EXISTE DEJA AVEC CE NOM</div>";
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
<html>
    <head>
        <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
       <link rel="stylesheet" type="text/css" href="design.css" />
        <script type="text/javascript" src="jquery.js"></script>
        <title>app_etit : accueil</title>
    </head>
    <body>
		<header></header>
		<?php echo $notificationsLogin; ?>
        <?php echo $notificationsRegister; ?>
        
	<br>
	
		<section id="formLogin">
            <h1>Connexion</h1>
            
			<form action="index.php" method="post" id="loginForm">
				<label for="username">Nom d'utilisateur:</label><br />
				<input type="text" id="username" placeholder="nom de compte" maxlength="25" name="login_account" /><br />
                
				<label for="password">Mot de Passe</label><br />
				<input type="password" id="password" placeholder="mot de passe" maxlength="25" name="login_password" /><br /><br />
				
                <input type="submit" name="loginConfirm" value="Se connecter" /><br /><br />
                <a href="Motdepasseoublie.php">Mot de passe oublié ?</a>
			</form> 
            
            <button class="switch" id="showRegisterForm">Pas encore inscrit ? Créer un compte ici</button>
		</section>
        
        <section id="formRegister">
            <button class="switch" id="showLoginForm">Déjà inscrit ? Connectez vous ici</button>
            
            <h1>Inscription</h1>
            
			<form action="index.php" method="post" id="registerForm">
                <label for="registerUsername">Nom d'utilisateur:</label><br />
				<input type="text" id="registerUsername" placeholder="nom de compte" maxlength="25" name="registerUsername" /><br />
				
                <label for="registerPassword">Mot de passe:</label><br />
				<input type="password" id="registerPassword" placeholder="mot de passe" maxlength="105" name="registerPassword" /><br />
				
                <label for="registerPasswordConfirm">Re-tapez le mot de passe:</label><br />
				<input type="password" id="registerPasswordConfirm" placeholder="mot de passe" maxlength="105" name="registerPasswordConfirm" /><br />
				
                <label for="registerAddress">Adresse e-mail:</label><br />
				<input type="text" id="registerAddress" placeholder="adresse mail" maxlength="225" name="registerAddress" /><br />
				
                <label for="registerAddressConfirm">ré-entrez l'adresse e-mail:</label><br />
				<input type="text" id="registerAddressConfirm" placeholder="adresse mail" maxlength="225" name="registerAddressConfirm" /><br />
                
                <label for="registerFirstName">Votre prénom: </label><br />
				<input type="text" id="registerFirstName" placeholder="prénom" maxlength="105" name="registerFirstName" /><br />
				
                <label for="registerLastName">Votre nom de famille:</label><br />
				<input type="text" id="registerLastName" placeholder="nom de famille" maxlength="105" name="registerLastName" /><br /><br />
                
                <input type="submit" name="registerConfirm" value="Créer un nouveau compte" />
            </form>	
        </section>
		
		<footer>
			<p id="copyright"> réalisé par Florquin Deborah, Delatte Mélanie, Feincoeur Marina, Tworowski Dimitri, Bastin Jordan, Libert Ronan (design) et Regibo Hugo (PHP/SQL)</p>
			<img src="logo.png" id="logo"/>
		</footer>
        
		<script>
            $(".switch").click(function()
            {
                $("section#formLogin").slideToggle("normal", function() 
                {
                  $("section#formRegister").slideToggle("normal");  
                });
            });
        </script> 
    </body>
</html>


