<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="he" dir="rtl">

<head>
   <title>{$title|default:$site->title}</title>

   <base href="{$site->url}/" />

   <link rel="stylesheet" type="text/css" href="styles/{$site->theme}/main.css" title="n0where" media="all" />
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
   //]]>
   </script>

<!-- Google Analytics code -->
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-166973-1";
urchinTracker();
</script>
{/literal}

{if $photo}
   <style type="text/css">
      div.page div.photo {literal}{{/literal}
         background-image: url('img/photos/{$photo}.png') !important;
      {literal}}{/literal}
   </style>
{/if}
</head>

<body>

<div class="page">

{*<img src="img/photos/babe.png" width="500" height="240"
   alt="{$site->name}" title="{$site->name}" class="photo" />*}

<div class="photo"><span>{$site->name}</span></div>
