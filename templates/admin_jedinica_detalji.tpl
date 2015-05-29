{load_admin_jedinica_detalji assign="admin_jedinica_detalji"}
<form enctype="multipart/form-data" 
action="admin.php?Stranica=JedinicaDetalji
&amp;PodrucjeID={$admin_jedinica_detalji->mPodrucjeId}
&amp;CjelinaID={$admin_jedinica_detalji->mCjelinaId}
&amp;JedinicaID={$admin_jedinica_detalji->mJedinicaId}" method="post">
Promjene podataka jedinice: 
<b>{$admin_jedinica_detalji->mJedinicaIme}</b>
(<a href="admin.php?Stranica=Jedinice
&amp;PodrucjeID={$admin_jedinica_detalji->mPodrucjeId}        
&amp;CjelinaID={$admin_jedinica_detalji->mCjelinaId}">nazad na listu svih jedinica u cjelini...</a>)                     
<p>                                                              
Jedinica pripada ovim cjelinama:
<b>{$admin_jedinica_detalji->mJedinicaCjelineString}</b>
</p>                                                             
Ukloni jedinicu iz ove cjeline:     
<select name="TargetCategoryIdRemove">                           
 {html_options options=$admin_jedinica_detalji->mUkloniIzCjelina}
</select>                                                        
<input type="submit" name="RemoveFromCategory" value="Ukloni" 
{if $admin_jedinica_detalji->premjestiIzCjelineGumbOnemogucen}
disabled="disabled" {/if}/>                                      
<br /><br />                                                       
Jedinicu dodijeli ovoj cjelini:
<select name="TargetCategoryIdAssign">                           
 {html_options options=$admin_jedinica_detalji->mAssignOrMoveTo}  
</select>                                                        
<input type="submit" name="Assign" value="Dodijeli" /> 
<br/><br/>                                                       
Premjesti jedinicu u ovu kategoriju:
<select name="TargetCategoryIdMove">                             
 {html_options options=$admin_jedinica_detalji->mAssignOrMoveTo}  
</select>                                                        
<input type="submit" name="Move" value="Premjesti" /> 
<br/><br/>                                                       
<input type="submit" name="RemoveFromCatalog"                    
        value="Ukloni ovu jedinicu iz baze podataka"                      
 {if !$admin_jedinica_detalji->premjestiIzCjelineGumbOnemogucen} 
disabled="disabled" {/if} />                                     
<br /><br />                                                       
 Slika 1: {$admin_jedinica_detalji->mJedinicaSlika1}           
 <input name="Image1Upload" type="file" value="Upload" />         
 <input type="submit" name="Upload" value="Objavi" /> <br />       
 <img src="jedinica_slike/{$admin_jedinica_detalji->mJedinicaSlika1}" 
border="0" alt="{$admin_jedinica_detalji->mJedinicaSlika1}" />                                    
 <br />                                                           
 Slika 2: {$admin_jedinica_detalji->mJedinicaSlika2}           
 <input name="Image2Upload" type="file" value="Upload"/>         
 <input type="submit" name="Upload" value="Objavi"/> <br/>       
 <img src="jedinica_slike/{$admin_jedinica_detalji->mJedinicaSlika2}" 
border="0" alt="{$admin_jedinica_detalji->mJedinicaSlika2}" />                                    
</form>      