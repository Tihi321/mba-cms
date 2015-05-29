<?php        
function smarty_function_load_cjelina($params, $smarty)
{            
  $cjelina = new Cjelina();
  $cjelina->init();
  $smarty->assign($params['assign'], $cjelina);
}            
class Cjelina
{            
  /* javne varijable za predloške (template) smarty */
  public $mCjelinaOdabrana = 0;
  public $mPodrucjeOdabrano = 0;
  public $mCjelina;                            
  /* privatni èlanovi */                           
  private $mPoslovniObjekt;                            
  /* constructor */                               
  function __construct()                          
  {                                               
    $this->mPoslovniObjekt = new PoslovniObjekt();          
    if (isset($_GET['PodrucjeID']))             
       $this->mPodrucjeOdabrano = (int)$_GET['PodrucjeID'];
    if (isset($_GET['CjelinaID']))               
       $this->mCjelinaOdabrana = (int)$_GET['CjelinaID'];
  }                                               
  /* init */                                      
  function init()                                 
  {                                               
    $this->mCjelina =                          
    $this->mPoslovniObjekt->GetCjelineUPodrucju($this->mPodrucjeOdabrano);
//izgradnja linkova za stranice `cjelina`          
    for ($i = 0; $i < count($this->mCjelina); $i++)
       $this->mCjelina[$i]['ovo_je_link'] =        
           "index.php?PodrucjeID=" .            
           $this->mPodrucjeOdabrano . "&CjelinaID=" . 
           $this->mCjelina[$i]['cjelina_id']; 
  }                                               
} //kraj classe                                     
?>     