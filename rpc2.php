<?php
/**
 * XML-RPC server handling Blogger API functions
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
 * @subpackage xmlrpc
 * @author Sagie Maoz <n0nick@php.net>
 * @copyright Sagie Maoz, 2003
 * @version 1.0
 * @link http://www.blogger.com/developers/api/
 *
 */

/*           WARNING
     messy code ahead of you
          scoll carefuly !     */

require_once('inc/include.inc.php');
require_once('inc/IXR_Library.inc.php');

// create site object according to location
if (stristr(getenv('HTTP_HOST'),'n0nick.net')) {
   $site = new Site('inc/dreamhost.ini.php');
} else {
   $site = new Site('inc/local.ini.php');
}
global $site;


/**
 * Send debug message
 *
 * Logs the content of a given variable.
 *
 * @param  string  $x Variable to log
 * @return void
 */
function debug_msg($x) {
    $f = fopen('debug.txt','a');
    ob_start();
    print_r($x);
    $o = ob_get_contents();
    ob_clean();
    fputs($f,$o."\r\n");
    fclose($f);
} // debug_msg()


/**
 * New post
 *
 * This function creates a new post and optionally publishes it.
 *
 * @param  array  $args (in appkey string, in blogid string, in username string,
 *                 in password string, in content string, in publish boolean)
 * @return string Upon success this will return: "postid" string - ID of the
 *                new post. Upon failure, the fault will be returned.
 * @link   http://docs.openlinksw.com/virtuoso/fn_blogger.newPost.html
 */
function newPost($args) {
   global $server, $site;

   $password = $args[3];
   $content  = $args[4];

   if (!is_string($content)) {
      $server->error(8002, 'Wrong type for content.');
   } else if ($password === $site->ad_pass) {
      // get title tag
      $title = eregi ('<title>((.*\n*)*)</title>', $content, $matches);
      $title = @$matches[1]; $matches = 0;

      // get template tag
      $template = eregi ('<template>((.*\n*)*)</template>', $content, $matches);
      $template = @$matches[1]; $matches = 0;
      if (!$template) $template = $site->getSetting('defskin'); // default value

      // get comments tags
      $allowcomments = eregi('<allow_comments>((.*\n*)*)</allow_comments>',$content,$matches);
      $allowcomments = @$matches[1]; $matches = 0;
      if (!$allowcomments)
         $allowcomments = $site->getSetting('allow_comments'); // default value

      $commentalert = eregi('<comment_alert>((.*\n*)*)</comment_alert>',$content,$matches);
      $commentalert = @$matches[1]; $matches = 0;
      if (!$commentalert)
         $commentalert = $site->getSetting('comment_alert'); // default value

      // remove tags
      $content = eregi_replace('<title>((.*\n*)*)</title>', '', $content);
      $content = eregi_replace('<template>((.*\n*)*)</template>', '', $content);
      $content = eregi_replace('<allow_comments>((.*\n*)*)</allow_comments>', '', $content);
      $content = eregi_replace('<comment_alert>((.*\n*)*)</comment_alert>', '', $content);

      // build xml body
      $content = '<title>'.$title.'</title>'."\n"
                .'<text>'.$content.'</text>'."\n"
                .'<template>'.$template.'</template>'."\n"
                .'<allow_comments>'.$allowcomments.'</allow_comments>'."\n"
                .'<comment_alert>'.$commentalert.'</comment_alert>';

      // create post instance and insert it
      $post = new Post($site,0,time(),$content,0);
      if ($post->updateDB(FALSE, TRUE)) {
         return "$post->postid";
      } else { // mysql error
         $server->error(8004, 'Database error.');
      }
   } else {
      $server->error(8000, 'Wrong password given.');
   }
} // newPost()


/**
 * Delete post
 *
 * This function deletes a post from the server.
 *
 * @param  array  $args (in appkey string, in postid string, in username string,
 *                       in password string)
 * @return string Upon success this will return a boolean true value. Upon
 *                failure, the fault will be returned.
 * @link   http://docs.openlinksw.com/virtuoso/fn_blogger.deletePost.html
 */
