<?php
/**
 * Post class
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
 * Post class
 *
 * Manages a single post in the weblog.<br />
 * The class represents a post in the weblog, and handles all operations related
 * to it.
 *
 * @package n0where
 * @author Sagie Maoz <n0nick@php.net>
 * @copyright Sagie Maoz, 2003
 * @version 1.0
 */
class Post {

   /**
    * Site
    *
    * Instance of the parent site.
    *
    * @var Site
    */
   var $site;

   /**
    * Post ID
    *
    * Post's serial identification number.
    *
    * @var int
    */   
   var $postid         = 0;
   /**
    * Post time
    *
    * Post's publish date and time, in Unix timestamp format
    * (seconds since Epoch).
    *
    * @var int
    */   
   var $time           = 0;
   /**
    * Post content
    *
    * The post's content in a pseudo-XML format:<br />
    * My core code accepts the following tags:
    * <ul>
    * <li><text> - actual content. required.</li>
    * <li><title> - post title.</li>
    * <li><excerpt> - article excerpt.</li>
    * <li><allow_comments> - whether to allow comments. [yes/no].</li>
    * <li><comment_alert> - alert webmaster upon new comment. [yes/no].</li>
    * <li><type> - post type. list/article/etc.</li>
    * </ul>
    *
    * And of course, leaves room for future extensions.
    *
    * @var string
    */   
   var $content        = '';
   /**
    * Comments count
    *
    * Total number of comments added to the post.
    *
    * @var int
    */   
   var $comments_count = 0;

   /**
    * Post Constructor
    *
    * Constructs instance of a post, using the values of parameters passed
    * as properties values.
    *
    * @param Site   $site           Instance of the parent site.
    * @param int    $postid Post    identification number
    * @param int    $time Post      publish date
    * @param string $content        Post content
    * @param int    $comments_count Post's comments count
    * @return void
    */
   function Post($site, $postid = 0, $time = 0, $content = '',
                 $comments_count = 0) {

      $this->site           = $site;
      $this->postid         = $postid;
      $this->time           = $time +
                          3600 * $this->site->config['settings']['time_offset'];
      $this->content        = $content;
      $this->comments_count = $comments_count;

   } // Post()


   /**
    * Fetch post data from DB
    *
    * Requests post data from the database, by the postid given. If no
    * postid is passed, the current object's {@link $postid} value is
    * used.<br />
    * If this is empty too (or, equal to 0), the most recent post is requested.
    *
    * @see fetch_from_array
    * @param  int     $postid  Post id (if empty, object's current postid is used)
    * @param  boolean $errflag Return success state flag
    * @return void
    */
   function fetch_from_db($postid = '%', $errflag = FALSE) {

      if ($postid == '%') { $postid = $this->postid; }

      // sql preperation
      if ($postid != 0)   { $where = '`postid`=\''.$postid.'\''; }
      else                { $where = '1';                        }
      $sql  = 'SELECT `postid`, `time`, `content`, `comments_count` '
             .'FROM `+posts` '
             .'WHERE '.$where.' '
             .'ORDER BY `postid` DESC';

      // db query
      if ($q = $this->site->db->query($sql)) {
         $data = $this->site->db->fetch_assoc($q);
         $this->fetch_from_array($data);
         return TRUE;
      } else {
         if ($errflag) {
            return FALSE;
         } else {
            $this->site->displayError('post->fetch_from_db()',
                                      $this->site->db->error());
         }
      }

   } // fetch_from_db()


   /**
    * Fetch post data from an array
    *
    * Uses the data array parameter passed, to set the object's properties
    * values.<br />
    * The data array should be an associative array with the keys:<br />
    * 'postid', 'time', 'post', 'comment'.
    *
    * @param  array $data Data array retrieved from database query
    * @return void
    */
   function fetch_from_array($data) {
      // data cleanup
      $data['post'] = stripslashes(@$data['post']);

      $this->Post($this->site,
                  @$data['postid'],
                  @$data['time'],
                  @$data['content'],
                  @$data['comments_count']);

   } // fetch_from_array()


