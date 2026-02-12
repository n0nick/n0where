<?php
/**
 * Comment class
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
 * Comment class
 *
 * Manages a single comment to a post in the weblog.<br />
 * The class represents a comment to a post in the weblog, and handles all
 * operations related to it.
 *
 * @package n0where
 * @author Sagie Maoz <n0nick@php.net>
 * @copyright Sagie Maoz, 2003
 * @version 1.0
 */
class Comment {

   /**
    * Post
    *
    * Instance of the parent post.
    *
    * @var Site
    */
   var $post;

   /**
    * Comment ID
    *
    * Comment's serial identification number.
    *
    * @var int
    */
   var $commentid = 0;
   /**
    * Parent comment's id
    *
    * Commentid of the parent comment.
    *
    * @var int
    */
   var $parentid  = 0;
   /**
    * Content
    *
    * Comment content.
    *
    * @var string
    */
   var $comment   = '';
   /**
    * Time
    *
    * Comment's publish date and time, in Unix timestamp format
    * (seconds since Epoch).
    *
    * @var int
    */
   var $time      = 0;
   /**
    * Poster name
    *
    * Name of the person who posted the comment.
    *
    * @var string
    */
   var $name      = '';
   /**
    * Poster e-mail
    *
    * E-mail address of the person who posted the comment.
    *
    * @var string
    */
   var $email     = '';
   /**
    * Poster URL
    *
    * URL for the homepage of the person who posted the comment.
    *
    * @var string
    */
   var $url       = '';
   /**
    * Poster IP
    *
    * IP Address of the person who posted the comment.
    *
    * @var string
    */
   var $ip        = '';
   /**
    * Post ID
    *
    * Postid of the parent story.
    *
    * @var int
    */
   var $postid    = 0;

   /**
    * Comment constructor
    *
    * Constructs instance of a comment, using the values of parameters passed
    * as properties values.
    *
    * @param Post   $post      Instance of the parent post.
    * @param int    $commentid Comment identification number
    * @param int    $parentid  Parent comment's id
    * @param string $comment   Comment content
    * @param int    $time      Comment publish date
    * @param string $name      Poster name
    * @param email  $email     Poster e-mail address
    * @param string $url       Poster homepage URL
    * @param ip     $ip        Poster IP address
    * @param int    $postid    Parent story's id
    * @return void
    */
   function Comment($post, $commentid = 0, $parentid = 0, $comment = '',
                    $time = 0, $name = '', $email = '', $url = '', $ip = '',
                    $postid = 0) {

      $this->post      = $post;

      $this->commentid = $commentid;
      $this->parentid  = $parentid;
      $this->comment   = $comment;
      $this->time      = $time;
      $this->name      = $name;
      $this->email     = $email;
      $this->url       = $url;
      $this->ip        = $ip;
      $this->postid    = $postid;

   } // Comment()


   /**
    * Fetch comment data from DB
    *
    * Requests comment data from the database, by the commentid given. If no
    * commentid is passed, the current object's {@link $commentid} value is
    * used.
    *
    * @see fetch_from_array
    * @param  int     $postid Comment id (if empty, object's current commentid
                              is used)
    * @return void
    */
   function fetch_from_db($commentid = '%') {

      if ($commentid == '%') { $commentid = $this->commentid; }

      // sql preperation
      if ($commentid != 0)   { $where = '`commentid`=\''.$commentid.'\''; }
      else                   { $where = '1';                              }
      $sql  = 'SELECT `commentid`, `parentid`, `comment`, `time`, `name`, '
             .'`email`,`url`,`ip`,`postid` '
             .'FROM `+comments` '
             .'WHERE '.$where.' '
             .'ORDER BY `commentid` DESC';
      
      // db query
      $q = $this->post->site->db->query($sql)
         or $this->post->site->displayError('comment->fetch_from_db()',
                                            $this->post->site->db->error());

      $data = $this->post->site->db->fetch_assoc($q);
      $this->fetch_from_array($data);

   } // fetch_from_db()


