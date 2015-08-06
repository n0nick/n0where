{include file="`$template`/head.tpl" site=$post->site photo=$post->getAttribute('photo') next=$post->getNext() prev=$post->getPrev()}

<h1 class="post">
   <span class="date">{$post->time|hebdate:'יום b, j בx Y'}</span>
   <span class="time">{$post->time|date_format:"%H:%M"}&nbsp;</span>
</h1>


{include file="`$template`/topnav.tpl" post=$post site=$post->site}


<div class="post">

{if $post->getTitle()}<h2>{$post->getTitle()}</h2>{/if}

{$post->getContent()|autop|n0tags}

{if $post->getAllowComments()}
<p class="comments">
<a href="{$post->site->getLink('comments',$post->postid)}" target="n0comments"
   onclick="comments(this.href); return false" onkeypress="commentsp(this.href); return false"
   title="תגובות הגולשים לכניסה">({$post->comments_count|numbertext:"אין תגובות":"תגובה אחת":"%d תגובות"})</a>
</p>
{/if}

{include file="`$template`/more.tpl" post=$post site=$post->site}

</div>

{include file="`$template`/foot.tpl" site=$post->site post=$post}