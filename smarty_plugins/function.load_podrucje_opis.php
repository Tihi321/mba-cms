<?php                                             
function smarty_function_load_podrucje_opis($params, $smarty)
{                                                 
  $podrucje_opis = new PodrucjeOpis();                 
  $podrucje_opis->init();                            
  // pridodavanje varijabli smarty predlošku                     
  $smarty->assign($params['assign'], $podrucje_opis);
}                                                 
// classa koja uèitava podatke iz tablice `podrucje`
class PodrucjeOpis                                  
{                                                 
  /* javne varijable za smarty predložak */  
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
    // ako u upitu postoji CjelinaID, pohranit æemo taj podatak za kasnije potrebe
    // da smo sigurni da æe biti integer koristimo (int) ispred varijable $_GET
    if (isset($_GET['CjelinaID']))
       $this->mCjelinaId = (int)$_GET['CjelinaID'];
  }            
  /* init */   
  function init()
  {            
    // ako ste odabrali podruèje, pritiskom tipke miša na isto, uèitat æe se
    // svi podaci tog podruèja
    $details = 
          $this->mPoslovniObjekt->GetPodrucjeDetalji($this->mPodrucjeOpisId);
    $this->mImeLabel = $details['ime'];
    $this->mOpisLabel = $details['opis'];
    // ako ste pritiskom tipke miša odabrali cjelinu, uèitat æe se
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

