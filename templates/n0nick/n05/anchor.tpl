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

<div id="post">

{if $posttitle}<h2>{$posttitle}</h2>{/if}

{$post->getContent()|autop|n0tags}

<p class="byline">מאת 
{mailto address=$site->email text=$site->webmaster encode="javascript" extra='title="mail me"'}
ב{$post->time|hebdate:'יום b, j בx Y'}, {$post->time|date_format:"%H:%M"}.</p>

{include file="`$template`/nav.tpl" site=`$site` post=$post prev=$prev next=$next}

</div>

{include file="`$template`/foot.tpl" site=$post->site post=$post}
