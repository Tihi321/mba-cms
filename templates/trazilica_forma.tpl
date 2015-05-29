{* trazilica_forma.tpl *}
{load_trazilica_forma assign="search_box"}
<div style="border: 1px solid #000;padding: 0;">
	<form action="index.php">
		<fieldset>
			<input maxlength="100" id="Search" style="border: 0;" name="Search" value="{$search_box->mSearchString}" size="40" />
			<input type="submit" style="border: 0; background-image:url('slike_ms/ikona.jpg'); width: 28px; height: 24px" value=""/>
			<br />
			<!--
			<input type="checkbox" id="AllWords"  name="AllWords" {if $search_box->mAllWords == "on" } checked="checked" {/if}/>
			Sve riječi zastupljene
			-->
		</fieldset>
	</form>
</div>
{* kraj trazilica_forma.tpl *}