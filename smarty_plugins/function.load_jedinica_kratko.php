<?php  
function smarty_function_load_jedinica_kratko($params, $smarty)
{      
  $jedinica_kratko = new JedinicaKratko();
  $jedinica_kratko->init();
  // dodijeljivanje varijabli smartyjevu predlo�ku
  $smarty->assign($params['assign'], $jedinica_kratko);
}      
class JedinicaKratko
{      
  /* javne varijable koje �e pro�itati Smarty za kreiranje predlo�ka */
  public $mJedinica;
  public $mPageNo;
  public $mrTotalPages;
  public $mNextLink;
  public $mPreviousLink;
  public $mSearchResultsTitle;
  public $mSearch = "";
  public $mAllWords = "off";
  /* privatne varijable */
  private $mPoslovniObjekt;
  private $mPodrucjeId;
  private $mCjelinaId;
  /* konstruktor */
  function __construct()
  {    
    // kreiranje objekta poslovnog sloja                         
    $this->mPoslovniObjekt = new PoslovniObjekt();                   
    // uzeti PodrucjeID iz url query stringa i pomo�u (int) osigurati da je to integer
    if (isset($_GET['PodrucjeID']))                      
       $this->mPodrucjeId = (int)$_GET['PodrucjeID'];  
    // uzeti CjelinaID iz url query stringa i pomo�u (int) osigurati da je to integer  
    if (isset($_GET['CjelinaID']))                        
       $this->mCjelinaId = (int)$_GET['CjelinaID'];      
    // uzeti PageNo iz url query stringa i pomo�u (int) osigurati da je to integer      
    if (isset($_GET['PageNo']))                            
       $this->mPageNo = (int)$_GET['PageNo'];              
    else                                                   
       $this->mPageNo = 1;
           // uzeti Search iz url query stringa
    if (isset($_GET['Search'])) 
       $this->mSearchString=$_GET['Search'];
    // uzeti vrijednost AllWords iz url query stringa
    if (isset($_GET['AllWords'])) 
       $this->mAllWords=$_GET['AllWords'];                                       
  }                                                        
  /* init */                                               
  function init()                                          
  {  
        // ako postoji string iz tra�ilice, preko poslovnog sloja do�imo do rezultata
    if (isset($this->mSearchString))                              
    {                                                             
       $search_results = $this->mPoslovniObjekt->Search(               
                                 $this->mSearchString, $this->mAllWords,
                                 $this->mPageNo, $this->mrTotalPages);
       // dobiti listu jedinica od objekta SearchResults  
       $this->mJedinica = & $search_results->mJedinica;           
       // formirati listu naslova jedinica
       if (!empty($search_results->mSearchedWords))               
          $this->mSearchResultsTitle =                            
            "Jedinice koje sadr�e <font color=\"red\">"            
            . ($this->mAllWords == "on" ? "sve navedene rije�i" : 
	    "bilo koju od navedenih rije�i") . "</font>"
            . " <font color=\"red\">"             
            . $search_results->mSearchedWords . "</font><br>";    
       if (!empty($search_results->mIgnoredWords))                
          $this->mSearchResultsTitle .=                           
            "Zanemarene rije�i: <font color=\"red\">"                 
            . $search_results->mIgnoredWords . "</font><br/>";    
       if (empty($search_results->mJedinica))                     
          $this->mSearchResultsTitle .=                           
            "Nema tra�enih rije�i.<br/>";             
       $this->mSearchResultsTitle .= "<br/>";                     
    }                                                      
    // kad kliknemo na link Cjelina, sve jedinice koje pripadaju toj cjelini
    // bit �e u�itane u javnu varijablu mJedinica, preko metode 
    // GetJedinicaUCjelini u poslovnom sloju      
    elseif (isset($this->mCjelinaId))                         
       $this->mJedinica = $this->mPoslovniObjekt->GetJedinicaUCjelini($this
         ->mCjelinaId, $this->mPageNo, $this->mrTotalPages);
    // kad kliknemo na link Podrucje, sve jedinice koje se promoviraju u tom Podrucju
    // bit �e u�itane u javnu varijablu mJedinica, preko poslovnog sloja i
    // metode GetJediniceNaPromidzbiNaRaziniPodrucja      
    elseif (isset($this->mPodrucjeId))                   
       $this->mJedinica =                                  
                       $this->mPoslovniObjekt->GetJediniceNaPromidzbiNaRaziniPodrucja
         ($this->mPodrucjeId, $this->mPageNo, $this->mrTotalPages);
    // kad kliknemo na link za po�etnu stranicu, sve jedinice koje se promoviraju
    // na prvoj stranici
    // bit �e u�itane u javnu varijablu mJedinica, preko metode 
    // GetPromidzbaJedinicaNaHomePage u poslovnom sloju      
    else                                                   
       $this->mJedinica =                                  
         $this->mPoslovniObjekt->GetPromidzbaJedinicaNaHomePage($this->mPageNo, 
                                                          $this->mrTotalPages);
    // ako postoji vi�e stranica, prika�i linkve sljede�a i prethodna
    if ($this->mrTotalPages > 1)                           
    {                                                      
       // u�itaj query string                            
       $query_string = $_SERVER['QUERY_STRING'];           
       // provjerimo da li postoji PageNo u query stringu      
       $pos = stripos($query_string, "PageNo=");           
       // ako PageNo ne postoji u query stringu
       // to zna�i da smo na prvoj stranici                     
       if ($pos == false)                                  
       {                                                   
         $query_string .= "&PageNo=1";                     
         $pos = stripos($query_string, "PageNo=");         
       }                    
       // pro�itajmo teku�i broj stranice iz query stringa
       $temp = substr($query_string, $pos);
       sscanf($temp, "PageNo=%d", $this->mPageNo);
       // kreirajmo link Sljede�a
       if ($this->mPageNo >= $this->mrTotalPages)
         $this->mNextLink = "";
       else                 
       {                    
         $new_query_string = str_replace("PageNo=" . $this->mPageNo, 
                         "PageNo=" . ($this->mPageNo + 1), $query_string);
         $this->mNextLink = "index.php?".$new_query_string;
       }                    
       // kreirajmo link Prethodna
       if ($this->mPageNo == 1)
         $this->mPreviousLink = "";
       else                 
       {                    
         $new_query_string = str_replace("PageNo=" . $this->mPageNo, 
                         "PageNo=" . ($this->mPageNo - 1), $query_string);
         $this->mPreviousLink = "index.php?".$new_query_string;
       }                    
    }                       
    // kreirajmo linkove za stranicu jedinica_detalji
    $url = $_SESSION['LinkStranice'];
    if (count($_GET) > 0)   
       $url = $url . "&JedinicaID=";
    else                    
       $url = $url . "?JedinicaID=";
    for ($i = 0; $i < count($this->mJedinica); $i++)
       $this->mJedinica[$i]['onclick'] = 
                           $url . $this->mJedinica[$i]['jedinica_id'];
  }                         
} //kraj classe
?>           