{if !$level}{assign var="level" value="0"}{/if}
{if $level>5}{assign var="level" value="5"}{/if}

<div style="padding-right:{math equation="x*2" x=$level}em">
<div class="comment"{if $level > 0} style="margin-top: 5px;"{/if}>
<h2>
<a name="c{$comment->commentid}" class="poster">{$comment->name|htmlspecialchars}</a>
<a href="{$site->getLink('admin','comments','del',$comment->commentid,$comment->postid)}"
title="מחק הודעה" class="del">מחק</a>
<span class="date">{$comment->time|date_format:"%d.%m.%Y %H:%M"}</span>
</h2>
<div class="details">
<span class="url">{if !empty($comment->email)}
{mymailto address=$comment->email encode=hex text='דוא"ל' extra="title=\"שלח דואל ל`$comment->name`\""}
{/if}
{if !empty($comment->url) and $comment->url != 'http://'}
<a href="{$comment->url}" title="{$comment->url}" target="_blank">אתר</a>
{/if}
</span>
{if !empty($original) }
<div class="parent">בתגובה ל {$original}</div>
{elseif !empty($comment->email) or (!empty($comment->url) and $comment->url != 'http://')}
&nbsp;
{/if}
</div>
{assign var="cmt" value="`$comment->comment`"}
{assign var="cmt" value=$cmt|htmlspecialchars|nl2br|n0tags|linkalize}
<div class="text">{$comment->post->site->replaceEmoticons($cmt)}</div>
{if $recourse}
<div class="reply"><a
href="{$site->getLink('comments',$comment->postid,'reply',$comment->commentid)}"
title="הוסף תגובה תחת הודעה זו">הגב להודעה זו</a></div>
{/if}
</div></div>

{if $recourse}
{assign var="children" value=$comment->fetchChildren()}
{foreach from=$children item="child"}
{include file="comments/comment.tpl" comment=$child site=$site original=$comment->name level=`$level+1` recourse=yes}
{/foreach}
{/if}