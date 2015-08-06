{include file="comments/head.tpl" site=$site postid=$post->postid}

{assign var="comments" value=$post->fetchComments()}
{foreach from=$comments item="comment"}
{include file="comments/comment.tpl" comment=$comment site=$site recourse=yes}
{/foreach}

{if $site->config.settings.allow_comments neq 'no'}
{include file="comments/form.tpl" site=$site postid=$post->postid cookie=$cookie}
{else}
<p dir="ltr">Sorry, due to spam troubles, comments are not allowed.</p>
{/if}

{include file="comments/foot.tpl" site=$site postid=$post->postid}
