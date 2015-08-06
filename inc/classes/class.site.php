<?php
/**
 * Site class
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
 * Site class
 *
 * The class stores all website's configurations and handles all general
 * operations, including getting and processing user calls, whether page
 * requests or form submissions.
 *
 * @package n0where
 * @author Sagie Maoz <n0nick@php.net>
 * @copyright Sagie Maoz, 2003
 * @version 1.0
 */
class Site {
   
   /**
    * Database instance
    *
    * An instance of the {@link Database} class, for sending queries 
    * and receiving results.
    *
    * @var Database
    */
   var $db;

   /**
    * Settings array
    *
    * Array of configuration settings as fetched from the config file.
    *
    * @see fetchConfig
    * @var array
    */
   var $config;

   /**
    * Website's name
    *
    * The weblog name.
    *
    * The name of the weblog that will appear in pages describing it, and when
    * services such as the RSS feed or the XML-RPC server are requested for
    * the site's name.
    *
    * @var string
    */
   var $name;
   /**
    * Website's title
    *
    * The weblog page title.
    *
    * @var string
    */
   var $title;
   /**
    * Website's slogan
    *
    * A short unique sentence describing the weblog.
    * Could be anything really.
    *
    * @var string
    */
   var $slogan;
   /**
    * Website's URL
    *
    * The direct URI to the website's root directory.
    * A trailing slash is recommended.
    *
    * @var string
    */
   var $url;
   /**
    * Website path
    *
    * The full <b>exact</b> path to the website, excluding the trailing slash.
    *
    * @var string
    */
   var $path;
   /**
    * User theme
    *
    * Layout theme for the blog. This means the name of the subdirectory under
    * templates/ which contains all relevant .tpl files, and also the
    * subdirectory under styles/ containing all relevant stylesheets.
    */
   var $theme;

   /**
    * Webmaster's name
    *
    * The name of the blogger behind the website.
    * Prefferably the nickname, a short English word or two.
    *
    * @var string
    */
   var $webmaster;
   /**
    * Webmaster's E-mail address
    *
    * A valid E-mail address of the webmaster.
    * Will be encoded, so don't worry.
    *
    * @var string
    */
   var $email;

   /**
    * Admin password
    *
    * The administrator's password requested before every important operation.
    * Choose carefuly.
    *
    * @var string
    */
   var $ad_pass;
   
   /**
    * Emoticons
    *
    * The associative array stores all the emoticon codes and filenames, as
    * fetched from the comments.cfg file.
    *
    * @var array
    * @see prepareEmoticons
    * @see replaceEmoticons
    * @access private
    */
   var $emoticons;
   /**
    * Emoticons size
    *
    * A string defining the emoticon's images width and height, as fetched
    * from the comments.cfg file.
    *
    * @var string
    * @see prepareEmoticons
    * @see replaceEmoticons
    * @access private
    */
   var $emoticons_size;
   /**
    * Emoticons keys
    *
    * All emoticons code strings.
    *
    * @var string
    * @see prepareEmoticons
    * @see replaceEmoticons
    * @access private
    */
   var $emoticons_keys;
   /**
    * Emoticons files
    *
    * All emoticons image tags.
    *
    * @var string
    * @see prepareEmoticons
    * @see replaceEmoticons
    * @access private
    */
   var $emoticons_files;

   /**
    * Load start time
    *
    * The time (Unix timestamp - seconds since epoch) of the page's first
    * load, for benchmarking issues.
    *
    * @var string
    * @see startBenchmark
    * @see getBenchmark
    * @access private
    */   
   var $start_time;

   /**
    * Display what
    *
    * An array that tells the system what page it should display.
    *
    * The first value is the page name.<br />
    * Can be one of the following:<br />
    * anchor, post, archive, about, comments, rss, admin
    *
    * The second value contains the parameter(s) passed to the specific page.
    * Depending on the page type, this can be the post id, archive month, etc.
    *
    * @var array
    * @see display
    */      
   var $display;
   
   /**
    * Smarty instance
    *
    * Instance of the Smarty class that manages all the website's templates
    * and output control.
    *
    * @var Smarty
    * @link http://smarty.php.net/
    * @access private
    */     
   var $smarty;
   
