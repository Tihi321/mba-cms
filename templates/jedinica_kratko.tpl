{* jedinica_kratko.tpl *}
{load_jedinica_kratko assign="lista_jedinica"}
{$lista_jedinica->mSearchResultsTitle}
{if $lista_jedinica->mrTotalPages > 1}
    Stranica {$lista_jedinica->mPageNo} od ukupno {$lista_jedinica->mrTotalPages}:
    {if $lista_jedinica->mPreviousLink}
       <a href='{$lista_jedinica->mPreviousLink|escape:"html"}'>Prethodna</a>
    {else}
       Prethodna
    {/if}
    {if $lista_jedinica->mNextLink}
       <a href='{$lista_jedinica->mNextLink|escape:"html"}'>Sljedeća</a>
    {else}
       Sljedeća
    {/if}
{/if}
{section name=k loop=$lista_jedinica->mJedinica}
	<p><a href="{$lista_jedinica->mJedinica[k].onclick|escape:"html"}"><img src='jedinica_slike/{$lista_jedinica->mJedinica[k].slika_1}' width="745" alt="slika jedinice" /></a></p>
	<p><a href="{$lista_jedinica->mJedinica[k].onclick|escape:"html"}">{$lista_jedinica->mJedinica[k].ime}</a></p>
	<p>{$lista_jedinica->mJedinica[k].opis}</p>
{/section}