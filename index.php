<?php
require_once 'include/vrh_aplikacije.php';
/* Svaki link osim stranice detalja jedinice, ce biti pohranjen
u sesiju kako bi se na taj posljednji pohranjeni link uvijek mogli vratiti  */

if (!isset($_GET['JedinicaID']))
  $_SESSION['LinkStranice'] = "http://" . $_SERVER['SERVER_NAME'] .
  ":" . $_SERVER['SERVER_PORT'] . $_SERVER['REQUEST_URI'];


require_once SITE_ROOT . '/poslovni_objekti/poslovni_objekt.php';
$home = new HomePage();

$stoCeBitiNaHomePage = "home_page.tpl";
$cjelinaDioStranice = "blank.tpl";
if (isset($_GET['PodrucjeID']))
{
  $stoCeBitiNaHomePage ="podrucje_opis.tpl";
  $cjelinaDioStranice = "cjelina.tpl";
}
if (isset($_GET['Search']))                 
  $stoCeBitiNaHomePage = "trazilica_rezultat.tpl";
if (isset($_GET['JedinicaID']))                    
  $stoCeBitiNaHomePage = "jedinica.tpl";


$home->assign("stoCeBitiNaHomePage", $stoCeBitiNaHomePage);
$home->assign("cjelinaDioStranice", $cjelinaDioStranice);


$home->display('index.tpl');
require_once 'include/dno_aplikacije.php';
?>