   /**
    * Site constructor
    *
    * Given all the settings values from the config file, the function sets
    * the values to all its settings preferences, on construct.
    *
    * It also starts the benchmarking process, prepares the emoticon variables
    * (using the emoticons.cfg), and then starts the Smarty service.
    *
    * @return void
    * @param string $configfile location of config settings .ini file
    */
   function Site($configfile) {

      $this->startBenchmark();

      $this->config = $this->fetchConfig($configfile);

      $this->db     = new Database($this->config['database']['hostname'],
                                   $this->config['database']['username'],
                                   $this->config['database']['password'],
                                   $this->config['database']['name'],
                                   $this->config['database']['prefix']);
      $dbc = $this->db->connect();
      if ($dbc !== TRUE) {
         $this->displayError('$site->Site',$dbc);
      }

      $this->name           = $this->config['website']['name'];
      $this->title          = $this->config['website']['title'];
      $this->slogan         = $this->config['website']['slogan'];
      $this->url            = $this->config['website']['url'];
      $this->path           = $this->config['website']['path'];
      $this->theme          = $this->config['website']['theme'];
      $this->webmaster      = $this->config['webmaster']['name'];
      $this->email          = $this->config['webmaster']['email'];
      $this->ad_pass        = $this->config['admin']['password'];
      
      $this->prepareEmoticons();
      
      $this->smarty = new Smarty;
      
      // smarty directories
      $this->smarty->template_dir = 'templates/'.$this->theme;
      $this->smarty->compile_dir  = 'templates_c';
      $this->smarty->config_dir   = 'configs';
      $this->smarty->cache_dir    = 'cache';
      
      // custom modifiers & functions
      /* my plugins: * modifier.linkalize.php
                     * modifier.autop.php
                     * modifier.hebdate.php
                     * modifier.n0tags.php
                     * function.mymailto.php   */
      
   } // Site()


   /**
    * Fetches settings from ini file
    *
    * Reads a standard INI file and builds a settings array.
    *
    * An INI file is built using this format:<br />
    * <code>[section]
    * settings = setting value
    * ; any comment at all</code>
    *
    * Each section is given a sub-array in the settings array.
    *
    * @param  string $configfile Location of .ini file
    * @return array  Associative array of settings
    */
   function fetchConfig($configfile) {

      $return  = array();
      $section = '';

      $configs = file($configfile);

      foreach ($configs as $config) {
         // remove comments
         $config = split(';',$config);
         $config = trim($config[0]);

         if (preg_match('/\[(.*)\]/', $config, $match)) { // new section
            $section = $match[1];
         } else {
            if (preg_match('/(.*)=(.*)/', $config, $match)) { // value
               $key   = trim($match[1]);
               $value = trim($match[2]);

               if ($section != '') {
                  $argh = &$return[$section];
               } else {
                  $argh = &$return;
               } // if

               $argh[$key] = $value;
            } // if
         } // if
      } // foreach

      return $return;

   } // fetchConfig()

   /**
    * Get setting
    *
    * Returns the set value of a setting from the [settings] section of the
    * config file.
    *
    * @param  string setting Setting's name
    * @return string Requested setting's value
    */
   function getSetting($setting) {
      return $this->config['settings'][$setting];
   }


   /**
    * Starts benchmark process
    *
    * Gets current exact time, down to the micro-seconds, and stores it in the
    * class's {@link start_time} variable.<br />
    * This will enable the benchmark process, by using this time variable when
    * the {@link getBenchmark} function is called.
    *
    * @return void
    * @see getBenchmark
    * @see start_time
    */
   function startBenchmark() {
      
      $microtime        = microtime();
      $microsecs        = substr($microtime, 2, 8);
      $secs             = substr($microtime, 11);
      $start_time       = $secs.'.'.$microsecs;
      $this->start_time = $start_time;
      
   } // startBenchmark()


   /**
    * Gets benchmark results
    *
    * By substracting the current time from the time stored when the page just
    * started loading (i.e. {@link start_time}), we get the exact time it took
    * the page to be processed and loaded.
    *
    * @return string Page load time
    * @see startBenchmark
    * @see start_time
    */
   function getBenchmark() {

      $start_time = $this->start_time;
      $microtime  = microtime();
      $microsecs  = substr($microtime, 2, 8);
      $secs       = substr($microtime, 11);
      $endTime    = $secs.'.'.$microsecs;
      return sprintf('%.2fs',$endTime-$start_time);

   } // getBenchmark()


