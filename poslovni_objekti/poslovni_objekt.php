<?php                                                     
require_once SITE_ROOT . '/podatkovni_objekti/podatkovni_objekt.php';

// Classa koja pohranjuje rezultate tražilice      
class SearchResults                                                
{                                                                 
  public $mJedinica; // lista svih jedinica
  public $mSearchedWords; // rijeèi sudionice u stringu tražilice
  public $mIgnoredWords; // zanemarene rijeèi u stringu tražilice
}   


class PoslovniObjekt                                           
{                                                         
  private $mPodatkovniObjekt;                                   
  function __construct()                                 
  {                                                      
    $this->mPodatkovniObjekt = new PodatkovniObjekt();                 
  }                                                      
  public function GetPodrucje()                       
  {                                                      
    $result = $this->mPodatkovniObjekt->GetPodrucje();       
    return $result;                                      
  } 
  // uèitavanje svih podataka nekog podruèja
  public function GetPodrucjeDetalji($podrucjeId)    
  {                                                      
    $result = $this->mPodatkovniObjekt->GetPodrucjeDetalji($podrucjeId);
    return $result;
  }  
  // uèitava sve cjeline koje pripadaju odreðenom podruèju
  public function GetCjelineUPodrucju($podrucjeId)
  {            
     $result = $this->mPodatkovniObjekt->GetCjelineUPodrucju($podrucjeId);
     return $result;
  }  

  // uèitava sve podatke odreðene cjeline
  public function GetCjelinaDetalji($cjelinaId)
  {            
     $result = $this->mPodatkovniObjekt->GetCjelinaDetalji($cjelinaId);
     return $result;
  }   
  // uèitava sve jedinice koje pripadaju odreðenoj cjelini
  public function GetJedinicaUCjelini($cjelinaId, $pageNo, &$rTotalPages)
  {            
     // provjeri da li smo podatkovnom sloju poslali ispravan broj stranice
     if (empty($pageNo)) $pageNo=1;
     // pozovi metodu podatkovnog sloja koja æe nam vratiti listu jedinica
     $result = $this->mPodatkovniObjekt->GetJedinicaUCjelini($cjelinaId, $pageNo,
       $rTotalPages);
     // izbaci rezultat
     return $result;
  } 

  // Uèitava jedinice koje promoviramo za odreðeno podruèje
  public function GetJediniceNaPromidzbiNaRaziniPodrucja($podrucjeId, $pageNo,
     &$rTotalPages)
  {            
     // provjeri valjanost broja stranice kojeg šaljemo podatkovnom sloju
     if (empty($pageNo)) $pageNo=1;
     // poziv podatkovnog sloja i metode koja æe nam izbaciti listu jedinica
     $result = $this->mPodatkovniObjekt->GetJediniceNaPromidzbiNaRaziniPodrucja
       ($podrucjeId, $pageNo, $rTotalPages);
     // izbaci rezultat
     return $result;
  }
 // uèitaj jedinice koje æe se pojaviti na poèetnoj stranici
  public function GetPromidzbaJedinicaNaHomePage($pageNo, &$rTotalPages)
  {            
     // provjeri valjanost broja stranice kojeg smo poslali podatkovnom sloju
    if (empty($pageNo)) $pageNo=1;                       
    // poziv podatkovnog sloja i metode koja æe izbaciti listu jedinica
    $result = $this->mPodatkovniObjekt->GetPromidzbaJedinicaNaHomePage($pageNo,
      $rTotalPages);                                     
    // izbaci rezultat                                    
    return $result;                                      
  }
  // uèitaj sve podatke zadane jedinice                     
  public function GetJedinicaDetalji($jedinicaId)           
  {                                                       
     $result = $this->mPodatkovniObjekt->GetJedinicaDetalji($jedinicaId);
     return $result;                                      
  } 
  // pretraži bazu                                           
  public function Search($searchString, $allWords, $pageNo, &$rTotalPages)
  {                                                               
    // kreiraj instancu objekta SearchResults                        
    $search_results = new SearchResults();                        
    // moguæi znak koji u stringu tražilice odvaja rijeè od rijeèi                                   
    $delimiters = ",.; ";                                         
    /* na prvi poziv funkcije `strtok` isporuèujete cijeli string tražilice
    i moguæe znakove za odvajanje. Dobijete nazad prvu rijeè stringa */
    $word = strtok($searchString, $delimiters);                   
    $accepted_words = array();                                    
    $ignored_words = array();                                     
    // petlja za uèitavanje svih rijeèi, rijeè po rijeè
    while ($word)                                                 
    {                                                             
       // kratke rijeèi se dodijeljuju jednom arrayu, a ostale rijeèi drugom arrayu        
       if (strlen($word) < FT_MIN_WORD_LEN)
         $ignored_words[] = $word;
       else
         $accepted_words[] = $word;
       // uzimanje sljedeæe rijeèi u stringu tražilice
       $word = strtok($delimiters);
    }     
    // ako postoji ijedna rijeè...
    if (count($accepted_words))
    {     
       // zovemo metodu u podatkovnom sloju, koja æe nam vratiti rezultat
       $search_results->mJedinica = $this->mPodatkovniObjekt->Search
       ($accepted_words, $allWords, $pageNo, $rTotalPages);
    }     
    // pohrani liste prihvaæenih i zanemarenih rijeèi, ako postoje
    if ($accepted_words != null)
       $search_results->mSearchedWords = implode(", ", $accepted_words);
    if ($ignored_words != null) 
       $search_results->mIgnoredWords = implode(", ", $ignored_words);
    // izbaci rezultat
    return $search_results;
  }                 

