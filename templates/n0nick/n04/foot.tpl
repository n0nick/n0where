{if $post}
{assign var="prev" value=$post->getPrev()}
{assign var="next" value=$post->getNext()}
{/if}
</div>

<div class="foot1">
<ul class="links">
{if $prev > 0}
   <li><a href="{$site->getLink('post',$prev)}" title="לכניסה הקודמת">&#171; אחורה</a></li>
{/if}
   <li><a href="{$site->getLink()}" title="לדף הראשי">ראשי</a></li>
   <li><a href="{$site->getLink('archive')}" title="לארכיון הכניסות">ארכיון</a></li>
{if $post->postid > 0}
   <li><a href="{$site->getLink('anchor',$post->postid)}" title="קישור קבוע וישיר לכניסה זו">עוגן</a></li>
{/if}
   <li><a href="{$site->getLink('about')}" title="אודות האתר ועצמי">אודות</a></li>
{if $next > 0}
   <li><a href="{$site->getLink('post',$next)}" title="לכניסה הבאה">קדימה &#187;</a></li>
{/if}
</ul>
</div>

<div class="foot2">
{$smarty.now|date_format:"%Y"}&nbsp;
<a href="http://creativecommons.org/licenses/by-sa/1.0/" target="_blank"
	title="&amp;copyleft;"><img src="img/copyleft.png" width="11" height="11"
   alt="&amp;copyleft;" title="&amp;copyleft;" dir="ltr" /> חלק מהזכויות שמורות</a> ל<a
   href="{$site->getLink('about','me')}#contct"
   title="{$site->webmaster}">{$site->webmaster}</a>.
</div>

<div class="foot3">
<span>{$site->slogan}
<a title="oh, don't click here" href="{$site->getLink('admin')}">;)</a></span>

<ul id="bench" class="links">
   <li><a href="{$site->url}/honey.php" title="מלכודת דבש (למנועי ספאם)">honey</a></li>
   <li><a href="http://feeds.feedburner.com/n0nick" title="RSS feed">RSS</a></li>
   <li><a href="http://bobby.watchfire.com/bobby/bobbyServlet?URL={$site->url}&amp;output=Submit&amp;gl=sec508&amp;test="
      target="_blank" title="U.S. Section 508 Approved">508</a></li>
   <li><a href="http://jigsaw.w3.org/css-validator/validator?uri={$site->url}/styles/{$site->theme}/main.css"
      target="_blank" title="Valid CSS2">CSS2</a></li>
   <li><a href="http://validator.w3.org/check/referer"
      target="_blank" title="Valid XHTML1 Transitional">XHTML1</a></li>
   <li>{$site->getBenchmark()}</li>
</ul>
</div>

<div class="foot4">
<img src="img/n0nick.png"
   width="189" height="19" alt="powered by n0nick technologies"
   title="powered by n0nick technologies" /><!-- class="n0nick" />
<a href="http://www.twisthost.com/" target="_blank"
   title="Generously Hosted by TwistHost"><img src="img/twisthost.png"
   width="88" height="17" alt="Generously Hosted by TwistHost" /></a> -->
</div>

</body>
</html>
