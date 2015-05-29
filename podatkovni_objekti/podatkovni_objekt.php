<?php  
class PodatkovniObjekt 
{      
  function __construct()
  {    
    $this->bPodataka = $GLOBALS['gBazaPodataka'];
  }    
  public function GetPodrucje()
  {    
    $query_string = "SELECT podrucje_id, ime FROM podrucje order by podrucje_id asc";
    $result = $this->bPodataka->BpGetAll($query_string);
    return $result;
  }
  public function GetPodrucjeDetalji($podrucjeId)
  {                      
    $query_string = "SELECT ime, opis
                     FROM podrucje
                     WHERE podrucje_id = $podrucjeId";
    $result = $this->bPodataka->BpGetRow($query_string);
    return $result;     
  } 
  public function GetCjelineUPodrucju($podrucjeId)
  {                                                      
    $query_string = "SELECT cjelina_id, ime            
                     FROM cjelina 
                     WHERE podrucje_id = $podrucjeId";
    $result = $this->bPodataka->BpGetAll($query_string);                         
    return $result;                                      
  } 
  public function GetCjelinaDetalji($cjelinaId)        
  {                                                      
    $query_string =                                      
              "SELECT ime AS cjelina_ime, opis AS cjelina_opis
               FROM cjelina                                     
               WHERE cjelina_id = $cjelinaId";                 
    $result = $this->bPodataka->BpGetRow($query_string); 
    return $result;                                      
  } 

  // izbaci broj redaka nakon upita SELECT                       
  private function CountQueryRecords($queryString)                                  
  {                                                                                 
     // testiraj da li je $queryString valjan upit SELECT                                
     if (strtoupper(substr($queryString, 0, 6)) != 'SELECT')                        
       trigger_error("Not a SELECT statement");                                     
     $from_position = stripos($queryString, "FROM ");                               
     if ($from_position == false)                                                   
       trigger_error("Bad SELECT statement");     

                                  
     // da li je prethodni poziv funkcije CountQueryRecords imao isti string SELECT
     // direktno se kao parametar vraæa cache-irani odgovor
     if (isset($_SESSION['last_count_query']))                                      
       if ($_SESSION['last_count_query'] == $queryString)                           
         return $_SESSION['last_count'];                                            
     // raèunanje rednih brojeva redaka koje je izbacio upit SELECT
     $count_query = "SELECT COUNT(*) ".substr($queryString, $from_position);        
     $items_count = $this->bPodataka->BpGetOne($count_query);                       
     // pohrani u sesiju upit i broj retka kojeg je taj upit izbacio                          
     $_SESSION['last_count_query'] = $queryString;                                  
     $_SESSION['last_count'] = $items_count;                                        
     // izbaci izraèunate brojeve redaka
     return $items_count;
  }            
  // promjeni SQL upit tako da izbaci samo odreðenu stranicu s jedinicama
  private function CreateSubpageQuery($queryString, $pageNo, &$rTotalPages)
  {                                                      
    // izbaci broj redaka koje je vratio upit SELECT
    $items_count = $this->CountQueryRecords($queryString);
    // ako jedinica nema dovoljno, prijelom teksta se neæe dogoditi
    if ($items_count <= JEDINICA_PO_STRANICI)               
    {                                                    
      $pageNo = 1;                                       
      $rTotalPages = 1;                                  
    }                                                    
    // u suprotnom raèunamo broj stranica i kreiramo novi upit SELECT
    else                                                 
    {                                                    
      $rTotalPages = ceil($items_count / JEDINICA_PO_STRANICI);
      $start_page = ($pageNo - 1) * JEDINICA_PO_STRANICI;   
      $queryString .= " LIMIT " . $start_page . "," . JEDINICA_PO_STRANICI;
    }                                                    
    return $queryString;                                 
  }

  // uèitava jedinice koje pripadaju odreðenoj cjelini
  public function GetJedinicaUCjelini($cjelinaId, $pageNo, &$rTotalPages)
  {           
    $query_string = 
      "SELECT jedinica.jedinica_id, jedinica.ime,
         CONCAT(LEFT(opis," . BROJ_SLOVA_KRATKOG_OPISA . "), '...')
            AS opis,
         jedinica.slika_1,
         jedinica.promidzba_na_razini_podrucja, jedinica.promidzba_na_razini_homepage
       FROM jedinica INNER JOIN cjelina_jedinica
       ON jedinica.jedinica_id = cjelina_jedinica.jedinica_id
       WHERE cjelina_jedinica.cjelina_id = $cjelinaId";
    $page_query = $this->CreateSubpageQuery($query_string, $pageNo, $rTotalPages);
    return $this->bPodataka->BpGetAll($page_query);
  } 

