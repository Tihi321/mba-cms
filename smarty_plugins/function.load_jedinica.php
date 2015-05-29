<?php                                             
function smarty_function_load_jedinica($params, $smarty)
{                                                 
  $jedinica = new Jedinica();                       
  $jedinica->init();                               
  // assign template variable                     
  $smarty->assign($params['assign'], $jedinica);   
}                                                 
class Jedinica                                     
{                                                 
  // javne varijable koje æe koristiti Smarty za izradu predloška
  public $mJedinica;                               
  public $mPageLink = "index.php";
  // privatni sudionici 
  private $mPoslovniObjekt;
  private $mJedinicaId;

  function __construct()
  {          
    // kreiranje objekta srednjeg sloja
    $this->mPoslovniObjekt = new PoslovniObjekt();
    // inicijalizacija varijable, ili davanje vrijednosti varijabli
    if (isset($_GET['JedinicaID']))
       $this->mJedinicaId = (int)$_GET['JedinicaID'];
  }          
  // init    
  function init()
  {          
    // dobijanje podataka neke jedinice
    $this->mJedinica = 
       $this->mPoslovniObjekt->GetJedinicaDetalji($this->mJedinicaId);
    if (isset($_SESSION['LinkStranice'])) 
       $this->mPageLink = $_SESSION['LinkStranice'];
  }          
} //kraj classe
?>           
