<?php
namespace classes;

class DataHandler 
{
	public static function obtainGET($key)
	{
		$getSafe = filter_input_array(INPUT_GET);
		if($getSafe != null && array_key_exists($key, $getSafe))
		{
			return $getSafe[$key];
		}
		else
		{
			return null;
		}
	}
	
	public static function obtainSERVER($key)
	{
		$getSafe = filter_input_array(INPUT_SERVER);
		if($getSafe != null && array_key_exists($key, $getSafe))
		{
			return $getSafe[$key];
		}
		else
		{
			return null;
		}
	}
	
	public static function obtainPOST($key)
	{
		$getSafe = filter_input_array(INPUT_POST);
		if($getSafe != null && array_key_exists($key, $getSafe))
		{
			return $getSafe[$key];
		}
		else
		{
			return null;
		}
	}
	
	public static function obtainENV($key)
	{
		$getSafe = filter_input_array(INPUT_ENV);
		if($getSafe != null && array_key_exists($key, $getSafe))
		{
			return $getSafe[$key];
		}
		else
		{
			return null;
		}
	}
	
	public static function obtainCOOKIE($key)
	{
		$getSafe = filter_input_array(INPUT_COOKIE);
		if($getSafe != null && array_key_exists($key, $getSafe))
		{
			return $getSafe[$key];
		}
		else
		{
			return null;
		}
	}
	
}
