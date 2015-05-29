{load_admin_jedinice assign="admin_products"}
Promjene podataka jedinicama koje pripadaju cjelini: {$admin_products->mCategoryName} 
(<a href="admin.php?Stranica=Cjeline&amp;PodrucjeID={$admin_products->mDepartmentId}">
nazad na cjeline...</a>)
<br/><br/>
{if $admin_products->mProductsCount eq 0}
 <b>Nema jedinica u ovoj kategoriji!</b>
{else}
{$admin_products->mErrorMessage}
<form action="admin.php?Stranica=Jedinice&amp;PodrucjeID={$admin_products->mDepartmentId}&amp;CjelinaID={$admin_products->mCategoryId}" method="post">
<table cellpadding="3" cellspacing="1" border="0" width="100%">
 <tr valign="top">
  <td colspan="5">&nbsp;</td>
  <td colspan="2" class="naslovni_red">Promid탑ba na razini</td>
  <td colspan="3">&nbsp;</td>
 </tr>
 <tr valign="top" class="naslovni_red">
  <td align="right">ID</td>
  <td>Ime</td>
  <td>Opis</td>
  <td align="center">Slika1</td>
  <td align="center">Slika2</td>
  <td>Home</td>
  <td>Podru훾ja</td>
  <td colspan="3">&nbsp;</td>
 </tr>
 {section name=cProducts loop=$admin_products->mProducts}
 {if $admin_products->mEditItem == $admin_products->mProducts[cProducts].jedinica_id}
  <tr valign="top">
   <td>{$admin_products->mProducts[cProducts].jedinica_id}</td>
   <td><input type="text" name="prod_name" value="{$admin_products->mProducts[cProducts].ime}"/></td>
   <td><textarea name="prod_description" rows="3" cols="20"> {$admin_products->mProducts[cProducts].opis}</textarea></td>
   <td width="60" align="right"><input type="text" name="prod_image1_name" value="{$admin_products->mProducts[cProducts].slika_1}"/></td>
   <td width="60" align="right"><input type="text" name="prod_image2_name" value="{$admin_products->mProducts[cProducts].slika_2}"/></td>

   <td width="40" align="center"><input type="checkbox" name="on_catalog_promotion" {if $admin_products->mProducts[cProducts].promidzba_na_razini_homepage eq 1} checked="checked" {/if}/></td>

   <td width="40" align="center"><input type="checkbox" name="on_department_promotion" {if $admin_products->mProducts[cProducts].promidzba_na_razini_podrucja eq 1} checked="checked" {/if}/></td>
   <td width="30"><input type="submit" name="submit_update_{$admin_products->mProducts[cProducts].jedinica_id}" value="A엞riraj" /><br/>
<input type="submit" value="Odustani"/></td> 
   <td width="35"><input type="submit" name="submit_select_{$admin_products->mProducts[cProducts].jedinica_id}" value="Odaberi" /></td>
  </tr>
 {else}
  <tr valign="top">
   <td align="right">{$admin_products->mProducts[cProducts].jedinica_id}</td>
   <td>{$admin_products->mProducts[cProducts].ime}</td>
   <td>{$admin_products->mProducts[cProducts].opis}</td>
   <td width="60" align="right">{$admin_products->mProducts[cProducts].slika_1}</td>
   <td width="60" align="right">{$admin_products->mProducts[cProducts].slika_2}</td>
   <td width="40" align="center"><input type="checkbox" disabled="disabled" {if $admin_products->mProducts[cProducts].promidzba_na_razini_homepage eq 1} checked="checked" {/if}/></td>
   <td width="40" align="center"><input type="checkbox" disabled="disabled" {if $admin_products->mProducts[cProducts].promidzba_na_razini_podrucja eq 1} checked="checked" {/if}/></td>
   <td width="30"><input type="submit" name="submit_edit_{$admin_products->mProducts[cProducts].jedinica_id}" value="Edit"/></td>
   <td width="35"><input type="submit" name="submit_select_{$admin_products->mProducts[cProducts].jedinica_id}" value="Odaberi"/></td>
  </tr>
 {/if}
{/section}
</table>
</form> 
{/if}
<form action="admin.php?Stranica=Jedinice&amp;PodrucjeID={$admin_products->mDepartmentId}&amp;CjelinaID={$admin_products->mCategoryId}" method="post">
<b>Dodaj novu jedinicu:</b><br /><br/>
  <input type="text" size="30" name="prod_name" value="[Tipkaj ime jedinice]"/>
  <input type="text" size="75" name="prod_description" value="[Tipkaj opis jedinice]" /> 
<br />
<input type="checkbox" name="on_catalog_promotion"/>Promid탑ba na razini home page<br /> 
<input type="checkbox" name="on_department_promotion"/>Promid탑ba na razini podru훾ja<br/><br />
  <input type="submit" name="submit_add_0" class="AdminButtonText" value="Dodaj" />
</form>

