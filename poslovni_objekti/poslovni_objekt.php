<?php                                                     
require_once SITE_ROOT . '/podatkovni_objekti/podatkovni_objekt.php';

// Classa koja pohranjuje rezultate tra�ilice      
class SearchResults                                                
{                                                                 
  public $mJedinica; // lista svih jedinica
  public $mSearchedWords; // rije�i sudionice u stringu tra�ilice
  public $mIgnoredWords; // zanemarene rije�i u stringu tra�ilice
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
  // u�itavanje svih podataka nekog podru�ja
  public function GetPodrucjeDetalji($podrucjeId)    
  {                                                      
    $result = $this->mPodatkovniObjekt->GetPodrucjeDetalji($podrucjeId);
    return $result;
  }  
  // u�itava sve cjeline koje pripadaju odre�enom podru�ju
  public function GetCjelineUPodrucju($podrucjeId)
  {            
     $result = $this->mPodatkovniObjekt->GetCjelineUPodrucju($podrucjeId);
     return $result;
  }  

  // u�itava sve podatke odre�ene cjeline
  public function GetCjelinaDetalji($cjelinaId)
  {            
     $result = $this->mPodatkovniObjekt->GetCjelinaDetalji($cjelinaId);
     return $result;
  }   
  // u�itava sve jedinice koje pripadaju odre�enoj cjelini
  public function GetJedinicaUCjelini($cjelinaId, $pageNo, &$rTotalPages)
  {            
     // provjeri da li smo podatkovnom sloju poslali ispravan broj stranice
     if (empty($pageNo)) $pageNo=1;
     // pozovi metodu podatkovnog sloja koja �e nam vratiti listu jedinica
     $result = $this->mPodatkovniObjekt->GetJedinicaUCjelini($cjelinaId, $pageNo,
       $rTotalPages);
     // izbaci rezultat
     return $result;
  } 

  // U�itava jedinice koje promoviramo za odre�eno podru�je
  public function GetJediniceNaPromidzbiNaRaziniPodrucja($podrucjeId, $pageNo,
     &$rTotalPages)
  {            
     // provjeri valjanost broja stranice kojeg �aljemo podatkovnom sloju
     if (empty($pageNo)) $pageNo=1;
     // poziv podatkovnog sloja i metode koja �e nam izbaciti listu jedinica
     $result = $this->mPodatkovniObjekt->GetJediniceNaPromidzbiNaRaziniPodrucja
       ($podrucjeId, $pageNo, $rTotalPages);
     // izbaci rezultat
     return $result;
  }
 // u�itaj jedinice koje �e se pojaviti na po�etnoj stranici
  public function GetPromidzbaJedinicaNaHomePage($pageNo, &$rTotalPages)
  {            
     // provjeri valjanost broja stranice kojeg smo poslali podatkovnom sloju
    if (empty($pageNo)) $pageNo=1;                       
    // poziv podatkovnog sloja i metode koja �e izbaciti listu jedinica
    $result = $this->mPodatkovniObjekt->GetPromidzbaJedinicaNaHomePage($pageNo,
      $rTotalPages);                                     
    // izbaci rezultat                                    
    return $result;                                      
  }
  // u�itaj sve podatke zadane jedinice                     
  public function GetJedinicaDetalji($jedinicaId)           
  {                                                       
     $result = $this->mPodatkovniObjekt->GetJedinicaDetalji($jedinicaId);
     return $result;                                      
  } 
  // pretra�i bazu                                           
  public function Search($searchString, $allWords, $pageNo, &$rTotalPages)
  {                                                               
    // kreiraj instancu objekta SearchResults                        
    $search_results = new SearchResults();                        
    // mogu�i znak koji u stringu tra�ilice odvaja rije� od rije�i                                   
    $delimiters = ",.; ";                                         
    /* na prvi poziv funkcije `strtok` isporu�ujete cijeli string tra�ilice
    i mogu�e znakove za odvajanje. Dobijete nazad prvu rije� stringa */
    $word = strtok($searchString, $delimiters);                   
    $accepted_words = array();                                    
    $ignored_words = array();                                     
    // petlja za u�itavanje svih rije�i, rije� po rije�
    while ($word)                                                 
    {                                                             
       // kratke rije�i se dodijeljuju jednom arrayu, a ostale rije�i drugom arrayu        
       if (strlen($word) < FT_MIN_WORD_LEN)
         $ignored_words[] = $word;
       else
         $accepted_words[] = $word;
       // uzimanje sljede�e rije�i u stringu tra�ilice
       $word = strtok($delimiters);
    }     
    // ako postoji ijedna rije�...
    if (count($accepted_words))
    {     
       // zovemo metodu u podatkovnom sloju, koja �e nam vratiti rezultat
       $search_results->mJedinica = $this->mPodatkovniObjekt->Search
       ($accepted_words, $allWords, $pageNo, $rTotalPages);
    }     
    // pohrani liste prihva�enih i zanemarenih rije�i, ako postoje
    if ($accepted_words != null)
       $search_results->mSearchedWords = implode(", ", $accepted_words);
    if ($ignored_words != null) 
       $search_results->mIgnoredWords = implode(", ", $ignored_words);
    // izbaci rezultat
    return $search_results;
  }                 

  // izbaci sva podru�ja sa svim njihovim podacima
  public function GetDepartmentsWithDescriptions()              
  {                                                             
     $result = $this->mPodatkovniObjekt->GetDepartmentsWithDescriptions();
     return $result;                                            
  }                                                             
  // a�uriraj (update) podatke odre�enog podru�ja                                 
  public function UpdateDepartment($podrucjeId, $podrucjeIme, 
                                                         $podrucjeOpis)
  {                                                             
     $this->mPodatkovniObjekt->UpdateDepartment($podrucjeId, $podrucjeIme, 
                                                         $podrucjeOpis);
  }                                                             
  // obri�i odre�eno podru�je
  public function DeleteDepartment($podrucjeId)               
  {                                                             
     return $this->mPodatkovniObjekt->DeleteDepartment($podrucjeId); 
  }                                                             
  // dodaj podru�je u tablicu `podrucje`
  public function AddDepartment($podrucjeIme, $podrucjeOpis)
  {                                                             
     $this->mPodatkovniObjekt->AddDepartment($podrucjeIme, $podrucjeOpis);
  }


  // uzmi sve cjeline nekog podru�ja
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

  // obri�i neku cjelinu
  public function DeleteCategory($categoryId)
  {
    return $this->mPodatkovniObjekt->DeleteCategory($categoryId);
  }

  // a�uriraj (update) neku cjelinu
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

  // a�uriraj (update) podatke neke jedinice

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
  // obri�i neku jedinicu iz baze
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
  // u�itaj sve cjeline
  public function GetCategories()                                        
  {                                                                      
     return $this->mPodatkovniObjekt->GetCategories();                          
  }                                                                                      
  // u�itaj sve cjeline kojima pripada neka jedinica
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