   /**
    * Fetch comment data from an array
    *
    * Uses the data array parameter passed, to set the object's properties
    * values.<br />
    * The data array should be an associative array with the keys:<br />
    * 'commentid', 'parentid', 'comment', 'time', 'name', 'email', 'url', 'ip',
    * 'sid'.
    *
    * @param  array $data Data array retrieved from database query
    * @return void
    */
   function fetch_from_array($data) {

      if (!$this->validAddress($data['email'])) { $data['email'] = ''; }

      // data cleanup
      $data['comment'] = stripslashes($data['comment']);
      $data['name']    = stripslashes($data['name']);
      $data['email']   = stripslashes($data['email']);
      $data['url']     = stripslashes($data['url']);
      $data['ip']      = stripslashes($data['ip']);
      $data['time']+= 3600*$this->post->site->config['settings']['time_offset'];

      $this->Comment($this->post,
                     @$data['commentid'],
                     @$data['parentid'],
                     @$data['comment'],
                     @$data['time'],
                     @$data['name'],
                     @$data['email'],
                     @$data['url'],
                     @$data['ip'],
                     @$data['postid']);

   } // fetch_from_array()


   /**
    * Update database
    *
    * Updates the comments table in the database with the current object's
    * properties.<br />
    * if comment is set to new (through the flag parameter or its commentid
    * being 0), the data is inserted as a new row in the table. otherwise the
    * database is updated with the current data.
    *
    * @param  boolean $force_new new comment flag
    * @return void
    */
   function updateDB($force_new = FALSE) {

      // data cleanup
      $comment  = addslashes($this->comment);
      $time     = $this->time;
      $name     = addslashes($this->name);
      $email    = addslashes($this->email);
      $url      = addslashes($this->url);
      $ip       = addslashes($this->ip);

      // is it new?
      $new = (($force_new) or ($this->commentid <= 0));
      
      // sql preperation
      switch ($new) {
         case FALSE: // existing comment
            $sql = 'UPDATE `+comments` SET `parentid`=\''.$this->parentid.'\', '
                                        .'`comment`=\''.$comment.'\', '
                                        .'`time`=\''.$time.'\', '
                                        .'`name`=\''.$name.'\', '
                                        .'`email`=\''.$email.'\', '
                                        .'`url`=\''.$url.'\', '
                                        .'`ip`=\''.$ip.'\', '
                                        .'`postid`=\''.$this->postid.'\' '
                  .'WHERE `commentid`=\''.$this->commentid.'\';';
            break;
         case TRUE: // new comment
            if ($force_new) {
               $commentid = $this->commentid;
            } else {
               $commentid = '';
            }
            
            /* using Asikmet PHP5 class to filter spam comments      
            $akismet = new Akismet($this->post->site->url,
                                   $this->post->site->getSetting('wordpress_api'));
            $akismet->setAuthor($name);
            $akismet->setAuthorEmail($email);
            $akismet->setAuthorURL($url);
            $akismet->setContent($comment);
            $akismet->setPermalink($this->post->site->getLink('post',$this->postid));
            
            if($akismet->isSpam()) { // flagged as spam
              $spam = 1;
            } else { // regular comment
              $spam = 0;
            }*/ $spam = 0;
            
            // sql sentence
            $sql = 'INSERT INTO `+comments` (`commentid`,`parentid`,`comment`,'
                  .'`time`,`name`,`email`,`url`,`ip`,`postid`,`spamflag`) '
                  .'VALUES(\''.$commentid.'\', \''.$this->parentid.'\', \''
                  .$comment.'\', \''.$time.'\', \''
                  .$name.'\', \''.$email.'\', \''.$url
                  .'\', \''.$ip.'\', \''.$this->postid.'\',\''.$spam.'\')';
            break;
      } // switch
    

      // db query
      $this->post->site->db->query($sql)
         or $this->post->site->displayError('comment->updateDB()',
                                            $this->post->site->db->error());

      if (($new) and (!$force_new)) { // new comment
         $this->commentid = $this->post->site->db->insert_id();
      }

   } // updateDB()


