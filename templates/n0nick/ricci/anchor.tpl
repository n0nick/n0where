{assign var="next" value=$post->getNext()}
{assign var="prev" value=$post->getPrev()}
{assign var="posttitle" value=$post->getTitle()}
{assign var="title" value=" // `$posttitle`"}
<!DOCTYPE html
   PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="he" dir="rtl">

<head>
   <title>n06?{$title|strip_tags:true}</title>

   <base href="{$site->url}/" />

   <link rel="icon" href="favicon.ico" type="image/ico" />
   <link rel="alternate" type="application/rss+xml" title="n0feed"
         href="http://feeds.feedburner.com/n0nick" />


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
   <meta http-equiv=" pragma" content="no-cache" />
   <meta name="author" content="n0nick,sagiem@gmail.com" />
   <meta name="robots" content="index,follow" />
   <meta name="MSSmartTagsPreventParsing" content="true" />

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
   //]]>
   </script>
   
<!-- Google Analytics code -->
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-166973-1";
urchinTracker();
</script>

   <style type="text/css">
   body {
      background-color: #eee;
      margin: 0px 0px 0px 0px;
      font-family: arial, "lucida console", sans-serif;
   }
   a {
      color: #b10;
      font-weight: bold;
   }
   a:hover {
      text-decoration: none;
   }
   a:active {
      color: #00f;
   }

   h1 {
      font-size: xx-large;
      margin: 00px 10px 0px 0px;
   }

   #ricc {
      position: absolute;
      top: 100px;
      background: #fff url('img/items/cr01.png') no-repeat center left;
      width: 100%;
      height: 323px;
      border-top: 4px solid #39c;
      border-bottom: 4px solid #6c3;
   }
   #ricc #boo {
      display: block;
      overflow: auto;
      direction: ltr;
      height: 290px;
      margin: 10px 10px 0px 30px;
      padding-left: 420px;
   }
   #ricc #boo p,h1,h2,h3,div,blockquote {
      direction: rtl;
   }
   #ricc #boo p {
      margin-right: 10px;
      font: small arial, "lucida console", sans-serif;
      line-height: 130%;
      letter-spacing: 1.5px;
   }

   #ricc #yah {
      font-size: small;
      text-align: left;
      margin-left: 420px;
   }
   #ricc #yah #by {
      float: right;
      direction: ltr;
      padding-right: 10px;
   }
   #ricc #yah a.nav {
      color: #000;
      background-color: #eee;
   }
   #ricc #yah ul {
      padding: 0px 5px 0px 5px;
      display: inline;
   }
   #ricc #yah ul li {
      list-style: none;
      display: inline;
   }
   </style>
{/literal}

</head>

<body>

<div id="ricc">
<div id="boo">
{if $post->getTitle()}<h1>{$post->getTitle()}</h1>{/if}
{$post->getContent()|autop|n0tags}
</div>
<div id="yah">
<span id="by">
{$post->time|hebdate:'j/n/Y'} {$post->time|date_format:"%H:%M"} //
{mailto address=$site->email text=$site->webmaster encode="javascript" extra='title="mail me"'}
</span>
<ul>
{if $prev}
<li><a href="{$site->getLink('post',$prev)}" class="nav" title="לפוסט הקודם">אחורה</a></li>
{/if}
<li><a href="{$site->getLink('archive')}" class="nav" title="לארכיון הפוסטים">ארכיון</a></li>
{if $post->getAllowComments()}
<li><a href="{$post->site->getLink('comments',$post->postid)}" target="n0comments"
   onclick="comments(this.href); return false" class="nav" title="מה שאנשים כתבו"
   onkeypress="commentsp(this.href); return false">{$post->comments_count|numbertext:"אין תגובות":"תגובה אחת":"%d תגובות"}</a></li>
{/if}
<li><a href="{$site->getLink('anchor',$post->postid)}" class="nav"
   title="קישור ישיר">עוגן</a></li>
<li><a href="{$site->getLink('about')}" class="nav" title="אודות האתר">אודות</a></li>
{if $next}
<li><a href="{$site->getLink('post',$next)}" class="nav" title="לפוסט הבא">קדימה</a></li>
{/if}
</ul>
</div>
</div>

</body>
</html>
