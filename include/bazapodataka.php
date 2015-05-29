<?php     
require_once 'DB.php';
class BazaPodataka
{         
  public $bp;
  function __construct($connectionString)         
  {                                               
    $this->bp = DB::connect($connectionString,    
                                USE_PERSISTENT_CONNECTIONS);
    $this->bp->setFetchMode(DB_FETCHMODE_ASSOC); 
  }     
  public function BpDisconnect()                  
  {                                               
    $this->bp->disconnect();                      
  }    
  public function BpQuery($queryString)           
  {                                               
    $result = $this->bp->query($queryString);     
    return $result;                               
  }  
  public function BpGetAll($queryString)          
  {                                               
    $result = $this->bp->getAll($queryString);    
    return $result;                               
  }    
  public function BpGetRow($queryString)
  {     
    $result = $this->bp->getRow($queryString);
    return $result;
  }     
  public function BpGetOne($queryString)
  {     
    $result = $this->bp->getOne($queryString);
    return $result;
  }  

  // wrapper class for the escapeSimple() method                        
  public function DbEscapeSimple($string)                               
  {                                                                     
    if (get_magic_quotes_gpc())                                         
      return $string;                                                   
    else                                                                
      return $this->bp->escapeSimple($string);                          
  }                  

}                                                 
?>                                                