   /**
    * Prepares emoticons
    *
    * Reads all emoticons' data from the emoticons.cfg file, and stores it in
    * the class's emoticon variables.
    *
    * @return void
    * @see $emoticons
    * @see $emoticons_size
    * @see $emoticons_keys
    * @see $emoticons_files
    * @see replaceEmoticons
    */
   function prepareEmoticons() {

      $emoticons_file = file('inc/emoticons.cfg');
      $this->emoticons_size = $emoticons_file[0];

      $emoticons      = array();
      $emoticon_keys  = array();
      $emoticon_files = array();

      foreach($emoticons_file as $emoticon) {
         // first line is the size setting
         if (($emoticon != $this->emoticons_size) and (trim($emoticon)) != '') {
            $foo = preg_split("/[\t]+/",$emoticon);

            $emoticons[$foo[0]] = trim(@$foo[1]);

            // these are neede for the replacement function.
            $emoticon_keys[]    = '/'.quotemeta(addslashes($foo[0])).'/';
            $emoticon_files[]   = '<img src="img/emoticons/'.$emoticons[$foo[0]].'" alt="'
                                 .$foo[0].'" title="'.$foo[0].'" '
                                 .$this->emoticons_size.' />';
         }
      }

      $this->emoticons       = $emoticons;
      $this->emoticons_keys  = $emoticon_keys;
      $this->emoticons_files = $emoticon_files;

   } // prepareEmoticons()


   /**
    * Replace emoticons
    *
    * Replaces all emoticons tags with the appropriate image tags.
    *
    * @param string $text The text to work on
    * @return string The text with emoticon tags placed in
    * @see $emoticons
    * @see $emoticons_size
    * @see $emoticons_keys
    * @see $emoticons_files
    * @see prepareEmoticons
    */
   function replaceEmoticons($text) {
      
      return preg_replace($this->emoticons_keys, $this->emoticons_files, $text);
      
   } // replaceEmoticons()


   /**
    * Get recent posts
    *
    * Returns an array of all recent posts, given a certain posts amount.
    *
    * @param int $amount Number of posts to get (defaults to 10).
    * @param int $offset How many posts to skip.
    * @return array Array of {@link Post} instances of all recent posts.
    */
   function getRecentPosts($amount = '%', $offset = 0) {

      // default amount from setting
      if ($amount == '%') { $amount = $this->getSetting('recent_count'); }

      // db query
      $sql = 'SELECT `postid`, `time`, `content`, `comments_count` '
            .'FROM `+posts` '
            .'WHERE 1 '
            .'ORDER BY `postid` DESC '
            .'LIMIT '.($offset+0).','.($amount+0);

      $q = $this->db->query($sql)
         or $this->displayError('site->getRecentPosts',$this->db->error());

      $recent = array();
      
      while ($postdata = $this->db->fetch_assoc($q)) {
         $post = new Post($this);
         $post->fetch_from_array($postdata);

         $recent[] = $post;
      } // while

      return $recent;

   } // getRecentPosts()



