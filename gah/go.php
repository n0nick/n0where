<?php
require_once('pass.inc.php');
require_once('bloggerfunctions/blogger.php');

if ($_COOKIE['thank_god']!='its friday.') {
   header('Location: index.php');
}

$wtf = @$_POST['what'];

switch($wtf) {
   case 'delete-the-sucka': // delete the sucka!
      $postid = @$_POST['postid']+0;
      if (blogger_deletePost($postid, 'n0nick', N0_PASS, true)) {
         header('Location: list.php');
      } else {
         debug('Could not delete post.');
      }
      break;

   case 'edit-the-fucka': // edit the fucka!
      $postid = $_POST['postid']+0;

      $good  = '<title>'.stripslashes($_POST['title']).'</title>';
      $good .= str_replace("\r\n","\n",stripslashes($_POST['content']));
      $good .= '<template>'.stripslashes($_POST['template']).'</template>';
      if (@$_POST['allowcomments'] == 'on') {
         $good .= '<allow_comments>yes</allow_comments>';
      } else {
         $good .= '<allow_comments>no</allow_comments>';
      }
      if (@$_POST['commentalert'] == 'on') {
         $good .= '<comment_alert>yes</comment_alert>';
      } else {
         $good .= '<comment_alert>no</comment_alert>';
      }

      if (blogger_editPost($postid, 'n0nick', N0_PASS, true, $good)) {
         header('Location: list.php');
      } else {
         debug ('Could not edit post.');
      }
      break;

   case 'new-biatch': // a new masterpiece!

      $good  = '<title>'.stripslashes($_POST['title']).'</title>';
      $good .= str_replace("\r\n","\n",stripslashes($_POST['content']));
      $good .= '<template>'.stripslashes($_POST['template']).'</template>';
      if (@$_POST['allowcomments'] == 'on') {
         $good .= '<allow_comments>yes</allow_comments>';
      } else {
         $good .= '<allow_comments>no</allow_comments>';
      }
      if (@$_POST['commentalert'] == 'on') {
         $good .= '<comment_alert>yes</comment_alert>';
      } else {
         $good .= '<comment_alert>no</comment_alert>';
      }

      if (blogger_newPost('n0nick', 'n0nick', N0_PASS, $good, true)) {
         header('Location: list.php');
      } else {
         debug ('Could not create post.');
      }
      break;
}

?>