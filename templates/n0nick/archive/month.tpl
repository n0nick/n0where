{assign var="defskin" value=$site->getSetting('defskin')}
{include file="`$defskin`/head.tpl" site=$site title="`$site->name` :: archive : `$month`/`$year`"}
{include file="archive/head.tpl"}

<div class="here"><a href="{$site->getLink('archive')}" title="ארכיון">ארכיון</a> &gt;
<a href="{$site->getLink('archive',$year)}" title="ארכיון {$year}">{$year}</a> &gt; {$hebmonths[$month]}</div>
{section name=link loop=$links}
{if $smarty.section.link.first}
<ul>
{/if}
<li><a href="{$site->getLink('post',$links[link]->postid)}"
title="לקריאת הכניסה">{$links[link]->time|hebdate:"j.n"}</a>
:"{if $links[link]->getTitle()}<strong>{$links[link]->getTitle()|strip_tags}</strong>{/if} 
{$links[link]->getExcerpt()}"</li>
{if $smarty.section.link.last}
</ul>
{/if}
{/section}

{include file="archive/foot.tpl"}
{include file="`$defskin`/foot.tpl" site=$site}