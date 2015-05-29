<?php
ob_start();
session_start();
require_once 'konfiguracija.inc.php';
require_once 'uspostavljanje_smarty.php';
require_once 'bazapodataka.php';

//Instanciranje globalnog objekta BazaPodataka
$gBazaPodataka = new BazaPodataka(MYSQL_CONNECTION_STRING);
?>