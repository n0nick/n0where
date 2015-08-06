{assign var="prev" value=$post->getPrev()}
{assign var="next" value=$post->getNext()}
{if $post->getTitle()}
{assign var="posttitle" value=$post->getTitle()}
{assign var="title" value="`$site->title` // `$posttitle`"|strip_tags:true}
{else}
{assign var="title" value=$site->title}
{/if}
{assign var="defskin" value=$site->getSetting('defskin')}
{include file="`$template`/head.tpl" site=$post->site next=$next prev=$prev title=$title}

{include file="n06/nav.tpl" site=`$site` post=$post prev=$prev next=$next slogan="look closer."}

<div id="page" class="box">
{if $posttitle}<h2>{$posttitle}</h2>{/if}
<p class="datetime">{$post->time|hebdate:'j בx Y'}, {$post->time|date_format:"%H:%M"}</p>

{$post->getContent()|autop|n0tags}

</div>

{if $post->getAllowComments()}
<div id="comments" class="box">
<h2>תגובות</h2>
{assign var="comments" value=$post->fetchComments()}
{if empty($comments)}<p class="none">אין, אפילו לא תגובה אחת. אני בטח יושב 
עכשיו בבית בוכה. אתה באמת רוצה את זה על המצפון שלך? כל זה רק כי התעצלת לעשות 
כמה קליקים? נו באמת, תלחץ תגיב. מה יקרה!</p>{/if}
{foreach from=$comments item="comment"}
{include file="`$template`/comment.tpl" comment=$comment site=$site recourse=yes}
{/foreach}
{if $site->config.settings.allow_comments neq 'no'}
{include file="`$template`/comment.form.tpl" site=`$site` postid=$post->postid cookie=$cookie}
{else}
<p dir="ltr">Sorry, due to spam troubles, comments are not allowed.</p>
{/if}
</div>
{/if}

{include file="`$template`/nav.tpl" site=`$site` post=$post prev=$prev next=$next slogan="look up!"}

{include file="`$template`/foot.tpl" site=$post->site post=$post}
