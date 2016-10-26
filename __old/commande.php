<?php
    ob_start();
    session_start();
    
	spl_autoload_extensions('.php');
	spl_autoload_register();
	
    if(empty($_SESSION['username']))
    {
       header("location: index.php"); 
    }
    
    $pageContent = array();
    $notificationsLogin = "";
    
    // -- Commandes de sandwich
    $pdo = \classes\singletonPDO::getInstance();
    $requete_sandwichs = $pdo->prepare("SELECT * FROM commandes WHERE user=:username");
    $requete_sandwichs->bindParam(':username', $_SESSION['username']);
    
    if($requete_sandwichs->execute())
    {
        $pageContent['historique'] = "";
        if($requete_sandwichs->rowCount() > 0)
        {   
            $pageContent['historique'] .= "<table><tr><th>Numéro</th><th>Type de sandwich</th><th>Prix</th><th>Etat</th><th>Scan</th></tr>";
            while($fetched = $requete_sandwichs->fetch(\PDO::FETCH_OBJ))
            {
                $pageContent['historique'] .= "<tr>"
                        . "<td>{$fetched->numero}</td>"
                        . "<td>{$fetched->type}</td>"
                        . "<td>{$fetched->prix}</td>"
                        . "<td>{$fetched->etat}</td>"
                        . "<td>"
                                . "<a href='qrcode.php?user={$_SESSION['username']}&amp;numero={$fetched->numero}'>voir le QR</a>"
                        . "</td></tr>";
            }
            $pageContent['historique'] .= "</table>";
        }
        else
        {
            $pageContent['historique'] .= "Aucun sandwich n'a été commandé avec ce compte. Pourquoi ne pas "
                    . "<a href='commande.php?act=commander'>en commander un ?</a>";
        }
    }
    else 
    {
        $notificationsLogin .= "<div id='error'>Erreur lors de la récupération des données concernant les sandwiches commandés</div>";
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="design.css" />
        <title>app_etit :: commande de sandwichs</title>
    </head>
    <body>
		<header></header>
        
        <menu>
            <ul>
                <li>Voir la liste des commandes</li>
                <li>Commander un sandwich</li>
                <li>Gestion du compte</li>
                <li>Paramètres</li>
                <li>Déconnexion</li>
            </ul>
        </menu>
        
        <section>
            <!-- liste des commandes -->
            <div id="commandesListTable">
                
            </div>
        </section>
        
        <section id="commandesOrder">
            <!-- commander un sandwich -->
            <form id="formOrderSandwich">
                <h1>Commander un sandwich</h1>
                
                <label for="orderCampus">Campus à livrer:</label><br />
                <select id="orderCampus" name="orderCampus">
                    <option>HELHa Mons</option>
                    <option>FUCAM</option>
                    <option>HEH</option>
                    <option>Polytech</option>
                </select><br />
                
                <label for="orderType">Type de sandwich: </label><br />
                <select id="orderType" name="orderType">
                    <optgroup label="Sandwichs simples">
                        <option>Jambon</option>
                        <option>Fromage</option>
                        <option>Américain</option>
                    </optgroup>
                    <optgroup label="Sandwichs composés">
                        <option>Dagobert</option>
                        <option>Italien</option>
                        <option>Cru'zoé</option>
                    </optgroup>
                </select><br />
            </form>
        </section>
        
        <section>
            <!-- gestion du compte -->
            
        </section>
        
        <section>
            <!-- paramètres -->
            
        </section>
    </body>
</html>

<?php
ob_end_flush();
