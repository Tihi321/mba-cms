<?php   
function smarty_function_load_admin_jedinica_detalji($params, $smarty)
{       
  $admin_jedinica = new AdminJedinica();
  $admin_jedinica->init();
  $smarty->assign($params['assign'], $admin_jedinica);
}       
// classa koja brine o administraciji jedinica
class AdminJedinica
{       
  //javni atributi
  public $mJedinicaIme;
  public $mJedinicaSlika1;
  public $mJedinicaSlika2;
  public $mJedinicaCjelineString;
  public $mUkloniIzCjelina;
  public $mJedinicaId;
  public $mCjelinaId;
  public $mPodrucjeId;
  public $premjestiIzCjelineGumbOnemogucen = false;
  //privatni atributi
  private $mWebSite;
  private $mCiljCjelinaId;
  // class constructor
  function __construct()
  {     
    // business tier class
    $this->mWebSite = new PoslovniObjekt();
    // need to have DepartmentID in the query string
    if (!isset($_GET['PodrucjeID']))
       trigger_error("PodrucjeID not set");
    else
       $this->mPodrucjeId = (int)$_GET['PodrucjeID'];
    // need to have CjelinaID in the query string
    if (!isset($_GET['CjelinaID']))
       trigger_error("CjelinaID not set");
    else
       $this->mCjelinaId = (int)$_GET['CjelinaID'];
    // need to have ProductID in the query string
    if (!isset($_GET['JedinicaID']))
       trigger_error("JedinicaID not set");
    else                                                         
       $this->mJedinicaId = (int)$_GET['JedinicaID'];              
  } 


/*	echo $this->mPodrucjeId;
	echo $mCjelinaId;
	echo $mJedinicaId;
	exit;
*/

                                                             
  // init                                                        
  public function init()                                         
  {                                                              
    // if uploading a product picture ...                        
    if (isset($_POST['Upload']))                                 
    {                                                            
       // check whether we have write permission on the product_images folder
       if (!is_writeable(SITE_ROOT . '/jedinica_slike/'))        
       {                                                         
         echo "Can't write to the product_images folder";        
         exit;                                                   
       }                                                         
       // if the error code is 0, the first file was uploaded ok 
       if ($_FILES['Image1Upload']['error'] == 0)                
       {                                                         
         // use the move_uploaded_file PHP function to move the file 
         // from its temporary location to the product_images folder
         move_uploaded_file($_FILES['Image1Upload']['tmp_name'], 
           SITE_ROOT . '/jedinica_slike/' . $_FILES['Image1Upload']['name']);
         // update the product's information in the database     
         $this->mWebSite->SetPicture1($this->mJedinicaId,         
           $_FILES['Image1Upload']['name']);                     
       }                                                         
       // if the error code is 0, the second file was uploaded ok
       if ($_FILES['Image2Upload']['error'] == 0)                
       {                                                         
         // move the uploaded file to the product_images folder  
         move_uploaded_file($_FILES['Image2Upload']['tmp_name'], 
           SITE_ROOT . '/jedinica_slike/' . $_FILES['Image2Upload']['name']);
         // update the product's information in the database     
         $this->mWebSite->SetPicture2($this->mJedinicaId,         
           $_FILES['Image2Upload']['name']);                     
       }                                                         
    }                                                            
    // if removing the product from a category...                
    if (isset($_POST['RemoveFromCategory']))                     
    {                                                            
       $target_category_id = $_POST['TargetCategoryIdRemove'];   
       $still_exists = $this->mWebSite->RemoveProductFromCategory(
                                 $this->mJedinicaId, $target_category_id);
       if ($still_exists == 0)                                   
       {                                                         
         header(                                                 
           "Location:admin.php?Stranica=Jedinice&PodrucjeID=" . 
           "$this->mPodrucjeId&CjelinaID=$this->mCjelinaId");
         exit;              
       }                    
    }                       
    // if removing the product from catalog...
    if (isset($_POST['RemoveFromCatalog']))
    {                       
       $this->mWebSite->DeleteProduct($this->mJedinicaId);
       header(              
         "Location:admin.php?Stranica=Jedinice&PodrucjeID=" .
         "$this->mPodrucjeId&CjelinaID=$this->mCjelinaId");
       exit;                
    }                       
    // if assigning the product to another category ...
    if (isset($_POST['Assign']))
    {                       
       $target_category_id = $_POST['TargetCategoryIdAssign'];
       $this->mWebSite->AssignProductToCategory($this->mJedinicaId,
         $target_category_id);      
    }                       
    // if moving the product to another category ...
    if (isset($_POST['Move']))
    {                       
       $target_category_id = $_POST['TargetCategoryIdMove'];
       $this->mWebSite->MoveProductToCategory($this->mJedinicaId,
                           $this->mCjelinaId,$target_category_id);
       header(              
         "Location:admin.php?Stranica=JedinicaDetalji".
         "&PodrucjeID=$this->mPodrucjeId&CjelinaID=$target_category_id".
         "&JedinicaID=$this->mJedinicaId");
       exit;                
    } 
                      
    // get product details and show them to user
    $product_details =      
       $this->mWebSite->GetJedinicaDetalji($this->mJedinicaId);
    $this->mJedinicaIme = $product_details['ime'];
    $this->mJedinicaSlika1 = $product_details['slika_1'];
    $this->mJedinicaSlika2 = $product_details['slika_2'];
    $product_categories =   
       $this->mWebSite->GetCategoriesForProduct($this->mJedinicaId);
    if (count($product_categories) == 1) 
       $this->premjestiIzCjelineGumbOnemogucen = true;
    // show the categories the product belongs to
    for ($i = 0; $i < count($product_categories); $i++)
       $temp1[$product_categories[$i]['cjelina_id']] =
         $product_categories[$i]['ime'];
    $this->mUkloniIzCjelina = $temp1;
    $this->mJedinicaCjelineString = implode(",", $temp1);      
    $all_categories = $this->mWebSite->GetCategories();          
    for ($i = 0; $i < count($all_categories); $i++)              
       $temp2[$all_categories[$i]['cjelina_id']] =              
$all_categories[$i]['ime'];                                     
    $this->mAssignOrMoveTo = array_diff($temp2, $temp1);         
  }                                                              
} //end class                                                    
?>                                                               
