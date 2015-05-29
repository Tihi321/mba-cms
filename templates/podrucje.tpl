{* podrucje.tpl *}
{load_podrucje assign="podrucje"}
<ul>
{section name=i loop=$podrucje->mPodrucje}
         <li><a href="{$podrucje->mPodrucje[i].onclick}">{$podrucje->mPodrucje[i].ime}</a></li>
{/section}
</ul>