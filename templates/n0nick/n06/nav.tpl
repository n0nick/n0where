<ul class="nav box">
{if $prev}
<li class="back"><a href="{$site->getLink('post',$prev)}" title="לפוסט הקודם">אחורה</a></li>
{/if}
<li class="home"><a href="{$site->getLink()}" title="לדף הראשי">מעלה</a></li>
<li class="slogan">{$slogan}</li>
<li class="archive"><a href="{$site->getLink('archive')}" title="ארכיון פוסטים">היסטוריה</a></li>
{if $next}
<li class="next"><a href="{$site->getLink('post',$next)}" title="לפוסט הבא">קדימה</a></li>
{/if}
</ul>
