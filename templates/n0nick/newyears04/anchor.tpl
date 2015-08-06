{assign var="next" value=$post->getNext()}
{assign var="prev" value=$post->getPrev()}
<!DOCTYPE html
   PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="he" dir="rtl">

<head>
   <title>n0year</title>

   <base href="{$site->url}/" />

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

   <style type="text/css">
   body {
      background-color: #322;
      text-align: center;
      font: medium arial, "lucida console", sans-serif;
      margin: 25px 25px 25px 25px;
   }

   a {
      color: #f00;
      text-decoration: underline;
      font-weight: bold;
   }
   a:hover {
      text-decoration: none;
   }
   a:active {
      color: #363;
   }

   #page {
      background-color: #fff;
      border: 4px solid #b10;
      width: 600px;
      margin: 0px auto;
      text-align: right;
   }

   #balloon {
      width: 600px;
      height: 256px;
      background-image: url('img/items/balloon.png');
   }

   #balloon span {
      display: none;
   }

   #content {
      padding: 10px 20px 10px 20px;
   }

   #content h1 {
      font-size: xx-large;
   }

   #date {
	font-size: x-small;
	text-align: left;
	margin: 10px 10px 10px 10px;
   }

   #links {
      font-size: small;
      border-top: 2px dashed #b10;
      padding: 10px 10px 10px 10px;
      text-align: left;
   }

   #links .post {
      float: right;
      display: inline;
      margin: 0px 0px 0px 0px;
      padding: 0px 0px 0px 0px;
   }
   #links .post li {
   	list-style: none;
   	display: inline;
   }

   #links .site {
      display: inline;
      margin: 0px 0px 0px 0px;
      padding: 0px 0px 0px 0px;
   }
   #links .site li {
      list-style: none;
      display: inline;
   }
   </style>
{/literal}

</head>

<body>

<div id="page">
<div id="balloon"><span>(red balloon)</span></div>

<div id="content">
{if $post->getTitle()}<h1>{$post->getTitle()}</h1>{/if}
{$post->getContent()|autop|n0tags}
</div>

<div id="date">
{$post->time|hebdate:'יום b, j בx Y'},
{$post->time|date_format:"%H:%M"}.
</div>

<div id="links">
<ul class="post">
{if $prev}
   <li><a href="{$site->getLink('post',$prev)}"
          title="לכניסה הקודמת באתר">אחורה</a></li>
{/if}
{if $post->getAllowComments()}
<li><a href="{$post->site->getLink('comments',$post->postid)}" target="n0comments"
   onclick="comments(this.href); return false"
   onkeypress="commentsp(this.href); return false"
   title="תגובות הגולשים לכניסה">{$post->comments_count|numbertext:"אין תגובות":"תגובה אחת":"%d תגובות"}</a></li>
{/if}
   <li><a href="{$site->getLink('anchor',$post->postid)}"
          title="קישור ישיר לכניסה">עוגן</a></li>
{if $next}
   <li><a href="{$site->getLink('post',$next)}"
          title="לכניסה הבאה באתר">קדימה</a></li>
{/if}
</ul>

<ul class="site">
   <li><a href="{$site->getLink()}"
	  title="חזרה לאתר">ראשי</a></li>
   <li><a href="{$site->getLink('archive')}"
          title="לארכיון הכניסות">ארכיון</a></li>
   <li><a href="{$site->getLink('about')}"
          title="אודות האתר">אודות</a></li>
</ul>
</div>
</div>

</body>
</html>
