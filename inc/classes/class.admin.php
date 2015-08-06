<?php
/**
 * Admin class
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 * 
 * For questions, help, comments, etc., please contact <n0nick@php.net>.
 *
 * @package n0where
 * @author Sagie Maoz <n0nick@php.net>
 * @copyright Sagie Maoz, 2003
 * @version 1.0
 */

/**
 * Admin class
 *
 * The admin class manages all administration operations, such as deleting
 * comments, editing and deleting posts, changing settings, etc.
 *
 * Currently every page of the admin is visible to all users but in order
 * to complete an operation, a pssword is requested.<br />
 * For the admin's convinence, the password is stored in a session var once
 * entered correctly.
 *
 * @package n0where
 * @author Sagie Maoz <n0nick@php.net>
 * @copyright Sagie Maoz, 2003
 * @version 1.0
 * @see Site::display
 */
class Admin {

   /**
    * Site
    *
    * Instance of the parent site.
    *
    * @var Site
    */
   var $site;

   /**
    * Admin area
    *
    * The name of an area in the website to admin: currently there are only
    * two possible values: comments, posts.<br />
    * Future values: files=>for uploading files.
    *
    * @var string
    */
   var $area;

   /**
    * Action
    *
    * The action requested from the admin to process.
    *
    * @see display
    * @var string
    */
   var $action;

   /**
    * Required parameters
    *
    * An array with all parameters required by the action.
    *
    * @see action
    * @see display
    * @var array
    */
   var $parameters;


   /**
    * Admin constructor
    *
    * Constructs the admin instance and starts the admin session.
    *
    * @param Site $site  Parent site's instance
    * @return void
    */
   function Admin($site, $area, $action, $parameters) {

      $this->site       = $site;

      $this->area       = $area;
      $this->action     = $action;
      $this->parameters = $parameters;

      if (empty($this->area)) {
         $this->area = 'posts';
         if (empty($this->action)) {
            $this->action = 'list';
         }
      } // if

      // start session
      ini_set('arg_separator.output','&amp;'); // so PHP's links will be valid.
      session_start();

   } // Admin()

   /**
    * Validate given password
    *
    * Every form in the administration center requires a pssword.<br />
    * This function checks whether the password matches the set admin password.
    *
    * If the password is valid, a session is opened and the function returns
    * TRUE. Otherwise, any open admin session is closed and it returns FALSE.
    *
    * @param  string  $password Password given by the user
    * @return boolean Whether the password matched
    */
   function correctPass($password) {

      if ($this->site->ad_pass === $password) {
         $_SESSION['adminpass'] = $password;
         return TRUE;
      } else {
         $_SESSION['adminpass'] = '';
         return FALSE;
      }

   } // correctPass()


   /**
    * Display admin
    *
    * Calls the appropriate display function based on the given area.
    *
    * @return array New display array for the parent site instance.
    */
   function display() {

      switch ($this->area) {
         case 'posts':
            return $this->adminPosts();
            break;
         case 'comments':
            return $this->adminComments();
            break;
      } // switch

   } // display()


   /**
    * Manage posts
    *
    * Calls the appropriate admin function based on the given command under the
    * posts area.<br />
    * Current available actions: list, edit, del, add.
    *
    * @return array When appropriate, a new display array for the parent site
    *               instance.
    */
   function adminPosts() {

/*
      switch ($this->action) {
         case 'list': // default
            $this->listPosts(@$this->parameters[0]);
            break;
         case 'edit':
            break;
         case 'edit-go':
            break;
         case 'del':
            break;
         case 'del-go':
            break;
         case 'add':
            break;
         case 'add-go':
            break;
      }
*/
      $this->site->display = array('index');
      $this->site->display();

   } // adminPosts()

   /**
    * List posts
    *
    * Displays a list of all posts, divided to pages, with administration
    * options - edit post and remove post.
    *
    * @param integer $page Current list page index
    * @return void
    */
   function listPosts($page) {

      // page number
      if ($page==0) { $page = 1; }
      $offset = ($page-1)*15;

      // assign vars to template
      $this->site->smarty->assign('site',   $this->site);
      $this->site->smarty->assign('page',   $page);
      $this->site->smarty->assign('offset', $offset);
      $this->site->smarty->assign('pass',   @$_SESSION['adminpass']);

      // display confirmation page
      $this->site->smarty->display('admin/posts/list.tpl');

//      $posts = $this->site->getRecentPosts(15,$offset);
//      foreach($posts as $post) {
//         print $post->postid.'<br>';
//      }

   } // listPosts()


   /**
    * Manage comments
    *
    * Calls the appropriate admin function based on the given command under the
    * comments area.<br />
    * Currently there is only 'delete comment', but so be it.
    *
    * @return array New display array for the parent site instance.
    */
   function adminComments() {

      switch ($this->action) {
         case 'del':
            $this->delComment($this->parameters[0], $this->parameters[1]);
            break;
         case 'del-go':
            return $this->delCommentGO($this->parameters);
            break;
      } // switch

   } // adminComments()

   /**
    * Confirm comment deletion
    *
    * Before actually deleting the comment, this mid-level shows a confirmation
    * dialog, also requesting the admin password.<br />
    * This is done, how else, with templates.
    *
    * @param int $commentid Commentid of comment to delete
    * @param int $postid    Postid of comment's post
    * @return void
    */
   function delComment($commentid, $postid) {

      // assign vars to template
      $this->site->smarty->assign('site',      $this->site);
      $this->site->smarty->assign('commentid', $commentid);
      $this->site->smarty->assign('postid',    $postid);
      $this->site->smarty->assign('pass', @$_SESSION['adminpass']);

      // display confirmation page
      $this->site->smarty->display('admin/comments/del.tpl');

   } // delComment()

   /**
    * Delete comment
    *
    * Once everything is confirmed (and the password is O.K), the comment is
    * deleted, any child comments are deleted too, and then the post's comments
    * count is updated.
    *
    * Returns a new display array for the parent site, so that the post's
    * comments page is displayed after everything.
    *
    * @param array $_post Confirmation form's result POST variables.
    * @return array New display array for the parent site instance.
    */
   function delCommentGO($_post) {

      // get vars
      $commentid = $_post['commentid'];
      $postid    = $_post['postid'];
      $password  = $_post['password'];

      if ($this->correctPass($password)) {
         // get post data
         $post    = new Post($this->site, $postid);
         $post->fetch_from_db();

         // remove comment and update post's comments count
         $comment = new Comment($post, $commentid);
         $post->comments_count = $comment->remove()-1;
         $post->updateDB();
      }

      // back to comments page
      return array('comments', $postid, 0, 0);

   } // delCommentGO()

} // Admin

/* Simba says Roar! */ ?>