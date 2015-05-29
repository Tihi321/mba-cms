{load_admin_podrucja assign="admin_departments"}
Administriranje tablice `podrucje`:
<br/><br/>
<span class="poruka">{$admin_departments->mErrorMessage}</span>
{if $admin_departments->mDepartmentsCount eq 0}
<b>Nema područja u vašoj bazi podataka</b>                 
{else}                                                           
<form action="admin.php?Stranica=Podrucja" method="post" onsubmit="return submitForm();"> 
<table cellpadding="3" cellspacing="1" border="0" width="100%">  
 <tr valign="top" class="naslovni_red">                                        
  <td>Ime područja</td>                                       
  <td>Opis područja</td>                                
  <td colspan="3">&nbsp;</td>                                    
 </tr>                                                           
 {section name=cDepartments loop=$admin_departments->mDepartments}
  {if $admin_departments->mEditItem ==                           
        $admin_departments->mDepartments[cDepartments].podrucje_id}
 <tr valign="top">                                           
  <td>                                                           
   <input type="text" name="dep_name"                            
      value="{$admin_departments->mDepartments[cDepartments].ime}" />
  </td>                                                          
  <td valign="top">                                                           
   <textarea name="dep_description" rows="3" cols="50">          
{$admin_departments->mDepartments[cDepartments].opis}     
   </textarea>                                                   
  </td>                                                          
  <td width="30">                                                
   <input type="submit" name="submit_update_dep_{$admin_departments->mDepartments[cDepartments].podrucje_id}" value="Ažuriraj"/><br />
   <input type="submit" name="submit_cancel_dep_{$admin_departments->mDepartments[cDepartments].podrucje_id}" value="Odustani" />     
  </td>                                                          
  <td width="130">                                               
   <input type="submit" name="submit_edit_categ_{$admin_departments->mDepartments[cDepartments].podrucje_id}"                       
      value="Edit cjelina"/></td>                             
  <td width="50"><input type="submit"                            
    name="submit_delete_dep_{$admin_departments->mDepartments[cDepartments].podrucje_id}" value="Obriši"/></td> 
 </tr>                                                           
 {else}                                                          
  <tr valign="top">                                          
   <td>{$admin_departments->mDepartments[cDepartments].ime}</td>
   <td>{$admin_departments->mDepartments[cDepartments].opis}</td>
   <td width="30">                                               
    <input type="submit" name="submit_edit_dep_{$admin_departments->mDepartments[cDepartments].podrucje_id}" value="Edit"/>        
   </td>                                                         
   <td width="130">                                              
    <input type="submit" name="submit_edit_categ_{$admin_departments->mDepartments[cDepartments].podrucje_id}" value="Edit cjelina"/>
   </td>                                                         
   <td width="50">
    <input type="submit" name="submit_delete_dep_{$admin_departments->mDepartments[cDepartments].podrucje_id}" value="Obriši"/>
   </td> 
  </tr>  
  {/if}  
 {/section}
</table> 
</form>  
{/if}    
<form action="admin.php?Stranica=Podrucja" method="post">
 <b>Dodaj novo područje:</b><br /><br />
 <input  type="text" size="30" name="dep_name" 
   value="[tipkaj ime novog područja]"/> 
<input type="text" size="60" name="dep_description"
        value="[tipkaj opis novog područja]"/> 
<input type="submit" name="submit_add_dep_0" 
        class="AdminButtonText" value="Dodaj"/>
</form>  
