<?php
define("SITE_ROOT", dirname(dirname(__FILE__)));
define("SMARTY_DIR", SITE_ROOT."/biblioteke/smarty/");
define("TEMPLATE_DIR", SITE_ROOT."/templates/");
define("COMPILE_DIR", SITE_ROOT."/templates_c/");
define("CONFIG_DIR", SITE_ROOT."/configs/");

//Ovaj kod �e otkriti o kojem se operacijskom sustavu radi
//i primjeniti odgovaraju�e znakove u include_path.
//Za to koristi ini_set PHP funkciju
if ((substr(strtoupper(PHP_OS), 0, 3)) == "WIN")
 define("PATH_SEPARATOR1", ";");
else
 define("PATH_SEPARATOR1", ":");
ini_set('include_path', SITE_ROOT . '/biblioteke/PEAR' . PATH_SEPARATOR1 . ini_get('include_path'));
//podaci za logiranje u bazu
define("USE_PERSISTENT_CONNECTIONS", "true");
define("DB_SERVER", "localhost");
define("DB_USERNAME", "DB_USERNAME");
define("DB_PASSWORD", "DB_PASSWORD");
define("DB_DATABASE", "DB_DATABASE");
define("MYSQL_CONNECTION_STRING", "mysql://" . DB_USERNAME . ":" . 
	DB_PASSWORD . "@" . DB_SERVER . "/" . DB_DATABASE);
define("BROJ_SLOVA_KRATKOG_OPISA",1000);
define("JEDINICA_PO_STRANICI",2);
define("FT_MIN_WORD_LEN",4);
//podaci za logiranje administratora
define("ADMIN_KORISNICKOIME", "admin");
define("ADMIN_ZAPORKA", "admin");
?>
