{assign var="defskin" value=$site->getSetting('defskin')}
{include file="`$defskin`/head.tpl" site=$site title="`$site->name` :: archive : `$year`"}
{include file="archive/head.tpl"}

<div class="here"><a
href="{$site->getLink('archive')}" title="ארכיון">ארכיון</a> &gt; {$year}</div>

{if !empty($previous_years)}
{section name=year loop=$previous_years}
{if $smarty.section.year.first}
שנים קודמות:
{/if}
<a href="{$site->getLink('archive',$previous_years[year])}"
title="ארכיון {$previous_years[year]}">{$previous_years[year]}</a>{if !$smarty.section.year.last}, {/if}
{/section}
{/if}

{foreach name=monthfor item=month from=$months}
{if $smarty.foreach.monthfor.first}
<ul>
{/if}
<li><a href="{$site->getLink('archive',$year,$month)}"
title="ארכיון {$hebmonths[$month]} {$year}">{$hebmonths[$month]} {$year}</a></li>
{if $smarty.foreach.monthfor.last}
</ul>
{/if}
{/foreach}


{if !empty($more_years)}
{section name=year loop=$more_years}
{if $smarty.section.year.first}
עוד שנים:
{/if}
<a href="{$site->getLink('archive',$more_years[year])}"
title="ארכיון {$more_years[year]}">{$more_years[year]}</a>{if !$smarty.section.year.last}, {/if}
{/section}
{/if}

{include file="archive/foot.tpl"}
{include file="`$defskin`/foot.tpl" site=$site}