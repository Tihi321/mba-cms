<?php    
/* smarty plugin function that gets called when the 
   load_admin_podrucja function plugin is loaded from a template */
function smarty_function_load_admin_podrucja($params, $smarty)
{        
  $admin_departments = new AdminDepartments();
  $admin_departments->init(); 
  // assign template variable
  $smarty->assign($params['assign'], $admin_departments);
}        

class AdminDepartments
{        
   
  public $mDepartmentsCount;
  public $mDepartments;
  public $mErrorMessage = "";
  public $mEditItem;
  public $mAction = "";
  public $mActionedDepId;  
  private $mCatalog;

  function __construct()                                         
  {                                                              
    $this->mCatalog = new PoslovniObjekt();                           
    // parse the list with posted variables                      
    foreach ($_POST as $key => $value)                           
      // if a submit button was clicked...                       
      if (substr($key,0,6) == "submit")                          
      {                                                          
        // get the position of the last '_' underscore           
        // from submit button name                               
        // e.g. strtpos("submit_edit_dep_1", "_") is 16          
        $last_underscore = strrpos($key, "_");                   
        // get the scope of submit button                        
        // (e.g  'edit_dep' from 'submit_edit_dep_1')            
        $this->mAction = substr($key, strlen("submit_"),         
                                   $last_underscore-strlen("submit_"));
        // get the department id targeted by submit button       
        // (the number at the end of submit button name )        
        // e.g '1' from 'submit_edit_dep_1'                      
        $this->mActionedDepId = substr($key,$last_underscore+1); 
        break;                                                   
      }                                                          
  }                                                              
  // init                                                        
  function init()                                                
  {                                                              
    // if adding a new department ...                            
    if ($this->mAction == "add_dep")                             
    {                                                            
       $department_name = $_POST['dep_name'];                    
       $department_description = $_POST['dep_description'];      
       if ($department_name == null)                             
         $this->mErrorMessage = "Department name required";      
       if ($this->mErrorMessage == null)                         
         $this->mCatalog->AddDepartment($department_name,        
                                            $department_description);
    }                                                            
    // if editing an existing department ...                     
    if ($this->mAction == 'edit_dep')                            
       $this->mEditItem = $this->mActionedDepId;                 
    // if updating a department ...                              
    if ($this->mAction == 'update_dep')                          
    {                                                            
       $department_name = $_POST['dep_name'];                    
       $department_description = $_POST['dep_description'];      
       if ($department_name == null)                             
         $this->mErrorMessage = "Department name required";      
       if ($this->mErrorMessage == null)
         $this->mCatalog->UpdateDepartment($this->mActionedDepId, 
                                $department_name, $department_description);
    }                            
    // if deleting a department ...
    if ($this->mAction == "delete_dep")  
    {                            
       $status=$this->mCatalog->DeleteDepartment($this->mActionedDepId);
       if ($status < 0) $this->mErrorMessage = "Podruèje nije prazno!";
    }                            
    // if editing department's categories ...
    if ($this->mAction == "edit_categ")  
    {                            
       header("Location:admin.php?Stranica=Cjeline&" . 
        "PodrucjeID=$this->mActionedDepId");
       exit;                     
    }                            
    // load the list of departments 
    $this->mDepartments = $this->mCatalog->GetDepartmentsWithDescriptions();
    $this->mDepartmentsCount = count($this->mDepartments);
  }                              
} //kraj klase                   
?>           