{assign var="next" value=$post->getNext()}
{assign var="prev" value=$post->getPrev()}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="he" dir="rtl">

<head>
   <title>{$title|default:$site->title}</title>

   <base href="{$site->url}/" />

   <link rel="stylesheet" href="styles/{$site->theme}/end.css" title="n0where" media="all" />
   <style type="text/css"><!-- @import url('styles/{$site->theme}/personal.css'); --></style>
   {if $style}<style type="text/css"><!-- @import url('styles/{$site->theme}/{$style}.css'); --></style>{/if}
   <link rel="icon" href="favicon.ico" type="image/ico" />

   <link rel="index"      href="{$site->getLink()}" />
   <link rel="start"      href="{$site->getLink()}" />
   <link rel="first"      href="{$site->getLink('post',1)}" />
   <link rel="last"       href="{$site->getLink()}" />
{if $prev != 0}
   <link rel="prev"       href="{$site->getLink('post',$prev)}" />
{/if}
{if $next != 0}
   <link rel="next"       href="{$site->getLink('post',$next)}" />
{/if}
   <link rel="author"     href="{$site->getLink('about','me')}" />
   <link rel="copyright"  href="http://creativecommons.org/licenses/by-sa/1.0/"/>
   <link rel="openid.server" href="http://n0nick.net.net/id/" />

   <meta http-equiv="content-type" content="text/html; charset=utf-8" />
   <meta http-equiv="expires" content="-1" />
   <meta http-equiv= "pragma" content="no-cache" />
   <meta name="author" content="{$site->webmaster} {$site->email}" />
   <meta name="robots" content="index,follow" />
   <meta name="MSSmartTagsPreventParsing" content="true" />
   <meta name="Description" content="{$site->name} {$site->slogan}" />

{literal}
   <script language="javascript" type="text/javascript">
   //<![CDATA[
      window.name='n0main';
      function comments(c) {
         window.open(c, 'n0comments', 'toolbar=yes, directories=no,'
                    +'status=no, resizable=yes, scrollbars=yes, location=no'
                    +', dependent, width=400, height=350');
      }
      function commentsp(c) {
         if (window.event && window.event.keyCode == 13) {
            return comments(c);
         }
      }
      function emoticon(code) {
         x = document.postform.comment;
         x.value = x.value + code;
         document.postform.comment.focus();
      }
      function emoticonp(code) {
         if (window.event && window.event.keyCode == 13) {
            return emoticon(code);
         }
      }
      function closep() {
         if (window.event && window.event.keyCode == 13) {
            return window.close();
         }
      }
   //]]>
   </script>
{/literal}
</head>

<body>

<a name="top"></a>

<div class="photo"><span>{$site->name}</span></div>

<ul class="topnav">
{if $prev}
   <li><a href="{$site->getLink('post',$prev)}"
          title="לכניסה הקודמת באתר">&#171; אחורה</a></li>
{/if}
   <li><a href="{$site->getLink()}"
	  title="חזרה לאתר">ראשי</a></li>
   <li><a href="{$site->getLink('archive')}"
          title="לארכיון הכניסות">ארכיון</a></li>
   <li><a href="{$site->getLink('anchor',$post->postid)}"
          title="קישור ישיר לכניסה">עוגן</a></li>
   <li><a href="{$site->getLink('about')}"
          title="אודות האתר">אודות</a></li>
{if $next}
   <li><a href="{$site->getLink('post',$next)}"
          title="לכניסה הבאה באתר">קדימה &#187;</a></li>
{/if}
</ul>

<div class="post">

<div class="date">
{$post->time|hebdate:'יום b, j בx Y'}
</div>

{if $post->getTitle()}<h1>{$post->getTitle()}</h1>{/if}

{$post->getContent()|autop|n0tags}

<p class="date">
{$post->time|hebdate:'יום b, j בx Y'},
{$post->time|date_format:"%H:%M"}.
</p>

<ul class="nav">
{if $prev}
   <li><a href="{$site->getLink('post',$prev)}"
          title="לכניסה הקודמת באתר">&#171; אחורה</a></li>
   <li>&#151;</li>
{/if}
   <li><a href="{$site->getLink('post',$post->postid)}#comments"
          title="תגובות לכניסה">{$post->comments_count|numbertext:"אין תגובות":"תגובה אחת":"%d תגובות"}</a></li>
   <li>&#151;</li>
   <li><a href="{$site->getLink('post',$post->postid)}#postcomment"
          title="הגב בעצמך">הוסף תגובה</a></li>
   <li>&#151;</li>
   <li><a href="{$site->getLink('anchor',$post->postid)}"
          title="קישור ישיר לכניסה">קישור ישיר</a></li>
{if $next}
   <li>&#151;</li>
   <li><a href="{$site->getLink('post',$next)}"
          title="לכניסה הבאה באתר">קדימה &#187;</a></li>
{/if}
   <li>&#151;</li>
   <li><a href="{$site->getLink('post',$post->postid)}#top"
          title="לראש הדף">למעלה</a></li>
</ul>

<div class="comments">
<h1><a name="comments">:: {if $post->comments_count<1}אין {/if}תגובות לכניסה</a></h2>

{assign var="comments" value=$post->fetchComments()}
{foreach from=$comments item="comment"}
{include file="comments/comment.tpl" comment=$comment site=$site recourse=yes}
{/foreach}

{php}
$cookie = array();
$oreo = split('&', @$_COOKIE['details']);
foreach ($oreo as $milk) {
    $milk = split('=', $milk);
    $cookie[@$milk[0]] = @$milk[1];
}
$this->_tpl_vars['cookie'] = $cookie;
{/php}
{include file="comments/form.tpl" site=$site postid=$post->postid cookie=$cookie}

</div>

<ul class="nav">
{if $prev}
   <li><a href="{$site->getLink('post',$prev)}"
          title="לכניסה הקודמת באתר">&#171; אחורה</a></li>
   <li>&#151;</li>
{/if}
   <li><a href="{$site->getLink('post',$post->postid)}#comments"
          title="תגובות לכניסה">{$post->comments_count|numbertext:"אין תגובות":"תגובה אחת":"%d תגובות"}</a></li>
   <li>&#151;</li>
   <li><a href="{$site->getLink('post',$post->postid)}#postcomment"
          title="הגב בעצמך">הוסף תגובה</a></li>
   <li>&#151;</li>
   <li><a href="{$site->getLink('anchor',$post->postid)}"
          title="קישור ישיר לכניסה">קישור ישיר</a></li>
{if $next}
   <li>&#151;</li>
   <li><a href="{$site->getLink('post',$next)}"
          title="לכניסה הבאה באתר">קדימה &#187;</a></li>
{/if}
   <li>&#151;</li>
   <li><a href="{$site->getLink('post',$post->postid)}#top"
          title="לראש הדף">למעלה</a></li>
</ul>

<div class="copy">
<a href="http://creativecommons.org/licenses/by-sa/1.0/"
   title="&amp;copyleft;">חלק</a> מהזכרויות שמורות
<img src="img/copyleft.png" width="11" height="11"
alt="&amp;copyleft;" /> <a href="{$site->getLink('about','me')}#contct"
title="{$site->webmaster}">{$site->webmaster}</a>.<br />
תודה ל-<a href="http://twisthost.com/"
title="Generously Hosted by TwistHost">TwistHost</a>.</div>

</div>

</body>
</html>