   /**
    * Processes POST requests
    *
    * Handles all POST-submitted requests from users.
    * Such as: new comment, and admin form submits.
    *
    * @param array $_post All POST variables.
    * @return void
    */
   function processPost($_post) {

      switch ($_post['action']) {
         case 'post_comment':
         
          if ((!empty($_post['name'])) and (!empty($_post['comment']))) {
      			   // stupid spam workaround
      			   if ($_post['postid']=='283') { $this->displayError('processPost()', 'No such post'); }
      
      			   // useless spam protect
      			   if (strtoupper($_post['secret']) != strtoupper($_post['gocode'])) {
      				   $this->displayError('processPost()',
      					   'SSP [Stupid Spam Protection] - Please enter the secret number correctly');
      			   }

               // handle data
               $_post['name']    = substr($_post['name'],   0, 32);
               $_post['email']   = substr($_post['email'],  0, 32);
               $_post['url']     = substr($_post['url'],    0, 125);
               $_post['comment'] = substr($_post['comment'],0, 20480);

               // empty url
               if ($_post['url'] == 'http://') {
                  $_post['url'] = '';
               }

               // add 'http://' if none
               if (substr($_post['url'],0,7) != 'http://') {
                  $_post['url'] = 'http://'.$_post['url'];
               }

               // post object
               $post = new Post($this, $_post['postid']);
               $post->fetch_from_db();

               // comment object
               $comment = new Comment($post, 0, @$_post['parentid']+0,
                                      $_post['comment'], time(), $_post['name'],
                                      $_post['email'], $_post['url'],
                                      getenv('REMOTE_ADDR'), $_post['postid']);
               $success = $comment->updateDB();

               // update post's comments count
               $post->comments_count++;
               $post->updateDB();

               // inform webmaster upon new comment
               if ($post->getCommentAlert()) {
                  $comment->inform();
               } // if

               if (@$_post['remember']=='on') {
                  $_p = array_map('htmlspecialchars',$_post);
                  setcookie('details','name='.$_p['name']
                           .'&email='.$_p['email']
                           .'&url='.$_p['url'], time()+31536000);
               } else {
                  setcookie('details','');
               } // if

            } // if
            
            if ($post->getAttribute('template')=='n06')
              $this->display = array('post',$_post['postid']);
            else
              $this->display = array('comments',$_post['postid'],0,0);
            break;
         case 'admin':
            $admin = new Admin($this,
                               $_post['area'],
                               $_post['admin'],
                               $_post);
            $this->display = $admin->display();
            break;
      } // switch

   } // processPost()
   
  
  /**
    * Get user details cookie
    * 
    * This function returns the user details stored in a cookie, for the reply
    * form.    
    * 
    *@return array user details from cookie                
    */       
   function detailsCookie() {
      if (isset($this->cookie) and $this->site->cookie)
        return $this->cookie;
        
      else {
        $oreo = split('&', @$_COOKIE['details']);
        foreach ($oreo as $milk) {
           $milk = split('=', $milk);
           $cookie[@$milk[0]] = @$milk[1];
        }
        $this->cookie = $cookie;
        return $cookie;
      }
      
   }


   /**
    * Get link
    *
    * Provides a link to a page in the website.<br />
    * This is used by templates to generate a link to a page in the website.
    * The function decides on the link based on the set {@link $filename}.
    *
    * The function gets an infinite number of parameters and prints them as
    * the link attributes.<br />
    * For example, calling getLink('about','n0nick','the','coolest','dude')
    * will result in:
    * <ul>
    *    <li>for GET mode: index.php?about=n0nick&the=coolest&dude</li>
    *    <li>for path mode: index.php/about/n0nick/the/coolest/dude</li>
    * </ul>
    *
    * @see $filemode
    * @param string $arg, string $arg... Arguments to pass in link.
    * @return void
    */
   function getLink() {
      $args = func_get_args();

      $filename = $this->getSetting('filename');
      $filemode = $this->getSetting('filemode');

      switch ($filemode) {
         case 'get':
            $result = $filename;
            if (count($args)) {
               $result .= '?'.$args[0];
               for ($i=1;$i<count($args);$i++) {
                  if ($i%2==0) {
                     $result .= '&amp;'.$args[$i];
                  } else {
                     $result .= '='.$args[$i];
                  }
               }
            }
            break;
         case 'path':
            $result = join('/',$args);
            if ($filename) {
               $result = $filename.'/'.$result;
            }
            break;
      }
      return $result;
   } // getLink()


