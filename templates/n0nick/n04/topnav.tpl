{if $post}
{assign var="prev" value=$post->getPrev()}
{assign var="next" value=$post->getNext()}
{/if}
<div class="topnav">
<ul>{if $next > 0}<li><a
   href="{$site->getLink('post',$next)}" title="לכניסה הבאה"><img src="img/nav/next.png" width="8" height="19" alt="קדימה" title="לכניסה הבאה" /></a></li>{/if}<li><a
   href="{$site->getLink('about')}" title="אודות האתר ועצמי"><img src="img/nav/about.png" width="10" height="19" alt="אודות" title="אודות האתר ועצמי" /></a></li>{if $post->postid > 0}<li><a
   href="{$site->getLink('anchor',$post->postid)}" title="קישור קבוע וישיר לכניסה זו"><img src="img/nav/anchor.png" width="11" height="19" alt="עוגן" title="קישור קבוע וישיר לכניסה זו" /></a></li>{/if}<li><a
   href="{$site->getLink('archive')}" title="לארכיון הכניסות"><img src="img/nav/archive.png" width="12" height="19" alt="ארכיון" title="לארכיון הכניסות" /></a></li><li><a
   href="{$site->getLink()}" title="לדף הראשי"><img src="img/nav/home.png" width="16" height="19" alt="ראשי" title="לדף הראשי" /></a></li>{if $prev > 0}<li><a
   href="{$site->getLink('post',$prev)}" title="לכניסה הקודמת"><img src="img/nav/back.png" width="8" height="19" alt="אחורה" title="לכניסה הקודמת" /></a></li>{/if}<li><img
   src="img/nav/end.png" width="9" height="19" alt="" /></li>
</ul></div>