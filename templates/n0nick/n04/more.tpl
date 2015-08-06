{include_php file="addons/more.php"}

{if $today or $yesterday}
<div class="more">
{if $today}
<h2>עוד היום:</h2>
<ul>
{section name=tdy loop=$today}
   <li><a href="{$site->getLink('post',$today[tdy]->postid)}"
          title="{$today[tdy]->time|date_format:"%H:%M"}">{$today[tdy]->time|date_format:"%H:%M"}</a>
       {if $today[tdy]->getTitle()}<strong>{$today[tdy]->getTitle()|strip_tags}</strong>{/if}
       {$today[tdy]->getExcerpt(120)}</li>
{/section}
</ul>
{/if}

{if $yesterday}
<h2>אתמול היה:</h2>
<ul>
{section name=yst loop=$yesterday}
   <li><a href="{$site->getLink('post',$yesterday[yst]->postid)}"
          title="{$yesterday[yst]->time|date_format:"%H:%M"}">{$yesterday[yst]->time|date_format:"%H:%M"}</a>
       {if $yesterday[yst]->getTitle()}<strong>{$yesterday[yst]->getTitle()|strip_tags}</strong>{/if}
       {$yesterday[yst]->getExcerpt(120)}</li>
{/section}
</ul>
{/if}
</div>
{/if}