function deletePost($args) {
   global $server, $site;

   $postid   = $args[1];
   $password = $args[3];

   if ($password === $site->ad_pass) {
      $post = new Post($site,$postid);
      if ($post->remove(TRUE)) {
         return TRUE;
      } else { // mysql error
         $server->error(8004, 'Database error.');
      }
   } else {
      $server->error(8000, 'Wrong password given.');
   }
} // deletePost()


/**
 * Edit post
 *
 * This function edits an existing post and optionally publishes it.
 *
 * @param  array  $args (in appkey string, in postid string, in username string,
 *                       in password string, in content string,
 *                       in publish boolean)
 * @return string Upon success this will return a boolean true value. Upon
 *                failure, the fault will be returned.
 * @link   http://docs.openlinksw.com/virtuoso/fn_blogger.editPost.html
 */
function editPost($args) {
   global $server, $site;

   $postid   = $args[1]+0;
   $password = $args[3];
   $content  = $args[4];

   if (!is_string($content)) {
      $server->error(8002, 'Wrong type for content.');
   } else if ($password === $site->ad_pass) {
      // i'm doing this slow so untouched values are rescued
      $post = new Post($site);
      if ($post->fetch_from_db($postid, TRUE)) {
         // keep unknown values
         $oldcontent = $post->content;
         $oldtitle = '<title>'   .$post->getTitle()  .'</title>';
         $oldtext  = '<text>'    .$post->getcontent().'</text>';
         $oldtpl   = '<template>'.$post->getAttribute('template').'</template>';
         $oldallow = '<allow_comments>'.$post->getAttribute('allow_comments').'</allow_comments>';
         $oldalert = '<comment_alert>'.$post->getAttribute('comment_alert').'</comment_alert>';

         $oldcontent = str_replace($oldtitle, '', $oldcontent);
         $oldcontent = str_replace($oldtext,  '', $oldcontent);
         $oldcontent = str_replace($oldtpl,   '', $oldcontent);
         $oldcontent = str_replace($oldallow, '', $oldcontent);
         $oldcontent = str_replace($oldalert, '', $oldcontent);

         // get title tag
         $title = eregi ('<title>((.*\n*)*)</title>', $content, $matches);
         $title = @$matches[1]; $matches = 0;

         // get template tag
         $template = eregi('<template>((.*\n*)*)</template>',$content,$matches);
         $template = @$matches[1]; $matches = 0;
         if (!$template)
            $template = $post->getAttribute('template'); // old value

         // get comments tags
         $allowcomments = eregi('<allow_comments>((.*\n*)*)</allow_comments>',$content,$matches);
         $allowcomments = @$matches[1]; $matches = 0;
         if (!$allowcomments)
            $allowcomments = $site->getSetting('allow_comments'); // default value

         $commentalert = eregi('<comment_alert>((.*\n*)*)</comment_alert>',$content,$matches);
         $commentalert = @$matches[1]; $matches = 0;
         if (!$commentalert)
            $commentalert = $site->getSetting('comment_alert'); // default value

         // remove tags
         $text = eregi_replace('<title>((.*\n*)*)</title>', '', $content);
         $text = eregi_replace('<template>((.*\n*)*)</template>', '', $text);
         $text = eregi_replace('<allow_comments>((.*\n*)*)</allow_comments>', '', $text);
         $text = eregi_replace('<comment_alert>((.*\n*)*)</comment_alert>', '', $text);

         $content = '<title>'   .$title   .'</title>'   ."\n"
                   .'<text>'    .$text    .'</text>'    ."\n"
                   .'<template>'.$template.'</template>'."\n"
                   .'<allow_comments>'.$allowcomments.'</allow_comments>'."\n"
                   .'<comment_alert>' .$commentalert .'</comment_alert>' ."\n"
                   .trim($oldcontent);

         $post->content = $content;

         if ($post->updateDB(FALSE, TRUE)) {
            return TRUE;
         } else {
            $server->error(8004, 'Database error.');
         }
      } else {
         $server->error(8004, 'Database error.');
      }
   } else {
      $server->error(8000, 'Wrong password given.');
   }
} // editPost()


