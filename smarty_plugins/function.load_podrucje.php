<?php           
function smarty_function_load_podrucje($params, $smarty)
{               
  $podrucje = new Podrucje();
  $podrucje->init();
  $smarty->assign($params['assign'], $podrucje);
}               
class Podrucje
{               
  public $mPodrucje;                         
  private $mPoslovniObjekt;
  public $mOdabranoPodrucje;

  function __construct()                          
  {                                               
    $this->mPoslovniObjekt = new PoslovniObjekt();  

    if (isset($_GET['PodrucjeID']))             
       $this->mOdabranoPodrucje = (int)$_GET['PodrucjeID'];
    else                                          
       $this->mOdabranoPodrucje = -1;       
   }                                               
  function init()                                 
  {                                               
    $this->mPodrucje = $this->mPoslovniObjekt->GetPodrucje();
    for ($i = 0; $i < count($this->mPodrucje); $i++)
       $this->mPodrucje[$i]['onclick'] = "index.php?PodrucjeID=" . 
                                $this->mPodrucje[$i]['podrucje_id'];
  }                                               
}
?>