   /**
    * Remove comment
    *
    * Removes comment and all comments to it from the database, then
    * unsets the object instance.<br />
    * Also updates the parent post's comments count.
    *
    * @param  int $count Current post's comments count.
    *                    This is for the recourse.
    * @return int parent post's comments count
    */
   function remove($count='%') {

      if ($count == '%') { $count = $this->post->comments_count; }

      // recoursively remove children comments
      $sql = 'SELECT `commentid` FROM `+comments` WHERE '
            .'`parentid`=\''.$this->commentid.'\' ORDER BY `commentid`';

      $q   = $this->post->site->db->query($sql);

      while ($data = $this->post->site->db->fetch_row($q)) {
         $cmt   = new Comment($this->post,$data[0]);
         $count = $cmt->remove($count-1);
      }

      // remove post
      $sql = 'DELETE FROM `+comments` WHERE `commentid`=\''.$this->commentid
            .'\'';
      $this->post->site->db->query($sql)
         or $this->post->site->displayError('comment->remove() [I]',
                                            $this->post->site->db->error());

      if ($this->post->site->db->affected_rows()<=0) { // not deleted !!
         $this->post->site->displayError('comment->remove() [II]', 
                                         'Somehow the comment wasn\'t deleted.');
      }

      // return post's comments count (actually this has 1 too many)
      return $count;

    } // _Comment()



   /**
    * Inform upon comment
    *
    * Sends a notification e-mail to the webmaster, upon a new comment posted
    * to a story in the weblog.
    *
    * @see Site::$inform_comment
    * @return void
    * @todo make all parts of the mail() call templatable. so users can set
    *       their own subject string, headers strigns etc.
    */
   function inform() {
	    $this->post->site->smarty->assign('commentid',$this->commentid);
      $this->post->site->smarty->assign('user',     $this->name);
      $this->post->site->smarty->assign('postid',   $this->postid);
      $this->post->site->smarty->assign('comment',  $this->comment);
      $this->post->site->smarty->assign('site',     $this->post->site);

      $mail = $this->post->site->smarty->fetch('comments/mail.tpl');

      $succ =  mail($this->post->site->email,
                  'New comment on story #'.$this->postid,
                  $mail,
                  'From: '.$this->post->site->webmaster
                 .'<'.$this->post->site->email.'>'."\r\n"
                 .'Content-Type: text/plain; charset=utf-8'."\r\n"
                 .'X-Mailer: n0where')
         or $this->post->site->displayError('comment->inform()',
                                            "Couldn't send mail.\r\n"
                 .'Probably a PHP error with the configured SMTP server.');

   } // inform()


   /**
    * Fetch child comments
    *
    * Gets all direct children of current comment from the database, creates
    * Comment objects using this data and returns an array of all of them.
    *
    * @return Array of children comments (As Comment instances).
    */
   function fetchChildren($desc=FALSE) {
      $sql = 'SELECT `commentid`, `parentid`, `comment`, `time`, '
            .'`name`, `email`, `url`, `ip`, `postid` FROM `+comments` '
            .'WHERE (`postid`=\''.$this->postid.'\' '
            .'AND `parentid`=\''.$this->commentid.'\') '
            .'ORDER BY `commentid`';
      if ($desc) { $sql .= ' DESC'; }
      
      $q = $this->post->site->db->query($sql)
         or $this->post->site->displayError('comment->fetchChildren()',
                                            $this->post->site->db->error());

      $children = array();
      while ($data = $this->post->site->db->fetch_assoc($q)) {
         $cmt = new Comment($this->post);
         $cmt->fetch_from_array($data);
         $children[] = $cmt;
      } // while

      return $children;
   } // fetchChildren

   /**
    * Validate e-mail address
    *
    * Validates a given e-mail address using a very simple regular expression.
    * I didn't see a need for any socket connections or such.<br />
    * If no address is given, comment's email is assumed.
    *
    * @param  string  $email E-mail address to validate
    * @return boolean Whether address is valid
    * @author russlndr
    * @link http://www.zend.com/codex.php?id=371&single=1
    */
   function validAddress($email = '') {
      if (empty($email)) { $email = $this->email; }

      return preg_match("/^[a-z0-9\._-]+@+[a-z0-9\._-]+\.+[a-z]{2,3}$/i", $email);
   }

} // Comment


/* Simba says Roar! */ ?>