  // izbaci sva podruèja sa svim njihovim podacima
  public function GetDepartmentsWithDescriptions()              
  {                                                             
     $result = $this->mPodatkovniObjekt->GetDepartmentsWithDescriptions();
     return $result;                                            
  }                                                             
  // ažuriraj (update) podatke odreðenog podruèja                                 
  public function UpdateDepartment($podrucjeId, $podrucjeIme, 
                                                         $podrucjeOpis)
  {                                                             
     $this->mPodatkovniObjekt->UpdateDepartment($podrucjeId, $podrucjeIme, 
                                                         $podrucjeOpis);
  }                                                             
  // obriši odreðeno podruèje
  public function DeleteDepartment($podrucjeId)               
  {                                                             
     return $this->mPodatkovniObjekt->DeleteDepartment($podrucjeId); 
  }                                                             
  // dodaj podruèje u tablicu `podrucje`
  public function AddDepartment($podrucjeIme, $podrucjeOpis)
  {                                                             
     $this->mPodatkovniObjekt->AddDepartment($podrucjeIme, $podrucjeOpis);
  }


  // uzmi sve cjeline nekog podruèja
  public function GetCategoriesInDepartmentWithDescriptions($departmentId)
  {
    $result=$this->mPodatkovniObjekt->GetCategoriesInDepartmentWithDescriptions($departmentId);
    return $result;
  }

  // dodaj novu cjelinu
  public function AddCategory($departmentId, $categoryName, $categoryDescription)
  {
    $this->mPodatkovniObjekt->AddCategory($departmentId, $categoryName, $categoryDescription);
  }

  // obriši neku cjelinu
  public function DeleteCategory($categoryId)
  {
    return $this->mPodatkovniObjekt->DeleteCategory($categoryId);
  }

  // ažuriraj (update) neku cjelinu
  public function UpdateCategory($categoryId, $categoryName, $categoryDescription)
  {
    $this->mPodatkovniObjekt->UpdateCategory($categoryId, $categoryName, $categoryDescription);
  }

  // uzmi sve jedinice neke cjeline
  public function GetProductsInCategoryAdmin($categoryId)
  {
    $result=$this->mPodatkovniObjekt->GetProductsInCategoryAdmin($categoryId);
    return $result;
  }
  
  // ubaci novu jedinicu i automatski je pridodaj nekoj kategoriji
  public function CreateProductToCategory($categoryId, $productName,
                                            $productDescription,                                             $productImage1,$productImage2,$onDepartmentPromotion,
                                            $onCatalogPromotion)
  {
    $this->mPodatkovniObjekt->CreateProductToCategory($categoryId, $productName,
                                            $productDescription,                                             $productImage1,$productImage2,$onDepartmentPromotion,
                                            $onCatalogPromotion);
  }

  // ažuriraj (update) podatke neke jedinice

    public function UpdateProduct($productId, $productName,
                                  $productDescription, 
                                  $productImage1,$productImage2, $onCatalogPromotion,
                                  $onDepartmentPromotion)
  {
  
    $this->mPodatkovniObjekt->UpdateProduct($productId, $productName,
                                  $productDescription, 
                                  $productImage1,$productImage2, $onCatalogPromotion,
                                  $onDepartmentPromotion);
  }
  // obriši neku jedinicu iz baze
  public function DeleteProduct($productId)                              
  {                                                                      
     $this->mPodatkovniObjekt->DeleteProduct($productId);                       
  }                                                                      
  // ukloni neku jedinicu iz neke cjeline kojoj je do tad pripadao                                 
  public function RemoveProductFromCategory($productId, $categoryId)     
  {                                                                      
     return $this->mPodatkovniObjekt->RemoveProductFromCategory($productId,     
                                                                $categoryId);
  }                                                                      
  // uèitaj sve cjeline
  public function GetCategories()                                        
  {                                                                      
     return $this->mPodatkovniObjekt->GetCategories();                          
  }                                                                                      
  // uèitaj sve cjeline kojima pripada neka jedinica
  public function GetCategoriesForProduct($productId)       
  {                                                         
     return $this->mPodatkovniObjekt->GetCategoriesForProduct($productId);
  }                                                         
  // dodijeli jedinicu nekoj cjelini
  public function AssignProductToCategory($productId, $categoryId)
  {                                                         
     $this->mPodatkovniObjekt->AssignProductToCategory($productId, $categoryId);
  }                                                         
  // premjesti jedinicu iz jedne cjeline u drugu
  public function MoveProductToCategory($productId,         
                                              $sourceCategoryId,
                                              $targetCategoryId)
  {                                                         
     return $this->mPodatkovniObjekt->MoveProductToCategory($productId,
                                                           $sourceCategoryId,
                                                           $targetCategoryId);
  }                                                         
  // promjena imena datoteke prve slike u bazi
  public function SetPicture1($productId,$pictureName)      
  {                                                         
     $this->mPodatkovniObjekt->SetPicture1($productId,$pictureName);
  }                                                         
  // promjena imena datoteke druge slike u bazi
  public function SetPicture2($productId,$pictureName)      
  {                                                         
     $this->mPodatkovniObjekt->SetPicture2($productId,$pictureName);
  }                    
}
?>