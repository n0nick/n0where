{assign var="next" value=$post->getNext()}
{assign var="prev" value=$post->getPrev()}
<!DOCTYPE html
   PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="he" dir="rtl">

<head>
   <title>{$title|default:$site->title}</title>

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
	   background-image: url('img/items/stuff.png');
      background-position: top right;
      background-attachment: scroll;
      background-repeat: repeat;
      background-color: #fff;
	}

   a {
    color: #869;
    text-decoration: none;
   }
   a:hover {
      text-decoration: underline;
   }

	#nav {
	   background-color: #fff;
	   border: 3px double #a20;
      position: absolute;
      bottom: 15px;
      left: 15px;
      direction: ltr;
      padding: 0px 5px 0px 5px;
	}
   #nav ul {
      display: inline;
      margin: 0px 0px 0px 0px;
      padding: 0px 0px 0px 0px;
   }
	#nav li {
	   display: inline;
	}

	#post {
	   display: none;
	}
   </style>
{/literal}

</head>

<body>

<div id="nav">
{mailto address="`$site->email`" text="n0."
encode="javascript" extra='title="mail me"'}</a>
&copy;
|
<ul>
{if $next}
   <li><a href="{$site->getLink('post',$next)}"
          title="לכניסה הבאה באתר">&lt;</a></li>
{/if}
   <li><a href="{$site->getLink('anchor',$post->postid)}"
          title="קישור ישיר לכניסה">!</a></li>
{if $post->getAllowComments()}
<li><a href="{$post->site->getLink('comments',$post->postid)}" target="n0comments"
   onclick="comments(this.href); return false"
   onkeypress="commentsp(this.href); return false"
   title="תגובות הגולשים לכניסה">ת</a></li>
{/if}
{if $prev}
   <li><a href="{$site->getLink('post',$prev)}"
          title="לכניסה הקודמת באתר">&gt;</a></li>
{/if}
</ul>
</div>

<div id="post">
{if $post->getTitle()}<h1>{$post->getTitle()}</h1>{/if}
{$post->getContent()|autop|n0tags}
<p>{$post->time|hebdate:'יום b, j בx Y'},
{$post->time|date_format:"%H:%M"}.</p>
</div>

</body>
</html>
