<?php
require_once('pass.inc.php');
require_once('bloggerfunctions/blogger.php');

if ($_COOKIE['thank_god']!='its friday.') {
   header('Location: index.php');
}

$postid = @$_GET['postid']+0;

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
      function gobo() {
         if (document.edit.allowcomments.checked) {
            document.edit.commentalert.disabled = false;
         } else {
            document.edit.commentalert.disabled = true;
         }
      }
   // -->
   </script>

</head>

<body onload="gobo()">

<?php
if (stristr(@$_GET['submit'],'למחוק')): ?>

<h1>מחיקת פוסט</h1>

<p><strong>האם אתה בטוח במאת-האחוזים שבא לך למחוק את פוסט #<?=$postid?>?</strong><br />
(ושתדע לך שברגע שאישרת אין דרך חזרה!!)</p>

<button class="submit" onclick="document.location='list.php'; return true;">השתגעת??? קח אותי חזרה - ומהר!!!1</button>
<form action="go.php" method="post" style="display: inline;">
<input type="hidden" name="what" value="delete-the-sucka" />
<input type="hidden" name="postid" value="<?=$postid?>" />
<input type="submit" class="submit" value="כן בטח מה, חרא פוסט." />
</form>

<?php else: 

$postid = $_GET['postid']+0;
$post = blogger_getPost($postid, 'n0nick', N0_PASS);

$title = eregi ('<title>((.*\n*)*)</title>', $post['content'], $matches);
$title = @$matches[1]; $matches = 0;
$template = eregi('<template>((.*\n*)*)</template>',$post['content'],$matches);
$template = @$matches[1]; $matches = 0;
$allow_comments = eregi('<allow_comments>((.*\n*)*)</allow_comments>',$post['content'],$matches);
$allow_comments = @$matches[1]; $matches = 0;
$allowcomments = ($allow_comments != 'no');
if ($allowcomments) {
   $comment_alert = eregi('<comment_alert>((.*\n*)*)</comment_alert>',$post['content'],$matches);
   $comment_alert = @$matches[1]; $matches = 0;
   $commentalert = ($comment_alert != 'no');
} else { $commentalert = FALSE; }

$content = eregi_replace('<title>((.*\n*)*)</title>', '', $post['content']);
$content = eregi_replace('<template>((.*\n*)*)</template>', '', $content);
$content = eregi_replace('<allow_comments>((.*\n*)*)</allow_comments>', '', $content);
$content = eregi_replace('<comment_alert>((.*\n*)*)</comment_alert>', '', $content);
?>

<h1>עריכת פוסט</h1>

<form action="go.php" method="post" name="edit" style="display: inline;">
<input type="hidden" name="what" value="edit-the-fucka" />
<input type="hidden" name="postid" value="<?=$postid?>" />
<label for="title">כותרת:</label>
<input type="text" name="title" value="<?=$title?>" style="width: 350px;" /><br />
<label for="content">תוכן:</label><br />
<textarea name="content" rows="15" cols="60" style="width: 600px; height: 350px; font-size: smaller;">
<?=$content?></textarea><br />
<label for="template">תבנית עיצוב:</label>
<input type="text" name="template" value="<?=$template?>" style="width: 100px;" /><br />
<input type="checkbox" name="allowcomments"<?if ($allowcomments) {?> checked="checked"<?}?> onclick="gobo()" />
<label for="allowcomments">אפשר הוספת תגובות</label><!--TODOOOOOOOOOOOOOOOOOOO-->
<input type="checkbox" name="commentalert"<?if ($commentalert) {?> checked="checked"<?}?> />
<label for="commentalert">התראת תגובות</label><br />
<input type="submit" value="אוקיי, יאללה.." class="submit" />
</form>
<button class="submit" onclick="document.location='list.php'">אופסי, טעות שלי!</button>

<?php endif; ?>

</body>
</html>