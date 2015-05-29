<?php                                                            
require_once 'include/vrh_aplikacije.php';                              
$home = new HomePage();
$admin_login = new Login();                                 
$home->assign_by_ref("admin_login", $admin_login);               
$home->display('login.tpl');                               
require_once 'include/dno_aplikacije.php';
class Login                                                 
{                                                                
  public $mKorisnickoIme;                                             
  public $mLoginPoruka = "";                                    
  public $mZelimOvuStranicu;                                           

  function __construct()                                         
  {                                                              
    // Ako je zaporka ispravna, admin se preusmjerava na ovu stranicu
    if (isset($_GET['ZelimOvuStranicu']))                              
       $this->mZelimOvuStranicu = $_GET['ZelimOvuStranicu'];
    if (isset($_POST['korisnickoime']))                              
       $this->mKorisnickoIme = $_POST['korisnickoime'];
    // Ako je admin vec logiran, preusmjerava se na trazenu stranicu
    if (isset($_SESSION['AdministratorJeLogiran'])                          
         && $_SESSION['AdministratorJeLogiran'] ==  true)                   
    {                                                            
       header('Location: ' . $this->mZelimOvuStranicu);                
       exit;                                                     
    }                                                            
    // Provjera korisnickog imena i zaporke
    if(isset($_POST['Submit']))                                  
    {                                                            
       if($_POST['korisnickoime'] == ADMIN_KORISNICKOIME                   
          && $_POST['password'] == ADMIN_ZAPORKA)               
       {                                                         
         $_SESSION['AdministratorJeLogiran'] = true;                        
         header("Location: " . $this->mZelimOvuStranicu);              
         exit;                                                   
       }                                                         
       else                                                      
         $this->mLoginPoruka = "<br />Login nije uspio. Molim pokušajte ponovo:";
    }                                                            
  }                                                              
}                                                                
?>               