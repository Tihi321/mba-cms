<?php                                                            
require_once 'include/vrh_aplikacije.php';
require_once SITE_ROOT . '/poslovni_objekti/poslovni_objekt.php';
// Ako administrator nije logiran, preusmjeri ga na stranicu za logiranje login.php
// s dodanom varijablom ZelimOvuStranicu u GET stringu
// da se zna prema kud će se admin usmjeriti kad se logira            
if (!(isset($_SESSION['AdministratorJeLogiran'])) || $_SESSION['AdministratorJeLogiran'] !=true)
{                                                                
  header('Location: login.php?ZelimOvuStranicu=admin.php');
  exit;                                                          
}                                                                
// Ako se administrator odjavi ...                                            
if (isset($_GET['Stranica']) && $_GET['Stranica'] == "Odjava")           
{                                                                
  unset($_SESSION['AdministratorJeLogiran']);                               
  header("Location: index.php");                                 
  exit;                                                          
}                                                                
// Učitaj web stranicu instanciranjem objekta home                                                
$home = new HomePage();
$sadrzajStranice = "blank.tpl";   
// Ako u upitu nema varijable `Stranica`
// (drugim rijecima, ako Stranica nije eksplicitno zadana),
//  podrazumjeva se stranica Podrucja
if(isset($_GET['Stranica']))         
  $admin_stranica = $_GET['Stranica'];   
else                             
  $admin_stranica = "Podrucja";   
// Odabir stranice koja ce se ucitati ...
if ($admin_stranica == "Podrucja") 
  $sadrzajStranice = "admin_podrucja.tpl";
if ($admin_stranica == "Cjeline")
  $sadrzajStranice = "admin_cjeline.tpl";
if ($admin_stranica == "Jedinice")
  $sadrzajStranice = "admin_jedinice.tpl";
if ($admin_stranica == "JedinicaDetalji")                             
 $sadrzajStranice = "admin_jedinica_detalji.tpl"; 
                          
$home->assign("sadrzajStranice", $sadrzajStranice);                      
$home->display('admin.tpl');                             
require_once 'include/dno_aplikacije.php';
?>                