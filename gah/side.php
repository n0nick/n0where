<?php

$a = @$_GET['a']; 

if ($_COOKIE['thank_god']!='its friday.') {
   header('Location: index.php');
}

print '<'.'?xml version="1.0" encoding="utf-8"?'.'>';
?>
<!DOCTYPE html
   PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="he" dir="rtl">

<head>
   <title>n0where :: admin : sidebar</title>

   <base target="mainframe" />

   <link rel="stylesheet" href="side.css" title="n0admin" media="all" />

   <link rel="icon" href="favicon.ico" type="image/ico" />
   <link rel="copyright" href="http://creativecommons.org/licenses/by-sa/2.0/"/>

   <meta http-equiv="content-type" content="text/html; charset=utf-8" />
   <meta http-equiv="expires" content="-1" />
   <meta http-equiv=" pragma" content="no-cache" />
   <meta name="author" content="n0nick,sagiem@gmail.com" />
   <meta name="robots" content="index,follow" />
   <meta name="MSSmartTagsPreventParsing" content="true" />



</head>

<body>

<h1><span>gah</span></h1>

<div id="navcontainer">

<ul id="navlist">
   <li<?php if($a=='list'){?> id="active"<?}?>><a
      href="list.php">רשימת פוסטים</a></li>
   <li<?php if($a=='new'){?> id="active"<?}?>><a
      href="new.php">פוסט חדש</a></li>
   <li><a href="http://n0nick.net/" target="_blank">האתר האתר</a></li>
   <li><a href="index.php?log=out" target="_top">יציאה מהמערכת</a></li>
</ul>

<p class="quote">
<strong>quote of the day</strong>
<script type="text/javascript" src="http://www.brainyquote.com/link/quotefu.js"></script>
</p>

</div>

</body>
</html>
