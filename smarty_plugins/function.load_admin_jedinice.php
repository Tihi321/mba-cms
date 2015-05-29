<?php
/* smarty plugin function that gets called when the
load_admin_products function plugin is loaded from a template */
function smarty_function_load_admin_jedinice($params, $smarty)
{
  $admin_products = new AdminProducts();
  $admin_products->init();
  // assign template variable
  $smarty->assign($params['assign'], $admin_products);
}
//class that deals with products administration from a specific category
class AdminProducts
{
  /* public variables available in smarty template */
  public $mProducts;
  public $mProductsCount;
  public $mEditItem;
  public $mErrorMessage = "";
  public $mDepartmentId;
  public $mCategoryId;
  public $mProductId;
  public $mCategoryName;
  /* private attributes */
  private $mCatalog;
  private $mAction = "";
  private $mActionedProdId;  
  // class constructor
  function __construct()
  {
    $this->mCatalog = new PoslovniObjekt();
    if (isset($_GET['PodrucjeID']))
      $this->mDepartmentId = (int)$_GET['PodrucjeID'];
    else
      trigger_error("DepartmentID not set");
    if (isset($_GET['CjelinaID']))
      $this->mCategoryId = (int)$_GET['CjelinaID'];
    else
      trigger_error("CategoryID not set");
    $category_details = $this->mCatalog->GetCjelinaDetalji($this->mCategoryId);
    $this->mCategoryName = $category_details['cjelina_ime'];
    foreach ($_POST as $key => $value) 
    //if a submit button was clicked..    
    if (substr($key,0,6) == "submit") 
    {       
      /* get the position of the last '_' underscore from submit button name 
         e.g strtpos("submit_edit_dep_1","_") is 16
      */
      $last_underscore = strrpos($key,"_");
      //get the scope of submit button (e.g  'edit_dep' from 'submit_edit_dep_1')
      $this->mAction = substr($key,strlen("submit_"),$last_underscore-strlen("submit_"));        
      /* get the department id targeted by submit button
         (the number at the end of submit button name )
         e.g '1' from 'submit_edit_dep_1'
      */ 
      $this->mActionedProdId = (int)substr($key,$last_underscore+1);       
      break; 
    }
  }
  //init
  function init()
  {
    //if ading a new product
    if ($this->mAction == "add")
    {
      $product_name = $_POST['prod_name'];
      $product_description = $_POST['prod_description'];
 //     $product_price = $_POST['prod_price'];      
      $product_on_department_promotion = (isset($_POST['on_department_promotion']) && ($_POST['on_department_promotion'] == "on")) ?1:0;
         
      $product_on_catalog_promotion = (isset($_POST['on_catalog_promotion']) && ($_POST['on_catalog_promotion'] == "on")) ?1:0;
      if ($product_name == null)
        $this->mErrorMessage = 'Jedinica nema imena!';
      if ($product_description == null)
        $this->mErrorMessage = 'Jedinica nema opis!';
 //     if ($product_price == null || !is_numeric($product_price))
 //       $this->mErrorMessage = 'Product price must be a number!';
      if ($this->mErrorMessage == null)
       $this->mCatalog->CreateProductToCategory($this->mCategoryId, $product_name,
          $product_description, "generic_image_1.jpg",
          "generic_image_2.jpg", $product_on_department_promotion,
          $product_on_catalog_promotion);
    }
    //if editing a product
    if ($this->mAction == "edit")
    {
      $this->mEditItem = $this->mActionedProdId;
    }
    //if we want to see a product details
    if ($this->mAction == "select")
    {
      header(
        "Location:admin.php?Stranica=JedinicaDetalji&PodrucjeID=$this->mDepartmentId&CjelinaID=$this->mCategoryId&JedinicaID=$this->mActionedProdId");
      exit;
    }
    //if updating a product
    if ($this->mAction == "update")
    {     
      $product_name = $_POST['prod_name'];
      $product_description = $_POST['prod_description'];

  //  $product_price = $_POST['prod_price'];

      $product_file_name1 = $_POST['prod_image1_name'];
      $product_file_name2 = $_POST['prod_image2_name'];
         
      $product_on_catalog_promotion = (isset($_POST['on_catalog_promotion']) && ($_POST['on_catalog_promotion'] == "on")) ?1:0;

        $product_on_department_promotion = (isset($_POST['on_department_promotion']) && ($_POST['on_department_promotion'] == "on")) ?1:0;
    
      if ($product_name == null)
        $this->mErrorMessage = 'Jedinica nema imena!';
      if ($product_description == null)
        $this->mErrorMessage = 'Jedinica nema opis!';

  //    if ($product_price == null || !is_numeric($product_price))
  //      $this->mErrorMessage = 'Product price must be a number!';


/*	echo $this->mActionedProdId;
	echo $product_name;
	echo $product_description;
	echo $product_file_name1;
	echo $product_file_name2;
	echo $product_on_catalog_promotion;
	echo $product_on_department_promotion;

	exit;*/



      if ($this->mErrorMessage == null)
        $this->mCatalog->UpdateProduct($this->mActionedProdId, $product_name,
          $product_description, $product_file_name1,
          $product_file_name2, $product_on_catalog_promotion,
          $product_on_department_promotion);




    }

    $this->mProducts = $this->mCatalog->GetProductsInCategoryAdmin($this
      ->mCategoryId);
//    print_r($this->mProducts);exit;
    $this->mProductsCount = count($this->mProducts);
  }
}
?>
