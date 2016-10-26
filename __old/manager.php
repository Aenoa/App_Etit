<?php
    ob_start();
    session_start();
    
	spl_autoload_extensions('.php');
	spl_autoload_register();
	
    
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="design.css" />
        <title>app_etit :: gestionnaire de sandwichs</title>
    </head>
    <body>
		<header></header>
		
    </body>
</html>

<?php
ob_end_flush();