   /**
    * Displays page
    *
    * According to the class's {@link $display} variable, this function decides
    * what page should be displayed and calls the appropriate function.
    *
    * @see    $display
    * @return void
    */
   function display() {
      
      switch ($this->display[0]) {
         case 'index':
            $this->displayIndex();
            break;
         case 'post':
            $this->displayPost($this->display[1]);
            break;
         case 'archive':
            $archive = new Archive($this,
                                   $this->display[1][0],
                                   $this->display[1][1]);
            $archive->display();
            break;
         case 'about':
            $this->displayAbout($this->display[1]);
            break;
         case 'comments':
            $this->displayComments($this->display[1],
                                   $this->display[2],
                                   $this->display[3]);
            break;
         case 'rss':
            $this->displayRSS();
            break;
         case 'admin':
            $admin = new Admin($this,
                               $this->display[1],
                               $this->display[2],
                               array($this->display[3],$this->display[4]));
            $admin->display();
            break;
      } // switch

   } // display()

   
   /**
    * Displays index page
    *
    * Displays the website's main page using the correct template.
    * As I see it all I need to pass to the template is the site object.
    * Using it, it can call {@link getRecentPosts} and work from there:
    * processing all posts in a loop and displaying it.
    *
    * @return void
    * @see display()
    */
   function displayIndex() {

      
      $cookie = $this->detailsCookie();
      
      $this->smarty->assign('cookie', $cookie);
      $this->smarty->assign('site',   $this);
      $this->smarty->display('index.tpl');
      return TRUE;

   } // displayIndex()


   /**
    * Displays post page
    *
    * Given the postid, calls the functions to display the post's page.
    *
    * @param int $postid Requested post's id number
    * @return void
    * @see display
    */
   function displayPost($postid) {

      $post = new Post($this);
      $post->fetch_from_db($postid);
      $post->display();

   } // displayPost()


   /**
    * Displays RSS feed
    *
    * Returns to the client the RSS code of the feed, using the smarty
    * RSS template.
    * The feed contains information about the site itself, and of course
    * the 15 most recent posts.
    *
    * @return void
    */
   function displayRSS() {

      $posts = $this->getRecentPosts(15);

      $this->smarty->assign('site',$this);
      $this->smarty->assign('posts',$posts);

      header('Content-Type: text/xml; charset=utf-8');
      $this->smarty->display('rss.tpl');

   } // displayRSS()


   /**
    * Displays comments page
    *
    * Given a post's id, displays the post's comments page, containing all
    * of the post's comments and an option to reply.
    *
    * @param int $postid Post's id number
    * @param string $reply If reply equals to "reply", then the page requested
    *                      is a reply page to a certain comment
    * @param int $commentid If a reply page was requested, this contains the
    *                       parent comment's od.
    * @return void
    * @see display
    */
   function displayComments($postid, $reply, $commentid) {

      $post = new Post($this,$postid);
      $post->displayComments($reply === 'reply', $commentid);

   } // displayComments()


   /**
    * Displays about page
    *
    * Displays a requested about page.
    *
    * @param string $what What about page to display?
    * @return void
    * @see display
    */
   function displayAbout($what) {

      switch($what) {
         case 'site':
            $tmpl  = 'site';
            break;
         case 'me':
            $tmpl  = 'webmaster';
            break;
         case 'link':
            $tmpl  = 'link';
            break;
         case 'outside':
            $tmpl  = 'outside';
            break;
         case 'subscribe':
            $tmpl  = 'subscribe';
            break;
         case 'system':
            $tmpl  = 'system';
            break;
         default:
            $tmpl  = 'index';
            break;
      } // switch

      $this->smarty->assign('site', $this);

      $this->smarty->display('about/'.$tmpl.'.tpl');

   } // displayAbout()

   /**
    * Displays error page
    *
    * Displays an error message page and halts.
    *
    * @param string $func Name of last accessed function.
    * @param string $msg  Error message
    * @return void
    */
   function displayError($func='', $msg='') {
      print '<html><head><title>'.$this->name.':error</title></head><body>';
      print '<p>An error has occured. Gee, I wonder why.</p>';
      if (!empty($func)) {
         print '<p>The error occured while in the function ';
         print '<var style="font-family: monospace; font-weight: bold;">';
         print $func.'</var>.</p>';
      }
      if (!empty($msg)) {
         print '<p>It says:<br />';
         print '<textarea rows="5" cols="40">'.$msg;
         print '</textarea></p>';
      }
      print '<p>Told you it\'s your fault.</p>';
      print '<hr />';
      print '<p>If you have no idea what this is all about, you should ';
      print 'probably <a href="mailto:'.$this->email.'">contact the ';
      print 'webmaster</a>.</p>';
      print '</body></html>';

      // halts the script.
      exit(0);
   } // displayError()

} // Site

/* Simba says Roar! */ ?>
