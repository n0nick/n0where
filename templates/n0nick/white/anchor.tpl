{assign var="next" value=$post->getNext()}
{assign var="prev" value=$post->getPrev()}
<!DOCTYPE html
   PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="he" dir="rtl">

<head>
   <title>wh1te</title>

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
      background-color: #FFFFFF;
      margin: 0px 0px 0px 0px;
   }

   #content {
      color: #FFFFFF;
   }

   #foot {
      text-align: left;
      font-size: xx-small;
      border-top: 1px solid #000000;
      width: 100%;
      height: 15px;
      bottom: 0px;
      left: 0px;
      position: absolute;
      direction: ltr;
      padding-top: 1px;
   }

   #foot ul {
      display: inline;
      margin-left: 20px;
      padding: 0px 0px 0px 0px;
   }
   #foot ul li {
      list-style: none;
      display: inline;
      padding-right: 3px;
   }

   #foot img {
      border: 0px;
      width: 10px;
      height: 10px;
   }
   </style>
{/literal}

</head>

<body>

<div id="content">
{if $post->getTitle()}<h1>{$post->getTitle()}</h1>{/if}
{$post->getContent()|autop|n0tags}
</div>

<div id="foot">
<ul>
{if $prev}
<li><a href="{$site->getLink('post',$prev)}"><img
       src="img/items/video/rw.png" width="10" height="10" alt="rw" title="rw" /></a></li>
{/if}
<li><a href="{$site->getLink('archive')}"><img
       src="img/items/video/play.png" width="10" height="10" alt="play "title="play" /></a></li>
{if $post->getAllowComments()}
<li><a href="{$post->site->getLink('comments',$post->postid)}" target="n0comments"
   onclick="comments(this.href); return false"
   onkeypress="commentsp(this.href); return false"><img
   src="img/items/video/stop.png" width="10" height="10" alt="stop" title="stop" /></a></li>
{/if}
{if $next}
<li><a href="{$site->getLink('post',$next)}"><img
       src="img/items/video/ff.png" width="10" height="10" alt="ff" title="ff" /></a></li>
{/if}
</ul>
</div>

</body>
</html>
