<?php
require_once('pass.inc.php');

if(@$_POST['passwd']==N0_PASS) {
   setcookie('thank_god', 'its friday.');
   header('Location: index.php');
}

if (@$_GET['log']=='out') {
   setcookie('thank_god', 'for chocolate!');
   header('Location: index.php');
}

print '<'.'?xml version="1.0" encoding="utf-8"?'.">\n"; ?>
<!DOCTYPE html
   PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="he" dir="rtl">

<head>
   <title>n0where :: admin</title>

   <link rel="stylesheet" href="page.css" title="n0admin" media="all" />

   <link rel="icon" href="favicon.ico" type="image/ico" />
   <link rel="copyright" href="http://creativecommons.org/licenses/by-sa/2.0/"/>

   <meta http-equiv="content-type" content="text/html; charset=utf-8" />
   <meta http-equiv="expires" content="-1" />
   <meta http-equiv=" pragma" content="no-cache" />
   <meta name="author" content="n0nick,sagiem@gmail.com" />
   <meta name="robots" content="index,follow" />
   <meta name="MSSmartTagsPreventParsing" content="true" />

</head>

<?php if (@$_COOKIE['thank_god']!='its friday.'): ?>

<body style="text-align: center;">
<h1>תן סיסמא!</h1>
<form action="index.php" method="post">
<input type="password" name="passwd" />
<input type="submit" value="קח" class="submit" style="width: 50px;" />
</form>
</body>

<?php else: ?>

<frameset cols="*, 320" rows="*">
   <frame src="list.php" name="mainframe" scrolling="no" frameborder="0" />
   <frame src="side.php?a=list" name="side" scrolling="auto" frameborder="0" />
</frameset>

<body>
<noframes>
Sorry! I want frames.
</noframes>
</body>

<?php endif; ?>

</html>
