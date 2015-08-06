{if empty($parentid)}

<hr />
<h2 class="postcomment"><a name="postcomment">הוסיפו תגובה</a></h2>
{else}
<div class="replyhead">
<h2>הוספת תגובה להודעה</h2>
<a href="{$site->getLink('comments',$postid)}" title="חזרה לתגובות לסיפור">חזרה
לתגובות</a><div>
{/if}
<div class="form">
<form action="{$site->getLink('comments',$postid)}" method="post" id="postform" name="postform">
<input type="hidden" name="action" value="post_comment" />
<input type="hidden" name="postid" value="{$postid}" />
{randomtext long=5 assign=secret}
{randomtext long=7 assign=goaway1}
{randomtext long=12 assign=goaway2}
<input type="hidden" name="secret" value="{$secret}" />
{if $parentid}
<input type="hidden" name="parentid" value="{$parentid}" />
{/if}
<div class="row">
   <span class="label"><label for="name" class="reqf"><u>ש</u>ם:</label></span>
   <span class="formw"><input type="text" name="name" id="name" accesskey="ש"
      maxlength="32" value="{$cookie.name}" /></span>
</div><div class="row">
   <span class="label"><label for="email"><u>ד</u>ואל:</label></span>
   <span class="formw"><input type="text" name="email" id="email" accesskey="ד"
      maxlength="32" value="{$cookie.email}" dir="ltr" /></span>
</div><div class="row">
   <span class="label"><label for="url">א<u>ת</u>ר:</label></span>
   <span class="formw"><input type="text" name="url" id="url" accesskey="ת"
      maxlength="125" value="{if $cookie.url}{$cookie.url}{else}http://{/if}" dir="ltr" /></span>
</div><div class="row">
   <span class="label"><label for="gocode" class="reqf"><u>ק</u>וד:</label></span>
   <span class="formw"><input type="text" name="gocode" id="gocode" accesskey="ק"
      maxlength="8" value="" />[הכנס <img src="/addons/image.php?text={$goaway1}{$secret}{$goaway2}" alt="secret number" />]</span>
</div><div class="row">
   <span class="label"><label for="comment" class="reqf">ת<u>ג</u>ובה:</label>
   </span><span class="formw"><textarea rows="8" cols="40" name="comment"
      id="comment" accesskey="ג"></textarea></span>
</div><div class="row">
   <span class="label">עיצוב:</span>
   <span class="formw">**<strong>מודגש</strong>**</span>
</div><div class="row">
   <span class="label">אייקונים:</span>
   <span class="formw">{include file="comments/emoticons.tpl" site=$site}</span>
</div><div class="colspan">
   <input type="checkbox" name="remember" accesskey="ז"
      id="remember"{if $cookie.name} checked="checked"{/if} />
   <label for="remember"><u>ז</u>כור אותי, זכור אותי, זכור אותי, עד למקום הקבוע שלנו.</label>
</div><div class="colspan">
   <input type="submit" value="שלח" id="sub" />
</div>
</form>
</div>