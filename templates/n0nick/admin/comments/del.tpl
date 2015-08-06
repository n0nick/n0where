{assign var="defskin" value=$site->getSetting('defskin')}
{include file="comments/head.tpl" postid=$postid site=$site}

<div class="comment">
<h2>
<a class="poster">ניהול תגובות</a>
&nbsp;
<span class="date">{$smarty.now|date_format:"%H:%M %d.%m.%Y"}</span>
</h2>
<div class="text" style="text-align: center; padding-top: 20px;">
<form action="{$site->getLink('admin','comments',$commentid,$postid)}" method="POST">
<input type="hidden" name="action"    value="admin" />
<input type="hidden" name="area"      value="comments" />
<input type="hidden" name="admin"     value="del-go" />
<input type="hidden" name="commentid" value="{$commentid}" />
<input type="hidden" name="postid"    value="{$postid}" />
<label for="password">סיסמת ניהול:</label>
<input type="password" name="password" value="{$pass}" class="password" /><br />
<p>האם אתה בטוח שברצונך למחוק את תגובה #{$commentid} ?</p>
<div><input type="submit" value="כן, מחק" id="sub" />
<a href="{$site->getLink('comments',$postid)}"
   title="חזרה לדף התגובות">לא, חזור.</a>
</div>
</form>
</div>
</div>

{include file="comments/foot.tpl" postid=$postid site=$site}