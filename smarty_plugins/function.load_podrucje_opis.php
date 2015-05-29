<?php                                             
function smarty_function_load_podrucje_opis($params, $smarty)
{                                                 
  $podrucje_opis = new PodrucjeOpis();                 
  $podrucje_opis->init();                            
  // pridodavanje varijabli smarty predlo�ku                     
  $smarty->assign($params['assign'], $podrucje_opis);
}                                                 
// classa koja u�itava podatke iz tablice `podrucje`
class PodrucjeOpis                                  
{                                                 
  /* javne varijable za smarty predlo�ak */  
  public $mOpisLabel;                      
  public $mImeLabel;                           

  /* privatni sudionici */
  private $mPoslovniObjekt;
  private $mPodrucjeOpisId;
  private $mCjelinaId;
  /* constructor */
  function __construct()
  {            
    // kreiranje instance objekta iz poslovnog sloja
    $this->mPoslovniObjekt = new PoslovniObjekt();
    // u upitu mora postojati PodrucjeID
    if (isset($_GET['PodrucjeID']))
       $this->mPodrucjeOpisId = (int)$_GET['PodrucjeID'];
    // ako u upitu postoji CjelinaID, pohranit �emo taj podatak za kasnije potrebe
    // da smo sigurni da �e biti integer koristimo (int) ispred varijable $_GET
    if (isset($_GET['CjelinaID']))
       $this->mCjelinaId = (int)$_GET['CjelinaID'];
  }            
  /* init */   
  function init()
  {            
    // ako ste odabrali podru�je, pritiskom tipke mi�a na isto, u�itat �e se
    // svi podaci tog podru�ja
    $details = 
          $this->mPoslovniObjekt->GetPodrucjeDetalji($this->mPodrucjeOpisId);
    $this->mImeLabel = $details['ime'];
    $this->mOpisLabel = $details['opis'];
    // ako ste pritiskom tipke mi�a odabrali cjelinu, u�itat �e se
    // svi podaci te cjeline
    if (isset($this->mCjelinaId))
    {          
       $details = 
              $this->mPoslovniObjekt->GetCjelinaDetalji($this->mCjelinaId);
       $this->mImeLabel = 
              $this->mImeLabel . " : " . $details['cjelina_ime'];
       $this->mOpisLabel = $details['cjelina_opis'];
    }          
  }
}             
?>             

