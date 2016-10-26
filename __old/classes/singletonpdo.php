<?php
namespace classes;

/**
 * Classe servant de singleton de la DAO PDO, permettant de n'avoir qu'une seule instance appelée à tout moment
 * @author Hugo
 */
class singletonPDO 
{
	private static $_instance = null;
	
	/**
	 * retourne une instance unique de PDO ayant une connexion à la base de données
	 * @return PDO l'instance PDO globale
	 */
	public static function getInstance()
	{
		if (self::$_instance != null) 
		{
			return self::$_instance;
		}
		else
		{
			self::$_instance = new \PDO("mysql:host=localhost;dbname=appetit", "appetit", "appetit_helha_pwd");
		}
	}
}