   /**
    * Update database
    *
    * Updates the posts table in the database with the current object's
    * properties.<br />
    * if post is set to new (through the flag parameter or its postid
    * being 0), the data is inserted as a new row in the table. otherwise the
    * database is updated with the current data.
    *
    * @param  boolean $force_new New post flag
    * @param  boolean $errflag   Return success state flag
    * @return void
    */
   function updateDB($force_new = FALSE, $errflag = FALSE) {

      // data cleanup
      $time     = $this->time;
      $content  = addslashes($this->content);
      $comments = $this->comments_count;

      // is it new?
      $new = (($force_new) or ($this->postid <= 0));
      
      // sql preperation
      switch ($new) {
         case FALSE: // existing post
            $sql = 'UPDATE `+posts` SET `time`=\''.$time.'\', '
                                     .'`content`=\''.$content.'\', '
                                     .'`comments_count`=\''.$comments.'\' '
                                     .'WHERE `postid`=\''.$this->postid.'\'';
            break;
         case TRUE: // new post
            if ($force_new) {
               $postid = $this->postid;
            } else {
               $postid = '';
            }

            $sql = 'INSERT INTO `+posts`(`postid`,`time`,`content`,'
                                       .'`comments_count`) '
                  .'VALUES(\''.$postid.'\', \''.$time.'\', \''.$content.'\', \''
                  .$comments.'\')';
            break;
      }

      // db query
      if ($this->site->db->query($sql)) {
         if (($new) and (!$force_new)) { // new post
            $this->postid = $this->site->db->insert_id();
         }
         return TRUE;
      } else {
         if ($errflag) {
            return FALSE;
         } else {
            $this->site->displayError('post->updateDB()',
                                      $this->site->db->error());
         }
      } // if
      
   } // updateDB()


   /**
    * Remove post
    *
    * Removes post and all comments to it from the database, then
    * unsets the object instance.
    *
    * @document $errflag
    * @return void
    */
   function remove($errflag = FALSE) {

      $sql = 'DELETE FROM `+posts` WHERE `postid`=\''.$this->postid.'\'';

      if ($this->site->db->query($sql)) {
         // remove comments!
         $sql = 'DELETE FROM `+comments` '
               .'WHERE `postid`=\''.$this->postid.'\'';
         if (!$this->site->db->query($sql)) {
            if ($errflag) {
               return FALSE;
            } else {
               $this->site->displayError('post->remove() [II]',
                                         $this->site->db->error());
            }
         }

         return TRUE;

      } else {
         if ($errflag) {
            return FALSE;
         } else {
            $this->site->displayError('post->remove() [I]',
                                      $this->site->db->error());
         }
      } // if

   } // _Post()



   /**
    * Get attribute value
    *
    * Returns the value of a given tag in the post's content field, using our
    * pseudo-XML style of storage.<br />
    * If many results found, returns an array of all of them.
    *
    * @param  string $what Tag name to look for.
    * @return mixed  Value of tag or array of values.
    */
   function getAttribute($what) {

      $what = strtolower($what);
      $regex = '/<'.$what.'>(.*?)<\/'.$what.'>/is';
      preg_match_all ($regex, $this->content, $matches);

      // didn't your momma tell you never to play with matches?
      $matches = $matches[1][0];

      return $matches;

   } // getAttribute()

   /**
    * Get post content
    *
    * Returns actual content of post, the text between the <text> tags in my
    * pseudo-XML content code.
    *
    * @return string Post text
    */
   function getContent() {

      return $this->getAttribute('text');

   } // getContent()

   /**
    * Get post title
    *
    * Returns post's optional title, the text between the <title> tags in my
    * pseudo-XML content code.
    *
    * @return string Post title
    */
   function getTitle() {

      return $this->getAttribute('title');

   } // getTitle()

   /**
    * Get allow comments flag
    *
    * Returns the post's setting of whether to allow users to post comments to
    * the story.<br />
    * This is set using the <allow_comments> tag in the content pseudo-XML code.
    *
    * It returns TRUE for any case the setting is different from "no", so you
    * can see the core system's default is "yes". Thus it is advisable for the
    * admin system to have its own default pre-defined by the user.
    *
    * @return boolean Whether to allow new comments.
    */
   function getAllowComments() {

      return ($this->getAttribute('allow_comments') != 'no');

   } // getAllowComments()

   /**
    * Get comment alert flag
    *
    * Returns the post's setting of whether to alert the webmaster (by e-mail
    * etc.) upon a new comment to the post.<br />
    * This is set using the <comment_alert> tag in the content pseudo-XML code.
    *
    * It returns TRUE for any case the setting is different from "no", so you
    * can see the core system's default is "yes". Thus it is advisable for the
    * admin system to have its own default pre-defined by the user.
    *
    * @return boolean Whether to alert upon new comment.
    */
   function getCommentAlert() {

      $set = $this->getAttribute('comment_alert');

      if (!empty($set)) {
         return ($set != 'no');
      } else { // use default value
         return ($this->site->getSetting('comment_alert') != 'no');
      }

   } // getCommentAlert()

   /**
    * Get post type
    *
    * Get the post's defined type.<br />
    * This is stored in the <type> tag in the content pseudo-XML code.
    *
    * An idea for using this is categorizing posts as articles, news, etc.
    *
    * @return string Post type definition
    */
   function getType() {

      return $this->getAttribute('type');

   } // getType()


