{if !$level}{assign var="level" value="0"}{/if}
{if $level>5}{assign var="level" value="5"}{/if}
<div class="comment" style="margin-right:{math equation="x*2" x=$level}em">
<h3><a name="c{$comment->commentid}" class="poster">{$comment->name|htmlspecialchars}</a>
{if !empty($comment->email) or (!empty($comment->url) and $comment->url != 'http://')}
({if !empty($comment->email)}
{mymailto address=$comment->email encode=hex text='ד' extra="title=\"שלח דואל ל`$comment->name`\""}
{/if}
{if !empty($comment->email) and (!empty($comment->url) and $comment->url != 'http://')} / {/if}
{if !empty($comment->url) and $comment->url != 'http://'}
<a href="{$comment->url}" title="{$comment->url}" target="_blank">א</a>{/if})
{/if}
ב-{$comment->time|date_format:"%d.%m.%Y %H:%M"}
<a href="{$site->getLink('admin','comments','del',$comment->commentid,$comment->postid)}" title="מחק הודעה" class="del"><span>x</span></a></h3>
{assign var="cmt" value="`$comment->comment`"}
{assign var="cmt" value=$cmt|htmlspecialchars|nl2br|n0tags|linkalize}
<div class="text">{$comment->post->site->replaceEmoticons($cmt)}</div>
{if $recourse}
<div class="reply"><a
href="javascript:addComment({$comment->commentid})"
title="הוסף תגובה תחת הודעה זו">הגב להודעה זו</a></div>
</div>
{/if}
{if $recourse}
{assign var="children" value=$comment->fetchChildren()}
{foreach from=$children item="child"}
{include file="`$template`/comment.tpl" comment=$child site=$site original=$comment->name level=`$level+1` recourse=yes}
{/foreach}
{/if}
