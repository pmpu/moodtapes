<?
/*!*/ error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set("Europe/Moscow");

setlocale(LC_ALL, "ru_RU.UTF8");

function __autoload($className){
	if(strstr($className, 'Action'))
		require_once("/classes/actions/$className.php");
	else
	    require_once("/classes/$className.php");
}

#url
define("MAX_URL_LENGTH", 128);
define('ROOT', $_SERVER['DOCUMENT_ROOT']);

#database
define("DB_ADDRESS", "localhost");
define("DB_USER", "root");
define("DB_PASSWORD", "");
define("DB_NAME", "george.blog");
define("DB_SALT", "CLOUDYSALT");


?>