  // uèitava jedinice koje su na promidžbi za odreðeno podruèje
  public function GetJediniceNaPromidzbiNaRaziniPodrucja($podrucjeId, $pageNo,
    &$rTotalPages)                                       
  {                                                      
    $query_string =                                      
        "SELECT DISTINCT jedinica.jedinica_id, jedinica.ime,
            CONCAT(LEFT(jedinica.opis," . BROJ_SLOVA_KRATKOG_OPISA . "),
             '...') AS opis,                      
            jedinica.slika_1          
         FROM jedinica                                    
         INNER JOIN cjelina_jedinica                     
            ON jedinica.jedinica_id = cjelina_jedinica.jedinica_id
         INNER JOIN cjelina                             
            ON cjelina_jedinica.cjelina_id = cjelina.cjelina_id
         WHERE jedinica.promidzba_na_razini_podrucja = 1       
            AND cjelina.podrucje_id=$podrucjeId";   
    $page_query = $this->CreateSubpageQuery($query_string, $pageNo, $rTotalPages);
    return $this->bPodataka->BpGetAll($page_query);      
  }   

  // uèitava jedinice koje se promoviraju na poèetnoj stranici koju možemo 
  // nazvati i Home Page. Napomena: cjelokupan sadržaj se izmjenjuje 
  // uvijek na jednoj stranici, index.php
  public function GetPromidzbaJedinicaNaHomePage($pageNo, &$rTotalPages)
  {             
    $query_string = 
      "SELECT   
         jedinica.jedinica_id, jedinica.ime,
            CONCAT(LEFT(opis," . BROJ_SLOVA_KRATKOG_OPISA . "), '...')
            AS opis,
         jedinica.slika_1
       FROM jedinica
       WHERE jedinica.promidzba_na_razini_homepage = 1";
    $page_query = $this->CreateSubpageQuery($query_string, $pageNo, $rTotalPages);
    return $this->bPodataka->BpGetAll($page_query);
  } 
  // uèitava jednu jedinicu i sve njene podatke
  public function GetJedinicaDetalji($jedinicaId)
  {             
    $query_string = 
      "SELECT jedinica_id, ime, opis,
               slika_1, slika_2
       FROM jedinica
       WHERE jedinica_id = $jedinicaId";
    return $this->bPodataka->BpGetRow($query_string);
  }        
  // Tražilica tablice `jedinica`                                                            
  public function Search($words, $allWords, $pageNo, &$rTotalPages)                    
  {                                                                       
     // ako je ukljuèena opcija $allWords (`Sve rijeèi zastupljene`)
     // tad dodajemo "+" ispred svake rijeèi u arrayu $words
     if (strcmp($allWords, "on") == 0)                                    
       for ($i = 0; $i < count($words); $i++)                             
         $words[$i] = "+" . $words[$i];                                   
     // od arraya $words kreiraj jedan `search string`
     $temp_string = $words[0];                                            
     for ($i = 1; $i < count($words); $i++)                               
       $temp_string = $temp_string . " $words[$i]";                       
     // izgradi upit za `search`                                                
     if (strcmp($allWords, "on") == 0)                                    
       // izgradi upit za traženje `sve rijeèi zastupljene` (all-words)                                    
       $query_string = "SELECT jedinica_id, ime, CONCAT(LEFT(opis,"
                          . BROJ_SLOVA_KRATKOG_OPISA .            
                         "),'...') AS opis, slika_1    
                         FROM jedinica                                     
                         WHERE MATCH (ime,opis)                   
                         AGAINST (\"$temp_string\" IN BOOLEAN MODE)       
                         ORDER BY MATCH (ime,opis)                
                         AGAINST (\"$temp_string\" IN BOOLEAN MODE)";     
     else                                                                 
       // izgradi upit za traženje `bilo koja rijeè zastupljena` (any-words)                                    
       $query_string = "SELECT jedinica_id, ime, CONCAT(LEFT(opis,"
                          . BROJ_SLOVA_KRATKOG_OPISA .            
                         "),'...') AS opis, slika_1    
                         FROM jedinica                                     
                         WHERE MATCH (ime,opis)                   
                            AGAINST (\"$temp_string\")";                  
     // pozovi CreateSubpageQuery za aktiviranje prijeloma teksta
     $page_query = $this->CreateSubpageQuery($query_string, $pageNo,      
                                                  $rTotalPages);          
     // izvrši upit i izbaci rezultat
     return $this->bPodataka->BpGetAll($page_query);                      
  }


  // uèitaj sve retke iz tablice `podrucje`, sa svim pripadajuæim poljima                  
  public function GetDepartmentsWithDescriptions()                      
  {                                                                     
    $query_string = "SELECT podrucje_id, ime, opis FROM podrucje order by podrucje_id asc";
    $result = $this->bPodataka->BpGetAll($query_string);                
    return $result;                                                     
  }                  
  public function UpdateDepartment($podrucjeId, $podrucjeIme,      
                                        $podrucjeOpis)    
  {            
     $query_string =
       "UPDATE podrucje
        SET ime = '" . $this->bPodataka->DbEscapeSimple($podrucjeIme) .
        "', opis = '" .
        $this->bPodataka->DbEscapeSimple($podrucjeOpis) .
        "' WHERE podrucje_id = $podrucjeId";
     $result = $this->bPodataka->BpQuery($query_string);
  }                 
  public function DeleteDepartment($podrucjeId)
  {           
    $query_string = 
      "SELECT COUNT(*) 
       FROM cjelina WHERE podrucje_id = $podrucjeId";
    $counter = $this->bPodataka->BpGetOne($query_string);
    if ($counter == 0)
    {         
      $query_string = 
        "DELETE FROM podrucje WHERE podrucje_id = $podrucjeId";
      $result = $this->bPodataka->BpQuery($query_string);
      return 1;
    }         
    return -1;
  }           
  // dodaj podruèje u tablicu `podrucje`
  public function AddDepartment($podrucjeIme, $podrucjeOpis)
  {           
    $query_string = 
      "INSERT INTO podrucje (ime, opis)
       VALUES ('" . $this->bPodataka->DbEscapeSimple($podrucjeIme) . 
       "', '" . $this->bPodataka->DbEscapeSimple($podrucjeOpis) 
       . "')";
    $result = $this->bPodataka->BpQuery($query_string);
  }  


  public function GetCategoriesInDepartmentWithDescriptions($departmentId)
  {
    $query_string = "SELECT cjelina_id, ime, opis
                     FROM cjelina
                     WHERE podrucje_id = $departmentId";    
 
    $result=$this->bPodataka->BpGetAll($query_string);
    return $result; 
  }
 
  public function AddCategory($departmentId, $categoryName, $categoryDescription)
  {
    $query_string = 
      "INSERT INTO cjelina (podrucje_id,ime, opis)
       VALUES ($departmentId,'" . 
       $this->bPodataka->DbEscapeSimple($categoryName) . "', '" . 
       $this->bPodataka->DbEscapeSimple($categoryDescription)."')";
    $result = $this->bPodataka->BpQuery($query_string);
  }

  public function DeleteCategory($categoryId)
  {
    $query_string = 
      "SELECT COUNT(*)
       FROM jedinica INNER JOIN cjelina_jedinica 
       ON jedinica.jedinica_id = cjelina_jedinica.jedinica_id 
       WHERE cjelina_jedinica.cjelina_id = $categoryId";
    $counter = $this->bPodataka->BpGetOne($query_string);
    if ($counter == 0)
    {    
      $query_string = "DELETE FROM cjelina WHERE cjelina_id = $categoryId";
      $result = $this->bPodataka->BpQuery($query_string);
      return 1;
    }
    return -1;
  }

  public function UpdateCategory($categoryId, $categoryName, $categoryDescription)
  {
    $query_string = 
      "UPDATE cjelina SET ime = '" . 
       $this->bPodataka->DbEscapeSimple($categoryName) . 
       "', opis = '" . 
       $this->bPodataka->DbEscapeSimple($categoryDescription) . 
       "' WHERE cjelina_id = $categoryId";
    $result=$this->bPodataka->BpQuery($query_string);
  }

  public function GetProductsInCategoryAdmin($categoryId)
  {  
    $query_string = 
      "SELECT jedinica.jedinica_id,jedinica.ime, jedinica.opis,
              slika_1, slika_2, 
              promidzba_na_razini_podrucja, promidzba_na_razini_homepage
       FROM jedinica INNER JOIN cjelina_jedinica 
       ON jedinica.jedinica_id = cjelina_jedinica.jedinica_id 
       WHERE cjelina_jedinica.cjelina_id = $categoryId";
    $result=$this->bPodataka->BpGetAll($query_string);
    return $result; 
  }
 
  public function CreateProductToCategory($categoryId, $productName, $productDescription, $productImage1,$productImage2, $onDepartmentPromotion,$onCatalogPromotion)
  {
    $query_string = 
      "INSERT INTO jedinica (ime, opis, slika_1, slika_2, promidzba_na_razini_podrucja, promidzba_na_razini_homepage)
       VALUES('" . $this->bPodataka->DbEscapeSimple($productName) . "','" . $this->bPodataka->DbEscapeSimple($productDescription) . "', '$productImage1', '$productImage2', $onDepartmentPromotion, $onCatalogPromotion)"; 
    $this->bPodataka->BpQuery($query_string);
    $query_string = "SELECT LAST_INSERT_ID()";  
    $product_id = $this->bPodataka->BpGetOne($query_string);
    $query_string = "INSERT INTO cjelina_jedinica(cjelina_id, jedinica_id)
                     VALUES($categoryId, $product_id)";  
    $this->bPodataka->BpQuery($query_string);
  }

    public function UpdateProduct($productId, $productName,
                                  $productDescription,
                                  $productImage1,$productImage2, $onCatalogPromotion,
                                  $onDepartmentPromotion)
  {
    $query_string = "UPDATE jedinica
                     SET ime = '$productName',
                         opis = '".$this->bPodataka->DbEscapeSimple($productDescription)."',
                         
                         slika_1 = '$productImage1', 
                         slika_2 = '$productImage2', 
                         promidzba_na_razini_homepage = $onCatalogPromotion,
                         promidzba_na_razini_podrucja = $onDepartmentPromotion
                     WHERE jedinica_id = $productId";
    $this->bPodataka->BpQuery($query_string);
  }
  public function DeleteProduct($productId)                              
  {                                                                      
     $query_string = "DELETE FROM cjelina_jedinica WHERE jedinica_id = $productId";
     $this->bPodataka->BpQuery($query_string);                           
     $query_string = "DELETE FROM jedinica WHERE jedinica_id = $productId";
     $this->bPodataka->BpQuery($query_string);                           
  }                                                                                
  public function RemoveProductFromCategory($productId, $categoryId)    
  {                                                                     
    $query_string = "SELECT COUNT(*) FROM cjelina_jedinica              
                       WHERE jedinica_id=$productId";                    
    $counter = $this->bPodataka->BpGetOne($query_string);               
    if ($counter == 1)                                                  
    {                                                                   
      $this->DeleteProduct($productId);                                 
      return 0;                                                         
    }                                                                   
    else                                                                
    {                                                                   
      $query_string =                                                   
        "DELETE FROM cjelina_jedinica                                   
         WHERE cjelina_id = $categoryId AND jedinica_id = $productId";  
      $this->bPodataka->BpQuery($query_string);                         
      return 1;                                                         
    }                                                                   
  }       
  public function GetCategories()                                        
  {                                                                      
     $query_string = "SELECT cjelina_id, ime, opis FROM cjelina";
     $result=$this->bPodataka->BpGetAll($query_string);                  
     return $result;                                                     
  }                                                                                            
  public function GetCategoriesForProduct($productId)
  {                                           
    $query_string =                           
     "SELECT cjelina.cjelina_id, cjelina.podrucje_id, cjelina.ime
      FROM cjelina JOIN cjelina_jedinica     
      ON cjelina.cjelina_id = cjelina_jedinica.cjelina_id
      WHERE cjelina_jedinica.jedinica_id = $productId";
    $result = $this->bPodataka->BpGetAll($query_string);
    return $result;                           
  }                                            
  public function AssignProductToCategory($productId, $categoryId)
  {                                           
    $query_string =                           
      "INSERT INTO cjelina_jedinica (jedinica_id, cjelina_id)
       VALUES ($productId, $categoryId)";     
    $this->bPodataka->BpQuery($query_string);  
  }                                           
                
  public function MoveProductToCategory($productId, $sourceCategoryId, 
                                             $targetCategoryId)
  {                                           
    $query_string = "UPDATE cjelina_jedinica  
                       SET cjelina_id=$targetCategoryId
                       WHERE jedinica_id = $productId AND
                              cjelina_id = $sourceCategoryId";
    $this->bPodataka->BpQuery($query_string); 
  }                                           
  public function SetPicture1($productId, $pictureName)                  
  {                                                                      
     $query_string = "UPDATE jedinica                                     
                        SET slika_1 = '$pictureName'                
                        WHERE jedinica_id = $productId";                  
     $this->bPodataka->BpQuery($query_string);                           
  }                                                                      
  public function SetPicture2($productId, $pictureName)                  
  {                                                                      
     $query_string = "UPDATE jedinica                                     
                        SET slika_2 = '$pictureName'                
                        WHERE jedinica_id = $productId";                  
     $this->bPodataka->BpQuery($query_string);                           
  } 

} //PodatkovniObjekt kraj
?> 