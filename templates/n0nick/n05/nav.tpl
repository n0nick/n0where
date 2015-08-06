<div id="linksline"><ul>
{if $prev}
<li class="first"><a href="{$site->getLink('post',$prev)}" title="לכניסה הקודמת באתר">&#171; אחורה</a></li>
{/if}
<li{if !$prev} class="first"{/if}><a href="{$site->getLink()}" title="חזרה לאתר">בית</a></li>
<li><a href="{$site->getLink('archive')}" title="לארכיון הכניסות באתר" rel="Site">ארכיון</a></li>
{if $post}
<li><a href="{$site->getLink('anchor',$post->postid)}" title="קישור ישיר לכניסה"
       rel="Post">עוגן</a></li>
{if $post->getAllowComments()}
<li><a href="{$post->site->getLink('comments',$post->postid)}" target="n0comments"
   rel="Post" onclick="comments(this.href); return false" 
   onkeypress="commentsp(this.href); return false"
   title="תגובות הגולשים לכניסה">{$post->comments_count|numbertext:"אין תגובות":"תגובה אחת":"%d תגובות"}</a></li>
{/if}
{/if}
<li><a href="{$site->getLink('about')}" title="אודות האתר" rel="Site">אודות</a></li>
{if $next}
<li><a href="{$site->getLink('post',$next)}" title="לכניסה הבאה באתר">קדימה &#187;</a></li>
{/if}
</ul></div>