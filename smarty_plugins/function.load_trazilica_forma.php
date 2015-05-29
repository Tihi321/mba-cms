<?php                                                             
function smarty_function_load_trazilica_forma($params, $smarty)        
{                                                                 
  $search_box = new SearchBox();                                  
  $smarty->assign($params['assign'], $search_box);                
}                                                                 
// classa koja upravlja s formom tra�ilice
class SearchBox                                                   
{                                                                 
  /* javne varijable za smaty predlo�ak */                  
  public $mSearchString = "";                                     
  public $mAllWords = "off";                                      
  /* constructor */                                               
  function __construct()                                          
  {                                                               
    $this->mPoslovniObjekt = new PoslovniObjekt();
    if (isset($_GET['Search']))
       $this->mSearchString = $_GET['Search'];
    if (isset($_GET['AllWords']))
       $this->mAllWords = $_GET['AllWords'];
  }     
} //kraj classe
?>      
