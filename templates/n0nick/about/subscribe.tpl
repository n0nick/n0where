{assign var="defskin" value=$site->getSetting('defskin')}
{include file="`$defskin`/head.tpl" title="`$site->name` :: about : subscribe" site=$site}
{include file="about/head.tpl"}

<div class="here"><a href="{$site->getLink('about')}" title="על האתר">אודות</a> &gt;
עשו מנוי</div>
<h3>לומוכן לומוכן לומוכן לומוכן לומוכן</h3>
<p>כאן תוכלו להרשם ולהמחק מרשימת הדיוור של n0where.</p>

{include file="about/foot.tpl"}
{include file="`$defskin`/foot.tpl" site=$site}