{* cjelina.tpl *}
{load_cjelina assign="cjelina"}
<ul>
{section name=i loop=$cjelina->mCjelina}
<li><a href="{$cjelina->mCjelina[i].ovo_je_link|escape:"html"}">{$cjelina->mCjelina[i].ime}</a></li>
{/section}
</ul>
{* kraj cjelina.tpl *}