<?php
/* smarty plugin funkcije koje preko poslovnog sloja
   dolaze do potrebnih varijabli za kreiranje prezentacijskog sloja */
function smarty_function_load_admin_cjeline($params, $smarty)
{

  $admin_cjeline = new AdminCjeline();
  $admin_cjeline->init();
  // dodijeli varijable za smarty predložak
  $smarty->assign($params['assign'], $admin_cjeline);
}

class AdminCjeline
{
  // javne varijable na raspolaganju smarty predlošku
  public $mBrojCjelina;
  public $mCjeline;
  public $mEditItem =  - 1;
  public $mErrorMessage = "";
  public $mPodrucjeId;
  public $mPodrucjeIme;
  /* privatne varijable */
  private $mCms;
  private $mAction="";
  private $mActionedCategId;
  
  function __construct()
  {
    $this->mCms = new PoslovniObjekt();
    if (isset($_GET['PodrucjeID']))
      $this->mPodrucjeId = (int)$_GET['PodrucjeID'];
    else
      trigger_error("PodrucjeID not set");
    $department_details = $this->mCms->GetPodrucjeDetalji($this
      ->mPodrucjeId);
    $this->mPodrucjeIme = $department_details['ime'];
    foreach ($_POST as $key => $value) 
    //ako amo uèinili klik na gumb submit..    
    if (substr($key,0,6) == "submit") 
    {       
      /* pohranimo poziciju posljednje crtice '_' poèevši brojiti od imena gumba submit 
         npr., strtpos("submit_edit_dep_1","_") je 16
      */
      $last_underscore = strrpos($key,"_");
      //pohranimo ime gumba submit (npr.  'edit_dep' u stringu 'submit_edit_dep_1')
      $this->mAction = substr($key,strlen("submit_"),$last_underscore-strlen("submit_"));        
      /* pohrani podatak podrucje_id, koji ovisi o tome koji smo gumb submit odabrali
         (to je onaj zadnji broj nakon imena gumba submit 
         npr. '1' u stringu 'submit_edit_dep_1')
      */ 
      $this->mActionedCategId = (int)substr($key,$last_underscore+1);       
      break; 
    }
  }

  function init()
  {
    // ako dodajemo novu cjelinu ...
    if ($this->mAction == "add")
    {
      $category_name = $_POST['categ_name'];
      $category_description = $_POST['categ_description'];
      if ($category_name == null)
        $this->mErrorMessage = 'Ime cjeline je prazno';
      if ($this->mErrorMessage == null)
        $this->mCms->AddCategory($this->mPodrucjeId, $category_name,
          $category_description);
    }
    // ako mijenjamo podatke u postojeæem podruèju ...
    if ($this->mAction == "edit_categ")
    {
      $this->mEditItem = $this->mActionedCategId;
    }
    // ako ažuriramo cjelinu ...
    if ($this->mAction == "update")
    {
      $category_name = $_POST['categ_name'];
      $category_description = $_POST['categ_description'];
      if ($category_name == null)
        $this->mErrorMessage = 'Ime cjeline je prazno';
      if ($this->mErrorMessage == null)
        $this->mCms->UpdateCategory($this->mActionedCategId, $category_name,
          $category_description);
    }
    // ako brišemo neku cjelinu ...
    if ($this->mAction == "delete")
    {
      $status = $this->mCms->DeleteCategory($this->mActionedCategId);
      if ($status < 0)
        $this->mErrorMessage = "Cjelina nije prazna";
    }
    // ako editiramo jedinice koje pripadaju nekoj cjelini ...
    if ($this->mAction == "edit_products")
    {
      header(
        "Location:admin.php?Stranica=Jedinice&PodrucjeID=$this->mPodrucjeId&CjelinaID=$this->mActionedCategId");
      exit;
    }
    $this->mCjeline = $this->mCms
      ->GetCategoriesInDepartmentWithDescriptions($this->mPodrucjeId);
    $this->mBrojCjelina = count($this->mCjeline);
  }
}
?>
