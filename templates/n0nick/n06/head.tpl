<!DOCTYPE html
   PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="he" dir="rtl">

<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="generator" content="PSPad editor, www.pspad.com" />
<title>{$title|default:$site->title}</title>
<base href="{$site->url}/" />
<link rel="stylesheet" href="styles/{$site->theme}/n06/main.css" title="n0where 6.0" media="all" type="text/css" />
{if $style}<style type="text/css"><!-- @import url('styles/{$site->theme}/n05/{$style}.css'); --></style>{/if}
<script type="text/javascript" src="scripts/cookies.js"></script>
<script type="text/javascript" src="scripts/n06.js"></script>
<link rel="icon" href="/favicon.ico" type="image/ico" />
<link rel="alternate" type="application/rss+xml" title="n0feed" href="http://feeds.feedburner.com/n0nick" />
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
<link rel="copyright"  href="http://creativecommons.org/licenses/by-sa/1.0/il/" />
<link rel="openid.server" href="http://n0nick.net.net/id/" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta http-equiv="expires" content="-1" />
<meta http-equiv= "pragma" content="no-cache" />
<meta name="author" content="{$site->webmaster} {$site->email}" />
<meta name="robots" content="index,follow" />
<meta name="MSSmartTagsPreventParsing" content="true" />
<meta name="Description" content="{$site->name} {$site->slogan}" />
</head>

<body>

<!--[if IE]>
<div id="explorerdestroyer">
<a class="close" href="javascript:closeDestroyer();" title="Close notification">x</a>
<p>אני רואה שאת משתמשת בדפדפן Internet Explorer של מיקרוסופט.
זהו דפדפן מאוד עני, תקול, מלא בפרצות אבטחה ובעיות תוכנה.</p>
<p>יתרה על זאת הוא מפר הרבה <a href="http://www.standards.co.il/" title="הכללים">תקנים</a>, מה שמקשה על הפיתוח עבורו ומונע התפתחות סדירה של הטכנולוגיות ברשת.</p>
<p>אני ממליץ לך בחום להחליף דפדפן ולגלות את האינטרנט מחדש. אני אישית משתמש וממליץ מאוד על <a href="http://getfirefox.com/" title="Get Firefox" dir="ltr"><strong>Mozilla Firefox</strong></a>.</p>
</div>
<script type="text/javascript">shouldHide()</script>
<![endif]-->

<h1><a href="{$site->getLink()}" title="n0where."><span>n0where.</span></a></h1>