   /**
    * Get post excerpt
    *
    * Returns the post's excerpt string.<br />
    * If one is defineded using an <excerpt> tag, use this.<br />
    * Otherwise, return a truncated version of the content.
    *
    * @param  string $length Length of truncated version.
    * @return string Post excerpt
    */
   function getExcerpt($length = 400) {

      $excerpt = $this->getAttribute('excerpt'); // tag?
      if (empty($excerpt)) { // use truncated content
         // strip tags
         $excerpt = strip_tags($this->getContent());
         // truncate
         if (strlen($excerpt) > $length) {
            $length -= 3;	
            $excerpt = preg_replace('/\s+?(\S+)?$/', '',
                                    substr($excerpt, 0, $length+1));

            $excerpt = substr($excerpt, 0, $length).'...';
         }
      }
      return $excerpt;

   } // getExcerpt()

   /**
    * Get previous postid
    *
    * Returns the postid of the post previous to the current one, if available.
    *
    * @return int Previous postid
    */
   function getPrev() {

      $sql = 'SELECT `postid` '
            .'FROM `+posts` '
            .'WHERE `postid`<\''.$this->postid.'\' '
            .'ORDER BY `postid` DESC';
      if ($q = $this->site->db->query($sql)) {
         $d = $this->site->db->fetch_row($q);
         return $d[0];
      } else {
         return FALSE;
      }

   } // getPrev()

   /**
    * Get next postid
    *
    * Returns the postid of the post next to the current one, if available.
    *
    * @return int Next postid
    */
   function getNext() {

      $sql = 'SELECT `postid` '
            .'FROM `+posts` '
            .'WHERE `postid`>\''.$this->postid.'\' '
            .'ORDER BY `postid`';
      if ($q = $this->site->db->query($sql)) {
         $d = $this->site->db->fetch_row($q);
         return $d[0];
      } else {
         return FALSE;
      }

   } // getNext()


   /**
    * Fetch post comments
    *
    * Gets all parent comments to the current post from the database, creates
    * Comment objects using the data and returns an array of all of them.
    *
    * @return Array of post's comments (As Comment instances). If failed,
    *         returns FALSE.
    */
   function fetchComments() {

      $sql = 'SELECT `commentid`, `parentid`, `comment`, `time`, '
            .'`name`, `email`, `url`, `ip`, `postid` '
            .'FROM `+comments` '
            .'WHERE `postid`=\''.$this->postid.'\' '
            .'AND `parentid`=\'0\''
            .'ORDER BY `commentid`';
      
      if ($q = $this->site->db->query($sql)) {
         $result = array();
         while ($data = $this->site->db->fetch_assoc($q)) {
            $comment = new Comment($this);
            $comment->fetch_from_array($data);
            $result[] = $comment;
         }
         return $result;
      } else {
         return FALSE;
      }

   } // fetchComments()


   /**
    * Display comments
    *
    * Displays a comments page with all the comments to the current post,
    * using the appropriate templates.
    *
    * If $reply is TRUE, the requested page is a "reply" page, which enables
    * the user to reply to a certain comment. In that case the parent comment
    * is presented, and then a reply form.
    *
    * Otherwise, all comments are printed with deep-commenting enabled, and
    * a "reply to story" form is displayed at the bottom of the page.
    *
    * @param boolean $reply Was a reply page requested?
    * @param  int     $commentid If a reply page was requested, this will
                                 contain the parent comment's id.
    * @param  string  $style     CSS stylesheet to use.
    * @return void
    */
   function displayComments($reply = FALSE, $commentid = 0) {
      
      $cookie = $this->site->detailsCookie();

      $this->site->smarty->assign('site',   $this->site);
      $this->site->smarty->assign('post',   $this);
      $this->site->smarty->assign('cookie', $cookie);

      if (!$reply) {
         $this->site->smarty->display('comments/allcomments.tpl');
      } else {
         $parent = new Comment($this);
         $parent->fetch_from_db($commentid);

         $this->site->smarty->assign('parent', $parent);
         $this->site->smarty->display('comments/reply.tpl');
      }
      
   } // displayComments()


   /**
    * Disaply post
    *
    * Displays a single post using the appropriate templates.
    *
    * @return void
    */
   function display() {
   
      $cookie = $this->site->detailsCookie();
      
      $this->site->smarty->assign('cookie', $cookie);
      $this->site->smarty->assign('post',  $this);
      $this->site->smarty->display('anchor.tpl');
      
   } // display()
   
} // Post

/* Simba says Roar! */ ?>