/**
 * Get post
 *
 * This function retrieves an existing post from the server.
 *
 * @param  array  $args (in appkey string, in blogid string, in postid string,
 *                       in username string, in password string)
 * @return string Upon success this will return the content of the post. Upon
 *                failure, the fault will be returned.
 * @link   http://docs.openlinksw.com/virtuoso/fn_blogger.getPost.html
 */
function getPost($args) {
    global $server, $site;

    $postid   = $args[1]+0;
    $password = $args[3];

    if ($password === $site->ad_pass) {
        $post = new Post($site);
        $post->fetch_from_db($postid);

        // error occured?
        if ($post->postid <= 0) {
            $server->error(8003, 'No post found.');
        }

        $content =  '<title>'.$post->getTitle().'</title>'.$post->getContent();
        $content .= '<template>'.$post->getAttribute('template').'</template>';
        $content .= '<allow_comments>'.$post->getAttribute('allow_comments').'</allow_comments>';
        $content .= '<comment_alert>'.$post->getAttribute('comment_alert').'</comment_alert>';

        $return = array('dateCreated' => $post->time,
                        'userid'  => 1,
                        'blogid'  => 1,
                        'content' => $content);
        return $return;
    } else {
        $server->error(8000, 'Wrong password given.');
    }
} // getPost()


/**
 * Get recent posts
 *
 * This function retrieves a list of the most recent posts on the server.
 *
 * @param  array  $args (in appkey string, in blogid string, in username string,
 *                       in password string, in numberOfPosts integer)
 * @return string Upon success this will return an array of structs containing:
 * <code>{
 *    "dateCreated"  ISO.8601 date string
 *    "userid"       string 	
 *    "postid"       string  
 *    "content"      string  
 * }</code>
 *                Upon failure, the fault will be returned.
 * @link   http://docs.openlinksw.com/virtuoso/fn_blogger.getRecentPosts.html
 */
function getRecentPosts($args) {
    global $server, $site;

    $password   = $args[3];
    $numOfPosts = $args[4]+0;

    if ($password === $site->ad_pass) {
        $posts = $site->getRecentPosts($numOfPosts);

        $return = array();

        foreach ($posts as $post) {
            $content='<title>'.$post->getTitle().'</title>'.$post->getContent();
            $content.="\n".'<template>'.$post->getAttribute('template').'</template>';

            $time = new IXR_Date($post->time);

            $return[] = array('dateCreated' => $time->getIso(), // @TODO this ain't right
                              'userid'      => 1,
                              'postid'      => $post->postid,
                              'content'     => $content);
        }
        return $return;
    } else {
        $server->error(8000, 'Wrong password given.');
    }
} // getRecentPosts()


/**
 * Get users blogs
 *
 * This function retrieves a list of weblogs for which a user has posting
 * privileges.
 *
 * @param  array  $args (in appkey string, in username string,
 *                       in password string)
 * @return string Upon success this will return an array of structs containing:
 * <code>{
 *    "url"          string
 *    "blogid"       string
 *    "blogName"     string
 * }</code>
 *                Upon failure, the fault will be returned.
 * @link   http://docs.openlinksw.com/virtuoso/fn_blogger.getUsersBlogs.html
 */
function getUsersBlogs($args) {
    global $server, $site;

    $password = $args[2];

    if ($password === $site->ad_pass) {
        return array(array('blogid'   => '1',
                           'blogName' => $site->name,
                           'url'      => $site->url));
    } else {
        $server->error(8000, 'Wrong password given.');
    }
} // getUsersBlogs()


