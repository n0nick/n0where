<?php
/**
 * Index page
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
 * @todo try migrating rpc2.php into the main system.
 */

require_once('inc/include.inc.php');

// create site object
if (stristr(getenv('HTTP_HOST'),'n0where.')) {
   $site = new Site('inc/sagim.ini.php');
}
elseif (stristr(getenv('HTTP_HOST'),'n0nick.')) {
   $site = new Site('inc/dreamhost.ini.php');
} else {
   $site = new Site('inc/local.ini.php');
}


if (!empty($_POST['action'])) { // take POST calls
   $site->processPost($_POST);

} else { // decide what to display

   switch ($site->getSetting('filemode')) {
      case 'path':
         $pathinfo = $_SERVER['REQUEST_URI'];
         $path     = explode ('/',$pathinfo);
         array_shift($path);
         break;
      case 'get':
         $path = array();
         $path[] = '';
         foreach($_GET as $key => $value) {
            $path[] = $key;
            $path[] = $value;
         }
         break;
   }

   // case insensitive
   $path = array_map('strtolower',$path);

   // decisions, decisions
   switch (@$path[1]) {
      case 'anchor':
      case 'post':     // post , postid
         $display = array('post',$path[2]);
         break;
      case 'archive':  // archive , array (month, year)
         $display = array('archive', array(@$path[3],@$path[2]));
         break;
      case 'about':    // about , what
         $display = array('about', @$path[2]);
         break;
      case 'comments': // comments, postid, reply?, reply to what?
         $display = array('comments', $path[2], @$path[3], @$path[4]);
         break;
      case 'rss':      // rdf feed
         $display = array('rss');
         break;
      case 'admin':    // TODO admin
         $display = array('admin', $path[2], @$path[3], @$path[4], @$path[5]);
         break;
      default:         // index
         $display = array('index');
         break;
   }

   $site->display = $display;
}

// display stuff
$site->display();

// say goodbye
$site->db->_Database();

/* Simba says Roar! */ ?>
