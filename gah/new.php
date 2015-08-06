<?php
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
      function gobo() {
         if (document.edit.allowcomments.checked) {
            document.edit.commentalert.disabled = false;
         } else {
            document.edit.commentalert.disabled = true;
         }
      }

      parent.side.location = "side.php?a=new";
   // -->
   </script>

</head>

<body>

<h1>פוסט חדש</h1>

<form action="go.php" method="post" name="edit" style="display: inline;">
<input type="hidden" name="what" value="new-biatch" />
<label for="title">כותרת:</label>
<input type="text" name="title" value="" style="width: 350px;" /><br />
<label for="content">תוכן:</label><br />

<textarea name="content" rows="15" cols="60" style="width: 600px; height: 350px; font-size: smaller;">
</textarea><br />

<label for="template">תבנית עיצוב:</label>
<input type="text" name="template" value="n06" style="width: 100px;" /><br />
<input type="checkbox" name="allowcomments" checked="checked" onclick="gobo()" />
<label for="allowcomments">אפשר הוספת תגובות</label>
<input type="checkbox" name="commentalert" checked="checked" />
<label for="commentalert">התראת תגובות</label><br />
<input type="submit" value="תקתק אותה !" class="submit" />
</form>
<button class="submit" onclick="document.location='list.php'">אחורה פנה!</button>

</body>
</html>