/**
 * Get user info
 *
 * This function retrieves information about a blog author.
 *
 * @param  array  $args (in appkey string, in username string,
 *                       in password string)
 * @return string Upon success this will return a struct containing:
 * <code>{
 *    string userid
 *    string firstname
 *    string lastname
 *    string nickname
 *    string email
 *    string url
 * }</code>
 *                Upon failure, the fault will be returned.
 * @link   http://docs.openlinksw.com/virtuoso/fn_blogger.getUserInfo.html
 */
function getUserInfo($args) {
    global $server, $site;

    $password   = $args[2];

    if ($password === $site->ad_pass) {
        return array('nickname'  => $site->webmaster,
                     'userid'    => 1,
                     'url'       => $site->url,
                     'email'     => $site->email,
                     'lastname'  => '',
                     'firstname' => '');
    } else {
        $server->error(8000, 'Wrong password given.');
    }
} // getUserInfo()


/**
 * Get template
 *
 * This function retrieves the content of the requested template.
 *
 * @param  array  $args  (in appkey string, in blogid string,
 *                        in username string, in password string,
 *                        in templateType string)
 * @return string Upon success this will return the string of the content of the
 *                template. Upon failure, the fault will be returned.
 * @link   http://docs.openlinksw.com/virtuoso/fn_blogger.getTemplate.html
 * @deprecated    I do not support Blogger-type templates.
 */
function getTemplate($args) {
    global $server;

    $server->error(8001, 'Unsupported method.');
} // getTemplate()


/**
 * Set template
 *
 * This function sets the content of the specfied template.
 *
 * @param  array  $args (in appkey string, in blogid string, in username string,
 *                       in password string, in template string,
 *                       in templateType string)
 * @return string Upon success this will return the bollean true value. Upon
 *                failure, the fault will be returned.
 * @link   http://docs.openlinksw.com/virtuoso/fn_blogger.setTemplate.html
 * @deprecated    I do not support Blogger-type templates.
 */
function setTemplate($args) {
    global $server;

    $server->error(8001, 'Unsupported method.');
} // setTemplate()


/* SERVER CODE */

// create server
$server = new IXR_IntrospectionServer();
global $server;
// Now add the callbacks along with their introspection details
$server->addCallback(
    'blogger.newPost',
    'newPost',
    array('string', 'string', 'string', 'string', 'string', 'string',
          'boolean'),
    'This function creates a new post and optionally publishes it.'
);
$server->addCallback(
    'blogger.editPost',
    'editPost',
    array('string', 'string', 'string', 'string', 'string', 'string',
          'boolean'),
    'This function edits an existing post and optionally publishes it.'
);
$server->addCallback(
    'blogger.deletePost',
    'deletePost',
    array('string', 'string', 'string', 'string', 'string', 'boolean'),
    'This function deletes a post from the server.'
);
$server->addCallback(
    'blogger.getRecentPosts',
    'getRecentPosts',
    array('string', 'string', 'string', 'string', 'string', 'int'),
    'This function retrieves a list of the most recent posts on the server.'
);
$server->addCallback(
    'blogger.getPost',
    'getPost',
    array('string', 'string', 'string', 'string', 'string'),
    'This function retrieves an existing post from the server.'
);
$server->addCallback(
    'blogger.getUsersBlogs',
    'getUsersBlogs',
    array('struct', 'string', 'string', 'string'),
    'This function retrieves a list of weblogs for which a user has posting '
   .'privileges.'
);
$server->addCallback(
    'blogger.getUserInfo',
    'getUserInfo',
    array('struct', 'string', 'string', 'string'),
    'This function retrieves information about a blog author.'
);
$server->addCallback(
    'blogger.getTemplate',
    'getTemplate',
    array('string', 'string', 'string', 'string', 'string', 'string'),
    '(UNSUPPORTED) This function retrieves the content of the requested '
   .'template.'
);
$server->addCallback(
    'blogger.setTemplate',
    'setTemplate',
    array('string', 'string', 'string', 'string', 'string', 'string', 'string'),
    '(UNSUPPORTED) This function sets the content of the specfied template.'
);

// And serve the request
$server->serve();

/* Simba says Roar! */ ?>
