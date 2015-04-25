<?

header('Content-Type: text/html; charset=utf-8');
/*!*/ error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);
date_default_timezone_set("Europe/Moscow");

setlocale(LC_ALL, "en_US.UTF8");
mysql_query("SET NAMES 'utf8'"); 
mysql_query("SET CHARACTER SET 'utf8'");
mysql_query("SET SESSION collation_connection = 'utf8_general_ci'");

function __autoload($className){
	require_once(ROOT."/classes/$className.php");
}

#url
define("MAX_URL_LENGTH", 128);
define('ROOT', $_SERVER['DOCUMENT_ROOT']);

#database
define("DB_ADDRESS", "46.101.170.107");
define("DB_USER", "admin");
define("DB_PASSWORD", "ternary6");
define("DB_NAME", "moodtapes");
define("DB_SALT", "MOODtaPESsALT");


?>