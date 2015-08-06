<h2 class="addcomment"><a name="postcomment" href="javascript:addComment(0)" title="טופס הוספת תגובה">הוסיפו תגובה</a></h2>
<form action="{$site->getLink('comments',$postid)}" method="post" id="postform" name="postform">
<input type="hidden" name="action" value="post_comment" />
<input type="hidden" name="postid" value="{$postid}" />
{randomtext long=5 assign=secret}
{randomtext long=7 assign=goaway1}
{randomtext long=12 assign=goaway2}
<input type="hidden" name="secret" value="{$secret}" />
<input type="hidden" name="parentid" id="parentid" value="0" />
<div>
<label for="name" class="reqf"><u>ש</u>ם:</label>
<input type="text" name="name" id="name" accesskey="ש" maxlength="32" value="{$cookie.name}" class="formw" onfocus="focuser(this)" onblur="blurer(this)" />
</div>
<div>
<label for="email"><u>ד</u>ואל:</label>
<input type="text" name="email" id="email" accesskey="ד" maxlength="32" value="{$cookie.email}" dir="ltr" class="formw"onfocus="focuser(this)" onblur="blurer(this)" />
</div>
<div>
<label for="url">א<u>ת</u>ר:</label>
<input type="text" name="url" id="url" accesskey="ת" maxlength="125" value="{if $cookie.url}{$cookie.url}{else}http://{/if}" dir="ltr" class="formw"onfocus="focuser(this)" onblur="blurer(this)" />
</div>
<div>
<label for="gocode" class="reqf"><u>ק</u>וד:</label>
<span class="formw"><input type="text" name="gocode" id="gocode" accesskey="ק" maxlength="8" value="" onfocus="focuser(this)" onblur="blurer(this)" />[הכנס <img src="addons/image.php?text={$goaway1}{$secret}{$goaway2}" alt="secret number" />]</span>
</div>
<div>
<label for="comment" class="reqf">ת<u>ג</u>ובה:</label>
<textarea rows="8" cols="40" name="comment" id="comment" accesskey="ג" class="formw" onfocus="focuser(this)" onblur="blurer(this)"></textarea>
</div>
<div>
<label>עיצוב:</label>
<span class="formw">**<strong>מודגש</strong>**</span>
</div>
<div class="emoticons">
<label>אייקונים:</label>
<span class="formw">{include file="`$template`/emoticons.tpl" site=$site}</span>
</div>
<div>
<input type="checkbox" name="remember" accesskey="ז" id="remember" {if $cookie.name} checked="checked"{/if} />
<label for="remember" class="rm"><u>ז</u>כור אותי, זכור אותי, זכור אותי, עד למקום הקבוע שלנו.</label>
</div>
<div class="formend">
<input type="submit" value="שלח" class="sub" id="sub" />
<button class="sub" onclick="addComment(0); return false;">בטל</button>
</div>
</form>
