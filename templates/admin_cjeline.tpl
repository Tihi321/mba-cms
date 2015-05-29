{load_admin_cjeline assign="admin_cjeline"}
Administracija svih cjelina koje pripadaju podrčju: 
{$admin_cjeline->mPodrucjeIme} 
(<a href="admin.php?Stranica=Podrucja">nazad na područja...</a>)
<br/><br/>
{if $admin_cjeline->mBrojCjelina eq 0}
<b>Nema cjelina u ovom području!</b><br />
{else}
<span class="poruka">{$admin_cjeline->mErrorMessage}</span>
<form action="admin.php?Stranica=Cjeline&amp;PodrucjeID={$admin_cjeline->mPodrucjeId}" method="post">
<input type="hidden" name="PodrucjeID" value="{$admin_cjeline->mPodrucjeId}"/>
<table cellpadding="3" cellspacing="1" border="0" width="100%">
 <tr valign="top" class="naslovni_red">
  <td>Ime cjeline</td>
  <td>Opis cjeline</td>
  <td colspan="3">&nbsp;</td>
 </tr>
 {section name=cCategories loop=$admin_cjeline->mCjeline}
  {if $admin_cjeline->mEditItem == $admin_cjeline->mCjeline[cCategories].cjelina_id}
   <tr valign="top">
    <td>
     <input type="text" name="categ_name" value="{$admin_cjeline->mCjeline[cCategories].ime}"/>
    </td>
    <td>
     <textarea name="categ_description" rows="3" cols="50">{$admin_cjeline->mCjeline[cCategories].opis}</textarea>
    </td>
    <td width="30">
      <input type="submit" name="submit_update_{$admin_cjeline->mCjeline[cCategories].cjelina_id}" value="Ažuriraj"/><br/>
      <input type="submit" name="submit_cancel_{$admin_cjeline->mCjeline[cCategories].cjelina_id}" value="Odustani"/>
    </td>
    <td width="110">
     <input type="submit" name="submit_edit_products_{$admin_cjeline->mCjeline[cCategories].cjelina_id}" value="Edit jedinica"/> 
    </td>
    <td width="50">
     <input type="submit" name="submit_delete_{$admin_cjeline->mCjeline[cCategories].cjelina_id}" value="Obriši"/>
    </td>
   </tr> 
  {else}
  <tr valign="top">
   <td>{$admin_cjeline->mCjeline[cCategories].ime}</td>
   <td>{$admin_cjeline->mCjeline[cCategories].opis}</td>
   <td width="30"><input type="submit" name="submit_edit_categ_{$admin_cjeline->mCjeline[cCategories].cjelina_id}" value="Edit"/></td>
   <td width="110"><input type="submit" name="submit_edit_products_{$admin_cjeline->mCjeline[cCategories].cjelina_id}" value="Edit jedinica"/></td>
   <td width="50"><input type="submit" name="submit_delete_{$admin_cjeline->mCjeline[cCategories].cjelina_id}" value="Obriši"/></td>
  </tr> 
  {/if}
 {/section}
</table>
</form>
{/if}
<form action="admin.php?Stranica=Cjeline&amp;PodrucjeID={$admin_cjeline->mPodrucjeId}" method="post">
Dodaj novu cjelinu:<br/>
 <input type="text" size="30" name="categ_name" value="[tipkaj ime cjeline]"/> 
 <input type="text" size="60" name="categ_description" value="[tipkaj opis cjeline]"/>  
 <input name="submit_add_0" type="submit" value="Dodaj"/>
</form>


