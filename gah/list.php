<?php
require_once('pass.inc.php');
require_once('bloggerfunctions/blogger.php');

if ($_COOKIE['thank_god']!='its friday.') {
   header('Location: index.php');
}

print '<'.'?xml version="1.0" encoding="utf-8"?'.">\n"; ?>
<!DOCTYPE html
   PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="he" dir="rtl">

<head>
   <title>n0where :: admin : posts list</title>

   <link rel="stylesheet" href="page.css" title="n0admin" media="all" />

   <link rel="icon" href="favicon.ico" type="image/ico" />
   <link rel="copyright" href="http://creativecommons.org/licenses/by-sa/2.0/"/>

   <meta http-equiv="content-type" content="text/html; charset=utf-8" />
   <meta http-equiv="expires" content="-1" />
   <meta http-equiv=" pragma" content="no-cache" />
   <meta name="author" content="n0nick,sagiem@gmail.com" />
   <meta name="robots" content="index,follow" />
   <meta name="MSSmartTagsPreventParsing" content="true" />

   <script language="javascript" type="text/javascript">
   <!--
      parent.side.location = "side.php?a=list";
   // -->
   </script>

</head>

<body>

<h1>מסך ניהול ראשי</h1>

<ul>

<li>
<form action="new.php" method="get">
<input type="submit" class="submit" name="go" value="בוא צור" />
<label for="go">פוסט חדש.</label>
</form>
</li>

<li>
<form action="edit.php" method="get">
<label for="postid">בחר אחד מה-20 האחרונים:</label><br />
<select name="postid" size="20" id="postslist" style="float: right;">
<?php
$posts = blogger_getRecentPosts('n0nick', 'n0nick', N0_PASS, 20);
$titles = array();
$first = TRUE;
foreach ($posts as $post) {
   $title = eregi ('<title>((.*\n*)*)</title>', $post['content'], $matches);
   $title = @$matches[1]; $matches = 0;
?>
   <option value="<?=$post['postid']?>"<?if ($first) {?> selected="selected"<?}?>><?=$post['postid']?> :
   <?=$title?></option>
<?php $first = FALSE;
} ?>
</select>
<div>
<input type="submit" name="submit" value="יאללה לערוך" class="submit" style="width: 100px; margin-bottom: 3px;" />
<br />
<input type="submit" name="submit" value="יאללה למחוק" class="submit" style="width: 100px;" />
</div><br clear="all" />
</form>
</li>

<li>
<form action="edit.php" method="get">
<label for="postid" id="spec">או שאולי פשוט תבחר מספר:</label>
<input type="text" name="postid" size="3" value="" />
<input type="submit" name="submit" value="לערוך" class="submit" />
<input type="submit" name="submit" value="למחוק" class="submit" />
</form>
</li>

</ul>

</body>
</html>
