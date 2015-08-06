<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="he" dir="rtl">

<head>
   <title>{$site->name} :: comments</title>

   <base href="{$site->url}/" />

   <link rel="stylesheet" href="styles/{$site->theme}/comments.css" media="all" type="text/css" />
   <link rel="index"      href="{$site->getLink()}/" />
   <link rel="author"     href="{$site->getLink('about','me')}" />
   <link rel="copyright"  href="http://dsl.org/copyleft/dsl.txt" />
   <link rel="openid.server" href="http://n0nick.net.net/id/" />

   <meta http-equiv="content-type" content="text/html; charset=utf-8" />
   <meta http-equiv="expires" content="-1" />
   <meta http-equiv= "pragma" content="no-cache" />
   <meta name="author" content="{$site->webmaster} {$site->email}" />
   <meta name="robots" content="all" />
   <meta name="MSSmartTagsPreventParsing" content="true" />
   <meta name="description" content="{$site->name} {$site->slogan}" />

{literal}
   <script language="javascript" type="text/javascript">
   //<![CDATA[
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

<body dir="rtl">

<div id="topp">
<h1><a name="top" target="n0main" href="{$site->getLink()}"
   title="{$site->name}">{$site->name}</a></h1>
<div class="sub">תגובות
   ל<a href="{$site->getLink('post',$postid)}" title="בחזרה לכניסה" target="n0main"
   onclick="window.close()" onkeypress="closep()">כניסה
   {$postid}</a>.</div></div>

<ul>
<li><a href="{$site->getLink('comments',$postid)}#postcomment" title="הוסיפו תגובה">הגיבו בעצמכם</a></li>
<li><a href="{$site->getLink('post',$postid)}" onclick="window.close()"
   onkeypress="closep()">סגירה</a></li>
</ul>
