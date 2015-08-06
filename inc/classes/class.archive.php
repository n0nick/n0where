<?php
/**
 * Archive class
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
 * Archive class
 *
 * The class handles the weblog's posts archive.<br />
 * Given a year and perhaps a month from the user, it displays the appropriate
 * page so that all posts from that time are accesible.
 *
 * @package n0where
 * @author Sagie Maoz <n0nick@php.net>
 * @copyright Sagie Maoz, 2003
 * @version 1.0
 * @see Site::display
 */
class Archive {

   /**
    * Site
    *
    * Instance of the parent site.
    *
    * @var Site
    */
   var $site;

   /**
    * Month
    *
    * Number of the month in year, that the user asked to display its page.
    *
    * @var int
    */
   var $month     = 0;
   /**
    * Year
    *
    * Year that the user asked to display its page.
    *
    * @var int
    */
   var $year      = 0;

   /**
    * Hebrew months
    *
    * Constant array containing all Hebrew names of months, to display.
    *
    * @var array
    * @access private
    */
   var $hebmonths = 0;


   /**
    * Archive constructor
    *
    * Constructs the archive instance.
    *
    * @param Site $site  Parent site's instance
    * @param int  $month Number of month to display its page
    * @param int  $year  Year to display its page
    * @return void
    */
   function Archive($site,$month=0,$year=0) {

     $this->site  = $site;

     $this->month = $month;
     $this->year  = $year;

     $this->hebmonths = array('','ינואר','פברואר','מרץ','אפריל','מאי','יוני',
                        'יולי','אוגוסט','ספטמבר','אוקטובר','נובמבר','דצמבר');

   } // Archive()


   /**
    * Display archive
    *
    * Displays the archive page.<br />
    * If month was speicified, display the month's page.<br />
    * Otherwise, display the year's page (If no year was specified, we're using
    * the current year).
    *
    * @see displayYear
    * @see displayMonth
    * @return void
    */
   function display() {

      if (empty($this->month)) {
        $this->displayYear();
      } else {
        $this->displayMonth();
      }

   } // display()


   /**
    * Display Year page
    *
    * Displays the year archive page.<br />
    * The year archive page has a list of all the months in the year in which
    * a post was added. Every month is linked to its page.<br />
    * Additionaly, there are links to previous and following year pages.
    *
    * @see display()
    * @return void
    */
   function displayYear() {
      
      if (empty($this->year)) { $this->year = date('Y')+0; }
      
      $this->site->smarty->assign('year', $this->year);
      
      $start   = mktime(0,0,0,01,01,$this->year);
      $end     = mktime(0,0,0,12,32,$this->year);
      
      $sql     = 'SELECT `time` '
                .'FROM `+posts`  '
                .'WHERE 1 '
                .'ORDER BY `time`';
      $q = $this->site->db->query($sql)
         or $this->site->displayError('archive->displayYear() [I]',
                                      $this->site->db->error());

      if ($this->site->db->num_rows($q)>0) {
         $yrs  = array();
         while ($r = mysql_fetch_row($q)) {
            $yr = date('Y',$r[0]);
            array_push($yrs,$yr);
         }
         $years  = array_unique($yrs);
         sort($years);

         $now_pos = array_search($this->year, $years);
         $previous_years = array_slice($years, 0, $now_pos);
         $next_years = array_slice($years, $now_pos+1);            
      } // if

      $this->site->smarty->assign('previous_years', @$previous_years);
      $this->site->smarty->assign('more_years',     @$next_years);
      
      $sql = 'SELECT `time` '
           .'FROM `+posts` '
           .'WHERE `time`>=\''.$start.'\' AND `time`<=\''.$end.'\' '
           .'ORDER BY `time`';

      $q = $this->site->db->query($sql)
         or $this->displayError('archive->displayYear() [II]',
                                $this->site->db->error());

      $mons     = array();
      while ($r = mysql_fetch_row($q)) {
         $month = date('n',$r[0]);
         array_push($mons,$month);
      } unset($r);
      $mons     = array_unique($mons);
      sort($mons);
      
      $this->site->smarty->assign('hebmonths', $this->hebmonths);
      $this->site->smarty->assign('months',    $mons);
      $this->site->smarty->assign('site',      $this->site);
      
      $this->site->smarty->display('archive/year.tpl');

   } // displayYear()


   /**
    * Display Month page
    *
    * Displays the month archive page.<br />
    * The month archive page has a list of all posts added at the particular
    * month, their date and a link to the post page itself.
    *
    * @see display()
    * @return void
    */
   function displayMonth() {

      $this->site->smarty->assign('year',      $this->year);
      $this->site->smarty->assign('month',     $this->month);
      $this->site->smarty->assign('hebmonths', $this->hebmonths);

      $start    = mktime(0,0,0,$this->month,1,$this->year);
      $end      = mktime(0,0,0,$this->month,date('t',$start)+1,$this->year);
      $sql      = 'SELECT `postid`, `time`, `content` '
                .'FROM `+posts` '
                .'WHERE `time`>=\''.$start.'\' AND `time`<=\''.$end.'\' '
                .'ORDER BY `postid`';
      $q = $this->site->db->query($sql)
         or $this->site->displayError('archive->displayMonth()',
                                      $this->site->db->error());

      $links = array();
      while ($r = $this->site->db->fetch_assoc($q)) {
        $post    = new Post($this,$r['postid'],$r['time'],$r['content'],0);
        $links[] = $post;
      } unset($r);

      $this->site->smarty->assign('links', $links);
      $this->site->smarty->assign('site',  $this->site);

      $this->site->smarty->display('archive/month.tpl');

   } // displayMonth()

} // Archive

/* Simba says Roar! */ ?>